jQuery(document).ready(function($) {
    // Initialise les variables de suivi de l'état
    let currentPage = 1;         // Numéro de la page actuelle
    let currentCategory = "";    // Catégorie actuelle sélectionnée
    let currentFormat = "";      // Format actuel sélectionné
    let order = "";              // Ordre actuel sélectionné
    let response;                // Variable pour stocker la réponse de la requête Ajax

    
    // Écouteur d'événement pour gérer le survol des options dans les sélecteurs//
    $(document).on('mouseenter', '.select2-results__option', function() {
        $(this).addClass('hovered-select');
    });

    $(document).on('mouseleave', '.select2-results__option', function() {
        $(this).removeClass('hovered-select');
    });

    // Initialisez Select2 pour chaque sélecteur avec la recherche désactivée//
    $('#photo-category-select').select2({
    minimumResultsForSearch: -1, // Désactive la recherche//
    placeholder: "" // permet d'avoir une option vide//
    });

    $('#format-select').select2({
    minimumResultsForSearch: -1, // Désactive la recherche//
    placeholder: "" // permet d'avoir une option vide//
    });

    $('#sort-by').select2({
    minimumResultsForSearch: -1, // Désactive la recherche//
    placeholder: "" // Permet d'avoir une option vide//
    });

    // permet de rendre le texte de l'option désactivée vide//
    $('.select2-results__option--disabled').text('');

    // Initialisation de Select2 pour modifier la couleur des selects//
    $('#photo-category-select, #format-select, #sort-by').select2(); 

    // Initialisation de Select2 pour modifier la couleur des selects//
    $('#photo-category-select, #format-select, #sort-by').select2();


    // Gestion du clic sur le bouton "Charger plus"//
    $('#load-more-btn').on('click', function() {
        // Augmente le numéro de la page actuelle//
        currentPage++;
        // Appelle la fonction ajax_request pour charger plus de contenu
        ajax_request(currentCategory, currentFormat, order, false, response);
    });

    // Gestion de la catégorie de photo dans le sélecteur
    $('#photo-category-select').on('change', function() {
        // Mise à jour de la catégorie sélectionnée//
        currentCategory = $(this).val();
        // Réinitialisation de la page à 1
        currentPage = 1;
        // Appelle la fonction ajax_request pour charger le contenu correspondant à la nouvelle catégorie//
        ajax_request(currentCategory, currentFormat, order, true, response);
    });

    // Gestion du changement du format de photo dans le sélecteur//
    $('#format-select').on('change', function() {
        // Mise à jour du format sélectionné//
        currentFormat = $(this).val();
        // Réinitialisation de la page à 1//
        currentPage = 1;
        // Appelle la fonction ajax_request pour charger le contenu correspondant au nouveau format//
        ajax_request(currentCategory, currentFormat, order, true, response);
    });

    // Gestion du changement de l'ordre dans le sélecteur//
    $('#sort-by').on('change', function() {
        // Mise à jour de l'ordre sélectionné//
        order = $(this).val();
        // Réinitialisation de la page à 1//
        currentPage = 1;
        // Appelle la fonction ajax_request pour charger le contenu correspondant au nouvel ordre//
        ajax_request(currentCategory, currentFormat, order, true, response);
    });

    // Fonction qui effectue la requête Ajax//
    function ajax_request(category, format, order, replace, response) {
        // Définit les données à envoyer dans la requête//
        const data = {
            'page': currentPage,
        };

        // Ajoute la catégorie uniquement si elle n'est pas vide//
        if (category) {
            data['photo_categories'] = category;
        }

        // Ajoute le format uniquement s'il n'est pas vide//
        if (format) {
            data['formats'] = format;
        }

        // Ajoute l'ordre uniquement s'il n'est pas vide//
        if (order) {//
            data['order'] = order;
        }

        // Affiche les données dans la console à des fins de débogage//
        console.log("data", data);

        // Effectue la requête Ajax//
        $.ajax({
            url: ajax_object.rest_url_custom_pagination_photo,
            data: data,
            dataType: 'json',
            success: function(response) {
                // Affiche la réponse dans la console à des fins de débogage//
                console.log("response", response);
                console.log("response.html", response.html);
                console.log("response.post_next_page", response.post_next_page);

                // Détachez les événements de hover avant d'ajouter le nouveau contenu//
                $('.thumbnail').off('mouseenter mouseleave');

                // Remplace ou ajoute le contenu en fonction du paramètre 'replace'//
                if (replace) {
                    $("#photos-list").html(response.html);
                } else {
                    $("#photos-list").append(response.html);
                }

                // Réattachez les événements de hover après avoir ajouté le nouveau contenu//
                addHoverEventListeners();

                // Affiche ou cache le bouton "Charger plus" en fonction de la disponibilité de la page suivante//
                if (response.post_next_page) {
                    $('#load-more-btn').show();
                } else {
                    $('#load-more-btn').hide();
                }
            },
            error: function(response) {
                // Affiche les erreurs dans la console à des fins de débogage//
                console.log('error', response);
            }
        });
    }

    // Déclenchez la fonction pour attacher les événements de hover au chargement initial//
    addHoverEventListeners();
});
// Gestion du clic sur les images pour afficher la lightbox
jQuery(document).on('click', '.thumbnail', function() {
    // Récupère l'ID de l'image à afficher dans la lightbox
    var photoId = jQuery(this).data('id');
    // Appelle la fonction pour afficher la lightbox avec l'image spécifique
    showLightbox(photoId);
});