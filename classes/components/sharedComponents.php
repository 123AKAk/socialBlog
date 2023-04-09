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
            }
            catch (PDOException $error) {
                
                return ['response' => false, 'message' => 'Error! '.$error, 'code' => '0', 'data' => ''];
            }
        }

        function sendUsersMail($username, $subject, $message, $toEmail, $altBody)
        {
            require "../../includes/varnames.php"; 
            require 'mailers/autoload.php';

            $mail = new PHPMailer(true);
            try
            {
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                //only to be used on Localhost
                $mail->IsSMTP();
                
                $mail->Host = $siteEmailHost;
                $mail->SMTPAuth = true;
                $mail->Username = $siteEmail;
                $mail->Password = $siteEmailPassword;
                $mail->SMTPSecure = 'SSL';
                $mail->Port = $siteEmailPort;

                $mail->setFrom($siteEmail, $siteName, 0);
                $mail->addAddress($toEmail);
                $mail->addReplyTo($siteEmail, 'For any Information');
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = $altBody;

                if ($mail->send())
                {
                    return ['response' => true, 'message' => 'Account created Successfully, access your email to activate your account', 'code' => '1', 'data' => ''];
                }
                else 
                {
                    return ['response' => false, 'message' => 'System failed to send Email verification link, contact the adminstrator to verify your Email account.', 'code' => '0', 'data' => "Mail Error Info: ".$mail->ErrorInfo];
                }
            }
            catch (Exception $eax) 
            {
                return ['response' => false, 'message' => 'System failed to send Email verification link, contact the adminstrator to verify your Email account.', 'code' => '0', 'data' => "Error Info: ".$eax];
            }
        }

        //get all details about user
        function getUserDetails($pdo, $userId)
        {
            $sql = "SELECT * FROM user WHERE user_id = :user_id";
            if ($stmt = $pdo->prepare($sql)) 
            {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Check if id exists
                    if ($stmt->rowCount() == 1) 
                    {
                        if ($row = $stmt->fetch()) 
                        {
                            return json_encode( ['response' => true, 'message' => '', 'code' => '1', 'data' => $row]);
                        }
                    }
                    else {
                        return json_encode( ['response' => false, 'message' => '', 'code' => '0', 'data' => '']);
                    }
                }
                else {
                    return json_encode( ['response' => false, 'message' => '', 'code' => '0', 'data' => '']);
                }
            }
        }

        function checkInsertCategory($pdo, $category_name)
        {
            if ($stmt = $pdo->prepare("SELECT * FROM category WHERE category_name = :category_name")) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":category_name", $category_name, PDO::PARAM_STR);
                // Attempt to execute the prepared statement
                if ($stmt->execute()) 
                {
                    // Check if username exists, if yes then verify password
                    if ($stmt->rowCount() == 1) 
                    {
                        if ($row = $stmt->fetch()) 
                        {
                            return ['response' => true, 'message' => 'Category is available', 'code' => '1', 'data' => $row["category_id"]];
                        }
                    }
                    else
                    {
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
                if ($stmt->execute()) 
                {
                    // Check if username exists, if yes then verify password
                    if ($stmt->rowCount() == 1) 
                    {
                        if ($row = $stmt->fetch()) 
                        {
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
            iF(!empty($post_title) && !empty($postId))
            {
                $ellipsis = "...  <a style='font-weight:bold;' href='post.php?dt=" . $post_title . "&id=" . $postId . "'> Read more</a>"; // Text to indicate truncated string
            }
            else
            {
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
            } 
            else 
            {
                return strip_tags($string);
            }
        }

        function getAdminUser_Post($adminId, $userId, $pdo)
        {
            $systemJson = [];
            if(!empty($userId))
            {
                $asql = "SELECT * FROM user WHERE user_id = :user_id";
                if ($astmt = $pdo->prepare($asql))
                {
                    $astmt->bindParam(":user_id", $userId, PDO::PARAM_STR);
                    $astmt->execute();
                    if ($astmt->rowCount() == 1) 
                    {
                        if ($user = $astmt->fetch()) 
                        {   
                            if($user['status'] == 1)
                            {
                                $userDetails= [];
                                $userJson = new stdClass();
                                $userJson->id = $this->protect($user['user_id']);
                                $userJson->username = $user['username'];
                                $userJson->email = $user['email'];
                                $userJson->gender = $user['gender'];
                                $userJson->profile_pic = $user['profile_pic'];
                                $userJson->type = "User";
                                $userJson->desc = $user['user_desc'];
                                
                                $systemJson = $userJson;
                            }
                            else
                            {
                                $systemJson = $this->useSystemDetails();
                            }
                        }
                    }
                }
            }
            else if (!empty($adminId))
            {
                $asql = "SELECT * FROM admin WHERE admin_id = :admin_id";
                if ($astmt = $pdo->prepare($asql))
                {
                    $astmt->bindParam(":admin_id", $adminId, PDO::PARAM_STR);
                    $astmt->execute();
                    if ($astmt->rowCount() == 1) 
                    {
                        if ($admin = $astmt->fetch()) 
                        {  
                            if($admin['admin_status'] == 1)
                            {
                                $adminDetails= [];
                                $adminJson = new stdClass();
                                $adminJson->id = $this->protect($admin['admin_id']);
                                $adminJson->username = $admin['admin_name'];
                                $adminJson->email = $admin['email'];
                                $adminJson->gender = "System";
                                $adminJson->profile_pic = $admin['profile_pic'];
                                $adminJson->type = "Admin";
                            
                                $systemJson = $adminJson;
                            }
                            else
                            {
                                $systemJson = $this->useSystemDetails();
                            }
                        }
                    }
                }
            }
            else
            {
                $systemJson = $this->useSystemDetails();
            }

            return json_encode($systemJson);
        }
        
        function useSystemDetails()
        {
            require "includes/varnames.php"; 

            $systemDetails= [];
            $systemJson = new stdClass();
            $systemJson->id = $this->protect(0);
            $systemJson->username = $siteName;
            $systemJson->email = $siteEmail;
            $systemJson->gender = "Male";
            $systemJson->profile_pic = $siteImage;
            $systemJson->type = "Admin";
            $systemJson->desc = $siteDesc;
            
            return $systemJson;
        }
       
        function checkNumofComments($postId, $pdo)
        {
            $post_Id = $this->unprotect($postId);
            $asql = "SELECT * FROM comments WHERE status = 1 AND postid = :postid";
            if ($astmt = $pdo->prepare($asql))
            {
                $astmt->bindParam(":postid", $post_Id, PDO::PARAM_STR);
                $astmt->execute();
                $comments = $astmt->fetchAll();
                $number_of_rows = $astmt->rowCount();

                return $number_of_rows;
            }
        }

        //check if file exsits
        function checkFile($filename)
        {
            // Define file path 
            $dir = "classes/components/filesUpload/";
            $pathtofile = $dir.$filename; 

            // Clear cache to remove result from previous run 
            clearstatcache(); 

            if(!empty($filename))
            {
                if(is_dir($dir))
                {
                    if (file_exists($pathtofile))
                    {
                        return 1;
                    }
                    else
                    {
                        return 0;
                    }
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }

        //encrypt the datastring
        function protect($routeValue)
        {
            // Store a string into the variable which
            // need to be Encrypted
            $data = $routeValue."";

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
            $encryption = openssl_encrypt($data, $ciphering,
            $encryption_key, $options, $encryption_iv);

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
            $decryption = openssl_decrypt ($encryptedValue, $ciphering, 
            $decryption_key, $options, $decryption_iv);
    
            return $decryption;
        }

        function getAdminDetails($adminid, $pdo){
            $sql = "SELECT * FROM admin WHERE admin_id = :admin_id";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":admin_id", $adminid, PDO::PARAM_STR);
                if ($stmt->execute()) 
                {
                    if ($stmt->rowCount() == 1)
                    {
                        if ($row = $stmt->fetch()){
                            return $row;
                        }
                    }
                }
            }
        }

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function implodeArray($array){
            return implode(", ", $array);
        }
    }
?>