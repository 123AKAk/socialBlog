  window.onload = getLocation;

  // signup form
  $("#signup-form").submit(function (event)
  {
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



  function ValidateEmail(email) {
    let emailtest = /[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/;

    if (!emailtest.test(email)) {
        return false;
    } else {
        return true;
    }
  }

  function PingURL(URL) 
  {
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

  
  var result = document.getElementById("json-result");
  const Http = new XMLHttpRequest();
  var bdcApi = "https://api.bigdatacloud.net/data/reverse-geocode-client"

  function getLocation()
  {
    reset();

    alertify.alert("This site uses Cookies to imporove your experience, <br> <div class='container'> to continue to use this site you agree to our terms and conditions</div>");

    // alertify.set({ labels: { ok: "Ok", cancel: "" } });
    // alertify.confirm("This site uses Cookies to imporove your experience, <br> <div class='container'> to continue to use this site you agree to our terms and conditions</div>", function (e) {
    //   if (e) {
    //     alertify.success("Thanks for Accepting.");
    //   } else {
    //     alertify.log("We are only collecting information about your location.");
    //   }
    // });
    

    window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;  
    var pc = new RTCPeerConnection({iceServers:[]}), 
    noop = function(){}; 
      
    pc.createDataChannel("");  
    pc.createOffer(pc.setLocalDescription.bind(pc), noop);   
    pc.onicecandidate = function(ice){ 
      if(!ice || !ice.candidate || !ice.candidate.candidate)  return;

      var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];

      console.log(myIP);
      pc.onicecandidate = noop;
	  };    
    
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);

      navigator.geolocation.getCurrentPosition(
          (position) => {
              bdcApi = bdcApi
                  + "?latitude=" + position.coords.latitude
                  + "&longitude=" + position.coords.longitude
                  + "&localityLanguage=en";
              getApi(bdcApi);

          },
          (err) => { getApi(bdcApi); },
          {
              enableHighAccuracy: true,
              timeout: 5000,
              maximumAge: 0
          });
    } else {
      alertify.log("Geolocation is not supported by this browser.");
    }
  }

  function getApi(bdcApi) {
    Http.open("GET", bdcApi);
    Http.send();
    Http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
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

  function showPosition(position)
  {
    var result =
      "Latitude: " +
      position.coords.latitude +
      " Longitude: " +
      position.coords.longitude;
    return result;
  }


  function reset()
  {
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