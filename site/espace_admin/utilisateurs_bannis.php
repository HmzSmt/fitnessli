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
    // Récupérer les utilisateurs bannis
    $sqlBanned = "SELECT * FROM utilisateurs WHERE statut_bannissement = '1'";
    $stmtBanned = $pdo->query($sqlBanned);
    $bannedUsers = $stmtBanned->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les informations de bannissement pour chaque utilisateur banni
    foreach ($bannedUsers as $index => $user) {
        $sqlBannedIP = "SELECT * FROM ip_bannies WHERE adresse_ip = :ip";
        $stmtBannedIP = $pdo->prepare($sqlBannedIP);
        $stmtBannedIP->bindParam(':ip', $user['adresse_ip'], PDO::PARAM_STR);
        $stmtBannedIP->execute();
        $bannedIP = $stmtBannedIP->fetch(PDO::FETCH_ASSOC);

        if ($bannedIP) {
            $bannedUsers[$index]['date_fin_ban'] = $bannedIP['date_fin_ban'];
            $bannedUsers[$index]['permanent'] = $bannedIP['permanent'];
        } else {
            $bannedUsers[$index]['date_fin_ban'] = null;
            $bannedUsers[$index]['permanent'] = false;
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Utilisateurs bannis</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1 class="text-center">Utilisateurs bannis</h1>
        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Adresse Email</th>
                            <th scope="col">Date de fin de bannissement</th>
                            <th scope="col">Bannissement permanent</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($bannedUsers as $user): ?>
                        <tr>
                            <td><?= $user['ID_Utilisateur'] ?></td>
                            <td><?= $user['Nom_Utilisateur'] ?></td>
                            <td><?= $user['Prénom_Utilisateur'] ?></td>
                            <td><?= $user['Adresse_Email'] ?></td>
                            <td><?= isset($user['date_fin_ban']) ? $user['date_fin_ban'] : 'N/A' ?></td>
                            <td><?= isset($user['permanent']) && $user['permanent'] ? 'Oui' : 'Non' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary">Retour à la page d'administration</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

