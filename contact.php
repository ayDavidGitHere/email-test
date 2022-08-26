<?php

//set credentials at line 53,54,58,59






$recipientEmail = "funmbiogunsola@gmail.com";
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
    include(__DIR__."/PHPMailer.php");
    include(__DIR__."/SMTP.php");
    //include(__DIR__."/PHPMailer/Exception.php");
    $phpmailer = new PHPMailer();
    //$phpmailer->SMTPDebug = 0; 
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mail.yourdomain.com'; //SET
    $phpmailer->SMTPAuth   = true;// enable SMTP authentication
    $phpmailer->SMTPSecure = "ssl";  
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 465;
    $phpmailer->Username = 'address@domain.com'; //SET THE EMAIL ACCOUNT YOU CREATED
    $phpmailer->Password = 'emailpass'; //SET THE PASSWORD FOR YOUR EMAIL ACCOUNT
    
    
    
    
    
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
