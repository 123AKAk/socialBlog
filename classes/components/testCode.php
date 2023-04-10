<?php
    require "db.php";
    require 'sharedComponents.php';
    $sharedComponents = new SharedComponents();

    $folder_name = "filesUpload/";

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    {
        $url = "https://";
    }
    else
    {
        $url = "http://";
    }
    // Append the requested resource location to the URL
    //$url.= $_SERVER['REQUEST_URI'];

    $mailResultMsg = $sharedComponents->sendUsersMail("Favour", "Testing Email Service", "My name is EYO", "favourakak@gmail.com", "Not necessary");

    print_r($mailResultMsg);
?>