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
                        
                        <form  class="sign-form widget-form contact_form " id="signup-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="User Name*" id="username" name="username" value="">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address*" id="email" name="email" value="">
                            </div>
                            <div class="form-group">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password*" id="password" name="password" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confrim Password*" id="confrimpassword" name="confrimpassword" value="">
                            </div>
                            <div class="form-group">
                                <label for="country">Select your Country</label>
                                <select name="country" id="country" class="select2bs4 form-control" style="width: 100%;" onchange="getSelectedCountry(this)">
                                </select>
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agreed">
                                    <label class="custom-control-label" for="agreed">Agree to our <a href="termandconditions.php" class="btn-link">terms & conditions</a> </label>
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
