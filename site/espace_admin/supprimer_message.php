<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../config.php';
session_start_custom(true, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];
        $message = $_POST['message'];


        // Supprimer le message signalé
        $requete_supprimer_message = $pdo->prepare("DELETE FROM signalements WHERE ID_Signalement = :messageId");
        $requete_supprimer_message->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $requete_supprimer_message->execute();


        $requete_supprimer = $pdo->prepare("DELETE FROM messages WHERE ID_Message = :messageId");
        $requete_supprimer->bindParam(':messageId', $message, PDO::PARAM_INT);
        $requete_supprimer->execute();


    

        header('Location: index.php');
        exit();
    }
}
?>
