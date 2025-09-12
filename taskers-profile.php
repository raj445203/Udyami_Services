<?php
session_start();

// Check if the user is logged in
// This assumes you set a session variable like $_SESSION['user_id'] on successful login
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page with a message
    header("Location: login.php?message=login_required");
    exit();
}

require 'db.php'; // Database connection

$tasker_id = $_GET['id'] ?? null;

if (!$tasker_id) {
    echo "<p>No tasker selected.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM taskers WHERE id = ?");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$result = $stmt->get_result();
$tasker = $result->fetch_assoc();

if (!$tasker) {
    echo "<p>Tasker not found.</p>";
    exit;
}

$image = !empty($tasker['profile_image']) ? $tasker['profile_image'] : 'images/image.png';
$skills_list = explode(',', $tasker['skills']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($tasker['fullname']); ?> - Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f9fdfc;
      font-family: 'Segoe UI', sans-serif;
    }
    .profile-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 30px;
    }
    .profile-img {
      width: 100%;
      height: auto;
      border-radius: 10px;
      object-fit: cover;
      max-height: 400px;
    }
    .contact-card {
      background: #e0f5ec;
      border: 1px solid #c8e6d6;
      border-radius: 10px;
      padding: 20px;
    }
    .badge-skill {
      background-color: #d1e7dd;
      color: #0f5132;
      font-size: 1rem;
      padding: 8px 12px;
      margin: 5px;
      border-radius: 5px;
    }
    .btn-book {
      background-color: #198754;
      color: white;
      font-size: 1.2rem;
      padding: 12px 24px;
      transition: background-color 0.3s;
    }
    .btn-book:hover {
      background-color: #146c43;
    }
    /* Updated custom colors */
    .text-custom-green {
      color: #084650ff !important;
    }
    .badge-skill {
      background-color: #d1e7dd;
      color: #084650ff;
    }
  </style>
</head>
<body>
<?php
  include('header.php');
?>
<div class="container my-5">
  <div class="profile-card">
    <div class="row">
      <div class="col-lg-4 col-md-5 text-center">
        <img src="<?php echo htmlspecialchars($image); ?>" alt="Tasker Profile Image" class="profile-img mb-4">
        <div class="contact-card text-center mb-4">
          <h5 class="text-custom-green">Book this Tasker</h5>
          <p class="text-muted">Contact to discuss your project.</p>
          <a href="tel:<?php echo htmlspecialchars($tasker['phone']); ?>" class="btn btn-book w-100 mb-2">
            <i class="bi bi-telephone-fill me-2"></i>Call Now
          </a>
          <a href="mailto:<?php echo htmlspecialchars($tasker['email']); ?>" class="btn btn-outline-success w-100">
            <i class="bi bi-envelope-fill me-2"></i>Email
          </a>
        </div>
      </div>
      
      <div class="col-lg-8 col-md-7">
        <h1 class="text-custom-green"><?php echo htmlspecialchars($tasker['fullname']); ?></h1>
        <p class="lead text-muted"><?php echo htmlspecialchars($tasker['skills']); ?> Specialist</p>
        
        <hr>
        
        <div class="row mb-4">
          <div class="col-md-6">
            <h4 class="text-custom-green">Experience</h4>
            <p><i class="bi bi-briefcase-fill me-2"></i><?php echo htmlspecialchars($tasker['experience_years']); ?> years</p>
          </div>
          <div class="col-md-6">
            <h4 class="text-custom-green">Location</h4>
            <p><i class="bi bi-geo-alt-fill me-2"></i><?php echo htmlspecialchars($tasker['preferred_location']); ?></p>
          </div>
        </div>
        
        <div class="mb-4">
          <h4 class="text-custom-green">Contact Information</h4>
          <p><i class="bi bi-phone-fill me-2"></i>Mobile: **<?php echo htmlspecialchars($tasker['phone']); ?>**</p>
          <p><i class="bi bi-envelope-fill me-2"></i>Email: **<?php echo htmlspecialchars($tasker['email']); ?>**</p>
        </div>
        
        <div class="mb-4">
          <h4 class="text-custom-green">Skills & Expertise</h4>
          <?php foreach ($skills_list as $skill): ?>
            <span class="badge badge-skill"><?php echo htmlspecialchars(trim($skill)); ?></span>
          <?php endforeach; ?>
        </div>
        
        <div class="mb-4">
          <h4 class="text-custom-green">Portfolio/Gallery</h4>
          <p class="text-muted">
            <i class="bi bi-images me-2"></i>Portfolio images would be displayed here.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  include('footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>