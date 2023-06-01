<?php
require_once '../config.php';
session_start_custom(true, true);

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les utilisateurs et leur date de dernière connexion
    $query = "SELECT ID_Utilisateur, Nom_Utilisateur, last_login FROM utilisateurs";

    // Exécution de la requête
    $stmt = $bdd->prepare($query);
    $stmt->execute();

    // Affichage des résultats
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Liste des utilisateurs</title>
            <link rel="stylesheet" href="./css/logs_user.css">
            <a href="index.php" class="home-button">Accueil</a>
        </head>
        <body>
            <h1>Liste des utilisateurs</h1>
            <input type="text" id="rechercheInput" placeholder="Rechercher un utilisateur" oninput="rechercheUtilisateurs()">
            <ul class="user-list">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userID = $row['ID_Utilisateur'];
        $username = $row['Nom_Utilisateur'];
        $last_login = $row['last_login'];
        echo '
                <li>
                    <span class="user-name">' . 'id' . ' ' . $userID . ' - ' . $username . '</span>
                    <span class="last-login">Dernière connexion : ' . $last_login . '</span>
                    <a href="logs_utilisateur.php?userID=' . $userID . '" class="view-logs-button">Voir les logs</a>
                </li>';
    }
    echo '
            </ul>
            <script>
                function rechercheUtilisateurs() {
                    var rechercheInput = document.getElementById("rechercheInput");
                    var listeUtilisateurs = document.getElementsByClassName("user-list")[0];
                    var recherche = rechercheInput.value.toLowerCase();

                    var utilisateurs = listeUtilisateurs.getElementsByTagName("li");

                    for (var i = 0; i < utilisateurs.length; i++) {
                        var utilisateur = utilisateurs[i];
                        var nomUtilisateur = utilisateur.getElementsByClassName("user-name")[0].textContent.toLowerCase();

                        if (nomUtilisateur.includes(recherche)) {
                            utilisateur.style.display = "flex";
                        } else {
                            utilisateur.style.display = "none";
                        }
                    }
                }
            </script>
        </body>
        </html>
    ';
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}
?>