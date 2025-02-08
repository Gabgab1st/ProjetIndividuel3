<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}



require_once '../../config.php';

// Connexion à la base de données
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier la présence d'un identifiant utilisateur en GET
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    echo "Aucun utilisateur spécifié.";
    exit;
}

// Traitement de la demande de suppression
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Erreur lors de la suppression : " . $stmt->error;
    }
} else {
    // Récupérer les informations de l'utilisateur pour confirmation
    $stmt = $conn->prepare("SELECT nom, email FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Utilisateur non trouvé.";
        exit;
    }
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer l'utilisateur</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    <div class="content">
        <h1>Supprimer l'utilisateur</h1>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <p>
            Êtes-vous sûr de vouloir supprimer l'utilisateur 
            <strong><?php echo htmlspecialchars($user['nom']); ?></strong> (<?php echo htmlspecialchars($user['email']); ?>) ?
        </p>
        <form action="" method="post">
            <button type="submit" onclick="return confirm('Confirmer la suppression ?');">Supprimer</button>
            <a href="index.php">Annuler</a>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
