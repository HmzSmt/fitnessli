<?php
include '../config.php'; 
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];

// Rechercher un ami
if (isset($_POST['recherche'])) {
    $pseudo_recherche = $_POST['pseudo_recherche'];
    $requete_recherche = $pdo->prepare("SELECT utilisateurs.ID_Utilisateur, pseudos_forum.Pseudo FROM utilisateurs INNER JOIN pseudos_forum ON utilisateurs.ID_Utilisateur = pseudos_forum.ID_Utilisateur WHERE pseudos_forum.Pseudo LIKE :pseudo_recherche AND utilisateurs.ID_Utilisateur != :id_utilisateur");
    $requete_recherche->bindParam(':pseudo_recherche', $pseudo_recherche);
    $requete_recherche->bindParam(':id_utilisateur', $id_utilisateur);
    $requete_recherche->execute();
    $resultat_recherche = $requete_recherche->fetchAll(PDO::FETCH_ASSOC);
}

// Liste des demandes d'amis en attente
$requete_demandes = $pdo->prepare("SELECT relations_amis.*, utilisateurs.*, pseudos_forum.Pseudo FROM relations_amis INNER JOIN utilisateurs ON relations_amis.ID_Utilisateur1 = utilisateurs.ID_Utilisateur INNER JOIN pseudos_forum ON utilisateurs.ID_Utilisateur = pseudos_forum.ID_Utilisateur WHERE relations_amis.ID_Utilisateur2 = :id_utilisateur AND relations_amis.statut_amitie = 'demande_recue'");
$requete_demandes->bindParam(':id_utilisateur', $id_utilisateur);
$requete_demandes->execute();
$liste_demandes = $requete_demandes->fetchAll(PDO::FETCH_ASSOC);


// Liste des amis
$requete_amis = $pdo->prepare("SELECT relations_amis.*, utilisateurs.*, pseudos_forum.Pseudo FROM relations_amis INNER JOIN utilisateurs ON (relations_amis.ID_Utilisateur1 = :id_utilisateur AND relations_amis.ID_Utilisateur2 = utilisateurs.ID_Utilisateur) OR (relations_amis.ID_Utilisateur2 = :id_utilisateur AND relations_amis.ID_Utilisateur1 = utilisateurs.ID_Utilisateur) INNER JOIN pseudos_forum ON utilisateurs.ID_Utilisateur = pseudos_forum.ID_Utilisateur WHERE relations_amis.statut_amitie = 'amis'");
$requete_amis->bindParam(':id_utilisateur', $id_utilisateur);
$requete_amis->execute();
$liste_amis = $requete_amis->fetchAll(PDO::FETCH_ASSOC);

// user co
if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "amis.php";
    $action = "Accès à la page amis";

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
<html lang="fr">
<head>
    <title>Gestion des amis</title>
    <link rel="stylesheet" href="style_amis.css">
</head>
<body>
    <h1>Gestion des amis</h1>

    <!-- Rechercher un ami -->
    <h2>Rechercher un ami</h2>
    <form method="post" action="amis.php">
        <label for="pseudo_recherche">Pseudo :</label>
        <input type="text" name="pseudo_recherche" id="pseudo_recherche" required>
        <input type="submit" name="recherche" value="Rechercher">
    </form>

    <?php if (isset($resultat_recherche)): ?>
        <h3>Résultats de la recherche :</h3>
        <ul>
            <?php foreach ($resultat_recherche as $ami): ?>
                <li>
                    <?= htmlspecialchars($ami['Pseudo']) ?> <a href="ajouter_ami.php?id=<?= $ami['ID_Utilisateur'] ?>">Ajouter</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Liste des amis -->
    <h2>Liste des amis</h2>
    <ul>
        <?php foreach ($liste_amis as $ami): ?>
            <li>
                <?= htmlspecialchars($ami['Pseudo']) ?> <a href="supprimer_ami.php?id=<?= $ami['ID_Utilisateur'] ?>">Supprimer</a> <a href="./private_discussion/discussion.php?id_ami=<?= $ami['ID_Utilisateur'] ?>">Envoyer un message</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Liste des demandes d'amis -->
    <h2>Demandes d'amis en attente</h2>
    <ul>
        <?php foreach ($liste_demandes as $demande): ?>
            <li>
                <?= htmlspecialchars($demande['Pseudo']) ?> 
                <a href="accepter_ami.php?id=<?= $demande['ID_Relation'] ?>">Accepter</a>
                <a href="refuser_ami.php?id=<?= $demande['ID_Relation'] ?>">Refuser</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="accueil.php">Retour à l'accueil</a>
</body>
</html>
