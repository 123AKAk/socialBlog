<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    // shows author details based on their Id
    if (!isset($_GET['catd'])) {
        echo "<script>window.location.replace('404.php?err=Error Getting Category Details');</script>";
    }

    echo $catId = $sharedComponents->unprotect($_GET['catd']);

    // Get Category Info
    $stmt = $conn->prepare("SELECT * FROM `category` WHERE category_id = ?");
    $stmt->execute([$catId]);
    $category = $stmt->fetch();

    // Get category post
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE id_category = ?");
    $stmt->execute([$catId]);
    $posts = $stmt->fetchAll();

    if (!isset($category)) {
        echo "<script>window.location.replace('404.php?err=Error Getting Category Details');</script>";
    }

?>

        <main class="main">
            <!--Categorie-->
            <section class="categorie-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="categorie-title">
                                <small>
                                    <a href="./">Home</a>
                                   <i class="fas fa-angle-right"></i><?= $category["category_name"] ?>
                                </small>
                                <h3>Category : <span><?= $category["category_name"] ?></span> </h3>
                                <p> <?= $category["category_desc"] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--/-->

            <!--blog-grid-->
            <section class="blog-grid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 mt-30 side-content">
                            <div class="theiaStickySidebar">
                                <div class="row masonry-items">
                                
                                <?php 
                                    foreach ($posts as $post) : 

                                    $postId = $sharedComponents->protect($post['post_id']);
                        
                                    $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];

                                    $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                                    $authId = $adminUserDetails["id"];
                                    $authEmail = $adminUserDetails["email"];
                                    $authName = $adminUserDetails["username"];
                                    $authGender = $adminUserDetails["gender"];
                                    $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
                                    $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];
                                ?>

                                    <!--Post-1-->
                                    <div class="col-lg-6 col-md-6 masonry-item">
                                        <div class="post-card ">
                                            <div class="post-card-image">
                                                <a href="post.php?dt=<?= $post['post_title']?>&id=<?= $postId ?>">
                                                    <img src="<?= $postImage ?>" alt="" width="100%">
                                                </a>
                                            </div>
                                            <div class="post-card-content">
                                                <div class="entry-cat">
                                                    <a class="categorie" href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $sharedComponents->protect($post['category_id']) ?>">
                                                        <?= $post['category_name'] ?>
                                                    </a>
                                                </div>
            
                                                <h5 class="entry-title">
                                                    <a href="post.php?dt=<?= $post['post_title']?>&id=<?= $postId ?>">
                                                        <?= $post['post_title'] ?>
                                                    </a>
                                                </h5>
            
                                                <div class="post-exerpt">
                                                    <p>
                                                    <?= $sharedComponents->convertHtmltoText($post['post_contents'], 25, '', '') ?>
                                                    </p>
                                                </div>
            
                                                <ul class="entry-meta list-inline">
                                                <li class="post-author-img">
                                                    <a href="<?= $authLink ?>">
                                                        <img src="<?= $authProfilePic ?>" alt="">
                                                    </a>
                                                </li>
                                                <li class="post-author">
                                                    <a href="<?= $authLink ?>">
                                                        <?= $authName ?> 
                                                    </a> 
                                                </li>
                                                    <li class="post-date"> <span class="dot"></span>  
                                                        <?= date_format(date_create($post["post_creation_time"]), "F d, Y") ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/-->

                                <?php endforeach; ?>
                    
                                </div>
            
                                <!--pagination-->
                                <!-- <div class="row">
                                    <div class="col-lg-12">
                                        <div class="pagination ">
                                            <ul class="list-inline">
                                                <li class="active"> <a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#"><i class="fas fa-arrow-right"></i></a></li>
                                            </ul>
                                        </div>   
                                    </div>
                                </div> -->

                            </div>
                        </div>
                        
                        <!-- sidebar -->
                        <?php include 'includes/sidebar.php'; ?>

                    </div>
                </div>
            </section><!--/-->
            
           <!--newslettre-->
           <?php include 'includes/newsletter.php'; ?>
        </main>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
