<?php
var_dump($_POST)
// Connexion à la base de données
$servername = "54.36.189.13";
$dbname = "fitnessli";
$username = "user";
$password = "J2SG3,QN<*:z!?QQ";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le formulaire a été soumis et le bouton "Get" a été cliqué
    if (isset($_POST["get"])) {
        // Récupérer le chemin de l'image depuis le formulaire
        $imagePath = $_POST["image_path"];

        // Préparer la requête SQL pour insérer l'image dans la table "badge"
        $stmt = $conn->prepare("INSERT INTO badge (image_path) VALUES (:image_path)");
        $stmt->bindParam(":image_path", $imagePath);

        // Exécuter la requête SQL
        $stmt->execute();

        // Afficher un message de succès
        echo "L'image a été enregistrée dans la base de données.";
    }
}
?>
