<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../config.php';
session_start_custom(true, true);

if (!isset($_GET['id'])) {
    die("Aucun ID d'utilisateur signalé fourni");
}

$idUtilisateurSignale = intval($_GET['id']);

// Récupérer les messages signalés de l'utilisateur
$requete_messages = $pdo->prepare("SELECT * FROM signalements INNER JOIN messages ON signalements.ID_Message = messages.ID_Message WHERE signalements.ID_Utilisateur_Signale = :idUtilisateurSignale");
$requete_messages->bindParam(':idUtilisateurSignale', $idUtilisateurSignale, PDO::PARAM_INT);

$requete_messages->execute();


$messages = $requete_messages->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Messages signalés</title>
</head>
<body>
    
    <style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  padding: 20px;
}

h1 {
  text-align: center;
  margin-top: 20px;
  color: #007bff;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin-bottom: 10px;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

p {
  margin: 0;
}

form {
  display: inline;
  margin-left: 10px;
}

button {
  background-color: green;
  color: #fff;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}
#btn {
    background-color: red;
  color: #fff;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #c82333;
}

    </style>
    <h1>Messages signalés de l'utilisateur <?= $idUtilisateurSignale ?></h1>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <p><?= htmlspecialchars($message['Contenu']) ?> (<?= $message['Date_Signalement'] ?>)</p>
                <form action="supprimer_message_signale.php" method="POST">
                    <input type="hidden" name="message_id" value="<?= $message['ID_Signalement'] ?>">
                    <button type="submit">clear</button>
                </form>
                <form action="supprimer_message.php" method="POST">
                    <input type="hidden" name="message" value="<?= $message['ID_Message'] ?>">
                    <input type="hidden" name="message_id" value="<?= $message['ID_Signalement'] ?>">
                    <button id="btn" type="submit">supremer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

