<?php
include '../config.php'; 
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];

$requete_messages = $pdo->prepare("SELECT messages.ID_Message, messages.Contenu, messages.date_envoi, pseudos_forum.Pseudo, messages.ID_Utilisateur FROM messages INNER JOIN pseudos_forum ON messages.ID_Utilisateur = pseudos_forum.ID_Utilisateur ORDER BY date_envoi DESC");
$requete_messages->execute();
$messages = $requete_messages->fetchAll(PDO::FETCH_ASSOC);

$messages = array_reverse($messages);

if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "accueil.php";
    $action = "Accès à la page principal forum";

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
    <title>Accueil</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <h1>Accueil</h1>

    <a href="amis.php">Gérer les amis</a>
    <a href="../recup.php">Accueil</a>

    <h2>Messages</h2>
    <div id="messages">
        <?php foreach ($messages as $message): ?>
            <p>
                <strong><?= htmlspecialchars($message['Pseudo']) ?>:</strong> <?= htmlspecialchars($message['Contenu']) ?> (<?= $message['date_envoi'] ?>)
                <button onclick="signalerUtilisateur(<?= $message['ID_Utilisateur'] ?>, <?= $message['ID_Message'] ?>)">Signaler</button>
            </p>
        <?php endforeach; ?>
    </div>

    <h2>Poster un message</h2>
    <form method="post" action="poster_message.php">
        <input type="text" name="contenu" id="contenu" required>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
<script>
    var messages = document.getElementById('messages');
    messages.scrollTop = messages.scrollHeight;

    function signalerUtilisateur(idUtilisateur, idMessage) {
        fetch('signalement.php?idUtilisateur=' + idUtilisateur + '&idMessage=' + idMessage)
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>
