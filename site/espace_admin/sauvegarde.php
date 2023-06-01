<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de sauvegarde de la base de données</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .title {
            font-size: 24px;
            margin: 0;
        }
        .home-button {
            background-color: #6c757d;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
        }
        .home-button:hover {
            background-color: #555;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Page de sauvegarde de la base de données</h1>
        </div>
        <form method="post" action="">
            <div class="form-group">
                <button type="submit" name="backup" class="btn btn-primary">Sauvegarder et Télécharger la base de données</button>
                <a href="index.php" class="home-button">Accueil</a>
            </div>
        </form>
    </div>

    <?php
    // Inclure le fichier de configuration pour obtenir les informations de connexion à la base de données
    require_once '../config.php';
    session_start_custom(true, true);

    // Fonction pour exporter la base de données
    function exportDatabase($host, $user, $password, $dbname) {
        // Établir la connexion avec la base de données
        $mysqli = new mysqli($host, $user, $password, $dbname);

        // Vérifier si la connexion a réussi
        if ($mysqli->connect_error) {
            die('Erreur de connexion : ' . $mysqli->connect_error);
        }

        // Récupérer la liste des tables dans la base de données
        $tables = [];
        $result = $mysqli->query("SHOW TABLES");
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }

        // Initialiser la variable pour stocker le contenu de la sauvegarde
        $output = '';

        // Parcourir chaque table et extraire les données
        foreach ($tables as $table) {
            // Récupérer les données de la table
            $result = $mysqli->query("SELECT * FROM $table");
            $numColumns = $result->field_count;

            // Ajouter une instruction pour supprimer la table si elle existe déjà
            $output .= "DROP TABLE IF EXISTS $table;";

            // Récupérer la requête de création de la table
            $createTableResult = $mysqli->query("SHOW CREATE TABLE $table");
            $createTableRow = $createTableResult->fetch_row();

            // Ajouter la requête de création de la table au contenu de la sauvegarde
            $output .= "\n\n" . $createTableRow[1] . ";\n\n";

            // Parcourir chaque ligne de données de la table et les ajouter au contenu de la sauvegarde
            for ($i = 0; $i < $numColumns; $i++) {
                while ($row = $result->fetch_row()) {
                    $output .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $numColumns; $j++) {
                        $row[$j] = $mysqli->real_escape_string($row[$j]);
                        $output .= $j < ($numColumns - 1) ? "'$row[$j]', " : "'$row[$j]'";
                    }
                    $output .= ");\n";
                }
            }
            $output .= "\n\n\n";
        }

        // Fermer la connexion à la base de données
        $mysqli->close();

        // Retourner le contenu de la sauvegarde
        return $output;
    }

    // Vérifier si le bouton de sauvegarde a été cliqué
    if (isset($_POST['backup'])) {
        try {
            // Appeler la fonction exportDatabase() pour récupérer le contenu de la sauvegarde
            $backupData = exportDatabase($host, $user, $password, $dbname);

            // Mise en tampon de la sortie pour capturer le contenu de la sauvegarde
            ob_start();
            echo $backupData;
            $content = ob_get_clean();

            // Préparer les en-têtes HTTP pour télécharger le fichier de sauvegarde
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="backup.sql"');
            header('Content-Length: ' . strlen($content));

            // Envoyer le contenu de la sauvegarde au navigateur pour le téléchargement
            echo $content;
            exit;
        } catch (Exception $e) {
            // Afficher un message d'erreur en cas d'exception
            echo '<div class="container mt-3">';
            echo '<div class="alert alert-danger" role="alert">Erreur : ' . $e->getMessage() . '</div>';
            echo '</div>';
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
