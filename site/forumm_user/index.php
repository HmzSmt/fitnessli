<?php
include '../config.php'; 
session_start_custom();

// Récupérez l'ID de l'utilisateur connecté
$id_utilisateur = $_SESSION['ID_Utilisateur'];

// Vérifier si l'utilisateur a déjà un pseudo dans la table pseudos_forum
$requete = $pdo->prepare('SELECT Pseudo FROM pseudos_forum WHERE ID_Utilisateur = :id_utilisateur');
$requete->bindParam(':id_utilisateur', $id_utilisateur);
$requete->execute();
$resultat = $requete->fetch(PDO::FETCH_ASSOC);

if ($resultat !== false && $resultat['Pseudo'] !== null && $resultat['Pseudo'] !== '') {
    // Si l'utilisateur a déjà un pseudo, redirigez vers une autre page (par exemple, la page d'accueil)
    header('Location: accueil.php');
    exit;
}

// Vérifier si le pseudo a été soumis dans le formulaire
if (isset($_POST['pseudo'])) {
    $pseudo = $_POST['pseudo'];

    // Vérifier si le pseudo est déjà pris
    $requete = $pdo->prepare('SELECT COUNT(*) AS total FROM pseudos_forum WHERE Pseudo = :pseudo');
    $requete->bindParam(':pseudo', $pseudo);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    if ($resultat['total'] > 0) {
        // Le pseudo est déjà pris, afficher un message d'erreur et rediriger vers la page de choix du pseudo
        $_SESSION['message'] = 'Ce pseudo est déjà pris. Veuillez en choisir un autre.';
        header('Location: index.php');
        exit;
    }

    // Enregistrer le pseudo dans la table pseudos_forum
    $requete = $pdo->prepare('INSERT INTO pseudos_forum (ID_Utilisateur, Pseudo) VALUES (:id_utilisateur, :pseudo)');
    $requete->bindParam(':id_utilisateur', $id_utilisateur);
    $requete->bindParam(':pseudo', $pseudo);
    $requete->execute();

    // Rediriger vers une autre page (par exemple, la page d'accueil du forum)
    header('Location: accueil.php');
    exit;
}
if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "index.php";
    $action = "Accès à la page configuration pseudo";

    // Insérer le log dans la base de données
    $sql = "INSERT INTO logs (ID_Utilisateur, Page_Visitée, Action) VALUES (:userID, :pageVisited, :action)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':pageVisited', $pageVisited, PDO::PARAM_STR);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page de discussion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalPseudo = document.getElementById('modalPseudo');

            // Afficher la fenêtre modale si l'utilisateur n'a pas de pseudo
            <?php if (!isset($_SESSION['Pseudo'])): ?>
            modalPseudo.style.display = 'block';
            <?php endif; ?>

            // Valider le formulaire de choix de pseudo
            document.getElementById('submitPseudo').addEventListener('click', function (event) {
                event.preventDefault();
                var pseudo = document.getElementById('pseudo').value;
                if (pseudo.trim() === '') {
                    alert('Veuillez entrer un pseudo.');
                } else {
                    document.querySelector('form[action="index.php"]').submit();
                }
            });
        });
    </script>
</head>
<body>
    <div id="container">
        <h1>Page de discussion</h1>
        <!-- Fenêtre modale pour le choix du pseudo -->
        <div id="modalPseudo" class="modal" style="display:none;">
            <div class="modal-content">
                <form action="index.php" method="post">
                    <label for="pseudo">Choisissez un pseudo :</label>
                    <input type="text" id="pseudo" name="pseudo" required>
                    <button type="submit" id="submitPseudo">Valider</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

