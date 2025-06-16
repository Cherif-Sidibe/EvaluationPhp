<?php
require_once __DIR__ . '/../models/Article.php';

class ArticleController {
    private $model;

    public function __construct($pdo) {
        $this->model = new Article($pdo);
    }

    
    public function store() {
        $data = $_POST;
        $data['photo'] = '';
        $this->model->create($data);
        header('Location: index.php?page=articles');
    }

    public function ajouter() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $libelle = $_POST['libelle'];
        $unite = $_POST['unite'];
        $categorie = $_POST['categorie'];
        $seuil = $_POST['seuil_alerte'];
        $prix = $_POST['prix_achat'];
        $quantite = $_POST['quantite_stock'];
        $description = $_POST['description'];

        $photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $nomFichier = time() . '_' . basename($_FILES['photo']['name']);
            $chemin = 'images/' . $nomFichier;
            move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
            $photo = $chemin;
        }

        if ($quantite <= 0) {
            $statut = 'Rupture';
        } elseif ($quantite <= $seuil) {
            $statut = 'Stock faible';
        } else {
            $statut = 'En stock';
        }

        $this->model->create([
            'libelle' => $libelle,
            'unite' => $unite,
            'categorie' => $categorie,
            'seuil_alerte' => $seuil,
            'prix_achat' => $prix,
            'quantite_stock' => $quantite,
            'description' => $description,
            'photo' => $photo,
            'statut' => $statut
        ]);

        header('Location: index.php?page=articles');
        exit;
    }
}
    public function index() {
        $limit = 5; 
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $limit;

        $articles = $this->model->getPaginated($limit, $offset);
        $total = $this->model->countAll();
        $totalPages = ceil($total / $limit);

        require_once 'views/Articles.php';
}


}
