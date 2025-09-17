<?php
// Start the session to ensure the header can check for login status
session_start();

// Include your database connection file, though not strictly needed for this page
require 'db.php'; 

// Include the header file containing the navigation bar
include('header.php');

$message_status = '';
$message_type = '';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic server-side validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $message_status = 'All fields are required.';
        $message_type = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message_status = 'Invalid email format.';
        $message_type = 'danger';
    } else {
        // Email configuration
        $to = 'udyamiservices@gmail.com'; // Replace with your support email
        $headers = "From: $name <$email>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $email_subject = "[Udyami Services Contact Form] " . htmlspecialchars($subject);
        $email_body = "You have received a new message from the Udyami Services contact form.\n\n";
        $email_body .= "Name: " . htmlspecialchars($name) . "\n";
        $email_body .= "Email: " . htmlspecialchars($email) . "\n";
        $email_body .= "Subject: " . htmlspecialchars($subject) . "\n";
        $email_body .= "Message: \n" . htmlspecialchars($message) . "\n";

        // Send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            $message_status = 'Your message has been sent successfully!';
            $message_type = 'success';
        } else {
            $message_status = 'An error occurred while sending your message.';
            $message_type = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Udyami Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f7;
        }

        .contact-container {
            max-width: 900px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .contact-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .contact-info {
            background-color: #2cb0ca;
            color: white;
            padding: 40px;
            border-radius: 15px 0 0 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .contact-info h2 {
            font-weight: 600;
        }
        
        .contact-info p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-item i {
            margin-right: 15px;
            font-size: 1.5rem;
        }

        .contact-form {
            padding: 40px;
        }
        
        .contact-form h2 {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .btn-send {
            background-color: #2cb0ca;
            color: white;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-send:hover {
            background-color: #1a7e94;
        }
        
        .credits {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .credits span {
            font-weight: 600;
            color: #333;
        }

        /* Responsive styles for mobile view */
        @media (max-width: 768px) {
            .contact-card .row {
                flex-direction: column;
            }
            .contact-info {
                border-radius: 15px 15px 0 0; /* Rounded corners on top for mobile */
            }
            .contact-form {
                border-radius: 0 0 15px 15px; /* Rounded corners on bottom for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container contact-container">
        <div class="contact-card row g-0">
            <div class="col-md-5 contact-info">
                <h2>Get in Touch</h2>
                <p>We'd love to hear from you. Feel free to reach out with any questions or feedback you may have.</p>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h5>Location</h5>
                        <p>Udyami Services, Nanded, India</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h5>Phone</h5>
                        <p>+91 98765 43210</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h5>Email</h5>
                        <p>udyamiservices@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-7 contact-form">
                <h2>Send Us a Message</h2>
                <?php if ($message_status): ?>
                    <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> mt-3" role="alert">
                        <?php echo htmlspecialchars($message_status); ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-send">Send Message</button>
                </form>
            </div>
        </div>
        <div class="credits">
            Designed & Developed by <span>Bhojraj Salunke</span> and <span>Shivam Zampalkar</span>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    include('footer.php');
    ?>
</body>
</html>