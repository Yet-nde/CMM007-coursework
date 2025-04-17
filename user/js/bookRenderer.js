(function ($) {
    function renderBookCards(books) {
        const $container = $('<div>').addClass("row row-cols-1 row-cols-md-3 g-4");

        books.forEach(book => {
            const $card = $('<div>').addClass('col');
            const $cardBody = $('<div>').addClass('card h-100 book-card')
                .data('book-id', book.book_id)
                .data('book-title', book.title)
                .data('book-author', book.author)
                .data('book-genre', book.genre)
                .data('book-isbn', book.isbn || 'N/A')
                .data('book-quantity', book.available_quantity)
                .data('book-image', book.image_path ? '/CMM007-coursework/' + book.image_path : '/CMM007-coursework/assets/images/default_book.jpg');
            const $img = $('<img>')
                .addClass('card-img-top')
                .attr('src', book.image_path ? '/CMM007-coursework/' + book.image_path : '/CMM007-coursework/assets/images/default_book.jpg')
                .css({
                    'height': '200px',
                    'object-fit': 'contain'
                });

            const $cardContent = $('<div>').addClass('card-body');
            $cardContent.append($('<h5>').addClass('card-title').text(book.title));
            $cardContent.append($('<p>').addClass('card-text text-muted').text(book.author));

            $cardBody.append($img).append($cardContent);
            $card.append($cardBody);
            $container.append($card);
        });

        $('#filterResults').empty().append($container);

        $('.book-card').click(function () {
            showBookDetails({
                book_id: $(this).data('book-id'),
                title: $(this).data('book-title'),
                author: $(this).data('book-author'),
                genre: $(this).data('book-genre'),
                isbn: $(this).data('book-isbn'),
                available_quantity: $(this).data('book-quantity'),
                image_path: $(this).data('book-image')
            });
        });
    }

    // Show book modal:
    function showBookDetails(book) {
        const available = book.available_quantity > 0;

        $('#bookModalTitle').text(book.title);
        $('#bookModalAuthor').text(book.author);
        $('#bookModalGenre').text(book.genre);
        $('#bookModalIsbn').text(book.isbn || 'N/A');
        $('#bookModalAvailableQty').text(book.available_quantity);
        $('#bookModalImage').attr('src', book.image_path);


        // Configure borrow button
        const $borrowBtn = $('#bookModalBorrowBtn');
        $borrowBtn.off('click').toggle(available);

        if (available) {
            $borrowBtn.click(() => {
                window.bookService.borrowBook(book.book_id);
                $('#bookDetailsModal').modal('hide');
            });
        }

        // Show modal
        $('#bookDetailsModal').modal('show');
    }

    // Load Books with Filters
    function loadFilteredBooks(filters) {
        $('#filterResults').html('<div class="text-center my-5"><div class="spinner-border"></div><p>Loading books...</p></div>');

        const requestFilters = {
            genre: $('#genreFilter').val(),
            sort: $('#sortFilter').val(),
            availability: $('#availabilityFilter').val(),
            search: $('#userPageSearch').val().trim()
        };

        $.getJSON('/CMM007-coursework/user/controllers/getFilteredBooks.php', requestFilters, function (response) {
            if (response.status === 'success') {
                if (response.data.length > 0) {
                    renderBookCards(response.data);
                } else {
                    $('#filterResults').html('<div class="alert alert-info">No books found matching your criteria</div>');
                }
            }
        })
            // .fail(function () {
            //     $('#filterResults').html('<div class="text-danger">Error loading books</div>');
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                $('#filterResults').html('<div class="alert alert-danger">Failed to load books. Please try again.</div>');
            });
    }

    // Initialize Filters
    function initFilters() {
        $.getJSON('/CMM007-coursework/user/controllers/getGenres.php', function (genres) {
            const $select = $('#genreFilter');
            genres.forEach(genre => {
                $select.append($('<option>', {
                    value: genre,
                    text: genre
                }));
            });
        });

        // Filter Change Handler
        $('#genreFilter, #sortFilter').change(function () {
            loadFilteredBooks({
                genre: $('#genreFilter').val(),
                sort: $('#sortFilter').val()
            });
        });
    }

    // Make functions available globally
    window.bookRenderer = {
        renderBookCards,
        showBookDetails,
        loadFilteredBooks,
        initFilters
    };
})(jQuery);