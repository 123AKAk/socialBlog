<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Medium RSS URL</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        img{
            width: 200px;
            height: 200px;
        }
    </style>

</head>
<body>
    <div class="container-fluid pt-4">
        <div class="jumbotron text-center">
            <div id="logo"></div>
            <h1 class="display-4 mb-3" style="font-weight: 500;">Blog Page</h1>
            <a class="btn btn btn-lg" style="color: green;" href="https://medium.com/@eyoakak" target="_blank" role="button">View all posts</a>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="" id="medium">
                    <div class="row" id="jsonContent">
                    </div>
                    <center>
                        <ul class="pagination" id="pagin" style="text-align: center;">
                        </ul>
                    </center>
            
                    <!-- modal here -->
                    <div class="modal" id="exampleModal">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h3 class="modal-title">Blog</h3>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                <h3 style="color: green;" id="bodytitle"></h3>
                                <br>
                                <p id="bodytext">
                                </p>
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <h5>Ads here</h5>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(function () 
        {
            var mediumPromise = new Promise(function (resolve) {
            var $content = $('#jsonContent');
            var data = {
                rss: 'https://medium.com/feed/@eyoakak'
            };
            $.get('https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fmedium.com%2Ffeed%2F%40eyoakak', data, function (response) {
                if (response.status == 'ok') {
                    $("#logo").append(`<img src="${response.feed["image"]}" class="rounded mx-auto d-block">`)
                    var display = '';
                    $.each(response.items, function (k, item) {
                        display += `<div class=" m-3 mx-auto col-12 col-md-6 col-xl-4 carda" >`;
                        var src = item["thumbnail"]; // use thumbnail url
                        display += `<img src="${src}" class="card-img-top" alt="Tete Efik Dictionary" style="height: 20rem;">`;
                        display += `<div class="card-body">`;
                        display += `<h5 class="card-title"><a style="color:green;" href="${item.link}">${item.title}</a></h5>`;
                        var yourString = item.description.replace(/<img[^>]*>/g,""); //replace with your string.
                        yourString = yourString.replace('h4', 'p');
                        yourString = yourString.replace('h3', 'p');
                        var maxLength = 120; // maximum number of characters to extract
                        //trim the string to the maximum length
                        var trimmedString = yourString.substr(0, maxLength);
                        //re-trim if we are in the middle of a word
                        trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
                        display += `<p class="card-text">${trimmedString}...</p>`;
                        
                        //display += `<a href="${item.link}" target="_blank" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal">Read More</a>`;
                        display += `<a href="#" class="btn btn-outline-success" onclick="showSingleBlog(${k})" data-toggle="modal" data-target="#exampleModal">Read More</a>`;
                        display += '</div></div></div>';
                        return k < 10;
                    });

                    resolve($content.html(display));
                }
            });
            });

            mediumPromise.then(function()
            {
                //Pagination
                pageSize = 6;

                var pageCount = $(".carda").length / pageSize;
                
                for (var i = 0; i < pageCount; i++) {
                    $("#pagin").append(`<li class="page-item"><a style="" class="page-link" href="#">${(i + 1)}</a></li> `);
                }
                $("#pagin li:nth-child(1)").addClass("active");
                showPage = function (page) {
                    $(".carda").hide();
                    $(".carda").each(function (n) {
                        if (n >= pageSize * (page - 1) && n < pageSize * page)
                            $(this).show();
                    });
                }

                showPage(1);

                $("#pagin li").click(function () {
                    $("#pagin li").removeClass("active");
                    $(this).addClass("active");
                    showPage(parseInt($(this).text()))
                    return false;
                });
            });
        });


        function showSingleBlog(key)
        {
            console.log("Okay"+key);

            var mediumPromise = new Promise(function (resolve) {
            var $content = $('#jsonContent');
            var data = {
                rss: 'https://medium.com/feed/@eyoakak'
            };
            $.get('https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fmedium.com%2Ffeed%2F%40eyoakak', data, function (response) {
                if (response.status == 'ok') 
                {
                    $.each(response.items, function (k, item) {
                        if(k == key)
                        {
                            document.getElementById("bodytitle").innerHTML = item.title;
                            document.getElementById("bodytext").innerHTML = item.description;
                        }
                    });

                    resolve($content.php(display));
                }
            });
            });
        }
    </script>
</body>
</html>