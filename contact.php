<?php

    
    
    
    
$_POST = [];
$_POST["name"] = "ayoade";
$_POST["email"] = "adewoleayoade057@gmail.com";
$_POST["message"] = "Testing emailing ";
$_POST["subject"] = "Test";









$recipientEmail = "adewoleayoade057@gmail.com";
$errors = [];
$errorMessage = '';
if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];
    if (empty($name)) {
        $errors[] = 'Name is empty';
    }
    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }
    if (empty($message)) {
        $errors[] = 'Message is empty';
    }
    if (empty($errors)) {
        if (SendEmail($name, $email, $subject, $message, $recipientEmail)) {
            echo "Your Email is sent";
            exit;
        } else {
            $errorMessage = 'Oops, something went wrong. Please try again later';
        }
    } else {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "{$allErrors}";
    }
}




function SendEmail($name, $email, $subject, $body, $recipientEmail){
    try{
    include(__DIR__."/../libs/PHPMailer/PHPMailer.php");
    include(__DIR__."/../libs/PHPMailer/SMTP.php");
    //include(__DIR__."/../libs/PHPMailer/Exception.php");
    $phpmailer = new PHPMailer();
    //$phpmailer->SMTPDebug = 0; 
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mail.nextmoonshotgems.com';
    $phpmailer->SMTPAuth   = true;// enable SMTP authentication
    $phpmailer->SMTPSecure = "ssl";  
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 465;
    $phpmailer->Username = 'notifications@nextmoonshotgems.com';
    $phpmailer->Password = 'CRemilekun247';
    
    
    
    
    
    $phpmailer->setFrom($email,  $name);
    $phpmailer->addAddress($recipientEmail);
    $phpmailer->AuthType = 'PLAIN';
    

    //Content
    $phpmailer->isHTML(true);//Set email format to HTML
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $body;
    $phpmailer->AltBody = $body;
    //send
    $phpmailer->send();
    //echo 'Message has been sent';
    
    return true;
    }catch(Exception $e){ print_r($e); }
    return false;
}



?>
