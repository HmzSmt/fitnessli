<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/programme.css" type="text/css" media="screen" />
    <title>Push Up</title>
    <style>
        body {
        background-color: #ECC9EE;
        
        
        }
        /* Styles de boutons */
        #prevBtn, #nextBtn {
            background-color: #BE9CC7;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        #prevBtn:hover, #nextBtn:hover {
            background-color: #872e7e;
        }

        #prevBtn:disabled, #prevBtn[disabled], #nextBtn:disabled, #nextBtn[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #prevBtn {
            float: left;
        }

        #nextBtn {
            float: right;
        }
        .intro {
        background-color: #ead4f8;
        padding: 20px;
        }

        h1, h2 {
        color: #6a1b9a;
        font-size: 36px;
        text-align: center;
        }

        p {
        font-size: 18px;
        color: #4a148c;
        line-height: 1.5;
        }

        span {
        font-weight: bold;
        font-size: 24px;
        color: #7b1fa2;
        }

        /* Program section */
        section#program {
        background-color: #cea7e6;
        padding: 30px;
        text-align: center;
        }

        h3 {
        font-size: 24px;
        color: #7b1fa2;
        margin-bottom: 20px;
        }

        .program-list {
        list-style: none;
        margin: 0;
        padding: 0;
        }

        .program-item {
        background-color: #e1bee7;
        padding: 10px;
        margin-bottom: 10px;
        }

        .program-item span {
        color: #4a148c;
        font-weight: bold;
        font-size: 18px;
        }
        header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f2f2f2;
        height: 80px;
        padding: 0 20px;
        }

        #div_logo {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        }

        #logo {
        max-height: 50px;
        }

        #paramettre {
        margin-right: 20px;
        }

        #logo_paramettre {
        max-height: 30px;
}
    </style>
</head>
<body>
<header>
<a href="../../recup.php" class="home-button">Accueil</a>
</header>
<section id="intro">
    <div>
       <h1>Découvrez comment les push-ups peuvent transformer votre corps !</h1>
        
        <p>
        Cet exercice polyvalent utilise votre poids corporel pour renforcer les muscles du haut du corps, 
        améliorer votre posture et augmenter votre endurance cardiovasculaire. 
        <br>
        Suivez notre programme de push-up pour voir des résultats rapides et atteindre votre meilleure forme physique. 
        <br>
        Êtes-vous prêt à relever le défi ?
        </p>
    </div>
</section>

<section id="programme">
    <div id="intro">
        <h1>Programme de Push Up</h1>
        <p>Le programme de push-up ci-dessous est conçu pour vous aider à améliorer votre force et votre endurance.</p>
    </div>
    <div id="exercices">
        
        <!-- Le programme du jour -->
        
        
        <video controls id='myVideo'>
            <source src='../vidéos/pushup5.mp4' type='video/mp4'>
        </video>
        
    </div>
    <button id='prevBtn' style='display: none;'>Précédent</button>
        <button id='nextBtn'>Suivant</button>

        <script>
            const videos = [
                '../vidéos/pushup5.mp4',
                '../vidéos/pushup6.mp4',
                '../vidéos/pushup5.mp4',
                '../vidéos/pushup6.mp4',
            ];

            let currentVideoIndex = 0;
            const videoPlayer = document.getElementById('myVideo');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');

            nextBtn.addEventListener('click', function() {
                currentVideoIndex++;
                if (currentVideoIndex >= videos.length) {
                    currentVideoIndex = 0;
                }
                videoPlayer.querySelector('source').src = videos[currentVideoIndex];
                videoPlayer.load();
                if (currentVideoIndex > 0) {
                    prevBtn.style.display = 'inline-block';
                }
            });

            prevBtn.addEventListener('click', function() {
                currentVideoIndex--;
                if (currentVideoIndex < 0) {
                    currentVideoIndex = videos.length - 1;
                }
                videoPlayer.querySelector('source').src = videos[currentVideoIndex];
                videoPlayer.load();
                if (currentVideoIndex === 0) {
                    prevBtn.style.display = 'none';
                }
            });
        </script>
</section>
        </body>
</html>
