<?php

  include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HandyHelp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>



    <!-- Hero Section -->
    <section class="hero-section-custom py-5 animate-on-scroll">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start mb-4 mb-lg-0 animate-on-scroll animate-left">
                    <h1 class="fw-bold display-5">Book trusted help<br>for home tasks</h1>
                    <p class="lead text-muted mt-3">From furniture assembly to home repairs, we’ve got you covered.</p>
                    <div class="position-relative mt-4" style="max-width: 100%;">
                      <div class="search-bar d-flex">
                        <input type="text" id="serviceSearch" class="form-control form-control-lg rounded-start-pill" placeholder="What do you need help with?">
                        <button class="btn btn-custom-orange btn-lg rounded-end-pill px-4" id="searchBtn">🔍</button>
                      </div>
                      <ul id="suggestionsList" class="list-group position-absolute mt-1 w-100" style="z-index: 1000; display: none;"></ul>
                    </div>
                </div>
                <div class="col-lg-6 animate-on-scroll animate-right">
                    <div class="image-collage d-flex flex-wrap justify-content-center gap-2">
                        <img src="images/painter_working.png" class="collage-img" alt="">
                        <img src="images/mechanic_working.png" class="collage-img" alt="">
                        <img src="images/plumber_working.png" class="collage-img" alt="">
                        <img src="images/tailor_working.png" class="collage-img" alt="">
                        <img src="images/carpenter_working.png" class="collage-img" alt="">
                        <img src="images/working women.jpg" class="collage-img" alt="">
                        <img src="images/electrician_working.png" class="collage-img" alt="">
                        <img src="images/cleaning staff.jpg" class="collage-img" alt="">
                        <img src="images/plumber_working.png" class="collage-img" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="task-categories py-5 animate-on-scroll">
        <div class="container text-center">
            <h2 class="section-title mb-4 animate-on-scroll">Explore Task Categories</h2>
            <div class="d-flex flex-wrap justify-content-center gap-4">
                <a href="Services2.php" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-fire fa-2x"></i></div>
                    <h3>Popular</h3>
                    <p>Top-rated and trending tasks people love.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-tools fa-2x"></i></div>
                    <h3>Household & Maintenance</h3>
                    <p>Repairs, cleaning, assembly, and more at home.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-hard-hat fa-2x"></i></div>
                    <h3>Construction & Renovation</h3>
                    <p>Skilled work for home improvement and remodeling.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-user-friends fa-2x"></i></div>
                    <h3>Personal & Lifestyle</h3>
                    <p>Support for wellness, beauty, shopping, and errands.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-left text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-lightbulb fa-2x"></i></div>
                    <h3>Decorations</h3>
                    <p>Home, event, and seasonal decor setup and design.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-calendar-alt fa-2x"></i></div>
                    <h3>Events</h3>
                    <p>From setup to support – events done right.</p>
                </a>
                <a href="Services2.php" class="category-card animate-on-scroll animate-right text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-truck-moving fa-2x"></i></div>
                    <h3>Movers</h3>
                    <p>Quick and reliable moving and shifting help.</p>
                </a>
            </div>
            <div class="mt-5 animate-on-scroll">
                <a href="Services2.php" class="btn btn-custom-orange px-4 py-2">View All Categories</a>
            </div>
        </div>
    </section>

    <!-- How it works Section -->
    <section class="how-it-works-section">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-5 col-md-10 mb-4 mb-lg-0">
                    <div class="how-it-works-card">
                        <h4 class="fw-bold mb-4">How it works</h4>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>1</span>
                            </div>
                            <div class="step-content">
                                <p>Choose a <strong>Tasker</strong> by price, skills, and reviews. Browse detailed profiles and confidently select the right professional for your needs.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>2</span>
                            </div>
                            <div class="step-content">
                                <p>Schedule a <strong>Tasker</strong> as early as today. Use our intuitive calendar to book a service at a time that's most convenient for you.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-icon">
                                <span>3</span>
                            </div>
                            <div class="step-content">
                                <p>Review all in one place. Our platform provides a seamless, secure experience from start to finish.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 text-center how-it-works-image">
                    <img src="https://via.placeholder.com/600x400.png?text=Image+of+Happy+Workers" alt="How it works" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-bar text-white text-center py-5 animate-on-scroll" style="background: rgb(4, 171, 160);">
        <div class="container">
            <h2 class="fw-bold mb-3">Need Help With Something?</h2>
              <a href="#" class="btn btn-light btn-lg rounded-pill px-4 py-2">Get Help Today</a>
        </div>
    </section>

    <!-- Guarantee -->
    <section class="guarantee-section">
        <div class="background-stars"></div>
        <div class="container position-relative">
            <h1 class="text-white">GUARANTEE</h1>
            <div class="sub-section">
                <div class="item">
                    <h5 class="fw-bold">Happiness Pledge</h5>
                    <p>If you’re not satisfied, we’ll work to make it right.</p>
                </div>
                <div class="item">
                    <h5 class="fw-bold">Vetted Taskers</h5>
                    <p>Taskers are always background checked before joining the platform.</p>
                </div>
                <div class="item">
                    <h5 class="fw-bold">Dedicated Support</h5>
                    <p>Friendly service when you need us – every day of the week.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Get Help -->
    <section class="get-help-section py-5 animate-on-scroll">
        <div class="container text-center">
            <h3 class="fw-bold mb-4">Get help Today</h3>
            <p>Book a service now and get your tasks done hassle-free.</p>
        </div>
    </section>

    <?php
    include('footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Service list
    const services = [
      "Electrician", "Plumber", "Carpenter", "Painter", "Mehendi Artist", 
      "Catering Service", "Home Cleaning", "Gardener", "Photographer",
      "Event Planner", "Makeup Artist", "Yoga Trainer", "Tutor"
    ];

    const searchInput = document.getElementById("serviceSearch");
    const suggestionsList = document.getElementById("suggestionsList");
    const searchBtn = document.getElementById("searchBtn");

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
          li.classList.add("list-group-item");
          li.textContent = service;
          li.addEventListener("click", function() {
            window.location.href = `taskers.php?service=${encodeURIComponent(service)}`;
          });
          suggestionsList.appendChild(li);
        });
      } else {
        suggestionsList.style.display = "none";
      }
    });

    // Redirect when search button clicked
    searchBtn.addEventListener("click", function() {
      const service = searchInput.value.trim();
      if (service !== "") {
        window.location.href = `taskers.php?service=${encodeURIComponent(service)}`;
      }
    });

    // Hide suggestions when clicking outside
    document.addEventListener("click", function(e) {
      if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
        suggestionsList.style.display = "none";
      }
    });
    </script>
    <script>
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('show');
            }
          });
        }, { threshold: 0.2 });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>
    <script src="script.js"> </script>
</body>
</html>