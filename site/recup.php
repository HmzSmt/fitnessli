<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php'; 
session_start_custom();

if(isset($_GET['session_id'])) {
  \Stripe\Stripe::setApiKey('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');

    $session = \Stripe\Checkout\Session::retrieve($_GET['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']);

    $userID = $session->client_reference_id;

    $sql = "UPDATE utilisateurs SET statut_prenium = 1 WHERE ID_Utilisateur = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du statut prénium : " . $e->getMessage();
        exit;
    }
}

$getdataimages = $pdo->prepare("SELECT * FROM publications");
$getdataimages->execute();
$images = $getdataimages->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['ID_Utilisateur'])) {
    $userID = $_SESSION['ID_Utilisateur'];
    $pageVisited = "recup.php";
    $action = "Accès à la page recup";

    $sql = "INSERT INTO logs (ID_Utilisateur, Page_Visitée, Action) VALUES (:userID, :pageVisited, :action)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':pageVisited', $pageVisited, PDO::PARAM_STR);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
<header>
    <nav>
        <a href="profil.php" class="logo">
            <div class="user-info">
                <div id="avatar_change">
                    <img src="<?php echo $_SESSION['avatar']; ?>" class="avatar">
                </div>
                <div id="user_name">
                    <?php
                    echo $_SESSION['Nom_Utilisateur'] . "_" . $_SESSION['Prénom_Utilisateur'];
                    ?>
                </div>
            </div>
        </a>
        <div><img id="munu" src="images/MENU.png"></div>
        <div>
            <input type="checkbox" id="toggle">
        </div>
        <nav class="navbar">
            <div id="la" class="nav-liks">
                <ul>
                    <li><a href="recup.php">Accueil</a></li>
                    <li><a href="./forumm_user/index.php">Forum</a></li>
                    <li><a href="evenement.php">Evenement</a></li>
                    <li><a href="Entrainement/index.html">Entraînement</a></li>
                    <li><a href="./prenium/subscription.php">Boutique</a></li>
                    <li><a href="./parametres/parametres.php">Paramètres</a></li>
                    <?php if (isset($_SESSION['statut_admin']) && $_SESSION['statut_admin'] == 1) : ?>
                        <li><a href="./espace_admin/index.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="deconnexion.php">deconnexion</a></li>
                </ul>
            </div>
        </nav>
    </nav>
</header>
<main>
    <div id="output">
    <?php foreach ($images as $image) : ?>
      <div class="post">
        <div class="user-info">
          <img src="<?php echo $image['avatar']; ?>" alt="Avatar de l'utilisateur" class="post-avatar">
          <p><?php echo $image['user']; ?></p>
        </div>
        <div class="post-content">
          <div id="text_publi"><p><?php echo $image['texte']; ?></p></div>
          <img src="images/<?php echo $image['image']; ?>" alt="Image de la publication" class="post-image">
        </div>
        <div class="post-likes">
          <button class="like-btn" data-post-id="<?php echo $image['id']; ?>">Like</button>
          <p class="like-count"><?php echo $image['likes']; ?></p>
          <form action="signaler_publication.php" method="POST" class="signaler-form">
            <input type="hidden" name="publication_id" value="<?php echo $image['id']; ?>">
            <button type="submit" class="signaler-btn">Signaler</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
    <div id="form-container">
        <form id="publish-form" method="POST" enctype="multipart/form-data" action="uplod.php">
            <label for="text">Texte:</label>
            <textarea id="text" name="text" rows="5" cols="50"></textarea><br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*"><br>
            <button type="submit">Publier</button>
        </form>
    </div>
</main>
<script src="app.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var likeBtns = document.querySelectorAll('.like-btn');
  for (var i = 0; i < likeBtns.length; i++) {
    likeBtns[i].addEventListener('click', function() {
      var postId = this.getAttribute('data-post-id');
      var likeBtn = this;
      var likeCount = this.nextElementSibling;
      var isLiked = likeBtn.classList.contains('liked');

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'like.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var likes = xhr.responseText;
          if (likes !== 'false') {
            likeCount.textContent = likes;
            likeBtn.classList.toggle('liked');
          } else {
            alert('Erreur lors de la mise à jour des likes.');
          }
        } else if (xhr.status !== 200) {
          alert('Erreur lors de la requête AJAX.');
        }
      };
      xhr.send('post_id=' + encodeURIComponent(postId) + '&like=' + encodeURIComponent(!isLiked));
    });
  }
});


</script>
<script>
    const menuHamburger = document.querySelector("#munu")
        const navLinks = document.querySelector(".navbar")
 
        menuHamburger.addEventListener('click',()=>{
        navLinks.classList.toggle('mobile-menu')
        })
</script>

</body>
</html>
