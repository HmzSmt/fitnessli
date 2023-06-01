
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/confirm.css">
    <title>Confirmation d'inscription</title>
</head>
<body>
    <h1>Confirmation d'inscription</h1>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Démarrer une session
    session_start();

    // Vérifier si la clé "code_confirmation" existe dans la variable de session
    if (isset($_SESSION['verification_code'])) {
        $code_confirmation_attendu = $_SESSION['verification_code'];
    } else {
        // La clé n'existe pas, rediriger vers la page d'inscription
        header("Location: index.php");
        exit;
    }

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer le code de confirmation entré par l'utilisateur
        $code_confirmation_entre = $_POST['code_confirmation'];

        // Vérifier si le code de confirmation entré par l'utilisateur correspond au code de confirmation attendu
        if ($code_confirmation_entre == $code_confirmation_attendu) {
            // Le code de confirmation est correct, afficher un message de succès
            // Le code de confirmation est correct, rediriger vers la page de connexion
        header("Location: avatar.php");
        exit;

        } else {
            // Le code de confirmation est incorrect, afficher un message d'erreur
            echo "<p>Le code de confirmation est incorrect. Veuillez réessayer.</p>";
        }
    } else {
        // Formulaire non soumis, afficher le formulaire de confirmation
    ?>
        <form action="" method="post">
            <label for="code_confirmation">Code de confirmation :</label>
            <input type="number" id="code_confirmation" name="code_confirmation" required>
            <button type="submit">Confirmer l'inscription</button>
        </form>
    <?php
    }
    ?>

</body>
</html>
