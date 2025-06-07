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
    <script src="../js/ajax.js"></script>
    <script src="../js/modification.js"></script>
</head>
<body>
<form id="installation-form" class="row g-4">
    <div class="col-md-6">
        <ul class="list-group">
            <li class="list-group-item">
                <label>Mois d'installation :
                    <input type="text" class="form-control" name="mois_installation" value="Septembre">
                </label>
            </li>
            <li class="list-group-item">
                <label>Année d'installation :
                    <input type="number" class="form-control" name="an_installation" value="2007">
                </label>
            </li>
            <li class="list-group-item">
                <label>Nombre de panneaux :
                    <input type="number" class="form-control" name="nb_panneaux" value="14">
                </label>
            </li>
            <li class="list-group-item">
                <label>Marque des panneaux :
                    <input type="text" class="form-control" name="marque_panneaux" value="Sanyo">
                </label>
            </li>
            <li class="list-group-item">
                <label>Modèle des panneaux :
                    <input type="text" class="form-control" name="modele_panneaux" value="HIP-215 NKHE1">
                </label>
            </li>
            <li class="list-group-item">
                <label>Nombre d’onduleurs :
                    <input type="number" class="form-control" name="nb_onduleurs" value="1">
                </label>
            </li>
            <li class="list-group-item">
                <label>Marque onduleur :
                    <input type="text" class="form-control" name="marque_onduleur" value="SMA">
                </label>
            </li>
            <li class="list-group-item">
                <label>Modèle onduleur :
                    <input type="text" class="form-control" name="modele_onduleur" value="Sunny Boy 2800">
                </label>
            </li>
            <li class="list-group-item">
                <label>Puissance crête (kWc) :
                    <input type="number" step="0.1" class="form-control" name="puissance_crete" value="3.1">
                </label>
            </li>
            <li class="list-group-item">
                <label>Surface (m²) :
                    <input type="number" step="0.1" class="form-control" name="surface" value="22">
                </label>
            </li>
            <li class="list-group-item">
                <label>Pente (°) :
                    <input type="number" class="form-control" name="pente" value="20">
                </label>
            </li>
        </ul>
    </div>

    <div class="col-md-6">
        <ul class="list-group">
            <li class="list-group-item">
                <label>Orientation :
                    <input type="number" class="form-control" name="orientation" value="-20">
                </label>
            </li>
            <li class="list-group-item">
                <label>Orientation optimale :
                    <input type="number" class="form-control" name="orientation_opt" value="1">
                </label>
            </li>
            <li class="list-group-item">
                <label>Installateur :
                    <input type="text" class="form-control" name="installateur" value="MECOTECH">
                </label>
            </li>
            <li class="list-group-item">
                <label>Production PVGIS estimée (kWh/an) :
                    <input type="number" class="form-control" name="pvgis" value="3633">
                </label>
            </li>
            <li class="list-group-item">
                <label>Latitude :
                    <input type="number" step="0.01" class="form-control" name="latitude" value="43.51">
                </label>
            </li>
            <li class="list-group-item">
                <label>Longitude :
                    <input type="number" step="0.01" class="form-control" name="longitude" value="1.51">
                </label>
            </li>
            <li class="list-group-item">
                <label>Pays :
                    <input type="text" class="form-control" name="pays" value="France">
                </label>
            </li>
            <li class="list-group-item">
                <label>Code postal :
                    <input type="text" class="form-control" name="code_postal" value="31320">
                </label>
            </li>
            <li class="list-group-item">
                <label>Localité :
                    <input type="text" class="form-control" name="localite" value="Castanet-Tolosan">
                </label>
            </li>
            <li class="list-group-item">
                <label>Région :
                    <input type="text" class="form-control" name="region" value="Occitanie">
                </label>
            </li>
            <li class="list-group-item">
                <label>Département :
                    <input type="text" class="form-control" name="departement" value="Haute-Garonne">
                </label>
            </li>
        </ul>
    </div>

    <div class="col-12 text-end mt-3">
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </div>
</form>
</body>
</html>