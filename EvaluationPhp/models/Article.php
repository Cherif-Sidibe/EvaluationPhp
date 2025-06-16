<?php
class Article {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM articles");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO articles 
            (libelle, unite, categorie, seuil_alerte, prix_achat, quantite_stock, description, photo, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['libelle'],
            $data['unite'],
            $data['categorie'],
            $data['seuil_alerte'],
            $data['prix_achat'],
            $data['quantite_stock'],
            $data['description'],
            $data['photo'],
            $data['statut']
        ]);
    }

    public function getPaginated($limit, $offset) {
        $stmt = $this->pdo->prepare("SELECT * FROM articles LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll() {
        return $this->pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    }

}
