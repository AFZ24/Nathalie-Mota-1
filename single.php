<div class="container">
<?php
get_header(); // Inclus l'en-tête de votre site

if (have_posts()) : while (have_posts()) : the_post();

    if (get_post_type() == 'photos') : ?>
        
        <!-- Affiche l'image de la photo avant le titre -->
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
                <!-- Affiche le contenu de la publication -->
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    <?php else : // Pour les autres types de publication ?>

        <div class="post-item">
            <h1><?php the_title(); ?></h1>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        </div>

    <?php endif;

endwhile;
endif;

get_footer(); // Inclus le pied de page
?>
