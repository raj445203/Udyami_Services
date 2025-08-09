<?php
// session_start();
include('header.php');
?>
    <section class="hero-section-custom py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-start mb-4 mb-lg-0">
                    <h1 class="fw-bold display-5">Book trusted help<br>for home tasks</h1>
                    <p class="lead text-muted mt-3">From furniture assembly to home repairs, we’ve got you covered.</p>
               
<div class="search-container mt-4 position-relative">
  <div class="d-flex">
    <input type="text" id="service-search" class="form-control form-control-lg rounded-start-pill" placeholder="What service do you need?">
    <button id="search-button" class="btn btn-custom-orange btn-lg rounded-end-pill px-4">🔍</button>
  </div>
  <div id="autocomplete-results" class="autocomplete-dropdown-content"></div>
</div>
                </div>
                <div class="col-lg-6">
                    <div class="image-collage d-flex flex-wrap justify-content-center gap-2">
                        <img src="images/painter_working.png" class="collage-img" alt="A painter working on a wall.">
                        <img src="images/mechanic_working.png" class="collage-img" alt="A mechanic fixing something.">
                        <img src="images/plumber_working.png" class="collage-img" alt="A plumber repairing a pipe.">
                        <img src="images/tailor_working.png" class="collage-img" alt="A tailor stitching clothes.">
                        <img src="images/carpenter_working.png" class="collage-img" alt="A carpenter building a wooden shelf.">
                        <img src="images/working women.jpg" class="collage-img" alt="A professional cleaner tidying up.">
                        <img src="images/electrician_working.png" class="collage-img" alt="An electrician fixing wiring.">
                        <img src="images/cleaning staff.jpg" class="collage-img" alt="Cleaning staff smiling.">
                        <img src="images/plumber_working.png" class="collage-img" alt="A plumber working with a wrench.">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="task-categories py-5">
        <div class="container text-center">
            <h2 class="section-title mb-4">Explore Task Categories</h2>
            <div class="d-flex flex-wrap justify-content-center gap-4">

                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-fire fa-2x"></i></div>
                    <h3>Popular</h3>
                    <p>Top-rated and trending tasks people love.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-tools fa-2x"></i></div>
                    <h3>Household & Maintenance</h3>
                    <p>Repairs, cleaning, assembly, and more at home.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-hard-hat fa-2x"></i></div>
                    <h3>Construction & Renovation</h3>
                    <p>Skilled work for home improvement and remodeling.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-user-friends fa-2x"></i></div>
                    <h3>Personal & Lifestyle</h3>
                    <p>Support for wellness, beauty, shopping, and errands.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-lightbulb fa-2x"></i></div>
                    <h3>Decorations</h3>
                    <p>Home, event, and seasonal decor setup and design.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-calendar-alt fa-2x"></i></div>
                    <h3>Events</h3>
                    <p>From setup to support – events done right.</p>
                </a>
                
                <a href="Services2.html" class="category-card animate-fade text-decoration-none text-dark">
                    <div class="category-icon"><i class="fas fa-truck-moving fa-2x"></i></div>
                    <h3>Movers</h3>
                    <p>Quick and reliable moving and shifting help.</p>
                </a>
            </div>
            <div class="mt-5">
                <a href="Services2.php" class="btn btn-custom-orange px-4 py-2">View All Categories</a>
            </div>
        </div>
    </section>

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
                            <p>Choose a **Tasker** by price, skills, and reviews. Browse detailed profiles and confidently select the right professional for your needs.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">
                            <span>2</span>
                        </div>
                        <div class="step-content">
                            <p>Schedule a **Tasker** as early as today. Use our intuitive calendar to book a service at a time that's most convenient for you.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon">
                            <span>3</span>
                        </div>
                        <div class="step-content">
                            <p> Review all in one place. Our platform provides a seamless, secure experience from start to finish.</p>
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


    <section class="cta-bar text-white text-center py-5">
        <div class="container">
            <h2 class="fw-bold mb-3">Need Help With Something?</h2>
            <p class="mb-4">Find trusted local professionals today for your home tasks.</p>
            <a href="#" class="btn btn-light btn-lg rounded-pill px-4 py-2">Get Help Today</a>
        </div>
    </section>

    <section class="guarantee-section py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">
                Your satisfaction, <span class="text-highlight">guaranteed</span>
            </h2>
            <div class="row justify-content-center text-start">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Happiness Pledge</h5>
                    <p>If you’re not satisfied, <a href="#">we’ll work to make it right.</a></p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Shield Icon" width="32" class="me-2">
                        <span class="fw-medium">Happiness pledge</span>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Vetted Taskers</h5>
                    <p>Taskers are always background checked before joining the platform.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Dedicated Support</h5>
                    <p>Friendly service when you need us – every day of the week.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="get-help-section py-5">
        <div class="container text-center">
            <h3 class="fw-bold mb-4">Get help Today</h3>
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <span class="service-chip">Plumbing</span>
                <span class="service-chip">TV Mounting</span>
                <span class="service-chip">Furniture Assembly</span>
                <span class="service-chip">IKEA Furniture Assembly</span>
                <span class="service-chip">Help Moving</span>
                <span class="service-chip">House Cleaning</span>
                <span class="service-chip">Yardwork</span>
                <span class="service-chip">Furniture Removal</span>
                <span class="service-chip">Lawn Care</span>
                <span class="service-chip">Hang Pictures</span>
                <span class="service-chip">In Home Furniture Movers</span>
                <span class="service-chip">Shelf Mounting</span>
                <span class="service-chip">Light Installation</span>
                <span class="service-chip">Plumbing</span>
            </div>
            <a href="#" class="text-success fw-semibold text-decoration-none">See All Services &rarr;</a>
        </div>
    </section>

   <?php
include('footer.php');
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const elements = document.querySelectorAll('.animate-fade');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>
    <script src="script.js"> </script>
</body>
</html>