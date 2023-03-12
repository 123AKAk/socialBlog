<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    // Check if the user is already logged in, if yes then redirect him to dasboard page
    if ($loggedin == true) {
        echo "<script>window.location.replace('dashboard.php');</script>";
    }
?>
        <main class="main">
            <!--Login-->
            <section class="mt-60 mb-60">
                <div class="container">
                    <div class="sign widget ">
                        <div class="section-title">
                            <h5>Login</h5>
                        </div>
                        <form class="sign-form widget-form" id="login-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email*" name="email" id="email" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password*" name="password" id="password" value="">
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe" name="rememberMe">
                                    <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                </div>
                                <a href="uforgotpassword.php" class="btn-link  ml-auto">Forgot Password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-custom">Login</button>
                            </div>
                            
                            <p class="form-group text-center">Don't have an account? <a href="signup.php" class="btn-link">Create One</a> </p>
                        </form>
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
