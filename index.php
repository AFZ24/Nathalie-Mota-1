
<?php
get_header();
?>
<body>
<div> <img class="banniere" src="http://nathalie-mota1.local/wp-content/uploads/2024/10/Header-1.png" alt="image photographe event">
</div>

</body>
<main id="main-content" role="main">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <nav class="pagination">
            <?php
            // Affiche les liens de navigation pour les articles (précédent/suivant)
            the_posts_pagination( array(
                'prev_text' => __( 'Précédent', 'text-domain' ),
                'next_text' => __( 'Suivant', 'text-domain' ),
            ) );
            ?>
        </nav>
    <?php else : ?>
        <article class="no-posts">
            <h2><?php _e( 'Aucun contenu trouvé', 'text-domain' ); ?></h2>
            <p><?php _e( 'Désolé, aucun article ne correspond à votre recherche.', 'text-domain' ); ?></p>
        </article>
    <?php endif; ?>
</main>

<?php
get_footer();
?>
