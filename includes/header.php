<?php
    require "classes/components/db.php";
    require "classes/components/sharedComponents.php";
    $sharedComponents = new sharedComponents();
    
    require "includes/varnames.php";

    //validates logged in session ID
    $loggedin = false;
    if (isset($_SESSION["macae_blog_user_loggedin_"])){
      // validate session value
      $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
      // Prepare a select statement
      $sql = "SELECT * FROM user WHERE user_id = :user_id";
      if ($stmt = $pdo->prepare($sql)) 
      {
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
          // Attempt to execute the prepared statement
          if ($stmt->execute()) 
          {
              if ($stmt->rowCount() == 1) {
                  $loggedin = true;
              }
              else{
                  echo "<script>window.location.replace('logout.php');</script>";
              }
          }
          else{
              echo "<script>window.location.replace('logout.php');</script>";
          }
      }
    }

    //set pictures folder accesible from all pages
    $folder_name = "classes/components/filesUpload/";
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicon -->
    <link rel="icon" sizes="16x16" href="assets/img/favicon.png">

    <!-- Title -->
    <title> MACAE </title>

    <!--Stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/swiper.min.css">

    <!-- main style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/edits.css"> -->

    <!-- daterange picker -->
    <link rel="stylesheet" type="text/css" href="admin/assets/daterangepicker/daterangepicker.css">

    <!-- ajax -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->

    <link href="assets/alertify/css/alertify.css" rel="stylesheet">
    <link href="assets/alertify/css/themes/bootstrap.css" rel="stylesheet">
    <link href="assets/alertify/css/themes/semantic.css" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="assets/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="assets/dropzone/dropzone.min.css">
    <!-- dropzonejs -->
    <script src="assets/dropzone/dropzone.min.js" type="text/javascript"></script>

    <?php
      if(isset($style_refrences))
      {
        echo $style_refrences;
      }
    ?>  

    <style>
      .alertify-log-custom {
        background: blue;
      }


      @keyframes placeHolderShimmer{
        0%{
            background-position: -468px 0
        }
        100%{
            background-position: 468px 0
        }
      }
      .animated-background {
        animation-duration: 1.25s;
        animation-fill-mode: forwards;
        animation-iteration-count: infinite;
        animation-name: placeHolderShimmer;
        animation-timing-function: linear;
        background: #F6F6F6;
        background: linear-gradient(to right, #F6F6F6 8%, #F0F0F0 18%, #F6F6F6 33%);
        background-size: 800px 104px;
        height: 96px;
        position: relative;
      }
      /* for blog post */
      .awrapper-cell {
        display: flex;
      }
      .awrapper-image {
        height: 300px;
        width: 400px;
        border-radius: 10px;
        @extend .animated-background;
      }
      .awrapper-text-line {
        margin-top: 10px;
        height: 50px;
        width: 100%;
        border-radius: 3px; 
      }
      .awrapper-atext-line {
        height: 30px;
        width: 100%;
        margin-top: 15px;
        margin-right: 5px;
        border-radius: 3px; 
      }


      /* for slider child */
      .cwrapper-cell {
        /* display: flex; */
      }
      .cwrapper-image {
        height: 100px;
        width: 100px;
        border-radius: 15px;
        /* margin-right: 5px;   */
        
      }
      .cwrapper-text-line1 {
        margin-left: 5px;
        height: 20px;
        width: 130px;
        border-radius: 3px;
      }
      .cwrapper-text-line2 {
        margin-left: 5px;
        height: 15px;
        width: 130px;
        border-radius: 3px;
      }


      /* for slider 2 */
      .bwrapper-text{
        padding-bottom: 20px;
      }
      .bwrapper-text-line {
        height: 30px;
        width: 100%;
        border-radius: 3px;
      }
      .bwrapper-atext-line {
        margin: 5px;
        height: 15px;
        width: 130px;
        border-radius: 3px;
      }
    
      /* for author description and for popular post*/
      .dwrapper-cell {
        align-items: center;
        justify-content: center;
        display: flex;
      }
      .dwrapper-image {
        height: 100px;
        width: 100px;
        border-radius: 15px;
        @extend .animated-background;
      }
      .dwrapper-text-line1 {
        height: 15px;
        width: 100%;
        border-radius: 3px;
      }
      .dwrapper-text-line2 {
        height: 30px;
        width: 100%;
        border-radius: 3px;
      }

      /* for categories */
      .ewrapper-text-line1
      {
        height: 20px;
        width: 95px;
        border-radius: 3px;
      }

      /* for ads */
      .fwrapper-image
      {
        height: 200px;
        width: 100%;
        border-radius: 3px;
      }
      

      
    </style>

</head>
