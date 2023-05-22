<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    
    // shows author details based on their Id
    if (!isset($_GET['authDType']) && !isset($_GET['authd'])) {
        echo "<script>window.location.replace('404.php?err=Error Getting Author Details, could be that the ');</script>";
    }

    $authorId = $sharedComponents->unprotect($_GET['authd']);

    $authorType = $_GET['authDType'];

    // Get author details
    $authorName = $authorImage = $authorDesc = "";
    if($authorType == "User")
    {
        //gets author's details
        $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :user_id AND status > 0 ");
        $stmt->bindParam(":user_id", $authorId, PDO::PARAM_INT);
        $stmt->execute();
        $user_author = $stmt->fetch();

        //gets number of author's post
        $sql = "SELECT u.*, COUNT(p.post_id) AS postCount FROM user u LEFT JOIN posts p ON u.user_id = p.id_user WHERE p.id_user = $authorId AND p.post_status > 0 GROUP BY u.user_id ORDER BY RAND()";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $userAuthorPostCount = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //gets number of author's followers
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE authors_followed LIKE :criteria");
        $criteria = '%"id":"' . $authorId . '","type":"User"%';
        $stmt->bindParam(':criteria', $criteria, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //gets all author's active post
        $stmt = $conn->prepare("SELECT * FROM posts WHERE id_user = :id_user AND post_status > 0 ");
        $stmt->bindParam(":id_user", $authorId, PDO::PARAM_INT);
        $stmt->execute();
        $authorPost = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //set the author's details
        $authorNoFollowercount = $result['count'];
        $authorNoPost = $userAuthorPostCount['postCount'];
        $authorName = $user_author['username'];
        $authorDesc = $user_author['user_desc'];
        $authorImage = $sharedComponents->checkFile($user_author['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $user_author['profile_pic'];
    }
    else if($authorType == "Admin")
    {
        //gets author's details
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = :admin_id AND admin_status > 0");
        $stmt->bindParam(":admin_id",  $authorId, PDO::PARAM_INT);
        $stmt->execute();
        $admin_author = $stmt->fetch();

        //gets number of author's post
        $sql = "SELECT a.*, COUNT(p.post_id) AS postCount FROM admin a LEFT JOIN posts p ON a.admin_id = p.id_admin WHERE p.id_admin = $authorId AND p.post_status > 0 GROUP BY a.admin_id ORDER BY RAND()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $adminAuthorPostCount = $stmt->fetch(PDO::FETCH_ASSOC);

        //gets number of author's followers
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE authors_followed LIKE :criteria");
        $criteria = '%"id":"' . $authorId . '","type":"Admin"%';
        $stmt->bindParam(':criteria', $criteria, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //gets all author's active post
        $stmt = $conn->prepare("SELECT * FROM posts WHERE id_admin = :id_admin AND post_status > 0 ");
        $stmt->bindParam(":id_admin", $authorId, PDO::PARAM_INT);
        $stmt->execute();
        $authorPost = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //set the author's details
        $authorNoFollowercount = $result['count'];
        $authorNoPost = $adminAuthorPostCount['postCount'];
        $authorName = $admin_author['admin_name'];
        $authorDesc = $admin_author['admin_desc'];
        $authorImage = $sharedComponents->checkFile($admin_author['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $admin_author['profile_pic'];
    }

?>
    <main class="main">
        <!--author-->
        <section class="section  ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-11 m-auto">
                        <!--widget-author-->
                    
                            <div class="widget-author  ">
                                <div class="author-img">
                                    <a href="author.php" class="image">
                                        <img src="<?= $authorImage ?>" alt="">
                                    </a>
                                </div>
                                <div class="author-content">
                                    <h6 class="name"> Hi, I'm <?= $authorName ?></h6>
                                    <div class="btn-link"><?= $authorNoPost ?> Posts</div>
                                    <div class="btn-link"><?= $authorNoFollowercount ?> Followers</div>
                                    <p class="bio">
                                        <?= $authorDesc ?>
                                    </p>
                                    <!-- <div class="social-media">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="#" class="color-facebook"><i class="fab fa-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-instagram"><i class="fab fa-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-twitter"><i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="color-youtube"><i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
                                            <li>
                                            <a href="#" class="color-pinterest"><i class="fab fa-pinterest"></i></a>
                                            </li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        
                        <!--/-->
                    
                    </div>
                </div>
            </div>
        </section>
    
        <!--grid-layout-->
        <section class="mt-90">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    if(isset($authorPost))
                    {
                        foreach ($authorPost as $post)
                        {
                            $postId = $sharedComponents->protect($post['post_id']);
                            
                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];

                    ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="post-card">
                                <div class="post-card-image">
                                    <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $postId ?>">
                                        <img src="<?= $postImage ?>" alt="" width="100%">
                                    </a>
                                </div>
                                <div class="post-card-content">
                                    <div class="entry-cat">
                                        <p class="categorie"><?= $post['post_country'] ?></p>
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
                                        <li class="post-date"> <?= date_format(date_create($post["post_creation_time"]), "F d, Y") ?> </li>
                                    </ul>
                                </div>
                            </div>
                            <!--/-->
                        </div>
                    <?php
                        }
                    }
                    ?>


                    <!--pagination-->
                    <!-- <div class="col-lg-12">
                        <div class="pagination">
                            <ul class="list-inline">
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="fas fa-arrow-right"></i></a> </li>
                            </ul>
                        </div> 
                    </div> -->
                </div>
            </div>
        </section>
        <!--/-->

        <!--newslettre-->
        <?php include 'includes/newsletter.php'; ?>
    </main>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
