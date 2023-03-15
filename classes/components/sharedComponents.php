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

                return ['response' => true, 'message' => 'Data Inserted Successfully', 'code' => '1', 'data' => $resultData];
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

                $mail->send();

                if (!$mail->send())
                {
                    return ['response' => false, 'message' => 'System failed to send Email verification link, contact the adminstrator to verify your Email account.', 'code' => '0', 'data' => "Mail Error Info: ".$mail->ErrorInfo];
                }
                else 
                {
                    return ['response' => true, 'message' => 'Account created Successfully, access your email to activate your account', 'code' => '1', 'data' => ''];
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

        //checks images and upload to server
        function processUploadImage($email, $image)
        {

            $filename = htmlspecialchars(basename($_FILES[$image]["name"])).$email.date('d-m-y h:i:s');
            $target_dir = "../fileUploads/";
            $target_file = $target_dir.basename($_FILES[$image]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
            // Check file size
            if($_FILES[$image]["size"] > 500000)
            {
                $imageProcessingMsg = ['response' => false, 'message' => 'Sorry, your file is too large' ];
                return $imageProcessingMsg;
            }
            // Allow certain file formats
            else if($imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "doc"
            && $imageFileType != "pdf" )
            {
                $imageProcessingMsg = ['response' => false, 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed'];
                return $imageProcessingMsg;
            }
            //upload file
            move_uploaded_file($_FILES[$image]["tmp_name"], $target_file);

            $imageProcessingMsg = ['response' => true, 'message' => $filename];
            return $imageProcessingMsg;
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