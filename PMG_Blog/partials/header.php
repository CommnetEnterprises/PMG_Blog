<?php
require 'config/database.php';
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id= $id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMG Magazine</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    <!-- ====================START OF NAV================== -->
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">PMG Magazine</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Magazine</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Podcast</a></li>
                <?php if (isset($_SESSION['user-id'])): ?>
                    <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'images/' . $avatar['avatar']?>">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li> 
                <?php else :?>
                <li><a href="<?= ROOT_URL ?>signin.php">Sign-in</a></li>
                <?php endif ?>               
            </ul>
          <button id="open__nav-btn"><i class="uil uil-bars"></i></button>  
          <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>  

        </div>
    </nav>
    <!-- ====================END OF NAV================== -->