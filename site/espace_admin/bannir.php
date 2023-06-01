<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
session_start_custom(true, true);

if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['duree']) && !empty($_GET['duree'])) {
    $id = (int)$_GET['id'];
    $action = htmlspecialchars($_GET['action']);
    $duree = (int)htmlspecialchars($_GET['duree']); // Conversion de $duree en entier

    $verifID = $pdo->prepare('SELECT * FROM utilisateurs WHERE ID_Utilisateur = ?');
    $verifID->execute(array($id));

    if ($verifID->rowCount() > 0) {
        // Récupérer l'adresse IP de l'utilisateur
        $user = $verifID->fetch();
        $adresse_ip = $user['adresse_ip'];

        if ($action == "bannir") {
            // Insérer l'adresse IP dans la table ip_bannies avec un bannissement permanent
            $insertIP = $pdo->prepare('INSERT INTO ip_bannies (ID_Utilisateur, adresse_ip, permanent) VALUES (?, ?, 1)');
            $insertIP->execute(array($id, $adresse_ip));

            // Bannir l'utilisateur
            $ban = $pdo->prepare('UPDATE utilisateurs SET statut_bannissement = 1 WHERE ID_Utilisateur = ?');
            $ban->execute(array($id));
            echo '<script>alert("L utilisateur a été banni.");</script>';
            echo '<script>window.location.href = "utilisateurs.php";</script>';
            
        } elseif ($action == "bannir_temporairement") {
            $temps_bannissement = time() + $duree * 3600; // Convertir la durée en heures
            $date_fin_ban = date('Y-m-d H:i:s', $temps_bannissement);

            // Insérer l'adresse IP dans la table ip_bannies avec un bannissement temporaire
            $insertIP = $pdo->prepare('INSERT INTO ip_bannies (ID_Utilisateur, adresse_ip, date_fin_ban) VALUES (?, ?, ?)');
            $insertIP->execute(array($id, $adresse_ip, $date_fin_ban));

            // Bannir temporairement l'utilisateur
            $ban_temp = $pdo->prepare('UPDATE utilisateurs SET statut_bannissement = 1, temps_bannissement = ? WHERE ID_Utilisateur = ?');
            $ban_temp->execute(array($temps_bannissement, $id));
            echo '<script>alert("L utilisateur a été banni temporairement pour " . $duree . " heures.");</script>';
            echo '<script>window.location.href = "utilisateurs.php";</script>';
            
        } elseif ($action == "supprimer") {
            // Supprimer les enregistrements de la table "commentaires" liés à l'utilisateur
            $supprimerCommentaires = $pdo->prepare('DELETE FROM commentaires WHERE utilisateur_id = ?');
            $supprimerCommentaires->execute(array($id));
        
            // Supprimer les enregistrements de la table "conversations" liés à l'utilisateur
            $supprimerConversations = $pdo->prepare('DELETE FROM conversations WHERE ID_Conversation = ?');
            $supprimerConversations->execute(array($id));

            // Supprimer les enregistrements de la table "evenements" liés à l'utilisateur
            $supprimerEvenements = $pdo->prepare('DELETE FROM evenements WHERE id = ?');
            $supprimerEvenements->execute(array($id));
            
            // Supprimer les enregistrements de la table "event_inscriptions" liés à l'utilisateur
            $supprimerEventInscriptions = $pdo->prepare('DELETE FROM event_inscriptions WHERE id = ?');
            $supprimerEventInscriptions->execute(array($id));
            
            // Supprimer les enregistrements de la table "likes" liés à l'utilisateur
            $supprimerLikes = $pdo->prepare('DELETE FROM likes WHERE id = ?');
            $supprimerLikes->execute(array($id));
            
            // Supprimer les enregistrements de la table "logs" liés à l'utilisateur
            $supprimerLogs = $pdo->prepare('DELETE FROM logs WHERE ID_Utilisateur = ?');
            $supprimerLogs->execute(array($id));
            
            // Supprimer les enregistrements de la table "messages" liés à l'utilisateur
            $supprimerMessages = $pdo->prepare('DELETE FROM messages WHERE ID_Utilisateur = ?');
            $supprimerMessages->execute(array($id));

            // Supprimer les enregistrements de la table "message_private" liés à l'utilisateur
            $supprimerMessagesPrives = $pdo->prepare('DELETE FROM message_private WHERE ID_Utilisateur1 = ? OR ID_Utilisateur2 = ?');
            $supprimerMessagesPrives->execute(array($id, $id));

            // Supprimer les enregistrements de la table "newsletters" liés à l'utilisateur
            $supprimerNewsletters = $pdo->prepare('DELETE FROM newsletters WHERE id = ?');
            $supprimerNewsletters->execute(array($id));

            // Supprimer les enregistrements de la table "pseudos_forum" liés à l'utilisateur
            $supprimerPseudosForum = $pdo->prepare('DELETE FROM pseudos_forum WHERE ID_Utilisateur = ?');
            $supprimerPseudosForum->execute(array($id));

            // Supprimer les enregistrements de la table "publications" liés à l'utilisateur
            $supprimerPublications = $pdo->prepare('DELETE FROM publications WHERE user = ?');
            $supprimerPublications->execute(array($id));

            // Supprimer les enregistrements de la table "relations_amis" liés à l'utilisateur
            $supprimerRelationsAmis = $pdo->prepare('DELETE FROM relations_amis WHERE ID_Utilisateur1 = ? OR ID_Utilisateur2 = ?');
            $supprimerRelationsAmis->execute(array($id, $id));

            // Supprimer les enregistrements de la table "utilisateurs_conversations" liés à l'utilisateur
            $supprimerUtilisateursConversations = $pdo->prepare('DELETE FROM utilisateurs_conversations WHERE ID_Utilisateur = ?');
            $supprimerUtilisateursConversations->execute(array($id));

            // Supprimer l'utilisateur
            $supprimerUtilisateur = $pdo->prepare('DELETE FROM utilisateurs WHERE ID_Utilisateur = ?');
            $supprimerUtilisateur->execute(array($id));
            echo '<script>alert("Le compte de l utilisateur et tous ses éléments associés ont été supprimés.");</script>';
            echo '<script>window.location.href = "utilisateurs.php";</script>';
            
        } elseif ($action == "debannir") {
             // Supprimer l'adresse IP bannie de la table ip_bannies
            $deleteIP = $pdo->prepare('DELETE FROM ip_bannies WHERE ID_Utilisateur = ?');
            $deleteIP->execute(array($id));

            // Débannir l'utilisateur
            $unban = $pdo->prepare('UPDATE utilisateurs SET statut_bannissement = 0 WHERE ID_Utilisateur = ?');
            $unban->execute(array($id));
            echo '<script>alert("L utilisateur a été débanni.");</script>';
            echo '<script>window.location.href = "utilisateurs.php";</script>';
        
        } else {
            echo '<script>alert("Action non reconnue.");</script>';
            echo '<script>window.location.href = "utilisateurs.php";</script>';
            
        }
    } else {
        echo '<script>alert("L utilisateur est introuvable.");</script>';
        echo '<script>window.location.href = "utilisateurs.php";</script>';
        
    }
} else {
    echo '<script>alert("Informations manquantes.");</script>';
    echo '<script>window.location.href = "utilisateurs.php";</script>';
    
}
?>
            
