<!DOCTYPE html>
<html>
<head>
    <title>Réinitialiser le mot de passe</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <h1>Réinitialiser le mot de passe</h1>
    <form action="reinitialiser_mot_de_passe_traitement.php" method="POST" autocomplete="off">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

    <label for="password">Nouveau mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <label for="password_confirm">Confirmer le nouveau mot de passe :</label>
    <input type="password" id="password_confirm" name="password_confirm" required>

    <button type="submit">Réinitialiser le mot de passe</button>
</form>

<p><a href="connexion.php">Retour à la page de connexion</a></p>
</body>
</html>