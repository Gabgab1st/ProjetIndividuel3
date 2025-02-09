<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirection si pas connecté ou pas admin
    exit();
}


require_once '../config.php';

// Création de la connexion avec MySQLi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête SQL pour récupérer les utilisateurs
$sql = "SELECT id, nom, email FROM utilisateurs";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Index</title>
    <link rel="stylesheet" href="assets/index.css"> 
    <link rel="stylesheet" href="assets/sidebar.css">
    <link rel="stylesheet" href="assets/footer.css">    
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>

        <!-- Main content -->
        <div class="content">
            <h1>Liste des utilisateurs</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Vérifier s'il y a des résultats
                    if ($result->num_rows > 0) {
                        // Afficher chaque ligne du tableau
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['nom']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            </tr>";
                        }
                    } else {
                        // Aucun utilisateur trouvé
                        echo "<tr><td colspan='3'>Aucun utilisateur trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
</body>

</html>
<?php
// Fermer la connexion
$conn->close();
?>
