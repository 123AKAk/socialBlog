<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
        <main class="main">
            <!--Page404-->
            <section class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 m-auto">   
                            <div class="page404">
                                <div class="page404-image">
                                    <img src="assets/img/pic/error.png" alt="">
                                </div>
                                <div class="page404-content">
                                    <h3>Oops! This page can’t be found </h3>
                                    <p>The page which you are looking for does not exist. </p>
                                    <a href="./" class="btn-custom">Go back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>        

           <!--newslettre-->
           <?php include 'includes/newsletter.php'; ?>
        </main>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
