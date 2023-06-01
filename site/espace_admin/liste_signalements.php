<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../config.php';
session_start_custom(true, true);

// Récupérer la liste des utilisateurs signalés
$requete_signalements = $pdo->prepare("SELECT DISTINCT signalements.ID_Utilisateur_Signale, utilisateurs.Nom_Utilisateur, utilisateurs.Prénom_Utilisateur FROM signalements INNER JOIN utilisateurs ON signalements.ID_Utilisateur_Signale = utilisateurs.ID_Utilisateur");
$requete_signalements->execute();
$liste_signalements = $requete_signalements->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des utilisateurs signalés</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

h1 {
    text-align: center;
    margin-top: 20px;
    color: #007bff;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}

table th {
    background-color: #f8f8f8;
    font-weight: bold;
}

table tbody tr:nth-child(even) {
    background-color: #f8f8f8;
}

table tbody tr:hover {
    background-color: #e0e0e0;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}


</style>
<body>
<header>
    <a href="../recup.php">Retour</a>
    </header>
    <h1>Liste des utilisateurs signalés</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liste_signalements as $signalement): ?>
                <tr>
                    <td><?= $signalement['ID_Utilisateur_Signale'] ?></td>
                    <td><?= $signalement['Nom_Utilisateur'] ?></td>
                    <td><?= $signalement['Prénom_Utilisateur'] ?></td>
                    <td><a href="page_messages_signales.php?id=<?= $signalement['ID_Utilisateur_Signale'] ?>">Voir les messages signalés</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
