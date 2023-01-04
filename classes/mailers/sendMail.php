
<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class send_Mail
{
	function sendMail($useremail, $userpassword, $username, $code, $userid, $mailSubject, $message, $urltxt)
	{
        include "../includes/varnames.php";

        if(!empty($urltxt))
        {
            // get the url of the domain name server sending the mail 
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
            else
            $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url.= $_SERVER['HTTP_HOST'].$urltxt;
            // Append the requested resource location to the URL
            //$url.= $_SERVER['REQUEST_URI'];
        }

        require 'autoload.php';
        $mail = new PHPMailer(true);
        try
        {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //$mail->IsSMTP();
            $mail->Host = $siteemailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $siteemail;
            $mail->Password = $siteemailpassword;
            $mail->SMTPSecure = 'SSL';
            $mail->Port = $siteemailport;

            $mail->setFrom($siteemail, $sitename);
            $mail->addAddress($useremail, $username);
            $mail->addReplyTo($siteemail, 'For any Information');
            $mail->isHTML(true);
            $mail->Subject = $mailSubject." - ".$sitename;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();

            if (!$mail->send())
            {
                return $result = ['response' => false, 'message' => 'Unable to send Mail'];
            }
            else 
            {
                return $result = ['response' => true, 'message' => ''];
            }
        }
        catch (Exception $eax) 
        {
            return $result = ['response' => false, 'message' => 'Failure sending Mail '.$mail->ErrorInfo." ".$eax];
        }
        finally
        {
        }
    }
}

?>