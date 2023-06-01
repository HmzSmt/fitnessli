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

    // Vérifier si la requête a réussi
    if($updateUser->rowCount() > 0) {
        echo "<p>Le statut de l'utilisateur avec l'ID " . $userID . " a été mis à jour avec succès.</p>";
    } else {
        echo "<p>Échec de la mise à jour du statut de l'utilisateur. Vérifiez que l'utilisateur avec l'ID " . $userID . " existe.</p>";
    }
} else {
    echo "<p>ID utilisateur non spécifié.</p>";
}
?>
