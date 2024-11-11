jQuery(document).ready(function($) {
    let page = 1;

    // Fonction pour charger les photos via AJAX
    function loadPhotos() {
        let filters = {
            categorie: $('#categorie').val(),
            format: $('#format').val(),
            date: $('#date').val(),
            page: page
        };

        console.log("Attempting AJAX call"); // Log pour confirmer que la fonction est appelée
        console.log(ajax_object.ajaxurl); // Vérifiez si l'URL est correcte

        $.ajax({
            url: ajax_object.ajaxurl, // Utilise ajax_object pour s'assurer de l'URL
            method: 'POST',
            data: {
                action: 'load_photos',
                filters: filters
            },
            success: function(response) {
                console.log("Response received:", response); // Log pour voir la réponse du serveur
                if (page === 1) {
                    $('#photos').html(response); // Remplacer le contenu existant
                } else {
                    $('#photos').append(response); // Ajouter les photos supplémentaires
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error); // Log les erreurs AJAX
            }
        });
    }

    // Recharger les photos lorsque les filtres changent
    $('#photo-filters select').on('change', function() {
        page = 1;
        loadPhotos();
    });

    // Charger plus de photos lorsque l'utilisateur clique sur "Charger plus"
    $('#load-more').on('click', function(e) {
        e.preventDefault(); // Empêche le comportement par défaut du bouton
        page++;
        loadPhotos();
    });

    loadPhotos(); // Charger les photos initialement
});


jQuery(document).ready(function($) {
    // Ajoute la lightbox HTML
    $('body').append(`
        <div id="lightbox">
            <span class="close-lightbox">&times;</span>
            <img src="" alt="Photo en plein écran">
        </div>
    `);

    // Ouvre la lightbox au clic de l'icône "plein écran"
    $('.fullscreen-icon').on('click', function() {
        const imgSrc = $(this).data('src');
        $('#lightbox img').attr('src', imgSrc);
        $('#lightbox').fadeIn();
    });

    // Ouvre les infos de la photo au clic de l'icône "œil"
    $('.eye-icon').on('click', function() {
        const infoUrl = $(this).data('info');
        window.location.href = infoUrl; // Redirige vers la page d'infos
    });

    // Ferme la lightbox au clic du bouton de fermeture ou en dehors de l'image
    $('#lightbox, #lightbox .close-lightbox').on('click', function(event) {
        if (event.target === this) { // Assure la fermeture seulement si le fond ou le bouton est cliqué
            $('#lightbox').fadeOut();
        }
    });
});
