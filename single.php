<div class="container">
    <?php
    get_header(); // Inclus l'en-tête de votre site

    if (have_posts()) : while (have_posts()) : the_post();

    if (get_post_type() == 'photos') : ?>
        <div class="photo-texte">
            <!-- Affiche l'image de la photo -->
            <?php if (get_field('photo')) : ?>
                <div class="image">
                    <img class="photo-image" src="<?php echo esc_url(get_field('photo')); ?>" alt="<?php the_title(); ?>">
                </div>
            <?php endif; ?>
    
            <div class="photos-item">
                <h1><?php the_title(); ?></h1>
    
                <div class="photos-content">
                    <!-- Affiche la référence de la photo -->
                    <?php if (get_field('reference')) : ?>
                        <p><strong>Référence :</strong> <?php echo esc_html(get_field('reference')); ?></p>
                    <?php endif; ?>
    
                    <!-- Affiche les taxonomies Catégorie et Format -->
                    <p><strong>Catégorie :</strong> <?php the_terms(get_the_ID(), 'categorie'); ?></p>
                    <p><strong>Format :</strong> <?php the_terms(get_the_ID(), 'format'); ?></p>
    
                    <!-- Affiche le type -->
                    <?php if (get_field('type')) : ?>
                        <p><strong>Type :</strong> <?php echo esc_html(get_field('type')); ?></p>
                    <?php endif; ?>
    
                    <?php if (get_field('annee')) : ?>
                        <p><strong>Année :</strong> <?php echo esc_html(get_field('annee')); ?></p>
                    <?php endif; ?>
    
                    <!-- Bouton Contacter -->
                   
    
                    <!-- Affiche le contenu de la publication -->
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="contactpart">
    <div class="contact-infos"><?php if (get_field('contact')) : ?>
        <?php 
        $reference = get_field('reference'); // Récupérer la référence
        echo esc_html(get_field('contact')); 
        ?>
        <button class="contactbtn" data-reference="<?php echo esc_attr($reference); ?>">Contacter</button>
    <?php endif; ?></div>

    <!-- Navigation entre les photos -->
    <div class="photo-navigation">
        <?php 
        // Récupérer toutes les photos dans l'ordre
        $all_photos = get_posts(array(
            'post_type' => 'photos',
            'posts_per_page' => -1, // Récupérer toutes les photos
            'orderby' => 'date',
            'order' => 'ASC',
        ));

        // Trouver la position de la photo actuelle
        $current_index = array_search(get_the_ID(), wp_list_pluck($all_photos, 'ID'));

        // Déterminer l'ID de la photo suivante et précédente
        $next_index = ($current_index + 1) % count($all_photos); // Si dernière, revient à la première
        $prev_index = ($current_index - 1 + count($all_photos)) % count($all_photos); // Si première, revient à la dernière

        $next_post = $all_photos[$next_index];
        $prev_post = $all_photos[$prev_index];
        ?>

        <!-- Miniature de la photo suivante -->
        <div class="next-photo">
            <a href="<?php echo get_permalink($prev_post->ID); ?>">
                <img src="<?php echo esc_url(get_field('photo', $prev_post->ID)); ?>" alt="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>" class="miniature-next">
            </a>
        </div>
        <!-- Flèches de navigation -->
        <div class="arrows-navigation">
            <!-- Flèche gauche (vers la photo précédente) -->
            <a href="<?php echo get_permalink($next_post->ID); ?>" class="arrow prev-arrow">
                <img src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/Line%206.png" alt="Flèche gauche">
            </a>
            
            <!-- Flèche droite (vers la photo suivante) -->
            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="arrow next-arrow">
                <img src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/Line%207.png" alt="Flèche droite">
            </a>
        </div>
    </div>
</div>


            <!-- Section "Vous aimerez aussi" -->
            <div class="you-may-like">
                <h2>Vous aimerez aussi</h2>
                <div class="you-may-like-content">
                    <?php
                    // Récupérer les catégories de la photo actuelle
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    if ($categories && !is_wp_error($categories)) {
                        $category_ids = wp_list_pluck($categories, 'term_id');

                        // Récupérer 2 autres photos dans la même catégorie (différentes de la photo actuelle)
                        $related_photos = new WP_Query(array(
                            'post_type' => 'photos',
                            'posts_per_page' => 2,
                            'orderby' => 'rand', // Trier aléatoirement pour éviter l'ordre
                            'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categorie',
                                    'field'    => 'term_id',
                                    'terms'    => $category_ids,
                                    'operator' => 'IN',
                                ),
                            ),
                        ));

                        if ($related_photos->have_posts()) :
                            while ($related_photos->have_posts()) : $related_photos->the_post();
                    
                                // Vérifie si le type de publication est "photos"
                                if (get_post_type() == 'photos') :
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
                <span class="eye-icon" data-info="<?php the_permalink(); ?>"><img class="oeil" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/oeil.png" alt="eye-icon"> </span>
                <span class="fullscreen-icon" data-src="<?php echo esc_url(get_field('photo')); ?>" 
                      data-title="<?php the_title(); ?>" 
                      data-category="<?php
                        $categories = get_the_terms(get_the_ID(), 'categorie');
                        if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                    ?>">
                    <img class="fullscreen" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/icon%20fullscreen.png" alt="fullscreen-icon">
                </span>
            </div>
        </a>
    </div>
</div>
                    <?php
                                endif; // Fin de la condition if (get_post_type() == 'photos')
                            endwhile;
                        else :
                            echo '<p>Aucune photo à afficher.</p>';
                        endif;

                        wp_reset_postdata(); // Réinitialiser la requête après avoir affiché les photos
                    } // Fermeture du if ($categories && !is_wp_error($categories))
                    ?>
                </div>
            </div>

           <!-- Lightbox HTML structure -->
<div class="lightbox" style="display: none;">
    <button class="lightbox__close"> <img class="suiv" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/Nathalie%20Mota%20-%20Maquette%202.0%20(1)/Vector.png"> </button>
    <button class="lightbox__next"> <img class="suiv" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/Nathalie%20Mota%20-%20Maquette%202.0%20(1)/Navigation%20arrows.png"> </button>
    <button class="lightbox__prev"> <img class="prec" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/Nathalie%20Mota%20-%20Maquette%202.0%20(1)/Navigation%20arrows-1.png"> </button>
    <div class="lightbox__container">
        <img src="" alt="Image en plein écran">
        <div class="photo-info lightbox-info">
            <p class="categorie" id="lightbox-category"></p>
            <p class="titre" id="lightbox-title"></p>
        </div>
    </div>
</div>
</div>
        <?php
        endif;
    endwhile;
    endif;
    
    get_footer(); // Inclus le pied de page ?>

