<?php include("auth.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Flèche retour -->
    <link rel="stylesheet" href="../style/detail.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- J query -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-light p-4">

<div class="container bg-white shadow rounded p-4">

    <!-- Bouton retour -->
    <div class="back">
        <button onclick="window.history.go(-1)" id="retour">
            <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1"
                 viewBox="0 0 1024 1024">
                <path
                    d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
                </path>
            </svg>
            <span>Retour</span>
        </button>
    </div>

    <h2 class="mb-4">Ajouter une installation</h2>

    <form id="installation-form" class="row g-4">
        <!-- Colonne 1 -->
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <label>Mois d'installation :
                        <select class="form-select" id="mois_installation" required >
                            <option value="" disabled selected>Choisissez un mois</option>
                            <option value="1">Janvier</option>
                            <option value="2">Février</option>
                            <option value="3">Mars</option>
                            <option value="4">Avril</option>
                            <option value="5">Mai</option>
                            <option value="6">Juin</option>
                            <option value="7">Juillet</option>
                            <option value="8">Août</option>
                            <option value="9">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Décembre</option>
                        </select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Année d'installation :
                        <input type="number" class="form-control" name="an_installation" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Nombre de panneaux :
                        <input type="number" class="form-control" name="nb_panneaux" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Marque des panneaux :
                        <select class="form-select" id="panneau_marque" required ></select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Modèle des panneaux :
                        <select  class="form-select" id="panneau_modele" required ></select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Nombre d’onduleurs :
                        <input type="number" class="form-control" name="nb_onduleur">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Marque onduleur :
                        <select class="form-select" id="onduleur_marque" required ></select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Modèle onduleur :
                        <select class="form-select" id="onduleur_modele" required ></select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Puissance crête (kWc) :
                        <input type="number" step="0.1" class="form-control" name="puissance_crete" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Surface (m²) :
                        <input type="number" step="0.1" class="form-control" name="surface" required>
                    </label>
                </li>
            </ul>
        </div>

        <!-- Colonne 2 -->
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <label>Orientation :
                        <input type="number" class="form-control" name="orientation" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Orientation optimale :
                        <input type="number" class="form-control" name="orientation_opt" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Installateur :
                        <input type="text" class="form-control" name="id_installateur" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Production PVGIS estimée (kWh/an) :
                        <input type="number" class="form-control" name="puissance_pvgis" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Latitude :
                        <input type="number" step="0.01" class="form-control" name="lat" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Longitude :
                        <input type="number" step="0.01" class="form-control" name="lon" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Localité :
                        <select type="text" class="form-control" id="code_insee" ></select>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Pente (°) :
                        <input type="number" class="form-control" name="pente" required>
                    </label>
                </li>
                <li class="list-group-item">
                    <label>pente optimum (°) :
                        <input type="number" class="form-control" name="pente_optimum" required>
                    </label>
                </li>
            </ul>
        </div>

        <!-- Bouton enregistrer -->
        <div class="col-12 text-end mt-4">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-circle"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
<script src="../js/ajax.js"></script>
<script src="../js/select2.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
