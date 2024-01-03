
<div class="thumbnail" data-id="<?php echo get_the_ID(); ?>">
    <?php the_post_thumbnail('full'); ?>
    <div class="thumbnail-hover">
        <!-- Overlay pour les éléments interactifs au survol -->
        <div class="thumbnail-hover__overlay">
            <!-- Icône œil avec lien vers la page de l'article -->
            <div class="thumbnail-hover__eye">
                <a href="<?php echo esc_url(get_permalink()); ?>" class="thumbnail-hover__link">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/Icon_eye.png"
                        alt="icon-eye">
                </a>
            </div>
            <!-- Icône d'agrandissement -->
            <div class="thumbnail-hover__expand">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/Icon_fullscreen.png"
                    alt="Agrandir">
            </div>
        </div>
        <!-- Informations supplémentaires au survol -->
        <div class="thumbnail-hover__info">
            <!-- Affichage de la référence de la photo -->
            <div class="thumbnail-hover__ref">
                <span>
                    <?php echo get_post_meta(get_the_ID(), 'Références', true); ?>
                </span>
            </div>
            <!-- Affichage de la catégorie de la photo -->
            <div class="thumbnail-hover__category disable-link">
                <span>
                    <?php echo get_the_term_list(get_the_ID(), 'categorie', '', ', '); ?>
                </span>
            </div>
            <!-- Affichage du type de photo -->
            <div class="thumbnail-hover__type">
                <?php
                $type = get_field('type');
                if ($type) {
                    echo 'Type : ' . $type;
                }
                ?>
            </div>
        </div>
    </div>
</div>