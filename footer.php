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
        const modal = document.getElementById('myModal');
        const overlay = document.getElementById('myModalOverlay');
        const closeModalBtn = document.getElementById('closeModal');

        if (contactMenuItem && modal && overlay && closeModalBtn) {
            contactMenuItem.addEventListener('click', function(event) {
                event.preventDefault();
                modal.style.display = 'block';
                overlay.style.display = 'block';
            });

            closeModalBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });

            overlay.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });
        } else {
            console.error("L'un des éléments n'a pas été trouvé");
        }
    });
</script>
