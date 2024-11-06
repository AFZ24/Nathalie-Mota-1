
<head>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>

<header>
<div class="logo">
        <a href="#"><img src="http://nathalie-mota1.local/wp-content/uploads/2024/10/Nathalie-Mota.png" alt="Logo" /></a>
    </div>



<nav class="navbar" role="navigation" aria-label="<?php esc_html_e( 'Menu principal', 'text-domain' ); ?>">
    <?php
    if (has_nav_menu('main-menu')) {
        wp_nav_menu([
            'theme_location' => 'main-menu',
            'container'      => false,
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'menu',
        ]);
    } else {
        echo '<p>' . esc_html__('Aucun menu n\'est défini pour cet emplacement.', 'text-domain') . '</p>';
    }
    ?>
</nav>
</header>

<body>
<div> <img class="banniere" src="http://nathalie-mota1.local/wp-content/uploads/2024/10/Header-1.png" alt="image photographe event">
</div>

</body>

