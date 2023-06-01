<!DOCTYPE html>
<html>
<head>
	<title>Ma page</title>
	<style>
		/* Réinitialiser les marges et les rembourrages */
		* {
			margin: 0;
			padding: 0;
		}

		/* Définir la taille de la page */
		html, body {
			height: 100%;
		}

		/* Définir l'espace autour des boîtes */
		.container {
			display: flex;
			flex-direction: column;
			justify-content: center; 
			height: 100%;
			margin: 20px;
			margin-top: 40px; /* Ajouter un espace en haut */
			margin-bottom: 40px; /* Ajouter un espace en bas */
		}

		.box {
		text-align: center;
		font-size: 24px;
		color: white;
		background-color: #000;
		padding: 20px;
		cursor: pointer;
	}

		/* Définir les styles pour chaque boîte */
		.box {
			border: 1px solid #ccc;
			flex: 1;
		}

		/* Définir les couleurs pour chaque boîte */
		.box1 {
  			background-color: #A689E1;
		}

		.box2 {
			background-color: #9966CC;
		}

		.box3 {
			background-color: #562270;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="box box1" onclick="window.location.href = 'series/PushUp1.php'">Premiére series</div>
	<div class="box box2" onclick="window.location.href = 'series/PushUp2.php'">Deuxiéme series</div>
	<div class="box box3" onclick="window.location.href = 'series/PushUp3.php'">Troisiéme series </div>
	</div>
</body>
</html>
