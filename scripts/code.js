window.onload = getLocation;

// signup form
$( "#signup-form" ).submit(function( event ) 
{
    var username = $( "#username" ).val();
    var email = $( "#email" ).val();
    var country = $( "#country" ).val();
    var gender = $( "#gender" ).val();
    var password = $( "#password" ).val();
    var confrimpassword = $( "#confrimpassword" ).val();
    var agreed = $( "#agreed" ).val();

    if(username == "" || email == "" || country == "" || gender == "" || password == "" || confrimpassword == "")
    {
        alertify.error("Fill all Input Feilds");
    }
    if(ValidateEmail(email) == false)
    {
        alertify.error("Invalid Email, use a Valid Email");
    }
    if(password != confrimpassword)
    {
        alertify.error("Passwords are not the same");
    }
    else
    {
        if($("#agreed").is(':checked'))
        {
            let formdata = new FormData();
            formdata.append("username", username);
            formdata.append("email", username);
            formdata.append("gender", gender);
            formdata.append("password", password);
            formdata.append("user_ipaddress", ipaddress);
            formdata.append("user_country", country);

            let loca = "classes/components/userComponents.php?dataPurpose=signup";
            fetch(loca, { method: "POST", body: formdata })
            .then(res => res.text())
            .then(data => 
            {
                var result = JSON.parse(data);
                $( "#bmsgspan" ).text( result.message ).show().fadeOut( 5000 );
            });
        }
        else
        {
            alertify.error("Accpet Terms and Agreement to continue");   
        }
    }

    event.preventDefault();
});


    function ValidateEmail(email)
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
        {
            var domainName = emailVal.split('@')[1];
            if(domainName != "gmail.com")
            {
                var response = PingURL("https://"+domainName);
                if(response == true)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        else
        {
            return false;
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
                return false
            },
            0: function (response) {
                return false
            },
          },
        };
        
        // Sends the request and observes the response
        $.ajax(settings).done(function (response) {
          console.log(response);
        });
    }

    function getLocation()
    {
        var ipadd;

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
        $.getJSON("https://api.ipify.org?format=json", function(data) {
                
            // Setting text of element P with id gfg
            ipadd = data.ip;
            alert(data);
        })

        console.log(ipadd);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            return "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) 
    {
        var result = "Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude;
        return result;
    }