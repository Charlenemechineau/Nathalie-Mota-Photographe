<?php
// Fonction pour enregistrer les emplacements de menu//
function register_my_menus() {
    register_nav_menus(
        array(
            'primary' => __( 'Menu principal' ),
            'footer' => __( 'Menu du pied de page' )
        )
    );
}

// Appele la fonction pour enregistrer les menus//
add_action('init', 'register_my_menus');

// Fonction pour charger les styles et scripts du thème
function theme_enqueue_styles() {
    // Enregistrement du style
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

    // Enregistrement des scripts
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est inclus en premier
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('lightbox', get_stylesheet_directory_uri() . '/lightbox.js', array(), '1.0.0', true);

    // Vérifier si la page est la page d'accueil
    if (is_home()) {
        // Enregistrement du script Ajax uniquement sur la page d'accueil
        wp_enqueue_script('mota-ajax-script', get_stylesheet_directory_uri() . '/ajax.js', array('jquery'), '1.0', true);

        // Données à envoyer au script Ajax
        $data = array(
            'rest_url_custom_pagination_photo' => esc_url_raw(rest_url('mota-custom/v1/photo')),
        );

        // Ajoute les données en ligne pour le script Ajax
        wp_add_inline_script('mota-ajax-script', sprintf('let ajax_object = %s;', wp_json_encode($data)), 'before');
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Configuration du thème//
function mota_setup() {
    // Activer la prise en charge des images mises en avant (thumbnails)//
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mota_setup' );

// Configuration de l'API REST personnalisée//
function mota_rest_api_init() {
    // Enregistrement de la route personnalisée "mota-custom/v1/photo"//
    register_rest_route( 'mota-custom/v1', '/photo', array(
        'methods' => 'GET', // Méthodes HTTP autorisées pour cette route (GET dans ce cas)//
        'callback' => 'mota_rest_api_photo_handler', // Fonction de rappel qui sera exécutée lors de l'appel à la route//
        'permission_callback' => '__return_true', // Autorisation pour accéder à cette route (ici, tout le monde a accès)//
        'args' => array(
            'page' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
            'photo_categories' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                }
            ),
            'formats' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                }
            ),
            'order' => array(
                'default' => 'DESC', // Valeur par défaut si non défini
                'validate_callback' => function($param, $request, $key) {
                    return in_array($param, array('ASC', 'DESC'));
                }
            )
        )
    ) );
}
add_action( 'rest_api_init', 'mota_rest_api_init' );

// Gestionnaire pour l'API REST personnalisée//
function mota_rest_api_photo_handler( $request ) {
    // Arguments pour la requête WP_Query//
    $args = array(
        'post_type' => 'photo',
        'paged' => $request['page'],
        'posts_per_page' => get_option('posts_per_page'),
        'orderby' => 'date',
        'order' => $request['order']
    );

    // Taxonomies à filtrer//
    $tax_query = array();
    
    // Filtrer par catégories de photos//
    if ( ! empty( $request['photo_categories'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $request['photo_categories'],
        );
    }
    
    // Filtrer par formats de photos//
    if ( ! empty( $request['formats'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $request['formats'],
        );
    }
    
    // Ajoute les filtres taxonomiques à la requête si définis//
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    // Effectue la requête WP_Query//
    $query = new WP_Query( $args );

    // Tampon de sortie pour collecter le HTML généré//
    ob_start();
    
    // Si des articles sont trouvés, les parcourir et inclure le template correspondant//
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'templates_parts/photo_block' );
        }
    }

    // Récupére le contenu du tampon de sortie//
    $output = ob_get_contents();//

    // Vide le tampon de sortie//
    ob_end_clean();

    // Mettre à jour le numéro de page pour la prochaine requête//
    $args['paged'] = $request['page'] + 1;

    // Effectue une nouvelle requête pour déterminer s'il y a plus d'articles//
    $query = new WP_Query( $args );
    $post_next_page = $query->have_posts(); 

    // Retourne la réponse WP_REST avec le HTML généré et l'indicateur pour plus d'articles
    return new WP_REST_Response( array('html' => $output, 'post_next_page'=>$post_next_page), 200 );
}

// Ajout du plugin Select2
function theme_enqueue_scripts() {
    wp_enqueue_style(
        'select2',  
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    );

    wp_enqueue_script(
        'select2',  
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 
        array('jquery'), 
        '4.1.0-rc.0', 
        true 
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');