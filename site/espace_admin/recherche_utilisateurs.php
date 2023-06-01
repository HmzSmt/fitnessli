<?php
require_once '../config.php';
session_start_custom(true, true);

if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
    $recupUsers = $pdo->prepare('SELECT * FROM utilisateurs WHERE Nom_Utilisateur LIKE :recherche OR Prénom_Utilisateur LIKE :recherche OR Adresse_Email LIKE :recherche');
    $recupUsers->execute(array(':recherche' => '%' . $recherche . '%'));
} else {
    $recupUsers = $pdo->query('SELECT * FROM utilisateurs');
}

$users = $recupUsers->fetchAll();

foreach ($users as $user) {
    echo "<p>ID: " . $user['ID_Utilisateur'] . " | Nom: " . $user['Nom_Utilisateur'] . " | Prénom: " . $user['Prénom_Utilisateur'] . " | Email: " . $user['Adresse_Email'] . " | Taille: " . $user['taille'] . " | Poids: " . $user['poids'] . " | Statut premium: " . $user['statut_prenium'] . " | Statut connexion: " . $user['statut_connexion'] . " | Avatar: " . $user['avatar'] . " | Statut admin: " . $user['statut_admin'] . " | Statut bannissement: " . $user['statut_bannissement'] . " <a href='bannir.php?id=" . $user['ID_Utilisateur'] . "&action=bannir&duree=permanent' style='color:red;text-decoration: none;'>🚫 Bannir</a> | <a href='./bannir.php?id=" . $user['ID_Utilisateur'] . "&action=bannir_temporairement&duree=1h' style='color:orange;text-decoration: none;'>⏲️ Bannir temporairement (1h)</a> | <a href='./bannir.php?id=" . $user['ID_Utilisateur'] . "&action=bannir_temporairement&duree=24h' style='color:orange;text-decoration: none;'>⏲️ Bannir temporairement (24h)</a> | <a href='./bannir.php?id=" . $user['ID_Utilisateur'] . "&action=bannir_temporairement&duree=7d' style='color:orange;text-decoration: none;'>⏲️ Bannir temporairement (7d)</a> | <a href='./bannir.php?id=" . $user['ID_Utilisateur'] . "&action=supprimer&duree=permanent' style='color:blue;text-decoration: none;'>❌ Supprimer le compte</a> | <a href='bannir.php?id=" . $user['ID_Utilisateur'] . "&action=debannir&duree=permanent' style='color:green;text-decoration: none;'>✅ Débannir</a> 
    | <a href='adminer.php?id=" . $user['ID_Utilisateur'] . "' style='color:green;text-decoration: none;'>👾 Admin</a></p>";
}
?>
