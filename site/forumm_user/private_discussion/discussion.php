<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config.php'; 
session_start_custom();
$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_ami = $_GET['id_ami'];

// Requête pour récupérer le pseudo de l'ami
$query = "SELECT pseudos_forum.Pseudo as pseudo FROM utilisateurs INNER JOIN pseudos_forum ON utilisateurs.ID_Utilisateur = pseudos_forum.ID_Utilisateur WHERE utilisateurs.ID_Utilisateur = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $id_ami, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$pseudo_ami = $row['pseudo'];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Discussion</title>
    <style>
       /* Style de base */
body {
  font-family: Arial, sans-serif;
  background-color: #fff;
  margin: 0;
  padding: 0;
}

h1 {
  font-size: 2.5rem;
  margin: 0;
  padding: 20px;
  background-color: #7b1fa2;
  color: #fff;
  text-align: center;
}

#messages {
  height: 300px;
  border: 1px solid black;
  overflow-y: scroll;
  margin: 20px;
  padding: 10px;
}

#messages p {
  margin: 0;
  padding: 0;
}

input[type="text"] {
  padding: 10px;
  margin: 20px;
  border-radius: 5px;
  border: none;
  background-color: #f0f0f0;
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
  width: 100%;
  font-size: 1.1rem;
  color: #333;
}

input:focus {
  outline: none;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

button {
  background-color: #7b1fa2;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.2rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  transition: all 0.2s ease-in-out;
  margin: 20px;
}

button:hover {
  background-color: #4a148c;
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

a {
  color: #7b1fa2;
  text-decoration: none;
  transition: all 0.2s ease-in-out;
}

a:hover {
  color: #4a148c;
}

    </style>
    <script>
        function chargerMessages() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("messages").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "recuperer_messages.php?id_ami=<?= $id_ami ?>", true);
            xhr.send();
        }

        function envoyerMessage() {
            var message = document.getElementById("message").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "envoyer_message.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id_ami=<?= $id_ami ?>&message=" + encodeURIComponent(message));
            document.getElementById("message").value = "";
        }

        setInterval(chargerMessages, 1000);
    </script>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    </head>
<body>
    <h1>Discussion avec <?= htmlspecialchars($pseudo_ami) ?></h1>

    <div id="messages"></div>
    <input type="text" id="message" placeholder="Entrez votre message">
    <button onclick="envoyerMessage()">Envoyer</button>
    <a href="../amis.php">Retour à la liste des amis</a>
</body>
</html>
