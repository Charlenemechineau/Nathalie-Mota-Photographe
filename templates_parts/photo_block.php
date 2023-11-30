
<div class="thumbnail" data-id="<?php echo get_the_ID(); ?>">
    <?php the_post_thumbnail('full'); ?>

        <!-- Div pour afficher des informations supplémentaires au survol -->
        <div class="thumbnail-hover__info">

            <!-- Affiche la référence de la photo -->
            <div class="thumbnail-hover__ref">
                <span><?php echo get_post_meta(get_the_ID(), 'references', true); ?></span>
            </div>

            <!-- Affiche la catégorie de la photo -->
            <div class="thumbnail-hover__category disable-link">
                <span><?php echo get_the_term_list(get_the_ID(), 'categorie', '', ', '); ?></span>
            </div>
            <!-- Affiche le type de la photo -->
            <div class="thumbnail-hover__type">
                <?php $type = get_field('type');
                if ($type) {
                echo 'Type : ' . $type;
        }
    ?>
        </div>
        </div>

    </div>
</div>
