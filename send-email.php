<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'salunkeraj098@gmail.com'; // Your Gmail
        $mail->Password   = 'yczk rvjt zcbc vixr';  // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('salunkeraj098@gmail.com', 'HandyHelp');
        $mail->addAddress('support@handyhelp.com', 'HandyHelp Support');
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b><br>$message";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        echo "<h2>✅ Message sent successfully!</h2>";

    } catch (Exception $e) {
        echo "<h2>❌ Message could not be sent. Error: {$mail->ErrorInfo}</h2>";
    }
}
?>
