//code filtres 
jQuery(document).ready(function($) {
    var page = 1; // Page initiale
    var categorie = ''; // Filtre de catégorie
    var format = ''; // Filtre de format
    var date = 'desc'; // Tri par date

    // Fonction pour charger les photos via AJAX
    function loadPhotos(page, categorie, format, date) {
        $.ajax({
            url: ajax_object.ajaxurl, // URL d'admin AJAX
            type: 'POST',
            data: {
                action: 'load_photos', // Action AJAX
                filters: {
                    page: page, // Numéro de la page
                    categorie: categorie, // Filtre catégorie
                    format: format, // Filtre format
                    date: date // Tri par date
                }
            },
            success: function(response) {
                if (response) {
                    // Ajouter les photos au conteneur
                    $('#photo-container').append(response);
                }
            },
            error: function(error) {
                console.log('Erreur AJAX:', error);
            }
        });
    }

    // Charger les premières photos
    loadPhotos(page, categorie, format, date);

    // Écouteurs pour les changements dans les filtres
    $('#photo-filters select').on('change', function() {
        // Récupérer les valeurs des filtres
        categorie = $('#categorie').val();
        format = $('#format').val();
        date = $('#date').val();
        // Réinitialiser les photos au changement de filtre
        page = 1;
        $('#photo-container').empty(); // Vider le conteneur de photos

        // Recharger les photos avec les nouveaux filtres
        loadPhotos(page, categorie, format, date);
    });

    // Fonction pour détecter lorsque l'utilisateur atteint le bas de la page
    
    $('#load-more').on('click', function() {
        page++; // Incrémenter la page
        loadPhotos(page, categorie, format, date); // Charger les photos suivantes
    });
});





//code lightbox


jQuery(document).ready(function($) {
    let currentImageIndex = 0;
    let images = [];

    // Fonction pour afficher l'image dans la lightbox
    function showImage(index) {
        if (index >= 0 && index < images.length) {
            currentImageIndex = index;
            $('.lightbox__container img').attr('src', images[currentImageIndex].src);
            $('.lightbox').fadeIn();
        }
    }

    // Ouvre la lightbox et initialise l'index de l'image
    $(document).on('click', '.fullscreen-icon', function(event) {
        event.preventDefault(); // Empêche la redirection par défaut
        event.stopPropagation(); // Empêche la propagation de l'événement de clic

        // Collecte toutes les images pour la navigation
        images = $('.photo-accueil .fullscreen-icon').map(function() {
            return { src: $(this).data('src') };
        }).get();

        // Récupère l'index de l'image cliquée
        currentImageIndex = $('.fullscreen-icon').index(this);
        showImage(currentImageIndex);
    });

    // Bouton "Suivant" dans la lightbox
    $('.lightbox__next').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if (currentImageIndex < images.length - 1) {
            showImage(currentImageIndex + 1);
        }
    });

    // Bouton "Précédent" dans la lightbox
    $('.lightbox__prev').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if (currentImageIndex > 0) {
            showImage(currentImageIndex - 1);
        }
    });

    // Ferme la lightbox
    $('.lightbox__close').on('click', function(event) {
        event.preventDefault();
        $('.lightbox').fadeOut();
    });

    // Ferme la lightbox en cliquant en dehors de l'image
    $(document).on('click', function(event) {
        if ($(event.target).closest('.lightbox__container').length === 0 && $(event.target).closest('.fullscreen-icon').length === 0) {
            $('.lightbox').fadeOut();
        }
    });
});





    // Fonction pour détecter lorsque l'utilisateur clique sur le boutton charger plus
    jQuery(function($) {
        
    });
    
    // fonction pour le menu burger 

    document.addEventListener('DOMContentLoaded', function() {
        const burgerBtn = document.getElementById('burger-btn');
        const burgerMenu = document.getElementById('burger-menu');
        const body = document.body;
    
        burgerBtn.addEventListener('click', () => {
            burgerMenu.classList.toggle('menu-active');
            burgerBtn.classList.toggle('burger-open');
            body.classList.toggle('menu-open');
        });
    
        const menuLinks = burgerMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                burgerMenu.classList.remove('menu-active');
                burgerBtn.classList.remove('burger-open');
                body.classList.remove('menu-open');
            });
        });
    });


