<div class="modal-container">
    <!-- Overlay pour l'arrière-plan de la modale -->
    
    
<div class="overlay modal-trigger"></div>
    <!-- Conteneur principal de la modale -->
    <div class="modal">
        
       
<!-- Logo du haut de la modale -->
<div class="close-modal modal-trigger"></div>
        <h1><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/contact-header.png" alt="Logo"></h1>
        <!-- Insertion du formulaire de contact -->
        <?php echo do_shortcode('[contact-form-7 id="0aa5616" title="formulaire pour modal"]'); ?>
    </div>
</div>

