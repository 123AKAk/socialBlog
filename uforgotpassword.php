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
                                        <h6 class="name"> Forgotten Password?</h6>
                                        <div class="categorie-title">
                                        <small>
                                            <a href="./">Home</a>
                                        <i class="fas fa-angle-right"></i>Forgot Password
                                        </small>
                                    </div>
                                </div>
                            </div>
                        
                        <!--/-->
                    
                    </div>
                </div>
            </div>
        </section>
    
        <!--grid-layout-->
        <section class="mt-20 mb-15">
            <div class="container-fluid">
                <div class="container">
                    <div class="sign widget ">
                        <div class="section-title">
                            <h5>Enter your Registered Email</h5>
                        </div>
                        <form  action="#" class="sign-form widget-form " method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email" value="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-custom">Send Mail</button>
                            </div>
                            <p class="form-group text-center">Don't have an account? <a href="signup.php" class="btn-link">Create One</a> </p>
                        </form>
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
