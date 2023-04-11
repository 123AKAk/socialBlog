<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>

        <main class="main">
            <!--Categorie-->
            <section class="categorie-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="categorie-title">
                                <small>
                                    <a href="./">Home</a>
                                   <i class="fas fa-angle-right"></i>Livestyle
                                </small>
                                <h3>Category : <span>livestyle</span> </h3>
                                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Incidunt quae explicabo, ducimus necessitatibus eum aut enim modi
                                    saepe perspiciatis fugit
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--/-->

            <!--blog-grid-->
            <section class="blog-grid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 mt-30 side-content">
                            <div class="theiaStickySidebar">
                                <div class="row masonry-items">
                                    
                                    <!--Post-1-->
                                    <div class="col-lg-6 col-md-6 masonry-item">
                                        <div class="post-card ">
                                            <div class="post-card-image">
                                                <a href="post.php">
                                                    <img src="assets/img/blog/7.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card-content">
                                                <div class="entry-cat">
                                                    <a href="blog-grid.php" class="categorie"> food</a>
                                                </div>
            
                                                <h5 class="entry-title">
                                                    <a href="post.php">What Are Your Tips for Hosting an Easy Birthday Party?</a>
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
                                    </div>
                                    <!--/-->
                    
                                </div>
            
                                <!--pagination-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="pagination ">
                                            <ul class="list-inline">
                                                <li class="active"> <a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#"><i class="fas fa-arrow-right"></i></a></li>
                                            </ul>
                                        </div>   
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <!-- sidebar -->
                        <?php include 'includes/sidebar.php'; ?>

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
