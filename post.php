<?php
include 'includes/header.php';
include 'includes/navbar.php';

if (isset($_COOKIE["tok__enCountry"]) && !empty($_COOKIE["tok__enCountry"])) {

    $userCountry = $_COOKIE["tok__enCountry"];

    if (!isset($_GET['id'])) {
        echo "<script>window.location.replace('404.php?err=Error Getting Post Details');</script>";
    }

    $postId = $sharedComponents->unprotect($_GET['id']);

    // Get post details
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_id=$postId AND delete_status=0 AND post_country='$userCountry'");
    $stmt->execute();
    $post = $stmt->fetch();

    if (empty($post)) {
        echo "<script>window.location.replace('404.php?err=Post does not Exists, could be post is not for your country of choice found');</script>";
    }

    $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

    $authId = $adminUserDetails["id"];
    $authEmail = $adminUserDetails["email"];
    $authName = $adminUserDetails["username"];
    $authGender = $adminUserDetails["gender"];
    $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
    $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];

    $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];

    // Count the number of words in the text
    $num_words = str_word_count($sharedComponents->convertHtmltoText($post['post_contents'], 25, '', ''));

    // Assume an average reading speed of 200 words per minute
    $avg_speed = 200;

    // Calculate the estimated reading time in minutes
    $reading_time = ceil($num_words / $avg_speed);
}


?>
<main class="main">
    <!--post-default-->
    <section class="mt-60  mb-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 side-content">
                    <div class="theiaStickySidebar">
                        <?php
                        if (isset($post)) {
                        ?>
                            <!--Post-single-->
                            <div class="post-single">
                                <div class="post-single-image">
                                    <img src="<?= $postImage; ?>" alt="">
                                </div>
                                <div class="post-single-content" id="post-contents">
                                    <p class="">
                                        <?php
                                            $viewsPostDetails = $sharedComponents->getViewsPostDetails($postId, $conn);
                                            if(isset($viewsPostDetails))
                                            {
                                                echo $viewsPostDetails;
                                            }
                                        ?> Unique Post View(s)
                                    </p>
                                    <div class="post-single-footer">
                                        <div class="tags">
                                            <a href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $post['category_id'] ?>" class="categorie">
                                                <?= $post['category_name'] ?>
                                            </a>
                                        </div>
                                        <div class="social-media">
                                            <!-- share to diffrent social media -->
                                            <ul class="list-inline">
                                                <?php
                                                if ($loggedin == true) 
                                                {
                                                    $DuserId = $_SESSION["macae_blog_user_loggedin_"];
                                                    $DpostId = $sharedComponents->protect($postId);
                                                    
                                                    $postDetails = $sharedComponents->getPostDetails($DpostId, $DuserId, $conn);

                                                    $bookmarkDetails = $sharedComponents->getBookmarkDetails($DpostId, $DuserId, $conn);

                                                    $authorFollowDetails = $sharedComponents->getAuthorFollowDetails($authId, $DuserId, $conn);
                                                    
                                                    if(isset($postDetails))
                                                    {
                                                        $likes = $postDetails['likes'];
                                                        $dislikes = $postDetails['dislikes'];
                                                ?>
                                                    <li>
                                                        <a id="likePost" href="javascript:void(0);" class="color-icons" title="Like Post" onclick="like_dislikePost('<?= $DpostId ?>', '<?= $DuserId ?>', 'like', this)" style="<?= ($likes == 1) ? "background:#0e100fbf;" : ""; ?>">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a id="dislikePost" href="javascript:void(0);" class="color-icons" title="Dislike Post" onclick="like_dislikePost('<?= $DpostId ?>', '<?= $DuserId ?>', 'dislike', this)" style="<?= ($dislikes == 1) ? "background:#0e100fbf;" : ""; ?>">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    } else {
                                                ?>
                                                    <li>
                                                        <a id="likePost" href="javascript:void(0);" class="color-icons" title="Like Post" onclick="like_dislikePost('<?= $DpostId ?>', '<?= $DuserId ?>', 'like', this)">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a id="dislikePost" href="javascript:void(0);" class="color-icons" title="Dislike Post" onclick="like_dislikePost('<?= $DpostId ?>', '<?= $DuserId ?>', 'dislike', this)">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    }
                                                    if(isset($bookmarkDetails) && $bookmarkDetails == 1)
                                                    {
                                                ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="color-icons" title="Bookmark Post" onclick="Un_BookmarkPost('<?= $DpostId ?>', '<?= $DuserId ?>', 'remove', this)" style="background:#0e100fbf;">
                                                            <i class="fas fa-bookmark"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    } else {
                                                ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="color-icons" title="Bookmark Post" onclick="Un_BookmarkPost('<?= $DpostId ?>', '<?= $DuserId ?>', 'add', this)">
                                                            <i class="fas fa-bookmark"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    }
                                                    if(isset($authorFollowDetails) && $authorFollowDetails == 1)
                                                    {
                                                ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="color-icons" title="Follow Author" onclick="Un_FollowAuthor('<?= $authId ?>', '<?= $DuserId ?>', 'remove', this)" style="background:#0e100fbf;">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    } else {
                                                ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="color-icons" title="Follow Author" onclick="Un_FollowAuthor('<?= $authId ?>', '<?= $DuserId ?>', 'add', this)">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                    </li>
                                                <?php
                                                    }
                                                }
                                                else
                                                {
                                                ?>
                                                <li>
                                                    <a href="javascript:void(0);" class="color-icons" title="Like Post" onclick="makelogin()">
                                                        <i class="fa fa-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="color-icons" title="Dislike Post" onclick="makelogin()">
                                                        <i class="fa fa-thumbs-down"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="color-icons" title="Bookmark Post" onclick="makelogin()">
                                                        <i class="fas fa-bookmark"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="color-icons" title="Follow Author" onclick="makelogin()">
                                                        <i class="fas fa-user-plus"></i>
                                                    </a>
                                                </li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <h3 class="title mt-4"><?= $post['post_title'] ?></h3>
                                    <ul class="entry-meta list-inline">
                                        <li class="post-author-img">
                                            <a href="<?= $authLink ?>">
                                                <img src="<?= $authProfilePic; ?>" alt="">
                                            </a>
                                        </li>
                                        <li class="post-author"><a href="<?= $authLink ?>"><?= $authName ?></a> </li>
                                        <li class="post-date"><span class="dot"></span>
                                            <?= date_format(date_create($post['post_creation_time']), "F d, Y") ?>
                                        </li>
                                        <li class="post-timeread"> <span class="dot"></span>
                                            <?= $reading_time; ?> min Read
                                        </li>
                                        <li class="post-comment" id="bcomments"><span class="dot"></span>
                                            <?php
                                            $commentResults = $sharedComponents->checkComments($postId, $conn);
                                            echo $commentResults["numberofRows"];
                                            ?> comments
                                        </li>
                                    </ul>

                                </div>

                                <div class="post-single-body">
                                    <p>
                                        <?= htmlspecialchars_decode($post['post_contents']) ?>
                                    </p>
                                </div>

                                <div class="post-single-footer">
                                    <!-- ShareThis BEGIN -->
                                    <div class="sharethis-inline-share-buttons"></div>
                                    <!-- ShareThis END -->
                                </div>
                            </div> <!--/-->
                        <?php
                        }
                        ?>
                        <!--next & previous-posts-->
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $prevstmt = $conn->prepare("SELECT * FROM `posts` WHERE delete_status=0 AND post_status=1 AND post_country='$userCountry' AND post_id < $postId ORDER BY post_id DESC LIMIT 1");
                                $prevstmt->execute();
                                $previousPost = $prevstmt->fetch();

                                if (isset($previousPost) && !empty($previousPost)) {
                                ?>
                                    <div class="widget">
                                        <div class="widget-next-post">
                                            <div class="post-item">
                                                <div class="image">
                                                    <a href="post.php?dt=<?= $previousPost["post_title"] ?>&id=<?= $sharedComponents->protect($previousPost["post_id"]) ?>"> <img src="<?= $folder_name . $previousPost['post_thumbnail'] ?>" alt="..."></a>
                                                </div>
                                                <div class="content">
                                                    <a class="btn-link" href="post.php?dt=<?= $previousPost["post_title"] ?>&id=<?= $sharedComponents->protect($previousPost["post_id"]) ?>">
                                                        <i class="fas fa-arrow-left"></i>Preview post
                                                    </a>
                                                    <p class="entry-title">
                                                        <a href="post.php?dt=<?= $previousPost["post_title"] ?>&id=<?= $sharedComponents->protect($previousPost["post_id"]) ?>">
                                                            <?= $previousPost["post_title"] ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $nextstmt = $conn->prepare("SELECT * FROM `posts` WHERE delete_status=0 AND post_status=1 AND post_country='$userCountry' AND post_id > $postId ORDER BY post_id ASC LIMIT 1");
                                $nextstmt->execute();
                                $nextPost = $nextstmt->fetch();

                                if (isset($nextPost) && !empty($nextPost)) {
                                ?>
                                    <div class="widget">
                                        <div class="widget-previous-post">
                                            <div class="post-item">
                                                <div class="image">
                                                    <a href="post.php?dt=<?= $nextPost["post_title"] ?>&id=<?= $sharedComponents->protect($nextPost["post_id"]) ?>"> <img src="<?= $folder_name . $nextPost['post_thumbnail'] ?>" alt="..."></a>
                                                </div>
                                                <div class="content">
                                                    <a class="btn-link" href="post.php?dt=<?= $nextPost["post_title"] ?>&id=<?= $sharedComponents->protect($nextPost["post_id"]) ?>">
                                                        <i class="fas fa-arrow-right"></i>Next post
                                                    </a>
                                                    <p class="entry-title">
                                                        <a href="post.php?dt=<?= $nextPost["post_title"] ?>&id=<?= $sharedComponents->protect($nextPost["post_id"]) ?>">
                                                            <?= $nextPost["post_title"] ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div><!--/-->

                        <!--widget-comments-->
                        <div class="widget mb-50">
                            <?php
                            $commentResults = $sharedComponents->checkComments($postId, $conn);
                            ?>
                            <div class="widget-comments" id="acomments">
                                <div class="title">
                                    <h5><?= $commentResults["numberofRows"]; ?> Comments</h5>
                                </div>
                                <ul class="widget-comments-items">
                                    <?php
                                    foreach ($commentResults["comments"] as $rows) :
                                    ?>
                                        <li class="comment-item">
                                            <?php
                                            if ($rows["userid"] != 0) {
                                                $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post("", $rows["userid"], $pdo), true);

                                                $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
                                                $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];

                                                $timestamp = strtotime($rows["date_added"]);
                                                $formattedDate = date("jS F, Y H:i", $timestamp);
                                            ?>
                                                <a href="<?= $authLink ?>">
                                                    <img src="<?= $authProfilePic ?>" alt="<?= $rows["name"] ?>" title="Site User - <?= $rows["name"] ?>">
                                                </a>
                                                <div class="content">
                                                    <ul class="info list-inline">
                                                        <li><?= $rows["name"] ?></li>
                                                        <li class="dot"></li>
                                                        <li><?= $formattedDate ?></li>
                                                    </ul>
                                                    <p><?= $rows["comment"] ?></p>
                                                    <!-- <div>
                                                        <a href="#" class="btn-link">
                                                            <i class="arrow_back"></i> Reply</a>
                                                    </div> -->
                                                </div>
                                            <?php
                                            } else {

                                                $timestamp = strtotime($rows["date_added"]);
                                                $formattedDate = date("jS F, Y H:i", $timestamp);
                                            ?>
                                                <img src="avatar.jpg" alt="<?= $rows["name"] ?>" title="<?= $rows["name"] ?> (Gender Netural)">
                                                <div class="content">
                                                    <ul class="info list-inline">
                                                        <li><?= $rows["name"] ?></li>
                                                        <li class="dot"></li>
                                                        <li><?= $formattedDate ?></li>
                                                    </ul>
                                                    <p><?= $rows["comment"] ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </li>
                                    <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </div>

                            <!--Leave-comments-->
                            <div class="widget-form">
                                <div class="title">
                                    <h5>Leave a Reply</h5>
                                </div>
                                <form class="widget-contact-form" action="#" method="POST" id="comment-form">
                                    <p>Your email adress will not be published ,Requied fileds are marked*.</p>
                                    <div class="alert alert-success contact_msg" style="display: none" role="alert">
                                        Your message was sent successfully.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Comment*" required="required"></textarea>
                                            </div>
                                        </div>
                                        <?php
                                        if ($loggedin == true) 
                                        {
                                            $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                                            
                                            $data = json_decode($sharedComponents->getUserDetails($conn, $userId), 1);

                                            if (isset($data["response"])) {
                                                if ($data["response"] == true) {
                                                    $details = $data["data"];
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input value="<?= $details["username"] ?>" type="text" name="name" id="name" class="form-control" placeholder="Name*" required="required" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input value="<?= $details["email"] ?>" type="email" name="email" id="email" class="form-control" placeholder="Email" required="required" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display: none;">
                                            <div class="form-group">
                                                <input value="<?= $sharedComponents->protect($userId) ?>" type="text" name="userId" id="userId" class="form-control">
                                            </div>
                                        </div>
                                        <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Name*" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display: none;">
                                            <div class="form-group">
                                                <input value="" type="text" name="userId" id="userId" class="form-control">
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- <div class="col-12 mb-20">
                                            <label>
                                                <input name="saveDetails" type="checkbox" value="1" required="required">
                                                <span>save my name , email and website in this browser for the next time I comment.</span>
                                            </label>
                                        </div> -->
                                        <div class="col-12">
                                            <button type="submit" name="submit" class="btn-custom">
                                                Send Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
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
<script>
    //this sets the view count for the post when a unique user views the post for the first time
    // Get the section element by its ID
    var section = document.getElementById("post-contents");

    // Flag variable to track if the function has already been executed
    var isFunctionExecuted = false;

    // Register the view function to be executed on scroll
    window.addEventListener("scroll", function() {
        var sectionPosition = section.getBoundingClientRect();

        // Check if the top of the section is in the viewport
        if (!isFunctionExecuted && sectionPosition.top >= 0 && sectionPosition.top <= window.innerHeight) {
            like_dislikePost('<?= $DpostId ?>', '<?= $DuserId ?>', 'view', "")
            isFunctionExecuted = true;
        }
    });

    // signup form
    $("#comment-form").submit(function(event) {
        var name = $("#name").val();
        var email = $("#email").val();
        var comment = $("#comment").val();

        var userId = $("#userId").val();
        var postId = <?= $postId ?>;

        if (
            name == "" ||
            email == "" ||
            comment == ""
        ) {
            alertify.error("Fill all Input Feilds");
        } else {                
            let formdata = new FormData();
            formdata.append("name", name);
            formdata.append("email", email);
            formdata.append("comment", comment);

            formdata.append("userId", userId);
            formdata.append("postId", postId);

            let loca = "classes/components/userComponents.php?dataPurpose=comment";
            fetch(loca, {
                    method: "POST",
                    body: formdata
                })
                .then((res) => res.json())
                .then((data) => {
                    var result = (data);
                    if (result.response == true) {
                        reloadObj("acomments");
                        alertify.success(result.message);
                        reloadObj("bcomments");

                        name = email = comment = "";

                    } else {
                        alertify.error(result.message);
                    }
                });
        }
        event.preventDefault();
    });

</script>