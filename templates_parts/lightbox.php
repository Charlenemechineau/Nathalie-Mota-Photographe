<?php global $query_lightbox; ?>

<?php if (isset($query_lightbox)): ?>
  <!-- Vérifie si $query_lightbox est défini -->
  <div class="lightbox">
    <button class="lightbox__close">Fermer</button>
    <!-- Bouton pour fermer la lightbox -->

    <button class="lightbox__next">Suivant</button>
    <!-- Bouton pour afficher l'image suivante dans la lightbox -->
    <button class="lightbox__prev">Précédent</button>
    <!-- Bouton pour afficher l'image précédente dans la lightbox -->

    <div class="lightbox__container">
      <!-- Conteneur pour les images de la lightbox -->
      <?php while ($query_lightbox->have_posts()): ?>
        <!-- Boucle sur les articles dans $query_lightbox -->
        <?php $query_lightbox->the_post(); ?>
        <div class="thumbnail-lightbox" data-id="<?php echo get_the_ID(); ?>">
          <!-- Div pour chaque image avec l'ID comme attribut de données -->
          <?php the_post_thumbnail("full"); ?>
          <!-- Affiche l'image en taille complète -->
        </div>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <!-- Réinitialise les données de l'article après la boucle -->
    </div>
  </div>
<?php endif; ?>
<!-- Fin de la condition pour vérifier si $query_lightbox est défini -->