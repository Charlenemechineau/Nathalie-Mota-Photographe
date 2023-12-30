<?php get_header(); ?>
<main class="main-body">

<?php
// Arguments de la requête pour obtenir une image aléatoire du type de contenu 'photo'//
$random_image_args = array(
    'post_type' => 'photo',     // Type de contenu personnalisé
    'posts_per_page' => 1,      // Limite le nombre de résultats à 1
    'orderby' => 'rand'         // Tri aléatoire
);

// Initialisation de la requête WP_Query
$random_image_query = new WP_Query($random_image_args);

// Vérifier si la requête a des résultats
if ($random_image_query->have_posts()) {
    // Boucle à travers les résultats //
    while ($random_image_query->have_posts()) {
        $random_image_query->the_post();
        // Récupérer l'URL de l'image à la une en taille complète ('full') //
        $background_image_url = get_the_post_thumbnail_url(null, 'full');
    }

    // Réinitialisation des données de la requête principale //
    wp_reset_postdata();
}
?>

<!-- Section du héros avec l'image de fond aléatoire -->
<div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
    <h1><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/title.png" alt="title"></h1>
</div>

<?php
// Arguments de la requête WP_Query pour récupérer les articles de type 'photo'//
$args = array(
    'post_type' => 'photo',
);

// Initialiser la requête WP_Query avec les arguments définis //
$query = new WP_Query( $args );

// Stocker la requête dans une variable globale pour une utilisation ultérieure//
global $query_lightbox;
$query_lightbox = $query;
?>


<?php if ($query->have_posts()) : ?>
    <!-- Div pour les filtres des photos -->
    <div class="filters-photos">
        <div class="filters">

            <?php
            // Récupérer les catégories de la taxonomie 'photo-categories'
            $photo_categories = get_terms(array(
                'taxonomy' => 'categorie',
                'hide_empty' => true,
            ));
            ?>

        <?php if (!empty($photo_categories) && !is_wp_error($photo_categories)) : ?>
        <!-- Sélecteur pour les catégories -->
            <div class="tt-select">
                <select name="photo-category" id="photo-category-select" class="custom-select">
                    <option value="" disabled selected>Catégories</option>

                    <?php foreach ($photo_categories as $category) : ?>
                        <?php if ($category->slug !== 'categories') : ?>
                            <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

            <?php
            // Récupérer les termes de la taxonomie 'formats'//
            $formats = get_terms(array(
                'taxonomy' => 'format',
                'hide_empty' => true,
            ));
            ?>

        <?php if (!empty($formats) && !is_wp_error($formats)) : ?>
        <!-- Sélecteur pour les formats -->
            <div class="tt-select">
                <select name="format" id="format-select" class="custom-select">
                
                    <option value="" disabled selected>Formats</option>

                    <?php foreach ($formats as $format) : ?>
                        <?php if ($format->slug !== 'formats') : ?>
                            <option value="<?php echo esc_attr($format->slug); ?>">
                        <?php echo esc_html($format->name); ?>
                             </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
             </div>
        <?php endif; ?>

        </div>

        <!-- Sélecteur pour trier les articles -->
        <div class="sort-by-container">
            <select id="sort-by" name="sort-by" class="custom-select">
                <option value="" disabled selected>Trier par</option>
                <option value="DESC">Plus récent</option>
                <option value="ASC">Plus ancien</option>
            </select>
        </div>

    </div>

    <div class="main-page">
        <!-- Conteneur pour les miniatures des photos -->
        <div class="thumbnail-container" id="photos-list">
            <?php while($query->have_posts()) : ?>
                <?php $query->the_post(); ?>
                <?php get_template_part('templates_parts/photo_block' ); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>

<?php else : ?>
    <!-- Message s'il n'y a pas d'articles correspondants -->
    <p>Désolé, aucun article ne correspond à cette requête</p>  
<?php endif; ?>

<!-- Bouton "Charger plus" pour charger d'autres articles -->
<div class="load-more-btn">
    <button id="load-more-btn">Charger plus</button>
</div>

</div>

</main>

<!-- Pied de page -->
<div class="footer-test">
    <?php get_footer(); ?> 
</div>
