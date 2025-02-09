<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirection si pas connecté ou pas admin
    exit();
}

require_once '../../config.php';

// Connexion à la base de données
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Si un utilisateur est sélectionné pour modification
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT nom, email FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo "Utilisateur non trouvé.";
        exit;
    }

    $user = $result->fetch_assoc();

    // Mise à jour de l'utilisateur
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = $_POST['nom'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nom, $email, $user_id);

        if ($stmt->execute()) {
            header("Location: edit.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    }
} else {
    // Afficher la liste des utilisateurs si aucun ID n'est spécifié
    $sql = "SELECT id, nom, email FROM utilisateurs";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="../assets/login.css"> 
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="../assets/footer.css">
    <link rel="stylesheet" href="../assets/edit.css">
</head>
<body>

<div class="sidebar">
    <?php include '../includes/sidebar.php'; ?>
</div>

<div class="content">
    <h1>Modifier un utilisateur</h1>

    <?php if (!isset($_GET['id'])): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nom']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><a href="edit.php?id=<?= $row['id'] ?>">Modifier</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <form action="" method="post">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            
            <label for="email">Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            
            <button type="submit">Enregistrer</button>
            <a href="edit.php">Annuler</a>
        </form>
    <?php endif; ?>
</div>
<?php include "../includes/footer.php"; ?>

</body>
</html>

<?php $conn->close(); ?>
