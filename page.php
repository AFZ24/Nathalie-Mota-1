<?php
// Empêche l'accès direct
if (!defined('ABSPATH')) {
    exit;
}?>
<div class="container">
<?php
get_header();
?>


<main id="site-content">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    // Contenu édité avec Gutenberg
                    the_content();

                    // Affiche les blocs imbriqués si nécessaire
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'nom-du-theme'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        // Si aucun contenu n'est trouvé
        ?>
        <p><?php esc_html_e('Aucun contenu trouvé.', 'nom-du-theme'); ?></p>
    <?php
    endif;
    ?>
</main>
</div>

<?php get_footer(); ?>
