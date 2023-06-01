<?php
require_once '../config.php';
session_start_custom(true, true);

// Vérifier si l'ID utilisateur est spécifié
if(isset($_GET['id'])) {
    $userID = $_GET['id'];
    // Préparer la requête SQL
    $updateUser = $pdo->prepare("UPDATE utilisateurs SET statut_admin = 1 WHERE ID_Utilisateur = :userID");
    // Exécuter la requête, en passant l'ID utilisateur
    $updateUser->execute(array(':userID' => $userID));
    header("Location: index.php");
exit();


}
?>
