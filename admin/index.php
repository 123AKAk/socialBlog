<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all ACTIVE users 
    $stmt = $conn->prepare("SELECT * FROM users WHERE userstatus = 1 ORDER BY id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $userscount = $stmt->rowCount();

    // Get all POST
    $stmt = $conn->prepare("SELECT * FROM article");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $postcount = $stmt->rowCount();

    // Get all AUTHOR Data
    $stmt = $conn->prepare("SELECT * FROM author");
    $stmt->execute();
    $authors = $stmt->fetchAll();
    $authorcount = $stmt->rowCount();

    // Get all NEWSLETTER Data
    $stmt = $conn->prepare("SELECT * FROM newsletters");
    $stmt->execute();
    $authors = $stmt->fetchAll();
    $emailcount = $stmt->rowCount();
?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title bold">Dashboard</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Admin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Start Card-->
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Active Users</h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    <h4 class="ad-card-title"><?= $userscount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Blog Post(s)</h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    <h4 class="ad-card-title"><?= $postcount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Author(s)</h3>
                                <div class="icon-info-text">
                                    <h4 class="ad-card-title"><?= $authorcount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Email(s)</h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    <h4 class="ad-card-title"><?= $emailcount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Site Analystics <span><button type="button" class="btn btn-primary squer-btn sm-btn">View</button></span></h4>
                            </div>
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Products Orders Start -->
                <div class="row">
                    
                </div>
				
<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>