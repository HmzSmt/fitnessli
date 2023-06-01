<!DOCTYPE html>
<html>
<head>
    <title>Guess the Number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            font-size: 24px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-bottom: 20px;
        }

        button {
            padding: 12px 20px;
            background-color: #8a2be2 ;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: violet ;  /* Violet foncé au survol */
        }

        #result {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <button onclick="goToHome()">Accueil</button>
    <h1>Guess the Number</h1>
    <p>Devinez un nombre entre 1 et 100:</p>
    <input type="text" id="guessInput">
    <button onclick="checkGuess()">Devinez</button>
    <p id="result"></p>

    <script>
        // Choix d'un nombre aléatoire entre 1 et 100
        const randomNumber = Math.floor(Math.random() * 100) + 1;
        
        function checkGuess() {
            // Récupération de la valeur devinée par le joueur
            const guessInput = document.getElementById("guessInput");
            const guess = parseInt(guessInput.value);

            // Vérification si la valeur est correcte, plus grande ou plus petite
            if (guess === randomNumber) {
                document.getElementById("result").textContent = "Bravo ! Vous avez deviné le nombre.";
            } else if (guess < randomNumber) {
                document.getElementById("result").textContent = "Le nombre est plus grand.";
            } else {
                document.getElementById("result").textContent = "Le nombre est plus petit.";
            }

            // Réinitialisation de l'input
            guessInput.value = "";
        }

        function goToHome() {
            window.location.href = "../index.php";
        }
    </script>
</body>
</html>
