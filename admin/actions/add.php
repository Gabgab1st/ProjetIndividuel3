<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../config.php';

// Connexion à la base de données
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);

    if (!empty($nom) && !empty($email)) {
        // Préparation de la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom, $email);
        
        if ($stmt->execute()) {
            $message = "Utilisateur ajouté avec succès.";
        } else {
            $error = "Erreur lors de l'ajout : " . $stmt->error;
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Utilisateur</title>
    <link rel="stylesheet" href="../assets/add.css"> 
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="../assets/footer.css"></head>
<body>
<div class="container">

    <div class="sidebar">
        <?php include '../includes/sidebar.php'; ?>
    </div>

    <div class="content">
        <h1>Ajouter un Utilisateur</h1>
        
        <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        
        <form method="post">
            <label>Nom :</label>
            <input type="text" name="nom" required>
            
            <label>Email :</label>
            <input type="email" name="email" required>
        
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
</body>
</html>
<?php $conn->close(); ?>
