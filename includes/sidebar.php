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
                                                <ul class="widget-latest-posts">
                    
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
                                                            <a href="post.php"> <img src="<?= $postImage; ?>" alt="..."></a>
                                                        </div>
                                                        <div class="count"><?= $views ?></div>
                                                        <div class="content">
                                                            <p class="entry-title">
                                                                <a href="post.php?dt=<?= $post['post_title'] ?>&id=<?= $postId ?>">
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
                                                    <h5>Tags</h5>
                                                </div>
                                                <div class="widget-tags">
                                                    <ul class="list-inline">
                                                        
                                                        <li>
                                                            <a href="blog-grid.php">Tech</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <!--/-->

                                            <!--widget-ads-->
                                            <div class="widget">
                                                <div class="section-title">
                                                    <h5>ads</h5>
                                                </div>
                                                <div class="widget-ads">
                                                    <a href="#">
                                                        <img src="assets/img/ads/ads3.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>