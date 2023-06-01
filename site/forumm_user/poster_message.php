<?php
require_once '../config.php';
session_start_custom();


// Vérifier si la conversation générale existe
$id_conversation_generale = 1000;
$requete_conversation = $pdo->prepare("SELECT * FROM conversations WHERE ID_Conversation = :id_conversation");
$requete_conversation->bindParam(':id_conversation', $id_conversation_generale);
$requete_conversation->execute();
$conversation = $requete_conversation->fetch(PDO::FETCH_ASSOC);

// Si la conversation générale n'existe pas, l'insérer dans la base de données
if (!$conversation) {
    $requete_insert_conversation = $pdo->prepare("INSERT INTO conversations (ID_Conversation, nom_conversation) VALUES (:id_conversation, 'Général')");
    $requete_insert_conversation->bindParam(':id_conversation', $id_conversation_generale);
    $requete_insert_conversation->execute();
}

$id_utilisateur = $_SESSION['ID_Utilisateur'];

if (isset($_POST['contenu'])) {
    $contenu = trim($_POST['contenu']);

    if (!empty($contenu)) {
        // Insérer le message dans la base de données
        $requete = $pdo->prepare("INSERT INTO messages (ID_Conversation, ID_Utilisateur, Contenu) VALUES (:id_conversation, :id_utilisateur, :contenu)");
        $requete->bindParam(':id_conversation', $id_conversation_generale);
        $requete->bindParam(':id_utilisateur', $id_utilisateur);
        $requete->bindParam(':contenu', $contenu);
        $requete->execute();
    }
}

// Rediriger vers la page d'accueil
header('Location: accueil.php');
exit;
?>
