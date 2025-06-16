<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Articles de Confection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Articles de Confection</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutArticleModal">
                <i class="fas fa-plus"></i> Nouvel article
            </button>
        </div>

        <div class="row g-2 mb-3 align-items-center">
            <div class="col-md-4">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Rechercher...">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>

            <div class="col-md-3">
                <select class="form-select">
                    <option>Toutes les catégories</option>
                    <option>Tissus</option>
                    <option>Mercerie</option>
                    <option>Fournitures</option>
                </select>
            </div>

            <div class="col-md-3">
                <select class="form-select">
                    <option>Tous les niveaux de stock</option>
                    <option>En stock</option>
                    <option>Stock faible</option>
                    <option>Rupture</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filtrer
                </button>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-borderless align-middle text-center bg-white">
                <thead class="bg-white fw-bold">
                    <tr>
                        <th>Image</th>
                        <th>Libellé</th>
                        <th>Catégorie</th>
                        <th>Prix d'achat</th>
                        <th>Quantité en stock</th>
                        <th>Valeur en stock</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($article['photo']) ?>" alt="<?= htmlspecialchars($article['libelle']) ?>" width="50"></td>
                                <td><?= htmlspecialchars($article['libelle']) ?></td>
                                <td><?= htmlspecialchars($article['categorie']) ?></td>
                                <td><?= number_format($article['prix_achat'], 0, ',', ' ') ?> FCFA/<?= htmlspecialchars($article['unite']) ?></td>
                                <td><?= htmlspecialchars($article['quantite_stock']) ?> <?= htmlspecialchars($article['unite']) ?></td>
                                <td><?= number_format($article['prix_achat'] * $article['quantite_stock'], 0, ',', ' ') ?> FCFA</td>
                                <td>
                                    <?php if ($article['statut'] === 'En stock'): ?>
                                        <span class="badge bg-success">En stock</span>
                                    <?php elseif ($article['statut'] === 'Stock faible'): ?>
                                        <span class="badge bg-warning text-dark">Stock faible</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rupture</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">Aucun article disponible.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=articles&p=<?= $page - 1 ?>">Précédent</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=articles&p=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=articles&p=<?= $page + 1 ?>">Suivant</a>
                </li>

            </ul>
        </nav>

    </div>

    <div class="modal fade" id="ajoutArticleModal" tabindex="-1" aria-labelledby="ajoutArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="post" enctype="multipart/form-data" action="index.php?page=articles&action=ajouter">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un nouvel article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Libellé</label>
                        <input type="text" name="libelle" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unité de mesure</label>
                        <select class="form-select" name="unite">
                            <option>Sélectionner une unité</option>
                            <option>m</option>
                            <option>unité</option>
                            <option>bobine</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" name="categorie">
                            <option>Sélectionner une catégorie</option>
                            <option>Tissus</option>
                            <option>Mercerie</option>
                            <option>Fournitures</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Seuil d'alerte</label>
                        <input type="number" name="seuil_alerte" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix d'achat</label>
                        <div class="input-group">
                            <input type="number" name="prix_achat" class="form-control">
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quantité initiale en stock</label>
                        <input type="number" name="quantite_stock" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>