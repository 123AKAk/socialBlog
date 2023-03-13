<?php
    include 'includes/header.php';
    include 'includes/navbar.php';

    // Check if the user is already logged in, if yes then redirect him to dasboard page
    if ($loggedin == false) {
        echo "<script>window.location.replace('dashboard.php');</script>";
    }

     $data = json_decode($sharedComponents->getUserDetails($conn, $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"])), 1);

    if (isset($data["response"])) 
    {
        if ($data["response"] == true) 
        {
            $details = $data["data"];
        }
    }
?>
        <main class="main">
            <!--post-default-->
            <section class="mt-60  mb-30 h-39">
                <div class="container-fluid">
                    <div class="row">
                        <div class=" card-primary card-outline">
                        
                            <div class="">
                                <h3 class="text-center">User Dashboard</h3>
                                <p class="text-center">Good Evening, <?= $details["username"]; ?>!</p>
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
                                                        <form action="" class="widget-form contact_form row" method="POST" id="main_contact_form" autocomplete="off">
                                                            <p>The Catgory Box is a datalist, if the post category is not available, type in a category related to the post, the category will need verting before the post is verified</p>
                                                            <div class="alert alert-success contact_msg" style="display: none" role="alert">
                                                                Your message was sent successfully.
                                                            </div>

                                                            <div class="col-6 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="postTitle" class="col-form-label">Post Title</label>
                                                                    <input class="form-control" type="text" placeholder="Enter Post Title" name="postTitle" id="postTitle" />
                                                                </div>
                                                            </div>

                                                            <div class="col-6 col-md-6">
                                                                <div class="form-group">
                                                                <label for="category" class="col-form-label">Post Category</label>
                                                                <input class="form-control" type="text" name="category" list="category" value="" placeholder="Select Category" id="postCategory" autocomplete="off"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="postContents">Post Content</label>
                                                                    <textarea class="form-control" name="postContents"  required id="postContents" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                                
                                                            <div class="">
                                                                <div class="">
                                                                <div id="actions" class="col-12">
                                                                    <div class="col-md-6">
                                                                        <div class="btn-group w-100">
                                                                        <span class="btn btn-success col fileinput-button">
                                                                            <i class="fas fa-plus"></i>
                                                                            <span>Add files</span>
                                                                        </span>
                                                                        <button type="submit" class="btn btn-primary col start">
                                                                            <i class="fas fa-upload"></i>
                                                                            <span>Start upload</span>
                                                                        </button>
                                                                        <button type="reset" class="btn btn-warning col cancel">
                                                                            <i class="fas fa-times-circle"></i>
                                                                            <span>Cancel upload</span>
                                                                        </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 d-flex align-items-center">
                                                                        <div class="fileupload-process w-100">
                                                                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="table table-striped files" id="previews">
                                                                <div id="template" class="row mt-2">
                                                                    <div class="col-auto">
                                                                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                                                    </div>
                                                                    <div class="col d-flex align-items-center">
                                                                        <p class="mb-0">
                                                                        <span class="lead" data-dz-name></span>
                                                                        (<span data-dz-size></span>)
                                                                        </p>
                                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                                    </div>
                                                                    <div class="col-4 d-flex align-items-center">
                                                                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 d-flex align-items-center">
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-primary start">
                                                                        <i class="fas fa-upload"></i>
                                                                        <span>Start</span>
                                                                        </button>
                                                                        <button data-dz-remove class="btn btn-warning cancel">
                                                                        <i class="fas fa-times-circle"></i>
                                                                        <span>Cancel</span>
                                                                        </button>
                                                                        <button data-dz-remove class="btn btn-danger delete">
                                                                        <i class="fas fa-trash"></i>
                                                                        <span>Delete</span>
                                                                        </button>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                </div>
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
                                                    
                                                    <p>All Posts</p>
                                                    
                                                </div>

                                                <div class="dyn-height" style="max-height:600px;overflow-y:auto;">
                                                    <ul class="widget-comments-items">
                                                        <li class="comment-item">
                                                            <label for="" > <b>1</b></label>
                                                            <img src="assets/img/user/2.jpg" alt="">
                                                            <div class="content">
                                                        
                                                                <ul class="info list-inline">
                                                                    <li>Technology</li>
                                                                    <li class="dot"></li>
                                                                    <li> January 15, 2021</li>
                                                                </ul>
                                                
                                                                <b><p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus at doloremque adipisci eum placeat
                                                                    quod non fugiat aliquid sit similique!
                                                                </p></b>
                                                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus at doloremque adipisci eum placeat
                                                                </p>
                    
                                                                <div>
                                                                    <a href="#" class="btn btn-outline-primary">
                                                                        Edit
                                                                    </a>
                                                                    
                                                                    <a href="#" class="btn btn-outline-danger">
                                                                        Delete
                                                                    </a>
                                                                    <a href="#" class="btn btn-outline-secondary">
                                                                    Publish
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul class="widget-comments-items">
                                                        <li class="comment-item">
                                                            <label for="" > <b>2</b></label>
                                                            <img class="comimg" src="assets/img/user/2.jpg" alt="">
                                                            <div class="content">
                                                        
                                                                <ul class="info list-inline">
                                                                    <li>Technology</li>
                                                                    <li class="dot"></li>
                                                                    <li> January 15, 2021</li>
                                                                </ul>
                                                
                                                                <b><p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus at doloremque adipisci eum placeat
                                                                    quod non fugiat aliquid sit similique!
                                                                </p></b>
                                                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus at doloremque adipisci eum placeat
                                                                </p>
                    
                                                                <div>
                                                                    <a href="#" class="btn btn-outline-primary">
                                                                        Edit
                                                                    </a>
                                                                    
                                                                    <a href="#" class="btn btn-outline-danger">
                                                                        Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade p-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                     <div class="">
                                        <form class="widget-form contact_form row" method="POST" id="profile-form" autocomplete="off">
                                            <h6>Profile & Settings</h6>
                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Username</label>
                                                    <input class="form-control" type="text" placeholder="Enter Username" name="username" id="username" />
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Email</label>
                                                    <input class="form-control" type="text" placeholder="Enter Email " name="email" id="email" />
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Password</label>
                                                    <input class="form-control" type="text" placeholder="Enter Password " name="password" id="password" />
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="postTitle" class="col-form-label">Confrim Password</label>
                                                    <input class="form-control" type="text" placeholder="Confirm Password " name="confrimPassword" id="confrimPassword" />
                                                </div>
                                            </div>
                                                
                                            <div class="col">
                                                <div class="form-group">
                                                    <button type="submit" class="btn-custom">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                     </div>
                                </div>
                                
                                <div class="tab-pane fade p-3" id="nav-savedposts" role="tabpanel" aria-labelledby="nav-savedposts-tab">
                                     <div class="">
                                        <div class="widget-comments">
                                            <div class="title">
                                                <p>Saved Posts</p>    
                                            </div>
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
                        <form  class="sign-form widget-form contact_form " method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Ad Name" name="adname" value="">
                            </div>
                            <div class="form-group">
                                <label for="duration" class="pl-2">Duration of Ad</label>
                                <input type="text" class="form-control" id="duration">
                            </div>
                            <div class="form-group">
                                <label for="addescription" class="pl-2">Ad Description</label>
                                <textarea class="form-control" placeholder="" name="addescription" id="addescription" value=""></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category" class="pl-2">Ad Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value=""></option>
                                    <option value="">Bussiness</option>
                                    <option value="">Health</option>
                                    <option value="">Food</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="country" class="pl-2">Ad Target Country</label>
                                <select name="country" id="country" class="form-control">
                                    <option value=""></option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="Ghana">Ghana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="pl-2">Ad Target Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value=""></option>
                                    <option value="Male">Males</option>
                                    <option value="Female">Females</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="duration" class="pl-2">Ad Thumbnail</label>
                                <input type="file" class="form-control" name="adthumbnail">
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                    <label class="custom-control-label" for="rememberMe">Agree to the <a href="adstermandconditions.php" class="btn-link">terms of our Ad Service</a> </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn-custom">Next</button>
                </div>
                </div>
            </div>
        </div>

<?php
    include 'includes/footer.php';
?>
    <!-- Text Editor Script -->
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <!-- dropzonejs -->
    <script src="admin/assets/css/dropzone/min/dropzone.min.js"></script>
    <!-- date-range-picker -->
    <script src="admin/assets/moment/moment.min.js"></script>
    <script src="admin/assets/daterangepicker/daterangepicker.js"></script>
    <script>

        
        //Date range picker
        $('#duration').daterangepicker()
           
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



        CKEDITOR.replace('postContents');

        // Dropzone has been added as a global variable.
        //const dropzone = new Dropzone("div.my-dropzone", { url: "http://localhost:81/socialblog/admin/fileUploads/images" });

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, 
        { 
            // Make the whole body a dropzone
            url: "http://localhost:81/socialblog/admin/fileUploads/images", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) 
        {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) 
        {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) 
        {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) 
        {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() 
        {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() 
        {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
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
        var postcategories = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
        
        /*initiate the autocomplete function on the "myInput" element, and pass along the postcategories array as possible autocomplete values:*/

        autocomplete(document.getElementById("postCategory"), postcategories);

        window.onload = autocomplete;
   

        //prevent modal from closing from outside click
        $(document).ready(function () {
            $('#exampleModalToggle').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#exampleModalToggle2').modal({
                backdrop: 'static',
                keyboard: false
            })
        });
    </script>
<?php
    include 'includes/scripts.php';
?>
    