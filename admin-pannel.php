<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENCON Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
        session_start();
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: login.php");
            exit;
        }
        if(isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit;
        }

        /*$host = "localhost";
        $user = "root";
        $pass = ""; // change if different
        $db   = "gencon";

        $conn = new mysqli($host, $user, $pass, $db);*/
        $conn = new mysqli('sql304.infinityfree.com','if0_39979054','Barhoma2008','if0_39979054_gencon');
        $r = mysqli_query($conn, "SELECT * FROM products");
        $r2 = mysqli_query($conn, "SELECT * FROM category");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Account Management Logic
        $account_status = "";
        $account_color = "";
        
        // Add Account
        if (isset($_POST['add_account'])) {
            $secret_password = $_POST['secret_password'];
            if ($secret_password === "gencon_123456") {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $check_sql = "SELECT * FROM account WHERE user = '$username'";
                $check_result = $conn->query($check_sql);
                
                if ($check_result->num_rows > 0) {
                    $account_status = "Username already exists!";
                    $account_color = "red";
                } else {
                    $sql = "INSERT INTO account (user, pass) VALUES ('$username', '$password')";
                    if ($conn->query($sql) === TRUE) {
                        $account_status = "Account added successfully!";
                        $account_color = "green";
                    } else {
                        $account_status = "Error: " . $conn->error;
                        $account_color = "red";
                    }
                }
            } else {
                $account_status = "Invalid secret password!";
                $account_color = "red";
            }
        }
        
        // Edit Account
        if (isset($_POST['edit_account'])) {
            $secret_password = $_POST['secret_password'];
            if ($secret_password === "gencon_123456") {
                $old_username = $_POST['old_username'];
                $new_username = $_POST['new_username'];
                $new_password = $_POST['new_password'];
                
                $check_sql = "SELECT * FROM account WHERE user = '$new_username' AND user != '$old_username'";
                $check_result = $conn->query($check_sql);
                
                if ($check_result->num_rows > 0) {
                    $account_status = "Username already exists!";
                    $account_color = "red";
                } else {
                    $sql = "UPDATE account SET user = '$new_username', pass = '$new_password' WHERE user = '$old_username'";
                    if ($conn->query($sql) === TRUE) {
                        $account_status = "Account updated successfully!";
                        $account_color = "green";
                    } else {
                        $account_status = "Error: " . $conn->error;
                        $account_color = "red";
                    }
                }
            } else {
                $account_status = "Invalid secret password!";
                $account_color = "red";
            }
        }
        
        // Delete Account
        if (isset($_POST['delete_account'])) {
            $secret_password = $_POST['secret_password'];
            if ($secret_password === "gencon_123456") {
                $username = $_POST['delete_username'];
                
                $sql = "DELETE FROM account WHERE user = '$username'";
                if ($conn->query($sql) === TRUE) {
                    $account_status = "Account deleted successfully!";
                    $account_color = "green";
                } else {
                    $account_status = "Error: " . $conn->error;
                    $account_color = "red";
                }
            } else {
                $account_status = "Invalid secret password!";
                $account_color = "red";
            }
        }

        $status = "";
        $color = "";

        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $description = $_POST['desc'];
            $price = $_POST['price'];
            if(isset($_POST['category'])){
                $category = $_POST['category'];
            }

            // Handle file upload
            if (isset($_FILES['pic']) && $_FILES['pic']['error'] === 0) {
                $uploadDir = "uploads/"; // make sure this folder exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . "_" . basename($_FILES['pic']['name']); // unique name
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['pic']['tmp_name'], $targetPath)) {
                    // Save only the path in DB
                    $pic = $targetPath;

                    $sql = "INSERT INTO products (name, category, description, price, pic) 
                            VALUES ('$name', '$category', '$description', '$price', '$pic')";

                    if ($conn->query($sql) === TRUE) {
                        $status = "Product added successfully!";
                        $color = "green";
                        header("Location: admin-pannel.php");
                    } else {
                        $status =  "Error: " . $conn->error;
                        $color = "red";
                    }
                } else {
                    $status = "Failed to upload image.";
                    $color = "red";
                }
            } else {
                $status = "No file selected.";
                $color = "red";
            }
        }

        $category = "";
        if (isset($_POST['update'])) {
            $id    = (int)$_POST['id'];
            $name  = $_POST['name'];
            $desc  = $_POST['description'];
            $price = $_POST['price'];
            if(isset($_POST['category'])){
                $category = $_POST['category'];
            }

            // default: don't touch pic
            $picSql = "";

            // if user uploaded a new pic, process it
            if (!empty($_FILES['pic']['name'])) {
                $uploadDir = "uploads/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . "_" . basename($_FILES['pic']['name']);
                $target   = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['pic']['tmp_name'], $target)) {
                    $picSql = ", pic='$target'";
                }
            }

            // final query
            $sql = "UPDATE products 
                    SET name='$name', category='$category', description='$desc', price='$price' $picSql
                    WHERE id=$id";

            if($conn->query($sql)===True){
                header("Location: admin-pannel.php");
            }
            if (!$conn->query($sql)) {
                die("Update failed: " . $conn->error);
            }
        }

        if (isset($_GET['delete_id'])) {
            $id = (int) $_GET['delete_id']; 

            // use your existing $conn here (since DB is already connected)
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // redirect back to the same page so the row disappears from the table
            header("Location: admin-pannel.php"); // change if your file is admin_panel.php
            exit();
        }
    ?> 
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #c9a961;
            --light-bg: #f8f8f8;
            --text-color: #333333;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .admin-header {
            background: #1a1a1a;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .admin-logo {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 24px;
        }
        
        .gen-part { color: white; }
        .con-part { color: #c9a961; }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: #b89356;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .btn-info {
            background: #17a2b8;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-info:hover {
            background: #138496;
        }
        
        .table th, .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 5px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateX(150%);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background: #28a745;
        }
        
        .notification.error {
            background: #dc3545;
        }
        
        /* Edit Modal Styles - Centered and Full Height */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }        
        .popup-content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow-y: auto;
            max-height: 90vh;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .image-preview {
            margin-top: 10px;
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
            display: none;
        }
        
        .current-image-container {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        
        .current-image-label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
        
        .current-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        
        /* Custom File Input */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-input-label:hover {
            background-color: #e9ecef;
        }
        
        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        
        .file-input-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 70%;
        }
        
        .file-size {
            font-size: 0.75rem;
        }
        
        /* Category Search Styles */
        .category-search-wrapper {
            position: relative;
            margin-bottom: 0.5rem;
        }
        
        .category-search {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .category-search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        /* No Products Message */
        #no-products {
            display: none;
            text-align: center;
            padding: 2rem;
            color: #666;
        }
        
        #no-products i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        /* Account Management Styles */
        .account-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .account-table th, .account-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .account-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .account-actions {
            display: flex;
            gap: 5px;
        }
        
        .account-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        .secret-password-group {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .secret-password-group label {
            color: #856404;
            font-weight: 600;
        }
        
        .account-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .account-tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .account-tab.active {
            border-bottom-color: var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        .account-tab-content {
            display: none;
        }
        
        .account-tab-content.active {
            display: block;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 3px;
        }
    </style>
    
   
</head>
<body>
    <!-- Admin Dashboard -->
    <div id="dashboard-page" class="min-h-screen bg-gray-100">
        <!-- Admin Header -->
        <header class="admin-header">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="admin-logo">
                    <span class="gen-part">GEN</span><span class="con-part">CON</span> Admin
                </div>
                <div class="flex items-center space-x-4">
                    <button id="manage-accounts-btn" class="btn-info">
                        <i class="fas fa-users-cog mr-2"></i> Manage Accounts
                    </button>
                    <span>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></span>
                    <form method="POST">
                        <button id="logout-btn" name="logout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <h1 class="text-3xl font-bold mb-6">Product Management</h1>
            
            <!-- Add Product Form -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Add New Product</h2>
                </div>
                <form id="add-product-form" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="product-name">Product Name</label>
                            <input type="text" id="product-name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="product-category">Category</label>
                            <div class="category-search-wrapper">
                                <input type="text" id="category-search" class="category-search" placeholder="Search categories...">
                                <i class="fas fa-search category-search-icon"></i>
                            </div>
                            <select name="category" id="product-category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">All</option>
                                <?php
                                    while($row2 = mysqli_fetch_array($r2)) {
                                        echo "<option value='$row2[name]'>$row2[name]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="product-price">Price ($)</label>
                            <input name="price" type="number" id="product-price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" step="0.01" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="product-image">Product Image</label>
                            <div class="file-input-wrapper">
                                <label for="product-image" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose File</span>
                                </label>
                                <input name="pic" type="file" id="product-image" class="file-input" accept="image/*" required>
                            </div>
                            <div class="file-input-info">
                                <span id="product-file-name" class="file-name">No file chosen</span>
                                <span id="product-file-size" class="file-size"></span>
                            </div>
                            <img id="image-preview" class="image-preview" alt="Preview">
                            <small id="image-error" class="text-red-500 hidden">Please select a valid image file</small>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="product-description">Description</label>
                        <textarea name="desc" id="product-description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
                    </div>
                    
                    <button name="add" type="submit" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i> Add Product
                    </button>
                </form>
                <?php if (!empty($status)): ?>
                    <p style="font-size:1.5rem;text-align:center;margin-top:1rem;color:<?php echo $color; ?>"><?php echo $status; ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Products List -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">All Products</h2>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" id="search-products" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search products...">
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="products-table">
                            <?php
                            $rowCount = mysqli_num_rows($r);
                            if ($rowCount > 0) {
                                while ($row = $r->fetch_assoc()):
                                    // make values safe for HTML attributes
                                    $id    = (int)$row['id'];
                                    $name  = htmlspecialchars($row['name'] ?? '', ENT_QUOTES);
                                    // remove newlines from description so it won't break an attribute
                                    $desc  = htmlspecialchars(str_replace(["\r", "\n"], [' ', ' '], $row['description'] ?? ''), ENT_QUOTES);
                                    $price = htmlspecialchars((string)($row['price'] ?? ''), ENT_QUOTES);
                                    $pic   = htmlspecialchars($row['pic'] ?? '', ENT_QUOTES);
                                    $category   = htmlspecialchars($row['category'] ?? '', ENT_QUOTES);
                            ?>
                            <tr>
                                <td>
                                <?php if (!empty($row['pic'])): ?>
                                  <img src="<?= $pic ?>" alt="" style="width:80px; height:auto;">
                                <?php endif; ?>
                              </td>
                              <td><?= $name ?></td>
                              <td><?= $desc ?></td>
                              <td><?= $price ?></td>
                              <td><?= $category ?></td>
                              <td>
                                <!-- Edit button: JS will read these data- attributes to fill the popup form -->
                                <button
                                  class="editBtn btn-secondary mr-2"
                                  data-id="<?= $id ?>"
                                  data-name="<?= $name ?>"
                                  data-desc="<?= $desc ?>"
                                  data-price="<?= $price ?>"
                                  data-pic="<?= $pic ?>"
                                  data-category="<?= $category ?>"
                                >Edit</button>

                                <!-- Delete button -->
                                <button type="button" class="btn-danger delete-btn" data-id="<?= $id ?>">Delete</button>
                              </td>
                            </tr>
                            <?php endwhile; 
                            } else {
                                // If no products found, show the message
                                echo '<tr><td colspan="6" class="text-center py-4">No products found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="no-products" class="text-center py-8 text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-2"></i>
                        <h3 class="text-xl font-medium">No products found</h3>
                        <p>Add your first product to get started</p>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Edit Product Modal -->
        <div id="editPopup" class="popup">
            <div class="popup-content">
                <div class="modal-header">
                    <h2 class="text-xl font-bold">Edit Product</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="edit-product-form" method="POST" enctype="multipart/form-data">
                    <input name="id" type="hidden" id="editId">
                    <div class="form-group">
                        <label for="edit-product-name">Product Name</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-price">Price ($)</label>
                        <input type="number" name="price" id="editPrice" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <div class="category-search-wrapper">
                            <input type="text" id="edit-category-search" class="category-search" placeholder="Search categories...">
                            <i class="fas fa-search category-search-icon"></i>
                        </div>
                        <select id="edit-product-category" name="category" required>
                            <option value="">All</option>
                                <?php
                                    $r2 = mysqli_query($conn, "SELECT * FROM category");
                                    while($row3 = mysqli_fetch_array($r2)) {
                                        echo "<option value='$row3[name]'>$row3[name]</option>";
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-description">Description</label>
                        <textarea name="description" id="editDesc" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Current Image</label>
                        <div class="current-image-container">
                            <img id="current-product-image" class="current-image" src="" alt="Current product image">
                        </div>
                        <label>Product Image</label>
                        <div class="file-input-wrapper">
                            <label for="edit-product-image" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose File</span>
                            </label>
                            <input type="file" name="pic" id="edit-product-image" class="file-input" accept="image/*">
                        </div>
                        <div class="file-input-info">
                            <span id="edit-file-name" class="file-name">No file chosen</span>
                            <span id="edit-file-size" class="file-size"></span>
                        </div>
                        <img id="edit-image-preview" class="image-preview" alt="Preview">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="closePopup" class="btn-secondary close-modal">Cancel</button>
                        <button type="submit" name="update" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Account Management Modal -->
        <div id="accountPopup" class="popup">
            <div class="popup-content">
                <div class="modal-header">
                    <h2 class="text-xl font-bold">Account Management</h2>
                    <button class="close-modal">&times;</button>
                </div>
                
                <?php if (!empty($account_status)): ?>
                    <div class="mb-4 p-3 rounded" style="background-color: <?php echo $account_color === 'green' ? '#d4edda' : '#f8d7da'; ?>; color: <?php echo $account_color === 'green' ? '#155724' : '#721c24'; ?>;">
                        <?php echo $account_status; ?>
                    </div>
                <?php endif; ?>
                
                <div class="account-tabs">
                    <div class="account-tab active" data-tab="view-accounts">View Accounts</div>
                    <div class="account-tab" data-tab="add-account">Add Account</div>
                </div>
                
                <!-- View Accounts Tab -->
                <div id="view-accounts" class="account-tab-content active">
                    <div class="overflow-x-auto">
                        <table class="account-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $account_result = $conn->query("SELECT * FROM account");
                                if ($account_result->num_rows > 0) {
                                    while ($account_row = $account_result->fetch_assoc()) {
                                        $username = htmlspecialchars($account_row['user']);
                                        $password = htmlspecialchars($account_row['pass']);
                                        echo "<tr>
                                            <td>$username</td>
                                            <td>$password</td>
                                            <td>
                                                <div class='account-actions'>
                                                    <button class='btn-secondary btn-sm edit-account-btn' data-username='$username' data-password='$password'>Edit</button>
                                                    <button class='btn-danger btn-sm delete-account-btn' data-username='$username'>Delete</button>
                                                </div>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center py-4'>No accounts found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Add Account Tab -->
                <div id="add-account" class="account-tab-content">
                    <form method="POST">
                        <div class="secret-password-group">
                            <label for="add-secret-password">Secret Password (Required)</label>
                            <input type="password" id="add-secret-password" name="secret_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="add-username">Username</label>
                                <input type="text" id="add-username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="form-group">
                                <label for="add-password">Password</label>
                                <input type="text" id="add-password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>
                        
                        <button type="submit" name="add_account" class="btn-primary">
                            <i class="fas fa-plus mr-2"></i> Add Account
                        </button>
                    </form>
                </div>
                
                <!-- Edit Account Form (Hidden by default) -->
                <div id="edit-account-form" class="account-tab-content" style="display: none;">
                    <form method="POST">
                        <input type="hidden" id="edit-old-username" name="old_username">
                        
                        <div class="secret-password-group">
                            <label for="edit-secret-password">Secret Password (Required)</label>
                            <input type="password" id="edit-secret-password" name="secret_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="edit-new-username">Username</label>
                                <input type="text" id="edit-new-username" name="new_username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-new-password">Password</label>
                                <input type="text" id="edit-new-password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-2">
                            <button type="button" id="cancel-edit-account" class="btn-secondary">Cancel</button>
                            <button type="submit" name="edit_account" class="btn-primary">Update Account</button>
                        </div>
                    </form>
                </div>
                
                <!-- Delete Account Form (Hidden by default) -->
                <div id="delete-account-form" class="account-tab-content" style="display: none;">
                    <form method="POST">
                        <input type="hidden" id="delete-username" name="delete_username">
                        
                        <div class="secret-password-group">
                            <label for="delete-secret-password">Secret Password (Required)</label>
                            <input type="password" id="delete-secret-password" name="secret_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <p class="mb-4">Are you sure you want to delete this account? This action cannot be undone.</p>
                        
                        <div class="flex justify-end space-x-2">
                            <button type="button" id="cancel-delete-account" class="btn-secondary">Cancel</button>
                            <button type="submit" name="delete_account" class="btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Notification -->
        <div id="notification" class="notification" role="alert" aria-live="assertive"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show/hide no products message based on table content
            const productsTable = document.getElementById("products-table");
            const noProductsMessage = document.getElementById("no-products");
            
            if (productsTable.children.length === 0) {
                noProductsMessage.style.display = "block";
            } else {
                noProductsMessage.style.display = "none";
            }

            // File input functionality for add product form
            const productImageInput = document.getElementById("product-image");
            const productFileName = document.getElementById("product-file-name");
            const productFileSize = document.getElementById("product-file-size");
            const imagePreview = document.getElementById("image-preview");
            
            productImageInput.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    productFileName.textContent = file.name;
                    productFileSize.textContent = formatFileSize(file.size);
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = "block";
                    }
                    reader.readAsDataURL(file);
                } else {
                    productFileName.textContent = "No file chosen";
                    productFileSize.textContent = "";
                    imagePreview.style.display = "none";
                }
            });

            // File input functionality for edit product form
            const editProductImageInput = document.getElementById("edit-product-image");
            const editFileName = document.getElementById("edit-file-name");
            const editFileSize = document.getElementById("edit-file-size");
            const editImagePreview = document.getElementById("edit-image-preview");
            
            editProductImageInput.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    editFileName.textContent = file.name;
                    editFileSize.textContent = formatFileSize(file.size);
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editImagePreview.src = e.target.result;
                        editImagePreview.style.display = "block";
                    }
                    reader.readAsDataURL(file);
                } else {
                    editFileName.textContent = "No file chosen";
                    editFileSize.textContent = "";
                    editImagePreview.style.display = "none";
                }
            });

            // Format file size helper function
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Edit modal functionality
            const popup = document.getElementById("editPopup");
            const closeBtn = document.getElementById("closePopup");
            const editId = document.getElementById("editId");
            const editName = document.getElementById("editName");
            const editDesc = document.getElementById("editDesc");
            const editPrice = document.getElementById("editPrice");
            const editCategory = document.getElementById("edit-product-category");
            const currentProductImage = document.getElementById("current-product-image");

            // When any Edit button is clicked
            document.querySelectorAll(".editBtn").forEach(btn => {
                btn.addEventListener("click", function() {
                    // Fill the form with row data
                    editId.value = btn.dataset.id;
                    editName.value = btn.dataset.name;
                    editDesc.value = btn.dataset.desc;
                    editPrice.value = btn.dataset.price;
                    editCategory.value = btn.dataset.category;
                    
                    // Show current image
                    currentProductImage.src = btn.dataset.pic;
                    currentProductImage.style.display = "block";
                    
                    // Set current file name
                    const currentFileName = btn.dataset.pic ? btn.dataset.pic.split('/').pop() : "No file chosen";
                    editFileName.textContent = currentFileName;
                    
                    // Show popup
                    popup.style.display = "flex";
                });
            });

            // Close popup
            closeBtn.addEventListener("click", function() {
                popup.style.display = "none";
            });

            // Close if clicked outside content
            window.addEventListener("click", function(e) {
                if (e.target === popup) {
                    popup.style.display = "none";
                }
            });

            // Delete functionality
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");

                    if (confirm("Are you sure you want to delete this product?")) {
                        // Redirect to admin.php with delete_id parameter
                        window.location.href = `admin-pannel.php?delete_id=${id}`;
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById("search-products");
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll("#products-table tr");
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
                
                // Show/hide no products message based on visible rows
                const visibleRows = Array.from(rows).filter(row => row.style.display !== "none");
                if (visibleRows.length === 0) {
                    noProductsMessage.style.display = "block";
                } else {
                    noProductsMessage.style.display = "none";
                }
            });

            // Category search functionality for add form
            const categorySearch = document.getElementById("category-search");
            const productCategory = document.getElementById("product-category");
            
            categorySearch.addEventListener("input", function() {
                filterCategories(this.value, productCategory);
            });
            
            // Category search functionality for edit form
            const editCategorySearch = document.getElementById("edit-category-search");
            const editProductCategory = document.getElementById("edit-product-category");
            
            editCategorySearch.addEventListener("input", function() {
                filterCategories(this.value, editProductCategory);
            });

            // Filter categories based on search term
            function filterCategories(searchTerm, selectElement) {
                const options = selectElement.options;
                const searchTermLower = searchTerm.toLowerCase();
                
                for (let i = 0; i < options.length; i++) {
                    const optionText = options[i].text.toLowerCase();
                    if (optionText.includes(searchTermLower) || i === 0) {
                        // Always show the first option (placeholder)
                        options[i].style.display = '';
                    } else {
                        options[i].style.display = 'none';
                    }
                }
            }
            
            // Account Management Modal
            const accountPopup = document.getElementById("accountPopup");
            const manageAccountsBtn = document.getElementById("manage-accounts-btn");
            const accountCloseBtn = accountPopup.querySelector(".close-modal");
            
            // Open account management modal
            manageAccountsBtn.addEventListener("click", function() {
                accountPopup.style.display = "flex";
            });
            
            // Close account management modal
            accountCloseBtn.addEventListener("click", function() {
                accountPopup.style.display = "none";
            });
            
            // Close if clicked outside content
            window.addEventListener("click", function(e) {
                if (e.target === accountPopup) {
                    accountPopup.style.display = "none";
                }
            });
            
            // Account tabs functionality
            const accountTabs = document.querySelectorAll(".account-tab");
            const accountTabContents = document.querySelectorAll(".account-tab-content");
            
            accountTabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const tabId = this.getAttribute("data-tab");
                    
                    // Remove active class from all tabs and contents
                    accountTabs.forEach(t => t.classList.remove("active"));
                    accountTabContents.forEach(c => c.classList.remove("active"));
                    
                    // Add active class to clicked tab and corresponding content
                    this.classList.add("active");
                    document.getElementById(tabId).classList.add("active");
                });
            });
            
            // Edit account functionality
            const editAccountButtons = document.querySelectorAll(".edit-account-btn");
            const editAccountForm = document.getElementById("edit-account-form");
            const cancelEditAccountBtn = document.getElementById("cancel-edit-account");
            
            editAccountButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const username = this.getAttribute("data-username");
                    const password = this.getAttribute("data-password");
                    
                    // Fill the edit form
                    document.getElementById("edit-old-username").value = username;
                    document.getElementById("edit-new-username").value = username;
                    document.getElementById("edit-new-password").value = password;
                    
                    // Hide all tabs and show edit form
                    accountTabContents.forEach(content => content.style.display = "none");
                    editAccountForm.style.display = "block";
                });
            });
            
            // Cancel edit account
            cancelEditAccountBtn.addEventListener("click", function() {
                // Show view accounts tab
                accountTabContents.forEach(content => content.style.display = "none");
                document.getElementById("view-accounts").classList.add("active");
                document.getElementById("view-accounts").style.display = "block";
                
                // Set active tab
                accountTabs.forEach(tab => tab.classList.remove("active"));
                document.querySelector("[data-tab='view-accounts']").classList.add("active");
            });
            
            // Delete account functionality
            const deleteAccountButtons = document.querySelectorAll(".delete-account-btn");
            const deleteAccountForm = document.getElementById("delete-account-form");
            const cancelDeleteAccountBtn = document.getElementById("cancel-delete-account");
            
            deleteAccountButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const username = this.getAttribute("data-username");
                    
                    // Fill the delete form
                    document.getElementById("delete-username").value = username;
                    
                    // Hide all tabs and show delete form
                    accountTabContents.forEach(content => content.style.display = "none");
                    deleteAccountForm.style.display = "block";
                });
            });
            
            // Cancel delete account
            cancelDeleteAccountBtn.addEventListener("click", function() {
                // Show view accounts tab
                accountTabContents.forEach(content => content.style.display = "none");
                document.getElementById("view-accounts").classList.add("active");
                document.getElementById("view-accounts").style.display = "block";
                
                // Set active tab
                accountTabs.forEach(tab => tab.classList.remove("active"));
                document.querySelector("[data-tab='view-accounts']").classList.add("active");
            });
        });
    </script>
</body>
</html>