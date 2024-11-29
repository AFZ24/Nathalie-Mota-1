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
    check_ajax_referer('filter_nonce', 'nonce'); // Vérifie la nonciété pour la sécurité

    $filters = isset($_POST['filters']) ? $_POST['filters'] : [];
    $paged = isset($filters['page']) ? intval($filters['page']) : 1;

    $args = [
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => isset($filters['date']) && $filters['date'] === 'asc' ? 'ASC' : 'DESC',
        'tax_query'      => [],
    ];

    // Filtrer par catégorie
    if (!empty($filters['categorie'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($filters['categorie']),
        ];
    }

    // Filtrer par format
    if (!empty($filters['format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($filters['format']),
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
                <div class="photo-accueil">
    <div class="image-accueil">
    <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_url(get_field('photo')); ?>" alt="<?php the_title(); ?>">
        <div class="overlay">
            <div class="photo-info">
                <p class="categorie">
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name); // Affiche le nom de la première catégorie
                    }
                    ?>
                </p>
                <p class="titre">
                    <?php the_title(); // Affiche le titre de la photo ?>
                </p>
            </div>
            <span class="eye-icon" data-info="<?php the_permalink(); ?>"><img class="oeil" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/oeil.png"> </span>
            <span class="fullscreen-icon" data-src="<?php echo esc_url(get_field('photo')); ?>"><img class="fullscreen" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/icon%20fullscreen.png"></span>
        </div>
    </a>
    </div>
    
</div>
                        
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>Aucune photo trouvée.</p>';
        }

        wp_reset_postdata();
        wp_die();
    }
    add_action('wp_ajax_load_photos', 'load_photos_ajax_handler');
    add_action('wp_ajax_nopriv_load_photos', 'load_photos_ajax_handler');


// Enqueue des scripts
function afaf_enqueue_scripts() {
    wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/js/script.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('custom-script', 'ajax_object', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('filter_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'afaf_enqueue_scripts');


