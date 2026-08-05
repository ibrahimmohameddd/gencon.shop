<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gencon');

// $conn = new mysqli('sql304.infinityfree.com','if0_39979054','Barhoma2008','if0_39979054_gencon');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories from database
$sql = "SELECT id, pic, name, description, status FROM category";
$result = $conn->query($sql);

$indoorCategories = [];
$outdoorCategories = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['status'] == 'indoor') {
            $indoorCategories[] = $row;
        } elseif ($row['status'] == 'outdoor') {
            $outdoorCategories[] = $row;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENCON - Consultancy | General Contracting | Renovations | Fit-Outs</title>
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
h1, h2, h3, h4, h5, h6 {
font-family: 'Playfair Display', serif;
}
.hero-bg {
background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/1.jpg');
background-size: cover;
background-position: center;
background-attachment: fixed;
position: relative;
}
.parallax {
background-attachment: fixed;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
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
.furniture-card {
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    flex: 0 0 300px; /* Fixed width of 300px */
    margin-right: 20px;
    background-color: white;
    border-radius: 0px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    min-width: 600px; /* Ensure minimum width */
    max-width: 7000px; /* Set maximum width */
}
@media (max-width: 768px) {
    /* ... other styles ... */
    .furniture-card {
        flex: 0 0 calc(50% - 10px);
        margin-right: 10px;
        min-width: 300px; /* Adjust minimum width for mobile */
        max-width: 350px; /* Adjust maximum width for mobile */
    }
    /* ... other styles ... */
}
.furniture-card:before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.7) 100%);
opacity: 0;
transition: opacity 0.3s ease;
z-index: 1;
}
.furniture-card:hover {
transform: translateY(-10px);
box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}
.furniture-card:hover:before {
opacity: 1;
}
.furniture-card img {
transition: all 0.8s ease;
height: 200px;
object-fit: cover;
width: 100%;
}
.furniture-card:hover img {
transform: scale(1.05);
}
.furniture-card .card-content {
position: relative;
z-index: 2;
transition: all 0.3s ease;
padding: 15px;
}
.furniture-card:hover .card-content {
transform: translateY(-5px);
}
.furniture-card h3 {
font-size: 1.2rem;
margin-bottom: 0.5rem;
transition: color 0.3s ease;
}
.furniture-card:hover h3 {
color: var(--secondary-color);
}
.furniture-card p {
font-size: 0.9rem;
margin-bottom: 1rem;
color: #666;
}
.furniture-card a {
font-weight: 600;
font-size: 0.9rem;
display: inline-flex;
align-items: center;
color: var(--secondary-color);
transition: all 0.3s ease;
}
.furniture-card a i {
margin-left: 8px;
transition: transform 0.3s ease;
}
.furniture-card:hover a i {
transform: translateX(5px);
}
.calculator-box {
background-color: white;
border-radius: 10px;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
padding: 30px;
max-width: 800px;
margin: 0 auto;
transition: all 0.3s ease;
}
.calculator-box:hover {
transform: translateY(-5px);
box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}
.form-input {
border: 1px solid #e0e0e0;
border-radius: 5px;
padding: 12px 15px;
width: 100%;
margin-bottom: 20px;
transition: all 0.3s ease;
}
.form-input:focus {
border-color: var(--secondary-color);
outline: none;
box-shadow: 0 0 0 3px rgba(201, 169, 97, 0.2);
transform: translateY(-2px);
}
.price-result {
background-color: var(--light-bg);
border-radius: 5px;
padding: 20px;
text-align: center;
margin-top: 20px;
display: none;
transform: translateY(20px);
opacity: 0;
transition: all 0.5s ease;
}
.price-result.show {
display: block;
transform: translateY(0);
opacity: 1;
}
@keyframes fadeIn {
from { opacity: 0; transform: translateY(10px); }
to { opacity: 1; transform: translateY(0); }
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
    padding: 5px 0;
    display: inline-block;
}

.nav-link:after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: var(--secondary-color);
    transition: width 0.3s ease;
}
.nav-link:hover:after {
    width: 100%;
}

.products-link {
    color: var(--primary-color);
    background-color: rgba(201, 169, 97, 0.35);
    padding: 6px 16px;
    border-radius: 20px;
    margin-left: 5px;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    border: 1px solid rgba(201, 169, 97, 0.2);
}

.products-link:hover {
    color: var(--primary-color);
    background-color: rgba(201, 169, 97, 0.25);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.65);
}

.products-link:after {
display: none;
}

@media (max-width: 768px) {
    .nav-link {
        margin: 0 8px;
        padding: 8px 0;
    }
    
    .products-link {
        margin-left: 0;
        margin-top: 8px;
        display: inline-block;
        background-color: rgba(201, 169, 97, 0.15);
    }
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
.gencon-logo {
font-family: 'Playfair Display', serif;
font-weight: 700;
font-size: 7rem;
line-height: 1;
letter-spacing: -2px;
position: relative;
display: inline-block;
}
.gen-part {
color: white;
position: relative;
z-index: 2;
}
.con-part {
color: var(--secondary-color);
position: relative;
z-index: 2;
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
.furniture-section {
padding: 120px 0;
background: linear-gradient(135deg, #f8f8f8 0%, #ffffff 100%);
position: relative;
overflow: hidden;
}
.furniture-section:before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMDEsIDE2OSwgOTcsIDAuMDUpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
opacity: 0.5;
z-index: 0;
}
.furniture-heading {
font-size: 4rem;
margin-bottom: 1.5rem;
position: relative;
display: inline-block;
}
.furniture-heading:after {
content: '';
position: absolute;
bottom: -10px;
left: 0;
width: 80px;
height: 4px;
background-color: var(--secondary-color);
}
/* Enhanced Scroll Down Indicator */
.scroll-indicator {
position: absolute;
bottom: 30px;
left: 50%;
transform: translateX(-50%);
z-index: 10;
cursor: pointer;
animation: bounce 2s infinite;
width: 60px;
height: 80px;
}
.scroll-indicator .mouse {
width: 40px;
height: 60px;
border: 3px solid white;
border-radius: 20px;
position: relative;
margin: 0 auto;
background-color: rgba(255, 255, 255, 0.1);
}
.scroll-indicator .mouse:before {
content: '';
position: absolute;
top: 15px;
left: 50%;
transform: translateX(-50%);
width: 8px;
height: 15px;
background-color: white;
border-radius: 4px;
animation: scroll 1.5s infinite;
}
.scroll-indicator .arrow {
color: white;
font-size: 24px;
text-align: center;
margin-top: 15px;
animation: arrow-bounce 1.5s infinite;
text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
}
@keyframes bounce {
0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
40% { transform: translateX(-50%) translateY(-15px); }
60% { transform: translateX(-50%) translateY(-7px); }
}
@keyframes scroll {
0% { top: 15px; opacity: 1; }
100% { top: 35px; opacity: 0; }
}
@keyframes arrow-bounce {
0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
40% { transform: translateY(8px); }
60% { transform: translateY(4px); }
}
/* Enhanced Animations */
.fade-in-up {
opacity: 0;
transform: translateY(30px);
transition: all 0.8s ease;
}
.fade-in-up.active {
opacity: 1;
transform: translateY(0);
}
.slide-in-left {
opacity: 0;
transform: translateX(-50px);
transition: all 0.8s ease;
}
.slide-in-left.active {
opacity: 1;
transform: translateX(0);
}
.slide-in-right {
opacity: 0;
transform: translateX(50px);
transition: all 0.8s ease;
}
.slide-in-right.active {
opacity: 1;
transform: translateX(0);
}
.scale-in {
opacity: 0;
transform: scale(0.9);
transition: all 0.8s ease;
}
.scale-in.active {
opacity: 1;
transform: scale(1);
}
/* Contact Form Enhancements */
.contact-form input, .contact-form textarea {
transition: all 0.3s ease;
}
.contact-form input:focus, .contact-form textarea:focus {
transform: translateY(-2px);
}
.contact-form button {
position: relative;
overflow: hidden;
}
.contact-form button:after {
content: '';
position: absolute;
top: 50%;
left: 50%;
width: 5px;
height: 5px;
background: rgba(255, 255, 255, 0.5);
opacity: 0;
border-radius: 100%;
transform: scale(1, 1) translate(-50%);
transform-origin: 50% 50%;
}
.contact-form button:focus:not(:active)::after {
animation: ripple 1s ease-out;
}
@keyframes ripple {
0% {
transform: scale(0, 0);
opacity: 0.5;
}
100% {
transform: scale(20, 20);
opacity: 0;
}
}
/* Parallax Elements */
.parallax-element {
position: absolute;
z-index: -1;
opacity: 0.1;
}
.parallax-element.circle-1 {
width: 300px;
height: 300px;
border-radius: 50%;
background-color: var(--secondary-color);
top: 10%;
left: -150px;
}
.parallax-element.circle-2 {
width: 200px;
height: 200px;
border-radius: 50%;
background-color: var(--secondary-color);
bottom: 10%;
right: -100px;
}
.parallax-element.square-1 {
width: 150px;
height: 150px;
background-color: var(--secondary-color);
top: 30%;
right: 10%;
transform: rotate(45deg);
}
/* About Section Enhancements */
.about-section {
background: linear-gradient(to right, #ffffff 50%, #f8f8f8 50%);
position: relative;
}
.about-image {
position: relative;
overflow: hidden;
border-radius: 10px;
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}
.about-image:before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: linear-gradient(135deg, rgba(201, 169, 97, 0.2) 0%, rgba(26, 26, 26, 0.1) 100%);
z-index: 1;
}
.about-image img {
width: 100%;
height: 100%;
object-fit: cover;
transition: transform 0.8s ease;
}
.about-image:hover img {
transform: scale(1.05);
}
.stats-box {
background-color: white;
border-radius: 10px;
padding: 25px;
text-align: center;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
transition: all 0.3s ease;
height: 100%;
}
.stats-box:hover {
transform: translateY(-10px);
box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}
.stats-box i {
font-size: 2.5rem;
color: var(--secondary-color);
margin-bottom: 15px;
}
.stats-box h3 {
font-size: 2.5rem;
font-weight: 700;
margin-bottom: 10px;
color: var(--primary-color);
}
.stats-box p {
color: #666;
font-size: 1rem;
}
.service-box {
background-color: white;
border-radius: 10px;
padding: 30px;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
transition: all 0.3s ease;
height: 100%;
display: flex;
flex-direction: column;
align-items: center;
text-align: center;
}
.service-box:hover {
transform: translateY(-10px);
box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}
.service-box i {
font-size: 3rem;
color: var(--secondary-color);
margin-bottom: 20px;
}
.service-box h3 {
font-size: 1.5rem;
margin-bottom: 15px;
color: var(--primary-color);
}
.service-box p {
color: #666;
line-height: 1.6;
}
.mission-statement {
background-color: var(--primary-color);
color: white;
padding: 60px 40px;
border-radius: 10px;
position: relative;
overflow: hidden;
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}
.mission-statement:before {
content: '"';
position: absolute;
top: 20px;
left: 20px;
font-size: 120px;
font-family: 'Playfair Display', serif;
color: rgba(255, 255, 255, 0.1);
line-height: 1;
}
.mission-statement h3 {
font-size: 2rem;
margin-bottom: 20px;
position: relative;
z-index: 1;
}
.mission-statement p {
font-size: 1.1rem;
line-height: 1.8;
position: relative;
z-index: 1;
}
/* Image Slider Styles */
.slider-container {
position: relative;
max-width: 100%;
margin: 0 auto;
overflow: hidden;
border-radius: 15px;
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}
.slider {
display: flex;
transition: transform 0.5s ease-in-out;
}
.slide {
min-width: 100%;
position: relative;
}
.slide img {
width: 100%;
height: 500px;
object-fit: cover;
display: block;
}
.slide-content {
position: absolute;
bottom: 0;
left: 0;
right: 0;
background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 100%);
color: white;
padding: 30px;
text-align: center;
}
.slide-content h3 {
font-size: 2rem;
margin-bottom: 10px;
}
.slide-content p {
font-size: 1.1rem;
max-width: 800px;
margin: 0 auto;
}
.slider-nav {
position: absolute;
bottom: 20px;
left: 50%;
transform: translateX(-50%);
display: flex;
gap: 10px;
z-index: 10;
}
.nav-dot {
width: 12px;
height: 12px;
border-radius: 50%;
background-color: rgba(255, 255, 255, 0.5);
cursor: pointer;
transition: background-color 0.3s ease;
}
.nav-dot.active {
background-color: var(--secondary-color);
}
.slider-arrows {
position: absolute;
top: 50%;
width: 100%;
display: flex;
justify-content: space-between;
padding: 0 20px;
transform: translateY(-50%);
z-index: 10;
}
.slider-arrow {
background-color: rgba(255, 255, 255, 0.3);
color: white;
border: none;
width: 40px;
height: 40px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
transition: all 0.3s ease;
}
.slider-arrow:hover {
background-color: var(--secondary-color);
}
.difference-text {
font-size: 1.1rem;
line-height: 1.6;
color: #555;
margin-bottom: 30px;
max-width: 800px;
text-align: center;
margin-left: auto;
margin-right: auto;
}
/* Material Samples Styles - Integrated with Form */
.form-group {
margin-bottom: 30px;
}
.form-group label {
display: block;
text-gray-700 font-medium mb-2;
margin-bottom: 10px;
}
.sample-grid {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
gap: 15px;
margin-top: 15px;
}
.sample-item {
border-radius: 8px;
overflow: hidden;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
cursor: pointer;
transition: all 0.3s ease;
position: relative;
}
.sample-item:hover {
transform: translateY(-5px);
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
.sample-item.selected {
outline: 3px solid var(--secondary-color);
outline-offset: 2px;
}
.sample-swatch {
height: 80px;
display: flex;
align-items: center;
justify-content: center;
}
.sample-label {
padding: 8px;
text-align: center;
font-size: 0.85rem;
background-color: white;
color: var(--text-color);
}
/* Kitchen Shape Styles */
.kitchen-shape-grid {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 15px;
margin-top: 15px;
}
.kitchen-shape-item {
border-radius: 8px;
overflow: hidden;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
cursor: pointer;
transition: all 0.3s ease;
position: relative;
}
.kitchen-shape-item:hover {
transform: translateY(-5px);
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
.kitchen-shape-item.selected {
outline: 3px solid var(--secondary-color);
outline-offset: 2px;
}
.kitchen-shape-img {
height: 120px;
width: 100%;
object-fit: cover;
display: block;
}
.kitchen-shape-label {
padding: 10px;
text-align: center;
font-size: 0.9rem;
background-color: white;
color: var(--text-color);
font-weight: 500;
}
/* Info Button Styles */
.info-button {
position: absolute;
top: 5px;
right: 5px;
background-color: rgba(255, 255, 255, 0.8);
color: var(--primary-color);
border: none;
width: 24px;
height: 24px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
z-index: 10;
font-size: 12px;
transition: all 0.2s ease;
}
.info-button:hover {
background-color: var(--secondary-color);
color: white;
}
/* Preview Modal Styles */
.preview-modal {
display: none;
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.8);
z-index: 1000;
justify-content: center;
align-items: center;
}
.preview-modal.active {
display: flex;
}
.preview-content {
background-color: white;
border-radius: 10px;
max-width: 90%;
max-height: 90%;
overflow: hidden;
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
position: relative;
}
.preview-close {
position: absolute;
top: 15px;
right: 15px;
background: none;
border: none;
font-size: 24px;
cursor: pointer;
color: var(--text-color);
z-index: 1001;
width: 40px;
height: 40px;
display: flex;
align-items: center;
justify-content: center;
border-radius: 50%;
transition: all 0.3s ease;
}
.preview-close:hover {
background-color: rgba(0, 0, 0, 0.1);
}
.preview-image-container {
padding: 20px;
text-align: center;
}
.preview-image {
max-width: 100%;
max-height: 400px;
border-radius: 8px;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}
.preview-color-container {
padding: 40px 20px 20px;
text-align: center;
}
.preview-color {
width: 200px;
height: 200px;
border-radius: 8px;
margin: 0 auto;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}
.preview-title {
font-size: 1.5rem;
font-weight: 600;
margin: 20px 0 10px;
color: var(--primary-color);
}
.preview-description {
font-size: 1rem;
color: #666;
max-width: 500px;
margin: 0 auto;
}
/* Wood Sample Colors */
.white-oak { background-color: #f0e6d2; }
.red-oak { background-color: #a0522d; }
.walnut { background-color: #5d4037; }
.glossy-white { background-color: #ffffff; border: 1px solid #e0e0e0; }
.glossy-black { background-color: #1a1a1a; }
.natural-veneer { background-color: #d7ccc8; }
/* Counter Top Sample Colors */
.granite-black { background-color: #2c2c2c; }
.granite-white { background-color: #f5f5f5; }
.granite-gray { background-color: #9e9e9e; }
.ceramic-beige { background-color: #e6d7b7; }
.ceramic-blue { background-color: #a7c5eb; }
.resin-clear { background-color: rgba(255, 255, 255, 0.7); border: 1px solid #e0e0e0; }
.resin-gold { background-color: rgba(201, 169, 97, 0.7); }
.quartz-white { background-color: #f8f8f8; }
.quartz-black { background-color: #333333; }
/* Selected option highlight */
.selected-option {
color: var(--secondary-color) !important;
font-weight: 600 !important;
}
/* Wishlist Icon */
.wishlist-icon {
position: absolute;
top: 15px;
right: 15px;
width: 40px;
height: 40px;
background-color: rgba(255, 255, 255, 0.8);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
z-index: 10;
cursor: pointer;
transition: all 0.3s ease;
}
.wishlist-icon:hover {
background-color: white;
transform: scale(1.1);
}
.wishlist-icon.active {
background-color: var(--secondary-color);
}
.wishlist-icon.active i {
color: white;
}
.wishlist-icon i {
color: var(--primary-color);
font-size: 18px;
transition: all 0.3s ease;
}
/* Newsletter Popup */
.newsletter-popup {
display: none;
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.7);
z-index: 1000;
justify-content: center;
align-items: center;
padding: 20px;
}
.newsletter-popup.active {
display: flex;
}
.newsletter-content {
background-color: white;
border-radius: 15px;
max-width: 500px;
width: 100%;
padding: 40px;
position: relative;
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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
.newsletter-close {
position: absolute;
top: 15px;
right: 15px;
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
.newsletter-close:hover {
background-color: rgba(0, 0, 0, 0.1);
}
.newsletter-title {
font-size: 28px;
font-weight: 700;
margin-bottom: 15px;
color: var(--primary-color);
}
.newsletter-subtitle {
font-size: 18px;
margin-bottom: 25px;
color: #666;
}
.newsletter-form {
margin-bottom: 20px;
}
.newsletter-input {
width: 100%;
padding: 15px;
border: 1px solid #e0e0e0;
border-radius: 8px;
margin-bottom: 15px;
font-size: 16px;
transition: all 0.3s ease;
}
.newsletter-input:focus {
border-color: var(--secondary-color);
outline: none;
box-shadow: 0 0 0 3px rgba(201, 169, 97, 0.2);
}
.newsletter-btn {
width: 100%;
padding: 15px;
background-color: var(--secondary-color);
color: white;
border: none;
border-radius: 8px;
font-size: 16px;
font-weight: 600;
cursor: pointer;
transition: all 0.3s ease;
}
.newsletter-btn:hover {
background-color: #b89356;
transform: translateY(-2px);
}
.newsletter-discount {
text-align: center;
font-size: 24px;
font-weight: 700;
color: var(--secondary-color);
margin-top: 20px;
}
/* Search Bar */
.search-container {
position: relative;
margin-left: auto;
margin-right: 20px;
display: flex;
align-items: center;
}
.search-input {
width: 0;
padding: 0;
border: none;
border-radius: 20px;
background-color: rgba(255, 255, 255, 0.9);
color: var(--primary-color);
font-size: 16px;
transition: all 0.3s ease;
position: relative;
right: 0;
}
.search-input.active {
width: 200px;
padding: 8px 15px;
border: 1px solid var(--secondary-color);
margin-right: 10px;
}
.search-btn {
background: none;
border: none;
color: var(--primary-color);
font-size: 20px;
cursor: pointer;
padding: 8px;
transition: all 0.3s ease;
position: relative;
z-index: 2;
}
.search-btn:hover {
color: var(--secondary-color);
}
/* Search Filters */
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
/* Product Section Styles */
.product-section {
margin-bottom: 60px;
position: relative;
}
.section-header {
display: flex;
align-items: center;
justify-content: space-between;
margin-bottom: 30px;
}
.section-title {
font-size: 2.5rem;
font-weight: 700;
position: relative;
display: inline-block;
}
.section-title:after {
content: '';
position: absolute;
bottom: -10px;
left: 0;
width: 60px;
height: 4px;
background-color: var(--secondary-color);
}
.section-badge {
background-color: var(--secondary-color);
color: white;
padding: 8px 16px;
border-radius: 20px;
font-weight: 600;
font-size: 0.9rem;
text-transform: uppercase;
letter-spacing: 1px;
}
.product-scroll-container {
position: relative;
overflow: hidden;
margin-bottom: 20px;
}
.product-scroll-wrapper {
display: flex;
overflow-x: auto;
scroll-behavior: smooth;
scrollbar-width: thin;
scrollbar-color: var(--secondary-color) #f1f1f1;
padding-bottom: 20px;
-webkit-overflow-scrolling: touch;
}
.product-scroll-wrapper::-webkit-scrollbar {
height: 8px;
}
.product-scroll-wrapper::-webkit-scrollbar-track {
background: #f1f1f1;
border-radius: 10px;
}
.product-scroll-wrapper::-webkit-scrollbar-thumb {
background-color: var(--secondary-color);
border-radius: 10px;
}
.product-grid {
display: flex;
gap: 20px;
}
.scroll-btn {
position: absolute;
top: 50%;
transform: translateY(-50%);
width: 50px;
height: 50px;
background-color: white;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
cursor: pointer;
z-index: 10;
transition: all 0.3s ease;
}
.scroll-btn:hover {
background-color: var(--secondary-color);
color: white;
}
.scroll-btn.prev {
left: 0px;
}
.scroll-btn.next {
right: 0px;
}
/* New item animation */
.new-item {
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(201, 169, 97, 0.4);
  }
  70% {
    box-shadow: 0 0 0 10px rgba(201, 169, 97, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(201, 169, 97, 0);
  }
}
/* Notification Styles */
.notification {
position: fixed;
top: 20px;
right: 20px;
padding: 15px 20px;
border-radius: 8px;
color: white;
font-weight: 500;
z-index: 1000;
transform: translateX(120%);
transition: transform 0.3s ease;
max-width: 300px;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
.notification.show {
transform: translateX(0);
}
.notification.success {
background-color: #4CAF50;
}
.notification.error {
background-color: #F44336;
}
.notification.info {
background-color: #2196F3;
}
.notification.warning {
background-color: #FF9800;
}
@media (max-width: 768px) {
.hero-bg {
background-attachment: scroll;
}
.parallax {
background-attachment: scroll;
}
.section-padding {
padding: 50px 0;
}
.furniture-section {
padding: 80px 0;
}
.gencon-logo {
font-size: 4rem;
}
.furniture-heading {
font-size: 2.5rem;
}
.parallax-element {
display: none;
}
.about-section {
background: #ffffff;
}
.mission-statement {
padding: 40px 30px;
}
.mission-statement h3 {
font-size: 1.5rem;
}
.mission-statement p {
font-size: 1rem;
}
.slide img {
height: 300px;
}
.slide-content h3 {
font-size: 1.5rem;
}
.slide-content p {
font-size: 1rem;
}
.sample-grid {
grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
}
.kitchen-shape-grid {
grid-template-columns: 1fr;
}
.preview-content {
max-width: 95%;
}
.search-container {
margin-right: 10px;
}
.search-input.active {
width: 150px;
}
.filter-container {
display: none;
}
.mobile-filter-btn {
display: flex;
}
.furniture-card {
flex: 0 0 calc(50% - 10px);
margin-right: 10px;
}
.section-title {
font-size: 2rem;
}
.scroll-btn {
width: 40px;
height: 40px;
}
.nav-link {
margin: 0 8px;
}
.products-link {
margin-left: 0;
margin-top: 8px;
display: inline-block;
}
}
@media (max-width: 480px) {
.furniture-card {
flex: 0 0 100%;
margin-right: 0;
}
.section-title {
font-size: 1.8rem;
}
.navbar-brand {
font-size: 20px;
}
.gencon-logo {
font-size: 3rem;
}
}
</style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar fixed top-0 left-0 right-0 z-50 py-4 px-6">
<div class="container mx-auto flex justify-between items-center">
<a href="#" class="navbar-brand">
<span class="navbar-gen-part">GEN</span><span class="navbar-con-part">CON</span>
</a>
<div class="hidden md:flex">
<a href="#home" class="nav-link">Home</a>
<a href="#about" class="nav-link">About</a>
<a href="#furniture" class="nav-link">Furniture</a>
<a href="#calculator" class="nav-link">Calculator</a>
<a href="#contact" class="nav-link">Contact</a>
<a href="products.php" class="nav-link products-link">Products</a>
</div>
<!-- Search Bar -->
<div class="search-container">
<input type="text" class="search-input" placeholder="Search products...">
<button class="search-btn">
<i class="fas fa-search"></i>
</button>
</div>
<button id="mobile-menu-btn" class="md:hidden">
<i class="fas fa-bars text-xl"></i>
</button>
</div>
<!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden bg-white mt-4 py-4 px-6 rounded-lg shadow-lg">
<a href="#home" class="block py-2 nav-link">Home</a>
<a href="#about" class="block py-2 nav-link">About</a>
<a href="#furniture" class="block py-2 nav-link">Furniture</a>
<a href="#calculator" class="block py-2 nav-link">Calculator</a>
<a href="#contact" class="block py-2 nav-link">Contact</a>
<a href="products.php" class="block py-2 products-link">Products</a>
<!-- Mobile Search -->
<div class="mt-4">
<input type="text" class="form-input" placeholder="Search products...">
</div>
</div>
</nav>
<!-- Hero Section -->
<section id="home" class="hero-bg min-h-screen flex items-center justify-center text-white">
<!-- Parallax Elements -->
<div class="parallax-element circle-1"></div>
<div class="parallax-element circle-2"></div>
<div class="parallax-element square-1"></div>
<div class="container mx-auto px-6 text-center">
<div class="fade-in-up" data-aos="fade-up" data-aos-duration="1000">
<h1 class="gencon-logo mb-8">
<span class="gen-part">GEN</span><span class="con-part">CON</span>
</h1>
<p class="text-xl md:text-2xl mb-4">Consultancy | General Contracting | Renovations | Fit-Outs</p>
<p class="text-lg md:text-xl mb-8">Turning ideas into reality 📍Lebanon 📍Dubai</p>
<div class="flex justify-center items-center mb-10">
<a href="tel:+96179399677" class="flex items-center text-xl">
<i class="fas fa-phone mr-3"></i> +961 79 399 677
</a>
</div>
<a href="#about" class="btn-primary py-3 px-8 rounded-full inline-block">
Discover More
</a>
</div>
</div>
<!-- Enhanced Scroll Down Indicator -->
<div class="scroll-indicator" id="scroll-indicator">
<div class="mouse"></div>
<div class="arrow">
<i class="fas fa-chevron-down"></i>
</div>
</div>
</section>
<!-- About Section -->
<section id="about" class="section-padding about-section">
<div class="container mx-auto px-6">
<div class="mb-16 text-center" data-aos="fade-up">
<h2 class="text-4xl font-bold mb-4">Why Choose GENCON?</h2>
<p class="text-gray-600 max-w-2xl mx-auto">We don't just build spaces, we craft experiences that inspire and endure.</p>
</div>
<!-- Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16" data-aos="fade-up" data-aos-delay="100">
<div class="stats-box">
<i class="fas fa-building"></i>
<h3>150+</h3>
<p>Projects Completed</p>
</div>
<div class="stats-box">
<i class="fas fa-users"></i>
<h3>50+</h3>
<p>Expert Team Members</p>
</div>
<div class="stats-box">
<i class="fas fa-award"></i>
<h3>15</h3>
<p>Years of Excellence</p>
</div>
<div class="stats-box">
<i class="fas fa-smile"></i>
<h3>100%</h3>
<p>Client Satisfaction</p>
</div>
</div>
<!-- Mission Statement -->
<div class="mission-statement mb-16" data-aos="fade-up" data-aos-delay="200">
<h3>Our Mission</h3>
<p>To transform spaces into extraordinary environments that blend functionality, aesthetics, and innovation. We approach each project as a unique opportunity to push boundaries and create spaces that not only meet our clients' needs but exceed their wildest expectations.</p>
</div>
<!-- Services Section -->
<div class="mb-16" data-aos="fade-up" data-aos-delay="300">
<h3 class="text-3xl font-bold mb-8 text-center">What Sets Us Apart</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="service-box">
<i class="fas fa-lightbulb"></i>
<h3>Innovative Design</h3>
<p>We blend cutting-edge design principles with practical functionality to create spaces that are both beautiful and highly efficient. Our design team stays ahead of trends while ensuring timeless appeal.</p>
</div>
<div class="service-box">
<i class="fas fa-handshake"></i>
<h3>Client-Centered Approach</h3>
<p>Your vision is our priority. We collaborate closely with you throughout the entire process, ensuring that every detail aligns with your expectations and lifestyle needs.</p>
</div>
<div class="service-box">
<i class="fas fa-gem"></i>
<h3>Uncompromising Quality</h3>
<p>We source the finest materials and work with skilled craftsmen to deliver exceptional results. Our commitment to quality is evident in every project we undertake.</p>
</div>
</div>
</div>
<!-- Image Slider Section -->
<div class="mb-16" data-aos="fade-up" data-aos-delay="400">
<h3 class="text-3xl font-bold mb-8 text-center">The GENCON Difference</h3>
<p class="difference-text">
Where creativity meets precision, and dreams transform into tangible masterpieces. We craft spaces that inspire, endure, and tell your unique story.
</p>
<div class="slider-container">
<div class="slider" id="image-slider">
<div class="slide">
<img src="images/random1.jpg" alt="Project 1">
<div class="slide-content">
<h3>Exceptional Craftsmanship</h3>
<p>Every detail meticulously crafted to perfection, creating spaces that stand the test of time.</p>
</div>
</div>
<div class="slide">
<img src="images/random2.jpg" alt="Project 2">
<div class="slide-content">
<h3>Innovative Solutions</h3>
<p>Transforming challenges into opportunities with creative design and expert execution.</p>
</div>
</div>
<div class="slide">
<img src="images/random3.jpg" alt="Project 3">
<div class="slide-content">
<h3>Timeless Elegance</h3>
<p>Creating spaces that blend contemporary style with classic sophistication.</p>
</div>
</div>
<div class="slide">
<img src="images/random4.jpg" alt="Project 4">
<div class="slide-content">
<h3>Bespoke Excellence</h3>
<p>Custom-designed solutions tailored to your unique vision and lifestyle needs.</p>
</div>
</div>
</div>
<div class="slider-nav">
<div class="nav-dot active" data-slide="0"></div>
<div class="nav-dot" data-slide="1"></div>
<div class="nav-dot" data-slide="2"></div>
<div class="nav-dot" data-slide="3"></div>
</div>
<div class="slider-arrows">
<button class="slider-arrow prev" id="prev-slide">
<i class="fas fa-chevron-left"></i>
</button>
<button class="slider-arrow next" id="next-slide">
<i class="fas fa-chevron-right"></i>
</button>
</div>
</div>
<div class="text-center mt-8">
<a href="#furniture" class="btn-primary py-3 px-8 rounded-full inline-block">
Explore Our Work
</a>
</div>
</div>
</div>
</section>
<!-- Furniture Section -->
<section id="furniture" class="furniture-section">
<div class="container mx-auto px-6 relative z-10">
<div class="text-center mb-16 fade-in-up" data-aos="fade-up">
<h2 class="furniture-heading">Furniture Collection</h2>
<p class="text-gray-600 max-w-2xl mx-auto text-lg">Discover our exquisite range of furniture designed to elevate your living and working spaces.</p>
</div>

<!-- Search Filters -->
<div class="filter-container">
<h3 class="filter-title">Filter Products</h3>
<div class="filter-group">
<span class="filter-label">Category</span>
<div class="filter-options">
<div class="filter-option active" data-filter="all">All</div>
<div class="filter-option" data-filter="sofas">Sofas</div>
<div class="filter-option" data-filter="chairs">Chairs</div>
<div class="filter-option" data-filter="tables">Tables</div>
<div class="filter-option" data-filter="dining-tables">Dining Tables</div>
<div class="filter-option" data-filter="coffee-tables">Coffee Tables</div>
<div class="filter-option" data-filter="night-stands">Night Stands</div>
<div class="filter-option" data-filter="bar">Bar</div>
<div class="filter-option" data-filter="bar-stools">Bar Stools</div>
<div class="filter-option" data-filter="armchairs">Armchairs</div>
<div class="filter-option" data-filter="cushions">Cushions</div>
<div class="filter-option" data-filter="dining-cabinets">Dining Cabinets</div>
<div class="filter-option" data-filter="bedroom-sets">Bedroom Sets</div>
<div class="filter-option" data-filter="beds">Beds</div>
<div class="filter-option" data-filter="closets">Closets</div>
<div class="filter-option" data-filter="outdoor-sets">Outdoor Sets</div>
<div class="filter-option" data-filter="outdoor-sofas">Outdoor Sofas</div>
<div class="filter-option" data-filter="swings">Swings</div>
<div class="filter-option" data-filter="outdoor-tables">Outdoor Tables</div>
<div class="filter-option" data-filter="outdoor-chairs">Outdoor Chairs</div>
<div class="filter-option" data-filter="outdoor-bar">Outdoor Bar</div>
<div class="filter-option" data-filter="outdoor-stools">Outdoor Stools</div>
<div class="filter-option" data-filter="pergolas">Pergolas</div>
<div class="filter-option" data-filter="umbrellas">Umbrellas</div>
<div class="filter-option" data-filter="coolers">Coolers</div>
<div class="filter-option" data-filter="bbq">BBQ</div>
<div class="filter-option" data-filter="fire-pits">Fire Pits</div>
<div class="filter-option" data-filter="kitchen">Kitchen</div>
</div>
</div>
<div class="filter-group">
<span class="filter-label">Price Range</span>
<div class="price-range">
<input type="number" class="price-input" placeholder="Min" min="0">
<span>-</span>
<input type="number" class="price-input" placeholder="Max" min="0">
</div>
</div>
<button class="filter-apply">Apply Filters</button>
</div>

<!-- Indoor Furniture Section -->
<div class="product-section">
<div class="section-header">
<div>
<h3 class="section-title">Indoor Collection</h3>
<p class="text-gray-600 mt-2">Elegant furniture for sophisticated interiors</p>
</div>
<div class="section-badge">Premium Living</div>
</div>
<div class="product-scroll-container">
<button class="scroll-btn prev" id="indoor-prev">
<i class="fas fa-chevron-left"></i>
</button>
<button class="scroll-btn next" id="indoor-next">
<i class="fas fa-chevron-right"></i>
</button>
<div class="product-scroll-wrapper" id="indoor-wrapper">
<div class="product-grid" id="indoor-products">
<?php if (!empty($indoorCategories)): ?>
    <?php foreach ($indoorCategories as $index => $category): ?>
        <div class="furniture-card scale-in" data-aos="fade-up" data-aos-delay="<?php echo ($index+1)*100; ?>" data-category="<?php echo htmlspecialchars($category['name']); ?>">
            <div class="wishlist-icon" data-product="<?php echo htmlspecialchars($category['id']); ?>">
                <i class="far fa-heart"></i>
            </div>
            <div class="h-48 overflow-hidden">
                <img src="<?php echo htmlspecialchars($category['pic']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="w-full h-full object-cover">
            </div>
            <div class="p-4 card-content">
                <h3 class="text-lg font-bold mb-1"><?php echo htmlspecialchars($category['name']); ?></h3>
                <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($category['description']); ?></p>
                <a href="#" class="text-primary font-medium text-sm">View Collection <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-gray-500">No indoor categories available at the moment.</p>
<?php endif; ?>
</div>
</div>
</div>
<div class="text-center mt-6">
<a href="products.html?type=Indoor" class="btn-primary py-2 px-6 rounded-full inline-block">
View All Indoor Products
</a>
</div>
</div>

<!-- Outdoor Furniture Section -->
<div class="product-section">
<div class="section-header">
<div>
<h3 class="section-title">Outdoor Collection</h3>
<p class="text-gray-600 mt-2">Durable furniture designed for outdoor living</p>
</div>
<div class="section-badge">Alfresco Luxury</div>
</div>
<div class="product-scroll-container">
<button class="scroll-btn prev" id="outdoor-prev">
<i class="fas fa-chevron-left"></i>
</button>
<button class="scroll-btn next" id="outdoor-next">
<i class="fas fa-chevron-right"></i>
</button>
<div class="product-scroll-wrapper" id="outdoor-wrapper">
<div class="product-grid" id="outdoor-products">
<?php if (!empty($outdoorCategories)): ?>
    <?php foreach ($outdoorCategories as $index => $category): ?>
        <div class="furniture-card scale-in" data-aos="fade-up" data-aos-delay="<?php echo ($index+1)*100; ?>" data-category="<?php echo htmlspecialchars($category['name']); ?>">
            <div class="wishlist-icon" data-product="<?php echo htmlspecialchars($category['id']); ?>">
                <i class="far fa-heart"></i>
            </div>
            <div class="h-48 overflow-hidden">
                <img src="<?php echo htmlspecialchars($category['pic']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="w-full h-full object-cover">
            </div>
            <div class="p-4 card-content">
                <h3 class="text-lg font-bold mb-1"><?php echo htmlspecialchars($category['name']); ?></h3>
                <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($category['description']); ?></p>
                <a href="#" class="text-primary font-medium text-sm">View Collection <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-gray-500">No outdoor categories available at the moment.</p>
<?php endif; ?>
</div>
</div>
</div>
<div class="text-center mt-6">
<a href="products.html?type=Outdoor" class="btn-primary py-2 px-6 rounded-full inline-block">
View All Outdoor Products
</a>
</div>
</div>
</div>
</section>
<!-- Kitchen Price Calculator -->
<section id="calculator" class="section-padding parallax" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/7.jpg');">
<div class="container mx-auto px-6">
<div class="text-center mb-16 fade-in-up" data-aos="fade-up">
<h2 class="text-4xl font-bold mb-4 text-white">Kitchen Price Calculator</h2>
<p class="text-gray-200 max-w-2xl mx-auto">Get an instant estimate for your custom kitchen cabinets.</p>
</div>
<div class="calculator-box scale-in" data-aos="fade-up" data-aos-delay="200">
<!-- Kitchen Length -->
<div class="form-group">
<label for="kitchen-length" class="block text-gray-700 font-medium mb-2">Kitchen Length (meters)</label>
<input type="number" id="kitchen-length" class="form-input" placeholder="Enter kitchen length in meters" min="1" step="0.1">
</div>
<!-- Kitchen Shape -->
<div class="form-group">
<label class="block text-gray-700 font-medium mb-2">Kitchen Shape</label>
<select id="kitchen-shape" class="form-input">
<option value="">Select kitchen shape</option>
<option value="straight" data-multiplier="1">Straight</option>
<option value="l-shaped" data-multiplier="1.2">L-shaped</option>
<option value="u-shaped" data-multiplier="1.5">U-shaped</option>
</select>
<div class="kitchen-shape-grid">
<div class="kitchen-shape-item" data-kitchen-shape="straight" data-shape-multiplier="1" data-shape-name="Straight Kitchen">
<img src="images/kitchen1.jpg" alt="Straight Kitchen" class="kitchen-shape-img">
<div class="kitchen-shape-label">Straight</div>
<button class="info-button" data-info-type="image" data-info-name="Straight Kitchen" data-info-src="images/kitchen1.jpg" data-info-description="A straight kitchen layout that maximizes space and functionality along a single wall. Ideal for small spaces and open-plan living areas.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="kitchen-shape-item" data-kitchen-shape="l-shaped" data-shape-multiplier="1.2" data-shape-name="L-shaped Kitchen">
<img src="images/kitchen2.jpg" alt="L-shaped Kitchen" class="kitchen-shape-img">
<div class="kitchen-shape-label">L-shaped</div>
<button class="info-button" data-info-type="image" data-info-name="L-shaped Kitchen" data-info-src="images/kitchen2.jpg" data-info-description="An L-shaped kitchen layout that provides ample counter space and storage. Perfect for corner spaces and creating a natural work triangle.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="kitchen-shape-item" data-kitchen-shape="u-shaped" data-shape-multiplier="1.5" data-shape-name="U-shaped Kitchen">
<img src="images/kitchen3.jpg" alt="U-shaped Kitchen" class="kitchen-shape-img">
<div class="kitchen-shape-label">U-shaped</div>
<button class="info-button" data-info-type="image" data-info-name="U-shaped Kitchen" data-info-src="images/kitchen3.jpg" data-info-description="A U-shaped kitchen layout that offers maximum storage and counter space. Creates an efficient work triangle and ideal for serious cooks.">
<i class="fas fa-info"></i>
</button>
</div>
</div>
</div>
<!-- Wood Type -->
<div class="form-group">
<label class="block text-gray-700 font-medium mb-2">Wood Type</label>
<select id="wood-type" class="form-input">
<option value="">Select wood type</option>
<option value="white-oak" data-price="850">White Oak</option>
<option value="red-oak" data-price="800">Red Oak</option>
<option value="walnut" data-price="950">Walnut</option>
<option value="glossy-white" data-price="750">Glossy White</option>
<option value="glossy-black" data-price="780">Glossy Black</option>
<option value="natural-veneer" data-price="700">Natural Veneer</option>
</select>
<div class="sample-grid">
<div class="sample-item" data-wood-type="white-oak" data-wood-price="850" data-wood-name="White Oak">
<div class="sample-swatch white-oak"></div>
<div class="sample-label">White Oak</div>
<button class="info-button" data-info-type="color" data-info-name="White Oak" data-info-color="white-oak" data-info-description="Premium White Oak with a beautiful light grain and durable finish. Resistant to wear and perfect for modern kitchens.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-wood-type="red-oak" data-wood-price="800" data-wood-name="Red Oak">
<div class="sample-swatch red-oak"></div>
<div class="sample-label">Red Oak</div>
<button class="info-button" data-info-type="color" data-info-name="Red Oak" data-info-color="red-oak" data-info-description="Rich Red Oak with distinctive grain patterns. Warm tones that add character to any kitchen space.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-wood-type="walnut" data-wood-price="950" data-wood-name="Walnut">
<div class="sample-swatch walnut"></div>
<div class="sample-label">Walnut</div>
<button class="info-button" data-info-type="color" data-info-name="Walnut" data-info-color="walnut" data-info-description="Luxurious Walnut with deep, rich tones. Premium hardwood that adds elegance and sophistication to your kitchen.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-wood-type="glossy-white" data-wood-price="750" data-wood-name="Glossy White">
<div class="sample-swatch glossy-white"></div>
<div class="sample-label">Glossy White</div>
<button class="info-button" data-info-type="color" data-info-name="Glossy White" data-info-color="glossy-white" data-info-description="Sleek Glossy White finish that reflects light and makes spaces appear larger. Modern and easy to clean.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-wood-type="glossy-black" data-wood-price="780" data-wood-name="Glossy Black">
<div class="sample-swatch glossy-black"></div>
<div class="sample-label">Glossy Black</div>
<button class="info-button" data-info-type="color" data-info-name="Glossy Black" data-info-color="glossy-black" data-info-description="Bold Glossy Black for dramatic, contemporary kitchens. Creates striking contrast and visual impact.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-wood-type="natural-veneer" data-wood-price="700" data-wood-name="Natural Veneer">
<div class="sample-swatch natural-veneer"></div>
<div class="sample-label">Natural Veneer</div>
<button class="info-button" data-info-type="color" data-info-name="Natural Veneer" data-info-color="natural-veneer" data-info-description="Natural Wood Veneer showcasing authentic wood grain. Eco-friendly option with the beauty of real wood.">
<i class="fas fa-info"></i>
</button>
</div>
</div>
</div>
<!-- Quality Level -->
<div class="form-group">
<label for="quality-level" class="block text-gray-700 font-medium mb-2">Quality/Finish Level</label>
<select id="quality-level" class="form-input">
<option value="">Select quality level</option>
<option value="standard" data-multiplier="1">Standard</option>
<option value="premium" data-multiplier="1.5">Premium</option>
<option value="luxury" data-multiplier="2">Luxury</option>
</select>
</div>
<!-- Counter Top Material -->
<div class="form-group">
<label class="block text-gray-700 font-medium mb-2">Counter Top Material</label>
<select id="counter-top-material" class="form-input">
<option value="">Select counter top material</option>
<option value="granite-black" data-price="600">Granite - Black</option>
<option value="granite-white" data-price="650">Granite - White</option>
<option value="granite-gray" data-price="620">Granite - Gray</option>
<option value="ceramic-beige" data-price="400">Ceramic - Beige</option>
<option value="ceramic-blue" data-price="420">Ceramic - Blue</option>
<option value="resin-clear" data-price="700">Resin - Clear</option>
<option value="resin-gold" data-price="750">Resin - Gold</option>
<option value="quartz-white" data-price="800">Quartz - White</option>
<option value="quartz-black" data-price="850">Quartz - Black</option>
</select>
<div class="sample-grid">
<div class="sample-item" data-counter-top-type="granite-black" data-counter-top-price="600" data-counter-top-name="Granite Black">
<div class="sample-swatch granite-black"></div>
<div class="sample-label">Granite Black</div>
<button class="info-button" data-info-type="color" data-info-name="Granite Black" data-info-color="granite-black" data-info-description="Durable Black Granite with natural variations. Heat and scratch resistant, perfect for busy kitchens.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="granite-white" data-counter-top-price="650" data-counter-top-name="Granite White">
<div class="sample-swatch granite-white"></div>
<div class="sample-label">Granite White</div>
<button class="info-button" data-info-type="color" data-info-name="Granite White" data-info-color="granite-white" data-info-description="Elegant White Granite with subtle patterns. Brightens spaces and complements any cabinet color.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="granite-gray" data-counter-top-price="620" data-counter-top-name="Granite Gray">
<div class="sample-swatch granite-gray"></div>
<div class="sample-label">Granite Gray</div>
<button class="info-button" data-info-type="color" data-info-name="Granite Gray" data-info-color="granite-gray" data-info-description="Versatile Gray Granite with medium tone. Hides stains and complements both modern and traditional designs.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="ceramic-beige" data-counter-top-price="400" data-counter-top-name="Ceramic Beige">
<div class="sample-swatch ceramic-beige"></div>
<div class="sample-label">Ceramic Beige</div>
<button class="info-button" data-info-type="color" data-info-name="Ceramic Beige" data-info-color="ceramic-beige" data-info-description="Warm Beige Ceramic tiles. Affordable option with easy maintenance and timeless appeal.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="ceramic-blue" data-counter-top-price="420" data-counter-top-name="Ceramic Blue">
<div class="sample-swatch ceramic-blue"></div>
<div class="sample-label">Ceramic Blue</div>
<button class="info-button" data-info-type="color" data-info-name="Ceramic Blue" data-info-color="ceramic-blue" data-info-description="Vibrant Blue Ceramic tiles. Adds a pop of color and creates a fresh, clean look in your kitchen.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="resin-clear" data-counter-top-price="700" data-counter-top-name="Resin Clear">
<div class="sample-swatch resin-clear"></div>
<div class="sample-label">Resin Clear</div>
<button class="info-button" data-info-type="color" data-info-name="Resin Clear" data-info-color="resin-clear" data-info-description="Modern Clear Resin with customizable embedded elements. Creates depth and visual interest in contemporary kitchens.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="resin-gold" data-counter-top-price="750" data-counter-top-name="Resin Gold">
<div class="sample-swatch resin-gold"></div>
<div class="sample-label">Resin Gold</div>
<button class="info-button" data-info-type="color" data-info-name="Resin Gold" data-info-color="resin-gold" data-info-description="Luxurious Gold Resin with metallic shimmer. Adds warmth and sophistication to upscale kitchen designs.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="quartz-white" data-counter-top-price="800" data-counter-top-name="Quartz White">
<div class="sample-swatch quartz-white"></div>
<div class="sample-label">Quartz White</div>
<button class="info-button" data-info-type="color" data-info-name="Quartz White" data-info-color="quartz-white" data-info-description="Premium White Quartz with consistent pattern. Non-porous surface resists stains and bacteria.">
<i class="fas fa-info"></i>
</button>
</div>
<div class="sample-item" data-counter-top-type="quartz-black" data-counter-top-price="850" data-counter-top-name="Quartz Black">
<div class="sample-swatch quartz-black"></div>
<div class="sample-label">Quartz Black</div>
<button class="info-button" data-info-type="color" data-info-name="Quartz Black" data-info-color="quartz-black" data-info-description="Sleek Black Quartz with subtle flecks. Modern, durable surface that's easy to maintain.">
<i class="fas fa-info"></i>
</button>
</div>
</div>
</div>
<button id="calculate-price" class="btn-primary py-3 px-8 rounded-full w-full">
Calculate Price
</button>
<div id="price-result" class="price-result">
<h3 class="text-2xl font-bold mb-2">Estimated Price</h3>
<p class="text-4xl font-bold text-primary">$<span id="price-value">0</span></p>
<p class="text-gray-600 mt-2">This is an estimate. Final price may vary based on specific requirements.</p>
</div>
</div>
</div>
</section>
<!-- Contact Section -->
<section id="contact" class="section-padding">
<div class="container mx-auto px-6">
<div class="text-center mb-16" data-aos="fade-up">
<h2 class="text-4xl font-bold mb-4">Contact Us</h2>
<p class="text-gray-600 max-w-2xl mx-auto">Have questions about our products or services? We're here to help.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-12">
<div data-aos="fade-right">
<h3 class="text-2xl font-bold mb-6">Get In Touch</h3>
<p class="text-gray-600 mb-8">Fill out the form and our team will get back to you as soon as possible.</p>
<div class="space-y-4">
<div class="flex items-start">
<i class="fas fa-map-marker-alt text-primary text-xl mt-1 mr-4"></i>
<div>
<h4 class="font-bold">Our Locations</h4>
<p class="text-gray-600">Beirut, Lebanon<br>Dubai, UAE</p>
</div>
</div>
<div class="flex items-start">
<i class="fas fa-phone text-primary text-xl mt-1 mr-4"></i>
<div>
<h4 class="font-bold">Phone</h4>
<p class="text-gray-600">+961 79 399 677</p>
</div>
</div>
<div class="flex items-start">
<i class="fas fa-envelope text-primary text-xl mt-1 mr-4"></i>
<div>
<h4 class="font-bold">Email</h4>
<p class="text-gray-600">info@gencon.com</p>
</div>
</div>
<div class="flex items-start">
<i class="fas fa-clock text-primary text-xl mt-1 mr-4"></i>
<div>
<h4 class="font-bold">Business Hours</h4>
<p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM</p>
</div>
</div>
</div>
<div class="mt-8">
<h4 class="font-bold mb-4">Follow Us</h4>
<div class="social-icons">
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="fab fa-linkedin-in"></i></a>
<a href="#"><i class="fab fa-pinterest-p"></i></a>
</div>
</div>
</div>
<div data-aos="fade-left">
<form class="contact-form">
<div class="mb-6">
<input type="text" class="form-input" placeholder="Your Name" required>
</div>
<div class="mb-6">
<input type="email" class="form-input" placeholder="Your Email" required>
</div>
<div class="mb-6">
<input type="tel" class="form-input" placeholder="Your Phone">
</div>
<div class="mb-6">
<select class="form-input">
<option value="">Select a Service</option>
<option value="consultancy">Consultancy</option>
<option value="contracting">General Contracting</option>
<option value="renovations">Renovations</option>
<option value="fit-outs">Fit-Outs</option>
<option value="furniture">Furniture</option>
</select>
</div>
<div class="mb-6">
<textarea class="form-input" rows="5" placeholder="Your Message" required></textarea>
</div>
<button type="submit" class="btn-primary py-3 px-8 rounded-full w-full">
Send Message
</button>
</form>
</div>
</div>
</div>
</section>
<!-- Footer -->
<footer class="footer">
<div class="container mx-auto px-6">
<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
<div>
<a href="#" class="navbar-brand text-white mb-4 inline-block">
<span class="footer-gen-part">GEN</span><span class="footer-con-part">CON</span>
</a>
<p class="text-gray-400">Transforming spaces into extraordinary environments since 2008.</p>
</div>
<div>
<h4 class="text-xl font-bold mb-4">Quick Links</h4>
<ul class="space-y-2">
<li><a href="#home" class="text-gray-400 hover:text-white transition">Home</a></li>
<li><a href="#about" class="text-gray-400 hover:text-white transition">About Us</a></li>
<li><a href="#furniture" class="text-gray-400 hover:text-white transition">Furniture</a></li>
<li><a href="#calculator" class="text-gray-400 hover:text-white transition">Calculator</a></li>
<li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
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
<div class="filter-options">
<div class="filter-option active" data-filter="all">All</div>
<div class="filter-option" data-filter="sofas">Sofas</div>
<div class="filter-option" data-filter="chairs">Chairs</div>
<div class="filter-option" data-filter="tables">Tables</div>
<div class="filter-option" data-filter="dining-tables">Dining Tables</div>
<div class="filter-option" data-filter="coffee-tables">Coffee Tables</div>
<div class="filter-option" data-filter="night-stands">Night Stands</div>
<div class="filter-option" data-filter="bar">Bar</div>
<div class="filter-option" data-filter="bar-stools">Bar Stools</div>
<div class="filter-option" data-filter="armchairs">Armchairs</div>
<div class="filter-option" data-filter="cushions">Cushions</div>
<div class="filter-option" data-filter="dining-cabinets">Dining Cabinets</div>
<div class="filter-option" data-filter="bedroom-sets">Bedroom Sets</div>
<div class="filter-option" data-filter="beds">Beds</div>
<div class="filter-option" data-filter="closets">Closets</div>
<div class="filter-option" data-filter="outdoor-sets">Outdoor Sets</div>
<div class="filter-option" data-filter="outdoor-sofas">Outdoor Sofas</div>
<div class="filter-option" data-filter="swings">Swings</div>
<div class="filter-option" data-filter="outdoor-tables">Outdoor Tables</div>
<div class="filter-option" data-filter="outdoor-chairs">Outdoor Chairs</div>
<div class="filter-option" data-filter="outdoor-bar">Outdoor Bar</div>
<div class="filter-option" data-filter="outdoor-stools">Outdoor Stools</div>
<div class="filter-option" data-filter="pergolas">Pergolas</div>
<div class="filter-option" data-filter="umbrellas">Umbrellas</div>
<div class="filter-option" data-filter="coolers">Coolers</div>
<div class="filter-option" data-filter="bbq">BBQ</div>
<div class="filter-option" data-filter="fire-pits">Fire Pits</div>
<div class="filter-option" data-filter="kitchen">Kitchen</div>
</div>
</div>
<div class="filter-group">
<span class="filter-label">Price Range</span>
<div class="price-range">
<input type="number" class="price-input" placeholder="Min" min="0">
<span>-</span>
<input type="number" class="price-input" placeholder="Max" min="0">
</div>
</div>
<button class="filter-apply">Apply Filters</button>
</div>
<div class="filter-overlay"></div>
<!-- Preview Modal -->
<div class="preview-modal" id="preview-modal">
<div class="preview-content">
<button class="preview-close" id="preview-close">
<i class="fas fa-times"></i>
</button>
<div id="preview-image-container" class="preview-image-container" style="display: none;">
<img id="preview-image" class="preview-image" src="" alt="">
<h3 id="preview-image-title" class="preview-title"></h3>
<p id="preview-image-description" class="preview-description"></p>
</div>
<div id="preview-color-container" class="preview-color-container" style="display: none;">
<div id="preview-color" class="preview-color"></div>
<h3 id="preview-color-title" class="preview-title"></h3>
<p id="preview-color-description" class="preview-description"></p>
</div>
</div>
</div>
<!-- Newsletter Popup -->
<div class="newsletter-popup" id="newsletter-popup">
<div class="newsletter-content">
<button class="newsletter-close" id="newsletter-close">
<i class="fas fa-times"></i>
</button>
<h3 class="newsletter-title">Subscribe to Our Newsletter</h3>
<p class="newsletter-subtitle">Get 10% off your first order and be the first to know about new collections and exclusive offers.</p>
<form class="newsletter-form">
<input type="text" class="newsletter-input" placeholder="Your Name" required>
<input type="email" class="newsletter-input" placeholder="Your Email" required>
<button type="submit" class="newsletter-btn">Subscribe</button>
</form>
<div class="newsletter-discount">10% OFF</div>
</div>
</div>
<!-- Notification Container -->
<div id="notification" class="notification"></div>
<script>
// Notification function
function showNotification(message, type = 'info') {
const notification = document.getElementById('notification');
notification.textContent = message;
notification.className = `notification ${type}`;
notification.classList.add('show');
setTimeout(() => {
notification.classList.remove('show');
}, 5000);
}
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
// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
anchor.addEventListener('click', function(e) {
e.preventDefault();
const target = document.querySelector(this.getAttribute('href'));
if (target) {
window.scrollTo({
top: target.offsetTop - 80,
behavior: 'smooth'
});
// Close mobile menu if open
mobileMenu.classList.add('hidden');
}
});
});
// Enhanced scroll indicator
const scrollIndicator = document.getElementById('scroll-indicator');
scrollIndicator.addEventListener('click', function() {
// Scroll to about section with smooth behavior
document.getElementById('about').scrollIntoView({
behavior: 'smooth',
block: 'start'
});
});
// Image slider
const slider = document.getElementById('image-slider');
const slides = slider.querySelectorAll('.slide');
const navDots = document.querySelectorAll('.nav-dot');
const prevBtn = document.getElementById('prev-slide');
const nextBtn = document.getElementById('next-slide');
let currentSlide = 0;
function showSlide(index) {
if (index < 0) index = slides.length - 1;
if (index >= slides.length) index = 0;
slider.style.transform = `translateX(-${index * 100}%)`;
navDots.forEach(dot => dot.classList.remove('active'));
navDots[index].classList.add('active');
currentSlide = index;
}
navDots.forEach((dot, index) => {
dot.addEventListener('click', () => showSlide(index));
});
prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
// Auto-advance slider
setInterval(() => {
showSlide(currentSlide + 1);
}, 5000);
// Kitchen calculator
const kitchenLengthInput = document.getElementById('kitchen-length');
const kitchenShapeSelect = document.getElementById('kitchen-shape');
const woodTypeSelect = document.getElementById('wood-type');
const qualityLevelSelect = document.getElementById('quality-level');
const counterTopMaterialSelect = document.getElementById('counter-top-material');
const calculateBtn = document.getElementById('calculate-price');
const priceResult = document.getElementById('price-result');
const priceValue = document.getElementById('price-value');
// Kitchen shape selection
const kitchenShapeItems = document.querySelectorAll('.kitchen-shape-item');
kitchenShapeItems.forEach(item => {
item.addEventListener('click', function() {
// Remove active class from all items
kitchenShapeItems.forEach(i => i.classList.remove('selected'));
// Add active class to clicked item
this.classList.add('selected');
// Update select value
const shape = this.getAttribute('data-kitchen-shape');
kitchenShapeSelect.value = shape;
});
});
// Wood type selection
const woodSampleItems = document.querySelectorAll('.sample-item[data-wood-type]');
woodSampleItems.forEach(item => {
item.addEventListener('click', function() {
// Remove active class from all items
woodSampleItems.forEach(i => i.classList.remove('selected'));
// Add active class to clicked item
this.classList.add('selected');
// Update select value
const woodType = this.getAttribute('data-wood-type');
woodTypeSelect.value = woodType;
});
});
// Counter top material selection
const counterTopSampleItems = document.querySelectorAll('.sample-item[data-counter-top-type]');
counterTopSampleItems.forEach(item => {
item.addEventListener('click', function() {
// Remove active class from all items
counterTopSampleItems.forEach(i => i.classList.remove('selected'));
// Add active class to clicked item
this.classList.add('selected');
// Update select value
const counterTopType = this.getAttribute('data-counter-top-type');
counterTopMaterialSelect.value = counterTopType;
});
});
// Calculate price
calculateBtn.addEventListener('click', function() {
const length = parseFloat(kitchenLengthInput.value) || 0;
const shape = kitchenShapeSelect.value;
const woodType = woodTypeSelect.value;
const qualityLevel = qualityLevelSelect.value;
const counterTopMaterial = counterTopMaterialSelect.value;
if (length <= 0 || !shape || !woodType || !qualityLevel || !counterTopMaterial) {
showNotification('Please fill in all fields to calculate the price.', 'warning');
return;
}
// Get base price per meter
const woodTypeOption = woodTypeSelect.options[woodTypeSelect.selectedIndex];
const basePricePerMeter = parseFloat(woodTypeOption.getAttribute('data-price')) || 0;
// Get shape multiplier
const shapeOption = kitchenShapeSelect.options[kitchenShapeSelect.selectedIndex];
const shapeMultiplier = parseFloat(shapeOption.getAttribute('data-multiplier')) || 1;
// Get quality multiplier
const qualityOption = qualityLevelSelect.options[qualityLevelSelect.selectedIndex];
const qualityMultiplier = parseFloat(qualityOption.getAttribute('data-multiplier')) || 1;
// Get counter top price per meter
const counterTopOption = counterTopMaterialSelect.options[counterTopMaterialSelect.selectedIndex];
const counterTopPricePerMeter = parseFloat(counterTopOption.getAttribute('data-price')) || 0;
// Calculate total price
const cabinetPrice = length * basePricePerMeter * shapeMultiplier * qualityMultiplier;
const counterTopPrice = length * counterTopPricePerMeter;
const totalPrice = cabinetPrice + counterTopPrice;
// Display result
priceValue.textContent = totalPrice.toFixed(2);
priceResult.classList.add('show');
// Scroll to result
priceResult.scrollIntoView({ behavior: 'smooth', block: 'center' });
});
// Info buttons
const infoButtons = document.querySelectorAll('.info-button');
const previewModal = document.getElementById('preview-modal');
const previewClose = document.getElementById('preview-close');
const previewImageContainer = document.getElementById('preview-image-container');
const previewColorContainer = document.getElementById('preview-color-container');
const previewImage = document.getElementById('preview-image');
const previewColor = document.getElementById('preview-color');
const previewImageTitle = document.getElementById('preview-image-title');
const previewColorTitle = document.getElementById('preview-color-title');
const previewImageDescription = document.getElementById('preview-image-description');
const previewColorDescription = document.getElementById('preview-color-description');
infoButtons.forEach(button => {
button.addEventListener('click', function(e) {
e.stopPropagation();
const type = this.getAttribute('data-info-type');
const name = this.getAttribute('data-info-name');
if (type === 'image') {
const src = this.getAttribute('data-info-src');
const description = this.getAttribute('data-info-description');
previewImage.src = src;
previewImageTitle.textContent = name;
previewImageDescription.textContent = description;
previewImageContainer.style.display = 'block';
previewColorContainer.style.display = 'none';
} else if (type === 'color') {
const colorClass = this.getAttribute('data-info-color');
const description = this.getAttribute('data-info-description');
previewColor.className = 'preview-color ' + colorClass;
previewColorTitle.textContent = name;
previewColorDescription.textContent = description;
previewImageContainer.style.display = 'none';
previewColorContainer.style.display = 'block';
}
previewModal.classList.add('active');
});
});
previewClose.addEventListener('click', function() {
previewModal.classList.remove('active');
});
previewModal.addEventListener('click', function(e) {
if (e.target === previewModal) {
previewModal.classList.remove('active');
}
});
// Wishlist functionality
const wishlistIcons = document.querySelectorAll('.wishlist-icon');
wishlistIcons.forEach(icon => {
icon.addEventListener('click', function() {
this.classList.toggle('active');
const heartIcon = this.querySelector('i');
if (this.classList.contains('active')) {
heartIcon.classList.remove('far');
heartIcon.classList.add('fas');
} else {
heartIcon.classList.remove('fas');
heartIcon.classList.add('far');
}
});
});
// Search functionality
const searchToggle = document.querySelector('.search-btn');
const searchInput = document.querySelector('.search-input');
searchToggle.addEventListener('click', function() {
searchInput.classList.toggle('active');
if (searchInput.classList.contains('active')) {
searchInput.focus();
}
});
// Handle search input
searchInput.addEventListener('input', function() {
const searchTerm = this.value.toLowerCase();
const furnitureCards = document.querySelectorAll('.furniture-card');
furnitureCards.forEach(card => {
const title = card.querySelector('h3').textContent.toLowerCase();
const description = card.querySelector('p').textContent.toLowerCase();
if (title.includes(searchTerm) || description.includes(searchTerm)) {
card.style.display = 'block';
} else {
card.style.display = 'none';
}
});
});
// Filter functionality
const filterOptions = document.querySelectorAll('.filter-option');
const filterApply = document.querySelector('.filter-apply');
const furnitureCards = document.querySelectorAll('.furniture-card');
filterOptions.forEach(option => {
option.addEventListener('click', function() {
// For category filters, only one can be active at a time
if (this.parentElement.classList.contains('filter-options') &&
this.parentElement.previousElementSibling.textContent === 'Category') {
this.parentElement.querySelectorAll('.filter-option').forEach(opt => {
opt.classList.remove('active');
});
}
this.classList.toggle('active');
});
});
filterApply.addEventListener('click', function() {
// Get active filters
const activeCategoryFilters = Array.from(document.querySelectorAll('.filter-options:first-child .filter-option.active'))
.map(opt => opt.getAttribute('data-filter'));
const minPrice = parseFloat(document.querySelector('.price-input:first-of-type').value) || 0;
const maxPrice = parseFloat(document.querySelector('.price-input:last-of-type').value) || Infinity;
// Filter furniture cards
furnitureCards.forEach(card => {
const categories = card.getAttribute('data-category').split(' ');
const price = parseFloat(card.getAttribute('data-price')) || 0;
// Check if card matches all active filters
const categoryMatch = activeCategoryFilters.length === 0 || activeCategoryFilters.includes('all') ||
categories.some(cat => activeCategoryFilters.includes(cat));
const priceMatch = price >= minPrice && price <= maxPrice;
if (categoryMatch && priceMatch) {
card.style.display = 'block';
} else {
card.style.display = 'none';
}
});
// Close mobile filter panel if open
document.querySelector('.mobile-filter-panel').classList.remove('active');
document.querySelector('.filter-overlay').classList.remove('active');
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
// Product scrolling functionality
function setupProductScrolling(sectionId, prevBtnId, nextBtnId, wrapperId) {
const wrapper = document.getElementById(wrapperId);
const prevBtn = document.getElementById(prevBtnId);
const nextBtn = document.getElementById(nextBtnId);
prevBtn.addEventListener('click', function() {
wrapper.scrollBy({
left: -500, // Increased scroll distance
behavior: 'smooth'
});
});
nextBtn.addEventListener('click', function() {
wrapper.scrollBy({
left: 500, // Increased scroll distance
behavior: 'smooth'
});
});
}
// Setup scrolling for both indoor and outdoor sections
setupProductScrolling('indoor-section', 'indoor-prev', 'indoor-next', 'indoor-wrapper');
setupProductScrolling('outdoor-section', 'outdoor-prev', 'outdoor-next', 'outdoor-wrapper');
// Newsletter popup
const newsletterPopup = document.getElementById('newsletter-popup');
const newsletterClose = document.getElementById('newsletter-close');
// Show newsletter popup after 5 seconds
setTimeout(function() {
newsletterPopup.classList.add('active');
}, 5000);
newsletterClose.addEventListener('click', function() {
newsletterPopup.classList.remove('active');
});
newsletterPopup.addEventListener('click', function(e) {
if (e.target === newsletterPopup) {
newsletterPopup.classList.remove('active');
}
});
// Newsletter form submission
const newsletterForm = document.querySelector('.newsletter-form');
newsletterForm.addEventListener('submit', function(e) {
e.preventDefault();
// Here you would normally send the form data to your server
showNotification('Thank you for subscribing to our newsletter!', 'success');
newsletterPopup.classList.remove('active');
this.reset();
});
// Contact form submission
const contactForm = document.querySelector('.contact-form');
contactForm.addEventListener('submit', function(e) {
e.preventDefault();
// Here you would normally send the form data to your server
showNotification('Thank you for your message! We will get back to you soon.', 'success');
this.reset();
});
// Footer newsletter form submission
const footerNewsletterForm = document.querySelector('footer form');
footerNewsletterForm.addEventListener('submit', function(e) {
e.preventDefault();
// Here you would normally send the form data to your server
showNotification('Thank you for subscribing to our newsletter!', 'success');
this.reset();
});
// Animate elements on scroll
const animateElements = document.querySelectorAll('.fade-in-up, .slide-in-left, .slide-in-right, .scale-in');
function checkIfInView() {
const windowHeight = window.innerHeight;
const windowTopPosition = window.scrollY;
const windowBottomPosition = windowTopPosition + windowHeight;
animateElements.forEach(element => {
const elementHeight = element.offsetHeight;
const elementTopPosition = element.offsetTop;
const elementBottomPosition = elementTopPosition + elementHeight;
// Check if element is in viewport
if (
(elementBottomPosition >= windowTopPosition) &&
(elementTopPosition <= windowBottomPosition)
) {
element.classList.add('active');
}
});
}
// Check on load and scroll
window.addEventListener('load', checkIfInView);
window.addEventListener('scroll', checkIfInView);
</script>
</body>
</html>