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

    // Get lastest post show on slider part of page
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 ORDER BY `post_id` DESC LIMIT 4");
    $stmt->execute();
    $lastestPostFirst = $stmt->fetchAll();

    // Get lastest post show on second section of page
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 ORDER BY `post_id` DESC LIMIT 4,10");
    $stmt->execute();
    $lastestPostSecond = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id INNER JOIN postdetails ON post_id=postid WHERE post_status=1 AND delete_status=0 ORDER BY `views` DESC LIMIT 4");
    $stmt->execute();
    $mostViewdPost = $stmt->fetchAll();
    
?>
        <main class="main ">
            
        
            <!--slider-style3-->
            <div class="slider-style3 ">
                <div class="swiper-wrapper">
                    <!--slider-1-->
                    <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/1.jpg);"> 
                        <div class="slider-item-content">
                            <div class="entry-cat ">
                                <a href="blog-grid.html" class="categorie ">interior</a> 
                            </div>
                            <h4 class="entry-title">
                                <a href="post-default.html">How To Design A Room Like An Interior Designer Step By Step</a>
                            </h4>

                            <ul class="entry-meta list-inline">
                                <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                <li class="post-author"><a href="author.html">David Smith</a> </li>
                                <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                            </ul>
                        </div>       
                    </div>

                    <!--slider-2-->
                    <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/2.jpg);">
                        <div class="slider-item-content">
                            <div class="entry-cat ">
                                <a href="blog-grid.html" class="categorie">
                                   livestyle
                                </a> 
                            </div>
                            <h4 class="entry-title">
                                <a href="post-default.html">5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                            </h4>
                            <ul class="entry-meta list-inline">
                                <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                <li class="post-author"><a href="author.html">David Smith</a> </li>
                                <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                            </ul> 
                        </div>
                    </div>


                    <!--slider-3-->
                    <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/3.jpg);">
                        <div class="slider-item-content">
                            <div class="entry-cat ">
                                <a href="blog-grid.html" class="categorie">
                                   food
                                </a> 
                            </div>
                            <h4 class="entry-title">
                                <a href="post-default.html">What Are Your Tips for Hosting an Easy Birthday Party?
                                </a>
                            </h4>
                            <ul class="entry-meta list-inline">
                                <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                <li class="post-author"><a href="author.html">David Smith</a> </li>
                                <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                            </ul>
                        </div>
                    </div>

                    <!--slider-4-->
                    <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/5.jpg);">
                        <div class="slider-item-content">
                            <div class="entry-cat ">
                            <a href="blog-grid.html" class="categorie">
                               travel
                            </a> 
                            </div>
                            <h4 class="entry-title">
                                <a href="post-default.html">Get the Most Out of Iceland with our 10 Travel Tips </a>
                            </h4>
                            <ul class="entry-meta list-inline">
                                <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                <li class="post-author"><a href="author.html">David Smith</a> </li>
                                <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                            </ul>
                        </div>
                    </div>

                    <!--slider-5-->
                    <div class="slider-item  swiper-slide" style="background-image: url(assets/img/blog/14.jpg);">
                        <div class="slider-item-content">
                            <div class="entry-cat ">
                            <a href="blog-grid.html" class="categorie">
                               interior
                            </a> 
                            </div>
                            <h4 class="entry-title">
                                <a href="post-default.html">7 Holiday Decor Ideas and Exactly What I Love About Each One</a>
                            </h4>
                            <ul class="entry-meta list-inline">
                                <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                <li class="post-author"><a href="author.html">David Smith</a> </li>
                                <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                            </ul>
                        </div>
                    </div>
                </div> 
                <!--pagination-->  
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </main>
<!--/-->
</div>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>