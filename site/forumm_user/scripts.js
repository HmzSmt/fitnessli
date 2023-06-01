$(document).ready(function() {
    // Vérifiez ici si l'utilisateur a déjà un pseudo
    // Si ce n'est pas le cas, affichez la fenêtre modale
    $('#modalPseudo').show();

    // Lorsque l'utilisateur clique sur le bouton "Valider"
    $('#submitPseudo').click(function() {
        // Récupérez le pseudo saisi par l'utilisateur
        var pseudo = $('#pseudo').val();
        if (pseudo) {
            // Envoyez le pseudo au serveur pour le stocker dans la base de données
            $.ajax({
                url: 'enregistrer_pseudo.php',
                type: 'POST',
                data: {pseudo: pseudo},
                success: function(response) {
                    // Vérifiez si l'enregistrement du pseudo a réussi
                    if (response === 'success') {
                        $('#modalPseudo').hide();
                    } else {
                        // Affichez un message d'erreur si l'enregistrement a échoué
                        alert('Erreur lors de l\'enregistrement du pseudo. Veuillez réessayer.');
                        console.log('Erreur de réponse : ' + response); // Ajoutez cette ligne
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Erreur AJAX : " + textStatus + " " + errorThrown); // Ajoutez cette ligne
                }
            });
        }
    });
});
