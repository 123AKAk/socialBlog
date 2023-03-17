  window.onload = getLocation;

  // signup form
  $("#signup-form").submit(function (event) {
    reset();
    var username = $("#username").val();
    var email = $("#email").val();
    var country = $("#country").val();
    var gender = $("#gender").val();
    var password = $("#password").val();
    var confrimpassword = $("#confrimpassword").val();
    var agreed = $("#agreed").val();

    if (
      username == "" ||
      email == "" ||
      country == "" ||
      gender == "" ||
      password == "" ||
      confrimpassword == ""
    ) {
      alertify.error("Fill all Input Feilds");
    } else {
      if (ValidateEmail(email) == false) {
        alertify.error("Invalid Email, use a Valid Email");
      } else {
        if (password != confrimpassword) {
          alertify.error("Passwords are not the same");
        } else {
          if ($("#agreed").is(":checked")) {
            let formdata = new FormData();
            formdata.append("username", username);
            formdata.append("email", email);
            formdata.append("gender", gender);
            formdata.append("password", password);
            formdata.append("user_ip_address", "ipaddress");
            formdata.append("user_country", country);

            let loca = "classes/components/userComponents.php?dataPurpose=signup";
            fetch(loca, { method: "POST", body: formdata })
              .then((res) => res.json())
              .then((data) => {
                console.log(data);
                var result = (data);
                if (result.response == true) 
                {
                  alertify.success(result.message);
                  alertify.message("Redirecting...");
                  setTimeout(function () {
                    window.location.replace("login.php?loginMsg=1");
                  }, 3000);

                } else {
                  alertify.set({ delay: 15000 });
                  alertify.error(result.message);
                }
              });
          } else {
            alertify.error("Accpet Terms and Agreement to continue");
          }
        }
      }
    }

    event.preventDefault();
  });

  //login form
  $("#login-form").submit(function (event) 
  {
    reset();
    var email = $("#email").val();
    var password = $("#password").val();

    if(email == "" || password == "") 
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Fill all Input Feilds");
    }
    else 
    {
      let formdata = new FormData();
      formdata.append("email", email);
      formdata.append("password", password);

      let loca = "classes/components/userComponents.php?dataPurpose=login";
      fetch(loca, { method: "POST", body: formdata })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          var result = (data);
          if (result.response == true) 
          {
            alertify.success(result.message);
            alertify.log("Redirecting...");
            setTimeout(function () {
              window.location.replace("dashboard.php");
            }, 2000);

          } else {
            alertify.set({ delay: 11000 });
            alertify.error(result.message);
          }
        });
    }
    event.preventDefault();
  });

  //file name to be uploaded
  let fileNameUploaded1 = "";
  //createPost form
  $('#createPost-form').submit(function (event) {
    reset();

    var post_title = document.getElementById("post_title").value;
    var post_category = document.getElementById("post_category").value;
    var post_contents = $('#post_contents').summernote('code');
    var post_country = document.getElementById("post_country").value;

    if (post_title == "" || post_category == "" || post_contents == "" || post_country == "")
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Fill all Feilds");
    }
    else 
    {
      if(fileNameUploaded1 != "")
      {
        //uploads file to server
        //alertify.log("Thumbnail upload started");
        myDropzone1.processQueue();
      }
      else
      {
        alertify.error("Choose a thumbnail for the Post");
      }
    }

    //Destroy Summernote
    //$('#post_contents').summernote('destroy');

    var post_contentsVal = 'Type here...';
    $('#post_contents').summernote('code', post_contentsVal);

    fileNameUploaded1 = "";
    event.preventDefault();

  });

  //file name to be uploaded
  let fileNameUploaded2 = "";
  //profile-form
  function profileForm()
  {
    //event.preventDefault();
    reset();

    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var gender = document.getElementById("gender").value;
    var user_country = document.getElementById("user_country").value;
    var password = document.getElementById("password").value;
    var confrimPassword = document.getElementById("confrimPassword").value;

    if(username == "" || email == "" || gender == "" || user_country == "")
    {
    alertify.set('notifier','position', 'top-right');
    alertify.error("Fill all Feilds");
    }
    else  
    {
      if(password != "" && password != confrimPassword) 
      {
          alertify.error("The Passwords are not the same");
      }
      else if(fileNameUploaded2 == "")
      {
        // let formdata = new FormData();
        // //send all the form data along with the files:
        // formdata.append("username", username);
        // formdata.append("email", email);
        // formdata.append("gender", gender);
        // formdata.append("user_country", user_country);
        // formdata.append("password", password);
        
        // let loca = "classes/components/userComponents.php?dataPurpose=updateProfile";
        // fetch(loca, { method: "POST", body: formdata })
        //   .then((res) => res.json())
        //   .then((data) => {
        //     console.log(data);
        //     var result = data;
        //     if (result.response == true) 
        //     {
        //       alertify.success(result.message);
        //     } else {
        //       alertify.set({ delay: 15000 });
        //       alertify.error(result.message);
        //     }
        //   });
      }
      else
      {
        console.log("Profile Pic Present");
        //uploads file to server
        alertify.log("Profile picture upload started");
        myDropzone2.processQueue();
      }
    }
    fileNameUploaded2 = "";
  }

  //file name to be uploaded
  let fileNameUploaded3 = "";
  //createAd-form
  $('#createAd-form').submit(function (event) {
    reset();

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

    if (ad_name == "" || ad_description == "" || ad_target_Country == "" || ad_duration == "" || ad_category == "" || ad_target_gender  == "")
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Fill all Feilds");
    }
    else if(date1 == date2)
    {
      alertify.error("Duration cannot be the same Date");
    }
    else 
    {
      if ($("#agreed").is(":checked")) {
        //uploads file to server
        alertify.log("Ad thumbnail upload started");
        myDropzone3.processQueue();
      }
      else
      {
        alertify.error("Accpet Terms of Ad Service to continue");
      }
    }

    fileNameUploaded3 = "";
    event.preventDefault();
  });

   // forgotPassword-form
   $("#forgotPassword-form").submit(function (event) {
    reset();
    var email = $("#email").val();
    if (email == "") 
    {
      alertify.error("Enter Registered Email to continue");
    } 
    else 
    {  
      let formdata = new FormData();
      formdata.append("email", email);
      
      let loca = "classes/components/userComponents.php?dataPurpose=forgotPassword";
      fetch(loca, { method: "POST", body: formdata })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          var result = (data);
          if (result.response == true) 
          {
            alertify.success(result.message);
            alertify.message("Redirecting...");
            setTimeout(function () {
              window.location.replace("ureset.php?"+email);
            }, 3000);

          } else {
            alertify.set({ delay: 15000 });
            alertify.error(result.message);
          }
        });
        
    }

    event.preventDefault();
  });




  //
  //dropzone codes starts here
  //cancels file upload
  //clear dropzone for user create post
  var cancelFileUpload1 = document.querySelector('#cancelFileUploadAll1');
  cancelFileUpload1.addEventListener("click", function() {myDropzone1.removeAllFiles(); fileNameUploaded1 = "";});

  //clear dropzone for user profile
  var cancelFileUpload2 = document.querySelector('#cancelFileUploadAll2');
  cancelFileUpload2.addEventListener("click", function() {myDropzone2.removeAllFiles(); fileNameUploaded2 = "";});

  //clear dropzone for ads
  var cancelFileUpload3 = document.querySelector('#cancelFileUploadAll3');
  cancelFileUpload3.addEventListener("click", function() {myDropzone3.removeAllFiles(); fileNameUploaded3 = "";});

  $(document).ready(function(){
    //
    // dropzone for user create post
    Dropzone.options.dropzoneForm1 = {
    autoProcessQueue: false,
    acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
    init: function(){
      myDropzone1 = this;
      this.on("complete", function(){
        if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
        {
          var _this = this;
          _this.removeAllFiles();
        }
        list_image();
      });
      this.on('addedfile', function(file) {
        //keeping the file extension.
        // var ext = file.name.split('.').pop();
        // fileNameUploaded1 = "user-" + getCombinedDateTime() + '.' + ext; //changing the name of the file
        fileNameUploaded1 = file.name;
        if (this.files.length > 1) {
          this.removeFile(this.files[0]);
          alertify.error("You cannot upload more than one file");
        }
      });
      this.on("sending", function(data, xhr, formData) {
        //send all the form data along with the files:
        formData.append("post_title", document.getElementById("post_title").value);
        formData.append("post_category", document.getElementById("post_category").value);
        formData.append("post_contents", $('#post_contents').summernote('code'));
        formData.append("post_country", document.getElementById("post_country").value);

        //file.myCustomName =  + file.name;
        // this.options.renameFilename = function(file){
        //     let filename = "user-" + getCombinedDateTime();
        //     //keeping the file extension.
        //     var ext = file.split('.').pop();
        //     return file.name = filename + '.' + ext;
        // };
      });
    },
    success: function(file, response ){
      reset();
      result = JSON.parse(response);
      if(result.response == true)
      {
        console.log(result);
        alertify.success(result.message);
      }
      else
      {
        alertify.set({ delay: 15000 });
        alertify.error(result.message);
      }
      refreshPostDiv();
    },
    };

    //
    // dropzone for user profile
    Dropzone.options.dropzoneForm2 = {
      autoProcessQueue: false,
      acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
      init: function(){
        myDropzone2 = this;
        //gets any uploaded image into the dropzone
        $.ajax({
          url:"classes/components/userComponents.php?dataPurpose=updateProfile",
          type: 'post',
          data: {request: 'fetch'},
          dataType: 'json',
          success:function(response){
            $.each(response, function(key, value) {
              var mockfile = {name: value.name, size: value.size};

              // myDropzone2.emit("addedfile", mockfile);
              myDropzone2.emit("thumbnail", mockfile, value.path);
              myDropzone2.emit("complete", mockfile);
            });
          }
        });
        this.on("complete", function(){
          if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
          {
            var _this = this;
            _this.removeAllFiles();
          }
          list_image();
        });
        this.on('addedfile', function(file) {
          fileNameUploaded2 = file.name;
          if (this.files.length > 1) {
            this.removeFile(this.files[0]);
            alertify.error("You cannot upload more than one file");
          }
        });
        this.on("sending", function(data, xhr, formData) {
          //send all the form data along with the files:
          formData.append("username", document.getElementById("username").value);
          formData.append("email", document.getElementById("email").value);
          formData.append("gender", document.getElementById("gender").value);
          formData.append("user_country", document.getElementById("user_country").value);
          var password = document.getElementById("password").value;
          if(password != "")
          {
            formData.append("password", password);
          }
        });
      },
      success: function(file, response ){
        reset();
        result = JSON.parse(response);
        if(result.response == true)
        {
          console.log(result);
          alertify.success(result.message);
        }
        else
        {
          alertify.set({ delay: 15000 });
          alertify.error(result.message);
        }
      },
    };

    //
    // dropzone for ads
    Dropzone.options.dropzoneForm3 = {
      autoProcessQueue: false,
      acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
      init: function(){
        myDropzone3 = this;
        this.on("complete", function(){
          if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
          {
            var _this = this;
            _this.removeAllFiles();
          }
          list_image();
        });
        this.on('addedfile', function(file) {
          fileNameUploaded3 = file.name;
          if (this.files.length > 3) {
            this.removeFile(this.files[0]);
            alertify.error("You cannot upload more than three files");
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
      success: function(file, response ){
        reset();
        result = JSON.parse(response);
        if(result.response == true)
        {
          console.log(result);
          alertify.success(result.message);
        }
        else
        {
          alertify.set({ delay: 15000 });
          alertify.error(result.message);
        }
      },
    };

  });

  function refreshPostDiv()
  {
    $('#allPost').load(document.URL + ' #allPost')
  }

  //deletePost

  //list_image();
  function list_image()
  {
   $.ajax({
    url:"classes/components/userComponents.php?dataPurpose=createPost",
    success:function(data){
     $('#preview').html(data);
    }
   });
  }

  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
     url:"classes/components/userComponents.php?dataPurpose=createPost",
     method:"POST",
     data:{name:name},
     success:function(data)
     {
      list_image();
     }
    })
  });
//dropzone codes stop here
//

function ValidateEmail(email) {
  let emailtest = /[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/;

  if (!emailtest.test(email)) {
    return false;
  } else {
    return true;
  }
}

function PingURL(URL) {
  // The custom URL entered by user
  //var URL = $("#url").val();
  var settings = {
    // Defines the configurations
    // for the request
    cache: false,
    dataType: "jsonp",
    async: true,
    crossDomain: true,
    url: URL,
    method: "GET",
    headers: {
      accept: "application/json",
      "Access-Control-Allow-Origin": "*",
    },

    // Defines the response to be made
    // for certain status codes
    statusCode: {
      200: function (response) {
        return true;
      },
      400: function (response) {
        return false;
      },
      0: function (response) {
        return false;
      },
    },
  };

  // Sends the request and observes the response
  $.ajax(settings).done(function (response) {
    console.log(response);
  });
}

function getLocation() {
  reset();
  var ipadd;
  return;
  alertify.set({ labels: { ok: "Accept", cancel: "Deny" } });
  alertify.confirm("This site uses Cookies. <br> <div class='container'> We are collection information about your location</div>", function (e) {
    if (e) {
      alertify.success("Thanks for Accepting.");
    } else {
      alertify.log("We are only collecting information about your location.");
    }
  });

  // Add "https://ipinfo.io" statement
  // this will communicate with the ipify servers
  // in order to retrieve the IP address
  // $.get("https://ipinfo.io", function(response) {
  //     ipadd = response.ip
  //     alert(response);
  // }, "json")

  // "json" shows that data will be fetched in json format

  /* Add "https://api.ipify.org?format=json" statement
               this will communicate with the ipify servers in
               order to retrieve the IP address $.getJSON will
               load JSON-encoded data from the server using a
               GET HTTP request */
  $.getJSON("https://api.ipify.org?format=json", function (data) {
    // Setting text of element P with id gfg
    ipadd = data.ip;
    alert(data);
  });

  console.log(ipadd);

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    return "Geolocation is not supported by this browser.";
  }
}

function getCombinedDateTime()
{
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
  const day = String(today.getDate()).padStart(2, '0');
  const hours = String(today.getHours()).padStart(2, '0');
  const minutes = String(today.getMinutes()).padStart(2, '0');
  const seconds = String(today.getSeconds()).padStart(2, '0');
  const currentDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
  return currentDateTime;
}

function showPosition(position) {
  var result =
    "Latitude: " +
    position.coords.latitude +
    " Longitude: " +
    position.coords.longitude;
  return result;
}


function reset() {
  //set either normal UI or Bootstrap UI for the alertify
  // $("#toggleCSS").attr("href", "assets/alertify_full_src/themes/alertify.default.css");
  $("#toggleCSS").attr("href", "assets/alertify_full_src/themes/alertify.bootstrap.css");
  alertify.set({
    labels : {
      ok     : "OK",
      cancel : "Cancel"
    },
    delay : 5000,
    buttonReverse : false,
    buttonFocus   : "ok"
  });
  alertify.set('notifier','position', 'top-right');
}