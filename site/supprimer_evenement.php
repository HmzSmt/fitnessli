<?php
include 'config.php';
session_start();

    $sql = "DELETE FROM evenements WHERE createur_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['Adresse_Email']]);


header("Location: evenement.php");
exit;
?>
