  window.onload = getLocation;


  //to get complete data about countries 
//   const url = "https://restcountries.com/v3.1/all";
//     fetch(url)
//     .then(response => {
//         if (response.ok) {
//             return response.json();
//         }
//         throw new Error("Failed to retrieve country list.");
//     })
//     .then(countries => {
//         const countries_sorted = countries.sort((a, b) => {
//             if (a.name.common < b.name.common) return -1;
//             if (a.name.common > b.name.common) return 1;
//                 return 0;
//             });
//             var earry = [];
//             for (let country of countries_sorted) {
//                 earry.push(country.name.common)   
//             }
//             console.log(earry);
//     })
//     .catch(error => {
//         console.error(error);
//     });
  
  const nextText = "South Korea, South Sudan, Spain, Sri Lanka, Sudan, Suriname, Svalbard and Jan Mayen, Sweden, Switzerland, Syria, São Tomé and Príncipe, Taiwan, Tajikistan, Tanzania, Thailand, Timor-Leste, Togo, Tokelau, Tonga, Trinidad and Tobago, Tunisia, Turkey, Turkmenistan, Turks and Caicos Islands, Tuvalu, Uganda, Ukraine, United Arab Emirates, United Kingdom, United States, United States Minor Outlying Islands, United States Virgin Islands, Uruguay, Uzbekistan, Vanuatu, Vatican City, Venezuela, Vietnam, Wallis and Futuna, Western Sahara, Yemen, Zambia, Zimbabwe, Åland Islands";
  
  const text = "Afghanistan, Albania, Algeria, American Samoa, Andorra, Angola, Anguilla, Antarctica, Antigua and Barbuda, Argentina, Armenia, Aruba, Australia, Austria, Azerbaijan, Bahamas, Bahrain, Bangladesh, Barbados, Belarus, Belgium, Belize, Benin, Bermuda, Bhutan, Bolivia, Bosnia and Herzegovina, Botswana, Bouvet Island, Brazil, British Indian Ocean Territory, British Virgin Islands, Brunei, Bulgaria, Burkina Faso, Burundi, Cambodia, Cameroon, Canada, Cape Verde, Caribbean Netherlands, Cayman Islands, Central African Republic, Chad, Chile, China, Christmas Island, Cocos (Keeling) Islands, Colombia, Comoros, Cook Islands, Costa Rica, Croatia, Cuba, Curaçao, Cyprus, Czechia, DR Congo, Denmark, Djibouti, Dominica, Dominican Republic, Ecuador, Egypt, El Salvador, Equatorial Guinea, Eritrea, Estonia, Eswatini, Ethiopia, Falkland Islands, Faroe Islands, Fiji, Finland, France, French Guiana, French Polynesia, French Southern and Antarctic Lands, Gabon, Gambia, Georgia, Germany, Ghana, Gibraltar, Greece, Greenland, Grenada, Guadeloupe, Guam, Guatemala, Guernsey, Guinea, Guinea-Bissau, Guyana, Haiti, Heard Island and McDonald Islands, Honduras, Hong Kong, Hungary, Iceland, India, Indonesia, Iran, Iraq, Ireland, Isle of Man, Israel, Italy, Ivory Coast, Jamaica, Japan, Jersey, Jordan, Kazakhstan, Kenya, Kiribati, Kosovo, Kuwait, Kyrgyzstan, Laos, Latvia, Lebanon, Lesotho, Liberia, Libya, Liechtenstein, Lithuania, Luxembourg, Macau, Madagascar, Malawi, Malaysia, Maldives, Mali, Malta, Marshall Islands, Martinique, Mauritania, Mauritius, Mayotte, Mexico, Micronesia, Moldova, Monaco, Mongolia, Montenegro, Montserrat, Morocco, Mozambique, Myanmar, Namibia, Nauru, Nepal, Netherlands, New Caledonia, New Zealand, Nicaragua, Niger, Nigeria, Niue, Norfolk Island, North Korea, North Macedonia, Northern Mariana Islands, Norway, Oman, Pakistan, Palau, Palestine, Panama, Papua New Guinea, Paraguay, Peru, Philippines, Pitcairn Islands, Poland, Portugal, Puerto Rico, Qatar, Republic of the Congo, Romania, Russia, Rwanda, Réunion, Saint Barthélemy, Saint Helena, Ascension and Tristan da Cunha, Saint Kitts and Nevis, Saint Lucia, Saint Martin, Saint Pierre and Miquelon, Saint Vincent and the Grenadines, Samoa, San Marino, Saudi Arabia, Senegal, Serbia, Seychelles, Sierra Leone, Singapore, Sint Maarten, Slovakia, Slovenia, Solomon Islands, Somalia, South Africa, South Georgia,"+nextText;
  const arrCountry = text.split(",");

  // signup form
  $("#signup-form").submit(function (event)
  {
      var username = $("#username").val();
      var email = $("#email").val();
      var gender = $("#gender").val();
      var password = $("#password").val();
      var confrimpassword = $("#confrimpassword").val();
      var country = selectedCountry;

      var mainUserinfo = alluserInfo["latitude"]+","+alluserInfo["longitude"]+","+alluserInfo["continent"]+","+alluserInfo["locality"]+","+alluserInfo["principalSubdivision"]

      if (
          username == "" ||
          email == "" ||
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

            if(country == "")
            {
                country = alluserInfo["countryName"];
            }

            let formdata = new FormData();
            formdata.append("username", username);
            formdata.append("email", email);
            formdata.append("gender", gender);
            formdata.append("password", password);
            formdata.append("user_ip_address", ipaddress);
            formdata.append("user_country", country);
            formdata.append("userInfo", mainUserinfo);

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
      var email = $("#email").val();
      var password = $("#password").val();

      if(email == "" || password == "") 
      {
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
                alertify.message("Redirecting...");
                setTimeout(function () {
                    window.location.replace("dashboard.php");
                }, 2000);

              } else {
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


  var bdcApi = "https://api.bigdatacloud.net/data/reverse-geocode-client"
  var ipaddress = "";
  let selectedCountry = "";
  let alluserInfo = "";
  function getLocation()
  {
    
    //set modal no removable
    $('#startUpToogle').modal({
        backdrop: 'static',
        keyboard: false
    });

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;  
    var pc = new RTCPeerConnection({iceServers:[]}), 
    noop = function(){}; 
      
    pc.createDataChannel("");  
    pc.createOffer(pc.setLocalDescription.bind(pc), noop);   
    pc.onicecandidate = function(ice){ 
      if(!ice || !ice.candidate || !ice.candidate.candidate)  return;

      var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate);

      ipaddress = myIP;
      //console.log(myIP);
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
      alertify.message("Geolocation is not supported by this browser.");
    }
    
    // if cookie is not set run aleritfy
    const token = getCookie("tok__enCountry")
    if(token == null)
    {
        // shows startUp Modal
        $('#startUpToogle').modal('toggle');
        //alertify.alert(document.getElementById("setCountry").innerHTML).set({ 'closable': false , 'basic': true, 'movable': false});
    }
    else
    {
        countryCookie = getCookie("tok__enCountry");
        loadData(countryCookie);
    }
    
  }

  
  function getApi(bdcApi) {

    fetch(bdcApi)
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Failed to retrieve Countries list.");
    })
    .then(userLocationData => {
        alluserInfo = userLocationData;

        var option = document.createElement("option");
        option.text = alluserInfo["countryName"];
        option.value = alluserInfo["countryName"];
        var select = document.getElementById("userCountryList");
        var eselect = document.getElementById("country");
        //select.appendChild(option);
        //select.insertBefore(option, select.firstChild);
        select.insertAdjacentHTML('afterbegin', option.outerHTML);
        eselect.insertAdjacentHTML('afterbegin', option.outerHTML);

        for (let country of arrCountry) {
            var optionN = document.createElement("option");
            optionN.text = country;
            optionN.value = country;
            select.appendChild(optionN);
        }

        for (let country of arrCountry) {
            var optionN = document.createElement("option");
            optionN.text = country;
            optionN.value = country;
            eselect.appendChild(optionN);
        }


        $('#counSpiner').hide();
        $('#counHolder').show();
    })
    .catch(error => {
        console.error(error);
        alertify.error("Error authenticating Client Machine");
    });
  }

  function getSelectedCountry(selectObject) {
    var value = selectObject.value;
    selectedCountry = value;
  }

  setCountry_check = 0;
  function setUserCountry()
  {
    if(selectedCountry == "" && alluserInfo == "")
    {
        alertify.error("Select a country");
    }
    else
    {
        if(selectedCountry != "")
        {
            document.cookie = `tok__enCountry=${selectedCountry}; expires=Thu, 31 Dec 2099 23:59:59 GMT; path=/cookieFolder`;
            loadData(selectedCountry);
        }
        else
        {
            document.cookie = `tok__enCountry=${alluserInfo["countryName"]}; expires=Thu, 31 Dec 2099 23:59:59 GMT; path=/cookieFolder`;
            loadData(alluserInfo["countryName"]);
        }
        $('#startUpToogle').modal('toggle');
    }
    if(setCountry_check == 1)
    {
        location.reload();
    }
    setCountry_check = 1;
  }

  function loadData(userCountry)
  {
    console.log(userCountry);

        let formdata1 = new FormData();
        formdata1.append("dataType", "slider")
        formdata1.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata1,
            })
            .then(res => res.json())
            .then(data => {
                //console.log(data);
                if(data != 0)
                {
                    $("#slider").html(data.slider);
                    $("#sliderControls").html(data.sliderControls);
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );

        let formdata3 = new FormData();
        formdata3.append("dataType", "bodyPost1")
        formdata3.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata3,
            })
            .then(res => res.text())
            .then(data => {
                //console.log(data);
                if(data != 0)
                {
                    $("#bodyPost1").html(data);

                    // adding styling
                    // $(".image-box").css({
                    //     "position": "relative",
                    //     "margin": "auto",
                    //     "overflow": "hidden",
                    //     "justify-content": "center",
                    //     "align-items": "center",
                    //     "overflow": "hidden"
                    // });
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );

        return;

        let formdata4 = new FormData();
        formdata4.append("dataType", "popularPost")
        formdata4.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata4,
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                if(data != 0)
                {
                    $("#popularPost").html(data);
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );

        let formdata5 = new FormData();
        formdata5.append("dataType", "bodyPost2")
        formdata5.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata5,
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                if(data != 0)
                {
                    $("#bodyPost2").html(data);
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );

        let formdata6 = new FormData();
        formdata6.append("dataType", "other")
        formdata6.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata6,
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                if(data != 0)
                {
                    // $("#other").html(data);
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );

        let formdata7 = new FormData();
        formdata7.append("dataType", "ads1")
        formdata7.append("userCountry", userCountry)
        fetch("classes/components/userComponents.php?dataPurpose=loadData", 
        {
                method: "POST",
                body: formdata7,
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                if(data != 0)
                {
                    // $("#ads1").html(data);
                }
        })
        .catch(error => 
            // handle the error
            console.log(error)
        );
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

  function getCookie(name) {
    const cookieString = document.cookie;
    const cookies = cookieString.split(";");
  
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
  
      if (cookie.startsWith(`${name}=`)) {
        return cookie.substring(name.length + 1, cookie.length);
      }
    }
  
    return null;
  }
  
  function deleteCookie(name)
  {
      document.cookie = name + "=;expires=Thu, 01 Jan 1980 00:00:01 GMT;";
  }

//   function reset()
//   {
//     //set either normal UI or Bootstrap UI for the alertify
//     // $("#toggleCSS").attr("href", "assets/alertify_full_src/themes/alertify.default.css");
//     $("#toggleCSS").attr("href", "assets/alertify/css/themes/semantic.css");
//     alertify.set({
//       labels : {
//         ok     : "OK",
//         cancel : "Cancel"
//       },
//       delay : 5000,
//       buttonReverse : false,
//       buttonFocus   : "ok"
//     });
//     alertify.set('notifier','position', 'top-right');
//   }