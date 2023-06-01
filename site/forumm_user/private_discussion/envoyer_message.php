<?php
include '../../config.php'; 
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_ami = $_POST['id_ami'];
$message = $_POST['message'];

$requete_envoi = $pdo->prepare("INSERT INTO message_private (ID_Utilisateur1, ID_Utilisateur2, contenu, date_envoi) VALUES (:id_utilisateur, :id_ami, :message, NOW())");
$requete_envoi->bindParam(':id_utilisateur', $id_utilisateur);
$requete_envoi->bindParam(':id_ami', $id_ami);
$requete_envoi->bindParam(':message', $message);
$requete_envoi->execute();
