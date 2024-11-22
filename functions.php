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
        'footer-menu' => __('Menu du footer', 'text-domain'),
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');

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


//fonction en rapport avec charger plus 
// fonction pour gerer les filtres 

// Fonction pour charger les photos via AJAX
function load_photos_ajax_handler() {
    // Vérifier si les paramètres sont envoyés via AJAX
    if (isset($_POST['filters'])) {
        $filters = $_POST['filters'];

        // Définir les arguments de la requête WP_Query
        $args = array(
            'post_type' => 'photos', // Assurez-vous que votre CPT est bien 'photos'
            'posts_per_page' => 8,   // Nombre de photos par page
            'paged' => $filters['page'], // La page de photos à charger
            'orderby' => 'date',     // Trier par date
            'order' => ($filters['date'] === 'asc' ? 'ASC' : 'DESC'), // Tri par date
            'tax_query' => array('relation' => 'AND'),
        );

        // Filtrer par catégorie
        if (!empty($filters['categorie'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $filters['categorie'],
            );
        }

        // Filtrer par format
        if (!empty($filters['format'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $filters['format'],
            );
        }

        // Requête WP_Query pour récupérer les photos
        $photos_query = new WP_Query($args);

        // Vérifier si des photos sont trouvées
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
            endwhile;  // Assurez-vous que cette ligne est bien fermée
        else :
            echo '<p>Aucune photo à afficher.</p>';
        endif;

        // Réinitialiser la requête WP
        wp_reset_postdata();
    }

    // Terminer correctement l'exécution AJAX
    wp_die();
}

// Ajouter les actions pour AJAX pour utilisateurs connectés et non connectés
add_action('wp_ajax_load_photos', 'load_photos_ajax_handler');
add_action('wp_ajax_nopriv_load_photos', 'load_photos_ajax_handler');

function afaf_enqueue_scripts() {
    // Enregistrement et inclusion du script
    wp_enqueue_script(
        'custom-script', // Identifiant unique pour le script
        get_template_directory_uri() . '/js/script.js', // Chemin vers le fichier
        array('jquery'), // Dépendances (ajoute 'jquery' si nécessaire)
        '1.0', // Version du script
        true // Charger dans le footer (true) ou le header (false)
    );
    wp_localize_script( 'custom-script', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ));

}
add_action('wp_enqueue_scripts', 'afaf_enqueue_scripts');


