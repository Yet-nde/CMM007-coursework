import { escapeHtml,getStatusBadge } from "./utilities.js";

export function renderBooksTable(books,$tbody) {
    $tbody.empty();

    books.forEach(book => {
        const isDeleted = book.deleted_at !== null;
        const statusBadge = isDeleted ? 
            '<span class="badge bg-danger">Deleted</span>' : 
            '<span class="badge bg-info">Active</span>';
        const deleteDate = isDeleted ? 
            `<small class="text-muted d-block">Deleted: ${new Date(book.deleted_at).toLocaleDateString()}</small>` : '';
        $tbody.append(`
            <tr data-id="${book.book_id}">
                <td><img src="/CMM007-coursework/${escapeHtml(book.image_path.startsWith('/') ? book.image_path : '/' + book.image_path)}" style="width: 100px;" class="img-fluid"></td>
                <td>${escapeHtml(book.title)}</td>
                <td>${escapeHtml(book.author)}</td>
                <td>${escapeHtml(book.isbn)}</td>
                <td>${escapeHtml(book.genre)}</td>
                <td>${escapeHtml(book.quantity)}</td>
                <td>${statusBadge} ${deleteDate}</td>
                <td>
                ${isDeleted ? `
                    <button class="btn btn-sm btn-success restore-book">Restore</button>
                ` : `
                    <button class="btn btn-sm btn-warning edit-book">Edit</button>
                    <button class="btn btn-sm btn-danger delete-book">Delete</button>
                `}
                </td>
            </tr>
        `);
    });
}

export function renderUsersTable(users,$tbody) {
    $tbody.empty();
    users.forEach(user => {
        const statusBadge=getStatusBadge(user.status);
        const deleteDate=user.deleted_at?
        `<small class="text-muted d-block">Deleted: ${new Date(user.deleted_at).toLocaleDateString()}</small>`:'';
        $tbody.append(`
            <tr data-id="${user.user_id}">
                <td>${escapeHtml(user.email)}</td>
                <td>${escapeHtml(user.username)}</td>
                <td>${escapeHtml(user.role)}</td>
                <td>
                ${statusBadge}
                ${deleteDate}
                </td>
                <td>
                    ${user.status !== 'deleted' ? `
                        
                            <button class="btn btn-sm btn-warning edit-user">Edit</button>
                            <button class="btn btn-sm btn-danger delete-user">Delete</button>
                        
                    ` : `
                        <button class="btn btn-sm btn-success restore-user">Restore</button>
                    `}
                </td>
            </tr>
        `);
    });
}