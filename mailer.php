<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function forgot_pasword_reset($email,$token){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'exemple@gmail.com';                     //SMTP username
        $mail->Password   = '******';                               //SMTP password
        $mail->SMTPSecure = "tls";                              //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ktraibi877@gmail.com', 'Reset your password');
        $mail->addAddress($email); 
                      
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Notification';
        $mail->Body    = "<h2>Bonjour</h2>
                        <h4>Vous recevez cet email suie à une demande de chamgement de mot de passe  
                        depuis votre compte de l'application Gestion de commande</h4>
                        <a href='http://localhost:8000/php2024/mini%20projet/login.php?email=".$email."&token=".$token."'>Merci de cliquer içi</a>"; 

        $mail->send();
        return 'Un Email vous a été envoyer';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
