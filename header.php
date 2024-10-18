<?php
wp_nav_menu( array(
    'theme_location' => 'main-menu',
) );
?>

<nav role="navigation" aria-label="<?php esc_html_e( 'Menu principal', 'text-domain' ); ?>">
    <button type="button" aria-expanded="false" aria-controls="primary-menu" class="menu-toggle">
        <?php esc_html_e( 'Menu', 'text-domain' ); ?>
    </button>
    <?php
    wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => false,
        'walker'         => new A11y_Walker_Nav_Menu(),
        'menu_id'        => 'primary-menu',
    ]);
    ?>
</nav>