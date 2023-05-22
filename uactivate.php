<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    $dataPurpose = $_GET['dataPurpose'];

    $sharedComponents
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
                                        <h6 class="name"> Activate your Account</h6>
                                        <div class="categorie-title">
                                        <small>
                                            <a href="./">Home</a>
                                        <i class="fas fa-angle-right"></i>Activate
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
        <section class="mt-20 mb-10">
            <div class="container-fluid">
                <div class="container">

                    <!-- error message -->
                    <div class="">
                        <div class='alert alert-danger'>
                            <h5>Error!</h5>
                            "There is no valid message at the moment"
                        </div>
                        <p>
                            <a href='' style='font-weight:bold;'>Try Again</a>
                            <br> 
                            You may <a href='signup.php' style='font-weight:bold;'>Sign Up</a> 
                            or back to <a href='./' style='font-weight:bold;'>Home Page</a>.
                        </p>
                    </div>

                    <!-- success message -->
                    <div class="">
                        <div class='alert alert-success'>
                            <h5>Success!</h5>
                            "Nice one bro, it's a new year"
                        </div>
                        <p>
                            You may <a href='login.php' style='font-weight:bold;'>Login</a> 
                            or back to <a href='./' style='font-weight:bold;'>Home Page</a>.
                        </p>
                    </div>

                    <!-- normal message -->
                    <div class="">
                        <div class='alert alert-secondary'>
                            <h5>Okay!</h5>
                            "You sabi this already na, why you deh stress me"
                        </div>
                        <p>
                            You may <a href='login.php' style='font-weight:bold;'>Login</a> 
                            or back to <a href='./' style='font-weight:bold;'>Home Page</a>.
                        </p>
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
