/*
 * Concernent tout les champs des formulaires
 * Change la couleurs des champs suivant si il est focus ou non
 */
// La fonction s'exécute une fois le html chargé
$(document).ready(function () {
    // Si le champ est focus
    $('.focusColor').focus(function () {
        // Change la couleur du fond en orange
        $(this).css('background-color', '#F9F079');
    });
    // Si le champ perd le focus
    $('.focusColor').blur(function () {
        // Change la couleur du fond en blanc/gris
        $(this).css('background-color', '#ffffff');
    });
    
    /*
     * Concernent les formulaires contenant un champs password
     * Script permettant de voir le mot de passe
     */
    // Assigne l'id des éléments dans une variable
    var checkbox = $('#checkbox');
    var password = $('.showPassword');
    var confirmPassword = $('.confirmPassword');
    // Quand je click sur la checkbox
    checkbox.click(function () {
        // Si la checkbox est coché
        if (checkbox.prop("checked")) {
            // Les champs de type password deviennent des types text
            password.attr('type', 'text');
            confirmPassword.attr('type', 'text');
            // Sinon (si elle est décoché)
        } else {
            // Les champs de type text deviennent des types password
            password.attr('type', 'password');
            confirmPassword.attr('type', 'password');
        }
    });

    /* 
     *  Page ayant un décompte à afficher
     *  Décompte de 5 secondes
     */
    // Assigne à la variable la valeur de 5
    var number = 5;
    // Une fonction qui lance un traitement répété à intervalle régulier
    setInterval(function () {
        // Si le nombre est supérieur à 0
        if (number > 0) {
            // Il décrémente
            number--;
            // Et il affiche dans la balise #chrono le texte contenu dans la variable number
            $('#chrono').text(number);
        }
        // Toutes les 1 secondes, exécute la fonction
    }, 1000);

    /* 
     * Page news formulaire commentaire 
     * Au clique sur le bouton la div contenant le formulaire apparait
     */
    $('.editBtn').click(function () {
        var idComment = $(this).attr('idComment');
        $('#divUpdate' + idComment).slideToggle();
    });


    /*
     * Page modification de profil
     * Permet de changer le bouton actif de proprietaire au clique
     */
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-info").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-info");
    });

    /*
     * Page forum 
     * Fait apparaitre ou disparaitre une div contenant un formulaire
     */
    $('#addForum').click(function () {
        if ($('.divForum').css('display', 'none')) {
            $('.divForum').css('display', 'block');
        }
    });
    $('.displayForm').click(function () {
        var id = $(this).attr('id');
        $('#divForum' + id).toggle();
    });

});

$('#flip1').click(function(){
    $('#panel1').slideToggle('slow');

}); 
$('#flip2').click(function(){
    $('#panel2').slideToggle('slow');

}); 
 $('[data-toggle="popover"]').popover(); 
/* test ajax connexion username password submit */
$('#sendMessage').click(function(e){
e.preventDefault();
    $.post(
           '../../controllers/homeController.php',{          
               message : $('#message').val(),
               ajaxReady : 'ready'
           },
                   function(data){
                       $('#receiveMessage').empty();
                       $.each(JSON.parse(data), function(index, value){
                           $('#receiveMessage').append('<div class="well"><p class="bold">' + value.username + ' à écrit :</p><p>' + value.message + '</p><p>Message datant du : <span class="bold">' + value.date + '</span></p></div>')
                       });
                   }            
            ),
    'JSON',
   $('#message').val('')
});




            