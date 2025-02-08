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

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Mise à jour de l'utilisateur avec une requête préparée
        $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour : " . $stmt->error;
        }
    }
} else {
    // Récupérer les données de l'utilisateur pour pré-remplir le formulaire
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
    <title>Editer l'utilisateur</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>    <div class="content">
        <h1>Editer l'utilisateur</h1>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <form action="" method="post">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
            <br>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <br>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
