<?php
// Include the database connection file.
require 'db.php';

// Check if the database connection was successful.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Safely retrieve the 'category' URL parameter.
$category_to_fetch = $_GET['category'] ?? '';
$taskers = [];


// Use a prepared statement with a WHERE clause to filter by category.
// We use the LOWER() function to ensure a case-insensitive search.
if (!empty($category_to_fetch)) {
    $sql .= " WHERE LOWER(t.category) = LOWER(?)";
}

// Group the results by tasker to get all skills for each tasker in one row.
$sql .= " GROUP BY t.id ORDER BY t.fullname ASC";

// Prepare the SQL statement for execution.
$stmt = $conn->prepare($sql);

// Add an error check for the prepared statement.
if ($stmt === false) {
    die('SQL prepare failed: ' . $conn->error);
}

// Bind the category parameter if it exists.
// We are binding the lowercase version of the variable.
if (!empty($category_to_fetch)) {
    $lowercase_category = strtolower($category_to_fetch);
    $stmt->bind_param("s", $lowercase_category);
}

// Execute the prepared statement.
$stmt->execute();
$result = $stmt->get_result();

// Fetch all the results into an associative array.
while ($row = $result->fetch_assoc()) {
    $taskers[] = $row;
}

// Close the statement and the database connection to free up resources.
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo !empty($category_to_fetch) ? htmlspecialchars($category_to_fetch) . " Taskers" : "All Taskers";
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tasker-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .tasker-card:hover {
            transform: translateY(-5px);
        }
        .skill-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            margin-right: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('header.php'); // Include your header file ?>

    <div class="container my-5">
        <h2 class="mb-4 text-center">
            <?php
            // Display the title based on whether a category was selected
            if (!empty($category_to_fetch)) {
                echo htmlspecialchars($category_to_fetch) . " Taskers";
            } else {
                echo "All Taskers";
            }
            ?>
        </h2>
        <div class="row">
            <?php if (!empty($taskers)): ?>
                <?php foreach ($taskers as $tasker): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 tasker-card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($tasker['fullname']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($tasker['category']) ?></h6>
                                <p class="card-text">
                                    <strong>Experience:</strong> <?= htmlspecialchars($tasker['experience_years']) ?> years<br>
                                    <strong>Location:</strong> <?= htmlspecialchars($tasker['preferred_location']) ?><br>
                                    <strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($tasker['email']) ?>"><?= htmlspecialchars($tasker['email']) ?></a>
                                </p>
                                <div class="mt-3">
                                    <h6>Skills:</h6>
                                    <?php
                                    if (!empty($tasker['skills_list'])) {
                                        $skills_array = explode(', ', $tasker['skills_list']);
                                        foreach ($skills_array as $skill) {
                                            echo '<span class="skill-badge">' . htmlspecialchars($skill) . '</span>';
                                        }
                                    } else {
                                        echo "<p>No skills listed</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">No taskers found for this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include('footer.php'); // Include your footer file ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>