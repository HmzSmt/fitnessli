<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
session_start_custom(true, true);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Premium</title>
    <link rel="stylesheet" href="prenium.css"> 
    <a href="./index.php" class="home-button">Accueil</a>
</head>
<body>
    <h2>Page Premium</h2>

    <form method="post" action="send_premium_email.php">
        <label for="theme">Sélectionnez le thème du mail :</label>
        <select id="theme" name="theme" onchange="showMessage(this.value)">
            <option value="nutrition">Nutrition</option>
            <option value="entrainement">Entraînement</option>
            <option value="motivation">Motivation</option>
            <option value="recuperation">Récupération</option>
            <option value="technique">Technique</option>
        </select>

        <label for="message">Message:</label>
        <textarea id="message" name="message"></textarea>

        <label for="date">Sélectionnez la date d'envoi :</label>
        <input type="date" id="date" name="date">

        <label for="time">Sélectionnez l'heure d'envoi :</label>
        <input type="time" id="time" name="time">

        <input type="submit" value="Envoyer">
    </form>

    <script>
        // Cette fonction montre le message en fonction du thème choisi
        function showMessage(theme) {
            var messages = {
                "nutrition": "Message pour nutrition",
                "entrainement": "Message pour entrainement",
                "motivation": "Message pour motivation",
                "recuperation": "Message pour recuperation",
                "technique": "Message pour technique"
            };
            document.getElementById('message').value = messages[theme];
        }
    </script>
    
</body>
</html>
