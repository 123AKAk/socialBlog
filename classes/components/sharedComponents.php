<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class sharedComponents
{
    function insertToDB($conn, $table, $data)
    {
        // Get keys string from data array
        $columns = $this->implodeArray(array_keys($data));

        // Get values string from data array with prefix (:) added
        $prefixed_array = preg_filter('/^/', ':', array_keys($data));
        $values = $this->implodeArray($prefixed_array);

        try {
            // prepare sql and bind parameters
            $sql = "INSERT INTO $table ($columns) VALUES ($values); SELECT LAST_INSERT_ID();";
            $stmt = $conn->prepare($sql);

            // insert row
            $stmt->execute($data);

            //echo "New records created successfully";
            $resultData = $conn->lastInsertId();

            return ['response' => true, 'message' => 'Data Submitted Successfully', 'code' => '1', 'data' => $resultData];
        } catch (PDOException $error) {

            return ['response' => false, 'message' => 'Error! ' . $error, 'code' => '0', 'data' => ''];
        }
    }

    function sendUsersMail($username, $subject, $message, $toEmail, $altBody)
    {

        $siteDetails = $this->siteDetails();

        require 'mailers/autoload.php';

        $mail = new PHPMailer(true);
        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //only to be used on Localhost
            //$mail->IsSMTP();

            $mail->Host = $siteDetails["siteEmailHost"];
            $mail->SMTPAuth = true;
            $mail->Username = $siteDetails["siteEmail"];
            $mail->Password = $siteDetails["siteEmailPassword"];
            $mail->SMTPSecure = 'SSL';
            $mail->Port = $siteDetails["siteEmailPort"];

            $mail->setFrom($siteDetails["siteEmail"], $siteDetails["siteName"]);
            $mail->addAddress($toEmail);
            $mail->addReplyTo($siteDetails["siteEmail"], 'For any Information');
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $altBody;

            if ($mail->send()) {
                return ['response' => true, 'message' => 'Account created Successfully, access your email to activate your account', 'code' => '1', 'data' => ''];
            } else {
                return ['response' => false, 'message' => 'System failed to send Email verification link, contact the adminstrator to verify your Email account.', 'code' => '0', 'data' => "Mail Error Info: " . $mail->ErrorInfo];
            }
        } catch (Exception $eax) {
            return ['response' => false, 'message' => 'System failed to send Email verification link, contact the adminstrator to verify your Email account.', 'code' => '0', 'data' => "Error Info: " . $eax];
        }
    }

    //get all details about user
    function getUserDetails($pdo, $userId)
    {
        $sql = "SELECT * FROM user WHERE user_id = :user_id";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if id exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        return json_encode(['response' => true, 'message' => '', 'code' => '1', 'data' => $row]);
                    }
                } else {
                    return json_encode(['response' => false, 'message' => '', 'code' => '0', 'data' => '']);
                }
            } else {
                return json_encode(['response' => false, 'message' => '', 'code' => '0', 'data' => '']);
            }
        }
    }

    function checkInsertCategory($pdo, $category_name)
    {
        if ($stmt = $pdo->prepare("SELECT * FROM category WHERE category_name = :category_name")) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":category_name", $category_name, PDO::PARAM_STR);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        return ['response' => true, 'message' => 'Category is available', 'code' => '1', 'data' => $row["category_id"]];
                    }
                } else {
                    $data = array(
                        "category_name" => $category_name,
                        "category_creation_date" => date('Y-m-d H:i:s')
                    );

                    //inserts category if not found
                    return $this->insertToDB($pdo, "category", $data);
                }
            }
        }
    }

    function getCategoryName($pdo, $category_id)
    {
        if ($stmt = $pdo->prepare("SELECT * FROM category WHERE category_id = :category_id")) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_STR);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        return ['response' => true, 'message' => 'Category is available', 'code' => '1', 'data' => $row["category_name"]];
                    }
                }
            }
        }
    }

    function convertHtmltoText($postContents, $max_words, $post_title, $postId)
    {
        //displays the contents as HTML
        $string = htmlspecialchars_decode($postContents);

        // Strip HTML tags and leave only texts
        $stripped_string = strip_tags($string);

        // Count words
        $num_words = str_word_count($stripped_string);

        //$max_words = 50; // Maximum number of words
        if (!empty($post_title) && !empty($postId)) {
            $ellipsis = "...  <a style='font-weight:bold;' href='post.php?dt=" . $post_title . "&id=" . $postId . "'> Read more</a>"; // Text to indicate truncated string
        } else {
            $ellipsis = "...";
        }

        if ($num_words > $max_words) {
            // Find position of the nth word boundary
            $pos = $max_words;
            for ($i = 0; $i < $max_words; $i++) {
                $pos = strpos($stripped_string, ' ', $pos + 1);
                if ($pos === false) {
                    break;
                }
            }
            // Truncate string and add ellipsis
            return substr($stripped_string, 0, $pos) . $ellipsis;
        } else {
            return strip_tags($string);
        }
    }

    function getLimitSize($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM siteinfo WHERE id = 1");
        $stmt->execute();
        $siteInfo = $stmt->fetch();
        $arryLimitSize = array($siteInfo['sliderSize_post'], $siteInfo['sliderSize_ads']);
        return $arryLimitSize;
    }

    function getNoOfPostToDisplayAds($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM siteinfo WHERE id = 1");
        $stmt->execute();
        $siteInfo = $stmt->fetch();
        $arry = array($siteInfo['noOfPostToDisplayAds_bodyPost'], $siteInfo['noOfPostToDisplayAds_bodySlider']);
        return $arry;
    }

    function getAdminUser_Post($adminId, $userId, $pdo)
    {
        $systemJson = [];
        if (!empty($userId)) {
            $asql = "SELECT * FROM user WHERE user_id = :user_id";
            if ($astmt = $pdo->prepare($asql)) {
                $astmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                $astmt->execute();
                if ($astmt->rowCount() == 1) {
                    if ($user = $astmt->fetch()) {
                        if ($user['status'] == 1) {
                            $userDetails = [];
                            $userJson = new stdClass();
                            $userJson->id = $this->protect($user['user_id']);
                            $userJson->username = $user['username'];
                            $userJson->email = $user['email'];
                            $userJson->gender = $user['gender'];
                            $userJson->profile_pic = $user['profile_pic'];
                            $userJson->type = "User";
                            $userJson->desc = $user['user_desc'];

                            $systemJson = $userJson;
                        } else {
                            $systemJson = $this->useSystemDetails($pdo);
                        }
                    }
                }
            }
        } else if (!empty($adminId)) {
            $asql = "SELECT * FROM admin WHERE admin_id = :admin_id";
            if ($astmt = $pdo->prepare($asql)) {
                $astmt->bindParam(":admin_id", $adminId, PDO::PARAM_STR);
                $astmt->execute();
                if ($astmt->rowCount() == 1) {
                    if ($admin = $astmt->fetch()) {
                        if ($admin['admin_status'] == 1) {
                            $adminDetails = [];
                            $adminJson = new stdClass();
                            $adminJson->id = $this->protect($admin['admin_id']);
                            $adminJson->username = $admin['admin_name'];
                            $adminJson->email = $admin['email'];
                            $adminJson->gender = "System";
                            $adminJson->profile_pic = $admin['profile_pic'];
                            $adminJson->type = "Admin";

                            $systemJson = $adminJson;
                        } else {
                            $systemJson = $this->useSystemDetails($pdo);
                        }
                    }
                }
            }
        } else {
            $systemJson = $this->useSystemDetails($pdo);
        }

        return json_encode($systemJson);
    }

    function useSystemDetails($conn)
    {
        $siteDetails = $this->siteDetails();

        $systemDetails = [];
        $systemJson = new stdClass();
        $systemJson->id = $this->protect(0);
        $systemJson->username = $siteDetails["siteName"];
        $systemJson->email = $siteDetails["siteEmail"];
        $systemJson->gender = "Male";
        $systemJson->profile_pic = $siteDetails["siteImage"];
        $systemJson->type = "Admin";
        $systemJson->desc = $siteDetails["siteDesc"];

        return $systemJson;
    }

    function checkComments($postId, $pdo)
    {
        $sql = "SELECT * FROM comments WHERE status = 1 AND postid = :postid ORDER BY comments_id DESC";
        if ($astmt = $pdo->prepare($sql)) {
            $astmt->bindParam(":postid", $postId, PDO::PARAM_INT);
            $astmt->execute();
            $comments = $astmt->fetchAll();
            $number_of_rows = $astmt->rowCount();

            $commentResults = array(
                'numberofRows' => $number_of_rows,
                'comments' => $comments,
            );
            return $commentResults;
        }
    }

    //gets the post details
    function getPostDetails($postId, $userId, $pdo)
    {
        $postId = $this->unprotect($postId);
        $userId = $this->unprotect($userId);

        $stmt = $pdo->prepare("SELECT * FROM postDetails WHERE postId = :postId AND userId = :userId");
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        if($row = $stmt->fetch())
        {
            $postDetails = array(
                'likes' => $row["likes"],
                'dislikes' => $row["dislikes"],
                'views' => $row["views"]
            );
            return $postDetails;
        }
    }
    
    function getBookmarkDetails($postId, $userId, $pdo)
    {
        $postId = $this->unprotect($postId);
        $userId = $this->unprotect($userId);

        // Retrieve the current saved_posts value for the user from the database
        $stmt = $pdo->prepare("SELECT saved_posts FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $saved_posts = $row['saved_posts'];
            
            // Convert the retrieved saved_posts string to an array using json_decode
            $post_ids = $saved_posts ? json_decode($saved_posts, true) : [];
            
            // Check if the post ID is already present in the array
            $index = array_search($postId, $post_ids);
    
            if ($index === false)
                return 0;
            else
                return 1;
        }
        else
        {
            return 0;
        }
    }

    function getAuthorFollowDetails($authorId, $authorType, $userId, $pdo)
    {
        $authorId = $this->unprotect($authorId);
        $userId = $this->unprotect($userId);

        // Retrieve the current authors_followed value for the user from the database
        $stmt = $pdo->prepare("SELECT authors_followed FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        
            $authors_followed = $row['authors_followed'];
            
            // Convert the retrieved authors_followed string to an array using json_decode
            $allAuthors_followed = $authors_followed ? json_decode($authors_followed, true) : [];
            
            // Check if the author ID is already present in the array
            //$index = array_search($authorId, $allAuthors_followed);
            
            // if ($index === false)
            //     return 0;
            // else
            //     return 1;

            $index = null;
            // Loop through the post IDs array and find the index of the ID and type combination
            foreach ($allAuthors_followed as $key => $author) {
                if ($author['id'] === $authorId && $author['type'] === $authorType) {
                    $index = $key;
                    return 1;
                    break;
                }
            }

            if ($index == null)
                return 0;
        }
        else
        {
            return 0;
        }
    }

    function getViewsPostDetails($postId, $pdo)
    {
        $sql = "SELECT SUM(views) AS totalViews FROM postDetails WHERE postId = :postId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":postId", $postId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            if($result = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                return $result['totalViews'];
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 3;
        }
    }

    //check if file exsits
    function checkFile($filename)
    {
        // Define file path 
        $dir = "filesUpload/";
        $pathtofile = $dir . $filename;

        // Clear cache to remove result from previous run 
        clearstatcache();

        if (!empty($filename)) {
            if (is_dir($dir)) {
                if (file_exists($pathtofile)) {
                    return 1;
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    function checkFile2($filename)
    {
        // Define file path 
        $dir = "filesUpload/ads/";
        $pathtofile = $dir . $filename;

        // Clear cache to remove result from previous run 
        clearstatcache();

        if (!empty($filename)) {
            if (is_dir($dir)) {
                if (file_exists($pathtofile)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    
    function siteDetails()
    {
        require 'db.php';

        $siteName = $globalName = $siteEmail = $siteEmailPassword = $siteEmailHost = $siteEmailPort = $siteMsg = $siteHashTag = $pageTitleDefault = $pageDescDefault = $siteURL = $pageLogo = $logoDesc = $siteImage = $siteDesc = "";

        $sql = "SELECT * FROM siteInfo WHERE id=:id";
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", 1, PDO::PARAM_INT);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if id exists
                if ($stmt->rowCount() > 1) {
                    if ($row = $stmt->fetch()) {
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
                } else {
                }
            } else {
            }
        }
    }

    //encrypt the datastring
    function protect($routeValue)
    {
        // Store a string into the variable which
        // need to be Encrypted
        $data = $routeValue . "";

        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';

        // Store the encryption key
        $encryption_key = "eyo123";

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt(
            $data,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        return $encryption;
    }

    //decrypt the datastring
    function unprotect($encryptedValue)
    {
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';

        // Store the decryption key
        $decryption_key = "eyo123";

        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt(
            $encryptedValue,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        return $decryption;
    }

    function getAdminDetails($adminid, $pdo)
    {
        $sql = "SELECT * FROM admin WHERE admin_id = :admin_id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":admin_id", $adminid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        return $row;
                    }
                }
            }
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function implodeArray($array)
    {
        return implode(", ", $array);
    }
}
