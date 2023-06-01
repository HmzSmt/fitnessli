<?php
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$host = "54.36.189.13";
$dbname = "fitnessli";
$user = "user";
$password = "J2SG3,QN<*:z!?QQ";

$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

session_start();
if (!isset($_SESSION['statut_admin']) || $_SESSION['statut_admin'] != 1) {
    header('Location: index.php');
    exit();
}

$subject = $_POST['theme']; // Récupérer le thème comme sujet
$message = $_POST['message']; // Récupérer le message
$theme = $_POST['theme']; // Récupérer le thème

// Sélectionner les utilisateurs qui ont un statut_prenium
$stmt = $db->prepare("SELECT Adresse_Email FROM utilisateurs WHERE statut_prenium = 1");
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fitnessly.esgi@gmail.com';
    $mail->Password = 'bpcawhonwfvodiph';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('fitnessly.esgi@gmail.com', 'FITNESSLY');

    foreach ($emails as $email) {
        $mail->addBCC($email['Adresse_Email']);
    }

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();

    $stmt = $db->prepare("INSERT INTO newsletters (email, nom, date) VALUES (:email, :nom, NOW())");
    foreach ($emails as $email) {
        $stmt->execute([
            ':email' => $email['Adresse_Email'],
            ':nom' => $theme
        ]);
    }

    echo 'Message a été envoyé';
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Erreur de messagerie: {$mail->ErrorInfo}";
}
?>
