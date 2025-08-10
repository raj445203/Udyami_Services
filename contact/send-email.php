<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
        $mail->Username   = 'udyamiservices@gmail.com'; // Your Gmail
        $mail->Password   = 'cqvw yakv yorb ssbc';  // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom($email, $name);
        $mail->addAddress( 'udyamiservices@gmail.com', 'HandyHelp Support');
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b><br>$message";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        header("Location: contact.php?success=1");
        exit;
    } catch (Exception $e) {
        header("Location: contact.php?error=1");
        exit;
    }
}
?>
