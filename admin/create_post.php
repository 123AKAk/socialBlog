<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    $stmt = $conn->prepare("SELECT id, category_name FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll();

    // $stmt = $conn->prepare("SELECT id, admin_name FROM author");
    // $stmt->execute();
    // $authors = $stmt->fetchAll();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title">Create Post</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="./"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Create Post</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col">
                            <div class="card">
                            
                                <div class="col">
                                    <!-- feedback message -->
                                    <?php include 'includes/feedbackmsg.php'; ?>
                                </div>

                                <div class="card-body">
                                    <form class="separate-form" action="php/insert.php?type=post" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="postTitle" class="col-form-label">Post Title</label>
                                                        <input class="form-control" type="text" placeholder="Enter Post Title" name="postTitle" id="postTitle" >
                                                    </div>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <div class="form-group">
                                                    <label for="category" class="col-form-label">Post Category</label>
                                                    <input class="form-control" type="text" name="category" list="category" value="" placeholder="Select Category">
                                                        <datalist id="category">
                                                            <?php foreach ($categories as $category) : ?>
                                                                <option value="<?= $category['category_name'] ?>"><?= $category['id'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </datalist>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="postContents">Post Content</label>
                                                        <textarea class="form-control" name="postContents"  required id="postContents" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
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
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button" onclick="goback()">Back</button>
                                                <input class="btn btn-primary" type="submit" name="submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
<!-- 
                        <div class="my-dropzone">asasa</div> -->


                    </div>

                </div>
<?php
    include 'includes/footer.php';
?>
    <!-- Text Editor Script -->
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <!-- dropzonejs -->
    <script src="assets/css/dropzone/min/dropzone.min.js"></script>

    <script>
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
<?php
    include 'includes/scripts.php';
?>