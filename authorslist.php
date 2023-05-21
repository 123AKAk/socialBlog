<?php
include 'includes/header.php';
include 'includes/navbar.php';

try {

    //$sql = "SELECT DISTINCT a.*, FROM admin a INNER JOIN posts p ON a.admin_id = p.id_admin WHERE p.post_status > 0";
    //selects with post count
    $sql = "SELECT a.*, COUNT(p.post_id) AS postCount FROM admin a LEFT JOIN posts p ON a.admin_id = p.id_admin WHERE p.post_status > 0 GROUP BY a.admin_id ORDER BY RAND()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //$sql = "SELECT DISTINCT u.* FROM user u INNER JOIN posts p ON u.user_id = p.id_user WHERE p.post_status > 0";
    //selects with post count
    $sql = "SELECT u.*, COUNT(p.post_id) AS postCount FROM user u LEFT JOIN posts p ON u.user_id = p.id_user WHERE p.post_status > 0 GROUP BY u.user_id ORDER BY RAND()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<main class="main">
    <!--category-->
    <section class="categorie-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="categorie-title">
                        <small>
                            <a href="index.php">Home</a>
                            <i class="fas fa-angle-right"></i> Authors
                        </small>
                        <h3>Authors</h3>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--blog-grid-->
    <section class="blog-classic">
        <div class="container-fluid">
            <div class="">
                <div class="">
                    <div class="">
                        <div class="">
                            <div class="row">

                                <!-- //admin authors -->
                                <?php
                                if (isset($admins)) {
                                    // Display the admins who have published posts
                                    foreach ($admins as $admin) {
                                        $authLink = "author.php?authDType=Admin&authd=" . $sharedComponents->protect($admin["admin_id"]);

                                        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE authors_followed LIKE :criteria");
                                        $criteria = '%"id":"' . $userId . '","type":"Admin"%';
                                        $stmt->bindParam(':criteria', $criteria, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $adminAuthorNoFollowercount = $result['count'];
                                        echo $admin['profile_pic'];
                                ?>
                                        <!--widget-author-->
                                        <div class="col-lg-4 col-md-4 masonry-item">
                                            <div class="widget">
                                                <div class="widget-author">
                                                    <div class="author-img">
                                                        <a href="<?= $authLink ?>" class="image">
                                                            <img src="<?= $sharedComponents->checkFile($admin['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $admin['profile_pic']; ?>" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="author-content">
                                                        <a href="<?= $authLink ?>">
                                                            <h6 class="name"> Hi, I'm <?= $admin['admin_name'] ?></h6>
                                                        </a>
                                                        <p class="bio">
                                                            <?= $admin['admin_desc'] ?>
                                                        </p>
                                                    </div>
                                                    <div class="social-media">
                                                        <ul class="list-inline">
                                                            <li>
                                                                <b>
                                                                    <p>Post: <?= $admin['postCount'] ?> </p>
                                                                </b>
                                                            </li>
                                                            -
                                                            <li>
                                                                <b>
                                                                    <p>Followers: <?= $adminAuthorNoFollowercount ?> </p>
                                                                </b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                                <!-- //user authors -->
                                <?php
                                if (isset($users)) {
                                    // Display the users who have published posts
                                    foreach ($users as $user) {
                                        $authLink = "author.php?authDType=User&authd=" . $sharedComponents->protect($user["user_id"]);

                                        $userId = $user["user_id"];

                                        // Count the number of user_id values with type 'user' and ID
                                        // $sstmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE JSON_CONTAINS(authors_followed, :criteria, '$[*]')");
                                        // $sstmt->bindValue(':criteria', json_encode(["id" => ".$userId.", "type" => "User"]), PDO::PARAM_STR);
                                        // $sstmt->execute();
                                        // $cresult = $sstmt->fetch(PDO::FETCH_ASSOC);
                                        // $count = $cresult['count'];


                                        // Count the number of user_id values with type 'user' and ID
                                        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE authors_followed LIKE :criteria");
                                        $criteria = '%"id":"' . $userId . '","type":"User"%';
                                        $stmt->bindParam(':criteria', $criteria, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $userAuthorNoFollowercount = $result['count'];
                                ?>
                                        <!--widget-author-->
                                        <div class="col-lg-4 col-md-4 masonry-item">
                                            <div class="widget">
                                                <div class="widget-author">
                                                    <div class="author-img">
                                                        <a href="<?= $authLink ?>" class="image">
                                                            <img src="<?= $sharedComponents->checkFile($user['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $user['profile_pic']; ?>" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="author-content">
                                                        <a href="<?= $authLink ?>">
                                                            <h6 class="name"> Hi, I'm <?= $user['username'] ?></h6>
                                                        </a>
                                                        <p class="bio">
                                                            <?= $user['user_desc'] ?>
                                                        </p>
                                                    </div>
                                                    <div class="social-media">
                                                        <ul class="list-inline">
                                                            <li>
                                                                <b>
                                                                    <p>Post: <?= $user['postCount'] ?> </p>
                                                                </b>
                                                            </li>
                                                            -
                                                            <li>
                                                                <b>
                                                                    <p>Followers: <?= $userAuthorNoFollowercount ?> </p>
                                                                </b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>


                        <!--pagination-->
                        <!-- <div class="pagination mt-30">
                                    <ul class="list-inline">
                                        <li class="active">
                                            <a href="#">1</a>
                                        </li>
                                        <li>
                                            <a href="#">2</a>
                                        </li>
                                        <li>
                                            <a href="#">3</a>
                                        </li>
                                        <li>
                                            <a href="#">4</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div> -->

                        <br>
                    </div>
                </div>


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