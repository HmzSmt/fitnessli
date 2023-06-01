<?php
include '../config.php';
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_ami = $_GET['id'];

// Supprimer l'ami
$requete_suppression = $pdo->prepare("DELETE FROM relations_amis WHERE (ID_Utilisateur1 = :id_utilisateur AND ID_Utilisateur2 = :id_ami) OR (ID_Utilisateur1 = :id_ami AND ID_Utilisateur2 = :id_utilisateur) AND statut_amitie = 'amis'");
$requete_suppression->bindParam(':id_utilisateur', $id_utilisateur);
$requete_suppression->bindParam(':id_ami', $id_ami);
$requete_suppression->execute();

header("Location: amis.php");
exit;
?>
