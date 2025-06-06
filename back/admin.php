<?php include("auth.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des installations PV</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Ton style perso -->
    <link rel="stylesheet" href="../style/admin.css" />
</head>

<body class="bg-light">
<nav id="navbar">
    <div>
        <img src="../images/logo.png" id="logo" alt="ML Photovoltaic Logo">
        <span>ML Photovoltaic</span>
    </div>

    <button id="burger"><i class="bi bi-list"></i></button>

    <ul id="nav-links" class="d-flex align-items-center gap-3 list-unstyled m-0">
        <li><a href="../front/accueil.html" class="windows">Accueil</a></li>
        <li><a href="../front/recherche.html" class="windows">Recherche</a></li>
        <li><a href="../front/carte.html" class="windows">Carte</a></li>
        <li><a href="" id="mainWindow" title="Espace admin"><i class="bi bi-person-gear fs-5.5"></i></a></li>
        <li>
            <a href="logout.php" class="btn btn-danger btn-sm d-inline-flex align-items-center px-3 py-2 rounded-pill">
                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
            </a>
        </li>
    </ul>
</nav>

<!-- CONTENU PRINCIPAL -->
<main class="container-fluid px-3 px-md-5 mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Liste des installations ajoutées</h2>
        <button id="btn-add" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#installationModal">
            Ajouter une installation
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
            <tbody id="installations-body">
            <!-- Contenu injecté dynamiquement -->
            </tbody>
        </table>
    </div>
</main>

<!-- MODAL -->
<div class="modal fade" id="installationModal" tabindex="-1" aria-labelledby="installationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="installationModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form id="installation-form" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="install-id" />
                    <div class="row g-3">
                        <!-- Toutes les colonnes (voir version précédente pour champs complets) -->
                        <!-- Exemple champ : -->
                        <div class="col-md-6">
                            <label for="installateur-name" class="form-label">Installateur</label>
                            <input type="text" class="form-control" id="installateur-name" required />
                        </div>
                        <!-- Reste des champs à insérer ici -->
                        <!-- ... -->
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

<!-- TOAST -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast-msg" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle menu mobile
    document.getElementById("burger").addEventListener("click", function () {
        document.getElementById("nav-links").classList.toggle("show");
    });
</script>
<script src="../js/ajax.js"></script>
<script src="../js/admin.js"></script>
<script src="../js/delUpt.js"></script>
</body>
</html>
