<?php
// Ajouter le support de la barre d'administration
function mon_theme_setup() {
    add_theme_support('admin-bar', array('callback' => '__return_true'));
}
add_action('after_setup_theme', 'mon_theme_setup');


// Enregistrer le menu principal
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menu');

// Enregistrer le menu du footer
function nathaliemota_register_menus() {
    register_nav_menus([
        'footer-menu' => __( 'Menu du footer', 'text-domain' ),
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');


// Enqueue le fichier JavaScript si nécessaire
function mon_theme_enqueue_scripts() {
    wp_enqueue_script(
        'mon-fichier-js',
        get_template_directory_uri() . '/script.js',
        array(),
        filemtime(get_template_directory() . '/script.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_scripts');


function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');

    // Enqueue le fichier script.js avec ajaxurl
    wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/script.js', // Assurez-vous que ce chemin est correct
        array('jquery'),
        null,
        true
    );

    // Passe ajaxurl au script
    wp_localize_script('custom-script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Enregistrer les taxonomies personnalisées
function create_custom_taxonomies() {
    // Taxonomie 'categorie'
    register_taxonomy('categorie', 'photos', array(
        'hierarchical' => true,
        'label' => 'Catégories',
        'singular_label' => 'Catégorie',
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'categorie'),
    ));

    // Taxonomie 'format'
    register_taxonomy('format', 'photos', array(
        'hierarchical' => true,
        'label' => 'Formats',
        'singular_label' => 'Format',
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'format'),
    ));
}
add_action('init', 'create_custom_taxonomies');

// AJAX pour charger les photos avec filtres
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');

function load_photos() {
    // Récupère les filtres
    $filters = isset($_POST['filters']) ? $_POST['filters'] : [];
    $args = [
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => isset($filters['date']) && $filters['date'] == 'asc' ? 'ASC' : 'DESC',
        'paged' => isset($filters['page']) ? $filters['page'] : 1,
    ];

    // Applique les filtres catégorie et format si sélectionnés
    if (!empty($filters['categorie'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $filters['categorie'],
        ];
    }

    if (!empty($filters['format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $filters['format'],
        ];
    }

    // Effectue la requête
    $photos_query = new WP_Query($args);

    // Si des photos sont trouvées, on les affiche
    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();
            ?>
            <div class="photo-accueil-container">
                <div class="photo-accueil">
                    <?php if (get_field('photo')) : ?>
                        <div class="image-accueil">
                            <img src="<?php echo esc_url(get_field('photo')); ?>" alt="<?php the_title(); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        endwhile;
    else :
        echo '<p>Aucune photo à afficher.</p>';
    endif;

    wp_reset_postdata(); // Réinitialiser la requête après avoir affiché les photos
    wp_die(); // Terminer correctement l'exécution AJAX
}
?>
