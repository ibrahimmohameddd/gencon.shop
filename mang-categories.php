<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENCON Category Admin Panel</title>
    
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

        $host = "localhost";
        $user = "root";
        $pass = ""; // change if different
        $db   = "gencon";

        $conn = new mysqli($host, $user, $pass, $db);
        
        // $conn = new mysqli('sql304.infinityfree.com','if0_39979054','Barhoma2008','if0_39979054_gencon');
       
        $r = mysqli_query($conn, "SELECT * FROM category");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $status = "";
        $color = "";

        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $description = $_POST['desc'];

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

                    $sql = "INSERT INTO category (name, description, pic) 
                            VALUES ('$name', '$description', '$pic')";

                    if ($conn->query($sql) === TRUE) {
                        $status = "Category added successfully!";
                        $color = "green";
                        header("Location: category-admin.php");
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

        if (isset($_POST['update'])) {
            $id    = (int)$_POST['id'];
            $name  = $_POST['name'];
            $desc  = $_POST['description'];

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
            $sql = "UPDATE category 
                    SET name='$name', description='$desc' $picSql
                    WHERE id=$id";

            if($conn->query($sql)===True){
                header("Location: mang-categories.php");
            }
            if (!$conn->query($sql)) {
                die("Update failed: " . $conn->error);
            }
        }

        if (isset($_GET['delete_id'])) {
            $id = (int) $_GET['delete_id']; 

            // use your existing $conn here (since DB is already connected)
            $stmt = $conn->prepare("DELETE FROM category WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // redirect back to the same page so the row disappears from the table
            header("Location: mang-category.php");
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
        
        /* No Categories Message */
        .message-container {
            display: none;
            text-align: center;
            padding: 2rem;
            color: #666;
        }
        
        .message-container i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        #no-categories i {
            color: var(--secondary-color);
        }
        
        #no-search-results i {
            color: #6c757d;
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
            <h1 class="text-3xl font-bold mb-6">Category Management</h1>
            
            <!-- Add Category Form -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Add New Category</h2>
                </div>
                <form id="add-category-form" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="category-name">Category Name</label>
                            <input type="text" id="category-name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="category-image">Category Image</label>
                            <div class="file-input-wrapper">
                                <label for="category-image" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose File</span>
                                </label>
                                <input name="pic" type="file" id="category-image" class="file-input" accept="image/*" required>
                            </div>
                            <div class="file-input-info">
                                <span id="category-file-name" class="file-name">No file chosen</span>
                                <span id="category-file-size" class="file-size"></span>
                            </div>
                            <img id="image-preview" class="image-preview" alt="Preview">
                            <small id="image-error" class="text-red-500 hidden">Please select a valid image file</small>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="category-description">Description</label>
                        <textarea name="desc" id="category-description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" required></textarea>
                    </div>
                    
                    <button name="add" type="submit" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i> Add Category
                    </button>
                </form>
                <?php if (!empty($status)): ?>
                    <p style="font-size:1.5rem;text-align:center;margin-top:1rem;color:<?php echo $color; ?>"><?php echo $status; ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Categories List -->
            <div class="card">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">All Categories</h2>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" id="search-categories" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search categories...">
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categories-table">
                            <?php
                            $rowCount = mysqli_num_rows($r);
                            if ($rowCount > 0) {
                                while ($row = $r->fetch_assoc()):
                                    // make values safe for HTML attributes
                                    $id    = (int)$row['id'];
                                    $name  = htmlspecialchars($row['name'] ?? '', ENT_QUOTES);
                                    // remove newlines from description so it won't break an attribute
                                    $desc  = htmlspecialchars(str_replace(["\r", "\n"], [' ', ' '], $row['description'] ?? ''), ENT_QUOTES);
                                    $pic   = htmlspecialchars($row['pic'] ?? '', ENT_QUOTES);
                            ?>
                            <tr>
                                <td>
                                <?php if (!empty($row['pic'])): ?>
                                  <img src="<?= $pic ?>" alt="" style="width:80px; height:auto;">
                                <?php endif; ?>
                              </td>
                              <td><?= $name ?></td>
                              <td><?= $desc ?></td>
                              <td>
                                <!-- Edit button: JS will read these data- attributes to fill the popup form -->
                                <button
                                  class="editBtn btn-secondary mr-2"
                                  data-id="<?= $id ?>"
                                  data-name="<?= $name ?>"
                                  data-desc="<?= $desc ?>"
                                  data-pic="<?= $pic ?>"
                                >Edit</button>

                                <!-- Delete button -->
                                <button type="button" class="btn-danger delete-btn" data-id="<?= $id ?>">Delete</button>
                              </td>
                            </tr>
                            <?php endwhile; 
                            } else {
                                // If no categories found, show the message
                                echo '<tr><td colspan="4" class="text-center py-4">No categories found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    <!-- No categories message (when database is empty) -->
                    <div id="no-categories" class="message-container">
                        <i class="fas fa-folder-open text-4xl mb-2"></i>
                        <h3 class="text-xl font-medium">No categories found</h3>
                        <p>Add your first category to get started</p>
                    </div>
                    
                    <!-- No search results message (when search returns no results) -->
                    <div id="no-search-results" class="message-container">
                        <i class="fas fa-search text-4xl mb-2"></i>
                        <h3 class="text-xl font-medium">No matching categories found</h3>
                        <p>Try a different search term</p>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Edit Category Modal -->
        <div id="editPopup" class="popup">
            <div class="popup-content">
                <div class="modal-header">
                    <h2 class="text-xl font-bold">Edit Category</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="edit-category-form" method="POST" enctype="multipart/form-data">
                    <input name="id" type="hidden" id="editId">
                    <div class="form-group">
                        <label for="edit-category-name">Category Name</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-category-description">Description</label>
                        <textarea name="description" id="editDesc" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Current Image</label>
                        <div class="current-image-container">
                            <img id="current-category-image" class="current-image" src="" alt="Current category image">
                        </div>
                        <label>Category Image</label>
                        <div class="file-input-wrapper">
                            <label for="edit-category-image" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose File</span>
                            </label>
                            <input type="file" name="pic" id="edit-category-image" class="file-input" accept="image/*">
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
        
        <!-- Notification -->
        <div id="notification" class="notification" role="alert" aria-live="assertive"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show/hide no categories message based on table content
            const categoriesTable = document.getElementById("categories-table");
            const noCategoriesMessage = document.getElementById("no-categories");
            const noSearchResultsMessage = document.getElementById("no-search-results");
            
            // Initially check if there are any categories
            if (categoriesTable.children.length === 0 || 
                (categoriesTable.children.length === 1 && categoriesTable.children[0].cells.length === 1)) {
                noCategoriesMessage.style.display = "block";
            } else {
                noCategoriesMessage.style.display = "none";
            }
            noSearchResultsMessage.style.display = "none";

            // File input functionality for add category form
            const categoryImageInput = document.getElementById("category-image");
            const categoryFileName = document.getElementById("category-file-name");
            const categoryFileSize = document.getElementById("category-file-size");
            const imagePreview = document.getElementById("image-preview");
            
            categoryImageInput.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    categoryFileName.textContent = file.name;
                    categoryFileSize.textContent = formatFileSize(file.size);
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = "block";
                    }
                    reader.readAsDataURL(file);
                } else {
                    categoryFileName.textContent = "No file chosen";
                    categoryFileSize.textContent = "";
                    imagePreview.style.display = "none";
                }
            });

            // File input functionality for edit category form
            const editCategoryImageInput = document.getElementById("edit-category-image");
            const editFileName = document.getElementById("edit-file-name");
            const editFileSize = document.getElementById("edit-file-size");
            const editImagePreview = document.getElementById("edit-image-preview");
            
            editCategoryImageInput.addEventListener("change", function() {
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
            const currentCategoryImage = document.getElementById("current-category-image");

            // When any Edit button is clicked
            document.querySelectorAll(".editBtn").forEach(btn => {
                btn.addEventListener("click", function() {
                    // Fill the form with row data
                    editId.value = btn.dataset.id;
                    editName.value = btn.dataset.name;
                    // Fix: Set textarea value properly
                    editDesc.value = btn.dataset.desc;
                    
                    // Show current image
                    currentCategoryImage.src = btn.dataset.pic;
                    currentCategoryImage.style.display = "block";
                    
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

                    if (confirm("Are you sure you want to delete this category?")) {
                        // Redirect to category-admin.php with delete_id parameter
                        window.location.href = `category-admin.php?delete_id=${id}`;
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById("search-categories");
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll("#categories-table tr");
                let visibleRows = 0;
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = "";
                        visibleRows++;
                    } else {
                        row.style.display = "none";
                    }
                });
                
                // Show/hide appropriate messages based on visible rows and search term
                if (searchTerm === "") {
                    // Not searching - show no categories message if no categories exist
                    if (visibleRows === 0) {
                        noCategoriesMessage.style.display = "block";
                        noSearchResultsMessage.style.display = "none";
                    } else {
                        noCategoriesMessage.style.display = "none";
                        noSearchResultsMessage.style.display = "none";
                    }
                } else {
                    // Searching - show no search results if no matches
                    if (visibleRows === 0) {
                        noCategoriesMessage.style.display = "none";
                        noSearchResultsMessage.style.display = "block";
                    } else {
                        noCategoriesMessage.style.display = "none";
                        noSearchResultsMessage.style.display = "none";
                    }
                }
            });
        });
    </script>
</body>
</html>