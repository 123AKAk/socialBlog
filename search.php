<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    if(!isset($_GET["keywrd"]))
    {
        header("location: ./");
    }

    $keywrd = $_GET["keywrd"];
    if($keywrd == "")
    {
        echo "<script>window.history.back()</script>";
    }

    $stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN category ON id_categorie=category_id INNER JOIN author ON author_id=id_author WHERE article_status=1 AND article_title LIKE :keyword OR category_name LIKE :keyword OR author_fullname LIKE :keyword");
    $stmt->bindValue(':keyword', '%' . $keywrd . '%', PDO::PARAM_STR);
    $stmt->execute();
    $searchdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $number_of_rows = $stmt->rowCount();

    session_start();

    

?>
        <main class="main">
            <!--category-->
            <section class="categorie-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="categorie-title"> 
                                <small>
                                    <a href="./">Home</a>
                                    <i class="fas fa-angle-right"></i> Search
                                </small>
                                <h3>Search Keyword : <span> Food</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--blog-grid-->
            <section class="blog-grid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 mt-30 side-content">
                            <div class="theiaStickySidebar">
                                <div class="row">
                                    <!--Post-1-->
                                    <div class=" col-lg-6 col-md-6">
                                        <div class="post-card">
                                            <div class="post-card-image">
                                                <a href="post.php">
                                                    <img src="assets/img/blog/12.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="post-card-content">
                                                <div class="entry-cat">
                                                    <a href="blog-grid.php" class="categorie"> fashion</a>
                                                </div>
            
                                                <h5 class="entry-title">
                                                    <a href="post.php">5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                                                </h5>
            
                                                <div class="post-exerpt">
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit quam atque ipsa laborum sunt distinctio... </p>
                                                </div>
            
                                                <ul class="entry-meta list-inline">
                                                    <li class="post-author-img"><a href="author.php"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                    <li class="post-author"><a href="author.php">David Smith</a> </li>
                                                    <li class="post-date"> <span class="dot"></span>  February 10, 2022</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/-->
                                    
                                </div>
                            </div>
                        </div>
                       

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
