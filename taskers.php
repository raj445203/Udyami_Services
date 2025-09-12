<?php
require 'db.php'; 

$skills = $_GET['skills'] ?? '';

if ($skills) {
    $stmt = $conn->prepare("SELECT * FROM taskers WHERE skills = ?");
    $stmt->bind_param("s", $skills);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "<p>No skills selected.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Taskers - <?php echo htmlspecialchars($skills); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f9fdfc;
      font-family: 'Segoe UI', sans-serif;
    }

    .container-box {
      border: 1px solid #e0e0e0;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }
    
    .tasker-card {
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 24px;
      overflow: hidden;
      transition: 0.3s;
      display: flex; 
      flex-direction: column;
    }

    .tasker-card:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    
    .tasker-row {
        display: flex;
        flex-wrap: wrap; 
        align-items: center;
    }

    .tasker-image-col {
        flex: 0 0 40%; 
        max-width: 40%;
    }
    
    .tasker-details-col {
        flex: 0 0 60%; 
        max-width: 60%;
        padding-left: 20px;
    }
    
    .tasker-img {
      width: 100%;
      height: 250px; 
      object-fit: cover;
    }

    .btn-profile {
      background-color: #084650ff;
      color: white;
      border-radius: 5px;
      padding: 8px 16px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s;
    }

    .btn-profile:hover {
      background-color: #14566cff;
    }
    
    @media (max-width: 768px) {
        .tasker-row {
            flex-direction: column; 
        }
        .tasker-image-col, .tasker-details-col {
            flex: 0 0 100%;
            max-width: 100%;
            padding-left: 0;
        }
        .tasker-img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 0;
        }
        .tasker-card .p-3 {
            padding: 15px !important;
        }
    }
  </style>
</head>
<body>
<?php
  include('header.php');
?>
<div class="container my-5">
  <div class="container-box">
    <h2 class="mb-4 text-green">Taskers for "<?php echo htmlspecialchars($skills); ?>"</h2>

    <div class="row">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $image = !empty($row['profile_image']) ? $row['profile_image'] : 'images/image.png';
          ?>
          <div class="col-12">
            <div class="tasker-card mb-4">
              <div class="tasker-row">
                <div class="tasker-image-col">
                  <img src="<?php echo htmlspecialchars($image); ?>" alt="Tasker Image" class="tasker-img">
                </div>
                
                <div class="tasker-details-col p-3 d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="text-green"><?php echo htmlspecialchars($row['fullname']); ?></h5>
                    <p class="mb-1"><strong>Skill:</strong> <?php echo htmlspecialchars($row['skills']); ?></p>
                    <p class="mb-1"><strong>Experience:</strong> <?php echo htmlspecialchars($row['experience_years']); ?> years</p>
                    <p class="mb-2"><strong>Location:</strong> <?php echo htmlspecialchars($row['preferred_location']); ?></p>
                  </div>
                <div class="mt-auto text-end">
    <a href="taskers-profile.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn-profile">
        <i class="bi bi-person-lines-fill me-2"></i>View Profile
    </a>
</div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        echo '<div class="col-12"><p class="text-muted">No taskers found for this skill.</p></div>';
      }
      ?>
    </div>
  </div>
</div>
<?php
  include('footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>