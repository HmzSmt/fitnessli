<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../config.php';
session_start_custom(true, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message_id'])) {
        $messageId = $_POST['message_id'];

        // Supprimer le message signalé
        $requete_supprimer_message = $pdo->prepare("DELETE FROM signalements WHERE ID_Signalement = :messageId");
        $requete_supprimer_message->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $requete_supprimer_message->execute();

        // Vérifier les erreurs SQL
        var_dump($requete_supprimer_message->errorInfo());

        header('Location: index.php');
        exit();
    }
}
?>
