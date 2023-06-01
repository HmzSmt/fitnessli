<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../config.php';

if (isset($_POST['confirm_delete'])) {
    $user_id = $_SESSION['ID_Utilisateur']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session

    // Suppression des signalements associés aux messages de l'utilisateur
    $query_signalements = "DELETE FROM signalements WHERE ID_Message IN (SELECT ID_Message FROM messages WHERE ID_Utilisateur = :user_id)";
    $stmt_signalements = $pdo->prepare($query_signalements);
    $stmt_signalements->execute([':user_id' => $user_id]);

    // Suppression des messages de l'utilisateur
    $query_messages = "DELETE FROM messages WHERE ID_Utilisateur = :user_id";
    $stmt_messages = $pdo->prepare($query_messages);
    $stmt_messages->execute([':user_id' => $user_id]);

    // Suppression des relations d'amitié de l'utilisateur
    $query_relations_amis = "DELETE FROM relations_amis WHERE ID_Utilisateur1 = :user_id OR ID_Utilisateur2 = :user_id";
    $stmt_relations_amis = $pdo->prepare($query_relations_amis);
    $stmt_relations_amis->execute([':user_id' => $user_id]);

    // Suppression des conversations de l'utilisateur
    $query_conversations = "DELETE FROM conversations WHERE ID_Conversation IN (SELECT ID_Conversation FROM messages WHERE ID_Utilisateur = :user_id)";
    $stmt_conversations = $pdo->prepare($query_conversations);
    $stmt_conversations->execute([':user_id' => $user_id]);

    // Suppression des enregistrements de la table "message_private" liés à l'utilisateur
    $query_messages_prives = "DELETE FROM message_private WHERE ID_Utilisateur1 = :user_id OR ID_Utilisateur2 = :user_id";
    $stmt_messages_prives = $pdo->prepare($query_messages_prives);
    $stmt_messages_prives->execute([':user_id' => $user_id]);

    // Suppression des enregistrements de la table "logs" liés à l'utilisateur
    $query_logs = "DELETE FROM logs WHERE ID_Utilisateur = :user_id";
    $stmt_logs = $pdo->prepare($query_logs);
    $stmt_logs->execute([':user_id' => $user_id]);

    // Suppression du compte de l'utilisateur
    $query_user = "DELETE FROM utilisateurs WHERE ID_Utilisateur = :user_id";
    $stmt_user = $pdo->prepare($query_user);
    $stmt_user->execute([':user_id' => $user_id]);

    // Détruire la session et rediriger vers la page d'accueil ou de connexion
    session_destroy();
    header("Location: ../index.php");
    exit;
    }
?>
