<?php
$host = '54.36.189.13';
$dbname = 'fitnessli';
$user = 'user';
$password = 'J2SG3,QN<*:z!?QQ';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

if (isset($_POST['text']) && isset($_FILES['image'])) {
    // Échapper les données utilisateur
    $title = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');

    // Obtenir le nom et l'extension du fichier téléchargé
    $original_name = $_FILES['image']['name'];
    $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    echo "Nom original : {$original_name}<br>";
    echo "Extension : {$extension}<br>";

    // Vérifier si l'extension est valide
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($extension, $allowed_extensions)) {
        // Renommer le fichier avec un nom unique
        $new_name = 'image_' . uniqid() . '.' . $extension;
        echo "Nouveau nom : {$new_name}<br>";

        // Déplacer le fichier téléchargé dans le répertoire images avec le nouveau nom
        $destination_path = 'images/' . $new_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination_path)) {
            session_start();
            
            // Utiliser une requête préparée pour insérer les données dans la base de données
            $addimage = $conn->prepare("INSERT INTO publications (texte, image, date,user,avatar) VALUES (?, ?, ?,?,?)");

            // Obtenir la date actuelle
            $date = new DateTime();
            $formatted_date = $date->format('Y-m-d');
            $mail=$_SESSION['Adresse_Email'];
            $avatar=$_SESSION['avatar'];

            // Binder les paramètres à la requête préparée et exécuter la requête
            $addimage->bindParam(1, $title);
            $addimage->bindParam(2, $new_name);
            $addimage->bindParam(3, $formatted_date);
            $addimage->bindParam(4, $mail);
            $addimage->bindParam(5, $avatar);
            $addimage->execute();

            echo "Image ajoutée avec succès à la base de données.<br>";

            
            header('Location: recup.php');
            exit;
        } else {
            echo "Erreur lors du déplacement du fichier.";
        }
    } else {
        echo "L'extension du fichier n'est pas autorisée.";
    }
}
?>
