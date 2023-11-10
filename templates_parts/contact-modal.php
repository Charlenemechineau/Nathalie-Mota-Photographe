<div class="modal-container">

  <div class="overlay modal-trigger"></div>
  
  <div class="modal">
    <h1><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/Contact-header.png" alt="Logo"></h1>
    <?php
		echo do_shortcode('[contact-form-7 id="0aa5616" title="formulaire pour modal"]');
	?>
  </div>

</div>