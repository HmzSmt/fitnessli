<?php
session_start();
if(isset($_POST['deconnexion'])){
    session_destroy();
    header('Location: connexion.php');
}
?>