<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification basique (remplace ça par une vraie vérification plus tard)
    if ($username === "admin" && $password === "1234") {
        $_SESSION['admin'] = true;
        header("Location: admin/index.php");
        exit();
    } else {
        $error = "Identifiants incorrects !";
    }
}
?>
<?php include "includes/header.php"; ?>
<h1>Connexion</h1>
<form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<?php include "includes/footer.php"; ?>
