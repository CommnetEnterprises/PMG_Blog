<?php
include 'partials/header.php';

$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Social Media Website</title>
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <!-- CSS STYLE -->
    <link rel="stylesheet" href="styler.css">
</head>
<body>
    <nav>
        <div class="container">
            <h2 class="log">
                Social Media
            </h2>
            <div class="search-bar">
                <i class="uil uil-search"></i>
                <input type="search" placeholder="Search for creators and projects">
            </div>
            <div class="create">
                <label class="btn btn-primary" for="create-post">Create</label>
                <div class="profile-photo">
                    <img src="./images/profile-1.jpg" alt="profile">
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">


            <div class="left">

                

                <div class="sidebar">

                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span><h3>Theme</h3>
                    </a>
                </div>


            </div>


            <div class="middle">
                
               



                <!-- View feeds -->
                <div class="feeds">
                <?php while($post =mysqli_fetch_assoc($posts)):?>
                <article class="post">
                <div class="head">
                <div class="user">
                    <div class="post__author">
                    <?php 
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result); ?>
                        <div class="post__author-avatar">
                            <img src=".\images\<?= $author['avatar']?>" alt="">
                        </div>
                        <div class="post_author-info">
                            <h5>By: <?="{$author['firstName']} {$author['lastName']}"?></h5>
                            <small><?=date("M d, Y - H:i", strtotime($post['date_time']))?></small>
                        </div>
                    </div>
                    </div>
                    </div>
                <div class="post__thumbnail">
                    <img src=".\images\<?= $post['thumbnail']?>" alt="">
                </div>
                <div class="post__info">
                <?php $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?=$post['category_id']?>" class="category__button"><?=  $category['title']?></a>
                    <h3 class="post_title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?=$post['id']?>">
                        <?= $post['title']?>
                        </a>
                    </h3>
                    <p class="post__body">
                    <?= substr($post['body'], 0 ,150)?>...
                    </p>
                </div>
            </article>
            <?php endwhile ?>

                </div>
                
            </div>
             
            
        </div>
    </main>

    <div class="customize-theme">
        <div class="card">
            <h2>Customize your theme</h2>

            <div class="font-size">
                <h4>Font Size</h4>

                <div>
                    <h6>Aa</h6>
                <div class="choose-size">
                    <span class="font-size-1"></span>
                    <span class="font-size-2"></span>
                    <span class="font-size-3 active"></span>
                    <span class="font-size-4"></span>
                    <span class="font-size-5"></span>
                </div>
                <h3>Aa</h3>
                </div>
            </div>

            <div class="color">
            
                <h4>Colour</h4>
                <div class="choose-color">
                    <div class="color-line">
                        <input type="range" id="color-p" min="0" max="360" value="252" step="1">       
                    </div>           
                </div>
            </div>
            
            <div class="background">

                <h4>Background Lighting</h4>
                
                <div class="choose-bg">

                <div class="bg-l active">
                    <span></span>
                    <h5 for="bg-l">Light</h5>
                </div>

                <div class="bg-d">
                    <span></span>
                    <h5 for="bg-d">Dim</h5>
                </div>

                <div class="bg-b">
                    <span></span>
                    <h5 for="bg-b">Black</h5>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>