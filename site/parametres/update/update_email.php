<?php
session_start();
require_once '../../config.php';

if (isset($_POST['email'])) {
    $new_email = $_POST['email'];
    $user_id = $_SESSION['ID_Utilisateur']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session

    // Vérification si l'email existe déjà
    $query = "SELECT * FROM utilisateurs WHERE Adresse_Email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':email' => $new_email]);
    $existing_email = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_email) {
        echo "L'email existe déjà, veuillez en choisir un autre.";
    } else {
        $query = "UPDATE utilisateurs SET Adresse_Email = :email WHERE ID_Utilisateur = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':email' => $new_email, ':id' => $user_id]);

        echo "Votre adresse email a été mise à jour.";
    }
}
?>
