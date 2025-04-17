export function populateEditModal(item, type) {
    if (type === 'book') {
        $('#editBookId').val(item.book_id);
        $('#editTitle').val(item.title);
        $('#editAuthor').val(item.author);
        $('#editIsbn').val(item.isbn);
        $('#editGenre').val(item.genre);
        $('#editQuantity').val(item.quantity);
        const imagePath = item.image_path
            ? '/CMM007-coursework/' + item.image_path.replace(/^\/+/, '')
            : '/CMM007-coursework/assets/images/default_book.jpg';

        $('#currentImage').attr('src', imagePath);
    } else {
        $('#editUserId').val(item.user_id);
        $('#editUserEmail').val(item.email);
        $('#editUsername').val(item.username);
        $('#editUserRole').val(item.role);
    }
}