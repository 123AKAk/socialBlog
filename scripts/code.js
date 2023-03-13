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