<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "gencon";

$conn = new mysqli($host, $user, $pass, $db);

//$conn = new mysqli('sql304.infinityfree.com','if0_39979054','Barhoma2008','if0_39979054_gencon');

$r = mysqli_query($conn, "SELECT * FROM products");
$r2 = mysqli_query($conn, "SELECT * FROM category");

$pic = "SELECT pic FROM PRODUCTS;";
$name = "SELECT name FROM PRODUCTS;";
$category = "SELECT category FROM PRODUCTS;";
$desc = "SELECT description FROM PRODUCTS;";
$price = "SELECT price FROM PRODUCTS;";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENCON - Products</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS for animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        .section-padding {
            padding: 80px 0;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-primary:hover {
            background-color: #b89356;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(201, 169, 97, 0.3);
        }

        .btn-primary:hover:before {
            left: 100%;
        }

        .text-primary {
            color: var(--secondary-color);
        }

        .product-card {
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            transition: all 0.8s ease;
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-card .card-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .product-card:hover h3 {
            color: var(--secondary-color);
        }

        .product-card p {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: #666;
            flex-grow: 1;
        }

        .product-card .price {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .product-card .btn {
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }

        .product-card .btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .product-card:hover .btn i {
            transform: translateX(5px);
        }

        .navbar {
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color);
        }

        .nav-link {
            color: var(--primary-color);
            font-weight: 500;
            margin: 0 15px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 50px 0 30px;
        }

        .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 18px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .navbar-gen-part {
            color: var(--primary-color);
        }

        .navbar-con-part {
            color: var(--secondary-color);
        }

        .footer-gen-part {
            color: white;
        }

        .footer-con-part {
            color: var(--secondary-color);
        }

        /* Filter Styles */
        .filter-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .filter-label {
            display: block;
            font-weight: 500;
            margin-bottom: 10px;
            color: #555;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-option {
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-option:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .filter-option.active {
            background-color: var(--secondary-color);
            color: white;
        }

        .price-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .price-input {
            width: 80px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        .filter-apply {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-apply:hover {
            background-color: #b89356;
        }

        /* Search Styles */
        .search-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .search-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .search-input-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(201, 169, 97, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-color);
            cursor: pointer;
        }

        .search-results {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: var(--light-bg);
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .breadcrumb-item {
            display: inline-block;
            font-size: 14px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--secondary-color);
        }

        .breadcrumb-item.active {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .breadcrumb-item:not(:last-child):after {
            content: '/';
            margin: 0 10px;
            color: #999;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Category Header */
        .category-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .category-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .category-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--secondary-color);
        }

        .category-description {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Mobile Filter Button */
        .mobile-filter-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 99;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-filter-btn:hover {
            transform: scale(1.1);
        }

        .mobile-filter-btn i {
            color: white;
            font-size: 20px;
        }

        /* Mobile Filter Panel */
        .mobile-filter-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 350px;
            height: 100%;
            background-color: white;
            z-index: 1001;
            padding: 20px;
            overflow-y: auto;
            transition: right 0.3s ease;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-filter-panel.active {
            right: 0;
        }

        .mobile-filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .mobile-filter-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .mobile-filter-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-color);
        }

        .filter-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .filter-overlay.active {
            display: block;
        }

        /* No Results Message */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .no-results i {
            font-size: 4rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .no-results h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .no-results p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
        }

        /* Cart Styles */
        .cart-icon-container {
            margin-left: 15px;
            position: relative;
        }

        #cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--secondary-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #cart-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 350px;
            height: 100%;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        #cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-items-container {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: #666;
            font-size: 0.9rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            margin-top: 8px;
        }

        .cart-item-quantity button {
            width: 25px;
            height: 25px;
            border: 1px solid #ddd;
            background: #f8f8f8;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .cart-item-quantity span {
            margin: 0 10px;
        }

        .cart-item-remove {
            color: #999;
            cursor: pointer;
            margin-left: 10px;
        }

        .cart-item-remove:hover {
            color: #ff0000;
        }

        .cart-footer {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .cart-checkout-btn {
            width: 100%;
            padding: 12px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cart-checkout-btn:hover {
            background-color: #b89356;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .cart-overlay.active {
            display: block;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 169, 97, 0.3);
        }

        /* Order Form Styles */
        .order-form-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .order-form-overlay.active {
            display: flex;
        }

        .order-form-container {
            background-color: white;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideInUp 0.5s ease;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .order-form-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .order-form-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-color);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .order-form-close:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .order-form-body {
            padding: 20px;
        }

        .order-form-group {
            margin-bottom: 20px;
        }

        .order-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }

        .order-form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .order-form-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(201, 169, 97, 0.2);
        }

        .order-form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            min-height: 100px;
            resize: vertical;
            transition: all 0.3s ease;
        }

        .order-form-textarea:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(201, 169, 97, 0.2);
        }

        .order-form-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .order-form-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .order-form-btn-cancel {
            background-color: #f0f0f0;
            color: var(--text-color);
        }

        .order-form-btn-cancel:hover {
            background-color: #e0e0e0;
        }

        .order-form-btn-submit {
            background-color: var(--secondary-color);
            color: white;
        }

        .order-form-btn-submit:hover {
            background-color: #b89356;
        }

        .order-summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: var(--light-bg);
            border-radius: 8px;
        }

        .order-summary-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .order-summary-items {
            margin-bottom: 10px;
        }

        .order-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .order-summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        /* Filter and Search Layout */
        .filter-search-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .filter-section {
            flex: 1;
            min-width: 280px;
        }

        .search-section {
            flex: 1;
            min-width: 280px;
        }

        @media (max-width: 768px) {
            .section-padding {
                padding: 50px 0;
            }

            .category-title {
                font-size: 2.2rem;
            }

            .filter-container {
                display: none;
            }

            .mobile-filter-btn {
                display: flex;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }

            #cart-sidebar {
                width: 100%;
                max-width: 350px;
            }

            .filter-search-container {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html" class="navbar-brand">
                <span class="navbar-gen-part">GEN</span><span class="navbar-con-part">CON</span>
            </a>
            <div class="hidden md:flex">
                <a href="index.html#home" class="nav-link">Home</a>
                <a href="index.html#about" class="nav-link">About</a>
                <a href="index.html#furniture" class="nav-link">Furniture</a>
                <a href="index.html#calculator" class="nav-link">Calculator</a>
                <a href="index.html#contact" class="nav-link">Contact</a>
            </div>
            <div class="flex items-center">
                <div class="cart-icon-container">
                    <button id="cart-icon" class="relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>
                </div>
                <button id="mobile-menu-btn" class="md:hidden ml-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white mt-4 py-4 px-6 rounded-lg shadow-lg">
            <a href="index.html#home" class="block py-2 nav-link">Home</a>
            <a href="index.html#about" class="block py-2 nav-link">About</a>
            <a href="index.html#furniture" class="block py-2 nav-link">Furniture</a>
            <a href="index.html#calculator" class="block py-2 nav-link">Calculator</a>
            <a href="index.html#contact" class="block py-2 nav-link">Contact</a>
        </div>
    </nav>

    <!-- Cart Sidebar -->
    <div id="cart-sidebar">
        <div class="cart-header">
            <h3 class="text-xl font-bold">Your Cart</h3>
            <button id="close-cart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items-container" id="cart-items">
            <p class="text-gray-500 text-center py-8">Your cart is empty</p>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cart-total">$0.00</span>
            </div>
            <button class="cart-checkout-btn" id="order-via-whatsapp">Order via WhatsApp</button>
        </div>
    </div>
    <div class="cart-overlay"></div>

    <!-- Order Form Modal -->
    <div class="order-form-overlay" id="order-form-overlay">
        <div class="order-form-container">
            <div class="order-form-header">
                <h3 class="order-form-title">Complete Your Order</h3>
                <button class="order-form-close" id="order-form-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="order-form-body">
                <div class="order-summary">
                    <div class="order-summary-title">Order Summary</div>
                    <div class="order-summary-items" id="order-summary-items">
                        <!-- Order items will be populated by JavaScript -->
                    </div>
                    <div class="order-summary-total">
                        <span>Total:</span>
                        <span id="order-summary-total">$0.00</span>
                    </div>
                </div>
                <form id="order-form">
                    <div class="order-form-group">
                        <label class="order-form-label" for="customer-name">Full Name</label>
                        <input type="text" id="customer-name" class="order-form-input" required>
                    </div>
                    <div class="order-form-group">
                        <label class="order-form-label" for="customer-phone">Phone Number</label>
                        <input type="tel" id="customer-phone" class="order-form-input" required>
                    </div>
                    <div class="order-form-group">
                        <label class="order-form-label" for="customer-location">Location</label>
                        <input type="text" id="customer-location" class="order-form-input" required>
                    </div>
                    <div class="order-form-group">
                        <label class="order-form-label" for="customer-notes">Additional Notes (Optional)</label>
                        <textarea id="customer-notes" class="order-form-textarea" placeholder="Any special requests or additional information..."></textarea>
                    </div>
                </form>
            </div>
            <div class="order-form-footer">
                <button type="button" class="order-form-btn order-form-btn-cancel" id="order-form-cancel">Cancel</button>
                <button type="button" class="order-form-btn order-form-btn-submit" id="submit-order">Send Order via WhatsApp</button>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="container mx-auto px-6">
            <div class="breadcrumb-item">
                <a href="index.html">Home</a>
            </div>
            <div class="breadcrumb-item">
                <a href="index.html#furniture">Furniture</a>
            </div>
            <div class="breadcrumb-item active" id="breadcrumb-category">
                Products
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <section class="section-padding">
        <div class="container mx-auto px-6">
            <!-- Category Header -->
            <div class="category-header" data-aos="fade-up">
                <h1 class="category-title" id="category-title">Products</h1>
                <p class="category-description" id="category-description">
                    Discover our exquisite range of furniture designed to elevate your living and working spaces.
                </p>
            </div>

            <!-- Search and Filter Container -->
            <div class="filter-search-container">
                <!-- Search Section -->
                <div class="search-section" data-aos="fade-up">
                    <div class="search-container">
                        <h3 class="search-title">Search Products</h3>
                        <div class="search-input-container">
                            <input type="text" id="search-input" class="search-input" placeholder="Search by name, category, or description...">
                            <button id="search-btn" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div id="search-results" class="search-results"></div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section" data-aos="fade-up" data-aos-delay="100">
                    <div class="filter-container">
                        <h3 class="filter-title">Filter Products</h3>
                        <div class="filter-group">
                            <span class="filter-label">Category</span>
                            <select name="category" id="filterCategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All</option>
                                <?php
                                    while($row2 = mysqli_fetch_array($r2)) {
                                        echo "<option value='$row2[name]'>$row2[name]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <span class="filter-label">Price Range</span>
                            <div class="price-range">
                                <input type="number" class="price-input" id="min-price" placeholder="Min" min="0">
                                <span>-</span>
                                <input type="number" class="price-input" id="max-price" placeholder="Max" min="0">
                            </div>
                        </div>
                        <button class="filter-apply" id="apply-filters">Apply Filters</button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="product-grid" id="products-grid">
                <!-- Products will be populated by PHP -->
                <?php/*
                while ($row = mysqli_fetch_array($r)) {
                    echo "<div class='product-card' data-category='$row[category]' data-price='$row[price]' data-name='$row[name]' data-description='$row[description]'>
                <img src='$row[pic]' alt='$row[name]' class='w-full h-full object-cover'>
                <div class='card-content'>
                    <h3 class='text-lg font-bold mb-2'>$row[name]</h3>
                    <p class='text-gray-600 text-sm mb-3'>$row[description]</p>
                    <div class='price mb-4'>$<span class='price2'>$row[price]</span></div>
                    <button class='add-to-cart-btn btn-primary' data-product-id='$row[id]' data-product-name='$row[name]' data-product-price='$row[price]'>Add to Cart <i class='fas fa-shopping-cart ml-2'></i></button>
                </div>
            </div>";
                }
               */ ?>

                <?php
                            $rowCount = mysqli_num_rows($r);
                            if ($rowCount > 0) {
                                while ($row = $r->fetch_assoc()):
                                    // make values safe for HTML attributes
                                    $id    = (int)$row['id'];
                                    $name  = htmlspecialchars($row['name'] ?? '', ENT_QUOTES);
                                    $price  = htmlspecialchars($row['price'] ?? '', ENT_QUOTES);
                                    $category  = htmlspecialchars($row['category'] ?? '', ENT_QUOTES);
                                    // remove newlines from description so it won't break an attribute
                                    $desc  = htmlspecialchars(str_replace(["\r", "\n"], [' ', ' '], $row['description'] ?? ''), ENT_QUOTES);
                                    $pic   = htmlspecialchars($row['pic'] ?? '', ENT_QUOTES);
                            ?>
                              <div class='product-card' data-category='<?= $category?>' data-price='<?=$price?>' data-name='<?=$name?>' data-description='$row[description]'>
                <img src='<?= $pic?>' alt='<?=$name?>' class='w-full h-full object-cover'>
                <div class='card-content'>
                    <h3 class='text-lg font-bold mb-2'><?= $name ?></h3>
                    <p class='text-gray-600 text-sm mb-3'><?=$desc?></p>
                    <div class='price mb-4'>$<span class='price2'><?=$price?></span></div>
                    <button class='add-to-cart-btn btn-primary' data-product-id='<?=$id?>' data-product-name='<?=$name?>' data-product-price='<?=$price?>'>Add to Cart <i class='fas fa-shopping-cart ml-2'></i></button>
                </div>
            </div>
                            <?php endwhile; 
                            } else {
                                // If no categories found, show the message
                                echo '<tr><td colspan="4" class="text-center py-4">No categories found</td></tr>';
                            }
                            ?>


            </div>

                


            <!-- No Results Message -->
            <div class="no-results" id="no-results" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>No Products Found</h3>
                <p>Try adjusting your filters or search terms to find what you're looking for.</p>
                <button class="btn-primary py-2 px-6 rounded-full" id="reset-filters">Reset Filters</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="index.html" class="navbar-brand text-white mb-4 inline-block">
                        <span class="footer-gen-part">GEN</span><span class="footer-con-part">CON</span>
                    </a>
                    <p class="text-gray-400">Transforming spaces into extraordinary environments since 2008.</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="index.html#home" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="index.html#about" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="index.html#furniture" class="text-gray-400 hover:text-white transition">Furniture</a></li>
                        <li><a href="index.html#calculator" class="text-gray-400 hover:text-white transition">Calculator</a></li>
                        <li><a href="index.html#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Consultancy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">General Contracting</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Renovations</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Fit-Outs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Furniture Design</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter for updates and exclusive offers.</p>
                    <form class="flex">
                        <input type="email" class="px-4 py-2 rounded-l text-gray-800 w-full" placeholder="Your email">
                        <button type="submit" class="bg-primary px-4 py-2 rounded-r hover:bg-opacity-90 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-6 text-center text-gray-400">
                <p>&copy; 2023 GENCON. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Filter Button -->
    <div class="mobile-filter-btn">
        <i class="fas fa-filter"></i>
    </div>

    <!-- Mobile Filter Panel -->
    <div class="mobile-filter-panel">
        <div class="mobile-filter-header">
            <h3 class="mobile-filter-title">Filter Products</h3>
            <button class="mobile-filter-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="filter-group">
            <span class="filter-label">Category</span>
            <div class="filter-options" id="mobile-category-filters">
                <!-- Category filters will be populated by JavaScript -->
            </div>
        </div>
        <div class="filter-group">
            <span class="filter-label">Price Range</span>
            <div class="price-range">
                <input type="number" class="price-input" id="mobile-min-price" placeholder="Min" min="0">
                <span>-</span>
                <input type="number" class="price-input" id="mobile-max-price" placeholder="Max" min="0">
            </div>
        </div>
        <button class="filter-apply" id="mobile-apply-filters">Apply Filters</button>
    </div>
    <div class="filter-overlay"></div>

    <script>
        document.getElementById("apply-filters").addEventListener("click", () => {
            const selectedCategory = document.getElementById("filterCategory").value.toLowerCase();
            const min = parseFloat(document.getElementById("min-price").value) || 0;
            const max = parseFloat(document.getElementById("max-price").value) || Infinity;
            const searchTerm = document.getElementById("search-input").value.toLowerCase();

            const products = document.querySelectorAll(".product-card");

            products.forEach((product) => {
                const productCategory = (product.dataset.category || "").toLowerCase();
                const price = parseFloat(product.dataset.price) || 0;
                const productName = (product.dataset.name || "").toLowerCase();
                const productDescription = (product.dataset.description || "").toLowerCase();

                const categoryMatch = !selectedCategory || productCategory === selectedCategory;
                const priceMatch = price >= min && price <= max;
                const searchMatch = !searchTerm ||
                    productName.includes(searchTerm) ||
                    productCategory.includes(searchTerm) ||
                    productDescription.includes(searchTerm);

                if (categoryMatch && priceMatch && searchMatch) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            });

            // Check if any products are visible
            const visibleProducts = Array.from(products).filter(product => product.style.display !== "none");
            const noResults = document.getElementById("no-results");

            if (visibleProducts.length === 0) {
                noResults.style.display = "block";
            } else {
                noResults.style.display = "none";
            }
        });

        // Search functionality
        document.getElementById("search-input").addEventListener("input", () => {
            const searchTerm = document.getElementById("search-input").value.toLowerCase();
            const selectedCategory = document.getElementById("filterCategory").value.toLowerCase();
            const min = parseFloat(document.getElementById("min-price").value) || 0;
            const max = parseFloat(document.getElementById("max-price").value) || Infinity;

            const products = document.querySelectorAll(".product-card");

            products.forEach((product) => {
                const productName = (product.dataset.name || "").toLowerCase();
                const productCategory = (product.dataset.category || "").toLowerCase();
                const productDescription = (product.dataset.description || "").toLowerCase();
                const price = parseFloat(product.dataset.price) || 0;

                const searchMatch = !searchTerm ||
                    productName.includes(searchTerm) ||
                    productCategory.includes(searchTerm) ||
                    productDescription.includes(searchTerm);

                const categoryMatch = !selectedCategory || productCategory === selectedCategory;
                const priceMatch = price >= min && price <= max;

                if (searchMatch && categoryMatch && priceMatch) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            });

            // Check if any products are visible
            const visibleProducts = Array.from(products).filter(product => product.style.display !== "none");
            const noResults = document.getElementById("no-results");

            if (visibleProducts.length === 0) {
                noResults.style.display = "block";
            } else {
                noResults.style.display = "none";
            }

            // Update search results text
            const searchResults = document.getElementById("search-results");
            if (searchTerm) {
                searchResults.textContent = `Found ${visibleProducts.length} products matching "${searchTerm}"`;
            } else {
                searchResults.textContent = "";
            }
        });

        // Cart functionality with localStorage
        document.addEventListener('DOMContentLoaded', function() {
            // Load cart from localStorage or initialize empty cart
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            const cartIcon = document.getElementById('cart-icon');
            const cartSidebar = document.getElementById('cart-sidebar');
            const closeCart = document.getElementById('close-cart');
            const cartCount = document.getElementById('cart-count');
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const cartOverlay = document.querySelector('.cart-overlay');
            const orderViaWhatsapp = document.getElementById('order-via-whatsapp');
            const orderFormOverlay = document.getElementById('order-form-overlay');
            const orderFormClose = document.getElementById('order-form-close');
            const orderFormCancel = document.getElementById('order-form-cancel');
            const submitOrder = document.getElementById('submit-order');
            const orderSummaryItems = document.getElementById('order-summary-items');
            const orderSummaryTotal = document.getElementById('order-summary-total');

            // Open cart when cart icon is clicked
            cartIcon.addEventListener('click', function() {
                cartSidebar.classList.add('active');
                cartOverlay.classList.add('active');
            });

            // Close cart when close button or overlay is clicked
            closeCart.addEventListener('click', closeCartSidebar);
            cartOverlay.addEventListener('click', closeCartSidebar);

            function closeCartSidebar() {
                cartSidebar.classList.remove('active');
                cartOverlay.classList.remove('active');
            }

            // Open order form when order via whatsapp button is clicked
            orderViaWhatsapp.addEventListener('click', function() {
                if (cart.length === 0) {
                    alert('Your cart is empty!');
                    return;
                }
                updateOrderSummary();
                orderFormOverlay.classList.add('active');
            });

            // Close order form when close button or cancel button is clicked
            orderFormClose.addEventListener('click', closeOrderForm);
            orderFormCancel.addEventListener('click', closeOrderForm);

            function closeOrderForm() {
                orderFormOverlay.classList.remove('active');
            }

            // Submit order via WhatsApp
            submitOrder.addEventListener('click', function() {
                const name = document.getElementById('customer-name').value;
                const phone = document.getElementById('customer-phone').value;
                const location = document.getElementById('customer-location').value;
                const notes = document.getElementById('customer-notes').value;

                if (!name || !phone || !location) {
                    alert('Please fill in all required fields!');
                    return;
                }

                // Create order message
                let message = `*New Order from GENCON*\n\n`;
                message += `*Customer Information:*\n`;
                message += `Name: ${name}\n`;
                message += `Phone: ${phone}\n`;
                message += `Location: ${location}\n\n`;
                message += `*Order Details:*\n`;

                let total = 0;
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    message += `${item.quantity}x ${item.name} - $${itemTotal.toFixed(2)}\n`;
                });

                message += `\n*Total: $${total.toFixed(2)}*\n`;

                if (notes) {
                    message += `\n*Additional Notes:*\n${notes}\n`;
                }

                // Encode message for URL
                const encodedMessage = encodeURIComponent(message);

                // Create WhatsApp URL
                const whatsappUrl = `https://wa.me/201050445930?text=${encodedMessage}`;

                // Open WhatsApp
                window.open(whatsappUrl, '_blank');

                // Close order form and cart
                closeOrderForm();
                closeCartSidebar();

                // Clear cart
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCart();
            });

            function updateOrderSummary() {
                if (cart.length === 0) {
                    orderSummaryItems.innerHTML = '<p>No items in cart</p>';
                    orderSummaryTotal.textContent = '$0.00';
                    return;
                }

                let itemsHTML = '';
                let total = 0;

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    itemsHTML += `
                        <div class="order-summary-item">
                            <span>${item.quantity}x ${item.name}</span>
                            <span>$${itemTotal.toFixed(2)}</span>
                        </div>
                    `;
                });

                orderSummaryItems.innerHTML = itemsHTML;
                orderSummaryTotal.textContent = `$${total.toFixed(2)}`;
            }

            // Add to cart button functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-to-cart-btn')) {
                    const button = e.target.closest('.add-to-cart-btn');
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');
                    const productPrice = parseFloat(button.getAttribute('data-product-price'));

                    // Add animation to button
                    button.classList.add('animate-pulse');
                    setTimeout(() => {
                        button.classList.remove('animate-pulse');
                    }, 500);

                    // Check if product is already in cart
                    const existingItem = cart.find(item => item.id === productId);

                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        cart.push({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            quantity: 1
                        });
                    }

                    // Save cart to localStorage
                    localStorage.setItem('cart', JSON.stringify(cart));

                    updateCart();
                }
            });

            function updateCart() {
                // Update cart count
                const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                cartCount.textContent = totalItems;

                // Update cart items
                if (cart.length === 0) {
                    cartItems.innerHTML = '<p class="text-gray-500 text-center py-8">Your cart is empty</p>';
                } else {
                    cartItems.innerHTML = '';
                    cart.forEach(item => {
                        const cartItem = document.createElement('div');
                        cartItem.className = 'cart-item';
                        cartItem.innerHTML = `
                    <div class="cart-item-details">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                        <div class="cart-item-quantity">
                            <button class="decrease-quantity" data-id="${item.id}">-</button>
                            <span>${item.quantity}</span>
                            <button class="increase-quantity" data-id="${item.id}">+</button>
                        </div>
                    </div>
                    <div class="cart-item-remove" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </div>
                `;
                        cartItems.appendChild(cartItem);
                    });

                    // Add event listeners to quantity buttons and remove buttons
                    document.querySelectorAll('.decrease-quantity').forEach(button => {
                        button.addEventListener('click', function() {
                            const itemId = this.getAttribute('data-id');
                            const item = cart.find(item => item.id === itemId);
                            if (item.quantity > 1) {
                                item.quantity -= 1;
                            } else {
                                cart = cart.filter(item => item.id !== itemId);
                            }
                            // Save updated cart to localStorage
                            localStorage.setItem('cart', JSON.stringify(cart));
                            updateCart();
                        });
                    });

                    document.querySelectorAll('.increase-quantity').forEach(button => {
                        button.addEventListener('click', function() {
                            const itemId = this.getAttribute('data-id');
                            const item = cart.find(item => item.id === itemId);
                            item.quantity += 1;
                            // Save updated cart to localStorage
                            localStorage.setItem('cart', JSON.stringify(cart));
                            updateCart();
                        });
                    });

                    document.querySelectorAll('.cart-item-remove').forEach(button => {
                        button.addEventListener('click', function() {
                            const itemId = this.getAttribute('data-id');
                            cart = cart.filter(item => item.id !== itemId);
                            // Save updated cart to localStorage
                            localStorage.setItem('cart', JSON.stringify(cart));
                            updateCart();
                        });
                    });
                }

                // Update cart total
                const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                cartTotal.textContent = `$${total.toFixed(2)}`;
            }

            // Initialize cart display on page load
            updateCart();
        });
    </script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Mobile filter functionality
        const mobileFilterBtn = document.querySelector('.mobile-filter-btn');
        const mobileFilterPanel = document.querySelector('.mobile-filter-panel');
        const mobileFilterClose = document.querySelector('.mobile-filter-close');
        const filterOverlay = document.querySelector('.filter-overlay');

        mobileFilterBtn.addEventListener('click', function() {
            mobileFilterPanel.classList.add('active');
            filterOverlay.classList.add('active');
        });

        mobileFilterClose.addEventListener('click', function() {
            mobileFilterPanel.classList.remove('active');
            filterOverlay.classList.remove('active');
        });

        filterOverlay.addEventListener('click', function() {
            mobileFilterPanel.classList.remove('active');
            filterOverlay.classList.remove('active');
        });

        // Mobile apply filters
        document.getElementById('mobile-apply-filters').addEventListener('click', function() {
            // Sync mobile filters with desktop filters
            const mobileCategory = document.getElementById('filterCategory').value;

            // Update price inputs
            document.getElementById('min-price').value = document.getElementById('mobile-min-price').value;
            document.getElementById('max-price').value = document.getElementById('mobile-max-price').value;

            // Apply filters
            document.getElementById("apply-filters").click();

            // Close mobile filter panel
            mobileFilterPanel.classList.remove('active');
            filterOverlay.classList.remove('active');
        });

        // Reset filters button
        document.getElementById('reset-filters').addEventListener('click', function() {
            // Reset all filters
            document.getElementById('filterCategory').value = '';

            // Clear price inputs
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            document.getElementById('mobile-min-price').value = '';
            document.getElementById('mobile-max-price').value = '';

            // Clear search input
            document.getElementById('search-input').value = '';
            document.getElementById('search-results').textContent = '';

            // Show all products
            const products = document.querySelectorAll(".product-card");
            products.forEach((product) => {
                product.style.display = "";
            });

            // Hide no results message
            document.getElementById('no-results').style.display = 'none';
        });

        // Footer newsletter form submission
        const footerNewsletterForm = document.querySelector('footer form');
        footerNewsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would normally send the form data to your server
            alert('Thank you for subscribing to our newsletter!');
            this.reset();
        });
    </script>
</body>

</html>