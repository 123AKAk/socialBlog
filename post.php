<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    if(!isset($_GET['id']))
    {
        echo "<script>window.location.replace('404.php?err=Error Getting Post Details');</script>";
    }
    
    $postId = $sharedComponents->unprotect($_GET['id']);
    
    //check if value is an integer

    // Get post details
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_id=$postId");
    $stmt->execute();
    $post = $stmt->fetch();

    if(empty($post))
    {
        echo "<script>window.location.replace('404.php?err=Post does not Exists, cannot be found');</script>";
    }

    $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

    $authId = $adminUserDetails["id"];
    $authEmail = $adminUserDetails["email"];
    $authName = $adminUserDetails["username"];
    $authGender = $adminUserDetails["gender"];
    $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $folder_name . $adminUserDetails["profile_pic"];
    $authLink = "author.php?authDType=".$adminUserDetails["type"]."&authd=".$adminUserDetails["id"];

    $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];

    // Count the number of words in the text
    $num_words = str_word_count($sharedComponents->convertHtmltoText($post['post_contents'], 25, '', ''));

    // Assume an average reading speed of 200 words per minute
    $avg_speed = 200;

    // Calculate the estimated reading time in minutes
    $reading_time = ceil($num_words / $avg_speed);
    
?>
        <main class="main">
            <!--post-default-->
            <section class="mt-60  mb-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 side-content">
                            <div class="theiaStickySidebar">
                                <!--Post-single-->
                                <div class="post-single">
                                    <div class="post-single-image">
                                        <img src="<?= $postImage; ?>" alt="">
                                    </div>
                                    <div class="post-single-content">
                                        <a href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $post['category_id'] ?>" class="categorie">
                                            <?= $post['category_name'] ?>
                                        </a>
                                        <h3 class="title"><?= $post['post_title'] ?></h3>
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
                                            <li class="post-comment"><span class="dot"></span>
                                                <?= $sharedComponents->checkNumofComments($postId, $pdo)." comments"; ?>
                                            </li>
                                        </ul>
                                    
                                    </div>
                            
                                    <div class="post-single-body">
                                        <p>
                                            <?= htmlspecialchars_decode($post['post_contents']) ?>
                                        </p>
                                    </div>

                                    <div class="post-single-footer">
                                        <div class="tags">
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="category.php?dt=<?= $post['category_name'] ?>&catid=<?= $post['category_id'] ?>" class="categorie">
                                                        <?= $post['category_name'] ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="social-media">
                                            <!-- share to diffrent social media -->
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="#" class="color-facebook">
                                                        <i class="fab fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="color-instagram">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="color-twitter">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="color-youtube">
                                                        <i class="fab fa-youtube"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="color-pinterest">
                                                        <i class="fab fa-pinterest"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>                           
                                    </div>
                                </div> <!--/-->

                                <!--next & previous-posts-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="widget">
                                            <div class="widget-next-post">
                                                <div class="post-item">
                                                    <div class="image">
                                                        <a href="post.php"> <img src="assets/img/latest/1.jpg" alt="..."></a>
                                                    </div>
                                                
                                                    <div class="content">
                                                        <a class="btn-link" href="post.php"><i class="fas fa-arrow-left"></i>Preview post</a>
                                                        <p class="entry-title"><a href="post.php">5 Things I Wish I Knew Before Traveling to Malaysia</a></p>
                                                        
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="widget">
                                            <div class="widget-previous-post">
                                                <div class="post-item">
                                                    <div class="image">
                                                        <a href="post.php"> <img src="assets/img/latest/2.jpg" alt="..."></a>
                                                    </div>
                                                
                                                    <div class="content">
                                                        <a class="btn-link" href="post.php"><i class="fas fa-arrow-right"></i>next post</a>
                                                        <p class="entry-title"><a href="post.php">5 Things I Wish I Knew Before Traveling to Malaysia</a></p>
                                                    
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/-->

                                <!--widget-comments-->
                                <div class="widget mb-50">
                                    <div class="widget-comments">
                                        <div class="title">
                                            <h5>3 Comments</h5>
                                        </div>
                                        <ul class="widget-comments-items">
                                           
                                            <li class="comment-item">
                                                <img src="assets/img/user/2.jpg" alt="">
                                                <div class="content">
                                            
                                                    <ul class="info list-inline">
                                                        <li>Adam bobly</li>
                                                        <li class="dot"></li>
                                                        <li> January 15, 2021</li>
                                                    </ul>
                                    
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus at doloremque adipisci eum placeat
                                                        quod non fugiat aliquid sit similique!
                                                    </p>
        
                                                    <div>
                                                        <a href="#" class="btn-link">
                                                            <i class="arrow_back"></i> Reply</a>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                
                                    <!--Leave-comments-->
                                    <div class="widget-form">
                                        <div class="title">
                                            <h5>Leave a Reply</h5>
                                        </div>
                                        <form class="widget-contact-form" action="#" method="POST" id="main_contact_form">
                                            <p>Your email adress will not be published ,Requied fileds are marked*.</p>
                                            <div class="alert alert-success contact_msg" style="display: none" role="alert">
                                                Your message was sent successfully.
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Message*" required="required"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name*" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email*" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-20">
                                                    <div class="form-group">
                                                        <input type="text" name="website" id="website" class="form-control" placeholder="website">
                                                    </div>
                                                    <label>
                                                        <input name="name" type="checkbox" value="1" required="required"> 
                                                    <span>save my name , email and website in this browser for the next time I comment.</span>                                   
                                                    </label>
                                                </div>
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
