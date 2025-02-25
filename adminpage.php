<?php
session_start();
error_reporting(E_ALL);
require_once "CMM007_dbconfig.php";
$sql = "SELECT*FROM Books";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT*FROM Users";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CM007 Admin Page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>

<body>
    <header class="mb-5">
        <nav class="navbar bg-light shadow-sm ">
            <div class="container">
                <a href="homepage.html" class="navbar-brand fw-bold text-info fs-3">CMM007 library</a>
                <form class="d-flex mx-auto w-50">
                    <input class="form-control" type="search" placeholder="Search for items..">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchItems()">Search</button>
                </form>

                <div>
                    <a href="login.html" class="btn btn-outline-info">Log In</a>
                    <a href="signup.html" class="btn btn-info">Sign Up</a>
                </div>


            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <h2 class="text-center">Admin Dashboard</h2>

        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="books-tab" data-bs-toggle="tab" data-bs-target="#books"
                    type="button" role="tab">Books</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
                    role="tab">Users</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            <div class="tab-pane fade show active" id="books" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-6 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Book</h4>
                            </div>
                            <div class="card-body">
                                <form action="addBook.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre</label>
                                        <input type="text" class="form-control" id="genre" name="genre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Book Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-info">Add Book</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Book List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:100px; ">Image</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>ISBN</th>
                                                <th>Genre</th>
                                                <th>Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($books as $book): ?>
                                                <tr>
                                                    <td><img src="<?php echo $book['image_path']; ?>" style="width: 100px;"
                                                            class="img-fluid"></td>
                                                    <td><?php echo $book['title']; ?></td>
                                                    <td><?php echo $book['author']; ?></td>
                                                    <td><?php echo $book['isbn']; ?></td>
                                                    <td><?php echo $book['genre']; ?></td>
                                                    <td><?php echo $book['quantity']; ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="users" role="tabpanel">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add User</h4>
                            </div>
                            <div class="card-body">
                                <form action="addUser.php" method="POST">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-info">Add User</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>User List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>E-mail</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?php echo $user['email']; ?></td>
                                                    <td><?php echo $user['username']; ?></td>
                                                    <td><?php echo $user['role']; ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>