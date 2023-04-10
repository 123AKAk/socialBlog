<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    // if author id is 0 show author not found or inaccesible on the website
?>
    <main class="main">
        <!--author-->
        <section class="section  ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-11 m-auto">
                        <!--widget-author-->
                    
                            <div class="widget-author  ">
                                <div class="author-img">
                                    <a href="author.php" class="image">
                                        <img src="assets/img/author/1.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-content">
                                    <h6 class="name"> Hi, I'm David Smith</h6>
                                    <div class="btn-link">13 Articles</div>
                                    <p class="bio">
                                        I'm David Smith, husband and father ,
                                        I love Photography,travel and nature. I'm working as a writer and blogger with experience
                                        of 5 years until now.
                                    </p>
                                    <div class="social-media">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="#" class="color-facebook"><i class="fab fa-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-instagram"><i class="fab fa-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-twitter"><i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-youtube"><i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
                                            <li>
                                            <a href="#" class="color-pinterest"><i class="fab fa-pinterest"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        
                        <!--/-->
                    
                    </div>
                </div>
            </div>
        </section>
    
        <!--grid-layout-->
        <section class="mt-90">
            <div class="container-fluid">
                <div class="row">
                    
                    <!--Post-1-->
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="post-card">
                            <div class="post-card-image">
                                <a href="post.php">
                                    <img src="assets/img/blog/25.jpg" alt="">
                                </a>
                            </div>
                            <div class="post-card-content">
                                <div class="entry-cat">
                                    <a href="blog-grid.php" class="categorie"> fashion</a>
                                </div>

                                <h5 class="entry-title">
                                    <a href="post.php">5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                                </h5>

                                <div class="post-exerpt">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit quam atque ipsa laborum sunt distinctio... </p>
                                </div>

                                <ul class="entry-meta list-inline">
                                    <li class="post-author-img"><a href="author.php"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                    <li class="post-author"><a href="author.php">David Smith</a> </li>
                                    <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                </ul>
                            </div>
                        </div>
                        <!--/-->
                    </div>


                    <!--pagination-->
                    <div class="col-lg-12">
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
