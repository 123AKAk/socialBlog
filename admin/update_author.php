<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    $author_id = $_GET["id"];

    // Get author Data to display
    $stmt = $conn->prepare("SELECT * FROM author WHERE author_id = ?");
    $stmt->execute([$author_id]);
    $author = $stmt->fetch();
    

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title"> Edit Author - <?= $author['author_fullname'] ?></h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Edit Author</li>
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
                                    <form class="separate-form" action="../assets/update.php?type=author&id=<?= $author_id ?>&img=<?= $author["author_avatar"] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authName" class="col-form-label">Full Name</label>
                                                        <input class="col-md-8 form-control" type="text" name="authName" id="authName" value="<?= $author['author_fullname'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authEmail" class="col-form-label">Email</label>
                                                        <input class="col-md-8 form-control" type="text" name="authEmail" id="authEmail" value="<?= $author['author_email'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="authDesc" class="col-form-label">Description</label>
                                                        <input class="col-md-8 form-control" type="text" name="authDesc" id="authDesc" value="<?= $author['author_desc'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authImage">Author Avatar</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="authImage" id="authImage">
                                                            <label for="authImage"> <?= $author['author_avatar'] ?> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="my-2" style="width: 200px;">
                                                        <img class="w-100 h-auto" src="../img/avatar/<?= $author["author_avatar"] ?>" alt="">
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authTwitter" class="col-form-label">Twitter Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authTwitter" id="authTwitter" placeholder="@Ex: EAkak" value="<?= $author['author_twitter'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authInstagram" class="col-form-label">Instagram Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authInstagram" id="authInstagram" placeholder="@Ex: EAkak" value="<?= $author['auth_instagram'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="authFacebook" class="col-form-label">Facebook Username</label>
                                                        <input class="col-md-8 form-control" type="text" name="authFacebook" id="authFacebook" placeholder="@Ex: EAkak" value="<?= $author['auth_facebook'] ?>" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button">Back</button>
                                                <input class="btn btn-primary" type="submit" name="update" value="Update">
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