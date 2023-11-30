<?php get_header(); ?>
<div class="single-post-container">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="post-content">

        <div class="first-section">

            <div class="title_ref">

                <div class="title">
                    <!-- Affiche le titre de la photo -->
                    <h1 class="post-title line-break-title"><?php the_title(); ?></h1>
                </div>

                <div class="ref">
                    <div class="post-reference">
                        <?php
                        // Récupère et affiche la référence de la photo
                        $reference = get_field('ref');
                        if ($reference) {
                            echo 'Référence : ' . $reference;
                        }
                        ?>
                    </div>

                    <div class="photo-category">
                        <?php
                        // Récupère et affiche la catégorie de la photo
                        $terms = get_the_terms(get_the_ID(), 'categorie');
                        if ($terms && !is_wp_error($terms)) {
                            echo 'Catégorie : ';
                            foreach ($terms as $term) {
                                echo $term->name . ' ';
                            }
                        }
                        ?>
                    </div>

                    <div class="post-format">
                        <?php
                        // Récupère et affiche le format de la photo
                        $terms = get_the_terms(get_the_ID(), 'format');
                        if ($terms && !is_wp_error($terms)) {
                            echo 'Format : ';
                            foreach ($terms as $term) {
                                echo $term->name . ' ';
                            }
                        }
                        ?>
                    </div>

                    <div class="post-type">
                        <?php
                        // Récupère et affiche le type de la photo
                        $type = get_field('Type');
                        if ($type) {
                            echo 'Type : ' . $type;
                        }
                        ?>
                    </div>

                    <div class="post-year">
                        <?php
                        // Affiche l'année de publication de la photo
                        echo 'Année : ' . get_the_date('Y');
                        ?>
                    </div>

                </div>
            </div>
            
            <!-- Affiche l'image à la une (thumbnail) de la photo -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            
        </div>

        <!-- Affiche le contenu principal de la photo -->
        <div class="post-text">
            <?php the_content(); ?>
        </div>

        <div class="second-section">

            <div class="CTA">
                <!-- Message d'appel à l'action -->
                <p>Cette photo vous intéresse ?</p>
                <!-- Bouton de contact -->
                <a class="contact-button" href="#">Contact</a>
            </div>

            <div class="photo-navigation">
                <?php
                // Récupère les photos précédente et suivante
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>

                <div class="arrow-left-thumbnail">
                    <!-- Affiche la photo précédente -->
                    <?php if (!empty($prev_post)) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="custom-prev-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-left.png" class="arrow" data-direction="previous" alt="Previous"></a>
                        <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail', array('class' => 'mini-thumbnail')); ?>
                    <?php endif; ?>
                </div>

                <div class="arrow-right-thumbnail">
                    <!-- Affiche la photo suivante -->
                    <?php if (!empty($next_post)) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="custom-next-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/arrow-right.png" class="arrow" data-direction="next" alt="Next"></a>
                        <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail', array('class' => 'mini-thumbnail')); ?>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    <!-- Titre pour la section des photos apparentées -->
<p>VOUS AIMEREZ AUSSI</p>

<!-- Troisième section avec les photos apparentées -->
<div class="third-section double-photos">

    <!-- Conteneur pour les miniatures des photos apparentées -->
    <div class="thumbnail-container">

        <?php
        // Récupère les termes (catégories) de l'article en cours
        $terms = get_the_terms(get_the_ID(), 'categorie');

        // Vérifie si des termes ont été récupérés et qu'il n'y a pas d'erreur
        if ($terms && !is_wp_error($terms) && is_array($terms) && !empty($terms)) {
            // Utilise le premier terme pour filtrer les photos apparentées
            $first_category = $terms[0]->slug;
        } else {
            // Si aucune catégorie n'est trouvée, utilise une catégorie par défaut
            $first_category = 'categorie-par-defaut';
        }

        // Arguments pour la requête des photos apparentées
        $args = array(
            'post_type' => 'photo',
            'post__not_in' => array(get_the_ID()), // Exclut la photo actuelle de la liste
            'posts_per_page' => 2, // Limite le nombre de photos à afficher à 2
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug',
                    'terms'    => $first_category,
                ),
            ),
        );

        // Initialise la requête WP_Query
        $query = new WP_Query($args);

        // Stocke la requête pour une utilisation ultérieure si nécessaire
        global $query_lightbox;
        $query_lightbox = $query;
        ?>

        <?php
        // Boucle WordPress pour afficher les photos apparentées
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="thumbnail">
                <?php
                // Utilise le modèle de bloc photo pour afficher chaque miniature
                get_template_part('templates_parts/photo_block');
                ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Bouton pour voir toutes les photos -->
    <div class="all-photos">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="all-photos-button">Toutes les photos</a>
    </div>
</div>
<!-- Fin de la boucle WordPress -->

<?php
// Fin de la structure WordPress
endwhile;
else:
?>

<!-- Message si la page n'existe pas -->
<p><?php _e('Désolé, cette page n\'existe pas.'); ?></p>

<?php endif; ?>

<!-- Fin du conteneur principal -->
</div>

<!-- Appel de la fonction pour afficher le pied de page -->
<?php get_footer(); ?>