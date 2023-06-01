<?php
session_start();
require_once '../../config.php';
require_once '/var/www/html2/vendor/autoload.php';

if (isset($_POST['download_report'])) {
    if (isset($_SESSION['ID_Utilisateur'])) {
        $user_id = $_SESSION['ID_Utilisateur'];

        $query = "SELECT * FROM utilisateurs WHERE ID_Utilisateur = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            echo "Erreur : Impossible de récupérer les informations de l'utilisateur.";
            exit;
        }

        $report = "Rapport de compte pour " . $user['Nom_Utilisateur'] . "\n\n";
        $report .= "ID Utilisateur : " . $user['ID_Utilisateur'] . "\n";
        $report .= "Nom : " . $user['Nom_Utilisateur'] . "\n";
        $report .= "Prénom : " . $user['Prénom_Utilisateur'] . "\n";
        $report .= "Email : " . $user['Adresse_Email'] . "\n";
        $report .= "Date de naissance : " . $user['date_naissance'] . "\n";
        $report .= "Statut Premium : " . ($user['statut_prenium'] ? "Oui" : "Non") . "\n";
        $report .= "Statut Admin : " . ($user['statut_admin'] ? "Oui" : "Non") . "\n";
        $report .= "Dernière connexion : " . $user['last_login'] . "\n";

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, utf8_decode($report));
        $filename = "rapport_compte_" . $user['Nom_Utilisateur'] . ".pdf";
        $pdf->Output('D', $filename);
        exit;
    } else {
        echo "Erreur : ID de l'utilisateur non défini.";
        exit;
    }
} else {
    echo "Erreur : Aucune demande de téléchargement de rapport de compte reçue.";
    exit;
}
?>
