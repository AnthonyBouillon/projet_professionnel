/* CE QUE J'AI PAS COMPRIS == PROP, ATTR  */

/* Execute le javascript quand le DOM à fini de charger */
$(document).ready(function () {
    /*
     *  Quand le champ des formulaires est focus
     *  On change la couleur du fond en orange
     *  Quand le champ des formulaires perd le focus
     *  On change la couleur du fond en blanc/gris
     */
    $('.focusColor').focus(function () {
        $(this).css('background-color', '#F9F079');
    });
    $('.focusColor').blur(function () {
        $(this).css('background-color', '#ffffff');
    });
    /*
     *  Script permettant pour l'utilisateur de voir le mot de passe
     *  Assigne l'id de la checkBox et des champs password dans une variable
     *  La fonction prend effet au moment du clique
     *  Quand la checkbox est coché
     *  Les champs de type password deviennent des types text
     *  Sinon (si elle est décoché)
     *  Les champs de type text deviennent des types password
     */
    var checkbox = $('#checkbox');
    var password = $('.showPassword');
    var confirmPassword = $('.confirmPassword');
    checkbox.click(function () {
        if (checkbox.prop("checked")) {
            password.attr('type', 'text');
            confirmPassword.attr('type', 'text');
        } else {
            password.attr('type', 'password');
            confirmPassword.attr('type', 'password');
        }
    });
    /* 
     *  Script permettant d'avoir un décompte de 5 secondes
     *  Assigne à la variable la valeur de 5
     *  Une fonction qui lance un traitement répété à intervalle régulier
     *  Si le nombre est supérieur à 0
     *  Il décrémente de 1
     *  Et il affiche dans la balise #chrono le texte contenu dans la variable number
     *  Toutes les 1 secondes, exécute la fonction
     */
    var number = 5;
    setInterval(function () {
        if (number > 0) {
            number--;
            $('#chrono').text(number);
        }
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
     *  Page modification de profil
     *  Permet de changer le bouton actif de proprietaire au clique
     *  La fonction démarre au clique
     *  La classe btn-info est supprimer et on ajoute à la place la classe btn-defaut
     *  et visse versa
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
    /*
     * Script pour la page d'accueil permettant d'afficher ou de faire disparaitre un block de text au clique
     * Quand je clique sur le titre
     * Un block de texte apparait ou disparait
     */
    $('#flip1').click(function () {
        $('#panel1').slideToggle('slow');
    });
    $('#flip2').click(function () {
        $('#panel2').slideToggle('slow');
    });
    /* Faire apparaitre une info bulle */
    $('[data-toggle="popover"]').popover();
});
/* 
 * Script pour le tchat de la page d'accueil, permettant de récupérer et d'afficher les messages sans recharger la page
 * 
 * Quand je clique sur le bouton
 * On annule la soumission de celui-ci
 * De type POST
 * On précise le chemin de notre controller
 * On récupère la valeur du textarea
 * 
 * On efface les messages
 * Si la valeur du pseudo n'est pas null on affiche le nom, et le message
 * Sinon juste le message
 */
$('#sendMessage').click(function (e) {
    e.preventDefault();
    $.post(
            '../../controllers/homeController.php', {
                message: $('#ChatMessage').val(),
                ajaxReady: 'ready'
            },
            function (data) {
                $('#receiveMessage').empty();
                $.each(JSON.parse(data), function (index, value) {
                    if (value.username != null) {
                        $('#receiveMessage').append('<div class="well"><p class="bold">' + value.username + ' à écrit :</p><p>' + value.message + '</p><p>Message datant du : <span class="bold">' + value.date + '</span></p></div>')
                    } else {
                        $('#receiveMessage').append('<div class="well"><p class="bold">' + 'Visiteur' + ' à écrit :</p><p>' + value.message + '</p><p>Message datant du : <span class="bold">' + value.date + '</span></p></div>')
                    }
                });
            }
    ),
            'JSON',
            $('#ChatMessage').val('')
});
setInterval(function () {
    $('#receiveMessage').load('views/chat.php').fadeIn("slow");
}, 0);
