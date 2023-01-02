<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
        <main class="main">
            <!--category-->
            <section class="categorie-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="categorie-title"> 
                                <small>
                                    <a href="index.php">Home</a>
                                    <i class="fas fa-angle-right"></i> Authors
                                </small>
                                <h3>Authors</h3>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--blog-grid-->
            <section class="blog-classic">
                <div class="container-fluid">
                    <div class="">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="row">
                                        
                                        <!--widget-author-->
                                        <div class="col-lg-4 col-md-4 masonry-item">
                                            <div class="widget">
                                                <div class="widget-author">
                                                    <div class="author-img">
                                                        <a href="author.php" class="image">
                                                            <img src="assets/img/author/1.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="author-content">
                                                        <h6 class="name"> Hi, I'm David Smith</h6>
                                                        <p class="bio">
                                                            I'm David Smith, husband and father ,
                                                            I love Photography,travel and nature. I'm working as a writer and blogger with experience
                                                            of 5 years until now.
                                                        </p>
                                                        <div class="social-media">
                                                            <ul class="list-inline">
                                                                <li>
                                                                    <a href="#" class="color-facebook">
                                                                        <i class="fab fa-facebook"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="color-instagram">
                                                                        <i class="fab fa-instagram"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="color-twitter">
                                                                        <i class="fab fa-twitter"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="color-youtube">
                                                                        <i class="fab fa-youtube"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="color-pinterest">
                                                                        <i class="fab fa-pinterest"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/-->
                                          
                                    </div>
                                </div>
                                
                            
                                <!--pagination-->
                                <div class="pagination mt-30">
                                    <ul class="list-inline">
                                        <li class="active">
                                            <a href="#">1</a>
                                        </li>
                                        <li>
                                            <a href="#">2</a>
                                        </li>
                                        <li>
                                            <a href="#">3</a>
                                        </li>
                                        <li>
                                            <a href="#">4</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        
                    </div>
                </div>
            </section><!--/-->

    
           <!--newslettre-->
           <?php include 'includes/newsletter.php'; ?>
        </main>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
