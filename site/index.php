
<!DOCTYPE html>
<html>
<head>
    
<link href="css/index_inscription.css" rel="stylesheet" type="text/css" >
    <title>Inscription</title>
    <script>
    // Fonction pour afficher une alerte en cas d'erreur
    function showAlert(message) {
        alert(message);
    }
    </script>
</head>
<body>
<h1>Inscription</h1>
<?php
    // Vérifier si une erreur est envoyée via la requête GET
    if (isset($_GET['erreur'])) {
        // Récupérer le code d'erreur
        $code_erreur = $_GET['erreur'];

        // Afficher un message d'erreur en fonction du code d'erreur
        switch ($code_erreur) {
            case '1':
                echo "<script>showAlert('L\'email que vous avez entré existe déjà.');</script>";
                break;
            case '2':
                echo "<script>showAlert('Une erreur s'est produite lors de l'envoi de l\'email de confirmation.');</script>";
                break;
            case '3':
                echo "<script>showAlert('Le mot de passe que vous avez entré n\'est pas sécurisé. Il doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.');</script>";
                break;
            case '4':
                echo "<script>showAlert('Votre adresse IP a été bannie. Contactez l\'administrateur pour plus d\'informations.');</script>";
                break;
            default:
                echo "<script>showAlert('Une erreur s'est produite.');</script>";
                break;
        }
    }
    ?>
    <!-- Barre de progression pour les étapes -->
    <form action="traitement.php" method="post">

        <!-- Partie 1 : Prénom, Nom, Âge -->
        <div id="partie-1" >
            <div class="progress">
        <div class="progress-bar" style="width: 25%">1</div></div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="date_naissance">Date de naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" required>


            <button type="button" onclick="afficherPartie(2)">Suivant</button>
            <p>Deja un compte ? <a href="connexion.php">Connexion</a></p>
        </div>

        <!-- Partie 2 : Taille en cm, Poids en kg -->
        <div id="partie-2" style="display:none;">
        <div class="progress">
        <div class="progress-bar" style="width: 50%">1</div></div>
            <label for="taille">Taille en cm :</label>
            <input type="number" id="taille" name="taille" required>

            <label for="poids">Poids en kg :</label>
            <input type="number" id="poids" name="poids" required>

            <button type="button" onclick="afficherPartie(1)">Précédent</button>
            <button type="button" onclick="afficherPartie(3)">Suivant</button>
            <p>Deja un compte ? <a href="connexion.php">Connexion</a></p>
        </div>

        <!-- Partie 3 : Email, Mot de passe -->
        <div id="partie-3" style="display:none;">
        <div class="progress">
        <div class="progress-bar" style="width: 75%">1</div></div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <button type="button" onclick="afficherPartie(2)">Précédent</button>
            <button type="button" onclick="afficherPartie(4)">Suivant</button>
            <p>Deja un compte ? <a href="connexion.php">Connexion</a></p>
        </div>

        <!-- Partie 4 : Code de confirmation -->
        <div id="partie-4" style="display:none;">
        <div class="progress">
        <div class="progress-bar" style="width: 100%">1</div></div>
            <label for="code_confirmation">Code de confirmation </label>

            <button type="button" onclick="afficherPartie(3)">Précédent</button>
            <button type="submit">Envoyer</button>
        </div>

    </form>

    <script>
    function afficherPartie(numero) {
        document.getElementById("partie-1").style.display = "none";
        document.getElementById("partie-2").style.display = "none";
        document.getElementById("partie-3").style.display = "none";
        document.getElementById("partie-4").style.display = "none";

        document.getElementById("partie-" + numero).style.display = "block";

        // Mettre à jour la barre de progression
        var barres = document.getElementsByClassName("barre");
        for (var i = 0; i < barres.length; i++) {
            barres[i].classList.remove("active");
        }
        var barreActive = document.getElementById("barre-" + numero);
        barreActive.classList.add("active");
    }
</script>


</body>
</html>
