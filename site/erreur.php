<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Erreur</title>
</head>
<body>
    <h1>Erreur</h1>
    <p><?php echo htmlspecialchars($_GET['msg']) ?></p>
    <a href="index.php">Retour à la page d'accueil</a>
</body>
</html>