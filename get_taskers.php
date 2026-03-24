<?php
session_start();
require 'db.php';

$user_lat = $_SESSION['lat'];
$user_lon = $_SESSION['lon'];

$skill = $_GET['skill'];

$result = $conn->query("
SELECT fullname AS name, latitude, longitude 
FROM taskers 
WHERE skills LIKE '%$skill%' 
AND status='approved'
");

$taskers = [];

while ($row = $result->fetch_assoc()) {
    $taskers[] = $row;
}

echo json_encode([
    "user_lat" => $user_lat,
    "user_lon" => $user_lon,
    "taskers" => $taskers
]);
?>