<?php
session_start();
require_once '../../config.php';

if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['ID_Utilisateur']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session

    // Vérification du mot de passe actuel
    $query = "SELECT * FROM utilisateurs WHERE ID_Utilisateur = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($current_password, $user['mot_de_passe_user'])) {
        // Vérification que les deux champs du nouveau mot de passe correspondent
        if ($new_password === $confirm_password) {
            // Mise à jour du mot de passe
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE utilisateurs SET mot_de_passe_user = :password WHERE ID_Utilisateur = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':password' => $hashed_password, ':id' => $user_id]);

            echo "Votre mot de passe a été mis à jour.";
        } else {
            echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
        }
    } else {
        echo "Le mot de passe actuel est incorrect.";
    }
}
?>
