<?php
    require_once '../config.php';
    session_start_custom(true, true);
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'événements - Backend</title>
    <link rel="stylesheet" href="css/Article_evenement.css"> 
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <a href="index.php" class="btn btn-secondary">Accueil</a>
</head>
<body>
    
    
    <h1>Liste des événements</h1>

    <?php
    // Récupération des événements
    $sql = "SELECT * FROM evenements";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll();
    // Vérifier si l'utilisateur est connecté
if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "Article_evenement.php";
    $action = "Accès à la page 1";

    // Insérer le log dans la base de données
    $sql = "INSERT INTO logs (ID_Utilisateur, Page_Visitée, Action) VALUES (:userID, :pageVisited, :action)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':pageVisited', $pageVisited, PDO::PARAM_STR);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->execute();
}
    ?>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Date de début</th>
                <th>Heure de début</th>
                <th>Date de fin</th>
                <th>Heure de fin</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['titre']) ?></td>
                <td><?= htmlspecialchars($event['description']) ?></td>
                <td><?= htmlspecialchars($event['date_debut']) ?></td>
                <td><?= htmlspecialchars($event['heure_debut']) ?></td>
                <td><?= htmlspecialchars($event['date_fin']) ?></td>
                <td><?= htmlspecialchars($event['heure_fin']) ?></td>
                
                <td>
                    <a href="supprimer_evenement.php?id=<?= $event['id'] ?>">Supprimer</a>
                    <a href="modifier.php?id=<?= $event['id'] ?>">Modifier</a>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
// Démarrer la session
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    include 'bdd.php';
    $pdo = connectDB();

    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $heure_debut = $_POST['heure_debut'];
    $date_fin = $_POST['date_fin'];
    $heure_fin = $_POST['heure_fin'];

    // Gestion de l'image
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Ajout de l'événement dans la base de données
    $sql = "INSERT INTO evenements (titre, description, date_debut, heure_debut, date_fin, heure_fin, image) VALUES (:titre, :description, :date_debut, :heure_debut, :date_fin, :heure_fin, :image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':date_debut', $date_debut, PDO::PARAM_STR);
    $stmt->bindParam(':heure_debut', $heure_debut, PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
    $stmt->bindParam(':heure_fin', $heure_fin, PDO::PARAM_STR);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR);
    $stmt->execute();

    // Rediriger vers la page des événements
    header('Location: evenement.php');
    exit();
}    ?>

</body>
</html>

