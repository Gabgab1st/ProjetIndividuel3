<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="/admin/index.php">Tableau de bord</a></li>
        <li><a href="#">Utilisateurs</a>
        <ul class="submenu">
    <li><a href="/admin/actions/add.php">Ajouter</a></li>
    <li><a href="/admin/actions/edit.php">Modifier</a></li>
    <li><a href="/admin/actions/delete.php">Supprimer</a></li>
</ul>

        </li>
        <!-- Ajoute d'autres liens ici si nécessaire -->
    </ul>
</div>


    <!-- Content Area -->
    <div class="content">
        <h1>Bienvenue dans le Panel Admin</h1>
        <p>Gérez les utilisateurs depuis la sidebar.</p>
    </div>

</body>
</html> 
