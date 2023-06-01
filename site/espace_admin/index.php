<?php
require_once '../config.php';
session_start_custom(true, true);
// Initialiser les variables
$isAdmin = false;
$isConnected = false;

// Vérifier si l'utilisateur est connecté et est un administrateur
if (isset($_SESSION['ID_Utilisateur']) && isset($_SESSION['statut_admin'])) {
    $isConnected = true;
    if ($_SESSION['statut_admin'] == 1) {
        $isAdmin = true;
    }
}

// Inclure le fichier de configuration
require_once('./config.php');

try {
    // Récupérer les admins connectés
    $sqlConnected = "SELECT * FROM utilisateurs WHERE statut_admin = 1 AND statut_connexion = 1";
    $stmtConnected = $pdo->query($sqlConnected);
    $connectedAdmins = $stmtConnected->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les admins non connectés
    $sqlNotConnected = "SELECT * FROM utilisateurs WHERE statut_admin = 1 AND statut_connexion = 0";
    $stmtNotConnected = $pdo->query($sqlNotConnected);
    $notConnectedAdmins = $stmtNotConnected->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['ID_Utilisateur'])) {
        $userID = $_SESSION['ID_Utilisateur'];
        $pageVisited = "index.php";
        $action = "Accès à la page admin";

        // Insérer le log dans la base de données
        $sqlLog = "INSERT INTO logs (ID_Utilisateur, Page_Visitée, Action) VALUES (:userID, :pageVisited, :action)";
        $stmtLog = $pdo->prepare($sqlLog);
        $stmtLog->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmtLog->bindParam(':pageVisited', $pageVisited, PDO::PARAM_STR);
        $stmtLog->bindParam(':action', $action, PDO::PARAM_STR);
        $stmtLog->execute();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin_a</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <a href="../recup.php" class="home-button">Accueil</a>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Page d'administration</h1>
        
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admins connectés</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <?php foreach ($connectedAdmins as $admin): ?>
                                <li><?= $admin['Prénom_Utilisateur'] . ' ' . $admin['Nom_Utilisateur'] ?></li>
                                

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admins non connectés</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <?php foreach ($notConnectedAdmins as $admin): ?>
                                <li><?= $admin['Prénom_Utilisateur'] . ' ' . $admin['Nom_Utilisateur'] ?></li>
                                <form class="admin-form" action="remettre_admin.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $admin['ID_Utilisateur'] ?>">
                                    <button class="btn btn-primary" type="submit">Réinitialiser le statut admin</button>
                                </form>


                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="text-center">
                    <a href="utilisateurs.php" class="btn btn-primary">Affichage membres</a>
                    <a href="Article_evenement.php" class="btn btn-primary">Affichage articles et événements</a>
                    <a href="logs_user.php" class="btn btn-primary">Affichage logs user</a>
                    <a href="newsletter/env_newsletter.php" class="btn btn-primary">Newsletter</a>
                    <a href="capcha.php" class="btn btn-primary">Capcha</a>
                    <a href="sauvegarde.php" class="btn btn-primary">Sauvegarde</a>
                    <a href="utilisateurs_bannis.php" class="btn btn-primary">statut_user</a>
                    <a href="./liste_signalements.php" class="btn btn-primary">signalement</a>
                    <a href="./prenium.php" class="btn btn-primary">prenium</a>
                    <a href="signial.php" class="btn btn-primary">publication signialer</a>
                    <a href="./historique.php" class="btn btn-primary">Historique_mail</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sauvegarde réussie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    La sauvegarde de la base de données a été effectuée avec succès.
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                $("#successModal").modal("show");
            <?php } ?>
        });
    </script>
</body>
</html>
   

