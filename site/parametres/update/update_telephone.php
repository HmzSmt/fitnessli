<?php
session_start();
// Inclure le fichier de configuration de la base de données
require_once '../../config.php';

// Obtenir l'objet PDO
$pdo = connectDB();

// Vérifier si le formulaire a été soumis
if (isset($_POST['telephone'])) {
    // Mettre à jour le numéro de téléphone de l'utilisateur
    $telephone = $_POST['telephone'];
    // Utiliser l'ID utilisateur approprié, vous pouvez récupérer cet ID en fonction de l'utilisateur connecté
    $id_utilisateur = 1;
    $query = "UPDATE utilisateurs SET Numero_de_telephone=? WHERE ID_Utilisateur=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$telephone, $id_utilisateur]);
    $message = "Le numéro de téléphone a été mis à jour.";
}

?>
