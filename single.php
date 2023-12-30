<?php get_header(); ?>
<!-- Inclut le fichier d'en-tête du thème -->

<div class="single-post-container">
    <!-- Div pour contenir le contenu de l'article -->

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <!-- Vérifie s'il y a des articles à afficher -->

        <div class="post-content">
            <!-- Div pour contenir le contenu de l'article -->

            <!-- Affiche le titre de l'article -->
            <h1 class="post-title"><?php the_title(); ?></h1>

            <!-- Affiche l'image mise en avant (featured image) de l'article -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

            <!-- Affiche le contenu de l'article -->
            <div class="post-text">
                <?php the_content(); ?>
            </div>

        </div>

    <?php endwhile; else: ?>
        <!-- Si aucun article n'est trouvé -->

        <p><?php _e('Sorry, this page does not exist.'); ?></p>
        <!-- Affiche un message d'erreur -->

    <?php endif; ?>

</div>

<?php get_footer(); ?>
<!-- Inclut le fichier de pied de page du thème -->