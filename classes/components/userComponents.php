<?php
    require "db.php";
    require 'sharedComponents.php';
    $sharedComponents = new SharedComponents();

    $dataPurpose = $_GET['dataPurpose'];


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
                    $folder_name = '../../admin/fileUploads/images/';
                    if(!empty($_FILES))
                    {
                        $temp_file = $_FILES['file']['tmp_name'];
                        $location = $folder_name . $_FILES['file']['name'];
                        if(move_uploaded_file($temp_file, $location))
                        {
                            echo json_encode( ['response' => true, 'message' => 'Upload Successful', 'code' => '1', 'data' => $_FILES['file']['name']]);
                        }
                        else
                        {
                            echo json_encode( ['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                        }                        
                    }
                    
                    if(isset($_POST["post_title"]))
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
                                    "post_category" => $sharedComponents->test_input($resultmsg2["data"]),
                                    "post_contents" => $sharedComponents->test_input($_POST["post_contents"]),
                                    "post_thumbnail" => $sharedComponents->test_input($_POST["post_thumbnail"]),
                                    "id_user" => $code
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
            case "updateProfile":
                //update user profile
                    // Upload Image
                    if ($_FILES["arImage"]['error'] === 0) {
                        $picuploadmsg = uploadImage2("arImage", "../img/article/");
                        if($picuploadmsg != 11)
                        {
                            //$_SESSION["adminerra"] = $picuploadmsg;
                            //echo $picuploadmsg;
                            //header("Location: ../admin/update_post.php?id=$urlId");
                        }
                    } else {
                        $imageName = $urlImage;
                    }

                    try {
                        $sql = "UPDATE `article`
                            SET `article_title`= ?, `article_content`= ?,`article_image`=?, `id_categorie`=?, `id_author`= ?
                            WHERE `article_id` = ?";

                        $stmt = $conn->prepare($sql);

                        $stmt->execute([$title, $content, $imageName, $categorie, $author, $urlId]);

                        // echo a message to say the UPDATE succeeded
                        //echo "Article UPDATED successfully";
                        $_SESSION["adminsuc"] = "Post UPDATED successfully";
                        header("Location: ../admin/posts.php", true, 301);
                        exit;
                    } catch (PDOException $e) {
                        //echo $e->getMessage();
                        $_SESSION["adminerra"] = $e->getMessage();
                        header("Location: ../admin/update_post.php?id=$urlId");
                    }
                
                break;
            default:
            echo "['response' => false, 'message' => 'System Processing Error!', 'code' => '1']";
        }
    }

?>