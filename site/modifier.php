<?php

require_once 'config.php';
session_start();


    $id = $_SESSION['Adresse_Email'];
    include 'bdd.php';
    $pdo = connectDB();

    // Récupérer les détails de l'événement depuis la base de données
    $sql = "SELECT * FROM evenements WHERE createur_id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    // Vérifier si l'événement existe
    if (!$event) {
        echo "L'événement n'existe pas.";
        exit;
    }

// Traitement du formulaire de modification de l'événement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $heure_debut = $_POST['heure_debut'];
    $date_fin = $_POST['date_fin'];
    $heure_fin = $_POST['heure_fin'];

    // Mise à jour de l'événement dans la base de données
    $sql = "UPDATE evenements SET titre = ?, description = ?, date_debut = ?, heure_debut = ?, date_fin = ?, heure_fin = ? WHERE createur_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $date_debut, $heure_debut, $date_fin, $heure_fin, $id]);

    // Rediriger vers la page des événements
    header('Location:evenement.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'événement</title>
</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

h1 {
    text-align: center;
    margin-top: 20px;
    color: #007bff;
}

form {
    width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-top: 10px;
    color: #333;
}

form input[type="text"],
form textarea,
form input[type="date"],
form input[type="time"] {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form input[type="submit"] {
    width: auto;
    padding: 8px 20px;
    margin-top: 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    margin-top: 10px;
}

.success-message {
    color: green;
    margin-top: 10px;
}


    </style>

    <h1>Modifier l'événement</h1>

    <form method="POST">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($event['titre']) ?>" required><br><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($event['description']) ?></textarea><br><br>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= $event['date_debut'] ?>" required><br><br>

        <label for="heure_debut">Heure de début :</label>
        <input type="time" id="heure_debut" name="heure_debut" value="<?= $event['heure_debut'] ?>" required><br><br>
        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" value="<?= $event['date_fin'] ?>" required><br><br>

        <label for="heure_fin">Heure de fin :</label>
        <input type="time" id="heure_fin" name="heure_fin" value="<?= $event['heure_fin'] ?>" required><br><br>

        <input type="submit" value="Modifier">
    </form>
</body>
</html>

