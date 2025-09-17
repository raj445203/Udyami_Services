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
    <title>HandyHelp</title>
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

        .category-card {
            background: white;
            border-radius: 12px;
            padding: 25px 20px;
            width: 220px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
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

        .guarantee-section {
            background: linear-gradient(135deg, #2e7d7aff 0%, #2c7f94ff 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .guarantee-section h1 {
            font-size: 72px;
            font-weight: 900;
            opacity: 0.1;
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            text-align: center;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section-custom {
                min-height: auto;
                padding: 80px 0;
            }

            .guarantee-section h1 {
                font-size: 48px;
            }
        }

        .collage-img {
            border: 2px solid white;
        }
    </style>
</head>

<body>
    <!--  Hero Section -->
    <section class="hero-section-custom py-5 animate-on-scroll">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start mb-4 mb-lg-0 animate-on-scroll animate-left">
                    <h1 class="fw-bold display-4 mb-4">Book trusted professionals <br><span class="text-green-400">for your home</span></h1>

                    <!--  Search Bar -->
                    <div class="position-relative mt-5" style="max-width: 100%;">
                        <form id="searchForm" class="search-bar d-flex shadow-lg">
                            <input type="text" id="serviceSearch" name="service" class="form-control form-control-lg rounded-start-pill border-0"
                                placeholder="What do you need help with?">
                            <button type="submit" class="btn btn-custom-orange btn-lg rounded-end-pill px-4 border-0" id="searchBtn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                        <ul id="suggestionsList" class="list-group position-absolute mt-1 w-100 rounded-3 overflow-hidden"
                            style="z-index: 1000; display: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></ul>
                    </div>


                </div>
                <div class="col-lg-6 animate-on-scroll animate-right">
                    <div class="image-collage d-flex flex-wrap justify-content-center gap-3">
                        <img src="images/mason.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.2s;" alt="Electrician at work">
                        <img src="images/tailor_working.png" class="collage-img rounded-3 floating" style="animation-delay: 0.4s;" alt="Plumber at work">
                        <img src="images/tabitha-turner-QrYt4_K5TIc-unsplash.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.6s;" alt="Carpenter at work">
                        <img src="images/pestcontrol.webp" class="collage-img rounded-3 floating" style="animation-delay: 0.8s;" alt="Painter at work">
                        <img src="images/enent planner.avif" class="collage-img rounded-3 floating" style="animation-delay: 0.3s;" alt="Handyman at work">
                        <img src="images/samsung-memory-fxKvHGDICcQ-unsplash.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.5s;" alt="Cleaning service">
                        <img src="images/flower.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.7s;" alt="Electrician at work">
                        <img src="images/fridge repairing.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.9s;" alt="Gardener at work">
                        <img src="images/mehandi artist.jpg" class="collage-img rounded-3 floating" style="animation-delay: 0.1s;" alt="Moving service">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="task-categories py-5 bg-white animate-on-scroll">
        <div class="container text-center">
            <h2 class="section-title mb-5 animate-on-scroll" style="font-size: 2.5rem;">Explore Our Services</h2>
            <div class="d-flex flex-wrap justify-content-center gap-4">
                <a href="Services2.php" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-fire"></i></div>
                    <h3>Popular</h3>
                    <p class="text-muted">Top-rated and trending tasks people love.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-tools"></i></div>
                    <h3>Household & Maintenance</h3>
                    <p class="text-muted">Repairs, cleaning, assembly, and more at home.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-hard-hat"></i></div>
                    <h3>Construction & Renovation</h3>
                    <p class="text-muted">Skilled work for home improvement and remodeling.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-user-friends"></i></div>
                    <h3>Personal & Lifestyle</h3>
                    <p class="text-muted">Support for wellness, beauty, shopping, and errands.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3>Decorations</h3>
                    <p class="text-muted">Home, event, and seasonal decor setup and design.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>Events</h3>
                    <p class="text-muted">From setup to support – events done right.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
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

    <!-- Enhanced How it works Section -->
    <section class="how-it-works-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-5 col-md-10 mb-4 mb-lg-0 animate-on-scroll animate-left">
                    <div class="how-it-works-card">
                        <h4 class="fw-bold mb-4 display-5">How HandyHelp Works</h4>
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




    <!-- Enhanced CTA Section -->
    <section class="py-5 animate-on-scroll" style="background: linear-gradient(135deg, #0f5c5fff 0%, #17accaff 100%);">
        <div class="container text-center text-white py-5">
            <h2 class="fw-bold mb-4 display-5">Need Help With Something?</h2>
            <p class="lead mb-5" style="opacity: 0.9;">Join thousands of happy homeowners who trust HandyHelp</p>
            <a href="Services2.php" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold">
                Get Help Today <i class="fas fa-arrow-right ms-2"></i>
            </a>


        </div>
    </section>

    <!-- Enhanced Guarantee Section -->
    <section class="guarantee-section py-5 animate-on-scroll">
        <div class="container position-relative py-5">
            <h1>GUARANTEE</h1>
            <div class="sub-section">
                <div class="item">
                    <div class="mb-3">
                        <i class="fas fa-heart fa-2x mb-3"></i>
                        <h5 class="fw-bold">Happiness Pledge</h5>
                    </div>
                    <p>If you're not satisfied, we'll work to make it right.</p>
                </div>
                <div class="item">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt fa-2x mb-3"></i>
                        <h5 class="fw-bold">Vetted Professionals</h5>
                    </div>
                    <p>All professionals are background checked before joining.</p>
                </div>
                <div class="item">
                    <div class="mb-3">
                        <i class="fas fa-headset fa-2x mb-3"></i>
                        <h5 class="fw-bold">Dedicated Support</h5>
                    </div>
                    <p>Friendly service when you need us – every day of the week.</p>
                </div>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Service list
        const services = [
            "Mehandi Artist", "Makeup Artist", "House Cleaning", "Electrician", "Plumber",
            "Movers & Packers", "Painter", "Beautician", "Cook / Tiffin Services",
            "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
            "AC Servicing", "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
            "Kitchen / Bathroom Cleaning", "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
            "Fabrication & Welding", "Tiling & Marble Work", "Painter / Whitewash", "Vastu Consultant",
            "Hair Stylist / Barber", "Mehndi Artist", "Massage Therapist", "Physiotherapist", "Gym Trainer", "Tailor / Stitching",
            "Dog Walker / Pet Groomer", "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
            "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
            "Light Installation (Decor)", "Wedding Stage Setup", "Event Planner", "Birthday Decorator",
            "Balloon Artist", "DJ & Sound System", "Caterer / Halwai", "Dhol / Tasha Party",
            "Tent House", "Photography & Videography", "Anchor", "Home Shifting (Local)",
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
            e.preventDefault(); // Prevent default form submission
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
    </script>

    <script id="omnidimension-web-widget" async src="https://backend.omnidim.io/web_widget.js?secret_key=68f0ba12eab69e9266647d3102b367a6"></script>
</body>

</html>