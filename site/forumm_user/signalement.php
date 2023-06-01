<?php
include '../config.php';
session_start_custom();

if (isset($_GET['idUtilisateur']) && isset($_GET['idMessage'])) {
    $idUtilisateurSignale = $_GET['idUtilisateur'];
    $idMessage = $_GET['idMessage'];
    $idUtilisateurSignalant = $_SESSION['ID_Utilisateur'];

    $requeteMessage = $pdo->prepare("SELECT Contenu FROM messages WHERE ID_Message = :idMessage");
    $requeteMessage->execute(['idMessage' => $idMessage]);
    $message = $requeteMessage->fetch();

    if ($message) {
        $contenuMessage = $message['Contenu'];

        $requeteSignalement = $pdo->prepare("INSERT INTO signalements (ID_Utilisateur, ID_Utilisateur_Signale, ID_Message, Contenu) VALUES (:idUtilisateurSignalant, :idUtilisateurSignale, :idMessage, :contenu)");
        try {
            $requeteSignalement->execute([
                'idUtilisateurSignalant' => $idUtilisateurSignalant,
                'idUtilisateurSignale' => $idUtilisateurSignale,
                'idMessage' => $idMessage,
                'contenu' => $contenuMessage
            ]);
            echo 'Signalement effectué';
        } catch (PDOException $e) {
            echo 'Erreur avec la requête : ' . $e->getMessage();
        }
    } else {
        echo 'Erreur: message non trouvé';
    }
} else {
    echo 'Erreur: ID Utilisateur ou ID Message non spécifié';
}
?>
