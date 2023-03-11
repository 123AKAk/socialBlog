<?php
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

                return ['response' => true, 'message' => 'Successfull', 'code' => '1', 'data', ". $resultData ."];
            } catch (PDOException $error) {
                
                return ['response' => false, 'message' => 'Error! " .$error."', 'code' => '0', 'data', ''];
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