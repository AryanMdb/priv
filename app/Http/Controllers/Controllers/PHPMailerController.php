<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerController extends Controller
{
    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'emails.emizentech.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'kalicharan.mishra@emails.emizentech.com';   //  sender username
            $mail->Password = 'Emizen@123#$';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
 
            $mail->setFrom('kalicharanmishra02@gmail.com', 'Emizen Tech');
            $mail->addAddress($request->email);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender-reply-email', 'sender-reply-name');

            // if(isset($_FILES['emailAttachments'])) {
            //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
            //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
            //     }
            // }


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = "otp send (forgot password)";
            $mail->Body    = "otp message";

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                echo ($mail->ErrorInfo);
            }
            
            else {
                echo ("success Email has been sent.");
            }

        } catch (Exception $e) {
             return $e->getMessage();
        }
    }
}
