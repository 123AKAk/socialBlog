<?php


$stmt = $conn->prepare("SELECT * FROM `siteInfo` WHERE id=1");
$stmt->execute();
$siteInfo = $stmt->fetch();

if (isset($siteInfo)) {
    $siteName = "Macae Blog";
    $globalName = "Macae";
    $siteEmail = "admin@donnapoodles.com";
    $siteEmailPassword = "5a51EZbK9jKj";
    $siteEmailHost = "mail.donnapoodles.com";
    $siteEmailPort = 465;
    $siteMsg = "Check out this Post on ";
    $siteHashTag = "BLUNT BLOGGING NIGERIA";
    $pageTitleDefault = "BLUNT BLOG";
    $pageDescDefault = "BLOGGING FOR EVERYONE";
    $siteURL = "http://bluntechnology.com/";
    $pageLogo = "http://bluntechnology.com/assets/img/logo.png";
    $logoDesc = "Nice Color";
    $siteImage = "siteImage.jpg";
    $siteDesc = "This is from Macae";
}
