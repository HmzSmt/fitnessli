<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';
session_start();

function est_token_valide($token, $pdo) {
    $sql = "SELECT ID_Utilisateur, password_reset_expires FROM utilisateurs WHERE password_reset_token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);
    $result = $stmt->fetch();
    
    if ($result) {
        $expiration = new DateTime($result['password_reset_expires']);
        $now = new DateTime();
        return $now < $expiration;
    } else {
        return false;
    }
}

function reinitialiser_mot_de_passe($token, $password, $pdo) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE utilisateurs SET mot_de_passe_user = ?, password_reset_token = NULL, password_reset_expires = NULL WHERE password_reset_token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$hashedPassword, $token]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

    if ($token === '' || !est_token_valide($token, $pdo)) {
        header("Location: reinitialiser_mot_de_passe.php?token=" . urlencode($token) . "&erreur=2");
        exit();
    }

    if ($password === '' || $password_confirm === '') {
        header("Location: reinitialiser_mot_de_passe.php?token=" . urlencode($token) . "&erreur=3");
        exit();
    }

    if ($password !== $password_confirm) {
        header("Location: reinitialiser_mot_de_passe.php?token=" . urlencode($token) . "&erreur=1");
        exit();
    }

    reinitialiser_mot_de_passe($token, $password, $pdo);

    // Redirigez vers la page de connexion ou vers une page de succès après la réinitialisation du mot de passe.
    header("Location: connexion.php?reinitialisation_succes=1");
    exit();
} else {
    header("Location: reinitialiser_mot_de_passe.php");
    exit();
}
