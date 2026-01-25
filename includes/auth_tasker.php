<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['tasker_logged_in']) || 
    $_SESSION['tasker_logged_in'] !== true || 
    !isset($_SESSION['tasker_id'])
) {
    header("Location: login_tasker.php");
    exit();
}
