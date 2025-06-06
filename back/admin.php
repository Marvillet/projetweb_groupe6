<?php include("auth.php"); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des installations PV</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-FQybjgWLrvvRgtW6Z199MOMoqwWcCdgbiW7ClFH9vvfZz6jj0WtBvC0YyHn13c7Y" crossorigin="anonymous" />
    <link rel="stylesheet" href="../style/admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap (conserve-le) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (pour <i class="bi ...">) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Notre feuille perso -->
    <link rel="stylesheet" href="../style/installation_gestion.css">
</head>

<body class="bg-light">
<nav id="navbar">
    <div>
        <img src="../images/logo.png" id="logo" alt="ML Photovoltaic Logo">
        <span>ML Photovoltaic</span>
    </div>
    <ul class="d-flex align-items-center gap-3 list-unstyled m-0">
        <li>
            <a href="../front/accueil.html" class="windows">Accueil</a>
        </li>
        <li>
            <a href="../front/recherche.html" class="windows">Recherche</a>
        </li>
        <li>
            <a href="../front/carte.html" class="windows">Carte</a>
        </li>
        <li>
            <a href="" id="mainWindow" title="Espace admin">
                <i class="bi bi-person-gear fs-5.5"></i>
            </a>
        </li>
        <li>
            <a href="logout.php" class="btn btn-danger btn-sm d-inline-flex align-items-center px-3 py-2 rounded-pill">
                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
            </a>
        </li>
    </ul>

</nav>
<br><br>
<main class="container">
    <!-- Bouton pour déclencher la modale d'ajout -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Liste des installations</h2>
        <!-- Le bouton -->
        <button id="btn-add" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#installationModal">
            Ajouter une installation
        </button>
    </div>

    <!-- Tableau des installations -->
    <div class="table-responsive shadow-sm rounded bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Puissance (kWc)</th>
                <th>Commune</th>
                <th>Année</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody id="installations-body">
            <!-- Les lignes sont injectées par JS -->
            </tbody>
        </table>
    </div>
</main>

<!-- Modale Bootstrap pour Ajouter / Modifier -->
<div class="modal fade modal-lg" id="installationModal" tabindex="-1" aria-labelledby="installationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="installationModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form id="installation-form" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="install-id" />
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="install-name" class="form-label">Installateur</label>
                            <input type="text" class="form-control" id="installateur-name" required />
                        </div>
                        <div class="col-md-6">
                            <label for="install-power" class="form-label">Puissance crete</label>
                            <input type="number" step="0.01" class="form-control" id="install-power" required />
                        </div>
                        <div class="col-md-4">
                            <label for="install-year" class="form-label">Annee</label>
                            <input type="number" class="form-control" id="install-year" min="1990" max="2099"
                                   required />
                        </div>
                        <div class="col-md-8">
                            <label for="install-commune" class="form-label">Mois</label>
                            <input type="text" class="form-control" id="install-mois" required />
                        </div>
                        <div class="col-md-8">
                            <label for="install-commune" class="form-label">Commune</label>
                            <input type="text" class="form-control" id="install-commune" required />
                        </div>
                        <div class="col-md-8">
                            <label for="install-postalCode" class="form-label">Code postal</label>
                            <input type="text" class="form-control" id="codePostal" required />
                        </div>
                        <div class="col-md-6">
                            <label for="install-lat" class="form-label">Latitude</label>
                            <input type="number" step="0.000001" class="form-control" id="install-lat" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-lng" class="form-label">Longitude</label>
                            <input type="number" step="0.000001" class="form-control" id="install-lon" />
                        </div>
                        <div class="col-md-8">
                            <label for="install-nbPanneaux" class="form-label">Nombre de panneaux</label>
                            <input type="number" step="1" class="form-control" id="nbPanneaux" required />
                        </div>
                        <div class="col-md-6">
                            <label for="install-marquePanneaux" class="form-label">Marque de panneaux</label>
                            <input type="text" class="form-control" id="install-marquePanneaux" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-modelePanneaux" class="form-label">Modèle des panneaux</label>
                            <input type="text" class="form-control" id="install-modelePanneaux" required/>
                        </div>
                        <div class="col-md-8">
                            <label for="install-nbOnduleur" class="form-label">Nombre d'Onduleur</label>
                            <input type="number" step="1" class="form-control" id="nbOnduleur" required />
                        </div>
                        <div class="col-md-6">
                            <label for="install-marqueOnduleur" class="form-label">Marque d'Onduleur</label>
                            <input type="text" class="form-control" id="install-marqueOnduleur" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-modeleOnduleur" class="form-label">Modèle d'onduleur</label>
                            <input type="text" class="form-control" id="install-modeleOnduleur" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-surface" class="form-label">Surface</label>
                            <input type="number" class="form-control" id="install-surface" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-Pente" class="form-label">Pente</label>
                            <input type="text" class="form-control" id="install-Pente" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-orientation" class="form-label">Orientation</label>
                            <input type="text" class="form-control" id="install-orientation" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="install-orientationOpt" class="form-label">Orientation optimal</label>
                            <input type="text" class="form-control" id="install-orientationOpt" required/>
                        </div>
                        <div class="col-md-8">
                            <label for="install-pvgis" class="form-label">Production PVGIS</label>
                            <input type="number" step="1" class="form-control" id="install-pvgis" required/>
                            <input type="text" class="form-control" id="marquePanneaux" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast de notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast-msg" class="toast align-items-center text-white bg-success border-0" role="alert"
         aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-RCXS5k4Zt9zc3Mn60dqTevWEL25fmfGjkLC5kSBD7Fg8MKRpjlp2O6ejdvo1fwkJ"
        crossorigin="anonymous"></script>

<!-- Script principal -->
<script src="../js/admin.js"></script>
</body>

</html>