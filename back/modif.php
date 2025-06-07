<?php include("auth.php"); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modifier une installation PV</title>
    <meta name="author" content="Mathis B / Mathis L / Louis M">
    <link rel="icon" type="image/vnd.icon" href="../images/logo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Style personnalisé -->
    <link rel="stylesheet" href="../style/admin.css" />

    <!-- jQuery + Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    <script src="../js/ajax.js"></script>
    <script src="../js/modification.js" defer></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-form {
            max-width: 1000px;
            margin: auto;
            margin-top: 40px;
            margin-bottom: 40px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 30px;
        }
        label {
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="container container-form">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Modifier une installation</h2>
        <a href="admin.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <form id="installation-form" class="row g-4">
        <!-- Colonne 1 -->
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <label>Mois d'installation :
                        <input type="text" class="form-control" name="mois_installation">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Année d'installation :
                        <input type="number" class="form-control" name="an_installation">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Nombre de panneaux :
                        <input type="number" class="form-control" name="nb_panneaux">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Marque des panneaux :
                        <input type="text" class="form-control" name="marque_panneaux">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Modèle des panneaux :
                        <input type="text" class="form-control" name="modele_panneaux">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Nombre d’onduleurs :
                        <input type="number" class="form-control" name="nb_onduleurs">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Marque onduleur :
                        <input type="text" class="form-control" name="marque_onduleur">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Modèle onduleur :
                        <input type="text" class="form-control" name="modele_onduleur">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Puissance crête (kWc) :
                        <input type="number" step="0.1" class="form-control" name="puissance_crete">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Surface (m²) :
                        <input type="number" step="0.1" class="form-control" name="surface">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Pente (°) :
                        <input type="number" class="form-control" name="pente">
                    </label>
                </li>
            </ul>
        </div>

        <!-- Colonne 2 -->
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <label>Orientation :
                        <input type="number" class="form-control" name="orientation">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Orientation optimale :
                        <input type="number" class="form-control" name="orientation_opt">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Installateur :
                        <input type="text" class="form-control" name="installateur">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Production PVGIS estimée (kWh/an) :
                        <input type="number" class="form-control" name="pvgis">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Latitude :
                        <input type="number" step="0.01" class="form-control" name="latitude">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Longitude :
                        <input type="number" step="0.01" class="form-control" name="longitude">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Pays :
                        <input type="text" class="form-control" name="pays">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Code postal :
                        <input type="text" class="form-control" name="code_postal">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Localité :
                        <input type="text" class="form-control" name="localite">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Région :
                        <input type="text" class="form-control" name="region">
                    </label>
                </li>
                <li class="list-group-item">
                    <label>Département :
                        <input type="text" class="form-control" name="departement">
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
