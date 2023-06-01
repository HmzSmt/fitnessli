<?php
require_once '../../config.php';
session_start_custom(); 

$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_ami = $_GET['id_ami'];

$requete_messages = $pdo->prepare("SELECT * FROM message_private WHERE (ID_Utilisateur1 = :id_utilisateur AND ID_Utilisateur2 = :id_ami) OR (ID_Utilisateur1 = :id_ami AND ID_Utilisateur2 = :id_utilisateur) ORDER BY date_envoi ASC");
$requete_messages->bindParam(':id_utilisateur', $id_utilisateur);
$requete_messages->bindParam(':id_ami', $id_ami);
$requete_messages->execute();
$messages = $requete_messages->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    if ($message['ID_Utilisateur1'] == $id_utilisateur) {
        echo "Moi : ";
    } else {
        echo "Ami : ";
    }
    echo htmlspecialchars($message['contenu']) . "<br>";
}
