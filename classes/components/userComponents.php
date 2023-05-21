<?php
require "db.php";
require 'sharedComponents.php';
$sharedComponents = new SharedComponents();

$dataPurpose = $_GET['dataPurpose'];

$folder_name = "filesUpload/";
$adfolder_name = "filesUpload/ads/";

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = "https://";
} else {
    $url = "http://";
}
// Append the requested resource location to the URL
//$url.= $_SERVER['REQUEST_URI'];


if ($conn) {
    switch ($dataPurpose) {
        case "signup":
            // Prepare a select statement
            $sql = "SELECT * FROM user WHERE email = :email";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                // Set parameters
                $param_email = trim($_POST["email"]);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Check if username exists, if yes then verify password
                    if ($stmt->rowCount() == 1) {
                        // Display an error message if email exist
                        echo json_encode(['response' => false, 'message' => 'User with that Email Address Already Exist', 'code' => '2', 'data' => '']);
                    } else {
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
                            "code" => $code,
                            "userInfo" => $sharedComponents->test_input($_POST["userInfo"])
                        );


                        // Call insert function
                        $resultmsg = json_encode($sharedComponents->insertToDB($conn, "user", $data));

                        //check if data entered the table 
                        $resultmsg2 = json_decode($resultmsg, 1);
                        if (isset($resultmsg2["response"])) {
                            if ($resultmsg2["response"] == true) {
                                //$resultmsg2["message"];
                                $userid =  $sharedComponents->protect($resultmsg2["data"]);

                                // Append the host(domain name, ip) to the URL.
                                $url .= $_SERVER['HTTP_HOST'] . "/uactivate.php?code=" . $code . "&userid=" . $userid . "";

                                $emailSubject = "Macae Blog Signup Successful";
                                $emailMessage = "
                                        <h3>Thank you for Registering on Macae .</h3>
                                        <p>Your Account Information:</p>
                                        <p>Username: " . $_POST["username"] . "</p>
                                        <p>Email: " . $_POST["email"] . "</p>
                                        <p>Password: " . $_POST["password"] . "</p>
                                        <p>Please click the link below to activate your account.</p>
                                        <a href='" . $url . "'>Activate your Account</a>
                                    ";
                                $altBody = "Macae Blog";

                                $mailResultMsg = $sharedComponents->sendUsersMail($_POST["username"], $emailSubject, $emailMessage, $_POST["email"], $altBody);

                                echo json_encode($mailResultMsg);
                            } else {
                                echo $resultmsg;
                            }
                        } else {
                            echo $resultmsg;
                        }
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Authorisation Failed', 'code' => '0', 'data' => '']);
                }
            }
            break;
        case "login":
            $sql = "SELECT * FROM user WHERE email = :email";
            if ($stmt = $pdo->prepare($sql)) {
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
                            if (password_verify($password, $hashed_password)) {
                                if ($userstatus == 0) {
                                    echo json_encode(['response' => false, 'message' => 'Account has not been Verified, check your email for Verification link', 'code' => '2', 'data' => '']);
                                } else if ($userstatus == 2) {
                                    echo json_encode(['response' => false, 'message' => 'Account has been Banned, Contact the Adminstrator for more details', 'code' => '2', 'data' => '']);
                                } else {
                                    // Store userID in session variables protected
                                    $_SESSION["macae_blog_user_loggedin_"] = $sharedComponents->protect($id);

                                    echo json_encode(['response' => true, 'message' => 'Login Successful', 'code' => '1', 'data' => '']);
                                }
                            } else {
                                echo json_encode(['response' => false, 'message' => 'The password you entered is Invalid', 'code' => '0', 'data' => '']);
                            }
                        }
                    } else {
                        echo json_encode(['response' => false, 'message' => 'No Account found with that Email', 'code' => '0', 'data' => '']);
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Authorisation Failed', 'code' => '0', 'data' => '']);
                }

                // Close statement
                unset($stmt);
                // Close connection
                unset($pdo);
            }
            break;
        case "forgotpassword":
            
            break;
        case "comment":
            if (isset($_POST["postId"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["comment"])) {
                // PREPARE DATA TO INSERT INTO DB
                $data = array(
                    "name" => $sharedComponents->test_input($_POST["name"]),
                    "email" => $sharedComponents->test_input($_POST["email"]),
                    "comment" => $sharedComponents->test_input($_POST["comment"]),
                    "userid" => $sharedComponents->test_input($sharedComponents->unprotect($_POST["userId"])),
                    "postid" => $sharedComponents->test_input($_POST["postId"]),
                    "status" => 1,
                );

                // Call insert function
                $resultmsg = json_encode($sharedComponents->insertToDB($conn, "comments", $data));

                //check if data entered the table 
                $resultmsg2 = json_decode($resultmsg, 1);
                if (isset($resultmsg2["response"]) && $resultmsg2["response"] == true) {
                    echo json_encode(['response' => true, 'message' => 'Added comment Successfully', 'code' => '1', 'data' => '']);
                } else {
                    echo json_encode(['response' => false, 'message' => 'Unable to add comment, an error occured', 'code' => '0', 'data' => '']);
                }
            } else {
                echo json_encode(['response' => false, 'message' => 'Fill all fields', 'code' => '0', 'data' => '']);
            }
            break;
        case "postDetails":
            if (!empty($_POST["postId"]) && !empty($_POST['userId']) && !empty($_POST['action'])) {
                
                $postId = $sharedComponents->unprotect($_POST['postId']);
                $userId = $sharedComponents->unprotect($_POST['userId']);
                $action = $_POST['action'];

                $data = array(
                    "likes" => 0,
                    "dislikes" => 0
                );

                try {
                    // Check if the user has already performed the action for the post
                    $stmt = $conn->prepare("SELECT * FROM postDetails WHERE postId = :postId AND userId = :userId");
                    $stmt->bindParam(':postId', $postId);
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                    $existingPost = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($existingPost) {
                        // User has already performed an action, handle accordingly
                        if ($action == 'like') {
                            // User wants to like the post
                            if ($existingPost['dislikes'] == 1) {
                                // User had previously disliked, so set dislikes to 0 and set likes to 1
                                $stmt = $conn->prepare("UPDATE postDetails SET dislikes = 0, likes = 1 WHERE postId = :postId AND userId = :userId");

                                $data["dislikes"] = 0;
                                $data["likes"] = 1;
                            } else {
                                if ($existingPost['likes'] == 1) {
                                    // User had previously liked, so set likes to 0
                                    $stmt = $conn->prepare("UPDATE postDetails SET likes = 0 WHERE postId = :postId AND userId = :userId");

                                    $data["dislikes"] = 0;
                                    $data["likes"] = 0;
                                }
                                else
                                {
                                    $stmt = $conn->prepare("UPDATE postDetails SET likes = 1 WHERE postId = :postId AND userId = :userId");

                                    $data["dislikes"] = 0;
                                    $data["likes"] = 1;
                                }
                            }
                        } else if ($action == 'dislike') {
                            // User wants to dislike the post
                            if ($existingPost['likes'] == 1) {
                                // User had previously liked, so set likes to 0 and set dislikes to 1
                                $stmt = $conn->prepare("UPDATE postDetails SET likes = 0, dislikes = 1 WHERE postId = :postId AND userId = :userId");

                                $data["dislikes"] = 1;
                                $data["likes"] = 0;
                            } else {
                                if ($existingPost['dislikes'] == 1) {
                                    // User had previously disliked, so set dislikes to 0
                                    $stmt = $conn->prepare("UPDATE postDetails SET dislikes = 0 WHERE postId = :postId AND userId = :userId");

                                    $data["dislikes"] = 0;
                                    $data["likes"] = 0;
                                }
                                else
                                {
                                    $stmt = $conn->prepare("UPDATE postDetails SET dislikes = 1 WHERE postId = :postId AND userId = :userId");

                                    $data["dislikes"] = 1;
                                    $data["likes"] = 0;
                                }
                            }
                        } else if ($action == 'view' && $existingPost['views'] == 0) {
                            // User wants to update the view action
                            $stmt = $conn->prepare("UPDATE postDetails SET views = 1 WHERE postId = :postId AND userId = :userId");
                        }
                        
                        $stmt->bindParam(':postId', $postId);
                        $stmt->bindParam(':userId', $userId);
                        $stmt->execute();
                        
                        echo json_encode(['response' => true, 'message' => 'Post details updated successfully', 'code' => '1', 'data' => json_encode($data)]);
                    } else {
                        // Insert a new row for the post and user
                        if ($action == 'like') {
                            $stmt = $conn->prepare("INSERT INTO postDetails (postId, userId, likes) VALUES (:postId, :userId, 1)");

                            $data["dislikes"] = 0;
                            $data["likes"] = 1;
                        } else if ($action == 'dislike') {
                            $stmt = $conn->prepare("INSERT INTO postDetails (postId, userId, dislikes) VALUES (:postId, :userId, 1)");

                            $data["dislikes"] = 1;
                            $data["likes"] = 0;
                        } else if ($action == 'view') {
                            $stmt = $conn->prepare("INSERT INTO postDetails (postId, userId, views) VALUES (:postId, :userId, 1)");
                        }

                        $stmt->bindParam(':postId', $postId);
                        $stmt->bindParam(':userId', $userId);
                        $stmt->execute();
                        
                        echo json_encode(['response' => true, 'message' => 'Success Post Details Updated', 'code' => '1', 'data' => json_encode($data)]);
                    }
                } catch (PDOException $e) {
                    echo json_encode(['response' => false, 'message' => 'Error updating post details: '.$e->getMessage(), 'code' => '0', 'data' => json_encode($data)]);
                }
            } else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
            }
            break;
        case "bookmark_unbookmark_Post":
            if (isset($_POST["postId"]) && isset($_POST['userId']) && isset($_POST['action'])) {

                $postId = $sharedComponents->unprotect($_POST['postId']);
                $userId = $sharedComponents->unprotect($_POST['userId']);
                // Action to perform: add or remove
                $action = $_POST['action'];

                $data = 0;

                try {

                    // Retrieve the current saved_posts value for the user from the database
                    $stmt = $conn->prepare("SELECT saved_posts FROM user WHERE user_id = :user_id");
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $saved_posts = $row['saved_posts'];
                    
                    // Convert the retrieved saved_posts string to an array using json_decode
                    $post_ids = $saved_posts ? json_decode($saved_posts, true) : [];
                    
                    // Check if the post ID is already present in the array
                    $index = array_search($postId, $post_ids);
                    
                    if ($action === 'add') {
                        // Add the post ID if it's not already present
                        if ($index === false) {
                            array_push($post_ids, $postId);
                            //$post_ids[] = $postId;

                            $data = 1;
                        }
                    } else if ($action === 'remove') {
                        // Remove the post ID if it's present in the array
                        if ($index !== false) {
                            unset($post_ids[$index]);

                            $data = 0;
                        }
                    }
                    
                    // Convert the modified array back to a JSON string
                    $saved_posts = json_encode($post_ids);
                    
                    // Update the saved_posts column for the user in the database
                    $stmt = $conn->prepare("UPDATE user SET saved_posts = :saved_posts WHERE user_id = :user_id");
                    $stmt->bindParam(':saved_posts', $saved_posts, PDO::PARAM_STR);
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->execute();

                    echo json_encode(['response' => true, 'message' => 'Success, Saved Post Updated', 'code' => '1', 'data' => $data]);

                } catch (PDOException $e) {
                    echo json_encode(['response' => false, 'message' => 'Error updating saved posts: '.$e->getMessage(), 'code' => '0', 'data' => json_encode($data)]);
                }
            }
            else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => 0]);
            }
            break;
        case "follow_unfollow_Author":
            if (isset($_POST["authorId"]) && isset($_POST['authorType']) && isset($_POST['userId']) && isset($_POST['action'])) {

                $authorId = $sharedComponents->unprotect($_POST['authorId']);
                $userId = $sharedComponents->unprotect($_POST['userId']);
                $authorType = $_POST['authorType'];
                $action = $_POST['action'];

                $data = 0;

                try {

                    // Retrieve the current authors_followed value for the user from the database
                    $stmt = $conn->prepare("SELECT authors_followed FROM user WHERE user_id = :user_id");
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $authors_followed = $row['authors_followed'];
                    
                    // Convert the retrieved authors_followed string to an array using json_decode
                    $allAuthors_followed = $authors_followed ? json_decode($authors_followed, true) : [];
                    
                    // Check if the author ID is already present in the array
                    //$index = array_search($authorId, $allAuthors_followed);
                    $index = null;
                    // Loop through the post IDs array and find the index of the ID and type combination
                    foreach ($allAuthors_followed as $key => $author) {
                        if ($author['id'] === $authorId && $author['type'] === $authorType) {
                            $index = $key;
                            break;
                        }
                    }
                    
                    if ($action === 'add') {
                        // Add the author ID if it's not already present
                        if ($index == null) {
                            $authorArr = array(
                                'id' => $authorId,
                                'type' => $authorType
                            );
                            array_push($allAuthors_followed, $authorArr);
                            //$allAuthors_followed[] = $authorId;

                            $data = 1;
                        }
                    } else if ($action === 'remove') {
                        // Remove the author ID if it's present in the array
                        if ($index !== null) {
                            unset($allAuthors_followed[$index]);

                            $allAuthors_followed = array_values($allAuthors_followed);

                            $data = 0;
                        }
                    }
                    
                    // Convert the modified array back to a JSON string
                    $authors_followed = json_encode($allAuthors_followed);
                    
                    // Update the authors_followed column for the user in the database
                    $stmt = $conn->prepare("UPDATE user SET authors_followed = :authors_followed WHERE user_id = :user_id");
                    $stmt->bindParam(':authors_followed', $authors_followed, PDO::PARAM_STR);
                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->execute();

                    echo json_encode(['response' => true, 'message' => 'Success, followed Authors Updated', 'code' => '1', 'data' => $data]);

                } catch (PDOException $e) {
                    echo json_encode(['response' => false, 'message' => 'Error updating followed Authors: '.$e->getMessage(), 'code' => '0', 'data' => json_encode($data)]);
                }
            }
            else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => 0]);
            }
            break;
        case "createPost":
            //uploading files into the server
            if (!empty($_FILES) && isset($_POST["post_contents"]) && isset($_POST["post_title"]) && isset($_POST["post_category"]) && isset($_POST["post_country"])) {
                $file_name = $_FILES["file"]["name"];
                $new_file_name = "user-" . date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                $temp_file = $_FILES['file']['tmp_name'];
                $location = $folder_name . $new_file_name;
                if (move_uploaded_file($temp_file, $location)) {
                    // Call check - Insert Category function
                    $resultmsg = json_encode($sharedComponents->checkInsertCategory($conn, $_POST["post_category"]));

                    //check if data entered the table 
                    $resultmsg2 = json_decode($resultmsg, 1);
                    if (isset($resultmsg2["response"])) {
                        if ($resultmsg2["response"] == true) {
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
                        } else {
                            echo $resultmsg;
                        }
                    } else {
                        echo $resultmsg;
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                }
            }
            break;
        case "editPost":
            if (isset($_POST["postId"]) && !isset($_POST["post_title"])) {
                $post_id = $sharedComponents->unprotect($_POST["postId"]);

                $asql = "SELECT * FROM posts WHERE post_id = :post_id";
                if ($astmt = $pdo->prepare($asql)) {
                    // Bind variables to the prepared statement as parameters
                    $astmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
                    // Set parameters
                    $astmt->execute();
                    if ($astmt->rowCount() == 1) {
                        if ($post = $astmt->fetch()) {

                            $postID = $_POST["postId"];

                            $postThumbnail = $post['post_thumbnail'];
                            $postTitle = $post['post_title'];
                            $postCountry = $post['post_country'];
                            $postContents = htmlspecialchars_decode($post['post_contents']);
                            //$postContents = htmlspecialchars($post['post_contents'], ENT_QUOTES, 'UTF-8');
                            $postCategory = "";
                            $resultmsg = json_encode($sharedComponents->getCategoryName($pdo, $post['id_category']));
                            $resultmsg = json_decode($resultmsg, 1);
                            if (isset($resultmsg["response"])) {
                                if ($resultmsg["response"] == true) {
                                    $postCategory = $resultmsg["data"];
                                } else {
                                    echo json_encode(['response' => false, 'message' => 'Unsuccessfull', 'code' => '0', 'data' => '']);
                                }
                            } else {
                                echo json_encode(['response' => false, 'message' => 'Unsuccessfull', 'code' => '0', 'data' => '']);
                            }

                            $allPost = [];
                            $postJson = new stdClass();
                            $postJson->postThumbnail = $postThumbnail;
                            $postJson->postID = $_POST["postId"];
                            $postJson->postTitle = $postTitle;
                            $postJson->postCountry = $postCountry;
                            $postJson->postContents = $postContents;
                            $postJson->postCategory = $postCategory;

                            array_push($allPost, $postJson);
                            echo json_encode($postJson);
                            // echo json_encode( ['response' => true, 'message' => 'Successful', 'code' => '1', 'data' => $postJson]);
                        } else {
                            echo json_encode(['response' => false, 'message' => 'Unsuccessfull', 'code' => '0', 'data' => '']);
                        }
                    } else {
                        echo json_encode(['response' => false, 'message' => 'Unsuccessfull', 'code' => '0', 'data' => '']);
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Unsuccessfull', 'code' => '0', 'data' => '']);
                }
            } else if (!empty($_FILES)) {
                if (isset($_POST["postId"])) {
                    //gets post id
                    $postId = $sharedComponents->unprotect($_POST["postId"]);

                    $file_name = $_FILES["file"]["name"];
                    $new_file_name = "user-" . date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                    $old_file_name = "";

                    $asql = "SELECT * FROM posts WHERE post_id = :post_id";
                    if ($astmt = $pdo->prepare($asql)) {
                        // Bind variables to the prepared statement as parameters
                        $astmt->bindParam(":post_id", $postId, PDO::PARAM_STR);
                        // Set parameters
                        $astmt->execute();
                        if ($astmt->rowCount() == 1) {
                            if ($arow = $astmt->fetch()) {
                                $old_file_name = $arow["post_thumbnail"];
                            }
                        }
                    }

                    //check if the former file still exsits
                    if ($new_file_name == $old_file_name) {
                        //deletes old file
                        unlink($folder_name . $old_file_name);
                    }

                    $temp_file = $_FILES['file']['tmp_name'];
                    $location = $folder_name . $new_file_name;
                    if (move_uploaded_file($temp_file, $location)) {
                        try {
                            // Call check - Insert Category function
                            $resultmsg = json_encode($sharedComponents->checkInsertCategory($conn, $_POST["post_category"]));
                            //check if data entered the table 
                            $resultmsg2 = json_decode($resultmsg, 1);
                            if (isset($resultmsg2["response"])) {
                                if ($resultmsg2["response"] == true) {

                                    $sql = "UPDATE `posts` SET `post_title`= ?, `post_contents`= ?,`post_country`=?, `post_thumbnail`=?, `id_category`= ? WHERE `post_id` = ?";

                                    $stmt = $conn->prepare($sql);

                                    if ($stmt->execute([$_POST["post_title"], $_POST["post_contents"], $_POST["post_country"], $new_file_name, $resultmsg2["data"], $postId])) {
                                        echo json_encode(['response' => true, 'message' => 'Post update Successful', 'code' => '1', 'data' => '']);
                                    }
                                } else {
                                    echo $resultmsg;
                                }
                            } else {
                                echo $resultmsg;
                            }
                        } catch (PDOException $e) {
                            echo json_encode(['response' => false, 'message' => 'Unable to update Post', 'code' => '0', 'data' => $e->getMessage()]);
                        }
                    } else {
                        echo json_encode(['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
                }
            } else if (isset($_POST["postId"]) && isset($_POST["post_contents"]) && isset($_POST["post_title"]) && isset($_POST["post_category"]) && isset($_POST["post_country"])) {
                try {
                    //gets post id
                    $postId = $sharedComponents->unprotect($_POST["postId"]);

                    // Call check - Insert Category function
                    $resultmsg = json_encode($sharedComponents->checkInsertCategory($conn, $_POST["post_category"]));
                    //check if data entered the table 
                    $resultmsg2 = json_decode($resultmsg, 1);
                    if (isset($resultmsg2["response"])) {
                        if ($resultmsg2["response"] == true) {

                            $sql = "UPDATE `posts` SET `post_title`= ?, `post_contents`= ?,`post_country`=?, `id_category`= ? WHERE `post_id` = ?";

                            $stmt = $conn->prepare($sql);

                            if ($stmt->execute([$_POST["post_title"], $_POST["post_contents"], $_POST["post_country"], $resultmsg2["data"], $postId])) {
                                echo json_encode(['response' => true, 'message' => 'Post update Successful', 'code' => '1', 'data' => '']);
                            }
                        } else {
                            echo $resultmsg;
                        }
                    } else {
                        echo $resultmsg;
                    }
                } catch (PDOException $e) {
                    echo json_encode(['response' => false, 'message' => 'Unable to update Post', 'code' => '0', 'data' => $e->getMessage()]);
                }
            }
            // Read files from folder
            else if (isset($_POST['request'])) {
                if (isset($_POST["filepostId"])) {
                    $file_list = array();
                    // Target folder
                    $dir = $folder_name;
                    if (is_dir($dir)) {
                        if ($dh = opendir($dir)) {
                            $post_id = $sharedComponents->unprotect($_POST["filepostId"]);

                            $sql = "SELECT * FROM posts WHERE post_id = :post_id";
                            if ($stmt = $pdo->prepare($sql)) {
                                // Bind variables to the prepared statement as parameters
                                $stmt->bindParam(":post_id", $post_id, PDO::PARAM_STR);
                                // Attempt to execute the prepared statement
                                if ($stmt->execute()) {
                                    if ($stmt->rowCount() == 1) {
                                        if ($row = $stmt->fetch()) {
                                            // Read files and comparing with what is in the database column of a specific user
                                            while (($file = readdir($dh)) !== false) {
                                                if ($file != '' && $file != '.' && $file != '..') {
                                                    // File path
                                                    $file_path = $folder_name . $file;

                                                    //echo $file_path;

                                                    if ($file == $row["post_thumbnail"]) {
                                                        // Check its not folder
                                                        if (!is_dir($file_path)) {

                                                            $size = filesize($file_path);

                                                            $file_list[] = array('name' => $file, 'size' => $size, 'path' => $file_path);
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
            } else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
            }
            break;
        case "publishPost":
            if (isset($_POST["postId"])) {
                $post_status = "";
                $post_id = $sharedComponents->unprotect($_POST["postId"]);

                $asql = "SELECT * FROM posts WHERE post_id = :post_id";
                if ($astmt = $pdo->prepare($asql)) {
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

                if ($post_status == 2) {
                    $sql = "UPDATE `posts` SET `post_status`= ? WHERE `post_id` = ?";

                    $stmt = $conn->prepare($sql);

                    if ($stmt->execute(["1", $post_id])) {
                        echo json_encode(['response' => true, 'message' => 'Post published Successfully', 'code' => '1', 'data' => '']);
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'The Post cannot be published, Administator has not approved Post', 'code' => '2', 'data' => '']);
                }
            }
            break;
        case "deletePost":
            if (isset($_POST["postId"])) {
                $post_id = $sharedComponents->unprotect($_POST["postId"]);

                $sql = "UPDATE `posts` SET `delete_status`= ? WHERE `post_id` = ?";

                $stmt = $conn->prepare($sql);

                if ($stmt->execute(["1", $post_id])) {
                    echo json_encode(['response' => true, 'message' => 'Post deleted successfully', 'code' => '1', 'data' => '']);
                } else {
                    echo json_encode(['response' => false, 'message' => 'Unable to delete Post', 'code' => '0', 'data' => '']);
                }
            }
            break;
        case "createAd":
            //uploading files into the server
            if (!empty($_FILES)) {
                $file_name = $_FILES["file"]["name"];
                $new_file_name = "user-" . date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                $temp_file = $_FILES['file']['tmp_name'];
                $location = $folder_name . $new_file_name;
                if (move_uploaded_file($temp_file, $location)) {
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
                } else {
                    echo json_encode(['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                }
            }

            if (isset($_POST["adName"])) {
            }
            break;
        case "editAd":
            break;
        case "publishAd":
            break;
        case "deleteAd":
            break;
        case "updateProfile":
            //uploading files into the server
            if (!empty($_FILES)) {
                //gets user id
                $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);

                $file_name = $_FILES["file"]["name"];
                $new_file_name = "user-" . date('Y-m-d H-i-s') . "." . pathinfo($file_name, PATHINFO_EXTENSION); // Set the new file name

                $old_file_name = "";

                $asql = "SELECT * FROM user WHERE user_id = :user_id";
                if ($astmt = $pdo->prepare($asql)) {
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
                if ($new_file_name == $old_file_name) {
                    //deletes old file
                    unlink($folder_name . $old_file_name);
                }

                $temp_file = $_FILES['file']['tmp_name'];
                $location = $folder_name . $new_file_name;
                if (move_uploaded_file($temp_file, $location)) {
                    try {
                        if (isset($_POST["password"])) {
                            $hashPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

                            $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `password`=?, `profile_pic`=?, `user_country`= ? WHERE `user_id` = ?";

                            $stmt = $conn->prepare($sql);

                            if ($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $hashPassword, $new_file_name, $_POST["user_country"], $userId])) {
                                echo json_encode(['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                            }
                        } else {
                            $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `profile_pic`=?, `user_country`= ? WHERE `user_id` = ?";

                            $stmt = $conn->prepare($sql);

                            if ($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $new_file_name, $_POST["user_country"], $userId])) {
                                echo json_encode(['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                            }
                        }
                    } catch (PDOException $e) {
                        echo json_encode(['response' => false, 'message' => 'Unable to update Profile', 'code' => '0', 'data' => $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['response' => false, 'message' => 'Upload was not Successful', 'code' => '0', 'data' => '']);
                }
            } else if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["gender"]) && isset($_POST["user_country"])) {
                // validate session value
                $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                try {
                    if (isset($_POST["password"]) && !empty($_POST["password"])) {
                        $hashPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

                        $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `password`=?, `user_country`= ? WHERE `user_id` = ?";

                        $stmt = $conn->prepare($sql);

                        if ($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $hashPassword, $_POST["user_country"], $userId])) {
                            echo json_encode(['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                        }
                    } else {
                        $sql = "UPDATE `user` SET `username`= ?, `email`= ?,`gender`=?, `user_country`= ? WHERE `user_id` = ?";

                        $stmt = $conn->prepare($sql);

                        if ($stmt->execute([$_POST["username"], $_POST["email"], $_POST["gender"], $_POST["user_country"], $userId])) {
                            echo json_encode(['response' => true, 'message' => 'Profile update Successful', 'code' => '1', 'data' => '']);
                        }
                    }
                } catch (PDOException $e) {
                    echo json_encode(['response' => false, 'message' => 'Unable to update Profile', 'code' => '0', 'data' => $e->getMessage()]);
                }
            }
            // Read files from folder
            else if (isset($_POST['request'])) {
                $file_list = array();
                // Target folder
                $dir = $folder_name;
                if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                        $sql = "SELECT * FROM user WHERE user_id = :user_id";
                        if ($stmt = $pdo->prepare($sql)) {
                            $userId = $sharedComponents->unprotect($_SESSION["macae_blog_user_loggedin_"]);
                            // Bind variables to the prepared statement as parameters
                            $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                            // Attempt to execute the prepared statement
                            if ($stmt->execute()) {
                                if ($stmt->rowCount() == 1) {
                                    if ($row = $stmt->fetch()) {
                                        // Read files and comparing with what is in the database column of a specific user
                                        while (($file = readdir($dh)) !== false) {
                                            if ($file != '' && $file != '.' && $file != '..') {
                                                // File path
                                                $file_path = $folder_name . $file;

                                                //echo $file_path;

                                                if ($file == $row["profile_pic"]) {
                                                    // Check its not folder
                                                    if (!is_dir($file_path)) {

                                                        $size = filesize($file_path);

                                                        $file_list[] = array('name' => $file, 'size' => $size, 'path' => $file_path);
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
            } else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
            }
            break;
        case "loadData":
            if (isset($_POST["dataType"])) {
                $dataType = $_POST["dataType"];
                $userCountry = $_POST["userCountry"];

                $picturesfolder_name = "classes/components/filesUpload/";

                $noOfPostToDisplayAds = $sharedComponents->getNoOfPostToDisplayAds($pdo);

                if ($dataType == "slider") {
                    $limitSize = $sharedComponents->getLimitSize($conn);

                    $slider = "";
                    $sliderControls = "";

                    $a = $limitSize[1]; // first variable
                    $b = $limitSize[0]; // second variable

                    $sum = $a + $b; // add the two variables together

                    if ($sum > 4) { // check if the sum is greater than 4
                        $diff = $sum - 4; // calculate the difference between the sum and 4
                        $b = $b - $diff; // subtract the difference from the second variable
                    }

                    $a = 4 - $b; // calculate the value of the first variable based on the output of the second variable

                    if ($b < 0) {
                        $b = 0;
                    }

                    $adstmtb = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(1, ad_position) > 0 AND trans_reference!='' ORDER BY RAND() LIMIT $a");
                    $adstmtb->execute();
                    $ads = $adstmtb->fetchAll();

                    if (isset($ads)) {
                        foreach ($ads as $ad) :
                            $adImage = $sharedComponents->checkFile2($ad["ad_thumbnail"]) == 0 ? "noimage.jpg" : $adfolder_name . $ad["ad_thumbnail"];

                            $slider .= '
                                        <div class="swiper-slide slider-item" style="background-image: url(' . $adImage . ');">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xl-7 col-lg-9 col-md-12">
                                                        <div class="slider-item-inner">
                                                            <div class="slider-item-content">
                                                            <div class="entry-cat ">
                                                                <a class="categorie">
                                                                    Sponsored Post
                                                                </a>
                                                            </div>
                                                            <h1 class="entry-title">
                                                                <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">' .
                                $ad["ad_name"]
                                . '</a>
                                                            </h1>
                                                            <div class="post-exerpt">
                                                                <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                                    <p>' . $ad["ad_desc"] . '</p>
                                                                </a>
                                                            </div>
                                                            <ul class="entry-meta list-inline">
                                                                
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';

                            $sliderControls .= '
                                        <div class="swiper-slide">
                                            <div class="post-item">
                                                <img src="' . $adImage . '" alt="">
                                                <div class="details">
                                                    <p class="entry-title"> 
                                                        <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                            <span>' .
                                $ad["ad_name"]
                                . '</span>
                                                        </a>
                                                    </p>
                                                    <ul class="entry-meta list-inline">
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                        endforeach;
                    }

                    // Get lastest post show on slider part of page
                    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=2 AND delete_status=0 AND post_country='$userCountry' ORDER BY RAND() LIMIT $b");
                    $stmt->execute();
                    $lastestPostFirst = $stmt->fetchAll();

                    if (isset($lastestPostFirst)) {
                        foreach ($lastestPostFirst as $post) :
                            $postId = $sharedComponents->protect($post['post_id']);
                            $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                            $authId = $adminUserDetails["id"];
                            $authEmail = $adminUserDetails["email"];
                            $authName = $adminUserDetails["username"];
                            $authGender = $adminUserDetails["gender"];
                            $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $picturesfolder_name . $adminUserDetails["profile_pic"];
                            $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];

                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? 'noimage.jpg' : $picturesfolder_name . $post['post_thumbnail'];

                            $apostImage = "'$postImage'";

                            $commentResults = $sharedComponents->checkComments($post['post_id'], $conn);

                            $slider .= '
                                        <div class="swiper-slide slider-item" style="background-image: url(' . $apostImage . ');">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xl-7 col-lg-9 col-md-12">
                                                        <div class="slider-item-inner">
                                                            <div class="slider-item-content">
                                                            <div class="entry-cat ">
                                                                <a class="categorie" href="category.php?dt=' . $post["category_name"] . '&catid=' . $post["category_id"] . '">' .
                                $post["category_name"]
                                . '</a>
                                                            </div>
                                                            <h1 class="entry-title">
                                                                <a href="post.php?dt=' . $post["post_title"] . '&id=' . $postId . '">' .
                                $post["post_title"]
                                . '</a>
                                                            </h1>
                                                            <div class="post-exerpt">
                                                                <p>' . $sharedComponents->convertHtmltoText($post["post_contents"], 25, "", "") . '</p>
                                                            </div>
                                                            <ul class="entry-meta list-inline">
                                                                <li class="post-author-img">
                                                                    <a href="' . $authLink . '">
                                                                        <img src="' . $authProfilePic . '" alt="">
                                                                    </a>
                                                                </li>
                                                                <li class="post-author">
                                                                    <a href="' . $authLink . '">' .
                                $authName
                                . '</a>
                                                                </li>
                                                                <li class="post-date"> <span class="dot"></span>' .
                                date_format(date_create($post['post_creation_time']), "F d, Y")
                                . '</li>
                                                                <li class="post-comment">
                                                                    <span class="dot"></span>' . $commentResults["numberofRows"] . " comments"
                                . '</li>
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ';

                            $sliderControls .= '
                                        <div class="swiper-slide">
                                            <div class="post-item">
                                                <img src="' . $postImage . '" alt="">
                                                <div class="details">
                                                    <p class="entry-title"> 
                                                    <span>' .
                                $post['post_title']
                                . '</span>
                                                    </p>
                                                    <ul class="entry-meta list-inline">
                                                        <li class="post-date"> <i class="fas fa-clock"></i>' .
                                date_format(date_create($post['post_creation_time']), "F d, Y")
                                . '</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                        endforeach;
                    }

                    if (isset($slider)) {
                        $postJson = new stdClass();
                        $postJson->slider = $slider;
                        $postJson->sliderControls = $sliderControls . '<script src="assets/js/swiper.min.js"></script><script src="assets/js/main.js"></script>';

                        echo json_encode($postJson);
                    } else {
                        echo 0;
                    }
                } else if ($dataType == "bodyPost1") {
                    $limitdt1 = $_POST["limitdt1"];
                    $limitdt2 = $_POST["limitdt2"];

                    // Get lastest post show on second section of page
                    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 AND post_country='$userCountry' ORDER BY `post_id` DESC LIMIT $limitdt1,$limitdt2");
                    $stmt->execute();
                    $lastestPostSecond = $stmt->fetchAll();

                    $blogPost1 = "";

                    $count = 0;
                    if (isset($lastestPostSecond)) {
                        foreach ($lastestPostSecond as $post) :

                            $count++;

                            $postId = $sharedComponents->protect($post['post_id']);
                            $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                            $authId = $adminUserDetails["id"];
                            $authEmail = $adminUserDetails["email"];
                            $authName = $adminUserDetails["username"];
                            $authGender = $adminUserDetails["gender"];
                            $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $picturesfolder_name . $adminUserDetails["profile_pic"];
                            $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];

                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $picturesfolder_name . $post['post_thumbnail'];

                            // Count the number of words in the text
                            $num_words = str_word_count($sharedComponents->convertHtmltoText($post['post_contents'], 25, '', ''));

                            // Assume an average reading speed of 200 words per minute
                            $avg_speed = 200;
                            // Calculate the estimated reading time in minutes
                            $reading_time = ceil($num_words / $avg_speed);


                            if (($count - 2) % $noOfPostToDisplayAds[0] == 0) {
                                $adstmt = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(2, ad_position) > 0 AND trans_reference!='' ORDER BY ad_id DESC");
                                $adstmt->execute();
                                $total_rows = $adstmt->rowCount();

                                // Generate a random number between 0 and the total number of rows
                                $random_number = rand(0, $total_rows - 1);

                                if ($total_rows > 0) {
                                    $adstmtb = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(2, ad_position) > 0 AND trans_reference!='' ORDER BY ad_id DESC LIMIT $random_number, 1");
                                    $adstmtb->execute();
                                    $ad = $adstmtb->fetch();

                                    if ($adstmtb->rowCount() > 0) {
                                        $adImage = $sharedComponents->checkFile2($ad["ad_thumbnail"]) == 0 ? "noimage.jpg" : $adfolder_name . $ad["ad_thumbnail"];

                                        $blogPost1 .= '
                                                <div class="post-list">
                                                    <div class="post-list-image">
                                                        <div class="image-box">
                                                            <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                                <img src="' . $adImage . '" class="img-fluid " alt="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="post-list-content">
                                                        <div class="entry-cat">
                                                            <a class="categorie" >Sponsored Post</a>
                                                        </div>
                                                        <h4 class="entry-title">
                                                            <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">' .
                                            $ad["ad_name"]
                                            . '</a>
                                                        </h4>
                                                        <div class="post-exerpt">
                                                            <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                                <p class="myText">' . $ad["ad_desc"] . '</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>
                                            ';
                                    }
                                }
                            }

                            $blogPost1 .= '
                                    <div class="post-list">
                                        <div class="post-list-image">
                                            <div class="image-box">
                                                <a href="post.php?dt=' . $post['post_title'] . '&id=' . $postId . '">
                                                    <img src="' . $postImage . '" class="img-fluid " alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="post-list-content">
                                            <div class="entry-cat">
                                                <a class="categorie" href="category.php?dt=' . $post['category_name'] . '&catid=' . $post['category_id'] . '">' .
                                $post['category_name']
                                . '</a>
                                            </div>
                                            <h4 class="entry-title">
                                                <a href="post.php?dt=' . $post['post_title'] . '&id=' . $postId . '">' .
                                $post['post_title']
                                . '</a>
                                            </h4>
                                            <div class="post-exerpt">
                                                <p class="myText">' . $sharedComponents->convertHtmltoText($post['post_contents'], 25, '', '') . '</p>
                                            </div>
                                            <ul class="entry-meta list-inline">
                                                <li class="post-author-img">
                                                    <a href="' . $authLink . '">
                                                        <img src="' . $authProfilePic . '" alt="">
                                                    </a>
                                                </li>
                                                <li class="post-author">
                                                    <a href="' . $authLink . '">' .
                                $authName
                                . '</a> 
                                                </li>
                                                <li class="post-date"> <span class="dot"></span>' .
                                date_format(date_create($post["post_creation_time"]), "F d, Y")
                                . '</li>
                                                <li class="post-timeread"> <span class="dot"></span>' .
                                $reading_time . ' min Read
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                ';

                        endforeach;
                    }
                    if (isset($blogPost1))
                        echo $blogPost1;
                    else
                        echo 0;
                } else if ($dataType == "sidebar") {
                    $aabout = $apopularPost = $acategories = $apopularAuthors = $arandomAds = "";

                    // Get About Info
                    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE admin_id=1");
                    $stmt->execute();
                    $about = $stmt->fetch();

                    if (isset($about)) {
                        $aboutImage = $sharedComponents->checkFile($about['profile_pic']) == 0 ? "noimage.jpg" : $picturesfolder_name . $about['profile_pic'];

                        $aabout .= '
                                    <div class="widget-author">
                                        <div class="author-img">
                                            <a href="author.php?authDType=Admin&authd=' . $about['admin_id'] . '" class="image">
                                                <img src="' . $aboutImage . '" alt="">
                                            </a>
                                        </div>
                                        <div class="author-content">
                                            <h6 class="name"> Hi, I am ' . $about['admin_name'] . '</h6>
                                            <p class="bio">' .
                            $about['admin_desc']
                            . '</p>
                                        </div>
                                    </div>
                                ';
                    }

                    //Get popular Post
                    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id INNER JOIN postdetails ON post_id=postid WHERE post_status=1 AND delete_status=0  AND post_country='$userCountry' ORDER BY `views` DESC LIMIT 5");
                    $stmt->execute();
                    $most_read_posts = $stmt->fetchAll();

                    if (isset($most_read_posts)) {
                        foreach ($most_read_posts as $post) :

                            $views = !isset($post["views"]) ? 0 : $post["views"];
                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $picturesfolder_name . $post['post_thumbnail'];

                            $apopularPost .= '
                                    <li class="post-item">
                                        <div class="image">
                                            <a href="post.php?dt=' . $post["post_title"] . '&id=' . $sharedComponents->protect($post["post_id"]) . '"> <img src="' . $postImage . '" alt="..."></a>
                                        </div>
                                        <div class="count">' . $views . '</div>
                                        <div class="content">
                                            <p class="entry-title">
                                                <a href="post.php?dt=' . $post["post_title"] . '&id=' . $sharedComponents->protect($post["post_id"]) . '">' .
                                $post["post_title"]
                                . '</a>
                                            </p>
                                            <small class="post-date"><i class="fas fa-clock"></i>' .
                                date_format(date_create($post["post_creation_time"]), "F d, Y")
                                . '</small>
                                        </div>
                                    </li>
                                ';
                        endforeach;
                    }

                    // Get Categories
                    $stmt = $conn->prepare("SELECT *,COUNT(*) as post_count FROM `posts` INNER JOIN category ON category_id=id_category GROUP BY category_id DESC");
                    $stmt->execute();
                    $categories = $stmt->fetchAll();

                    if (isset($categories)) {
                        foreach ($categories as $category) :

                            $catLink = "category.php?nam=" . $category["category_name"] . "&catd=" . $sharedComponents->protect($category["category_id"]);

                            $acategories .= '
                                    <li>
                                        <a href="' . $catLink . '" class="categorie">' .
                                $category["category_name"]
                                . '</a>
                                        <span class="ml-auto">' . $category["post_count"] . ' Posts</span>
                                    </li>
                                ';
                        endforeach;
                    }

                    //authors with the most post
                    $stmt = $conn->prepare("SELECT *, COUNT(*) as post_count FROM `posts` WHERE post_status=1 AND delete_status=0 AND post_country='$userCountry' GROUP BY id_user  ORDER BY COUNT(*) DESC LIMIT 5");
                    $stmt->execute();
                    $most_read_authors = $stmt->fetchAll();

                    if (isset($most_read_authors)) {
                        foreach ($most_read_authors as $authors) :

                            $authorId = $authLink = $authorName = $authorImage = $authorDesc = "";

                            if ($authors['id_user'] != 0 && $authors['id_admin'] == 0) {
                                $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :user_id");
                                $stmt->bindParam(":user_id", $authors['id_user'], PDO::PARAM_STR);
                                $stmt->execute();
                                $users_authors = $stmt->fetchAll();

                                foreach ($users_authors as $authors_u) :

                                    $authorId = $sharedComponents->protect($authors_u['user_id']);
                                    $authLink = "author.php?authDType=User&authd=" . $authorId;
                                    $authorName = $authors_u['username'];
                                    $authorDesc = $authors_u['user_desc'];
                                    $authorImage = $sharedComponents->checkFile($authors_u['profile_pic']) == 0 ? "noimage.jpg" : $picturesfolder_name . $authors_u['profile_pic'];

                                endforeach;
                            } else if ($authors['id_admin'] != 0 && $authors['id_user'] == 0) {
                                $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
                                $stmt->bindParam(":admin_id",  $authors['id_admin'], PDO::PARAM_STR);
                                $stmt->execute();
                                $admins_authors = $stmt->fetchAll();

                                foreach ($admins_authors as $authors_a) :

                                    $authorId = $sharedComponents->protect($authors['id_admin']);
                                    $authLink = "author.php?authDType=Admin&authd=" . $authorId;
                                    $authorName = $authors_a['admin_name'];
                                    $authorDesc = $authors_a['admin_desc'];
                                    $authorImage = $sharedComponents->checkFile($authors_a['profile_pic']) == 0 ? "noimage.jpg" : $picturesfolder_name . $authors_a['profile_pic'];

                                endforeach;
                            }

                            $apopularAuthors = '
                                    <li class="post-item">
                                        <div class="image">
                                            <a href="' . $authLink . '"> <img src="' . $authorImage . '" alt="."></a>
                                        </div>
                                        <div class="count">' . $authors['post_count'] . '</div>
                                        <div class="content">
                                            <p class="entry-title">
                                                <a href="' . $authLink . '">' .
                                $authorName
                                . '</a>
                                            </p>
                                            <small class="post-date">' .
                                $authorDesc
                                . '</small>
                                        </div>
                                    </li>
                                ';
                        endforeach;
                    }

                    $stmt = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(4, ad_position) > 0 AND trans_reference!='' ORDER BY RAND() DESC LIMIT  5");
                    $stmt->execute();
                    $randomAds = $stmt->fetchAll();
                    if (isset($randomAds)) {
                        $first_iteration = true;
                        foreach ($randomAds as $ad) :

                            $adImage = $sharedComponents->checkFile2($ad["ad_thumbnail"]) == 0 ? "noimage.jpg" : $adfolder_name . $ad["ad_thumbnail"];

                            if ($first_iteration) {
                                $arandomAds .= '
                                            <a href="' . $ad["ad_url"] . '" class="carousel-item active" data-bs-interval="3000" title="' . $ad["ad_desc"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                <img src="' . $adImage . '" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <b><p>' . $ad["ad_name"] . '</p></b>
                                                </div>
                                            </a>
                                        ';
                                $first_iteration = false;
                            } else {
                                $arandomAds .= '
                                            <a href="' . $ad["ad_url"] . '" class="carousel-item" data-bs-interval="3000" title="' . $ad["ad_desc"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">
                                                <img src="' . $adImage . '" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <b><p>' . $ad["ad_name"] . '</p></b>
                                                </div>
                                            </a>
                                        ';
                            }

                        endforeach;
                    }

                    if (isset($aabout) || isset($apopularPost) || isset($acategories) || isset($apopularAuthors) || isset($arandomAds)) {
                        $postJson = new stdClass();
                        $postJson->about = $aabout;
                        $postJson->popularPost = $apopularPost;
                        $postJson->categories = $acategories;
                        $postJson->popularAuthors = $apopularAuthors;
                        $postJson->randomAds = $arandomAds . '';

                        echo json_encode($postJson);
                    } else {
                        echo 0;
                    }
                } else if ($dataType == "postSlider2") {
                    // Get lastest post show on second section of page
                    $stmt = $conn->prepare("SELECT * FROM `posts` INNER JOIN category ON id_category=category_id WHERE post_status=1 AND delete_status=0 AND post_country='$userCountry' ORDER BY RAND() LIMIT 10");
                    $stmt->execute();
                    $postSlider2data = $stmt->fetchAll();

                    $postSlider2 = "";

                    $count = 0;
                    if (isset($postSlider2data)) {
                        foreach ($postSlider2data as $post) :

                            $count++;

                            $postId = $sharedComponents->protect($post['post_id']);
                            $adminUserDetails = json_decode($sharedComponents->getAdminUser_Post($post['id_admin'], $post['id_user'], $pdo), true);

                            $authId = $adminUserDetails["id"];
                            $authEmail = $adminUserDetails["email"];
                            $authName = $adminUserDetails["username"];
                            $authGender = $adminUserDetails["gender"];
                            $authProfilePic = $sharedComponents->checkFile($adminUserDetails["profile_pic"]) == 0 ? "noimage.jpg" : $picturesfolder_name . $adminUserDetails["profile_pic"];
                            $authLink = "author.php?authDType=" . $adminUserDetails["type"] . "&authd=" . $adminUserDetails["id"];

                            $postImage = $sharedComponents->checkFile($post['post_thumbnail']) == 0 ? "noimage.jpg" : $picturesfolder_name . $post['post_thumbnail'];

                            $apostImage = "'$postImage'";

                            // Count the number of words in the text
                            $num_words = str_word_count($sharedComponents->convertHtmltoText($post['post_contents'], 25, '', ''));

                            // Assume an average reading speed of 200 words per minute
                            $avg_speed = 200;
                            // Calculate the estimated reading time in minutes
                            $reading_time = ceil($num_words / $avg_speed);

                            if (($count - 2) % $noOfPostToDisplayAds[1] == 0) {
                                $adstmt = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(2, ad_position) > 0 AND trans_reference!='' ORDER BY ad_id DESC");
                                $adstmt->execute();
                                $total_rows = $adstmt->rowCount();

                                // Generate a random number between 0 and the total number of rows
                                $random_number = rand(0, $total_rows - 1);

                                if ($total_rows > 0) {
                                    $adstmtb = $conn->prepare("SELECT * FROM `ads` INNER JOIN transactions ON adId=ad_id WHERE status=1 AND ad_target_Country = '$userCountry' AND FIND_IN_SET(2, ad_position) > 0 AND trans_reference!='' ORDER BY ad_id DESC LIMIT $random_number, 1");
                                    $adstmtb->execute();
                                    $ad = $adstmtb->fetch();

                                    if ($adstmtb->rowCount() > 0) {
                                        $adImage = $sharedComponents->checkFile2($ad["ad_thumbnail"]) == 0 ? "noimage.jpg" : $adfolder_name . $ad["ad_thumbnail"];


                                        $postSlider2 .= '
                                                <div class="slider-item  swiper-slide" style="background-image: url(' . $adImage . ');"> 
                                                    <div class="slider-item-content">
                                                        <div class="entry-cat ">
                                                            <a class="categorie" >Sponsored Post</a>
                                                        </div>
                                                        <h4 class="entry-title">
                                                            <a href="' . $ad["ad_url"] . '" onclick="adClickCount("' . $sharedComponents->protect($ad["ad_id"]) . '")" target="_blank">' .
                                            $ad["ad_name"]
                                            . '</a>
                                                        </h4>

                                                        <ul class="entry-meta list-inline">
                                                            
                                                        </ul>
                                                    </div>       
                                                </div>
                                            ';
                                    }
                                }
                            }

                            $postSlider2 .= '
                                    <div class="slider-item  swiper-slide" style="background-image: url(' . $apostImage . ');"> 
                                        <div class="slider-item-content">
                                            <div class="entry-cat ">
                                                <a class="categorie " href="category.php?dt=' . $post['category_name'] . '&catid=' . $post['category_id'] . '">' .
                                $post['category_name']
                                . '</a>
                                            </div>
                                            <h4 class="entry-title">
                                                <a href="post.php?dt=' . $post['post_title'] . '&id=' . $postId . '">' .
                                $post['post_title']
                                . '</a>
                                            </h4>

                                            <ul class="entry-meta list-inline">
                                                <li class="post-author-img">
                                                    <a href="' . $authLink . '">
                                                        <img src="' . $authProfilePic . '" alt="">
                                                    </a>
                                                </li>
                                                <li class="post-author">
                                                    <a href="' . $authLink . '">' .
                                $authName
                                . '</a> 
                                                </li>
                                                <li class="post-date"> <span class="dot"></span>' .
                                date_format(date_create($post["post_creation_time"]), "F d, Y")
                                . '</li>
                                            </ul>
                                        </div>       
                                    </div>
                                ';

                        endforeach;
                    }
                    if (isset($postSlider2))
                        echo $postSlider2 . '<script src="assets/js/swiper.min.js"></script><script src="assets/js/main.js"></script>';
                    else
                        echo 0;
                } else if ($dataType == "ads1") {
                } else if ($dataType == "ads2") {
                } else if ($dataType == "ads3") {
                } else {
                    echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
                }
            } else {
                echo json_encode(['response' => false, 'message' => 'Authentication Error', 'code' => '0', 'data' => '']);
            }
            break;
        case "storeAdCount":
            if (isset($_POST["adId"])) {
                $adId = $sharedComponents->unprotect($_POST["adId"]);
                $sql = "UPDATE `ads` SET `clicks`= clicks+1 WHERE ad_id = $adId";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    echo json_encode(['response' => true, 'message' => 'Ad Clicks Incremented', 'code' => '1', 'data' => '']);
                } else {
                    echo json_encode(['response' => false, 'message' => 'Ad Clicks - Error occured', 'code' => '0', 'data' => '']);
                }
            }
            break;
        default:
            echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '0', 'data' => '']");
    }
}
