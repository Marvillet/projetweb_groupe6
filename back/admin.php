<?php include("auth.php"); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des installations PV</title>
    <meta name="author" content="Mathis B / Mathis L / Louis M">
    <link rel="icon" type="image/vnd.icon" href="../images/logo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Style personnalisé -->
    <link rel="stylesheet" href="../style/admin.css" />

    <!-- J query -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand d-flex align-items-center" href="">
        <img src="../images/logo.png" alt="Logo" id="logo" style="height: 40px;" class="me-2">
        <span>ML Photovoltaic</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link" href="../front/accueil.html">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="../front/recherche.html">Recherche</a></li>
            <li class="nav-item"><a class="nav-link" href="../front/carte.html">Carte</a></li>
            <li class="nav-item">
                <a class="nav-link" href="" title="Espace admin" id="admin"><i class="bi bi-person-gear fs-5"></i></a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="btn btn-danger btn-sm px-3 py-2 rounded-pill">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </a>
            </li>
        </ul>
    </div>
</nav>

<main class="container-fluid px-3 px-md-5 mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Liste des dernières installations ajoutées</h2>
        <button id="btn-add" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#installationModal">
            Ajouter des instances
        </button>
    </div>

    <div class="table-responsive shadow-sm rounded bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nb Panneau</th>
                <th>Puissance (kWc)</th>
                <th>Commune</th>
                <th>Date</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody id="resultat">
            <!-- Contenu injecté par JS -->
            </tbody>
        </table>
    </div>
    <br>
    <nav>
        <ul id="pagination" class="pagination justify-content-center"></ul>
    </nav>
</main>

<!-- Modal -->
<div class="modal fade" id="installationModal" tabindex="-1" aria-labelledby="installationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="installationModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form id="installation-form" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="choix" class="form-label">Installateur</label>
                            <select class="form-select form-control" id="choix" required >
                                <option value="" disabled selected>Choisir quelle instance ajouter</option>
                                <option value="1">Installateur</option>
                                <option value="2">Modele de Panneau</option>
                                <option value="3">Marque de Panneau</option>
                                <option value="4">Modele d'Onduleur</option>
                                <option value="5">Marque d'Onduleur</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="denomination" class="form-label">Denomination</label>
                            <input type="text" class="form-control" id="denomination" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast-msg" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/pagination.js"></script>
<script src="../js/ajax.js"></script>
<script src="../js/admin.js"></script>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <div class="container">
        <small>&copy; 2025 ML Photovoltaic. Tous droits réservés.</small><br>
        <small>Louis Marvillet / Mathis Brosseau / Mathis Letellier — Groupe 6 — CIR2</small>
    </div>
</footer>

</body>
</html>
