<?php
include '../config.php'; 
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_ami = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (isset($id_ami)) {
    // Ajouter une demande d'ami
    $requete_ajout = $pdo->prepare("INSERT INTO relations_amis (ID_Utilisateur1, ID_Utilisateur2, statut_amitie) VALUES (:id_utilisateur, :id_ami, 'demande_envoyee')");
    $requete_ajout->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $requete_ajout->bindParam(':id_ami', $id_ami, PDO::PARAM_INT);
    $requete_ajout->execute();

    // Ajouter la demande d'amitié dans l'autre sens
    $requete_ajout_inverse = $pdo->prepare("INSERT INTO relations_amis (ID_Utilisateur1, ID_Utilisateur2, statut_amitie) VALUES (:id_ami, :id_utilisateur, 'demande_recue')");
    $requete_ajout_inverse->bindParam(':id_utilisateur', $id_ami, PDO::PARAM_INT);
    $requete_ajout_inverse->bindParam(':id_ami', $id_utilisateur, PDO::PARAM_INT);
    $requete_ajout_inverse->execute();


    // Rediriger vers la page amis.php
    header("Location: amis.php");
    exit;
} else {
    // Gérer le cas où la variable n'est pas définie ou est nulle
    echo "ID de l'ami invalide.";
}
?>
