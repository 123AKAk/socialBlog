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

    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id INNER JOIN postdetails ON post_id=postid WHERE post_status=1 AND delete_status=0 ORDER BY `views` DESC LIMIT 4");
    $stmt->execute();
    $mostViewdPost = $stmt->fetchAll();
    
?>
        <main class="main">
            <!--slider-style-2-->
            <div class="slider-style2">
                <div  class="swiper swiper-top animated-background">
                   <div class="swiper-wrapper" id="slider">
                    <!-- slider post shows here -->
                   </div>
                </div>
      
                <div thumbsSlider="" class="swiper swiper-bottom container-fluid" >
                    <div class="swiper-wrapper " id="sliderControls">
                       
                        <!-- slidercontrols post shows here -->

                        <div class="swiper-slide ">
                            <div class="post-item">
                                <div class="cwrapper-image animated-background ">
                                </div>
                                <div class="details awrapper-text ">
                                    <p class="entry-title cwrapper-text-line1 animated-background">
                                    </p>
                                    <ul class="entry-meta list-inline cwrapper-text-line2 animated-background">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide cwrapper-cell">
                            <div class="post-item">
                                <div class="cwrapper-image animated-background">
                                </div>
                                <div class="details awrapper-text">
                                    <p class="entry-title cwrapper-text-line1 animated-background">
                                    </p>
                                    <ul class="entry-meta list-inline cwrapper-text-line2 animated-background">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide cwrapper-cell">
                            <div class="post-item">
                                <div class="cwrapper-image animated-background">
                                </div>
                                <div class="details awrapper-text">
                                    <p class="entry-title cwrapper-text-line1 animated-background">
                                    </p>
                                    <ul class="entry-meta list-inline cwrapper-text-line2 animated-background">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide cwrapper-cell">
                            <div class="post-item">
                                <div class="cwrapper-image animated-background">
                                </div>
                                <div class="details awrapper-text">
                                    <p class="entry-title cwrapper-text-line1 animated-background">
                                    </p>
                                    <ul class="entry-meta list-inline cwrapper-text-line2 animated-background">
                                    </ul>
                                </div>
                            </div>
                        </div>
                       
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
                                                <div class="col-lg-12" id="bodyPost1">
                                                
                                                    <!--Post-1-->
                                                    <div class="post-list awrapper-cell">
                                                        <div class="post-list-image">
                                                            <div class="image-box">
                                                                <div class="awrapper-image animated-background">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="post-list-content awrapper-text">
                                                            <div class="entry-cat awrapper-text-line  animated-background">
                                                            </div>
                                                            <h4 class="entry-title awrapper-text-line animated-background">
                                                            </h4>
                                                            <div class="post-exerpt awrapper-text-line animated-background">
                                                            </div>
                                                            <ul class="entry-meta list-inline awrapper-text">
                                                                <li class="post-author awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-date awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-timeread awrapper-atext-line animated-background">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>


                                                    <div class="post-list awrapper-cell">
                                                        <div class="post-list-image">
                                                            <div class="image-box">
                                                                <div class="awrapper-image animated-background">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="post-list-content awrapper-text">
                                                            <div class="entry-cat awrapper-text-line  animated-background">
                                                            </div>
                                                            <h4 class="entry-title awrapper-text-line animated-background">
                                                            </h4>
                                                            <div class="post-exerpt awrapper-text-line animated-background">
                                                            </div>
                                                            <ul class="entry-meta list-inline awrapper-text">
                                                                <li class="post-author awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-date awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-timeread awrapper-atext-line animated-background">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>


                                                    <div class="post-list awrapper-cell">
                                                        <div class="post-list-image">
                                                            <div class="image-box">
                                                                <div class="awrapper-image animated-background">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="post-list-content awrapper-text">
                                                            <div class="entry-cat awrapper-text-line  animated-background">
                                                            </div>
                                                            <h4 class="entry-title awrapper-text-line animated-background">
                                                            </h4>
                                                            <div class="post-exerpt awrapper-text-line animated-background">
                                                            </div>
                                                            <ul class="entry-meta list-inline awrapper-text">
                                                                <li class="post-author awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-date awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-timeread awrapper-atext-line animated-background">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="post-list awrapper-cell">
                                                        <div class="post-list-image">
                                                            <div class="image-box">
                                                                <div class="awrapper-image animated-background">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="post-list-content awrapper-text">
                                                            <div class="entry-cat awrapper-text-line  animated-background">
                                                            </div>
                                                            <h4 class="entry-title awrapper-text-line animated-background">
                                                            </h4>
                                                            <div class="post-exerpt awrapper-text-line animated-background">
                                                            </div>
                                                            <ul class="entry-meta list-inline awrapper-text">
                                                                <li class="post-author awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-date awrapper-atext-line animated-background">
                                                                </li>
                                                                <li class="post-timeread awrapper-atext-line animated-background">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    

                                                </div>
                                            </div>
                                            <div class="text-center justify-content-center">
                                                <button type="button" onclick="loadMore()" class="btn btn-outline-secondary">Load More</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sidebar -->
                                    <?php include 'includes/sidebar.php'; ?>
                                </div>
                                
                                <!--slider-style3-->
                                <div class="slider-style3">
                                    <div class="swiper-wrapper" id="postSlider2">
                                        <!--slider-1-->
                                        <div class="slider-item  swiper-slide"> 
                                            <div class="slider-item-content">
                                                <div class="entry-cat bwrapper-text-line animated-background">
                                                    
                                                </div>
                                                <h4 class="entry-title bwrapper-text-line animated-background">
                                                    
                                                </h4>

                                                <ul class="entry-meta list-inline">
                                                    <li class="post-author-img wrapper-atext-line animated-background"></li>
                                                    <li class="post-author bwrapper-atext-line animated-background"></li>
                                                    <li class="post-date bwrapper-atext-line animated-background"></li>
                                                </ul>
                                            </div>       
                                        </div>
                                        <div class="slider-item  swiper-slide"> 
                                            <div class="slider-item-content">
                                                <div class="entry-cat bwrapper-text-line animated-background">
                                                    
                                                </div>
                                                <h4 class="entry-title bwrapper-text-line animated-background">
                                                    
                                                </h4>

                                                <ul class="entry-meta list-inline">
                                                    <li class="post-author-img wrapper-atext-line animated-background"></li>
                                                    <li class="post-author bwrapper-atext-line animated-background"></li>
                                                    <li class="post-date bwrapper-atext-line animated-background"></li>
                                                </ul>
                                            </div>       
                                        </div>
                                        <div class="slider-item  swiper-slide"> 
                                            <div class="slider-item-content">
                                                <div class="entry-cat bwrapper-text-line animated-background">
                                                    
                                                </div>
                                                <h4 class="entry-title bwrapper-text-line animated-background">
                                                    
                                                </h4>

                                                <ul class="entry-meta list-inline">
                                                    <li class="post-author-img wrapper-atext-line animated-background"></li>
                                                    <li class="post-author bwrapper-atext-line animated-background"></li>
                                                    <li class="post-date bwrapper-atext-line animated-background"></li>
                                                </ul>
                                            </div>       
                                        </div>

                                    </div> 
                                    <!--pagination-->  
                                    <div class="swiper-button-nexta"></div>
                                    <div class="swiper-button-preva"></div>
                                </div>

                            </div>
                        </section><!--/-->

                        <!--pagination-->
                        <!-- <div class="col-lg-12 mt-30">
                            <div class="pagination">
                                <ul class="list-inline">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#"><i class="fas fa-arrow-right"></i></a> </li>
                                </ul>
                            </div> 
                        </div> -->
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
<!-- Page specific script -->
<!-- Script -->
<script type='text/javascript'>
    //window.onload = loadData;
    
</script>