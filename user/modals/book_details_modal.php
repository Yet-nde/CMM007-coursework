<div class="modal fade" id="bookDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img id="bookModalImage" src="" class="img-fluid rounded" alt="Book cover">
                    </div>
                    <div class="col-md-7">
                        <h4 id="bookModalTitle"></h4>
                        <p class="text-muted" id="bookModalAuthor"></p>
                        <p><strong>Genre:</strong> <span id="bookModalGenre"></span></p>
                        <p><strong>ISBN:</strong> <span id="bookModalIsbn"></span></p>
                        <p><strong>Available Copies:</strong> <span id="bookModalAvailableQty"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="bookModalBorrowBtn">Borrow</button>
            </div>
        </div>
    </div>
</div>