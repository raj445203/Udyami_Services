<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?message=login_required");
    exit();
}

require 'db.php'; // Database connection

$tasker_id = $_GET['tasker_id'] ?? null;

if (!$tasker_id) {
    echo "<p>No tasker selected.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT fullname FROM taskers WHERE id = ?");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$result = $stmt->get_result();
$tasker = $result->fetch_assoc();

if (!$tasker) {
    echo "<p>Tasker not found.</p>";
    exit;
}

$success_message = '';
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $success_message = 'Booking request sent successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($tasker['fullname']); ?></title>
    <!-- Google Fonts for a clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #388e3c;
            --secondary-color: #f1f8e9;
            --text-dark: #333;
            --text-medium: #666;
            --border-radius: 12px;
            --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .booking-container {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 600px;
            padding: 40px;
            box-sizing: border-box;
            border: 1px solid #e1e1e1;
            text-align: center;
        }

        h1 {
            color: var(--primary-color);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        h2 {
            color: var(--text-dark);
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 30px;
        }
        
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #2e7d32;
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            display: <?php echo $success_message ? 'block' : 'none'; ?>;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .booking-container {
                padding: 30px;
            }
            h1 {
                font-size: 24px;
            }
            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <h1>Book Now</h1>
        <h2>Booking for <?php echo htmlspecialchars($tasker['fullname']); ?></h2>

        <div class="success-message">
            <?php echo htmlspecialchars($success_message); ?>
        </div>

        <form action="process_booking.php" method="POST">
            <input type="hidden" name="tasker_id" value="<?php echo htmlspecialchars($tasker_id); ?>">
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="booking_date" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" id="time" name="booking_time" required>
            </div>
            
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="booking_message" placeholder="Provide details about the service you need..." required></textarea>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Send Booking Request
            </button>
        </form>
    </div>
</body>
</html>