import { loadInitialData, submitForm, deleteItem, getItem, restoreBook, restoreUser,submitEdit } from "./api.js";
import { confirmAction } from "./ui.js";
import { populateEditModal } from "./modalManager.js";

export function initializeEventHandlers() {
    $('#addBookModal', '#editBookModal, #editUserModal').on('shown.bs.modal', function () {
        $(this).find('.form-control:first').focus();
    });

    // Add Book Form Submission
    $('#addBookForm').on('submit', (e) => {
        e.preventDefault();
        submitForm('/CMM007-coursework/admin/controllers/up_addBook.php', '#addBookForm', 'book');
    });

    // Add User Form Submission
    $('#addUserForm').on('submit', (e) => {
        e.preventDefault();
        submitForm('/CMM007-coursework/admin/controllers/up_addUser.php', '#addUserForm', 'user');
    });

    // Delete book
    $(document).on('click', '.delete-book', function (e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const id = $row.data('id');
        confirmAction('Are you sure you want to delete this book?', () => {
            deleteItem(id, 'book');
        });
    });

    // Delete user
    $(document).on('click', '.delete-user', function (e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const id = $row.data('id');
        confirmAction('Are you sure you want to delete this user?', () => {
            deleteItem(id, 'user');
        });
    });

    // Edit Book
    $(document).on('click', '.edit-book', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const bookId = $row.data('id');
        
        getItem(bookId, 'book')
            .then(item => {
                populateEditModal(item, 'book');
                $('#editBookModal').modal('show');
            })
            .catch(error => console.error('Error fetching book:', error));
    });

    // Edit User
    $(document).on('click', '.edit-user', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const userId = $row.data('id');
        
        getItem(userId, 'user')
            .then(item => {
                populateEditModal(item, 'user');
                $('#editUserModal').modal('show');
            })
            .catch(error => console.error('Error fetching user:', error));
    });

    // Restore Book
    $(document).on('click', '.restore-book', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const bookId = $row.data('id');
        
        confirmAction('Are you sure you want to restore this book?', () => {
            restoreBook(bookId);
        });
    });

    // Restore User
    $(document).on('click', '.restore-user', function(e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const userId = $row.data('id');
        
        confirmAction('Are you sure you want to restore this user?', () => {
            restoreUser(userId);
        });
    });

    // Edit Book Form Submission
    $('#editBookForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const bookId = $('#editBookId').val();
        submitEdit(formData, 'book', bookId)
            .then(() => {
                loadInitialData();
                // $('#editBookModal').modal('hide');
            })
            .catch(error => console.error('Error updating book:', error));
    });

    // Edit User Form Submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const userId = $('#editUserId').val();
        submitEdit(formData, 'user', userId)
        
            .then(() => {
                loadInitialData();
                // $('#editUserModal').modal('hide');
            })
            .catch(error => console.error('Error updating user:', error));
    });
}