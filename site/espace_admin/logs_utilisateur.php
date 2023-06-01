<?php
require_once '../config.php';
session_start_custom(true, true);

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de l'ID utilisateur
    $userID = $_GET['userID'];

    // Requête pour récupérer les logs de l'utilisateur
    $query = "SELECT Page_Visitée, Action, Timestamp_Log FROM logs WHERE ID_Utilisateur = :userID";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Affichage des résultats
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Logs de l\'utilisateur</title>
            <link rel="stylesheet" href="./css/logs_utilisateur.css">
        </head>
        <body>
            <h1>Logs de l\'utilisateur</h1>
            <table>
                <thead>
                    <tr>
                        <th>Page visitée</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $page_visitee = $row['Page_Visitée'];
        $action = $row['Action'];
        $timestamp_log = $row['Timestamp_Log'];
        echo '
                    <tr>
                        <td>' . $page_visitee . '</td>
                        <td>' . $action . '</td>
                        <td>' . $timestamp_log . '</td>
                    </tr>';
    }
    echo '
                </tbody>
            </table>
        </body>
        </html>
    ';
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}
?>
