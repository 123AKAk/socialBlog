<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
    <main class="main">
        <!--author-->
        <section class="section  ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-11 m-auto">
                        <!--widget-author-->
                    
                            <div class="widget-author  ">
                                <div class="author-content">
                                    <h6 class="name"> Hi Eyo, Welcome!</h6>
                                    <a class="btn-link" href="authorsignup.php">Become an Author</a>
                                    
                                </div>
                            </div>
                        
                        <!--/-->
                    
                    </div>
                </div>
            </div>
        </section>
    
        <!--grid-layout-->
        <section class="mt-20">
            <div class="container-fluid">
                <div class="row">
                    
                    <!--Post-1-->
                    <div class="">
                        <div class="post-card">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="color: gray;" >Home</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" style="color: gray;"> Saved Lists </button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false" style="color: gray;">Authors</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <!-- home -->
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form class="widget-contact-form" action="#" method="POST" id="main_contact_form">
                                        <br>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <input type="text" name="name" id="name" class="form-control" placeholder="User Name" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="submit" name="submit" class="btn btn-outline-dark" style="float: right;">
                                                        Save
                                                    </button>
                                                </div> 
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <input type="password" name="confrimpassword" id="confrimpassword" class="form-control" placeholder="Confrim Password" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="submit" name="submit" class="btn btn-outline-dark" style="float: right;">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- saved lists -->
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                     <!--blog-grid-->
                                    <section class="blog-list">
                                        <div class="container-fluid">
                                            <div class="row mt-3">
                                                <div class="col-xl-9 side-content">
                                                    <div class="theiaStickySidebar">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            
                                                            <!--Post-1-->
                                                            <div class="post-list">
                                                                <div class="post-list-image">
                                                                    <a href="post-default.html">
                                                                        <img src="assets/img/blog/16.jpg" alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="post-list-content">
                                                                    <div class="entry-cat">
                                                                        <a href="blog-grid.html" class="categorie"> fashion</a>
                                                                    </div>

                                                                    <h4 class="entry-title">
                                                                        <a href="post-default.html">5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                                                                    </h4>

                                                                    <div class="post-exerpt">
                                                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit quam atque ipsa laborum sunt distinctio... </p>
                                                                    </div>

                                                                    <ul class="entry-meta list-inline">
                                                                        <li class="post-author-img"><a href="author.html"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                                        <li class="post-author"><a href="author.html">David Smith</a> </li>
                                                                        <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                                        <li class="post-timeread"> <span class="dot"></span> 15 min Read</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!--/-->

                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 max-width side-sidebar">
                                                    <div class="theiaStickySidebar">
                                                        
                                                        <!--widget-ads-->
                                                        <div class="widget">
                                                            <div class="section-title">
                                                                <h5>ads</h5>
                                                            </div>
                                                            <div class="widget-ads">
                                                                <a href="#">
                                                                    <img src="assets/img/ads/ads3.jpg" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section><!--/-->
                                </div>
                                <!-- authors user follow -->
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="row mt-3">
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
