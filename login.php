<?php
session_start();

// Database connection
//$conn = new mysqli("localhost", "root", "", "gencon");
$conn = new mysqli('sql304.infinityfree.com','if0_39979054','Barhoma2008','if0_39979054_gencon');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Simple query (no hashing for now)
    $sql = "SELECT * FROM account WHERE user='$username' AND pass='$password' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: admin-pannel.php");
        exit;
    } else {
        $error = "❌ Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENCON Admin Login</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    

<link rel="stylesheet" href="style.css">



</head>
<body>
    <!-- Login Page -->
    <div id="login-page" class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <span class="gen-part">GEN</span><span class="con-part">CON</span>
            </div>
            <p>Admin Panel</p>
        </div>
            <?php if(!empty($error)) echo "<p style='color:red;text-align:center;'>$error</p>" ?>
        <div class="login-body">

            <form id="login-form" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="user" id="username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="pass" id="password" class="form-control" required>
                    <div id="login-error" class="error-message">Invalid username or password</div>
                </div>
                
                <button type="submit" class="btn-primary" name="login">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
            
            <div class="credentials-info">
                <p>Please enter your admin credentials to access the dashboard.</p>
            </div>
        </div>
    </div>
    
</body>
</html>