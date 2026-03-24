<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$_SESSION['latitude'] = $data['latitude'];
$_SESSION['longitude'] = $data['longitude'];

echo "Location saved";
?>