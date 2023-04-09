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
  <link rel="stylesheet" type="text/css" href="assets/css/edits.css">

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
	</style>

</head>
