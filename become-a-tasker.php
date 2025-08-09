<?php
$page_css = "become-a-tasker.css";
include('header.php');
?>

<!-- Hero Section -->
<section class="tasker-hero d-flex align-items-center py-5" style="background-color:#4b869b;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start">
        <h1 class="fw-bold display-4">Become a HandyHelp Tasker</h1>
        <p class="lead mt-3">Earn money by helping people with everyday home services like cleaning, repairs, moving, and more.</p>
        <a href="register-tasker.php" class="btn btn-success btn-lg mt-4">Register here !</a>
      </div>
      <div class="col-md-6 text-center mt-4 mt-md-0">
        <img src="images/mechanic_working.png" alt="Become a Tasker" class="img-fluid" />
      </div>
    </div>
  </div>
</section>

<!-- Why Join Section -->
<section class="why-join py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-4">Why Join HandyHelp?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="p-3 border rounded bg-white shadow-sm">
          <h5>💰 Earn on Your Terms</h5>
          <p>Choose when and where you work. Get paid weekly for completed tasks.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 border rounded bg-white shadow-sm">
          <h5>🎯 Work You’re Good At</h5>
          <p>Only accept jobs that match your skills and interest — no pressure!</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 border rounded bg-white shadow-sm">
          <h5>🤝 Trusted Support</h5>
          <p>Our platform connects you to verified clients and helps you succeed.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="getting-started py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Getting Started</h2>
    <div class="row text-center gy-5">
      
      <!-- Step 1 -->
      <div class="col-md-4">
        <img src="icons/signup.svg" alt="Sign up" class="mb-3 step-icon">
        <h5><strong>1. Sign up</strong></h5>
        <p>Create your account. Then download the Tasker app to continue registration.</p>
      </div>

      <!-- Step 2 -->
      <div class="col-md-4">
        <img src="icons/profile.svg" alt="Profile" class="mb-3 step-icon">
        <h5><strong>2. Build your profile</strong></h5>
        <p>Select what services you want to offer and where.</p>
      </div>

      <!-- Step 3 -->
      <div class="col-md-4">
        <img src="icons/verify.svg" alt="Verify" class="mb-3 step-icon">
        <h5><strong>3. Verify your eligibility to task</strong></h5>
        <p>Confirm your identity and submit business verifications, as required.</p>
      </div>

      <!-- Step 4 -->
      <div class="col-md-4">
        <img src="icons/fee.svg" alt="Fee" class="mb-3 step-icon">
        <h5><strong>4. Pay registration fee</strong></h5>
        <p>We charge a small fee that helps us provide the best service to you.</p>
      </div>

      <!-- Step 5 -->
      <div class="col-md-4">
        <img src="icons/schedule.svg" alt="Schedule" class="mb-3 step-icon">
        <h5><strong>5. Set your schedule and work area</strong></h5>
        <p>Set your weekly availability and opt in to receive same-day jobs.</p>
      </div>

      <!-- Step 6 -->
      <div class="col-md-4">
        <img src="icons/jobs.svg" alt="Jobs" class="mb-3 step-icon">
        <h5><strong>6. Start getting jobs</strong></h5>
        <p>Grow your business on your own terms.</p>
      </div>

    </div>
  </div>
</section>


<section class="testimonial-section py-5">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Text Side -->
      <div class="col-md-6">
        <div class="testimonial-text">
          <div class="quote-icon mb-3 fs-1 text-success">❝</div>
          <p class="fs-4 fw-semibold">
            I love TaskRabbit! I was able to get out of debt, tackle bills, provide for my family, and still have enough room to save for future goals.
          </p>
          <p class="mt-4 fw-medium">Karsheem W., New York, NY</p>
        </div>
      </div>

      <!-- Image Side -->
      <div class="col-md-6">
        <img src="images/testimonial-779c1bf4e9d375692264bddc09568995.jpg" alt="Testimonial Image" class="img-fluid rounded shadow">
      </div>

    </div>
  </div>
</section>
 
<!-- Signup CTA Section -->
<section id="signup" class="signup-section bg-success text-dark text-center py-5">
  <div class="container">
    <h2 class="mb-3">Ready to Become a HandyHelp Tasker?</h2>
    <p class="mb-4">Join our growing community of skilled professionals.</p>
    <a href="register-tasker.php" class="btn btn-light btn-lg">Join Now</a>
  </div>
</section>

<!-- Footer -->
  <?php
include('footer.php');
?>

</body>
</html>
