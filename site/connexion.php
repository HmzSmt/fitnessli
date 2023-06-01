<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link href="css/index.css" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <h1>Connexion</h1>

    <form action="connexion_traitement.php" method="POST" autocomplete="off">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas de compte ? <a href="index.php">Inscrivez-vous</a></p>
    <p>Mot de passe oublié ? <a href="mot_de_passe_oublie.php">Cliquez ici</a></p>

</body>
</html>
