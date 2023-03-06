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
                                        <h6 class="name"> Reset your account Password</h6>
                                        <div class="categorie-title">
                                        <small>
                                            <a href="./">Home</a>
                                        <i class="fas fa-angle-right"></i>Account Reset
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
                            <h5>Account Reset</h5>
                        </div>
                        <form  action="#" class="sign-form widget-form " method="post">
                            <div class="form-group" style="text-align: center;">
                                <input type="number" class="form" placeholder=" Enter Code from Email" name="code" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Password *" name="password" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Confrim Password *" name="confrimpassword" value="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-custom">Update</button>
                            </div>
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
