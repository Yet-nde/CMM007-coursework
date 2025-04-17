<div class="row mt-4">
    <div class="col-md-12 mb-3">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add New User
        </button>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>User List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>E-mail</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>