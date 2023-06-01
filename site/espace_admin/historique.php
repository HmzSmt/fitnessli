<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['statut_admin']) || $_SESSION['statut_admin'] != 1) {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM newsletters ORDER BY date DESC");
$newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .newsletter {
            background-color: #ffeeba;
            padding: 10px;
            margin-bottom: 10px;
        }
        .premium {
            background-color: #d4edda;
            padding: 10px;
            margin-bottom: 10px;
        }
        .header {
            display: flex;
            align-items: center;
        }
        .title {
            margin-right: 10px;
            font-size: 24px;
        }
        .home-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="title">Historique des Newsletters et Programmes Premium</h2>
            <a href="index.php" class="home-button">Accueil</a>
        </div>

        <h3>Newsletters</h3>
        <?php foreach ($newsletters as $newsletter) { ?>
            <div class="newsletter">
                <p><strong>Date d'envoi :</strong> <?php echo $newsletter['date']; ?></p>
                <p><strong>Email :</strong> <?php echo $newsletter['email']; ?></p>
                <p><strong>Nom :</strong> <?php echo $newsletter['nom']; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
