<?php
// index.php - Main Router File

// Ambil parameter page dari URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Pisahkan module dan action
$parts = explode('/', $page);
$module = isset($parts[0]) ? $parts[0] : 'home';
$action = isset($parts[1]) ? $parts[1] : 'list';

// Include header
include('views/header.php');

// Routing logic
switch($module) {
    case 'user':
        // Load module user
        // Untuk action edit, ambil ID dari parameter
        if($action == 'edit' && !isset($_GET['id'])) {
            echo "<div class='content'><h2>Error</h2><p>ID tidak ditemukan</p></div>";
            break;
        }
        
        $file = "modules/user/{$action}.php";
        if(file_exists($file)) {
            include($file);
        } else {
            echo "<div class='content'><h2>404 - Halaman tidak ditemukan</h2><p>File: {$file}</p></div>";
        }
        break;
    
    case 'auth':
        // Load module auth
        $file = "modules/auth/{$action}.php";
        if(file_exists($file)) {
            include($file);
        } else {
            echo "<div class='content'><h2>404 - Halaman tidak ditemukan</h2><p>File: {$file}</p></div>";
        }
        break;
    
    case 'home':
    default:
        // Load dashboard/home
        if(file_exists('views/dashboard.php')) {
            include('views/dashboard.php');
        } else {
            echo "<div class='content'><h2>404 - File dashboard tidak ditemukan</h2></div>";
        }
        break;
}

// Include footer
include('views/footer.php');
?>