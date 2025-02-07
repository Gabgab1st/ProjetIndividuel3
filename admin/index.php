<?php
// Vérification si l'utilisateur est connecté (simple vérification pour l'instant)
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
?>
<?php include "../includes/header.php"; ?>
<h1>Tableau de bord Admin</h1>
<p>Bienvenue dans l'administration.</p>
<a href="../logout.php">Déconnexion</a>
<?php include "../includes/footer.php"; ?>
