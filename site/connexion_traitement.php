<?php
session_start();

if (isset($_SESSION['ID_Utilisateur'])) {
    header('Location: recup.php');
    exit;
}

require_once './config.php';

function isIpAddressBanned($adresse_ip, $pdo) {
    $sql = "SELECT COUNT(*) as nb FROM ip_bannies WHERE adresse_ip = ? AND (permanent = 1 OR date_fin_ban > ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$adresse_ip, time()]);

    $result = $stmt->fetch();
    return $result['nb'] > 0;
}

$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    header('location: ../connexion.php?message=Adresse e-mail invalide');
    exit;
}
$password = $_POST['password'];

$q = "SELECT * FROM utilisateurs WHERE Adresse_Email= ?";
$req = $pdo->prepare($q);
$req->execute([$email]);
$user = $req->fetch(PDO::FETCH_ASSOC);

if ($user !== false && password_verify($password, $user['mot_de_passe_user'])) {
    // Vérifier si l'utilisateur est banni
    $adresse_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    if ($user['statut_bannissement'] == 1 || isIpAddressBanned($adresse_ip, $pdo)) {
        header('Location: connexion.php?msg=Utilisateur banni');
        exit;
    }

    $_SESSION['ID_Utilisateur'] = $user['ID_Utilisateur'];
    $_SESSION['Nom_Utilisateur'] = $user['Nom_Utilisateur'];
    $_SESSION['Prénom_Utilisateur'] = $user['Prénom_Utilisateur'];
    $_SESSION['Adresse_Email'] = $user['Adresse_Email'];
    $_SESSION['statut_prenium'] = $user['statut_prenium'];
    $_SESSION['statut_admin'] = $user['statut_admin'];
    $_SESSION['last_login'] = $user['last_login'];
    $_SESSION['avatar'] = $user['avatar'];

    // Mettre à jour l'adresse IP de l'utilisateur
    $updateIP = $pdo->prepare('UPDATE utilisateurs SET adresse_ip = ? WHERE ID_Utilisateur = ?');
    $updateIP->execute(array($adresse_ip, $user['ID_Utilisateur']));

    header('location: captcha.html');
    exit;
} else {
    header('Location: connexion.php?msg=Problème d\'authentification');
    exit;
}
?>
