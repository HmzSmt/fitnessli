<?php
require_once '../config.php';
session_start_custom(true, true);

if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
    $recupUsers = $pdo->prepare('SELECT * FROM utilisateurs WHERE Nom_Utilisateur LIKE :recherche OR Prénom_Utilisateur LIKE :recherche OR Adresse_Email LIKE :recherche');
    $recupUsers->execute(array(':recherche' => '%' . $recherche . '%'));
} else {
    $recupUsers = $pdo->query('SELECT * FROM utilisateurs');
}

$users = $recupUsers->fetchAll();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "utilisateurs.php";
    $action = "accès à la page membre du site admin";

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
<html>
<head>
    <title>Afficher les membres</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/utilisateurs.css">
    <script>
        function rechercheUtilisateurs() {
            var rechercheInput = document.getElementById('rechercheInput');
            var listeUtilisateurs = document.getElementById('liste_utilisateurs');
            var recherche = rechercheInput.value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    listeUtilisateurs.innerHTML = xhr.responseText;
                }
            };

            xhr.open('GET', 'recherche_utilisateurs.php?recherche=' + recherche, true);
            xhr.send();
        }
    </script>
</head>
<body>

<header>
    <a href="index.php" id="acceuil">Accueil</a>
</header>

<form align="center">
    <input type="text" id="rechercheInput" placeholder="Rechercher un utilisateur..." value="<?php if (isset($_GET['recherche'])) echo $_GET['recherche']; ?>" oninput="rechercheUtilisateurs()">
    <button type="button" onclick="rechercheUtilisateurs()">Rechercher</button>
</form>

<div id="liste_utilisateurs">
    <?php include 'recherche_utilisateurs.php'; ?>
</div>

</body>
</html>
