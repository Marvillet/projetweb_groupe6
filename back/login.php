<?php
session_start();

// Si déjà connecté, on redirige
if (isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit();
}

// Traitement du formulaire
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie les identifiants
    if ($username === "admin" && $password === "isen") {
        $_SESSION['user'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Identifiants invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Connexion à l’espace administrateur</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
<div class="container mt-5">
    <h3>Retour page d'accueil</h3>
    <a href="../front/accueil.html" class="btn btn-info" target="">Retour</a>
</div>
</body>
</html>
