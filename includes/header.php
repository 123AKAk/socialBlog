<?php
    require "classes/components/db.php";
    require "classes/components/sharedComponents.php";
    $components = new sharedComponents();
    
    require "includes/varnames.php";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <!-- old alertify -->
	<!-- <link href="assets/js/alertify/themes/alertify.core.css" rel="stylesheet">
	<link href="assets/js/alertify/themes/alertify.default.css" rel="stylesheet"> -->

	<link href="assets/alertify/css/alertify.css" rel="stylesheet">
	<link href="assets/alertify/css/alertify.min.css" rel="stylesheet">

	<link href="assets/alertify/css/themes/bootstrap.css" rel="stylesheet">
	<link href="assets/alertify/css/themes/bootstrap.min.css" rel="stylesheet">

	<link href="assets/alertify/css/themes/default.css" rel="stylesheet">

</head>
