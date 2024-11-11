<div class="container">
<?php
get_header();
?>
</div>
<body>
<div> <img class="banniere" src="http://nathalie-mota1.local/wp-content/uploads/2024/10/Header-1.png" alt="image photographe event">
</div>

<div class="container">

 <!-- Formulaire des filtres -->
 <form><div id="photo-filters">
        <select name="categorie" id="categorie">
            <option value="">CATEGORIES</option>
            <?php
            $categories = get_terms(['taxonomy' => 'categorie']);
            foreach ($categories as $category) {
                echo "<option value='{$category->slug}'>{$category->name}</option>";
            }
            ?>
        </select>

        <select name="format" id="format">
            <option value="">FORMATS</option>
            <?php
            $formats = get_terms(['taxonomy' => 'format']);
            foreach ($formats as $format) {
                echo "<option value='{$format->slug}'>{$format->name}</option>";
            }
            ?>
        </select></div>
<div class="date">
        <select name="date" id="date">
        <option>TRIER PAR</option>
            <option value="desc">Plus récentes</option>
            <option value="asc">Plus anciennes</option>
        </select>
    </div>
    </form> </div>
    <div class="container photos-accueil" id="photos">
    <?php
    // La requête pour récupérer les 8 dernières photos du CPT 'photos'
    $args = array(
        'post_type' => 'photos', // Le CPT 'photos'
        'posts_per_page' => 8,   // Afficher les 8 derniers posts
        'orderby' => 'date',     // Trier par date
        'order' => 'DESC',       // Ordre décroissant (les plus récents en premier)
    );
    $photos_query = new WP_Query($args);

    if ($photos_query->have_posts()) :
        while ($photos_query->have_posts()) : $photos_query->the_post();

            // Vérifie si le type de publication est "photos"
            if (get_post_type() == 'photos') :
    ?>
    
    <div class="photo-accueil">
    <div class="image-accueil">
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
            <span class="icon eye-icon" data-info="<?php the_permalink(); ?>"><img class="oeil" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/oeil.png"> </span>
            <span class="icon fullscreen-icon" data-src="<?php echo esc_url(get_field('photo')); ?>"><img class="fullscreen" src="/wp-content/themes/nathaliemota/Nathalie-Mota-1/icon%20fullscreen.png"></span>
        </div>
    </div>
</div>


    <?php
            endif;
        endwhile;
    else :
        echo '<p>Aucune photo à afficher.</p>';
    endif;

    wp_reset_postdata(); // Réinitialiser la requête après avoir affiché les photos
    ?>
    <!-- Bouton pour charger plus de photos -->
    <button id="load-more">Charger plus</button>
</div>


</body>
</div>
<?php
get_footer();
?>
