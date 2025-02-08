<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Utilisateur</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="sidebar">
            <?php include '../includes/sidebar.php'; ?>
        </div>
    <div class="content">
        <h1>Ajouter un Utilisateur</h1>
        <!-- Formulaire pour ajouter un utilisateur -->
        <form method="post" action="process_add.php">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <br>
            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>
</html>
