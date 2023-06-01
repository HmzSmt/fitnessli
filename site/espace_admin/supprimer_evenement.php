<?php
require_once '../config.php';
session_start_custom(true, true);

// Vérifier si l'ID de l'événement est fourni
if (isset($_GET['id'])) {
    // Connexion à la base de données
    include 'bdd.php';
    $pdo = connectDB();

    // Récupérer l'ID de l'événement
    $id = $_GET['id'];

    // Supprimer l'événement de la base de données
    $sql = "DELETE FROM evenements WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // Rediriger vers la page des événements
    header('Location: Article_evenement.php');
    exit();
} else {
    // Rediriger vers la page des événements si l'ID n'est pas fourni
    header('Location: Article_evenement.php');
    exit();
}
?>