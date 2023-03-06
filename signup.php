<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
        <main class="main">
            <!--register-->
            <section class="mt-60  mb-60">
                <div class="container-fluid">
                    <div class="sign widget">
                        <div class="section-title">
                            <h5>Sign up</h5>
                        </div>
                        
                        <form  class="sign-form widget-form contact_form " method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username*" name="username" value="">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address*" name="email" value="">
                            </div>
                            <div class="form-group">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select Country</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="Ghana">Ghana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password*" name="password" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confrim Password*" name="confrimpassword" value="">
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                    <label class="custom-control-label" for="rememberMe">Agree to our <a href="termandconditions.php" class="btn-link">terms & conditions</a> </label>
                                </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn-custom">Sign Up</button>
                            </div>
                            <p class="form-group text-center">Already have an account? <a href="login.php" class="btn-link">Login</a> </p>
                        </form>
                    </div> 
                </div>
            </section>        

          <!--newslettre-->
          <?php include 'includes/newsletter.php'; ?>
        </main>

<?php
    include 'includes/footer.php';
?>
   

<?php
    include 'includes/scripts.php';
?>
