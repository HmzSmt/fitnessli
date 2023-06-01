<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Vérifier si le code de réinitialisation et l'e-mail sont présents dans la session
if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_email'])) {
    // Code de réinitialisation et/ou e-mail non présents, rediriger vers la page de réinitialisation du mot de passe
    header("Location: mot_de_passe_oublie.php");
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer le code entré par l'utilisateur
    $code = $_POST['code'];

    // Vérifier si le code entré par l'utilisateur correspond au code de réinitialisation dans la session
    if ($code == $_SESSION['reset_code']) {
        // Codes correspondent, rediriger vers la page de réinitialisation du mot de passe
        header("Location: reinitialiser_mot_de_passe.php?email=" . $_SESSION['reset_email']);
        exit;
    } else {
        // Codes ne correspondent pas, afficher un message d'erreur
        $erreur = "Le code entré est incorrect.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rentrer le code de réinitialisation</title>
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <h1>Rentrer le code de réinitialisation</h1>

    <form action="" method="POST" autocomplete="off">
        <p>Un e-mail a été envoyé à l'adresse <?php echo $_SESSION['reset_email']; ?> avec un code de réinitialisation à 6 chiffres. Veuillez entrer le code ci-dessous pour continuer :</p>

        <label for="code">Code :</label>
        <input type="text" id="code" name="code" required>

        <?php if (isset($erreur)) { ?>
            <p class="erreur"><?php echo $erreur; ?></p>
        <?php } ?>

        <button type="submit">Continuer</button>
    </form>
</body>
</html>
