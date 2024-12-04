jQuery(document).ready(function ($) {
    let page = 1; // Page initiale
    let categorie = ''; // Filtre catégorie (slug)
    let format = ''; // Filtre format (slug)
    let date = 'desc'; // Ordre par défaut

    // Fonction pour charger les photos via AJAX
    function loadPhotos(page, categorie, format, date) {
        $.ajax({
            url: ajax_object.ajaxurl, // URL d'admin AJAX
            type: 'POST',
            data: {
                action: 'load_photos', // Nom de l'action AJAX côté PHP
                filters: {
                    page: page,
                    categorie: categorie,
                    format: format,
                    date: date,
                },
            },
            beforeSend: function () {
                $('#load-more').text('Chargement...'); // Changement du texte pendant le chargement
            },
            success: function (response) {
                if (response.trim() !== '') {
                    // Ajouter le contenu au conteneur
                    $('#photo-container').append(response);
                    $('#load-more').text('Charger plus');
                } else {
                    // Masquer le bouton s'il n'y a plus de contenu
                    $('#load-more').hide();
                }
            },
            error: function (error) {
                console.error('Erreur AJAX:', error);
                $('#load-more').text('Charger plus');
            },
        });
    }

    // Gestion du clic sur le bouton "Charger plus"
    $('#load-more').on('click', function () {
        page++; // Incrémenter le numéro de la page
        loadPhotos(page, categorie, format, date); // Charger les photos suivantes
    });
});

jQuery(document).ready(function($) {
    let currentImageIndex = 0;
    let images = [];

    // Fonction pour afficher l'image dans la lightbox
    function showImage(index) {
        if (index >= 0 && index < images.length) {
            currentImageIndex = index;
            // Met à jour l'image dans la lightbox
            $('.lightbox__container img').attr('src', images[currentImageIndex].src);

            // Met à jour le titre et la catégorie dans la lightbox
            $('#lightbox-title').text(images[currentImageIndex].title);
            $('#lightbox-category').text(images[currentImageIndex].category);

            // Affiche la lightbox
            $('.lightbox').fadeIn();
        }
    }

    // Ouvre la lightbox et initialise l'index de l'image
    $(document).on('click', '.fullscreen-icon', function(event) {
        event.preventDefault(); // Empêche la redirection par défaut
        event.stopPropagation(); // Empêche la propagation de l'événement de clic

        // Collecte toutes les images pour la navigation
        images = $('.photo-accueil .fullscreen-icon').map(function() {
            return {
                src: $(this).data('src'),
                title: $(this).data('title'),
                category: $(this).data('category')
            };
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


//code pour les filtres 
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.custom-dropdown');

    dropdowns.forEach(dropdown => {
        const selected = dropdown.querySelector('.selected-option');
        const options = dropdown.querySelector('.dropdown-options');

        // Afficher/masquer les options
        selected.addEventListener('click', function () {
            dropdown.classList.toggle('open');
        });

        // Mise à jour du texte sélectionné
        options.addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                selected.textContent = e.target.textContent;
                dropdown.classList.remove('open');
            }
        });

        // Fermer le dropdown en cliquant ailleurs
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    });
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


// js des filtres 
jQuery(document).ready(function ($) {
    const filterForm = $('#photo-filters');
    const photoContainer = $('#photo-container');
    const loadMoreButton = $('#load-more');
    let currentPage = 1;

    function loadPhotos(filters) {
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_photos',
                nonce: ajax_object.nonce,
                filters: filters,
            },
            beforeSend: function () {
                photoContainer.append('<div class="loading">Chargement...</div>');
            },
            success: function (response) {
                photoContainer.html(response);
                $('.loading').remove();
            },
            error: function () {
                alert('Erreur lors du chargement des photos.');
            },
        });
    }

    // Filtrage des photos au changement des filtres
    filterForm.on('change', 'select', function () {
        const filters = {
            categorie: filterForm.find('select[name="categorie"]').val(),
            format: filterForm.find('select[name="format"]').val(),
            date: filterForm.find('select[name="date"]').val(),
            page: 1,
        };

        currentPage = 1; // Réinitialiser à la page 1
        loadPhotos(filters);
    });

    // Gestion du bouton "Charger plus"
    loadMoreButton.on('click', function () {
        currentPage++;
        const filters = {
            categorie: filterForm.find('select[name="categorie"]').val(),
            format: filterForm.find('select[name="format"]').val(),
            date: filterForm.find('select[name="date"]').val(),
            page: currentPage,
        };

        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_photos',
                nonce: ajax_object.nonce,
                filters: filters,
            },
            success: function (response) {
                photoContainer.append(response);
            },
            error: function () {
                alert('Erreur lors du chargement.');
            },
        });
    });
});


