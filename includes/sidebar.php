                                    <div class="col-xl-3 max-width side-sidebar">
                                        <div class="theiaStickySidebar">
                                            <!--widget-author-->
                                            <div class="widget">
                                                <div class="widget-author">
                                                    <div class="author-img">
                                                        <a href="author.php" class="image">
                                                            <img src="assets/img/author/1.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="author-content">
                                                        <h6 class="name"> Hi, I'm David Smith</h6>
                                                        <p class="bio">
                                                            I'm David Smith, husband and father ,
                                                            I love Photography,travel and nature. I'm working as a writer and blogger with experience
                                                            of 5 years until now.
                                                        </p>
                                                        <div class="social-media">
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
                                                </div>
                                            </div>
                                            <!--/-->

                                            <!--widget-latest-posts-->
                                            <div class="widget ">
                                                <div class="section-title">
                                                    <h5>Popular Posts</h5>
                                                </div>
                                                <ul class="widget-latest-posts" id="popularPost">
                    
                                                    <?php     
                                                        $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id INNER JOIN postdetails ON post_id=postid WHERE post_status=1 AND delete_status=0 ORDER BY `views` DESC LIMIT 5");
                                                        $stmt->execute();
                                                        $most_read_posts = $stmt->fetchAll();

                                                        if(isset($most_read_posts))
                                                        {
                                                            foreach ($most_read_posts as $post) : 

                                                                $views = !isset($post["views"]) ? 0 : $post["views"];
                                                                $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $folder_name . $post['post_thumbnail'];
                                                    ?>
                                                    <li class="post-item">
                                                        <div class="image">
                                                            <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $sharedComponents->protect($post['post_id']) ?>"> <img src="<?= $postImage; ?>" alt="..."></a>
                                                        </div>
                                                        <div class="count"><?= $views ?></div>
                                                        <div class="content">
                                                            <p class="entry-title">
                                                                <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $sharedComponents->protect($post['post_id']) ?>">
                                                                    <?= $post['post_title']; ?>
                                                                </a>
                                                            </p>
                                                            <small class="post-date"><i class="fas fa-clock"></i>
                                                                <?= date_format(date_create($post['post_creation_time']), "F d, Y") ?>
                                                            </small>
                                                        </div>
                                                    </li>
                                                    <?php 
                                                            endforeach; 
                                                        }
                                                        else
                                                        {
                                                            echo "<p>Post not avaiable</p>";
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <!--/-->
                                            
                                            <!--widget-categories-->
                                            <div class="widget">
                                                <div class="section-title">
                                                    <h5>Categories</h5>
                                                </div>
                                                <ul class="widget-categories">
                                                <?php     
                                                        // Get Categories
                                                        $stmt = $conn->prepare("SELECT *,COUNT(*) as post_count FROM `posts` INNER JOIN category ON category_id=id_category GROUP BY category_id DESC");
                                                        $stmt->execute();
                                                        $categories = $stmt->fetchAll();

                                                        if(isset($categories))
                                                        {
                                                            foreach ($categories as $category) : 
                                                            
                                                                $catLink = "category.php?nam=".$category["category_name"]."&catd=".$sharedComponents->protect($category["category_id"]);
                                                    ?>
                                                    <li>
                                                        <a href="<?= $catLink ?>" class="categorie">
                                                            <?= $category["category_name"] ?>
                                                        </a>
                                                        <span class="ml-auto"> <?= $category["post_count"] ?> Posts</span>
                                                    </li>
                                                    <?php 
                                                            endforeach; 
                                                        }
                                                        else
                                                        {
                                                            echo "<p>Category(s) not avaiable</p>";
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            
                    
                                            <!--widget-tags-->
                                            <div class="widget">
                                                <div class="section-title">
                                                    <h5>Popular Authors</h5>
                                                </div>
                                                <div class="">
                                                <ul class="widget-latest-posts">
                                                    <!-- user_id,   -->
                                                    <?php     
                                                        $stmt = $conn->prepare("SELECT *, COUNT(*) as post_count FROM `posts` WHERE post_status=1 AND delete_status=0 GROUP BY id_user  ORDER BY COUNT(*) DESC LIMIT 5");
                                                        $stmt->execute();
                                                        $most_read_authors = $stmt->fetchAll();

                                                        if(isset($most_read_authors))
                                                        {
                                                            foreach ($most_read_authors as $authors) : 

                                                                $authorId = $authLink = $authorName = $authorImage = $authorDesc = "";

                                                                //echo $authors['id_user']. " | ".$authors['id_admin']."<br>";

                                                                if($authors['id_user'] != 0 && $authors['id_admin'] == 0)
                                                                {
                                                                    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :user_id");
                                                                    $stmt->bindParam(":user_id", $authors['id_user'], PDO::PARAM_STR);
                                                                    $stmt->execute();
                                                                    $users_authors = $stmt->fetchAll();

                                                                    foreach ($users_authors as $authors_u) : 

                                                                    $authorId = $sharedComponents->protect($authors_u['user_id']);
                                                                    $authLink = "author.php?authDType=User&authd=".$authorId;
                                                                    $authorName = $authors_u['username'];
                                                                    $authorDesc = $authors_u['user_desc'];
                                                                    $authorImage = $sharedComponents->checkFile($authors_u['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $authors_u['profile_pic'];

                                                                    endforeach; 
                                                                }
                                                                else if($authors['id_admin'] != 0 && $authors['id_user'] == 0)
                                                                {
                                                                    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
                                                                    $stmt->bindParam(":admin_id",  $authors['id_admin'], PDO::PARAM_STR);
                                                                    $stmt->execute();
                                                                    $admins_authors = $stmt->fetchAll();

                                                                    foreach ($admins_authors as $authors_a) : 

                                                                    $authorId = $sharedComponents->protect($authors['id_admin']);
                                                                    $authLink = "author.php?authDType=Admin&authd=".$authorId;
                                                                    $authorName = $authors_a['admin_name'];
                                                                    $authorDesc = $authors_a['admin_desc'];
                                                                    $authorImage = $sharedComponents->checkFile($authors_a['profile_pic']) == 0 ? "noimage.jpg" : $folder_name . $authors_a['profile_pic'];

                                                                    endforeach; 
                                                                }
                                                                else
                                                                {
                                                                    echo "Authentication Error";
                                                                }

                                                    ?>
                                                    <li class="post-item">
                                                        <div class="image">
                                                            <a href="<?= $authLink ?>"> <img src="<?= $authorImage; ?>" alt="."></a>
                                                        </div>
                                                        <div class="count"><?= $authors['post_count'] ?></div>
                                                        <div class="content">
                                                            <p class="entry-title">
                                                                <a href="<?= $authLink ?>>">
                                                                    <?= $authorName; ?>
                                                                </a>
                                                            </p>
                                                            <small class="post-date">
                                                                <?= $authorDesc; ?>
                                                            </small>
                                                        </div>
                                                    </li>
                                                    <?php 
                                                            endforeach; 
                                                        }
                                                        else
                                                        {
                                                            echo "<p>Authors not avaiable</p>";
                                                        }
                                                    ?>
                                                </ul>
                                                </div>
                                            </div>
                                            <!--/-->

                                            <!--widget-ads-->
                                            <div class="widget">
                                                <div class="section-title">
                                                    <h5>ads</h5>
                                                </div>
                                                <div class="widget-ads" id="ads1">
                                                    <a href="#">
                                                        <img src="assets/img/ads/ads3.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>