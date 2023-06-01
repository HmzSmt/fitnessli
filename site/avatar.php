<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/avatar.css" type="text/css" media="screen" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>test</title>
</head>
<body>
  <div class="container">
    <div id="capture">
        <img id="bg" src="layers/back/white.png">
        <img id="body" src="layers/BODY/BODY.png">
        <img id="skin" src="layers/SKINY/NORMAL.png">
        <img id="clothes" src="layers/clothes/NORMAL.png">
        <img id="EXOSSIERS" src="layers/EXOSSIERS/NORMAL.png">
        <img id="eye" src="layers/EYE/NORMAL.png">
        <img id="cap" src="layers/HAT/CAP.png">
        <img id="th" src="layers/TEATH/NORMAL.png">
    </div>
    <div id="btn">
    <button onclick="myFunction()">bg</button>
    <button onclick="skine()">skin</button>
    <button onclick="clothes()">clothes</button>
    <button onclick="ex()">ex</button>
    <button onclick="cap()">cap</button>
    <button onclick="eye()">eye</button>
    <button onclick="th()">th</button>
    </div>
</div>


    
<button id="btnTerminer" onclick="captureAndSaveImage()">Terminer</button>


    <img id="mergedImage" src="" alt="Merged Image">

    
    <script>
  function captureAndSaveImage() {
    var divToCapture = document.getElementById('capture');
    var canvas = document.createElement('canvas');
    canvas.width = 300;
    canvas.height = 300;
    var context = canvas.getContext('2d');

    var images = divToCapture.getElementsByTagName('img');
    var loadedImages = 0;

    for (var i = 0; i < images.length; i++) {
      var image = new Image();
      image.src = images[i].src;

      image.onload = function() {
        loadedImages++;

        if (loadedImages === images.length) {
          for (var j = 0; j < images.length; j++) {
            context.drawImage(images[j], 0, 0, 300, 300);
          }
          var mergedImageElement = document.getElementById('mergedImage');
          mergedImageElement.src = canvas.toDataURL();
          mergedImageElement.alt = 'Merged Image';

          // Obtenir les données de l'image au format base64
          var imageData = mergedImageElement.src;

          // Créer un objet FormData
          var formData = new FormData();
          formData.append('image', dataURItoBlob(imageData), 'image.jpg');

          // Envoyer les données de l'image à la page PHP
          fetch('enregistrer_image.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              console.log(data);
              if (data.success) {
                alert('L\'image a été enregistrée avec succès.');
                window.location.replace("connexion.php");
              } else {
                window.location.replace("connexion.php");
              }
            })
            .catch(error => {
              window.location.replace("connexion.php");
            });
        }
      };
    }
  }

  // Convertir une chaîne de caractères base64 en objet Blob
  function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(',')[1]);
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
      ia[i] = byteString.charCodeAt(i);
    }
    return new Blob([ab], { type: mimeString });
  }

  document.getElementById("btnTerminer").addEventListener("click", captureAndSaveImage);
</script>


<script src="avatar.js"></script>
</body>
</html>

