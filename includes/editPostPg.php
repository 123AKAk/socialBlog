
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel3">Edit Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="post-modal-content">
                <form class="widget-form contact_form row" id="aeditPost-form" autocomplete="off">
                    <p>The Catgory Box is a datalist, if the post category is not available, type in a category related to the post, the category will need verting before the post is verified</p>
                    <p>Files larger than 2mb will not be inserted</p>

                    <input type="hidden" value="" id="apost_id">

                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="apost_title" class="col-form-label">Post Title</label>
                            <input class="form-control" type="text" placeholder="Enter Post Title" name="apost_title" id="apost_title" value="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label for="apost_category" class="col-form-label">Post Category</label>
                            <input class="form-control" type="text" name="apost_category" list="category" value="" placeholder="Select Category" id="apost_category" value="" autocomplete="off" onclick="getCatList('apost_category')" />
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label for="apost_country" class="col-form-label">Post Country</label>
                            <input class="form-control" type="text" placeholder="Enter Post Country" name="apost_country" id="apost_country" value="" />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="apost_contents">Post Content</label>
                            <div style="background-color: white;">
                                <textarea id="apost_contents" class="post_contents" name="apost_contents" style="padding: 10px;">
                                    <p>
                                        Type here...
                                    </p>
                                </textarea>
                            </div>
                        </div>
                    </div>


                    <p>Upload Post Thumbnail ↓</p>
                    <div class="" id="dropzoneContainer">
                        <div action="classes/components/userComponents.php?dataPurpose=editPost" class="dropzone" id="dropzoneFormEdit">
                            <a href="javascript:void(0);" class="btn btn-default" id="showLoadEditFiles" onclick="loadEditFiles()">Show File(s)</a>
                        </div>
                    </div>

                    <div class="text-center justify-content-center mt-3">
                        <button type="button" onclick="saveEdits()" class="btn-custom">Save Changes</button>
                    </div>
                </form>

            </div>