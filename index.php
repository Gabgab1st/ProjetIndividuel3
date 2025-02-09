<?php
// Inclure le header et footer
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="assets/css/header.css">  <!-- Pour le header -->
    <link rel="stylesheet" href="assets/css/index.css">   <!-- Pour la page principale -->
    <link rel="stylesheet" href="assets/css/footer.css">   <!-- Pour le footer -->
</head>
<body>

    <div class="container">
        <h1>Bienvenue sur la page d'accueil</h1>
        <p>Voici un tableau contenant la liste des utilisateurs</p>
<div class="tablecontainer">
        <?php
        require_once 'config.php'; // Inclure la configuration pour la base de données

        // Connexion à la base de données
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Requête SQL pour récupérer les utilisateurs
        $sql = "SELECT id, nom, email FROM utilisateurs";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<div class='table-container'>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>";
            // Afficher chaque ligne du tableau
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['nom']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>
                </div>";
        } else {
            echo "<p class='no-users'>Aucun utilisateur trouvé.</p>";
        }

        // Fermer la connexion
        $conn->close();
        ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
