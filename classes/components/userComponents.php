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
            case "savePost":
                echo "10";
                break;
            case "editPost":
                    //deleting file from server
                    if(isset($_POST["name"]))
                    {
                        $filename = $folder_name.$_POST["name"];
                        unlink($filename);
                    }
                    
                    // $result = array();
                    
                    // $files = scandir('upload');
                    
                    // $output = '<div class="row">';
                    
                    // if(false !== $files)
                    // {
                    //     foreach($files as $file)
                    //     {
                    //         if('.' !=  $file && '..' != $file)
                    //         {
                    //             $output .= '
                    //             <div class="col-md-2">
                    //                 <img src="'.$folder_name.$file.'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                    //                 <button type="button" class="btn btn-link remove_image" id="'.$file.'">Remove</button>
                    //             </div>
                    //             ';
                    //         }
                    //     }
                    // }
                    // $output .= '</div>';
                    // echo $output;
                break;
            case "publishPost":
                echo "12";
                break;
            case "deletePost":
                echo "13";
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
                        $file_name = $_FILES["file"]["name"];
                        $new_file_name = "user-".date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name
    
                        $temp_file = $_FILES['file']['tmp_name'];
                        $location = $folder_name . $new_file_name;
                        if(move_uploaded_file($temp_file, $location))
                        {
                            if (isset($_SESSION["macae_blog_user_loggedin_"]))
                            {
                                // validate session value
                                $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                                
                                // $sql = "SELECT * FROM user WHERE user_id = :user_id";
                                // if ($stmt = $pdo->prepare($sql)) 
                                // {
                                //     // Bind variables to the prepared statement as parameters
                                //     $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                                //     // Attempt to execute the prepared statement
                                //     if ($stmt->execute()) {
                                //         // Check if id exists, if yes then verify password
                                //         if ($stmt->rowCount() == 1) {
                                //             if ($row = $stmt->fetch()) {
                                                
                                //             }
                                //         }
                                //     }
                                // }
                                
                                try {
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
                    else if(isset($_POST["deleteFile"]))
                    {
                        $filename = $folder_name.$_POST["deleteFile"];

                        if (file_exists($filename))
                        {
                            $status=unlink($filename);
                            if($status){
                                echo json_encode( ['response' => true, 'message' => 'File Deleted', 'code' => '1', 'data' => '']);
                            }
                            else{  
                                echo json_encode( ['response' => false, 'message' => 'System Processing Error', 'code' => '0', 'data' => '']);
                            }  
                        } else {
                            echo json_encode( ['response' => false, 'message' => 'System Processing Error', 'code' => '0', 'data' => '']);
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
                    echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '1', 'data' => '']");
        }
    }

?>