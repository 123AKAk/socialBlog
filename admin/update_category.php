<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    $category_id = $_GET["id"];

    // Get category Data to display
    $stmt = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch();
    
    

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title"> Edit Post - <?= $category["category_name"] ?></h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Edit Blog Post</li>
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
                                    <form class="separate-form" action="../assets/update.php?type=category&id=<?= $category_id ?>&img=<?= $category["category_image"] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="catName" class="col-form-label">Category Name</label>
                                                        <input type="text" class="col-md-8 form-control" name="catName" id="catName" value="<?= $category["category_name"] ?>" required>
                                                        <label for="catColor" class="col-form-label">Category Color </label>
                                                        <input class="col-md-2" style="height:15px;" type="color" id="catColor" name="catColor" value="<?= $category["category_color"] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="catImage">Category Image</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="catImage" id="catImage">
                                                            <label for="catImage"><?= $category["category_image"] ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="my-2" style="width: 200px;">
                                                        <img class="w-100 h-auto" src="../img/category/<?= $category["category_image"] ?>" alt="">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button" onclick="goback()">Back</button>
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