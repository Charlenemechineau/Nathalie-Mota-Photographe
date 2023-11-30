//// Déclarer modalContainer en dehors de la fonction de chargement du DOM////
const modalContainer = document.querySelector(".modal-container");

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner des éléments DOM importants
    const overlay = document.querySelector(".overlay");
    const modal = document.querySelector(".modal");
    const contactTrigger = document.querySelector(".menu-item-13 > a");

    // Ajouter une classe "modal-trigger" au bouton de contact dans le menu principal
    contactTrigger.classList.add("modal-trigger");

    // Ajouter des écouteurs d'événements pour le bouton de contact et les éléments de la modale
    contactTrigger.addEventListener("click", function (event) {
        event.preventDefault();
        toggleModal();
    });

    overlay.addEventListener("click", function (event) {
        event.preventDefault();
        toggleModal();
    });

    modal.addEventListener("click", function (event) {
        event.stopPropagation();
    });

    // Fonction pour basculer l'état actif de la modale//
    function toggleModal() {
        modalContainer.classList.toggle("active");
    }
});

///// Relier la modale de contact au bouton sur le post ACF/////
document.addEventListener("DOMContentLoaded", function () {
    const contactTriggerCPT = document.querySelector(".contact-button");

    // Ajouter un écouteur d'événements pour le bouton de contact sur le post ACF
    if (contactTriggerCPT) {
        contactTriggerCPT.addEventListener("click", toggleModalCPT);
    }
});

/// Fonction pour le bouton de contact sur le post ACF//
function toggleModalCPT() {
    // Ajoutez ici le code pour afficher ou cacher la modale de contact//
    console.log("Bouton contact cliqué !");
}

////// Pour que les titres de plusieurs mots aillent à la ligne //////
const lineBreakTitles = document.querySelectorAll(".line-break-title");
    
lineBreakTitles.forEach(function(title) {
    const words = title.textContent.split(" ");
    title.innerHTML = words.join("<br>");
});

// Pour que le champ REF.PHOTO soit prérempli automatiquement dans la modale de contact //
const contactButton = document.querySelector('.contact-button');
const modalRefField = document.querySelector('input[name="your-subject"]'); // Assurez-vous que le sélecteur est correct

if (contactButton && modalRefField) {
    contactButton.addEventListener('click', function (event) {
        event.preventDefault();

        // Récupérer la référence de la photo depuis l'élément post-reference//
        const referenceElement = document.querySelector('.post-reference');
        const reference = referenceElement ? referenceElement.textContent.trim().replace('Référence : ', '') : '';

        // Préremplir le champ REF.PHOTO dans la modale de contact//
        modalRefField.value = reference;
    });
}