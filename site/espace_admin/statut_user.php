<?php
require_once '../config.php';
session_start_custom(true, true);

if (!isset($_SESSION['password'])) {
    header('Location: connexion.php');
}

if (!isset($_SESSION['statut_admin']) || $_SESSION['statut_admin'] != 1) {
    header('Location: ../connexion.php?msg=Accès non autorisé');
    exit;
}

if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
    $recupUsers = $pdo->prepare('SELECT * FROM utilisateurs WHERE (Nom_Utilisateur LIKE :recherche OR Prénom_Utilisateur LIKE :recherche OR Adresse_Email LIKE :recherche) AND (statut_bannissement = "banni_temporaire" OR statut_bannissement = "banni_definitif")');
    $recupUsers->execute(array(':recherche' => '%' . $recherche . '%'));
} else {
    $recupUsers = $pdo->query('SELECT * FROM utilisateurs WHERE statut_bannissement = "banni_temporaire" OR statut_bannissement = "banni_definitif"');
}

$users = $recupUsers->fetchAll();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "statut_user.php";
    $action = "Accès à la page statut_user";

    // Insérer le log dans la base de données
    $sql = "INSERT INTO logs (ID_Utilisateur, Page_Visitée, Action) VALUES (:userID, :pageVisited, :action)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':pageVisited', $pageVisited, PDO::PARAM_STR);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statut des utilisateurs</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/utilisateurs.css">
</head>
<body>

<header>
    <a href="index.php" id="acceuil">Accueil</a>
</header>

<div id="liste_utilisateurs">
    <?php foreach ($users as $user) : ?>
        <?php
            $statut_bannissement = $user['statut_bannissement'];
            $temps_restant = "";

            if ($statut_bannissement == "banni_temporaire") {
                $date_fin_ban = $user['date_fin_ban'];
                $date_actuelle = date('Y-m-d H:i:s');
                $temps_restant = strtotime($date_fin_ban) - strtotime($date_actuelle);
                $temps_restant = max(0, $temps_restant);

                $jours = floor($temps_restant / (60 * 60 * 24));
                $heures = floor(($temps_restant % (60 * 60 * 24)) / (60 * 60));
                $minutes = floor(($temps_restant % (60 * 60)) / 60);
                $secondes = $temps_restant % 60;

                $temps_restant = sprintf("%02d jours %02d:%02d:%02d", $jours, $heures, $minutes, $secondes);
            }
        ?>
        <p>ID: <?= $user['ID_Utilisateur'] ?> | Nom: <?= $user['Nom_Utilisateur'] ?> | Prénom: <?= $user['Prénom_Utilisateur'] ?> | Email: <?= $user['Adresse_Email'] ?> | Statut bannissement: <?= $statut_bannissement ?> | Temps restant: <?= $temps_restant ?></p>
    <?php endforeach; ?>
</div>

</body>
</html>

