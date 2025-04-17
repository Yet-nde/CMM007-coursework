<div class="modal fade" id="editBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBookForm" enctype="multipart/form-data">
                    <?php echo csrfField(); ?> 
                        <input type="hidden" name="book_id" id="editBookId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAuthor" class="form-label">Author</label>
                            <input type="text" class="form-control" id="editAuthor" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="editIsbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="editIsbn" name="isbn" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGenre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="editGenre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <img id="currentImage" src="" class="img-fluid mb-2" style="max-height: 200px;">
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">New Image (Leave blank to keep current)</label>
                            <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>