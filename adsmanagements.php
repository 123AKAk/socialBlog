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
    include 'includes/scripts.php';
?>
  <!-- Summernote -->
  <script src="assets/summernote/summernote-lite.js"></script>
  <script src="assets/summernote/plugin/uploadcare.js"></script>

  <!-- dropzonejs -->
  <script src="assets/dropzone/dropzone.js" type="text/javascript"></script>

  <!-- date-range-picker -->
  <script src="admin/assets/moment/moment.min.js"></script>
  <script src="admin/assets/daterangepicker/daterangepicker.js"></script>
  <script>
        //Date range picker
        $('#ad_duration').daterangepicker()

        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        $("#dropzoneForm3").dropzone({
          autoProcessQueue: false,
          acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
          dictDefaultMessage: 'Drop Picture files here!',
          paramName: "file",
          maxFilesize: 2, // MB
          addRemoveLinks: true,
          init: function() {
              myDropzone3 = this;
              this.on("complete", function() {
                  if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                      var _this = this;
                      _this.removeAllFiles();
                  }
                  list_image();
              });
              this.on('addedfile', function(file) {
                  if (this.files.length > 3) {
                      this.removeFile(this.files[0]);
                      alertify.error("You cannot upload more than three files");
                  }
                  else
                  {
                      fileNameUploaded3 = file.name;
                  }
              });
              this.on("sending", function(data, xhr, formData) {
                  //send all the form data along with the files:
                  formData.append("ad_name", document.getElementById("ad_name").value);
                  formData.append("ad_description", document.getElementById("ad_description").value);
                  formData.append("ad_url", document.getElementById("ad_url").value);
                  formData.append("ad_target_Country", document.getElementById("ad_target_Country").value);
                  formData.append("ad_duration", document.getElementById("ad_duration").value);
                  formData.append("ad_category", document.getElementById("ad_category").value);
                  formData.append("ad_target_gender", document.getElementById("ad_target_gender").value);
              });
          },
          success: function(file, response) {
              result = JSON.parse(response);
              if (result.response == true) {
                  // console.log(result);
                  alertify.success(result.message);
              } else {
                  alertify.error(result.message);
              }
          }
        });

        //file name to be uploaded
        let fileNameUploaded3 = "";
        //createAd-form
        $('#createAd-form').submit(function(event) {

            var ad_name = $('#ad_name').val();
            var ad_description = $("#ad_description").val();
            var ad_target_Country = $("#ad_target_Country").val();
            var ad_duration = $("#ad_duration").val();
            var ad_category = $("#ad_category").val();
            var ad_target_gender = $("#ad_target_gender").val();
            var agreed = $("#agreed").val();

            //compare date
            const parts = ad_duration.split(" - ");
            const date1 = new Date(parts[0]);
            const date2 = new Date(parts[1]);

            if (ad_name == "" || ad_description == "" || ad_target_Country == "" || ad_duration == "" || ad_category == "" || ad_target_gender == "") {
                alertify.error("Fill all Feilds");
            } else if (date1 == date2) {
                alertify.error("Duration cannot be the same Date");
            } else {
                if ($("#agreed").is(":checked")) {
                    //uploads file to server
                    alertify.message("Ad thumbnail upload started");
                    myDropzone3.processQueue();
                } else {
                    alertify.error("Accpet Terms of Ad Service to continue");
                }
            }

            fileNameUploaded3 = "";
            event.preventDefault();
        });

        /*An array containing all the categories:*/
        var postCategories = [];
        //gets category names and push to js array
        <?php
        foreach ($categorieslist as $category) :
        ?>
            postCategories.push("<?= $category['category_name'] ?>");
        <?php
        endforeach;
        ?>
        /*initiate the autocomplete function on the "myInput" element, and pass along the postcategories array as possible autocomplete values:*/
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
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
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }


        function loadFunctions() {
          autocomplete(document.getElementById("post_category"), postCategories);

          $('#exampleModalToggle').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#exampleModalToggle2').modal({
              backdrop: 'static',
              keyboard: false
          });

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4',
              placeholder: 'Select your Country'
          });

          var aselect = document.getElementById("post_country");
          for (let country of aarrCountry) {
              var aoptionN = document.createElement("option");
              aoptionN.text = country;
              aoptionN.value = country;
              aselect.appendChild(aoptionN);
          }
        }

        const anextText = "South Korea, South Sudan, Spain, Sri Lanka, Sudan, Suriname, Svalbard and Jan Mayen, Sweden, Switzerland, Syria, São Tomé and Príncipe, Taiwan, Tajikistan, Tanzania, Thailand, Timor-Leste, Togo, Tokelau, Tonga, Trinidad and Tobago, Tunisia, Turkey, Turkmenistan, Turks and Caicos Islands, Tuvalu, Uganda, Ukraine, United Arab Emirates, United Kingdom, United States, United States Minor Outlying Islands, United States Virgin Islands, Uruguay, Uzbekistan, Vanuatu, Vatican City, Venezuela, Vietnam, Wallis and Futuna, Western Sahara, Yemen, Zambia, Zimbabwe, Åland Islands";
  
        const atext = "Afghanistan, Albania, Algeria, American Samoa, Andorra, Angola, Anguilla, Antarctica, Antigua and Barbuda, Argentina, Armenia, Aruba, Australia, Austria, Azerbaijan, Bahamas, Bahrain, Bangladesh, Barbados, Belarus, Belgium, Belize, Benin, Bermuda, Bhutan, Bolivia, Bosnia and Herzegovina, Botswana, Bouvet Island, Brazil, British Indian Ocean Territory, British Virgin Islands, Brunei, Bulgaria, Burkina Faso, Burundi, Cambodia, Cameroon, Canada, Cape Verde, Caribbean Netherlands, Cayman Islands, Central African Republic, Chad, Chile, China, Christmas Island, Cocos (Keeling) Islands, Colombia, Comoros, Cook Islands, Costa Rica, Croatia, Cuba, Curaçao, Cyprus, Czechia, DR Congo, Denmark, Djibouti, Dominica, Dominican Republic, Ecuador, Egypt, El Salvador, Equatorial Guinea, Eritrea, Estonia, Eswatini, Ethiopia, Falkland Islands, Faroe Islands, Fiji, Finland, France, French Guiana, French Polynesia, French Southern and Antarctic Lands, Gabon, Gambia, Georgia, Germany, Ghana, Gibraltar, Greece, Greenland, Grenada, Guadeloupe, Guam, Guatemala, Guernsey, Guinea, Guinea-Bissau, Guyana, Haiti, Heard Island and McDonald Islands, Honduras, Hong Kong, Hungary, Iceland, India, Indonesia, Iran, Iraq, Ireland, Isle of Man, Israel, Italy, Ivory Coast, Jamaica, Japan, Jersey, Jordan, Kazakhstan, Kenya, Kiribati, Kosovo, Kuwait, Kyrgyzstan, Laos, Latvia, Lebanon, Lesotho, Liberia, Libya, Liechtenstein, Lithuania, Luxembourg, Macau, Madagascar, Malawi, Malaysia, Maldives, Mali, Malta, Marshall Islands, Martinique, Mauritania, Mauritius, Mayotte, Mexico, Micronesia, Moldova, Monaco, Mongolia, Montenegro, Montserrat, Morocco, Mozambique, Myanmar, Namibia, Nauru, Nepal, Netherlands, New Caledonia, New Zealand, Nicaragua, Niger, Nigeria, Niue, Norfolk Island, North Korea, North Macedonia, Northern Mariana Islands, Norway, Oman, Pakistan, Palau, Palestine, Panama, Papua New Guinea, Paraguay, Peru, Philippines, Pitcairn Islands, Poland, Portugal, Puerto Rico, Qatar, Republic of the Congo, Romania, Russia, Rwanda, Réunion, Saint Barthélemy, Saint Helena, Ascension and Tristan da Cunha, Saint Kitts and Nevis, Saint Lucia, Saint Martin, Saint Pierre and Miquelon, Saint Vincent and the Grenadines, Samoa, San Marino, Saudi Arabia, Senegal, Serbia, Seychelles, Sierra Leone, Singapore, Sint Maarten, Slovakia, Slovenia, Solomon Islands, Somalia, South Africa, South Georgia,"+anextText;
        const aarrCountry = atext.split(",");

  </script>
    
    