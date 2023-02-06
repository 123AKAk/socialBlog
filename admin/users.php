<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all users Data
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $number_of_rows = $stmt->rowCount();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h2 class="page-title bold">Users (<?= $number_of_rows ?>)</h2>
                                <input type="hidden" value="<?= $number_of_rows ?>" id="numrows"/>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Users</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Start -->
                <div class="row">
                    <!-- Advance Table Card-->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card table-card">
                            <div class="col">
                                <!-- feedback message -->
                                <?php include 'includes/feedbackmsg.php'; ?>
                            </div>
                            <div class="card-body">
                                <div class="chart-holder">
                                    <div class="table-responsive">
                                        <button id="showexport" style="float: right; display:none;" class="btn btn-sm btn-secondary mb-2" title="Exports Emails to CSV file" onclick="exportdata('csv')">Export CSV file</button>

                                        <button id="showmail" style="float: right; display:none;" class="btn btn-sm btn-secondary mb-2" title="Send Mail" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="exportdata('displaymail')">Send Mail</button>

                                        <table id="myTable" class="table table-styled" style="padding-bottom: 20px;  border:none">
                                            <thead>  
                                                <tr>  
                                                    <th>
                                                        <div class="checkbox">
                                                            <input id="checkbox0" title="Select All" type="checkbox" onclick="selectall('checkbox0')">
                                                            <label for="checkbox0"></label>
                                                        </div>
                                                    </th>
                                                    <th>S/N</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Time Created</th>
                                                    <!-- <th>User Type</th> -->
                                                    <th>Actions</th>
                                                </tr>  
                                                </thead>  
                                                <tbody>  
                                                <?php
                                                $countnum = 0;
                                                foreach ($data as $row) :                                                    
                                                echo $row['userstatus'] == 0 ? "<tr style='background:#f1f2f6; '>" : "<tr>";
                                                $date=date_create($row['created_at']);
                                                $countnum++
                                                ?>
                                                    <td>
														<div class="checkbox">
															<input value="<?= $row['id'] ?>" id="checkbox<?= $countnum ?>" type="checkbox" name="<?= $row['id'] ?>" onclick="onSelect('<?= $countnum ?>')">
															<label for="checkbox<?= $countnum ?>"></label>
														</div>
													</td>
                                                    <td>
                                                        <?= $countnum ?>
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <p id="checknamebox<?= $countnum ?>"> <?= $row['username'] ?></p>
                                                    </td>
                                                    <td>
                                                        <a id="checkemailbox<?= $countnum ?>" href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a>
                                                    </td>
                                                    <td>
                                                        <?= date_format($date, "D, M Y H:i:s") ?>
                                                    </td>
                                                    <!-- <td>
                                                        <?php //echo $row['type'] == 1 ? "<p style='font-weight: bold; color:dodgerblue;'>Admin</p>" : "<p>User</p>"; ?>
                                                    </td> -->
                                                    <td class="relative">
                                                        <a class="action-btn " href="javascript:void(0); ">
                                                            <svg class="default-size "  viewBox="0 0 341.333 341.333 ">
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                            <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                            <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                        <div class="action-option ">
                                                            <ul>
                                                                <li>
                                                                    <a href="../assets/delete.php?type=user&id=<?= $row['id'] ?> ">
                                                                        <i class="far fa-trash-alt mr-2" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="mailto:<?= $row['email'] ?>">
                                                                    <i class="far fa-envelope mr-1" aria-hidden="true"></i> Email
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php
                                                    echo "</tr>";
                                                    endforeach;
                                                ?>
                                            </tbody>  
                                        </table> 
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="sendbulkemail" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send Bulk Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert primary" id="emailalert" style="border-radius: 5px; display:none;background:slategray">
                                <span onclick="hidealert('emailalert')" class="closebtn">&times;</span>
                                <p style="text-align:center" id="txt"></p>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Recipient(s)</label>
                                <input type="text" id="displaymails" class="form-control" readonly required>
                            </div>
                            <div>
                                <label for="subject" class="col0-form-label">Mail Subject</label>
                                <input type="text" id="mailsubject" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="arContent" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="emailBtn" class="btn btn-primary">Send Mail</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</body>  

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/apexchart/apexcharts.min.js"></script>
<script src="assets/js/apexchart/control-chart-apexcharts.js"></script>
<!-- Page Specific -->
<script src="assets/js/nice-select.min.js"></script>
<!-- Custom Script -->
<script src="assets/js/custom.js"></script>

<!-- alertify -->
<script src="assets/js/alertify/src/alertify.js"></script>

<script>
    
    //hides the feedback alert
    function hidealert(idname){
        var fade = document.getElementById(idname);
        var div = fade;
        setTimeout(function(){ div.style.display = "none"; }, 600);
        div.style.opacity = "0";
      }
      
      //shows the feedback alert
      function showalert(errortext, idname)
      {
        var fade = document.getElementById(idname);

        document.getElementById("txt").innerHTML = errortext;
        var opacity = 0;
        var intervalID = setInterval(function() {
          if (opacity < 1) {
            opacity = opacity + 0.1
            fade.style.opacity = opacity;
          } else {
            clearInterval(intervalID);
          }
        }, 10);
        fade.style.display = "block";        
    }

    $( "#sendbulkemail" ).submit(function(event) 
    {
        if($( "#arContent" ).val() != "")
        {
            
            document.getElementById("emailBtn").disabled = true;
            document.getElementById("emailBtn").innerHTML = "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Sending...";

            let formdata = new FormData();
            formdata.append("emails", $( "#displaymails" ).val());
            formdata.append("emailmsg", $( "#arContent" ).val());
            formdata.append("emailsubject", $( "#mailsubject" ).val());
            let loca = "mailing.php";
            fetch(loca, { method: "POST", body: formdata })
            .then(res => res.text())
            .then(data =>
            {
                var result = JSON.parse(data);

                showalert(result.message, "emailalert")
                
                document.getElementById("emailBtn").disabled = false;
                document.getElementById("emailBtn").innerHTML = "Send Mail";
                $( "#displaymails" ).val("");
                $( "#arContent" ).val("");
                $( "#mailsubject" ).val("");

                alertify.alert(result.message, function(){
                        alertify.message('OK');
                    });
            });
        }
        hidealert("emailalert")
        event.preventDefault();
    });

    var xarray = [];

    function selectall(idname)
    {
        let count = document.getElementById("numrows").value;

        //check if all checked
        if(document.getElementById(idname).checked == true)
        {
            // Create one dimensional array
            // Loop to create 2D array using 1D array
            for (var i = 0; i < count; i++) 
            {
                xarray[i] = new Array(2);
            }
            // Loop to initialize 2D array elements.
            for (var i = 0; i < count; i++) 
            {
                for (var j = 0; j < 2; j++)
                {
                    document.getElementById("checkbox"+(i+1)).checked = true;
                    xarray[i][j] = [document.getElementById("checknamebox"+(i+1)).innerHTML];
                    if(j > 0)
                    {
                        xarray[i][j] = [document.getElementById("checkemailbox"+(i+1)).innerHTML];
                    }
                }
            }
            document.getElementById("showexport").style.display = "block";
            document.getElementById("showmail").style.display = "block";
        }
        else
        {
            for(let i = 0; i <= count; i++)
            {
                document.getElementById("checkbox"+i).checked = false;
            }
            xarray = [];
            document.getElementById("showexport").style.display = "none";
            document.getElementById("showmail").style.display = "none";
        }
        console.log(xarray);
    }

    //search an array
    function searchStringInArray(str, strArray)
    {
        for (var j=0; j<strArray.length; j++) {
            if (String(strArray[j]).match(str)) return j;
        }
        return -1;
    }

    function onSelect(idnum)
    {
        var emailval = document.getElementById("checkemailbox"+idnum).innerHTML;
        var nameval = document.getElementById("checknamebox"+idnum).innerHTML;

        if(xarray.length > 0)
        {
            var checkresult = searchStringInArray(emailval, xarray);
            // check if checked
            if(checkresult >= 0)
            {
                xarray.splice(checkresult,1);
                if(xarray.length <= 2)
                {
                    document.getElementById("showexport").style.display = "none";
                    document.getElementById("showmail").style.display = "none";
                    document.getElementById("checkbox0").checked = false;
                }
            }
            else
            {
                xarray.push([[nameval], [emailval]]);

                document.getElementById("showexport").style.display = "block";
                document.getElementById("showmail").style.display = "block";
            }
        }
        else
        {
            xarray = [[[nameval], [emailval]]];
        }
        
        console.log(xarray);
    }

    function exportdata(data)
    {
        if(data == "displaymail")
        {
            document.getElementById("displaymails").value = "";
            // Loop to display the elements of 2D array. 
            for (var i = 0; i < xarray.length; i++)
            {
                //display emails
                document.getElementById("displaymails").value += xarray[i][1];
                //display names
                //document.getElementById("displaymails").value += xarray[i][0];
                if(i != xarray.length-1)
                {
                    document.getElementById("displaymails").value += ", ";
                }
            }
        }
        else
        {
            download_csv_file(xarray);
        }
    }

    //create a user-defined function to download CSV file   
    function download_csv_file(csvFileData)
    {
        //define the heading for each row of the data  
        var csv = 'Name,Emails\n';  

        //merge the data with CSV
        for (let row of csvFileData)
        {
            csv += row.join(',');  
            csv += "\n";  
        }
        var hiddenElement = document.createElement('a');  
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);  
        hiddenElement.target = '_blank';  

        //provide the name for the CSV file to be downloaded  
        hiddenElement.download = 'blogemails.csv';  
        hiddenElement.click();  
    }


</script>
<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<!-- Text Editor Script -->
<script>
    var xdata = "<html><body style='margin:0; line-height: 26px;'><table style='background-color:#f8f8f8; width:100%;'><tr><td><table style='padding: 40px 0 0;padding-bottom: 0; width: 600px;margin:0 auto; margin-bottom:40px; border: none;'><tr><td style='border: none;clear: both !important;background-color:#ffffff;display: block !important;Margin: 0 auto !important;max-width: 600px !important;border-radius: 10px;'><table style='width: 100%; border: none;border: none;'><tr style='-webkit-font-smoothing: antialiased;  height: 100%;  -webkit-text-size-adjust: none;  width: 100% !important;'><td style=' float: left; padding: 40px 0px 145px;text-align: center;width:100%;background-image: url(assets/images/backgroundshape.png); background-size: cover;background-position: center;'><span style='text-align: center;display:inline-block;'><a href='#' style='text-decoration:none; color:white; font-size:34px; font-weight:bold; font-style:inherit;'>Blog</a></span></td></tr></table><table style=' width: 100%; padding:0 50px 30px;border: none;'><tr><td style='font-size:20px; color:#0b2354;font-weight: 600; text-align:left;'>Hello,</td></tr><tr><td style='height:20px;'><p style='margin-bottom: 0;font-size: 16px;color: #98a4bf;'>Small Message</p></td></tr><tr><td style='height:15px;'></td></tr><tr><td style='font-size:20px; color:#0b2354;;font-weight: 500; text-align:left;'>Post Title</td></tr><tr><td style='height:5px;'></td></tr><tr><td><img style='float:left; width:40%; margin-right:3px;' src='https://bluntechnology.com/blog/assets/img/logo/logo-dark.png'/><p style='margin: 0;font-size: 16px;color: #98a4bf;'>From Data Science, Machine Learning, Deep Learning, and Artificial intelligence are really hot at this moment and offering a lucrative career to programmers with high pay and exciting work. It's a great opportunity for programmers who are willing to learn these new skills and upgrade themselves and want to solve some of the most interesting real-world problems...</p></td></tr><tr><td style='height:20px;'></td></tr></table><table style=' width: 100%; padding:0;border: none;'><tr><td style='border-bottom: 1px solid #efefef;'></td></tr><tr><td style='height:34px;'></td></tr><tr><td style='padding:0 50px;'><p style='margin: 0;font-size: 16px;color: #98a4bf;'>From <span style='margin-right: 15px;color: #0b2354;font-weight: 600;'> Name Admin</span></p><tr><td style='height:32px;'></td></tr></table><table style=' border: none; width: 100%; padding:11px 20px 12px;  background:#11a1fd;'><tr><td style='font-size:14px; color:#ffffff; text-align:center;'>Copyright 2022 ©  Name All Rights Reserved.</td></tr></table></td></tr></table></td></tr></table></body></html>"

    var editor = CKEDITOR.replace('arContent');
    editor.setData(xdata);

    CKEDITOR.on("instanceReady", function(event) {
        var iframe = document.querySelector('#cke_1_contents iframe');
        var cke_doc = iframe.contentDocument || iframe.contentWindow.document;
        cke_doc.body.style = `background-color: whitesmoke;
                font-weight: 300;`
    });
</script>
</html>  