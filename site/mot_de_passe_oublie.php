<?php
// Démarrer une session
session_start();

// Générer un code aléatoire à 4 chiffres pour la réinitialisation du mot de passe
$code = rand(1000, 9999);
$_SESSION['reset_code'] = $code;
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>Erreur : " . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mot de passe oublié</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <h1>Réinitialiser le mot de passe</h1>

    <form action="mot_de_passe_oublie_traitement.php" method="POST" autocomplete="off">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <button type="submit" name="submit_email">Envoyer le lien de réinitialisation</button>
    </form>

    <p><a href="connexion.php">Retour à la page de connexion</a></p>
</body>
</html>
