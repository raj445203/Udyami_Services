<?php
session_start();
require 'db.php'; 

// Define the service categories and their respective services
$service_categories = [
    "Personal & Lifestyle" => [
        "Mehandi Artist", "Makeup Artist", "Photography & Videography", "Tour Agent",
        "Caterer / Halwai", "Home Decorator", "Movers / Packers", "Painter",
        "Beautician", "Tattoo Artist", "Hair Stylist / Barber", "Massage Therapist",
        "Tailor / Stitching", "Dog Walker / Pet Groomer"
    ],
    "Household & Maintenance" => [
        "Housemaid / Househelp", "Pest Control", "Washing Machine Repair", "AC Servicing",
        "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
        "Kitchen / Bathroom Cleaning"
    ],
    "Construction & Renovation" => [
        "Civil Contractor", "Interior Designer", "POP / False Ceiling Work", "Fabrication / Welding",
        "Tiling & Marble Work", "Painter / Whitewash", "Vastu Consultant", "Carpenter"
    ],
    "Decoration & Art" => [
        "Home Decorator", "Wallpaper Installation", "Wall Art / Mural Painting", "Floral Decorator",
        "Handicraft Decor Services", "Light Installation (Decor)"
    ],
    "Event Services" => [
        "Event Planner", "Birthday Decorator", "Balloon Artist", "DJ / Sound System",
        "Caterer / Halwai", "Dhol / Tasha Party", "Tent House", "Photography & Videography", "Anchor"
    ],
    "Movers & Transport" => [
        "Home Shifting (Local)", "Intercity Movers & Packers", "Truck / Tempo on Hire",
        "Bike / Car Transport", "Goods Transport Help", "Driver on Demand"
    ]
];

// Helper function to find the category for a given skill
function findCategoryBySkill($skill, $categories) {
    foreach ($categories as $category => $services) {
        if (in_array($skill, $services)) {
            return $category;
        }
    }
    return null; // Return null if not found
}

$skills = $_GET['skills'] ?? '';
$category_filter = $_GET['category'] ?? '';

if ($skills) {
    $search_skills = '%' . $conn->real_escape_string($skills) . '%';
    
    $sql = "SELECT * FROM taskers WHERE skills LIKE ?";
    $params = [$search_skills];
    $types = "s";

    if ($category_filter && $category_filter !== 'all') {
        $sql .= " AND category = ?";
        $params[] = $category_filter;
        $types .= "s";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL prepare error: " . $conn->error);
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    echo "<p>No skills selected.</p>";
    exit;
}

$current_category = findCategoryBySkill($skills, $service_categories);
$other_services_in_category = $current_category ? $service_categories[$current_category] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Taskers - <?php echo htmlspecialchars($skills); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <style>
    :root {
      --primary-color: #388e3c;
      --secondary-color: #f1f8e9;
      --text-dark: #333;
      --text-medium: #666;
      --text-light: #999;
      --border-radius: 12px;
      --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
      --icon-bg: #e0f2f1;
    }

    body {
      background-color: #f0f4f7;
      font-family: 'Segoe UI', sans-serif;
    }
    
    .container {
      max-width: 1200px;
    }
    
    .main-container {
        display: flex;
        gap: 24px;
        margin-top: 24px;
        flex-wrap: nowrap;
    }

    .sidebar {
        flex: 0 0 250px;
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        position: sticky;
        top: 24px;
        height: fit-content;
    }

    .content-area {
        flex-grow: 1;
        min-width: 0;
    }
    
    .content-box {
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
      flex-direction: row;
      min-height: 250px;
    }

    .tasker-card:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    .tasker-row {
        flex-grow: 1;
        display: flex;
        flex-wrap: nowrap;
    }

    .tasker-image-col {
        flex: 0 0 250px;
        max-width: 250px;
    }
    
    .tasker-details-col {
        flex-grow: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .tasker-img {
      width: 100%;
      height: 100%; 
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
    
    .sidebar-section {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .sidebar-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .sidebar-section h5 {
        font-weight: 600;
        margin-bottom: 12px;
        color: #333;
    }

    .sidebar-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-section ul li a {
        display: block;
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 5px;
        text-decoration: none;
        color: #555;
        transition: background-color 0.2s, color 0.2s;
    }

    .sidebar-section ul li a:hover {
        background-color: #f0f0f0;
        color: #084650ff;
    }
    
    .sidebar-section ul li a.active {
        background-color: #084650ff;
        color: #fff;
    }
    
    @media (max-width: 992px) {
        .main-container {
            flex-direction: column;
        }
        .sidebar {
            flex: 0 0 auto;
            position: static;
        }
    }
    
    @media (max-width: 768px) {
        .tasker-card {
            flex-direction: column;
        }
        .tasker-image-col {
            flex: 0 0 auto;
            max-width: 100%;
            height: 200px;
        }
        .tasker-details-col {
            padding: 15px;
        }
        .tasker-img {
            border-bottom-left-radius: 0;
        }
    }
  </style>
</head>
<body>
<?php
  include('header.php');
?>
<div class="container main-container">
    <div class="sidebar">
        <div class="sidebar-section">
            <h5>Filter by Type</h5>
            <ul>
                <li><a href="?skills=<?php echo htmlspecialchars($skills); ?>&category=all" class="<?php echo (empty($category_filter) || $category_filter == 'all') ? 'active' : ''; ?>">All</a></li>
                <li><a href="?skills=<?php echo htmlspecialchars($skills); ?>&category=professional" class="<?php echo ($category_filter == 'professional') ? 'active' : ''; ?>">Professional</a></li>
                <li><a href="?skills=<?php echo htmlspecialchars($skills); ?>&category=semi-professional" class="<?php echo ($category_filter == 'semi-professional') ? 'active' : ''; ?>">Semi-Professional</a></li>
            </ul>
        </div>
        <div class="sidebar-divider"></div>
        <div class="sidebar-section">
            <h5>Other Services in "<?php echo htmlspecialchars($current_category ?? 'General'); ?>"</h5>
            <ul>
                <?php if ($current_category && isset($service_categories[$current_category])): ?>
                    <?php foreach ($service_categories[$current_category] as $service): ?>
                        <li><a href="?skills=<?php echo urlencode($service); ?>"><?php echo htmlspecialchars($service); ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><p class="text-muted" style="font-size: 14px;">No other services in this category.</p></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="content-area">
        <h2 class="mb-4 text-dark">Taskers for "<?php echo htmlspecialchars($skills); ?>"</h2>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $image = !empty($row['profile_image']) ? $row['profile_image'] : 'images/image.png';
                    ?>
                    <div class="col-12">
                        <div class="tasker-card mb-4">
                            <div class="tasker-image-col">
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="Tasker Image" class="tasker-img">
                            </div>
                            <div class="tasker-details-col">
                                <div>
                                    <h5 class="text-green"><?php echo htmlspecialchars($row['fullname']); ?></h5>
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