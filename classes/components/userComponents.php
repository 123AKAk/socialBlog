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
                            echo json_encode( ['response' => false, 'message' => 'User Already Exist', 'code' => '2', 'data', '']);
                        }
                        else 
                        {
                            // PREPARE DATA TO INSERT INTO DB
                            $data = array(
                                "username" => $sharedComponents->test_input($_POST["username"]),
                                "email" => $sharedComponents->test_input($_POST["email"]),
                                "gender" => $sharedComponents->test_input($_POST["gender"]),
                                "password" => $sharedComponents->test_input($_POST["password"]),
                                "user_ip_address" => $sharedComponents->test_input($_POST["user_ip_address"]),
                                "user_country" => $sharedComponents->test_input($_POST["user_country"])
                            );


                            // Call insert function
                            $resultmsg = json_encode($sharedComponents->insertToDB($conn, "user", $data));

                            //check if data entered the table 
                            $resultmsg2 = json_decode($resultmsg, 1);
                            if (isset($resultmsg2["response"])) 
                            {
                                if ($resultmsg2["response"] == true) 
                                {
                                    $resultmsg2["message"];
                                    
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

                                    $mailResultMsg = $sharedComponents->sendUsersMail($_POST["username"], $subject, $emailMessage, $_POST["email"], $altBody);

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
                        echo json_encode( ['response' => false, 'message' => 'Error executing Query', 'code' => '0', 'data', '']);
                    }
                }
                break;
            case "login":
                echo "2";
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
                echo "9";
                break;
            case "savePost":
                echo "10";
                break;
            case "editPost":
                echo "11";
                break;
            case "publishPost":
                echo "12";
                break;
            case "deletePost":
                echo "13";
                break;
            case "updateProfile":
                echo "14";
                break;
            default:
            echo "['response' => false, 'message' => 'System Processing Error!', 'code' => '1']";
        }
    }

?>