<?php 
include 'config.php'; 
session_start_custom();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'événements</title>
    <link rel="stylesheet" href="./css/evenement.css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <main>
    <div class="container">
        <div class="form">
            <h2>Ajouter un événement</h2>
            <form action="verification_evenement.php" method="post" enctype="multipart/form-data">
                <!-- Titre de l'événement -->
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" required>

                <!-- Description de l'événement -->
                <label for="description">Description :</label>
                <textarea name="description" id="description" rows="4" cols="50"></textarea>

                <!-- Date de début de l'événement -->
                <label for="date_debut">Date de début :</label>
                <input type="date" name="date_debut" id="date_debut" required>

                <!-- Heure de début de l'événement -->
                <label for="heure_debut">Heure de début :</label>
                <input type="time" name="heure_debut" id="heure_debut" required>

                <!-- Date de fin de l'événement -->
                <label for="date_fin">Date de fin :</label>
                <input type="date" name="date_fin" id="date_fin" required>

                <!-- Heure de fin de l'événement -->
                <label for="heure_fin">Heure de fin :</label>
                <input type="time" name="heure_fin" id="heure_fin" required>

               

                <!-- Bouton pour ajouter l'événement -->
                <input type="submit" value="Ajouter l'événement">
            </form>
            <a href="recup.php" class="btn">Accueil</a>
        </div>

        <div class="evenements">
            <?php
            // Connexion à la base de données
            include 'bdd.php';
            $pdo = connectDB();

            // Récupérer les événements depuis la base de données
            $sql = "SELECT * FROM evenements";
            $stmt = $pdo->query($sql);

            // Afficher les événements
            // Vérification que la requête SQL a retourné des résultats
            if ($stmt->rowCount() > 0) {
                // Boucle qui parcourt chaque ligne du résultat de la requête SQL et stocke les données dans la variable $row
                while($row = $stmt->fetch()) {
                    echo "<div class='evenement'>";
                
                    echo "<div>";
                    // Titre de l'événement
                    echo "<h3>" . $row['titre'] . "</h3>";
                    // Date et heure de début de l'événement
                    echo "<p>Date : " . $row['date_debut'] . "</p>";
                    echo "<p>Heure : " . $row['heure_debut'] . " - " . $row['heure_fin'] . "</p>";
                    
                    // Vérifier si l'utilisateur connecté est le créateur de l'événement
                    if ($_SESSION['Adresse_Email'] == $row['createur_id']) {
                        // Lien pour supprimer l'événement
                        echo '<a class="bt" href="supprimer_evenement.php">Supprimer</a>';
                        echo '<br>';
                        echo '<a class="bt" href="modifier.php">modifier</a>';

                    }
                
                    echo "</div>";
                    echo "<div class='description'>";
                
                    echo "<h3>" . $row['titre'] . "</h3>";
                    echo "<p>Description : " . $row['description'] . "</p>";
                
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Aucun événement à afficher";
            }
            ?>
        </div>
        </div>
    </main>
</body>
</html>

                    