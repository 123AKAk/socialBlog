<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
?>
        <main class="main">
            <!--post-default-->
            <section class="mt-60  mb-30 h-39">
                <div class="container-fluid">
                    <div class="row">
                        <div class="card-primary card-outline">
                        
                            <div class="p-3 shadow">
                                <h2 class="text-center">Ads Management</h2>
                               
                            </div>
                            <div class="container">
                              <a class="nav-link" data-bs-toggle="modal" href="#exampleModalToggle" role="button" style="color:gray">Ads Managements</a>
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
      <!-- ad modal -->
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
?>
    <!-- Text Editor Script -->
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <!-- dropzonejs -->
    <script src="admin/assets/css/dropzone/min/dropzone.min.js"></script>

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
        
    </script>

<?php
    include 'includes/scripts.php';
?>
    
    