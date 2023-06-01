<?php

include '../config.php'; 
session_start_custom(true);
$userEmail = $_SESSION['Adresse_Email'];
$userNom = $_SESSION['Nom']; // Récupérez le nom de l'utilisateur
// Vérifiez si l'utilisateur est inscrit à la newsletter
$isSubscribed = isSubscribedToNewsletter($userEmail, $pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-pr.css" type="text/css" media="screen" />
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>parametres</title>
</head>
<body>
    <!-- Accueil et Profil -->
    <section id="buttons-container">
        <a href="../recup.php" class="btn">Accueil</a>
        <a href="../profil.php" class="btn btn-profil">Profil</a>
    </section>
    <section id="droit">
        <h3>Options</h3>
        <a href="#s">Mise à jour de l'e-mail</a>
        <a href="#t">Mise à jour du mot de passe</a>
        <a href="#fo">Mise à jour de l'avatar</a>
        <a href="#rp">Aide et assistance</a>
        <a href="#nl">Newsletters</a>
        <a href="#fi">Premium pass</a>
        <a href="#si">Rapport de compte</a>
        <a href="#sv">Supprimer le compte</a>
    </section>
    <button id="menu-button" class="menu-button">Menu</button>

    <!-- Accueil -->
    
    <section class="pr" id="rp">
    <!-- Aide & Assistance -->
    <h3>Besoin d'aide ou d'assistance ?</h3>
    <p class="description">Si vous rencontrez des problèmes ou si vous avez des questions, notre équipe de support est là pour vous aider.</p>

    <h4>FAQ (Foire aux questions)</h4>
    <div class="faq">
        <h5>1. Comment puis-je récupérer mon mot de passe oublié ?</h5>
        <p>Si vous avez oublié votre mot de passe, vous pouvez utiliser la fonction "Mot de passe oublié" sur la page de connexion. Suivez les instructions pour réinitialiser votre mot de passe.</p>

        <h5>2. Comment puis-je mettre à jour mon adresse e-mail ?</h5>
        <p>Pour mettre à jour votre adresse e-mail, accédez à la section "Mise à jour de l'e-mail" dans les options. Remplissez le formulaire avec votre nouvelle adresse e-mail et cliquez sur le bouton "Mettre à jour".</p>

        <h5>3. Comment puis-je supprimer mon compte ?</h5>
        <p>Pour supprimer définitivement votre compte, accédez à la section "Supprimer le compte" dans les options. Cochez la case de confirmation et cliquez sur le bouton "Supprimer le compte". Veuillez noter que cette action est irréversible.</p>

    </div>
</section>
    <section class="pr" id="s">
        <!-- Mise à jour de l'e-mail -->
        <p class="description">Mettez à jour votre adresse e-mail pour recevoir des notifications et des informations importantes.</p>
        <form action="update/update_email.php" method="POST">
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" required>
            <input type="submit" value="Mettre à jour">
        </form>
    </section>
    <section class="pr" id="t">
        <!-- Mise à jour du mot de passe -->
        <p class="description">Changez votre mot de passe pour protéger davantage votre compte.</p>
        <form action="update/update_password.php" method="POST">
            <label for="current_password">Mot de passe actuel :</label>
            <input type="password" id="current_password" name="current_password" required>
            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirmez le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <input type="submit" value="Mettre à jour">
        </form>
    </section>
    <section class="pr" id="fo">
        <!-- Mise à jour de l'avatar -->
        <p class="description">Changez votre avatar pour personnaliser votre profil.</p>
        <form action="update_avatar.php" method="POST" enctype="multipart/form-data">
            <label for="avatar">Avatar :</label>
            <a href="../avatar.php">changer l'avatar</a>
        </form>
    </section>
    <section class="pr" id="rp">
        <!-- Rapport de compte -->
        <p class="description">Consultez les informations de votre compte et votre activité.</p>
        <!-- Ici, vous pouvez ajouter du contenu pour afficher les informations du compte. -->
    </section>
    <section class="pr" id="nl">
    <p class="description">Inscrivez-vous ou désabonnez-vous de notre newsletter pour recevoir des mises à jour et des informations.</p>
    <form method="post" action="./update/newsletter.php">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" value="<?php echo $userEmail ?? ''; ?>" required><br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" value="<?php echo $userNom ?? ''; ?>" required><br>
        <?php if (!isSubscribedToNewsletter($userEmail, $pdo)): ?>
            <input type="hidden" name="action" value="subscribe">
            <input type="submit" value="S'inscrire">
        <?php else: ?>
            <input type="hidden" name="action" value="unsubscribe">
            <input type="submit" value="Se désinscrire">
        <?php endif; ?>
    </form>
</section>
    <section class="pr" id="fi">
        <!-- Premium pass -->
        <p class="description">Gérez votre abonnement Premium pour accéder à des fonctionnalités exclusives et bénéficier d'un accompagnement personnalisé par un coach sportif.</p>
        <h3>Abonnement Premium</h3>
        <p>En vous abonnant à notre offre Premium à seulement 1€ par mois, vous bénéficierez :</p>
        <ul>
            <li>D'un email mensuel personnalisé de la part de votre coach sportif</li>
            <li>Un accès exclusif à nos programmes d'entraînement</li>
        </ul>
        
        <h4>Souscrire à l'abonnement Premium :</h4>
        <form id="payment-form" action="../prenium/subscription.php" method="POST">
    <label for="pack_premium">Pack Premium :</label>
    <select name="pack_premium" required>
        <option value="none" selected>Aucun</option>
        <option value="monthly">Mensuel - 1€</option>
    </select>
    <input type="submit" value="Souscrire">
</form>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch('update/premium_payment.php', {
            method: 'POST',
            body: new FormData(this)
        }).then(function(response) {
            return response.text();
        }).then(function(sessionId) {
            var stripe = Stripe('pk_live_51N56ywJd7DdZkPuKumIoElPcQwsH0UoNw7GMCJlCmlDoEORWbIhlR57VjWVh310Jwkq6KtN9p0pspg3ZRCS41Rwp00GOPOCR7R');
            stripe.redirectToCheckout({
                sessionId: sessionId
            }).then(function (result) {
                if (result.error) {
                    alert(result.error.message);
                }
            });
        });
    });
</script>

    </section>
    <section class="pr" id="si">
        <!-- Rapport de compte -->
        <p class="description">Trouvez de l'aide et de l'assistance pour résoudre vos problèmes et vos questions.</p>
        <p>Si vous avez besoin d'aide ou avez des questions, veuillez contacter notre équipe de support à l'adresse e-mail suivante :</p>
        <p>fitnessli@gmail.com</p>
        <!-- Ajoutez le bouton ici pour accéder à la page download_account_report.php -->
        <form action="./update/download_account_report.php" method="post">
            <button type="submit" name="download_report" class="btn">Télécharger le rapport de compte</button>
        </form>
    </section>
    <section class="pr" id="sv">
    <!-- Supprimer le compte -->
    <p class="description">Supprimez définitivement votre compte et toutes les données associées.</p>
    <form action="update/delete_account.php" method="POST">
        <label for="confirm_delete">Voulez-vous vraiment supprimer votre compte ?</label>
        <input type="checkbox" id="confirm_delete" name="confirm_delete" required>
        <input type="submit" value="Supprimer le compte">
    </form>
</section>
</section>
<script>
    const lienOptions = document.querySelectorAll("#droit a");
    const sections = document.querySelectorAll(".pr");

    lienOptions.forEach(lien => {
        lien.addEventListener("click", (e) => {
            e.preventDefault();

            // Cache toutes les sections
            sections.forEach(section => {
                section.style.display = "none";
            });

            // Affiche la section correspondante à l'option cliquée
            const idSection = e.target.getAttribute("href").substring(1);
            const sectionCible = document.getElementById(idSection);
            sectionCible.style.display = "block";
        });
    });

    document.getElementById('accueil').addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>
<script>
  const menuButton = document.getElementById('menu-button');
  const menu = document.getElementById('droit');

  menuButton.addEventListener('click', () => {
    if (menu.style.display === 'block') {
      menu.style.display = 'none';
    } else {
      menu.style.display = 'block';
    }
  });
</script>
<script>
  const menuLinks = document.querySelectorAll("#droit a");

  menuLinks.forEach(link => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= 1000) {
        menu.style.display = "none";
      }
    });
  });

 src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"

</script>
</body>
</html>
