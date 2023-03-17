<?php
    //page required css

    $style_refrences = '
        <link rel="stylesheet" href="assets/summernote/summernote-lite.css">
        <link rel="stylesheet" type="text/css" href="assets/dropzone/dropzone.css">
        <style>
            .note-editable {
                background-color: #fff;
            }
            #post_contents{
                background-color: #ffffff;
            }
        </style>
    ';

    include 'includes/header.php';
    include 'includes/navbar.php';

    // Check if the user is already logged in, if yes then redirect him to dasboard page
    if ($loggedin == false) {
        echo "<script>window.location.replace('login.php');</script>";
    }

    $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);

    $data = json_decode($sharedComponents->getUserDetails($conn, $userId), 1);

    if (isset($data["response"])) 
    {
        if ($data["response"] == true) 
        {
            $details = $data["data"];
        }
    }

    // Gets user created post
    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE id_user = $userId  ORDER BY `post_id` DESC");
    $stmt->execute();
    $userCreatedPost = $stmt->fetchAll();
?>
        <main class="main">
            <!--post-default-->
            <section class="mt-60  mb-30 h-39">
                <div class="container-fluid">
                    <div class="row">
                        <div class=" card-primary card-outline">
                        
                            <div class="">
                                <h3 class="text-center">User Dashboard</h3>
                                <p class="text-center">
                                    <?php
                                    $hour = date('H');
                                    $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
                                    echo "Good " . $dayTerm . " ". $details["username"];
                                    ?>!
                                    </p>
                                <nav class="">
                                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="color:gray"> 
                                            Manage Blog Posts
                                        </button>

                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" style="color:gray">
                                            Profile & Setttings
                                        </button>

                                        <button class="nav-link" id="nav-savedposts-tab" data-bs-toggle="tab" data-bs-target="#nav-savedposts" type="button" role="tab" aria-controls="nav-savedposts" aria-selected="false" style="color:gray">
                                            Saved Posts
                                        </button>

                                        <a class="nav-link" data-bs-toggle="modal" href="#exampleModalToggle" role="button" style="color:gray">Ads Managements</a>

                                        <a class="nav-link" href="logout.php" style="color:gray">Logout</a>
                                    </div>
                                </nav>
                                
                                <div class="tab-content p-3" id="nav-tabContent">
                                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                <a href="javascript:void(0); " class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="background-color: whitesmoke; color:black;">
                                                    Create a Post
                                                </a>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <form  class="widget-form contact_form row" id="createPost-form" autocomplete="off">
                                                            <p>The Catgory Box is a datalist, if the post category is not available, type in a category related to the post, the category will need verting before the post is verified</p>

                                                            <div class="col-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label for="post_title" class="col-form-label">Post Title</label>
                                                                    <input class="form-control" type="text" placeholder="Enter Post Title" name="post_title" id="post_title" autocomplete="off"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 col-md-6">
                                                                <div class="form-group">
                                                                <label for="post_category" class="col-form-label">Post Category</label>
                                                                <input class="form-control" type="text" name="post_category" list="category" value="" placeholder="Select Category" id="post_category" autocomplete="off"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="post_title" class="col-form-label">Post Country</label>
                                                                    <input class="form-control" type="text" placeholder="Enter Post Country" name="post_country" id="post_country" />
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="post_contents">Post Content</label>
                                                                    <!-- <textarea class="form-control" name="post_contents"  required id="post_contents" rows="3" required></textarea> -->
                                                                    <div style="background-color: white;">
                                                                        <textarea id="post_contents" name="post_contents" style="padding: 10px;">
                                                                            <p>
                                                                                 Type here...
                                                                            </p>
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                                
                                                            <div class="">
                                                                <p>Upload Post Thumbnail ↓</p>
                                                                <div action="classes/components/userComponents.php?dataPurpose=createPost" class="dropzone" id="dropzoneForm1">
                                                                </div>
                                                                <button type="button" class="mt-3 btn btn-outline-danger" id="cancelFileUploadAll1">Clear</button>
                                                            </div>
                                                        
                                                            <div class="text-center justify-content-center">
                                                                <button type="submit" class="btn-custom">Submit Post</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" p-3">
                                            <div class="widget-comments">
                                                <div class="title">
                                                    
                                                    <p>Your Posts</p>
                                                    
                                                </div>

                                                <div class="dyn-height" style="max-height:600px;overflow-y:auto;" id="allPost">

                                                <?php 
                                                    $countnum = 0;
                                                    foreach ($userCreatedPost as $post) : 
                                                    $postId = $sharedComponents->protect($post['post_id']);
                                                    $countnum++;

                                                    //displays the contents as HTML
                                                    $string = htmlspecialchars_decode($post['post_contents']);

                                                    // Strip HTML tags and leave only texts
                                                    $stripped_string = strip_tags($string);

                                                    // Count words
                                                    $num_words = str_word_count($stripped_string);

                                                    $max_words = 50; // Maximum number of words
                                                    $ellipsis = "...  <a style='font-weight:bold;' href='post.php?dt=".$post['post_title']."&id=".$postId."'> Read more</a>"; // Text to indicate truncated string

                                                    if ($num_words > $max_words) {
                                                        // Find position of the nth word boundary
                                                        $pos = $max_words;
                                                        for ($i = 0; $i < $max_words; $i++) {
                                                            $pos = strpos($stripped_string, ' ', $pos + 1);
                                                            if ($pos === false) {
                                                            break;
                                                            }
                                                        }
                                                        // Truncate string and add ellipsis
                                                        $truncated_string = substr($stripped_string, 0, $pos) . $ellipsis;
                                                    } 
                                                    else {
                                                        $truncated_string = strip_tags($string);
                                                    }

                                                ?>
                                                    <ul class="widget-comments-items">
                                                        <li class="comment-item">
                                                            <label for="" > <?= $countnum ?></label>
                                                                <img src="admin/fileUploads/images/<?= $post['post_thumbnail'] ?>" alt="">
                                                            <div class="content">
                                                        
                                                                <ul class="info list-inline">
                                                                    <li>
                                                                        <a href="category.php?dt=<?=$post['category_name']?>&catid=<?= $post['category_id'] ?>">
                                                                            <?= $post['category_name'] ?>
                                                                        </a>
                                                                    </li>
                                                                    <li class="dot"></li>
                                                                    <li>
                                                                        <?= date_format(date_create($post['post_creation_time']), "F d, Y - h:ia") ?>
                                                                    </li>
                                                                </ul>
                                                                <b>
                                                                    <a href="post.php?dt=<?=$post['post_title']?>&id=<?= $postId ?>"><?= $post['post_title']; ?></a>
                                                                </b>
                                                                <p class="mt-2">
                                                                    <?= $truncated_string; ?>
                                                                </p>
                                                                <div>
                                                                    <a href="javascript:void(0);" onclick="editPost('<?= $postId ?>')" class="btn btn-outline-primary">
                                                                        Edit
                                                                    </a>
                                                                    <a href="javascript:void(0);" onclick="deletePost('<?= $postId ?>')" class="btn btn-outline-danger">
                                                                        Delete
                                                                    </a>
                                                                    <a href="javascript:void(0);" onclick="publishPost('<?= $postId ?>')" class="btn btn-outline-secondary">
                                                                        Publish
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                <?php endforeach;  ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                
                                <div class="tab-pane fade p-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                     <div class="">
                                        <form class="widget-form contact_form row" id="profile-form" autocomplete="off" onsubmit="return false">
                                            <h6>Profile & Settings</h6>
                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Username</label>
                                                    <input class="form-control" type="text" placeholder="" name="username" id="username" value="<?= $details["username"] ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Email</label>
                                                    <input class="form-control" type="text" placeholder="" name="email" id="email" value="<?= $details["email"] ?>"/>
                                                </div>
                                            </div>
                                            
                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="gender" class="col-form-label">Gender</label>
                                                    <input class="form-control" type="text" placeholder="" name="gender" id="gender" value="<?= $details["gender"] ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="country" class="col-form-label">Country</label>
                                                    <input class="form-control" type="text" placeholder="" name="user_country" id="user_country" value="<?= $details["user_country"] ?>"/>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Password</label>
                                                    <input class="form-control" type="password" placeholder="Enter Password " name="password" id="password" />
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Confrim Password</label>
                                                    <input class="form-control" type="password" placeholder="Confirm Password " name="confrimPassword" id="confrimPassword" />
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <p>Upload Profile Picture ↓</p>
                                                <div action="classes/components/userComponents.php?dataPurpose=updateProfile" class="dropzone" id="dropzoneForm2">
                                                </div>
                                                <button type="button" class="mt-3 btn btn-outline-danger" id="cancelFileUploadAll2">Clear</button>
                                            </div>

                                            <div class="form-group">
                                                <div class=" text-center justify-content-center">
                                                    <button type="button" onclick="profileForm()" class="btn-custom">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                     </div>
                                </div>
                                
                                <div class="tab-pane fade p-3" id="nav-savedposts" role="tabpanel" aria-labelledby="nav-savedposts-tab">
                                     <div class="">
                                        <div class="widget-comments">
                                            <h6 class="mb-3">Saved Posts</h6>
                                            <div class="dyn-height">
                                                <!--Post-1-->
                                                <div class="col-xl-4 col-lg-6 col-md-6">
                                                    <div class="post-card">
                                                        <div class="post-card-imagea">
                                                            <a href="post.php">
                                                                <img src="assets/img/blog/25.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="post-card-content">
                                                            <div class="entry-cat mt-2">
                                                                <a href="blog-grid.php" class="categorie"> fashion</a>
                                                            </div>
                                                            
                                                            <h5 class="entry-title">
                                                                <a href="post.php">5 Effective Ways I’m Finding Focus in a Busy Season of Life</a>
                                                            </h5>

                                                            
                                                            <ul class="entry-meta list-inline">
                                                                
                                                                <li class="post-author-img"><a href="author.php"> <img src="assets/img/author/1.jpg" alt=""></a></li>
                                                                <li class="post-author"><a href="author.php">David Smith</a> </li>
                                                                <li class="post-date"> <span class="dot"></span>  <a href="javascript:void(0);" onclick="" title=" Remove from Saved Posts"> Remove</a></li>
                                                                
                                                            </ul>
                                                            <li class="post-date p-2" style="font-size:14px">  February 10, 2022</li>
                                                        </div>
                                                    </div>
                                                    <!--/-->
                                                </div>
                                                
                                            </div>
                                        </div>
                                     </div>   
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section><!--/-->

        </main>

        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Ads Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class=" row text-center justify-content-center">
                    <div class="col-md-6">
                        <a href="adsmanagements.php" class="btn btn-outline-default">
                            View Exsiting Ad(s) stats 
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-default" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal" data-backdrop="static" data-keyboard="false">
                            Create new Ad
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Create new Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form class="sign-form widget-form contact_form " id="createAd-form">
                            <div class="form-group">
                                <label for="ad_name" class="pl-2">Ad Name</label>
                                <input type="text" class="form-control" placeholder="" name="ad_name" value="" id="ad_name">
                            </div>
                            <div class="form-group">
                                <label for="ad_description" class="pl-2">Ad Description</label>
                                <textarea class="form-control" placeholder="" name="ad_description" id="ad_description" value=""></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ad_url" class="pl-2">Ad URL</label>
                                <input type="text" class="form-control" placeholder="" name="ad_url" value="" id="ad_url">
                            </div>
                            <div class="form-group">
                                <label for="ad_duration" class="pl-2">Duration of Ad</label>
                                <input type="text" class="form-control" name="ad_duration" id="ad_duration">
                            </div>
                            <div class="form-group">
                                <label for="ad_category" class="pl-2">Ad Category</label>
                                <select name="ad_category" id="ad_category" class="form-control">
                                    <option value=""></option>
                                    <option value="">Bussiness</option>
                                    <option value="">Health</option>
                                    <option value="">Food</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ad_target_Country" class="pl-2">Ad Target Country</label>
                                <select name="ad_target_Country" id="ad_target_Country" class="form-control">
                                    <option value=""></option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="Ghana">Ghana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ad_target_gender" class="pl-2">Ad Target Gender</label>
                                <select name="ad_target_gender" id="ad_target_gender" class="form-control">
                                    <option value=""></option>
                                    <option value="Male">Males</option>
                                    <option value="Female">Females</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ad_thumbnail" class="pl-2">Upload Ad Thumbnail ↓</label>
                                <div action="classes/components/userComponents.php?dataPurpose=createAd" class="dropzone" id="dropzoneForm3">
                                </div>
                                <button type="button" class="mt-3 btn btn-outline-danger" id="cancelFileUploadAll3">Clear</button>
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agreed">
                                    <label class="custom-control-label" for="agreed">Agree to the<a href="adstermandconditions.php" class="btn-link">terms of our Ad Service</a> </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn-custom">Next</button>
                </div>
                </div>
            </div>
        </div>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
    <!-- Summernote -->
    <script src="assets/summernote/summernote-lite.js"></script>
   
    <!-- dropzonejs -->
    <script src="assets/dropzone/dropzone.js" type="text/javascript"></script>

    <!-- date-range-picker -->
    <script src="admin/assets/moment/moment.min.js"></script>
    <script src="admin/assets/daterangepicker/daterangepicker.js"></script>

    <!-- Page specific script -->
    <script>
        //Date range picker
        $('#ad_duration').daterangepicker()
           
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )
    </script>

    <script>
        function autocomplete(inp, arr) 
        {
          /*the autocomplete function takes two arguments,
          the text field element and an array of possible autocompleted values:*/
          var currentFocus;
          /*execute a function when someone writes in the text field:*/
          inp.addEventListener("input", function(e) {
              var a, b, i, val = this.value;
              /*close any already open lists of autocompleted values*/
              closeAllLists();
              if (!val) { return false;}
              currentFocus = -1;
              /*create a DIV element that will contain the items (values):*/
              a = document.createElement("DIV");
              a.setAttribute("id", this.id + "autocomplete-list");
              a.setAttribute("class", "autocomplete-items");
              /*append the DIV element as a child of the autocomplete container:*/
              this.parentNode.appendChild(a);
              /*for each item in the array...*/
              for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                  /*create a DIV element for each matching element:*/
                  b = document.createElement("DIV");
                  /*make the matching letters bold:*/
                  b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                  b.innerHTML += arr[i].substr(val.length);
                  /*insert a input field that will hold the current array item's value:*/
                  b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                  /*execute a function when someone clicks on the item value (DIV element):*/
                  b.addEventListener("click", function(e) {
                      /*insert the value for the autocomplete text field:*/
                      inp.value = this.getElementsByTagName("input")[0].value;
                      /*close the list of autocompleted values,
                      (or any other open lists of autocompleted values:*/
                      closeAllLists();
                  });
                  a.appendChild(b);
                }
              }
          });

          /*execute a function presses a key on the keyboard:*/
          inp.addEventListener("keydown", function(e) {
              var x = document.getElementById(this.id + "autocomplete-list");
              if (x) x = x.getElementsByTagName("div");
              if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
              } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
              } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                  /*and simulate a click on the "active" item:*/
                  if (x) x[currentFocus].click();
                }
              }
          });
          function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
          }
          function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
              x[i].classList.remove("autocomplete-active");
            }
          }
          function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
              if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
              }
            }
          }
          /*execute a function when someone clicks in the document:*/
          document.addEventListener("click", function (e) {
              closeAllLists(e.target);
          });
        }
        
        /*An array containing all the country names in the world:*/
        var postCategories = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
        
        /*initiate the autocomplete function on the "myInput" element, and pass along the postcategories array as possible autocomplete values:*/

        
        function loadFunctions()
        {
            autocomplete(document.getElementById("post_category"), postCategories);

            $('#exampleModalToggle').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#exampleModalToggle2').modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        window.onload = loadFunctions;

        // Summernote
        $('#post_contents').summernote({
            airMode: false,              // removes the tool bar, but when text is highlited it shows
            height: 200,                 // set editor height
            //minHeight: null,             // set minimum height of editor
            //maxHeight: null,             // set maximum height of editor
            focus: true,                  // set focus to editable area after initializing summernote
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            hint: {
                words: ['Macae', 'Blog', 'Blunt Technology', 'Science'],
                match: /\b(\w{1,})$/,
                search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
                }
            }
        });
        
    </script>
    