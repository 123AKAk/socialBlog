  //window.onload = getLocation;

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

  //profile form
  $('#profile-form').submit(function (event) {
    reset();
    var username = $("#username").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confrimpassword = $("#confrimpassword").val();

    if (username == "" || email == "") 
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Email and Username Feilds cannot be Empty");
    }
    else 
    {
      if(confrimpassword != "" || password != "")
      {
        if(confrimpassword != password)
        {
            alertify.error("Passwords are not the same");
        }
      }
      else
      {
        let formdata = new FormData();
        formdata.append("username", username);
        formdata.append("email", email);
        formdata.append("password", password);
    
        let loca = "classes/components/userComponents.php?dataPurpose=updateProfile";
        fetch(loca, { method: "POST", body: formdata })
          .then((res) => res.json())
          .then((data) => {
            console.log(data);
            var result = (data);
            if (result.response == true) 
            {
              alertify.success(result.message);
            } else {
              alertify.set({ delay: 11000 });
              alertify.error(result.message);
            }
        });
      }
    }
    event.preventDefault();

  });

  //file name to be uploaded
  let fileNameUploaded1 = "";
  //createPost form
  $('#createPost-form').submit(function (event) {
    reset();

    var post_title = $("#post_title").val();
    var post_category = $("#post_category").val();
    var post_contents = $('#post_contents').summernote('code');
    var post_country = $("#post_country").val();

    if (post_title == "" || post_category == "" || post_contents == "" || post_country == "")
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Fill all Feilds");
    }
    else if(fileNameUploaded1 == "")
    {
      alertify.error("Upload post Thumbnail");
    }
    else 
    {
      let formdata = new FormData();
      formdata.append("post_title", post_title);
      formdata.append("post_category", post_category);
      formdata.append("post_contents", post_contents);
      formdata.append("post_country", post_country);
      formdata.append("post_thumbnail", fileNameUploaded);
    
      let loca = "classes/components/userComponents.php?dataPurpose=createPost";
      fetch(loca, { method: "POST", body: formdata })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          var result = (data);
          if (result.response == true) 
          {
            alertify.success(result.message);
            alertify.log("Thumbnail upload started");

            //uploads file to server
            myDropzone1.processQueue();
          } else {
            alertify.set({ delay: 15000 });
            alertify.error(result.message);
          }
      });
    }

    fileNameUploaded1 = "";
    //Destroy Summernote
    $('#post_contents').summernote('destroy');

    var post_contentsVal = 'Type here...';
    $('#post_contents').summernote('code', post_contentsVal);

    event.preventDefault();

  });


  //file name to be uploaded
  let fileNameUploaded2 = "";
  //profile-form
  $('#profile-form').submit(function (event) {
    reset();

    var username = $('#username').val();
    var email = $("#email").val();
    var gender = $("#gender").val();
    var country = $("#country").val();
    var password = $("#password").val();
    var confrimPassword = $("#confrimPassword").val();

    if (username == "" || email == "" || gender == "" || password == "" || confrimPassword == "")
    {
      alertify.set('notifier','position', 'top-right');
      alertify.error("Fill all Feilds");
    }
    else if(fileNameUploaded2 == "")
    {
      alertify.error("Upload profile picture");
    }
    else 
    {
      if (password != confrimpassword) {
        alertify.error("Passwords are not the same");
      } else {
        let formdata = new FormData();
        formdata.append("username", username);
        formdata.append("email", email);
        formdata.append("gender", gender);
        formdata.append("country", country);
        formdata.append("password", password);
        formdata.append("profile_pic", fileNameUploaded2);
      
        let loca = "classes/components/userComponents.php?dataPurpose=updateProfile";
        fetch(loca, { method: "POST", body: formdata })
          .then((res) => res.json())
          .then((data) => {
            console.log(data);
            var result = (data);
            if (result.response == true) 
            {
              alertify.success(result.message);
              alertify.log("Profile picture upload started");

              //uploads file to server
              myDropzone2.processQueue();
            } else {
              alertify.set({ delay: 15000 });
              alertify.error(result.message);
            }
        });
      }
    }

    fileNameUploaded2 = "";
    event.preventDefault();
  });


  //
  //dropzone codes starts here
  //cancels file upload
  //clear dropzone for user create post
  var cancelFileUpload1 = document.querySelector('#cancelFileUploadAll1');
  cancelFileUpload1.addEventListener("click", function() {myDropzone1.removeAllFiles();});

  //clear dropzone for user profile
  var cancelFileUpload2 = document.querySelector('#cancelFileUploadAll2');
  cancelFileUpload2.addEventListener("click", function() {myDropzone2.removeAllFiles();});

  $(document).ready(function(){
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
        //file.myCustomName = file.name;
        //put name to be used in db
        fileNameUploaded = file.myCustomName;

        if (this.files.length > 1) {
          this.removeFile(this.files[0]);
          alertify.error("You cannot upload more than one file");
        }
      });
    },
    success: function(file, response ){
      obj = JSON.parse(response);
      if(obj.response == true)
      {
        alertify.success(obj.message);
      }
      else
      {
        alertify.error(obj.message);
      }
    },
    };
    // dropzone for user profile
    Dropzone.options.dropzoneForm2 = {
      autoProcessQueue: false,
      acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
      init: function(){
        myDropzone2 = this;
        this.on("complete", function(){
          if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
          {
            var _this = this;
            _this.removeAllFiles();
          }
          list_image();
        });
        this.on('addedfile', function(file) {
          //file.myCustomName = file.name;
          //put name to be used in db
          fileNameUploaded = file.myCustomName;
  
          if (this.files.length > 1) {
            this.removeFile(this.files[0]);
            alertify.error("You cannot upload more than one file");
          }
        });
      },
      success: function(file, response ){
        obj = JSON.parse(response);
        if(obj.response == true)
        {
          alertify.success(obj.message);
        }
        else
        {
          alertify.error(obj.message);
        }
      },
      };
  });

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
  var ipadd;

  reset();
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