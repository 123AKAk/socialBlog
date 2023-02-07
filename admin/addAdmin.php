<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';
?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title">Add Adminstrator</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="./"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Add Adminstrator</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col">
                            <div class="card">
                            
                                <div class="col">
                                    <!-- feedback message -->
                                    <?php include 'includes/feedbackmsg.php'; ?>
                                </div>

                                <div class="card-body">
                                    <form class="separate-form" action="php/insert.php?type=post" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="admin_name" class="col-form-label">Adminstrator Name</label>
                                                        <input class="form-control" type="text" placeholder="Enter Adminstrator Name" name="admin_name" id="admin_name" >
                                                    </div>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="admin_email" class="col-form-label">Adminstrator Email</label>
                                                        <input class="form-control" type="email" placeholder="Enter Adminstrator Email" name="admin_email" id="admin_email" >
                                                    </div>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password" class="col-form-label">Adminstrator Password</label>
                                                        <input class="form-control" type="password" placeholder="Enter Adminstrator Password" name="password" id="password" >
                                                    </div>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="confrim_password" class="col-form-label">Confrim Password</label>
                                                        <input class="form-control" type="password" placeholder="Confrim Password" name="confrim_password" id="confrim_password" >
                                                    </div>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="role" class="col-form-label">Adminstrator Role</label>
                                                        <input class="form-control" type="text" placeholder="Confrim Password" name="role" id="role" >
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button" onclick="goback()">Back</button>
                                                <input class="btn btn-primary" type="submit" name="submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
<?php
    include 'includes/footer.php';
?>  
<?php
    include 'includes/scripts.php';
?>