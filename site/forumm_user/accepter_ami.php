<?php
include '../config.php'; 
session_start_custom();

$id_utilisateur = $_SESSION['ID_Utilisateur'];
$id_relation = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (isset($id_relation)) {
    // Accepter une demande d'ami
    $requete_acceptation = $pdo->prepare("UPDATE relations_amis SET statut_amitie = 'amis' WHERE ID_Relation = :id_relation");
    $requete_acceptation->bindParam(':id_relation', $id_relation, PDO::PARAM_INT);
    $requete_acceptation->execute();

    // Rediriger vers la page amis.php
    header("Location: amis.php");
    exit;
} else {
    // Gérer le cas où la variable n'est pas définie ou est nulle
    echo "ID de la relation invalide.";
}
?>
