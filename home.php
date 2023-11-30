
<?php get_header(); ?>
<main class="main-body">

<?php
$random_image_args = array(                 // pour obtenir une image aléatoire du catalogue dans le header
    'post_type' => 'photo', 
    'posts_per_page' => 1, 
    'orderby' => 'rand'                     // pour que le tri soit aléatoire
);

$random_image_query = new WP_Query($random_image_args);

if ($random_image_query->have_posts()) {
    while ($random_image_query->have_posts()) {
        $random_image_query->the_post();

        $background_image_url = get_the_post_thumbnail_url(null, 'full');
    }
}

wp_reset_postdata();
?>

<div class="hero" style="background-image: url('<?php echo esc_url($background_image_url); ?>');">
    <h1><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/title.png" alt="title"></h1>
</div>


<?php get_footer(); ?>
