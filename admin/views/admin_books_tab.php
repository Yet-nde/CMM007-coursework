<div class="row mt-4">
    <div class="col-md-12 mb-3">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addBookModal">
            Add New Book
        </button>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Book List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="booksTable">
                        <thead>
                            <tr>
                                <th style="width:100px; ">Image</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Genre</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="booksTableBody">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>