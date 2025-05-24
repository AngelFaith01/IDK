 
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientEmail = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try { 
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'angelfaithtolentino143@gmail.com';
        $mail->Password   = 'wvtdxtiglymaimdp'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; 
 
        $mail->setFrom('angelfaithtolentino143@gmail.com', 'Angel Faith Tolentino');
        $mail->addAddress($recipientEmail);
 
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($message)); // Convert newlines to <br>
        $mail->AltBody = $message;

        $mail->send();
        header("Location: admn.php?Message=Email sent successfully");
        exit;
    } catch (Exception $e) {
        header("Location: admn.php?Message=Email not sent. Mailer Error: " . urlencode($mail->ErrorInfo));
        exit;
    }
}

?>
 