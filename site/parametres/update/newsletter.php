<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Vérifier si le formulaire a été soumis et tous les champs requis sont présents
if (isset($_POST['email'], $_POST['nom'], $_POST['action'])) {
    // Connexion à la base de données
    require_once '../../config.php';
    
    // Vérifier si l'utilisateur est déjà inscrit à la newsletter
    $email = $_POST['email'];
    $count = isSubscribedToNewsletter($email, $pdo);
    $message = "";
    
    if ($_POST['action'] == 'subscribe') {
        // S'inscrire à la newsletter
        if ($count == 0) {
            subscribeToNewsletter($email, $_POST['nom'], $pdo);
            $message = "Vous êtes maintenant inscrit à la newsletter.";
        } else {
            $message = "Vous êtes déjà inscrit à la newsletter.";
        }
    } else if ($_POST['action'] == 'unsubscribe') {
        // Se désinscrire de la newsletter
        if ($count > 0) {
            unsubscribeFromNewsletter($email, $pdo);
            $message = "Vous avez été désinscrit de la newsletter.";
        } else {
            $message = "Vous n'êtes pas inscrit à la newsletter.";
        }
    } else {
        $message = "Action non valide.";
    }

    // Rediriger vers la page précédente avec un message
    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?message=" . urlencode($message));
    } else {
        echo $message;
    }
    
    exit();
}

?>
