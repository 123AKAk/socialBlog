<?php

    $style_refrences = '
        <style>
            .image-box {
                position: relative;
                margin: auto;
                overflow: hidden;
                justify-content: center;
                align-items: center;
                overflow: hidden;
            }
            .image-box img {
                transition: all 0.3s;
                display: block;
                width: 100%;
                height: 400px;
                transform: scale(1);
                position: center center;
                background-size: cover;
            }
            
            .image-box:hover img {
                transform: scale(1.1);
            }
            .myText {
                overflow: hidden;
            }
        </style>
    ';

    include 'includes/header.php';
    include 'includes/navbar.php';

    // $folder_name = "classes/components/filesUpload/";

    // Get lastest article show on slider part of page
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 ORDER BY `post_id` DESC LIMIT 4");
    $stmt->execute();
    $lastestPostFirst = $stmt->fetchAll();

    // Get lastest article show on second section of page
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 ORDER BY `post_id` DESC LIMIT 4,10");
    $stmt->execute();
    $lastestPostSecond = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id INNER JOIN postdetails ON post_id=postid WHERE post_status=1 AND delete_status=0 ORDER BY `views` DESC LIMIT 4");
    $stmt->execute();
    $mostViewdPost = $stmt->fetchAll();
    
?>
        <main class="main">
            <!--slider-style-2-->
            <div class="slider-style2">
                <div  class="swiper swiper-top">
                   <div class="swiper-wrapper">
                        <?php 
                            if(isset($lastestPostFirst))
                            {
                                foreach ($lastestPostFirst as $post) : 
                                
                                $postId = $sharedComponents->protect($post['post_id']); 
                                $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                                $authId = $adminUserDetails["id"];
                                $authEmail = $adminUserDetails["email"];
                                $authName = $adminUserDetails["username"];
                                $authGender = $adminUserDetails["gender"];
                                $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
                                $authLink = "author.php?authDType=".$adminUserDetails["type"]."&authd=".$adminUserDetails["id"];

                                $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];
                        ?>
                        <!--slider1-->
                        <div class="swiper-slide slider-item" style="background-image: url('<?= $postImage; ?>');">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-9 col-md-12">
                                        <div class="slider-item-inner">
                                            <div class="slider-item-content">
                                            <div class="entry-cat ">
                                                <a class="categorie" href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $post['category_id'] ?>">
                                                    <?= $post['category_name'] ?>
                                                </a>
                                            </div>
                                            <h1 class="entry-title">
                                                <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $postId ?>">
                                                    <?= $post['post_title']; ?>
                                                </a>
                                            </h1>
                                            <div class="post-exerpt">
                                                <p><?= $sharedComponents->convertHtmltoText($post['post_contents'], 25, '', '') ?></p>
                                            </div>
                                            <ul class="entry-meta list-inline">
                                                <li class="post-author-img">
                                                    <a href="<?= $authLink ?>">
                                                        <img src="<?= $authProfilePic; ?>" alt="">
                                                    </a>
                                                </li>
                                                <li class="post-author">
                                                    <a href="<?= $authLink ?>">
                                                        <?= $authName ?>
                                                    </a> 
                                                </li>
                                                <li class="post-date"> <span class="dot"></span>
                                                    <?= date_format(date_create($post['post_creation_time']), "F d, Y") ?>
                                                </li>
                                                <li class="post-comment">
                                                    <span class="dot"></span>
                                                    <?= $sharedComponents->checkNumofComments($postId, $pdo)." comments"; ?>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endforeach; 
                        }
                        else
                        {
                            echo "<h4>Post not avaiable</h4>";
                        }
                        ?>
                   </div>
                </div>
      
                <div thumbsSlider="" class="swiper swiper-bottom container-fluid" >
                    <div class="swiper-wrapper ">
                        <?php 
                        if(isset($lastestPostFirst))
                        {
                            foreach ($lastestPostFirst as $post) : 
                                
                                $postId = $sharedComponents->protect($post['post_id']); 
                                $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                                $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail']
                        ?>
                        <!--slider1-->
                        <div class="swiper-slide">
                            <div class="post-item">
                                <img src="<?= $postImage; ?>"  alt="">
                                <div class="details">

                                        <p class="entry-title"> 
                                        <span>
                                            <?= $post['post_title']; ?>
                                        </span>
                                        </p>

                                    <ul class="entry-meta list-inline">
                                        <li class="post-date"> <i class="fas fa-clock"></i> 
                                            <?= date_format(date_create($post['post_creation_time']), "F d, Y") ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endforeach; 
                        }
                        else
                        {
                            echo "<h4>Post not avaiable</h4>";
                        }
                        ?>
                    </div>
                </div>      
            </div>
             

            <!--grid-layout-->
            <section class="mt-90">
                <div class="container-fluid">
                    <div class="row">

                        <!--blog-grid-->
                        <section class="blog-list">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xl-9 side-content">
                                        <div class="theiaStickySidebar">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php 
                                                        if(isset($lastestPostSecond))
                                                        {
                                                            foreach ($lastestPostSecond as $post) : 
                                                            
                                                            $postId = $sharedComponents->protect($post['post_id']); 
                                                            $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                                                            $authId = $adminUserDetails["id"];
                                                            $authEmail = $adminUserDetails["email"];
                                                            $authName = $adminUserDetails["username"];
                                                            $authGender = $adminUserDetails["gender"];
                                                            $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
                                                            $authLink = "author.php?authDType=".$adminUserDetails["type"]."&authd=".$adminUserDetails["id"];

                                                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail']
                                                    ?>
                                                    <!--Post-1-->
                                                    <div class="post-list">
                                                        <div class="post-list-image">
                                                            <div class="image-box">
                                                                <a href="post.php">
                                                                    <img src="<?= $postImage; ?>" class="img-fluid w-100" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="post-list-content">
                                                            <div class="entry-cat">
                                                                <a class="categorie" href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $post['category_id'] ?>">
                                                                    <?= $post['category_name'] ?>
                                                                </a>
                                                            </div>
                                                            <h4 class="entry-title">
                                                                <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $postId ?>">
                                                                    <?= $post['post_title']; ?>
                                                                </a>
                                                            </h4>
                                                            <div class="post-exerpt">
                                                                <p class="myText"><?= $sharedComponents->convertHtmltoText($post['post_contents'], 25, '', '') ?></p>
                                                            </div>
                                                            <ul class="entry-meta list-inline">
                                                                <li class="post-author-img">
                                                                    <a href="<?= $authLink ?>">
                                                                        <img src="<?= $authProfilePic; ?>" alt="">
                                                                    </a>
                                                                </li>
                                                                <li class="post-author"><a href="author.php">
                                                                    <a href="<?= $authLink ?>">
                                                                        <?= $authName ?>
                                                                    </a> 
                                                                </li>
                                                                <li class="post-date"> <span class="dot"></span>
                                                                    <?= date_format(date_create($post['post_creation_time']), "F d, Y") ?>
                                                                </li>
                                                                <li class="post-timeread"> <span class="dot"></span> 
                                                                    15 min Read
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--/-->
                                                    <?php 
                                                        endforeach; 
                                                    }
                                                    else
                                                    {
                                                        echo "<h4>Post not avaiable</h4>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sidebar -->
                                    <?php include 'includes/sidebar.php'; ?>
                                </div>
                                 <!--slider-style4-->
                                <div class="slider-style4">
                                    <div class="swiper-wrapper">
                                        <!--slider-1-->
                                        <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/14.jpg);">
                                                <div class="slider-item-content">
                                                    <div class="entry-cat ">
                                                    <a href="blog-grid.html" class="categorie ">
                                                        interior
                                                    </a> 
                                                    </div>
                                                    <h4 class="entry-title">
                                                    <a href="post-default.html">How To Design A Room Like An Interior Designer Step By Step</a>
                                                    </h4>
                                                    <ul class="entry-meta list-inline">
                                                        <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                        <li class="post-author"><a href="author.html">David Smith</a> </li>
                                                        <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                    </ul>
                                                </div>
                                        </div>

                                        <!--slider-2-->
                                        <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/7.jpg);">
                                                <div class="slider-item-content">
                                                    <div class="entry-cat ">
                                                        <a href="blog-grid.html" class="categorie"> food</a> 
                                                    </div>
                                                    <h4 class="entry-title">
                                                        <a href="post-default.html">10 Taco Tuesday Recipes for You If You Love Birria Tacos</a>
                                                    </h4>
                                                    <ul class="entry-meta list-inline">
                                                        <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                        <li class="post-author"><a href="author.html">David Smith</a> </li>
                                                        <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                    </ul>
                                                </div>  
                                        </div>

                                        <!--slider-3-->
                                        <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/12.jpg);">
                                                <div class="slider-item-content">
                                                    <div class="entry-cat ">
                                                        <a href="blog-grid.html" class="categorie">fashion</a> 
                                                    </div>
                                                    <h4 class="entry-title">
                                                        <a href="post-default.html">20+ Cute Girly Outfits to Buy for the First Day of Winter</a>
                                                    </h4>
                                                    <ul class="entry-meta list-inline">
                                                        <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                        <li class="post-author"><a href="author.html">David Smith</a> </li>
                                                        <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                    </ul>
                                                </div>
                                        </div>

                                        <!--slider-4-->
                                        <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/15.jpg);">
                                            <div class="slider-item-content">
                                                <div class="entry-cat ">
                                                    <a href="blog-grid.html" class="categorie">
                                                        travel
                                                    </a> 
                                                </div>
                                                <h4 class="entry-title">
                                                    <a href="post-default.html">Get the Most Out of Iceland with our 10 Travel Tips
                                                    </a>
                                                </h4>
                                                <ul class="entry-meta list-inline">
                                                    <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                    <li class="post-author"><a href="author.html">David Smith</a> </li>
                                                    <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                </ul>
                                            </div>   
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </section><!--/-->

                        <!--pagination-->
                        <div class="col-lg-12 mt-30">
                            <div class="pagination">
                                <ul class="list-inline">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#"><i class="fas fa-arrow-right"></i></a> </li>
                                </ul>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
            <!--/-->

            <!--newslettre-->
            <?php include 'includes/newsletter.php'; ?>
        </main>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
