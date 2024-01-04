// LIGHTBOX //

// Fonction pour afficher la lightbox avec une image spécifique
function showLightbox(photo_id) {
  // Sélectionne la lightbox et la rend visible
  var lightbox = document.querySelector('.lightbox');
  lightbox.style.display = 'block';

  // Empêche le défilement de la page lorsque la lightbox est ouverte//
  document.body.style.overflow = 'hidden';

  // Cache toutes les images de la lightbox et retire la classe 'active'//
  var images = lightbox.querySelectorAll(".thumbnail-lightbox");
  images.forEach(image => {
    image.style.display = "none";
    image.classList.remove("active");
  });

  // Affiche l'image spécifique et ajoute la classe 'active'//
  var image = lightbox.querySelector(`.thumbnail-lightbox[data-id="${photo_id}"]`)
  image.style.display = "block";
  image.classList.add("active");
}

// Fonction pour masquer la lightbox//
function hideLightbox() {
  // Sélectionne la lightbox et la rend invisible//
  var lightbox = document.querySelector('.lightbox');
  lightbox.style.display = 'none';

  // Rétablit le défilement de la page//
  document.body.style.overflow = 'auto';
}

// Fonction pour afficher l'image suivante dans la lightbox//
function showNextImage() {
  // Sélectionne l'image active dans la lightbox//
  var activeImage = document.querySelector('.thumbnail-lightbox.active');

  // Sélectionne l'image suivante ou la première si elle n'existe pas//
  var nextImage = activeImage.nextElementSibling;
  if (!nextImage) {
    nextImage = document.querySelector('.thumbnail-lightbox:first-of-type');
  }

  // Désactive l'image actuelle et active l'image suivante//
  activeImage.classList.remove('active');
  nextImage.classList.add('active');

  // Affiche la lightbox avec l'image suivante//
  showLightbox(nextImage.dataset.id);
}

// Fonction pour afficher l'image précédente dans la lightbox//
function showPreviousImage() {
  // Sélectionne l'image active dans la lightbox//
  var activeImage = document.querySelector('.thumbnail-lightbox.active');

  // Sélectionne l'image précédente ou la dernière si elle n'existe pas//
  var previousImage = activeImage.previousElementSibling;
  if (!previousImage) {
    previousImage = document.querySelector('.thumbnail-lightbox:last-of-type');
  }

  // Désactive l'image actuelle et active l'image précédente//
  activeImage.classList.remove('active');
  previousImage.classList.add('active');

  // Affiche la lightbox avec l'image précédente//
  showLightbox(previousImage.dataset.id);
}

// Définit la fonction pour attacher les événements de hover//
function addHoverEventListeners() {
  // Écouteur d'événement pour gérer le survol des images//
  var thumbnails = document.querySelectorAll('.thumbnail');
  thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('mouseenter', function() {
      thumbnail.classList.add('is-hovered');
    });

    thumbnail.addEventListener('mouseleave', function() {
      thumbnail.classList.remove('is-hovered');
    });
  });
}

// écouteur d'événement pour ouvrir la lightbox au clic sur l'icône d'agrandissement
var expandIcons = document.querySelectorAll('.thumbnail-hover__expand');
expandIcons.forEach(expandIcon => {
  expandIcon.addEventListener('click', function(event) {
    event.stopPropagation(); // Empêcher la propagation de l'événement aux éléments parents
    var photoId = expandIcon.closest('.thumbnail').dataset.id;
    showLightbox(photoId);
  });
});

// Déclenche la fonction pour attacher les événements de hover au chargement initial//
addHoverEventListeners();

// Ajoute un écouteur d'événement au chargement du DOM pour le bouton de fermeture//
document.addEventListener('DOMContentLoaded', function () {
    // Sélection du bouton de fermeture dans la lightbox//
    var closeButton = document.querySelector('.lightbox__close');

    // Vérifie si le bouton de fermeture existe avant d'ajouter l'écouteur d'événements//
    if (closeButton) {
        // Ajoute d'un écouteur d'événement au clic sur le bouton de fermeture//
        closeButton.addEventListener('click', function () {
            // Appel de la fonction pour cacher la lightbox//
            hideLightbox();
        });
    }

    // Sélectionne du bouton suivant dans la lightbox//
    var nextButton = document.querySelector('.lightbox__next');

    // Vérification si le bouton suivant existe//
    if (nextButton) {
        // Ajoute d'un écouteur d'événement au clic sur le bouton suivant//
        nextButton.addEventListener('click', function () {
            // Appel de la fonction pour afficher l'image suivante dans la lightbox//
            showNextImage();
        });
    }

    // Sélectionn du bouton précédent dans la lightbox//
    var prevButton = document.querySelector('.lightbox__prev');

    // Vérification si le bouton précédent existe//
    if (prevButton) {
        // Ajoute un écouteur d'événement au clic sur le bouton précédent//
        prevButton.addEventListener('click', function () {
            // Appel de la fonction pour afficher l'image précédente dans la lightbox//
            showPreviousImage();
        });
    }
});
