import { showToast } from './ui.js';
import { renderBooksTable, renderUsersTable } from './tableRendering.js';
import { getCsrfToken } from './utilities.js';

export function loadInitialData() {
    $.ajax({
        url: '/CMM007-coursework/admin/controllers/adminLoadData.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                renderBooksTable(response.data.books, $('#booksTableBody'));
                renderUsersTable(response.data.users, $('#usersTableBody'));
            } else {
                showToast('danger', response.message);
            }
        },
        error: () => showToast('danger', 'Error loading data')
    });
}

export function submitForm(url, formSelector, type) {
    // Create FormData for books, serialize normally for users
    const formData = type === 'book' ? new FormData($(formSelector)[0])
        : $(formSelector).serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: type !== 'book',
        contentType: type === 'book' ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
        success: (response) => {
            if (response.status === 'success') {
                $(`#add${type.charAt(0).toUpperCase() + type.slice(1)}Modal`)
                    .modal('hide');
                loadInitialData();
                showToast('success', response.message);
            } else {
                showToast('danger', response.message);
            }
        },
        error: (xhr) => {
            showToast('danger', "Error submitting form.");
            console.error("AJAX error:", xhr.responseText);
        }
    });
}

export function deleteItem(id, type) {
    $.ajax({
        url: '/CMM007-coursework/admin/controllers/deleteItem.php',
        type: 'POST',
        data: {
            id: id,
            type: type,
            csrf_token: getCsrfToken()
        },
        success: (response) => {
            if (response.status === 'success') {

                loadInitialData();
                showToast('success', `${type.charAt(0).toUpperCase() + type.slice(1)} deleted successfully`);
            } else {
                showToast('danger', response.message || `Delete failed`);
            }
        },
        error: () => showToast('danger', `Error deleting ${type}`)
    });
}

// Restore book function
export function restoreBook(bookId) {
    $.ajax({
        url: '/CMM007-coursework/admin/controllers/restore_book.php',
        type: 'POST',
        data: {
            book_id: bookId,
            csrf_token: getCsrfToken()
        },

        success: (response) => {
            if (response.status === 'success') {
                loadInitialData();
                showToast('success', response.message);
            } else {
                showToast('danger', response.message);
            }
        },
        error: function(xhr) {
            showToast('danger', 'Server error: ' + xhr.statusText);
            console.error('Restore error:', xhr.responseText);
        }
    });
}

// Restore user function
export function restoreUser(userId) {
    
    $.ajax({
        url: '/CMM007-coursework/admin/controllers/restoreUser.php',
        type: 'POST',
        data: {
            user_id: userId,
            csrf_token: getCsrfToken()
        },
        
        success: (response) => {
            if (response.status === 'success') {
                loadInitialData();
                showToast('success', 'User restored successfully');
            } else {
                showToast('danger', response.message || 'Restore failed');
            }
        },
        error: () => showToast('danger', 'Error restoring user')    
    });
}

export function getItem(id, type) {
    // Load item data
    return $.ajax({
        url: '/CMM007-coursework/admin/controllers/up_getItem.php',
        data: { id: id, type: type },
        dataType: 'json',
    });
}

export function submitEdit(formData, type,id) {
    const url= type === 'book' ? '/CMM007-coursework/admin/controllers/up_editBook.php' : '/CMM007-coursework/admin/controllers/up_editUser.php';

    return $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: type !== 'book',
        contentType: type === 'book' ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
        success: (response) => {
            if (response.status === 'success') {
                $(`#edit${type.charAt(0).toUpperCase() + type.slice(1)}Modal`).modal('hide');
                loadInitialData();
                showToast('success', response.message);
            } else {
                showToast('danger', response.message || 'Update failed');
            }
        },
        error: (xhr) => {
            showToast('danger', 'Update error');
            console.error("AJAX error:", xhr.responseText);
            
        }
    });
}