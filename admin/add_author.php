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
                                <h4 class="page-title">Add Authors</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Add Authors</li>
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
                                    <form class="separate-form" action="../assets/insert.php?type=author" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authName" class="col-form-label">Full Name</label>
                                                        <input class="col-md-8 form-control" type="text" name="authName" id="authName" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authEmail" class="col-form-label">Email</label>
                                                        <input class="col-md-8 form-control" type="text" name="authEmail" id="authEmail" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="authDesc" class="col-form-label">Description</label>
                                                        <input class="col-md-8 form-control" type="text" name="authDesc" id="authDesc" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="authImage">Author Avatar</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="authImage" id="authImage" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authTwitter" class="col-form-label">Twitter Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authTwitter" id="authTwitter" placeholder="@Ex: EAkak" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authInstagram" class="col-form-label">Instagram Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authInstagram" id="authInstagram" placeholder="@Ex: EAkak" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authFacebook" class="col-form-label">Facebook Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authFacebook" id="authFacebook" placeholder="@Ex: EAkak" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <br>
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
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <!-- Text Editor Script -->
    <script>
        CKEDITOR.replace('arContent');
    </script>
<?php
    include 'includes/scripts.php';
?>