<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$booking_id) {
    header("Location: dashboard.php");
    exit();
}

// First, check what columns exist in taskers and users tables
$tasker_columns = [];
$tasker_check = $conn->query("SHOW COLUMNS FROM taskers");
while ($col = $tasker_check->fetch_assoc()) {
    $tasker_columns[] = $col['Field'];
}

$user_columns = [];
$user_check = $conn->query("SHOW COLUMNS FROM users");
while ($col = $user_check->fetch_assoc()) {
    $user_columns[] = $col['Field'];
}

// Build SELECT fields based on existing columns
$select_fields = "b.*";

// Tasker fields
if (in_array('fullname', $tasker_columns)) {
    $select_fields .= ", t.fullname as tasker_name";
} elseif (in_array('full_name', $tasker_columns)) {
    $select_fields .= ", t.full_name as tasker_name";
} else {
    $select_fields .= ", 'Tasker' as tasker_name";
}

if (in_array('phone', $tasker_columns)) {
    $select_fields .= ", t.phone as tasker_phone";
} elseif (in_array('phone_number', $tasker_columns)) {
    $select_fields .= ", t.phone_number as tasker_phone";
} else {
    $select_fields .= ", '' as tasker_phone";
}

if (in_array('profile_image', $tasker_columns)) {
    $select_fields .= ", t.profile_image";
}

if (in_array('current_latitude', $tasker_columns)) {
    $select_fields .= ", t.current_latitude, t.current_longitude, t.last_location_update";
}

// User fields
if (in_array('fullname', $user_columns)) {
    $select_fields .= ", u.fullname as user_name";
} elseif (in_array('full_name', $user_columns)) {
    $select_fields .= ", u.full_name as user_name";
} else {
    $select_fields .= ", 'User' as user_name";
}

if (in_array('phone', $user_columns)) {
    $select_fields .= ", u.phone as user_phone";
}

// Get booking details
$sql = "SELECT $select_fields
        FROM bookings b 
        LEFT JOIN taskers t ON b.tasker_id = t.id 
        JOIN users u ON b.user_id = u.id 
        WHERE b.id = ? AND b.user_id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database prepare error: " . $conn->error);
}

$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header("Location: dashboard.php");
    exit();
}

// Check if tracking is enabled or should be enabled
$can_track = in_array($booking['status'], ['accepted', 'in_progress', 'assigned']);

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Live Tracking - Booking #<?php echo $booking_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        
        .tracking-container {
            position: relative;
            height: calc(100vh - 120px);
            min-height: 500px;
        }
        
        #map {
            height: 100%;
            width: 100%;
            border-radius: 0;
        }
        
        .tracking-panel {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            width: 320px;
            max-width: calc(100% - 40px);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        
        .booking-info {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-pending, .status-Pending {
            background: #ffc107;
            color: #856404;
        }
        
        .status-accepted, .status-Accepted {
            background: #28a745;
            color: white;
        }
        
        .status-in_progress, .status-in-progress {
            background: #17a2b8;
            color: white;
        }
        
        .status-completed, .status-Completed {
            background: #6c757d;
            color: white;
        }
        
        .live-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: #dc3545;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
            margin-right: 5px;
        }
        
        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .eta-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 10px;
        }
        
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .control-buttons {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .control-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .control-btn:hover {
            transform: scale(1.1);
        }
        
        .distance-info {
            font-size: 24px;
            font-weight: bold;
            color: #0f5a5e;
        }
        
        .waiting-message {
            text-align: center;
            padding: 40px;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0f5a5e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .tracking-panel {
                top: auto;
                bottom: 20px;
                right: 20px;
                left: 20px;
                width: auto;
            }
            
            .control-buttons {
                bottom: auto;
                top: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>

<div class="tracking-container">
    <div id="map"></div>
    
    <!-- Tracking Panel -->
    <div class="tracking-panel">
        <div class="booking-info">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Booking #<?php echo $booking_id; ?>
                </h5>
                <span class="status-badge status-<?php echo strtolower($booking['status']); ?>">
                    <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                </span>
            </div>
            
            <div class="d-flex align-items-center mt-3">
                <img src="<?php echo htmlspecialchars($booking['profile_image'] ?? 'images/default-avatar.png'); ?>" 
                     class="profile-img me-3" 
                     onerror="this.src='images/default-avatar.png'">
                <div>
                    <strong><?php echo htmlspecialchars($booking['tasker_name']); ?></strong>
                    <span class="badge bg-success ms-2">Tasker</span>
                    <div class="small text-muted">
                        <i class="fas fa-phone me-1"></i> <?php echo htmlspecialchars($booking['tasker_phone'] ?? 'Not available'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="liveInfo">
            <?php if ($can_track): ?>
            <div class="eta-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Estimated Arrival</small>
                        <div class="distance-info" id="etaDistance">Calculating...</div>
                    </div>
                    <div class="text-center">
                        <span class="live-indicator"></span>
                        <small>LIVE</small>
                    </div>
                </div>
                <div id="etaTime" class="mt-2 small">Waiting for tasker location...</div>
            </div>
            
            <div class="p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-map-marker-alt text-danger me-2"></i> Tasker Location:</span>
                    <span id="taskerLocationStatus" class="small text-muted">Waiting for GPS...</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-location-dot text-success me-2"></i> Your Location:</span>
                    <span id="myLocationStatus" class="small text-muted">Updating...</span>
                </div>
            </div>
            <?php else: ?>
            <div class="waiting-message">
                <div class="spinner"></div>
                <h5>Waiting for Tasker to Accept</h5>
                <p class="text-muted">Once the tasker accepts your booking, you'll be able to track their live location.</p>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Status: <strong><?php echo ucfirst($booking['status']); ?></strong>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Control Buttons -->
    <div class="control-buttons">
        <button class="control-btn" id="centerMapBtn" title="Center on my location">
            <i class="fas fa-location-dot"></i>
        </button>
        <button class="control-btn" id="zoomFitBtn" title="Fit both locations">
            <i class="fas fa-expand-alt"></i>
        </button>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let map;
let myMarker;
let taskerMarker;
let trackingInterval;
let currentMyLocation = null;
let currentTaskerLocation = null;
let bookingId = <?php echo $booking_id; ?>;
let canTrack = <?php echo $can_track ? 'true' : 'false'; ?>;
let bookingStatus = '<?php echo $booking['status']; ?>';

// Custom icons
const myIcon = L.divIcon({
    className: 'custom-div-icon',
    html: '<div style="background-color: #007bff; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
    iconSize: [24, 24],
    popupAnchor: [0, -12]
});

const taskerIcon = L.divIcon({
    className: 'custom-div-icon',
    html: '<div style="background-color: #28a745; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3); animation: pulse 1.5s infinite;"></div>',
    iconSize: [24, 24],
    popupAnchor: [0, -12]
});

// Initialize map
function initMap(latitude, longitude) {
    map = L.map('map').setView([latitude, longitude], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
}

// Calculate distance between two points (Haversine formula)
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// Estimate arrival time
function estimateArrivalTime(distanceKm) {
    const avgSpeed = 30;
    const timeHours = distanceKm / avgSpeed;
    const timeMinutes = Math.round(timeHours * 60);
    
    if (timeMinutes < 1) return '< 1 minute';
    if (timeMinutes === 1) return '1 minute';
    return `${timeMinutes} minutes`;
}

// Update user location on server
function updateMyLocation(latitude, longitude) {
    $.ajax({
        url: 'update_location.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            booking_id: bookingId,
            latitude: latitude,
            longitude: longitude
        }),
        success: function(response) {
            console.log('Location updated:', response);
        }
    });
}

// Fetch tasker location
function fetchTaskerLocation() {
    if (!canTrack) return;
    
    $.ajax({
        url: 'get_booking_tracking.php',
        method: 'GET',
        data: { booking_id: bookingId },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.tracking) {
                if (response.tracking.tasker_latitude && response.tracking.tasker_longitude) {
                    currentTaskerLocation = {
                        lat: parseFloat(response.tracking.tasker_latitude),
                        lng: parseFloat(response.tracking.tasker_longitude)
                    };
                    
                    updateTaskerMarker();
                    updateDistanceAndETA();
                    $('#taskerLocationStatus').text('Updated just now');
                } else {
                    $('#taskerLocationStatus').text('Waiting for tasker location...');
                }
                
                // Check if booking status changed
                if (response.booking && response.booking.status !== bookingStatus) {
                    bookingStatus = response.booking.status;
                    if (bookingStatus === 'completed' || bookingStatus === 'rejected') {
                        clearInterval(trackingInterval);
                        $('#liveInfo').html(`
                            <div class="waiting-message">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5>Service ${bookingStatus}</h5>
                                <p class="text-muted">Thank you for using Udyami Services!</p>
                            </div>
                        `);
                    }
                }
            }
        },
        error: function() {
            $('#taskerLocationStatus').text('Unable to fetch location');
        }
    });
}

// Update tasker marker
function updateTaskerMarker() {
    if (!currentTaskerLocation) return;
    
    if (taskerMarker) {
        taskerMarker.setLatLng([currentTaskerLocation.lat, currentTaskerLocation.lng]);
    } else if (map) {
        taskerMarker = L.marker([currentTaskerLocation.lat, currentTaskerLocation.lng], {icon: taskerIcon})
            .addTo(map)
            .bindPopup('<strong>Tasker Location</strong><br>Heading to your location');
    }
}

// Update distance and ETA
function updateDistanceAndETA() {
    if (!currentMyLocation || !currentTaskerLocation) return;
    
    const distance = calculateDistance(
        currentMyLocation.lat, currentMyLocation.lng,
        currentTaskerLocation.lat, currentTaskerLocation.lng
    );
    
    const eta = estimateArrivalTime(distance);
    
    $('#etaDistance').text(`${distance.toFixed(1)} km`);
    $('#etaTime').html(`<i class="fas fa-clock me-1"></i> Estimated: ${eta}`);
    
    // Check if arrived (within 50 meters)
    if (distance < 0.05) {
        $('#etaTime').html('<i class="fas fa-check-circle me-1"></i> Tasker has arrived! 🎉');
        
        // Show arrival notification
        if (Notification.permission === "granted") {
            new Notification("Tasker has arrived!", {
                body: "Your tasker is at your location",
                icon: "images/logo2.png"
            });
        }
    }
    
    // Fit both locations on map
    if (map && myMarker && taskerMarker) {
        const bounds = L.latLngBounds([myMarker.getLatLng(), taskerMarker.getLatLng()]);
        map.fitBounds(bounds, { padding: [50, 50] });
    }
}

// Start location tracking
function startLocationTracking() {
    if (!canTrack) return;
    
    if ("geolocation" in navigator) {
        navigator.geolocation.watchPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                
                currentMyLocation = { lat: lat, lng: lng };
                
                if (myMarker) {
                    myMarker.setLatLng([lat, lng]);
                } else if (map) {
                    myMarker = L.marker([lat, lng], {icon: myIcon})
                        .addTo(map)
                        .bindPopup('<strong>Your Location</strong>');
                }
                
                updateMyLocation(lat, lng);
                $('#myLocationStatus').html(`Updated: ${new Date().toLocaleTimeString()}<br><small>Accuracy: ±${Math.round(accuracy)}m</small>`);
                
                if (!map.getCenter().lat) {
                    map.setView([lat, lng], 14);
                }
            },
            function(error) {
                console.error('Geolocation error:', error);
                $('#myLocationStatus').text('Unable to get location');
            },
            {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 27000
            }
        );
    }
}

// Center map on my location
function centerMapOnMe() {
    if (currentMyLocation) {
        map.setView([currentMyLocation.lat, currentMyLocation.lng], 15);
    }
}

// Fit map to show both locations
function fitBothLocations() {
    if (myMarker && taskerMarker) {
        const bounds = L.latLngBounds([myMarker.getLatLng(), taskerMarker.getLatLng()]);
        map.fitBounds(bounds, { padding: [50, 50] });
    } else if (myMarker) {
        map.setView(myMarker.getLatLng(), 14);
    }
}

// Request notification permission
if (Notification.permission !== "granted" && Notification.permission !== "denied") {
    Notification.requestPermission();
}

// Start tracking
$(document).ready(function() {
    if (canTrack) {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    initMap(lat, lng);
                    startLocationTracking();
                    fetchTaskerLocation();
                    trackingInterval = setInterval(fetchTaskerLocation, 5000);
                },
                function(error) {
                    console.error('Geolocation error:', error);
                    initMap(28.6139, 77.2090);
                    startLocationTracking();
                    fetchTaskerLocation();
                    trackingInterval = setInterval(fetchTaskerLocation, 5000);
                    $('#myLocationStatus').text('Please enable location services');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser');
            initMap(28.6139, 77.2090);
        }
    } else {
        // Show default map for non-trackable bookings
        initMap(28.6139, 77.2090);
    }
    
    // Event handlers
    $('#centerMapBtn').on('click', centerMapOnMe);
    $('#zoomFitBtn').on('click', fitBothLocations);
});

// Clean up on page unload
$(window).on('beforeunload', function() {
    if (trackingInterval) {
        clearInterval(trackingInterval);
    }
});
</script>
<!-- Add this button for debugging -->
<button onclick="testTracking()" class="btn btn-sm btn-warning mt-2">Test Tracking</button>

<script>
function testTracking() {
    console.log("Testing tracking...");
    $.ajax({
        url: 'get_booking_tracking.php',
        method: 'GET',
        data: { booking_id: <?php echo $booking_id; ?> },
        dataType: 'json',
        success: function(response) {
            console.log("Tracking response:", response);
            alert("Status: " + response.booking.status + "\nTracking Enabled: " + response.booking.tracking_enabled + "\nCan Track: " + response.can_track);
        }
    });
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>