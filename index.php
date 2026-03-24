<?php
session_start();
require 'db.php';
$conn->close();

$page_css = "home.css"; // VERY IMPORTANT
include('header.php');
?>
<!-- HERO -->
<section class="hero-section d-flex align-items-center">
    <div class="container text-center">

        <h1 class="hero-title">
            Book Trusted Professionals <br>
            <span class="highlight">for Every Need</span>
        </h1>

        <p class="hero-subtext">
            Fast, reliable & verified services at your doorstep
        </p>

        <!-- SEARCH -->
        <div class="search-wrapper mx-auto">
            <form id="searchForm" class="search-bar d-flex">
                <input type="text" id="serviceSearch" name="service"
                    placeholder="What do you need help with?">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- SAME LOGIC -->
            <ul id="suggestionsList"></ul>
        </div>

        <!-- TRUST -->
        <div class="trust-badges">
            <span>✔ Verified</span>
            <span>⭐ Top Rated</span>
            <span>⚡ Fast Booking</span>
        </div>

    </div>
</section>

<!-- CATEGORIES -->
<section class="categories-section">
    <div class="container text-center">

        <h2 class="section-title">Explore Our Services</h2>

        <div class="category-grid">

            <a href="Services2.php#popular-services" class="category-card">
                <i class="fas fa-fire"></i>
                <h3>Popular</h3>
                <p>Trending services</p>
            </a>

            <a href="Services2.php#household-maintenance" class="category-card">
                <i class="fas fa-tools"></i>
                <h3>Household</h3>
                <p>Repairs & cleaning</p>
            </a>

            <a href="Services2.php#construction-renovation" class="category-card">
                <i class="fas fa-hard-hat"></i>
                <h3>Construction</h3>
                <p>Renovation work</p>
            </a>

            <a href="Services2.php#personal-lifestyle" class="category-card">
                <i class="fas fa-user"></i>
                <h3>Personal</h3>
                <p>Lifestyle services</p>
            </a>

            <a href="Services2.php#decoration-art" class="category-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Decor</h3>
                <p>Home & events</p>
            </a>

            <a href="Services2.php#movers-transport" class="category-card">
                <i class="fas fa-truck"></i>
                <h3>Movers</h3>
                <p>Transport help</p>
            </a>

        </div>
    </div>
</section>

<!-- HOW IT WORKS (PROFESSIONAL) -->
<section class="how-section">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">How Udyami Works</h2>
            <p class="section-subtitle">Simple, fast and reliable service booking</p>
        </div>

        <div class="row align-items-center g-5">

            <!-- LEFT IMAGE -->
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978"
                     class="img-fluid how-img">
            </div>

            <!-- RIGHT STEPS -->
            <div class="col-lg-6">

                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <h5>Choose a Service</h5>
                        <p>Browse from a wide range of trusted professionals near you.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5>Book Instantly</h5>
                        <p>Select date & time that fits your schedule easily.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h5>Get It Done</h5>
                        <p>Relax while our professionals complete your task perfectly.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===== SERVICE LIST (UNCHANGED) =====
    const services = [
        "Mehandi Artist", "Makeup Artist", "House Cleaning", "Electrician", "Plumber",
        "Movers & Packers", "Painter", "Beautician", "Cook / Tiffin Services",
        "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
        "AC Servicing", "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
        "Kitchen / Bathroom Cleaning", "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
        "Fabrication & Welding", "Tiling & Marble Work", "Vastu Consultant",
        "Hair Stylist / Barber", "Mehndi Artist", "Massage Therapist", "Physiotherapist",
        "Gym Trainer", "Tailor / Stitching", "Dog Walker / Pet Groomer",
        "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
        "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
        "Light Installation (Decor)", "Wedding Stage Setup", "Event Planner",
        "Birthday Decorator", "Balloon Artist", "DJ & Sound System",
        "Caterer / Halwai", "Dhol / Tasha Party", "Tent House",
        "Photography & Videography", "Tour Agent", "Anchor",
        "Home Shifting (Local)", "Intercity Movers & Packers",
        "Truck / Tempo on Hire", "Bike / Car Transport",
        "Goods Transport Help", "Driver on Demand"
    ];

    const searchInput = document.getElementById("serviceSearch");
    const suggestionsList = document.getElementById("suggestionsList");
    const form = document.getElementById("searchForm");

    // ===== SHOW SUGGESTIONS =====
    searchInput.addEventListener("input", function () {
        const query = this.value.toLowerCase().trim();
        suggestionsList.innerHTML = "";

        if (query === "") {
            suggestionsList.style.display = "none";
            return;
        }

        const filtered = services.filter(service =>
            service.toLowerCase().includes(query)
        );

        if (filtered.length > 0) {
            suggestionsList.style.display = "block";

            filtered.forEach(service => {
                const li = document.createElement("li");
                li.innerHTML = `<i class="fas fa-search me-2 text-muted"></i> ${service}`;
                li.style.padding = "10px 15px";
                li.style.cursor = "pointer";

                li.addEventListener("click", function () {
                    window.location.href = `taskers.php?skills=${encodeURIComponent(service)}`;
                });

                suggestionsList.appendChild(li);
            });

        } else {
            suggestionsList.style.display = "none";
        }
    });

    // ===== FORM SUBMIT =====
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const value = searchInput.value.trim();
        if (value !== "") {
            window.location.href = `taskers.php?skills=${encodeURIComponent(value)}`;
        }
    });

    // ===== HIDE DROPDOWN OUTSIDE CLICK =====
    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.style.display = "none";
        }
    });

    // ===== KEYBOARD NAVIGATION (NEW - PROFESSIONAL) =====
    searchInput.addEventListener("keydown", function (e) {
        const items = suggestionsList.querySelectorAll("li");
        let active = suggestionsList.querySelector(".active");

        if (e.key === "ArrowDown") {
            e.preventDefault();
            if (!active && items.length > 0) {
                items[0].classList.add("active");
            } else if (active && active.nextSibling) {
                active.classList.remove("active");
                active.nextSibling.classList.add("active");
            }
        }

        if (e.key === "ArrowUp") {
            e.preventDefault();
            if (active && active.previousSibling) {
                active.classList.remove("active");
                active.previousSibling.classList.add("active");
            }
        }

        if (e.key === "Enter" && active) {
            e.preventDefault();
            window.location.href = `taskers.php?skills=${encodeURIComponent(active.innerText)}`;
        }
    });

    // ===== SCROLL ANIMATION =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll(".animate-on-scroll").forEach(el => observer.observe(el));

});
</script>
<?php include('footer.php'); ?>