<?php
require 'db.php'; // Your DB connection file

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize & validate inputs
  $fullname = trim($_POST['fullname'] ?? '');
  $dob = $_POST['dob'] ?? '';
  $gender = $_POST['gender'] ?? '';
  $email = trim($_POST['email'] ?? '');
  $user_password = $_POST['password'] ?? ''; // Added password
  $phone = trim($_POST['phone'] ?? '');
  $address = trim($_POST['address'] ?? '');
  $category = $_POST['category'] ?? '';
  $skills = trim($_POST['skills'] ?? '');
  $experience_years = $_POST['experience_years'] ?? 0;
  $preferred_location = trim($_POST['preferred_location'] ?? '');
  $confirm_password = $_POST['confirm_password'] ?? ''; // Added confirm password

  // Validate required fields
  if ($fullname === '') $errors[] = "Full name is required.";
  if ($dob === '') $errors[] = "Date of birth is required.";
  if ($gender === '') $errors[] = "Gender is required.";
  if ($email === '') $errors[] = "Email is required.";
  if ($user_password === '') $errors[] = "Password is required.";
  if ($confirm_password === '') $errors[] = "Confirm Password is required.";
  if ($phone === '') $errors[] = "Phone number is required.";
  if ($address === '') $errors[] = "Address is required.";
  if ($category === '') $errors[] = "Category is required.";

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }

  if ($user_password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
  }

  // Validate file uploads
  if (!isset($_FILES['id_proof']) || $_FILES['id_proof']['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = "ID Proof upload is required.";
  }

  // Professional doc required only if category = Professional
  if ($category === 'Professional') {
    if (!isset($_FILES['professional_doc']) || $_FILES['professional_doc']['error'] === UPLOAD_ERR_NO_FILE) {
      $errors[] = "Professional Certificate upload is required for Professional category.";
    }
  }

  // If no errors, process files and save to DB
  if (empty($errors)) {
    // Define upload folder
    $uploadDir = 'uploads/taskers/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Handle ID Proof upload
    $idProofFile = $_FILES['id_proof'];
    $idProofExt = strtolower(pathinfo($idProofFile['name'], PATHINFO_EXTENSION));
    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];

    if (!in_array($idProofExt, $allowedExt)) {
      $errors[] = "ID Proof must be PDF, JPG, JPEG, or PNG.";
    } else {
      $idProofNewName = uniqid('idproof_') . '.' . $idProofExt;
      $idProofPath = $uploadDir . $idProofNewName;
      if (!move_uploaded_file($idProofFile['tmp_name'], $idProofPath)) {
        $errors[] = "Failed to upload ID Proof.";
      }
    }

    // Handle Professional Certificate upload (if professional)
    $professionalDocPath = null;
    if ($category === 'Professional' && empty($errors)) {
      $profDocFile = $_FILES['professional_doc'];
      $profDocExt = strtolower(pathinfo($profDocFile['name'], PATHINFO_EXTENSION));

      if (!in_array($profDocExt, $allowedExt)) {
        $errors[] = "Professional Certificate must be PDF, JPG, JPEG, or PNG.";
      } else {
        $profDocNewName = uniqid('profcert_') . '.' . $profDocExt;
        $professionalDocPath = $uploadDir . $profDocNewName;
        if (!move_uploaded_file($profDocFile['tmp_name'], $professionalDocPath)) {
          $errors[] = "Failed to upload Professional Certificate.";
        }
      }
    }

    // If still no errors after file uploads, insert data into DB
    if (empty($errors)) {
      // Prepare SQL (adjust table/columns as per your DB)
      $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO taskers (fullname, dob, gender, email,password, phone, address, category, skills, experience_years, preferred_location, id_proof_path, professional_cert_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param(
        "sssssssssisss",
        $fullname,
        $dob,
        $gender,
        $email,
        $hashed_password,
        $phone,
        $address,
        $category,
        $skills,
        $experience_years,
        $preferred_location,
        $idProofPath,
        $professionalDocPath
      );

      if ($stmt->execute()) {
        $success = "Registration successful! Thank you for joining HandyHelp.";
        // Clear POST data to reset form if you re-display it
        $_POST = [];
      } else {
        $errors[] = "Database error: " . $stmt->error;
        // Optionally delete uploaded files on DB failure
        if (file_exists($idProofPath)) unlink($idProofPath);
        if ($professionalDocPath && file_exists($professionalDocPath)) unlink($professionalDocPath);
      }
      $stmt->close();
    }
  }
}
$conn->close();
?>
<?php
include('header.php');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
          <h2 class="mb-0">Tasker Registration</h2>
        </div>
        <div class="card-body p-4 p-md-5">
          <form method="post" action="register-tasker.php" enctype="multipart/form-data" novalidate>


            <!-- Personal Details -->
            <h5 class="mb-3 text-primary border-bottom pb-2">Personal Information</h5>
            <div class="row g-4">
              <div class="col-md-6">
                <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required value="<?= htmlspecialchars($fullname ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dob" name="dob" required value="<?= htmlspecialchars($dob ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                <select id="gender" name="gender" class="form-select" required>
                  <option value="" disabled <?= empty($gender) ? 'selected' : '' ?>>Select Gender</option>
                  <option value="Male" <?= ($gender ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                  <option value="Female" <?= ($gender ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                  <option value="Other" <?= ($gender ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required value="<?= htmlspecialchars($email ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
              </div>
              <div class="col-md-6">
                <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required>
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+91 98765 43210" required value="<?= htmlspecialchars($phone ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Street, City, State, Zip" required><?= htmlspecialchars($address ?? '') ?></textarea>
              </div>
            </div>

            <!-- Work Details -->
            <h5 class="mt-5 mb-3 text-primary border-bottom pb-2">Work Details</h5>
            <div class="row g-4">
              <div class="col-md-6">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <select id="category" name="category" class="form-select" required onchange="toggleProfessionalDocs()">
                  <option value="" disabled <?= empty($category) ? 'selected' : '' ?>>Select Category</option>
                  <option value="Professional" <?= ($category ?? '') === 'Professional' ? 'selected' : '' ?>>Professional</option>
                  <option value="Semi-Professional" <?= ($category ?? '') === 'Semi-Professional' ? 'selected' : '' ?>>Semi-Professional</option>
                </select>
              </div>

              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <label for="skills" class="form-label">Skills</label>
                    <textarea id="skills" name="skills" class="form-control" rows="3" placeholder="Describe or select your skills"></textarea>
                    <div id="skillsList" class="autocomplete-list"></div>
                    <label for="or" class="form-label">or</label>
                    <select id="skillsDropdown" class="form-select mt-2">
                      <option value="">-- Select a skill --</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <label for="experience_years" class="form-label">Years of Experience</label>
                <input type="number" id="experience_years" name="experience_years" class="form-control" min="0" placeholder="e.g. 5" value="<?= htmlspecialchars($experience_years ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label for="preferred_location" class="form-label">Preferred Work Location</label>
                <input type="text" id="preferred_location" name="preferred_location" class="form-control" placeholder="City or area where you want to work" value="<?= htmlspecialchars($preferred_location ?? '') ?>">
              </div>
            </div>

            <!-- Upload Section -->
            <h5 class="mt-5 mb-3 text-primary border-bottom pb-2">Documents</h5>
            <div class="mb-3">
              <label for="id_proof" class="form-label">Upload ID Proof (PDF, JPG, PNG) <span class="text-danger">*</span></label>
              <input class="form-control" type="file" id="id_proof" name="id_proof" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div class="mb-3" id="professionalCertDiv" style="display:none;">
              <label for="professional_doc" class="form-label">Upload Professional Certificate (PDF, JPG, PNG) <span class="text-danger">*</span></label>
              <input class="form-control" type="file" id="professional_doc" name="professional_doc" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success btn-lg px-5">Register</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- SweetAlert Trigger -->
<?php if (!empty($success)) : ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Registration Successful!',
      text: <?= json_encode($success) ?>,
      confirmButtonColor: '#198754',
      confirmButtonText: 'OK'
    });
  </script>
<?php elseif (!empty($error)) : ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops!',
      text: <?= json_encode($error) ?>,
      confirmButtonColor: '#dc3545',
      confirmButtonText: 'Try Again'
    });
  </script>
<?php endif; ?>


<style>
  .card {
    background: #ffffff;
  }

  .form-label {
    font-weight: 500;
  }

  .form-control,
  .form-select {
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .25);
  }

  @media (max-width: 576px) {
    h5 {
      font-size: 1.1rem;
    }

    .btn-lg {
      font-size: 1rem;
      padding: 0.5rem 1.2rem;
    }
  }

  .autocomplete-list {
    position: absolute;
    background: white;
    border: 1px solid #ccc;
    z-index: 1000;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
  }

  .autocomplete-list div {
    padding: 8px;
    cursor: pointer;
  }

  .autocomplete-list div:hover {
    background-color: #f1f1f1;
  }
</style>


<?php
include('footer.php');
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if (isset($_SESSION['success'])): ?>
    Swal.fire('Success', '<?= addslashes($_SESSION['success']) ?>', 'success');
  <?php unset($_SESSION['success']);
  endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    Swal.fire('Error', '<?= addslashes($_SESSION['error']) ?>', 'error');
  <?php unset($_SESSION['error']);
  endif; ?>
</script>
<script>
  function toggleProfessionalDocs() {
    const category = document.getElementById('category').value;
    const certDiv = document.getElementById('professionalCertDiv');
    const profDocInput = document.getElementById('professional_doc');

    if (category === 'Professional') {
      certDiv.style.display = 'block';
      profDocInput.setAttribute('required', 'required');
    } else {
      certDiv.style.display = 'none';
      profDocInput.removeAttribute('required');
      profDocInput.value = ''; // clear file input if hidden
    }
  }
  window.addEventListener('load', toggleProfessionalDocs);
</script>
<script>
  const skillsArray = [
    "Mehandi Artist", "Makeup Artist", "Cleaning", "Electrician", "Plumber",
    "Movers & Packers", "Painter", "Beautician", "Cook / Tiffin Services",
    "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
    "AC Servicing", "Geyser Repair", "Refrigerator Technician",
    "RO Water Purifier Services", "Kitchen / Bathroom Cleaning",
    "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
    "Fabrication & Welding", "Tiling & Marble Work", "Painter / Whitewash",
    "Vastu Consultant", "Carpenter", "Hair Stylist / Barber", "Mehndi Artist",
    "Massage Therapist", "Tailor / Stitching", "Dog Walker / Pet Groomer",
    "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
    "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
    "Light Installation", "Wedding Stage Setup", "Event Planner",
    "Birthday Decorator", "Balloon Artist", "DJ & Sound System",
    "Caterer / Halwai", "Dhol / Tasha Party", "Tent House",
    "Photography & Videography", "Anchor", "Home Shifting",
    "Intercity Movers & Packers", "Truck / Tempo on Hire",
    "Bike / Car Transport", "Goods Transport Help", "Driver on Demand"
  ];

  // Fill dropdown options
  const skillsDropdown = document.getElementById('skillsDropdown');
  skillsArray.forEach(skill => {
    const option = document.createElement('option');
    option.value = skill;
    option.textContent = skill;
    skillsDropdown.appendChild(option);
  });

  const skillsInput = document.getElementById('skills');
  const skillsList = document.getElementById('skillsList');

  skillsInput.addEventListener('input', function() {
    const value = this.value.toLowerCase();
    skillsList.innerHTML = '';
    if (value) {
      const filtered = skillsArray.filter(skill => skill.toLowerCase().includes(value));
      filtered.forEach(skill => {
        const div = document.createElement('div');
        div.textContent = skill;
        div.onclick = function() {
          skillsInput.value = skill;
          skillsList.innerHTML = '';
        };
        skillsList.appendChild(div);
      });
    }
  });

  // Dropdown select event
  skillsDropdown.addEventListener('change', function() {
    if (this.value) {
      skillsInput.value = this.value;
    }
  });
</script>