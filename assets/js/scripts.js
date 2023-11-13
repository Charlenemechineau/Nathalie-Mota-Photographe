document.addEventListener("DOMContentLoaded", function () {
    // Apparition / disparition de la modale de contact au clic de Contacter
    const modalContainer = document.querySelector(".modal-container");

    // pour relier la modale de contact au bouton Contact dans le menu
    const contactTrigger = document.querySelector(".menu-item-13 > a"); // Mise à jour de la classe

    // Ajouter la classe modal-trigger au lien Contact dans le menu
    contactTrigger.classList.add("modal-trigger");

    contactTrigger.

    contactTrigger
addEventListener("click", function (event) {
        event.preventDefault();
        
       
toggleModal();
    });

    function toggleModal() {
        modalContainer.classList.toggle("active");
    }
});