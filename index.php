<?php
session_start();
require 'db.php';
include('header.php');
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Udyami Services - Find Trusted Professionals Near You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
    <style>
        .hero-section-custom {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/background-house.avif');
            background-size: cover;
            background-position: center;
            height: 700px;
            display: flex;
            align-items: center;
            color: white;
            padding: 20px 0;
        }

        .btn-custom-orange {
            background-color: #0f5a5eff;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom-orange:hover {
            background-color: #0b636fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .category-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            padding: 25px 20px;
            width: 220px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: #E8F5E9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #158687ff;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            background: #136161ff;
            color: white;
            transform: scale(1.1);
        }

        .how-it-works-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .step-item {
            display: flex;
            margin-bottom: 25px;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            background: #2b9498ff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .sub-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 2;
        }

        .item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 30px;
            color: white;
        }

        /* Animation classes */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .animate-on-scroll.show {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-left {
            transform: translateX(-30px);
        }

        .animate-right {
            transform: translateX(30px);
        }

        .show {
            transform: translateX(0) !important;
        }

        /* Floating animation */
        @keyframes float {
            0%,
            100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Modal custom styles */
        .location-modal-content {
            border-radius: 20px;
            overflow: hidden;
        }
        
        .location-icon-animation {
            animation: bounce 1s ease infinite;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .benefit-item {
            padding: 10px;
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            background: #f8f9fa;
            border-radius: 10px;
            transform: translateX(5px);
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .hero-section-custom {
                min-height: auto;
                padding: 80px 0;
                height: auto;
            }

            .hero-section-custom .col-lg-12 {
                text-align: center;
            }
            
            .hero-section-custom .search-bar {
                width: 90%;
                margin: 0 auto;
            }

            .guarantee-section h1 {
                font-size: 48px;
            }

            .category-card-container {
                gap: 15px;
            }

            .category-card {
                width: 45%;
                min-width: 150px;
            }

            .how-it-works-card {
                padding: 20px;
            }

            .how-it-works-card h4 {
                font-size: 2rem;
            }
        }

        @media (max-width: 767px) {
            .hero-section-custom h1 {
                font-size: 2.5rem;
            }

            .category-card {
                width: 100%;
            }

            .sub-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <section class="hero-section-custom py-5 animate-on-scroll">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center mb-4 mb-lg-0 animate-on-scroll animate-left">
                    <h1 class="fw-bold display-4 mb-4">Book trusted professionals <br><span class="text-green-400">for every need</span></h1>

                    <div class="position-relative mt-5" style="max-width: 100%;">
                        <form id="searchForm" class="search-bar d-flex shadow-lg">
                            <input type="text" id="serviceSearch" name="service" class="form-control rounded-start-pill border-0 flex-grow-1"
                                placeholder="What do you need help with?">
                            <button type="submit" class="btn btn-custom-orange px-4 rounded-end-pill border-0" id="searchBtn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <ul id="suggestionsList" class="list-group position-absolute mt-1 w-100 rounded-3 overflow-hidden"
                            style="z-index: 1000; display: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></ul>
                    </div>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="mt-4">
                        <a href="live-map.php" class="btn btn-outline-light rounded-pill px-4 py-2">
                            <i class="fas fa-map-marked-alt me-2"></i> View Nearby Taskers on Map
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="task-categories py-5 bg-white animate-on-scroll">
        <div class="container text-center">
            <h2 class="section-title mb-5 animate-on-scroll" style="font-size: 2.5rem;">Explore Our Services</h2>
            <div class="category-card-container">
                <a href="Services2.php#popular-services" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-fire"></i></div>
                    <h3>Popular</h3>
                    <p class="text-muted">Top-rated and trending tasks people love.</p>
                </a>
                <a href="Services2.php#household-maintenance" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-tools"></i></div>
                    <h3>Household & Maintenance</h3>
                    <p class="text-muted">Repairs, cleaning, assembly, and more at home.</p>
                </a>
                <a href="Services2.php#construction-renovation" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-hard-hat"></i></div>
                    <h3>Construction & Renovation</h3>
                    <p class="text-muted">Skilled work for home improvement and remodeling.</p>
                </a>
                <a href="Services2.php#personal-lifestyle" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-user-friends"></i></div>
                    <h3>Personal & Lifestyle</h3>
                    <p class="text-muted">Support for wellness, beauty, shopping, and errands.</p>
                </a>
                <a href="Services2.php#decoration-art" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3>Decorations</h3>
                    <p class="text-muted">Home, event, and seasonal decor setup and design.</p>
                </a>
                <a href="Services2.php#event-services" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>Events</h3>
                    <p class="text-muted">From setup to support – events done right.</p>
                </a>
                <a href="Services2.php#movers-transport" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-truck-moving"></i></div>
                    <h3>Movers</h3>
                    <p class="text-muted">Quick and reliable moving and shifting help.</p>
                </a>
            </div>
            <div class="mt-5 animate-on-scroll">
                <a href="Services2.php" class="btn btn-custom-orange px-4 py-3 rounded-pill">
                    View All Categories <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="how-it-works-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-5 col-md-10 mb-4 mb-lg-0 animate-on-scroll animate-left">
                    <div class="how-it-works-card">
                        <h4 class="fw-bold mb-4 display-5">How Udyami Services Works</h4>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>1</span>
                            </div>
                            <div class="step-content">
                                <h5>Choose a Professional</h5>
                                <p class="text-muted">Browse profiles by price, skills, and reviews to select the right professional for your needs.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>2</span>
                            </div>
                            <div class="step-content">
                                <h5>Schedule Your Service</h5>
                                <p class="text-muted">Book for as early as today using our intuitive scheduling system.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>3</span>
                            </div>
                            <div class="step-content">
                                <h5>Enjoy the Results</h5>
                                <p class="text-muted">Relax while we handle everything from start to finish.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 text-center how-it-works-image animate-on-scroll animate-right">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Happy professional at work" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 animate-on-scroll" style="background: linear-gradient(135deg, #0f5c5fff 0%, #17accaff 100%);">
        <div class="container text-center text-white py-5">
            <h2 class="fw-bold mb-4 display-5">Need Help With Something?</h2>
            <p class="lead mb-5" style="opacity: 0.9;">Join thousands of happy homeowners who trust HandyHelp</p>
            <a href="Services2.php" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold">
                Get Help Today <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <!-- Location Permission Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content location-modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4 p-md-5">
                    <div class="mb-4">
                        <i class="fas fa-map-marker-alt fa-5x text-primary location-icon-animation" style="color: #0f5a5e !important;"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Enable Location Services</h3>
                    <p class="text-muted mb-4">To help you find the best taskers near you, we need access to your location.</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="benefit-item">
                                <i class="fas fa-search-location fa-2x mb-2" style="color: #0f5a5e;"></i>
                                <p class="small mb-0">Find nearby professionals</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="benefit-item">
                                <i class="fas fa-clock fa-2x mb-2" style="color: #0f5a5e;"></i>
                                <p class="small mb-0">Faster response times</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="benefit-item">
                                <i class="fas fa-tachometer-alt fa-2x mb-2" style="color: #0f5a5e;"></i>
                                <p class="small mb-0">Accurate distance estimates</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-muted small mb-4">
                        <i class="fas fa-lock me-1"></i> We'll only use this to show nearby service providers and will never share your exact location.
                    </p>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" id="skipLocationBtn">
                            Not Now
                        </button>
                        <button type="button" class="btn btn-primary px-4" id="enableLocationBtn" style="background-color: #0f5a5e; border-color: #0f5a5e;">
                            <i class="fas fa-location-dot me-2"></i> Enable Location
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Service list
        const services = [
            "Mehandi Artist", "Makeup Artist", "House Cleaning", "Electrician", "Plumber",
            "Movers & Packers", "Painter", "Beautician", "Cook / Tiffin Services",
            "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
            "AC Servicing", "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
            "Kitchen / Bathroom Cleaning", "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
            "Fabrication & Welding", "Tiling & Marble Work", "Vastu Consultant",
            "Hair Stylist / Barber", "Mehndi Artist", "Massage Therapist", "Physiotherapist", "Gym Trainer", "Tailor / Stitching",
            "Dog Walker / Pet Groomer", "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
            "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
            "Light Installation (Decor)", "Wedding Stage Setup", "Event Planner", "Birthday Decorator",
            "Balloon Artist", "DJ & Sound System", "Caterer / Halwai", "Dhol / Tasha Party",
            "Tent House", "Photography & Videography", "Tour Agent", "Anchor", "Home Shifting (Local)",
            "Intercity Movers & Packers", "Truck / Tempo on Hire", "Bike / Car Transport", "Goods Transport Help",
            "Driver on Demand"
        ];

        const searchInput = document.getElementById("serviceSearch");
        const suggestionsList = document.getElementById("suggestionsList");

        // Show suggestions while typing
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase();
            suggestionsList.innerHTML = "";

            if (query.trim() === "") {
                suggestionsList.style.display = "none";
                return;
            }

            const filteredServices = services.filter(service => service.toLowerCase().includes(query));

            if (filteredServices.length > 0) {
                suggestionsList.style.display = "block";
                filteredServices.forEach(service => {
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "border-0", "py-3", "hover-bg-light");
                    li.style.cursor = "pointer";
                    li.style.transition = "all 0.2s ease";
                    li.innerHTML = `<i class="fas fa-search me-2 text-muted"></i> ${service}`;
                    li.addEventListener("click", function() {
                        window.location.href = `taskers.php?skills=${encodeURIComponent(service)}`;
                    });
                    suggestionsList.appendChild(li);
                });
            } else {
                suggestionsList.style.display = "none";
            }
        });

        // Redirect when search button clicked or form submitted
        document.getElementById("searchForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const service = searchInput.value.trim();
            if (service !== "") {
                window.location.href = `taskers.php?skills=${encodeURIComponent(service)}`;
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener("click", function(e) {
            if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                suggestionsList.style.display = "none";
            }
        });

        // Scroll animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

        // Location Management
        let locationModal;
        
        // Function to save location to server
        function saveLocationToServer(latitude, longitude) {
            $.ajax({
                url: 'update_location.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                }),
                success: function(response) {
                    console.log('Location saved to server:', response);
                    localStorage.setItem('locationSaved', 'true');
                    localStorage.setItem('locationPermissionGranted', 'true');
                    
                    // Show success message
                    if (locationModal) {
                        locationModal.hide();
                    }
                    
                    // Optional: Show a temporary success message
                    showToast('Location enabled! You can now see nearby taskers.', 'success');
                    
                    // Redirect to map if user wants to see nearby taskers
                    <?php if(isset($_SESSION['user_id'])): ?>
                    setTimeout(function() {
                        if (confirm('Would you like to see nearby taskers on the map?')) {
                            window.location.href = 'live-map.php';
                        }
                    }, 1000);
                    <?php endif; ?>
                },
                error: function(error) {
                    console.error('Error saving location:', error);
                }
            });
        }
        
        // Function to get user location
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        saveLocationToServer(lat, lng);
                    },
                    function(error) {
                        console.error('Geolocation error:', error);
                        let errorMessage = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = 'Location permission denied. You can enable it later from browser settings.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = 'Location information unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage = 'Location request timed out.';
                                break;
                        }
                        showToast(errorMessage, 'warning');
                        localStorage.setItem('locationPermissionGranted', 'false');
                        if (locationModal) locationModal.hide();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showToast('Geolocation is not supported by your browser', 'error');
                if (locationModal) locationModal.hide();
            }
        }
        
        // Toast notification function
        function showToast(message, type = 'info') {
            // Create toast container if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'success' ? 'bg-success' : (type === 'warning' ? 'bg-warning' : 'bg-info');
            const icon = type === 'success' ? 'fa-check-circle' : (type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle');
            
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${icon} me-2"></i> ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Remove toast after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }
        
        // Check if user is logged in and handle location permission
        <?php if(isset($_SESSION['user_id'])): ?>
        $(document).ready(function() {
            locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
            
            // Check if location permission has been asked before
            const locationPermissionAsked = localStorage.getItem('locationPermissionAsked');
            const locationPermissionGranted = localStorage.getItem('locationPermissionGranted');
            
            // If location not saved and permission not asked yet, show modal
            if (localStorage.getItem('locationSaved') !== 'true' && locationPermissionAsked !== 'true') {
                setTimeout(function() {
                    locationModal.show();
                }, 1500);
            } else if (locationPermissionGranted === 'true' && localStorage.getItem('locationSaved') !== 'true') {
                // If permission was granted but location not saved, try to get location
                getUserLocation();
            }
            
            // Enable location button handler
            $('#enableLocationBtn').on('click', function() {
                localStorage.setItem('locationPermissionAsked', 'true');
                getUserLocation();
            });
            
            // Skip button handler
            $('#skipLocationBtn').on('click', function() {
                localStorage.setItem('locationPermissionAsked', 'skipped');
                localStorage.setItem('locationPermissionGranted', 'false');
                showToast('You can enable location later from your profile settings.', 'info');
            });
        });
        <?php endif; ?>
        
        // Function to check if location is already saved and update if needed (for returning users)
        <?php if(isset($_SESSION['user_id'])): ?>
        function checkAndUpdateLocation() {
            if (localStorage.getItem('locationSaved') === 'true' && localStorage.getItem('locationPermissionGranted') === 'true') {
                // Periodically update location (every 5 minutes)
                setInterval(function() {
                    if ("geolocation" in navigator) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            saveLocationToServer(position.coords.latitude, position.coords.longitude);
                        }, function(error) {
                            console.log('Periodic location update failed:', error);
                        });
                    }
                }, 300000); // Update every 5 minutes
            }
        }
        
        // Start periodic updates if location is enabled
        if (localStorage.getItem('locationSaved') === 'true') {
            checkAndUpdateLocation();
        }
        <?php endif; ?>
    </script>
    
    <script id="omnidimension-web-widget" async src="https://backend.omnidim.io/web_widget.js?secret_key=68f0ba12eab69e9266647d3102b367a6"></script>
</body>

</html>