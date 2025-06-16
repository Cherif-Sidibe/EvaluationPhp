<?php
class Article
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data)
    {
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

    public function getPaginated($limit, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    }
    public function search($query, $limit, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE libelle LIKE :query LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSearch($query)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM articles WHERE libelle LIKE :query");
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getFiltered($filters, $limit, $offset)
    {
        $sql = "SELECT * FROM articles WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND libelle LIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['categorie'])) {
            $sql .= " AND categorie = :categorie";
            $params[':categorie'] = $filters['categorie'];
        }

        if (!empty($filters['statut'])) {
            $sql .= " AND statut = :statut";
            $params[':statut'] = $filters['statut'];
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind normal params
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // Bind limit/offset en entier
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function countFiltered($filters)
    {
        $sql = "SELECT COUNT(*) FROM articles WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND libelle LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['categorie'])) {
            $sql .= " AND categorie = ?";
            $params[] = $filters['categorie'];
        }

        if (!empty($filters['statut'])) {
            $sql .= " AND statut = ?";
            $params[] = $filters['statut'];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
