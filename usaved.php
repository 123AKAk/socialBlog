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
                                    <i class="fas fa-angle-right"></i> Travel
                                </small>
                                <h3>Category : <span> Travel</span></h3>
                                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Incidunt quae explicabo, ducimus necessitatibus eum aut enim modi
                                    saepe perspiciatis fugit
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--blog-list-->
            <section class="blog-grid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 mt-30 side-content">
                            <div class="theiaStickySidebar">
                                
                                 <!--Post-1-->
                                 <div class="post-list">
                                    <div class="post-list-image">
                                        <a href="post.php">
                                            <img src="assets/img/blog/16.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="post-list-content">
                                        <div class="entry-cat">
                                            <a href="blog-grid.php" class="categorie"> fashion</a>
                                        </div>

                                        <h4 class="entry-title">
                                            <a href="post.php">easa5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                                        </h4>

                                        <div class="post-exerpt">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit quam atque ipsa laborum sunt distinctio... </p>
                                        </div>

                                        <ul class="entry-meta list-inline">
                                            <li class="post-author-img"><a href="author.php"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                            <li class="post-author"><a href="author.php">David Smith</a> </li>
                                            <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                            <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                                        </ul>
                                    </div>
                                </div>
                                <!--/-->
                              
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
