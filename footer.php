<div class="foooter">

<!-- Footer content -->
 
<div id="myModalOverlay"></div>
<div id="myModal">
    <button id="closeModal" style="float: right;">&times;</button>
    <img class="contact-img" src="http://nathalie-mota1.local/wp-content/uploads/2024/11/Contact-header.png" alt="contact">
    <div class="formulaire"><?php echo do_shortcode('[contact-form-7 id="1c19cd6" title="Formulaire de contact 1"]'); ?></div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactMenuItem = document.querySelector('.menu-item-116 a');
        const contactMenuItem2 = document.querySelector('.burger-menu .menu-item-116 a');
        const contactBtn = document.querySelector('.contactbtn'); // Bouton avec la classe "contactbtn"
        const modal = document.getElementById('myModal');
        const overlay = document.getElementById('myModalOverlay');
        const closeModalBtn = document.getElementById('closeModal');
        const photoRefInput = document.querySelector('input[name="your-subject"]'); // Champ "Réf. Photo"

        // Fonction pour afficher la modale
        const openModal = function(event) {
            event.preventDefault();

            // Récupère la référence de la photo depuis le bouton cliqué
            if (this === contactBtn) {
                const reference = this.getAttribute('data-reference');
                if (photoRefInput && reference) {
                    photoRefInput.value = reference; // Préremplit le champ avec la référence
                }
            }

            // Affiche la modale et l'overlay
            if (modal && overlay) {
                modal.style.display = 'block';
                overlay.style.display = 'block';
            }
        };

        // Ouvrir la modale depuis le lien du menu
        if (contactMenuItem) {
            contactMenuItem.addEventListener('click', openModal);
        }
        // Ouvrir la modale depuis le lien du menu burger
        if (contactMenuItem2) {
            contactMenuItem2.addEventListener('click', openModal);
        }
        // Ouvrir la modale depuis le bouton avec la classe "contactbtn"
        if (contactBtn) {
            contactBtn.addEventListener('click', openModal);
        }

        // Fermer la modale
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function() {
                if (modal && overlay) {
                    modal.style.display = 'none';
                    overlay.style.display = 'none';
                }
            });
        }

        // Fermer la modale en cliquant sur l'overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                if (modal && overlay) {
                    modal.style.display = 'none';
                    overlay.style.display = 'none';
                }
            });
        }
    });
</script>








<nav class="navbar footer-navbar" role="navigation" aria-label="<?php esc_html_e( 'Menu du footer', 'text-domain' ); ?>">
    <?php
    if (has_nav_menu('footer-menu')) {
        wp_nav_menu([
            'theme_location' => 'footer-menu',
            'container'      => false,
            'menu_id'        => 'footer-menu',
            'menu_class'     => 'footer-menu',
        ]);
    } else {
        echo '<p>' . esc_html__('Aucun menu n\'est défini pour cet emplacement de footer.', 'text-domain') . '</p>';
    }
    ?>
    <ul id="footer-menu"><p>TOUS DROITS RESERVES</p></ul>
</nav>
<?php wp_footer(); ?>
</div>
</html> 