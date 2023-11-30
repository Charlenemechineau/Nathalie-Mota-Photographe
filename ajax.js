// Appel AJAX pour le bouton "Charger plus" et les filtres//
jQuery(document).ready(function($) {
    // Initialise les variables de suivi de l'état//
    let currentPage = 1;
    let currentCategory = "";
    let currentFormat = "";
    let order = "";

    // Gestion du clic sur le bouton "charger plus"//
    $('#load-more-btn').on('click', function() {
        // Augmente le numéro de la page actuelle//
        currentPage++;
        // Appelle la fonction ajax_request pour charger plus de contenu//
        ajax_request(currentCategory, currentFormat, order, false);
    });

    // Gestion de la catégorie de photo
    $('#photo-category-select').on('change', function() {
        // Mise à jour de la catégorie sélectionnée//
        currentCategory = $(this).val();
        // Réinitialisation de la page à 1
        currentPage = 1;
        // Appelle la fonction ajax_request pour charger le contenu correspondant à la nouvelle catégorie//
        ajax_request(currentCategory, currentFormat, order, true);
    });

    // Gestion du changement du format de photo//
    $('#format-select').on('change', function() {
        // Mise à jour du format sélectionné//
        currentFormat = $(this).val();
        // Réinitialisation de la page à 1//
        currentPage = 1;
        // Appelle la fonction ajax_request pour charger le contenu correspondant au nouveau format//
        ajax_request(currentCategory, currentFormat, order, true);
    });

    

    // Fonction qui effectue la requête Ajax//
    function ajax_request(category, format, order, replace) {
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
        if (order) {
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

                // Remplace ou ajoute le contenu en fonction du paramètre 'replace'//
                if (replace) {
                    $("#photos-list").html(response.html);
                } else {
                    $("#photos-list").append(response.html);
                }

                // Affiche ou cache le bouton "Charger plus" en fonction de la disponibilité de la page suivante/
                if (response.post_next_page) {
                    $('#load-more-btn').show();
                } else {
                    $('#load-more-btn').hide();
                }
            },
            error: function(response) {
                // Affiche les erreurs dans la console à des fins de débogage
                console.log('error', response);
            }
        });
    }
});