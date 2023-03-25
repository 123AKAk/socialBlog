<?php
    require "db.php";
    require 'sharedComponents.php';
    $sharedComponents = new SharedComponents();

    $dataPurpose = $_GET['dataPurpose'];

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
                

    if ($conn)
    {
        switch ($dataPurpose) 
        {
            case "signup":
                // Prepare a select statement
                $sql = "SELECT * FROM user WHERE email = :email";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    // Set parameters
                    $param_email = trim($_POST["email"]);

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) 
                    {
                        // Check if username exists, if yes then verify password
                        if ($stmt->rowCount() == 1) {
                            // Display an error message if email exist
                            echo json_encode( ['response' => false, 'message' => 'User with that Email Address Already Exist', 'code' => '2', 'data' => '']);
                        }
                        else 
                        {
                            //generates random characters
                            $set = 'EYO1BLUNT2AKAK3';
                            $code = substr(str_shuffle($set), 0, 12);
                            $hashpassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
                            
                            // PREPARE DATA TO INSERT INTO DB
                            $data = array(
                                "username" => $sharedComponents->test_input($_POST["username"]),
                                "email" => $sharedComponents->test_input($_POST["email"]),
                                "gender" => $sharedComponents->test_input($_POST["gender"]),
                                "password" => $sharedComponents->test_input($hashpassword),
                                "user_ip_address" => $sharedComponents->test_input($_POST["user_ip_address"]),
                                "user_country" => $sharedComponents->test_input($_POST["user_country"]),
                                "date_created" => date('Y-m-d H:i:s'),
                                "code" => $code
                            );


                            // Call insert function
                            $resultmsg = json_encode($sharedComponents->insertToDB($conn, "user", $data));

                            //check if data entered the table 
                            $resultmsg2 = json_decode($resultmsg, 1);
                            if (isset($resultmsg2["response"])) 
                            {
                                if ($resultmsg2["response"] == true) 
                                {
                                    //$resultmsg2["message"];
                                    $userid =  $sharedComponents->protect($resultmsg2["data"]);

                                    // Append the host(domain name, ip) to the URL.
                                    $url.= $_SERVER['HTTP_HOST']."/uctivate.php?code=".$code."&userid=".$userid."";

                                    $emailSubject = "Macae Blog Signup Successful";
                                    $emailMessage = "
                                        <h3>Thank you for Registering on Macae .</h3>
                                        <p>Your Account Information:</p>
                                        <p>Username: ".$_POST["username"]."</p>
                                        <p>Email: ".$_POST["email"]."</p>
                                        <p>Password: ".$_POST["password"]."</p>
                                        <p>Please click the link below to activate your account.</p>
                                        <a href='".$url."'>Activate your Account</a>
                                    ";
                                    $altBody = "Macae Blog";

                                    $mailResultMsg = $sharedComponents->sendUsersMail($_POST["username"], $emailSubject, $emailMessage, $_POST["email"], $altBody);

                                    echo json_encode($mailResultMsg);
                                }
                                else
                                {
                                    echo $resultmsg;
                                }
                            }
                            else
                            {
                                echo $resultmsg;
                            }
                        }
                    }
                    else {
                        echo json_encode( ['response' => false, 'message' => 'Authorisation Failed', 'code' => '0', 'data' => '']);
                    }
                }
                break;
            case "login":
                $sql = "SELECT * FROM user WHERE email = :email";
                if ($stmt = $pdo->prepare($sql)) 
                {
                    // Set parameters
                    $param_email = trim($_POST["email"]);
                    $password = $_POST["password"];
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Check if email exists, if yes then verify password
                        if ($stmt->rowCount() == 1) {
                            if ($row = $stmt->fetch()) {
                                $id = $row["user_id"];
                                $userstatus = $row["status"];
                                $hashed_password = $row["password"];
                                if(password_verify($password, $hashed_password)) {
                                    if($userstatus == 0){
                                        echo json_encode( ['response' => false, 'message' => 'Account has not been Verified, check your email for Verification link', 'code' => '2', 'data' => '']);
                                    }
                                    else if($userstatus == 2){
                                        echo json_encode( ['response' => false, 'message' => 'Account has been Banned, Contact the Adminstrator for more details', 'code' => '2', 'data' => '']);
                                    }
                                    else{
                                        // Store userID in session variables protected
                                        $_SESSION["macae_blog_user_loggedin_"] = $sharedComponents->protect($id);
                                        
                                        echo json_encode( ['response' => true, 'message' => 'Login Successful', 'code' => '1', 'data' => '']);
                                    }
                                }
                                else {
                                    echo json_encode( ['response' => false, 'message' => 'The password you entered is Invalid', 'code' => '0', 'data' => '']);
                                }
                            }
                        } else {
                            echo json_encode( ['response' => false, 'message' => 'No Account found with that Email', 'code' => '0', 'data' => '']);
                        }
                    } else {
                        echo json_encode( ['response' => false, 'message' => 'Authorisation Failed', 'code' => '0', 'data' => '']);
                    }
    
                    // Close statement
                    unset($stmt);
                    // Close connection
                    unset($pdo);
                }
                break;
            case "forgotpassword":
                echo "3";
                break;
            case "comment":
                echo "4";
                break;
            case "like":
                echo "5";
                break;
            case "unlike":
                echo "6";
                break;
            case "savePost":
                echo "7";
                break;
            case "unsavePost":
                echo "7";
                break;
            case "followAuthor":
                echo "8";
                break;
            case "unfollowAuthor":
                echo "8";
                break;
            case "createPost":
                    //uploading files into the server
                    if(!empty($_FILES) && isset($_POST["post_contents"]) && isset($_POST["post_title"]) && isset($_POST["post_category"]) && isset($_POST["post_country"]))
                    {
                        $file_name = $_FILES["file"]["name"];
                        $new_file_name = "user-".date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                        $temp_file = $_FILES['file']['tmp_name'];
                        $location = $folder_name . $new_file_name;
                        if(move_uploaded_file($temp_file, $location))
                        {
                            // Call check - Insert Category function
                            $resultmsg = json_encode($sharedComponents->checkInsertCategory($conn, $_POST["post_category"]));

                            //check if data entered the table 
                            $resultmsg2 = json_decode($resultmsg, 1);
                            if (isset($resultmsg2["response"])) 
                            {
                                if ($resultmsg2["response"] == true) 
                                {
                                    // PREPARE DATA TO INSERT INTO DB
                                    $data = array(
                                        "post_title" => $sharedComponents->test_input($_POST["post_title"]),
                                        "id_category" => $sharedComponents->test_input($resultmsg2["data"]),
                                        "post_contents" => $sharedComponents->test_input($_POST["post_contents"]),
                                        "post_country" => $sharedComponents->test_input($_POST["post_country"]),
                                        "post_thumbnail" => $sharedComponents->test_input($new_file_name),
                                        "post_creation_time" => date('Y-m-d H:i:s'),
                                        "id_user" => $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"])
                                    );
            
                                    // Call insert function
                                    $finalresultmsg = json_encode($sharedComponents->insertToDB($conn, "posts", $data));
                                    echo $finalresultmsg;
                                }
                                else
                                {
                                    echo $resultmsg;
                                }
                            }
                            else
                            {
                                echo $resultmsg;
                            }
                        }
                        else
                        {
                            echo json_encode( ['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                        }                        
                    }
                break;
            case "editPost":
                    If(isset($_POST["postId"]))
                    {
                        $post_id = $sharedComponents->unprotect($_POST["postId"]);

                        $asql = "SELECT * FROM posts WHERE post_id = :post_id";
                        if ($astmt = $pdo->prepare($asql)){
                            // Bind variables to the prepared statement as parameters
                            $astmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
                            // Set parameters
                            $astmt->execute();
                            if ($astmt->rowCount() == 1) {
                                if ($post = $astmt->fetch()) {
                                    
                                    $postThumbnail = $post['post_thumbnail'];
                                    $postTitle = $post['post_title'];
                                    $postCountry = $post['post_country'];
                                    $postContents = htmlspecialchars_decode($post['post_contents']);
                                    //$postContents = htmlspecialchars($post['post_contents'], ENT_QUOTES, 'UTF-8');
                                    $postCategory ="";
                                    $resultmsg = json_encode($sharedComponents->getCategoryName($pdo, $post['id_category']));
                                    $resultmsg = json_decode($resultmsg, 1);
                                    if (isset($resultmsg["response"])) 
                                    {
                                        if ($resultmsg["response"] == true) 
                                        {
                                            $postCategory = $resultmsg["data"];
                                        }
                                        else{
                                            echo "Help oh5";
                                        }
                                    }
                                    else{
                                        echo "Help oh4";
                                    }

                                    $allPost= [];
                                    $postJson = new stdClass();
                                    $postJson->postThumbnail = $postThumbnail;
                                    $postJson->postTitle = $postTitle;
                                    $postJson->postCountry = $postCountry;
                                    $postJson->postContents = $postContents;
                                    $postJson->postCategory = $postCategory;
                                    
                                    array_push($allPost,$postJson);
                                    echo json_encode($postJson);
                                }
                                else{
                                    echo "Help oh1";
                                }
                            }
                            else{
                            echo "Help oh2";
                            }
                        }
                        else{
                            echo "Help oh3";
                        }
                    }
                    else if(!empty($_FILES))
                    {

                    }
                    // Read files from folder
                    else if(isset($_POST['request']))
                    {
                        if(isset($_POST["filepostId"]))
                        {
                            $file_list = array();
                            // Target folder
                            $dir = $folder_name;
                            if (is_dir($dir))
                            {
                                if ($dh = opendir($dir))
                                {
                                    $post_id = $sharedComponents->unprotect($_POST["filepostId"]);
                                    
                                    $sql = "SELECT * FROM posts WHERE post_id = :post_id";
                                    if ($stmt = $pdo->prepare($sql)) 
                                    {
                                        // Bind variables to the prepared statement as parameters
                                        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
                                        // Attempt to execute the prepared statement
                                        if ($stmt->execute()) {
                                            if ($stmt->rowCount() == 1){
                                                if ($row = $stmt->fetch()) {
                                                    // Read files and comparing with what is in the database column of a specific user
                                                    while (($file = readdir($dh)) !== false)
                                                    {
                                                        if($file != '' && $file != '.' && $file != '..'){
                                                            // File path
                                                            $file_path = $folder_name.$file;
    
                                                            //echo $file_path;
    
                                                            if($file == $row["post_thumbnail"])
                                                            {
                                                                // Check its not folder
                                                                if(!is_dir($file_path)){
        
                                                                    $size = filesize($file_path);
        
                                                                    $file_list[] = array('name'=>$file,'size'=>$size,'path'=>$file_path);
        
                                                                }
                                                            }
                                                        }
                                                    }
                                                    closedir($dh);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            echo json_encode($file_list);
                            exit;
                        }   
                    }
                    else{
                        echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '1', 'data' => '']");
                    }
                break;
            case "publishPost":
                If(isset($_POST["postId"]))
                {
                    $post_status = "";
                    $post_id = $sharedComponents->unprotect($_POST["postId"]);

                    $asql = "SELECT * FROM posts WHERE post_id = :post_id";
                    if ($astmt = $pdo->prepare($asql)){
                        // Bind variables to the prepared statement as parameters
                        $astmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
                        // Set parameters
                        $astmt->execute();
                        if ($astmt->rowCount() == 1) {
                            if ($arow = $astmt->fetch()) {
                                $post_status = $arow["post_status"];
                            }
                        }
                    }

                    if($post_status == 2)
                    {
                        $sql = "UPDATE `posts` SET `post_status`= ? WHERE `post_id` = ?";
                                            
                        $stmt = $conn->prepare($sql);
    
                        if($stmt->execute(["1", $post_id]))
                        {
                            echo json_encode( ['response' => true, 'message' => 'Post published Successfully', 'code' => '1', 'data' => '']);
                        }
                    }
                    else
                    {
                        echo json_encode( ['response' => false, 'message' => 'The Post cannot be published, Administator has not approved Post', 'code' => '2', 'data' => '']);
                    }
                }
                break;
            case "deletePost":
                If(isset($_POST["postId"]))
                {
                    $post_id = $sharedComponents->unprotect($_POST["postId"]);

                    $sql = "UPDATE `posts` SET `delete_status`= ? WHERE `post_id` = ?";
                                        
                    $stmt = $conn->prepare($sql);

                    if($stmt->execute(["1", $post_id]))
                    {
                        echo json_encode( ['response' => true, 'message' => 'Post deleted successfully', 'code' => '1', 'data' => '']);
                    }
                    else
                    {
                        echo json_encode( ['response' => false, 'message' => 'Unable to delete Post', 'code' => '0', 'data' => '']);
                    }
                }
                break;
            case "createAd":
                //uploading files into the server
                if(!empty($_FILES))
                {
                    $file_name = $_FILES["file"]["name"];
                    $new_file_name = "user-".date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                    $temp_file = $_FILES['file']['tmp_name'];
                    $location = $folder_name . $new_file_name;
                    if(move_uploaded_file($temp_file, $location))
                    {
                        // PREPARE DATA TO INSERT INTO DB
                        $data = array(
                            "ad_name" => $sharedComponents->test_input($_POST["ad_name"]),
                            "ad_description" => $sharedComponents->test_input($_POST["ad_description"]),
                            "ad_url" => $sharedComponents->test_input($_POST["ad_url"]),
                            "ad_thumbnail" => $sharedComponents->test_input($new_file_name),
                            "ad_target_Country" => $sharedComponents->test_input($_POST["ad_target_Country"]),
                            "ad_duration" => $sharedComponents->test_input($_POST["ad_duration"]),
                            "ad_category" => $sharedComponents->test_input($_POST["ad_category"]),
                            "ad_target_gender" => $sharedComponents->test_input($_POST["ad_target_gender"]),
                            "date_created" => date('Y-m-d H:i:s'),
                        );

                        // Call insert function
                        $resultmsg = json_encode($sharedComponents->insertToDB($conn, "posts", $data));
                        echo $resultmsg;
                    }
                    else
                    {
                        echo json_encode( ['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                    }                        
                }
                
                if(isset($_POST["adName"]))
                {
                    
                    
                }
                break;
            case "updateProfile":
                    //update user profile

                    //uploading files into the server
                    if(!empty($_FILES))
                    {
                        //gets user id
                        $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                        
                        $file_name = $_FILES["file"]["name"];
                        $new_file_name = "user-".date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name
    
                        $old_file_name = "";

                        $asql = "SELECT * FROM user WHERE user_id = :user_id";
                        if ($astmt = $pdo->prepare($asql)){
                            // Bind variables to the prepared statement as parameters
                            $astmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                            // Set parameters
                            $astmt->execute();
                            if ($astmt->rowCount() == 1) {
                                if ($arow = $astmt->fetch()) {
                                    $old_file_name = $arow["profile_pic"];
                                }
                            }
                        }

                        //check if the former file still exsits
                        if($new_file_name == $old_file_name)
                        {
                            //deletes old file
                            unlink($folder_name.$old_file_name);
                        }

                        $temp_file = $_FILES['file']['tmp_name'];
                        $location = $folder_name . $new_file_name;
                        if(move_uploaded_file($temp_file, $location))
                        {
                            try 
                            {
                                if(isset($_POST["password"]))
                                {
                                    $hashPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

                                    $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `password`=?, `profile_pic`=?, `user_country`= ? WHERE `user_id` = ?";
                                    
                                    $stmt = $conn->prepare($sql);

                                    if($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $hashPassword, $new_file_name, $_POST["user_country"], $userId]))
                                    {
                                        echo json_encode( ['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                                    }
                                }
                                else
                                {
                                    $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `profile_pic`=?, `user_country`= ? WHERE `user_id` = ?";
                                    
                                    $stmt = $conn->prepare($sql);

                                    if($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $new_file_name, $_POST["user_country"], $userId]))
                                    {
                                        echo json_encode( ['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                                    }
                                }

                            } catch (PDOException $e) {
                                echo json_encode( ['response' => false, 'message' => 'Unable to update Profile', 'code' => '0', 'data' => $e->getMessage()]);
                            }
                        }
                        else
                        {
                            echo json_encode( ['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                        }                        
                    }
                    else If(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["gender"]) && isset($_POST["user_country"]))
                    {
                        if (isset($_SESSION["macae_blog_user_loggedin_"]))
                        {
                            // validate session value
                            $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                            try 
                            {
                                if(isset($_POST["password"]) && !empty($_POST["password"]))
                                {
                                    $hashPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

                                    $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `password`=?, `user_country`= ? WHERE `user_id` = ?";
                                    
                                    $stmt = $conn->prepare($sql);

                                    if($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $hashPassword, $_POST["user_country"], $userId]))
                                    {
                                        echo json_encode( ['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                                    }
                                }
                                else
                                {
                                    $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `user_country`= ? WHERE `user_id` = ?";
                                    
                                    $stmt = $conn->prepare($sql);

                                    if($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $_POST["user_country"], $userId]))
                                    {
                                        echo json_encode( ['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                                    }
                                }

                            } catch (PDOException $e) {
                                echo json_encode( ['response' => false, 'message' => 'Unable to update Profile', 'code' => '0', 'data' => $e->getMessage()]);
                            }
                        }
                    }
                    // Read files from folder
                    else if(isset($_POST['request']))
                    {
                        $file_list = array();
                        // Target folder
                        $dir = $folder_name;
                        if (is_dir($dir))
                        {
                            if ($dh = opendir($dir))
                            {
                                $sql = "SELECT * FROM user WHERE user_id = :user_id";
                                if ($stmt = $pdo->prepare($sql)) 
                                {
                                    $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                                    // Bind variables to the prepared statement as parameters
                                    $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                                    // Attempt to execute the prepared statement
                                    if ($stmt->execute()) {
                                        if ($stmt->rowCount() == 1){
                                            if ($row = $stmt->fetch()) {
                                                // Read files and comparing with what is in the database column of a specific user
                                                while (($file = readdir($dh)) !== false)
                                                {
                                                    if($file != '' && $file != '.' && $file != '..'){
                                                        // File path
                                                        $file_path = $folder_name.$file;

                                                        //echo $file_path;

                                                        if($file == $row["profile_pic"])
                                                        {
                                                            // Check its not folder
                                                            if(!is_dir($file_path)){
    
                                                                $size = filesize($file_path);
    
                                                                $file_list[] = array('name'=>$file,'size'=>$size,'path'=>$file_path);
    
                                                            }
                                                        }
                                                    }
                                                }
                                                closedir($dh);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo json_encode($file_list);
                        exit;
                    }
                    else
                    {
                        echo json_encode( ['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
                    }
                break;
            
                default:
                    echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '0', 'data' => '']");
        }
    }

?>