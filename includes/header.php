<?php
    require "classes/components/db.php";
    require "classes/components/sharedComponents.php";
    $sharedComponents = new sharedComponents();
    
    require "includes/varnames.php";

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

  <!-- old alertify -->
	<!-- <link href="assets/js/alertify/themes/alertify.core.css" rel="stylesheet">
	<link href="assets/js/alertify/themes/alertify.default.css" rel="stylesheet"> -->

	<link href="assets/alertify/css/alertify.css" rel="stylesheet">
	<link href="assets/alertify/css/alertify.min.css" rel="stylesheet">

	<link href="assets/alertify/css/themes/bootstrap.css" rel="stylesheet">
	<link href="assets/alertify/css/themes/bootstrap.min.css" rel="stylesheet">

	<link href="assets/alertify/css/themes/default.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/alertify_full_src/themes/alertify.core.css" />
	<link rel="stylesheet" href="assets/alertify_full_src/themes/alertify.default.css" id="toggleCSS" />

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
