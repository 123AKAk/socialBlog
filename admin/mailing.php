
<?php
    require '../assets/sendmail.php';
    $model = new send_Mail();

    $emailstring = $_POST["emails"];
    $message = $_POST["emailmsg"];
    $subject = $_POST["emailsubject"];

    $emailarray = explode(",",$emailstring);

    $mailresult = "";
    foreach ($emailarray as $email)
    {
        $mailresult = $model->adminBulkMail($email, $message, $subject);
    }
    if($mailresult["response"] == true)
        echo json_encode(['response' => true, 'message' => $mailresult["message"]]);
    else
        echo json_encode(['response' => false, 'message' => $mailresult["message"]]);

?>