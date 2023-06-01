<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fitnessli</title>
  <!-- Intégration de Bootstrap et des différents fichiers CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/footer.css" />
  <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
  <!-- En-tête du site -->
  <header class="bg-light d-flex flex-row align-items-center p-2">
    <img style="opacity: 1;" src="img/logo.png" alt="logo">
    <img id="munu" src="img/menu.png">
    <!-- Navigation principale -->
<nav class="navbar">
  <div id="la" class="nav-links">
    <ul class="breadcrumb">
      <li><a class="text-decoration-none p-5" href="#fr">Qui sommes-nous ?</a></li>
      <li><a class="text-decoration-none p-5" href="#section">Pourquoi nous ?</a></li>
      <li><a class="text-decoration-none p-5" href="#cons">Nos conseils</a></li>
      <li><a class="text-decoration-none p-5" href="./site/connexion.php">Se connecter</a></li>
    </ul>
  </div>
</nav>
</header>
  <!-- Section "Qui sommes-nous ?" -->
  <section>
    <article id="fr" class="d-flex flex-row">
      <div class="d-flex flex flex-wrap flex-column align-self-center p-5 container">
        <div class="d-flex flex-nowrap flex-row">
          <h3 style="color: #6F1895;">|</h3>
          <h3 id="h" style="color:white">ÊTES-VOUS PRÊT À</h3>
        </div>
        <div class="d-flex flex-nowrap flex-row">
          <h2 class="d-flex flex-nowrap flex-row" style="color:#8956F1;">DEVENIR</h2>
          <h2 style="color:#8956F1;">FIT</h2>
          <h2 style="color:white">, FORT & MOTIVÉ !</h2>
        </div>
        <button type="button" id='Inscription_btn' class="btn btn-outline-warning btn-lg btn-block" style="color: white;" onclick="window.location.href='./site/index.php'">Inscription</button>
  </div>

  <div class="des">
  <img style="width: 100%; height: auto; min-width: 100px;" src="img/p4.png" class="img-fluid" alt="Image 1">
  </div>
</article>
</section>
  <!-- Section "Pourquoi nous ?" -->
  <section>
    <article id="section" class="d-flex flex-row d-flex justify-content-between">
      <div class="des">
      <img style="width: 100%; height: auto; min-width: 100px;" src="img/M.jpg" class="img-fluid" alt="Image 2">
</div>
<div id="sd" class="d-flex flex flex-wrap flex-column align-self-center p-5">
<div class="dec" class="d-flex flex-nowrap flex-row">
<h2 class="d-flex flex-nowrap flex-row" style="color:white;">POURQUOI</h2>
<h2 style="color :#8956F1">FITNESSLY ?</h2>
</div>
<h3 class="dec" style="color :white">Facile à pratiquer, la musculation s’impose comme un sport moderne.</h3>
<h3 class="dec" style="color :#8956F1">Le sujet vous intéresse ?</h3>
<h3 class="dec" style="color: white;">Découvrez tous nos conseils pour débuter et progresser en musculation.</h3>
</div>
</article>

  </section>
  <!-- Section "Nos coachs" -->
  <section id="df">
  <h1 class="d-flex justify-content-center" style="color: #CB80FF;">Vous serez accompagné par nos coachs</h1>
  <div id="st" class="d-flex flex-row justify-content-between" style="padding-top: 50px;">
    <article class="defiler">
      <img class="img_fil img-fluid w-100" src="img/ziad.jpg">
      <div>
        <h1 class="title">Ziad Khalil</h1>
        <h2 class="exper">Expert en amincissement</h2>
      </div>
    </article>
    <article class="defiler">
    <img class="img_fil img-fluid w-100" src="img/diablo.jpg" onclick="mystere()">
    <div>
        <h1 class="title">Hassan Mohamed</h1>
        <h2 class="exper">Expert en augmentation musculaire</h2>
    </div>
    <script>
        function mystere() {
            window.location.href = "site/fonction-mystere.php";
        }
    </script>
</article>
    </article>
    <article class="defiler">
      <img class="img_fil img-fluid w-100" src="img/rayen.png">
      <div>
        <h1 class="title">Rayene Benzerjab</h1>
        <h2 class="exper">Expert en technique dynamique</h2>
      </div>
    </article>
    <article class="defiler">
      <img class="img_fil img-fluid w-100" src="img/mat.png">
      <div>
        <h1 class="title">Mathéo PION</h1>
        <h2 class="exper">Expert en transformation</h2>
      </div>
    </article>
  </div>
</section>

  <!-- Section "Nos conseils" -->
  <section id="cons" class="d-flex flex-column">
        <article>
          <h1 class="d-flex justify-content-center" style="color: #CB80FF;">Nos conseils</h1>
          <h2 class="text-decoration-none" style="color: white; font-size: larger;padding: 10px;">- UN ENTRAÎNEMENT RÉGULIER ET ADAPTÉ À VOTRE PROGRESSION</h2>
          <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- FIXEZ-VOUS DES OBJECTIFS À COURT TERME ET À LONG TERME</h2>
          <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- RESPECTEZ VOTRE PROGRAMME</h2>
          <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- PAS DE SPORT SANS PHASES DE REPOS</h2>
    <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- MODIFIEZ L’ORDRE DES EXERCICES</h2>
    <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- CONSOMMEZ SUFFISAMMENT DE CALORIES ET DE PROTÉINES</h2>
    <h2 class="text-decoration-none" style="color: white;font-size: larger;padding: 10px;">- N’OUBLIEZ PAS DE MANGER AUTOUR DE L'ENTRAÎNEMENT</h2>
    </article>

  </section>
  <!-- Pied de page -->
  <footer>
    <?php include 'footer.php'; ?>
  </footer>
  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Script personnalisé -->
  <script src="index.js"></script>
  <!-- Script pour le menu hamburger -->
  <script>
    const menuHamburger = document.querySelector("#munu");
    const navLinks = document.querySelector(".navbar");

    menuHamburger.addEventListener('click', () => {
      navLinks.classList.toggle('mobile-menu');
    });
  </script>
</body>
</html>