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
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $category = $_POST['category'] ?? '';
    $skills = trim($_POST['skills'] ?? '');
    $experience_years = $_POST['experience_years'] ?? 0;
    $preferred_location = trim($_POST['preferred_location'] ?? '');

    // Validate required fields
    if ($fullname === '') $errors[] = "Full name is required.";
    if ($dob === '') $errors[] = "Date of birth is required.";
    if ($gender === '') $errors[] = "Gender is required.";
    if ($email === '') $errors[] = "Email is required.";
    if ($phone === '') $errors[] = "Phone number is required.";
    if ($address === '') $errors[] = "Address is required.";
    if ($category === '') $errors[] = "Category is required.";

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
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
            $stmt = $conn->prepare("INSERT INTO taskers (fullname, dob, gender, email, phone, address, category, skills, experience_years, preferred_location, id_proof_path, professional_cert_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "ssssssssisss",
                $fullname,
                $dob,
                $gender,
                $email,
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

<div class="container my-5">
  <h2 class="mb-4 text-center">Tasker Registration</h2>

  <!-- Display PHP errors or success here if needed -->

  <form method="post" action="register-tasker.php" enctype="multipart/form-data" novalidate>
    <div class="row g-3">
      <!-- Full Name -->
      <div class="col-md-6">
        <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
        <input
          type="text"
          class="form-control"
          id="fullname"
          name="fullname"
          placeholder="Enter your full name"
          required
          value="<?= htmlspecialchars($fullname ?? '') ?>"
        >
      </div>

      <!-- Date of Birth -->
      <div class="col-md-6">
        <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
        <input
          type="date"
          class="form-control"
          id="dob"
          name="dob"
          required
          value="<?= htmlspecialchars($dob ?? '') ?>"
        >
      </div>

      <!-- Gender -->
      <div class="col-md-6">
        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
        <select
          id="gender"
          name="gender"
          class="form-select"
          required
        >
          <option value="" disabled <?= empty($gender) ? 'selected' : '' ?>>Select Gender</option>
          <option value="Male" <?= ($gender ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= ($gender ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
          <option value="Other" <?= ($gender ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>

      <!-- Email -->
      <div class="col-md-6">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="you@example.com"
          required
          value="<?= htmlspecialchars($email ?? '') ?>"
        >
      </div>

      <!-- Phone -->
      <div class="col-md-6">
        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
        <input
          type="tel"
          class="form-control"
          id="phone"
          name="phone"
          placeholder="+91 98765 43210"
          required
          value="<?= htmlspecialchars($phone ?? '') ?>"
        >
      </div>

      <!-- Address -->
      <div class="col-md-6">
        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
        <textarea
          id="address"
          name="address"
          class="form-control"
          rows="3"
          placeholder="Street, City, State, Zip"
          required
        ><?= htmlspecialchars($address ?? '') ?></textarea>
      </div>

      <!-- Category -->
      <div class="col-md-6">
        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
        <select
          id="category"
          name="category"
          class="form-select"
          required
          onchange="toggleProfessionalDocs()"
        >
          <option value="" disabled <?= empty($category) ? 'selected' : '' ?>>Select Category</option>
          <option value="Professional" <?= ($category ?? '') === 'Professional' ? 'selected' : '' ?>>Professional</option>
          <option value="Semi-Professional" <?= ($category ?? '') === 'Semi-Professional' ? 'selected' : '' ?>>Semi-Professional</option>
        </select>
      </div>

      <!-- Skills / Experience -->
      <div class="col-md-6">
        <label for="skills" class="form-label">Skills / Experience</label>
        <textarea
          id="skills"
          name="skills"
          class="form-control"
          rows="3"
          placeholder="Describe your skills or experience"
        ><?= htmlspecialchars($skills ?? '') ?></textarea>
      </div>

      <!-- Years of Experience -->
      <div class="col-md-6">
        <label for="experience_years" class="form-label">Years of Experience</label>
        <input
          type="number"
          id="experience_years"
          name="experience_years"
          class="form-control"
          min="0"
          placeholder="e.g. 5"
          value="<?= htmlspecialchars($experience_years ?? '') ?>"
        >
      </div>

      <!-- Preferred Location -->
      <div class="col-md-6">
        <label for="preferred_location" class="form-label">Preferred Work Location</label>
        <input
          type="text"
          id="preferred_location"
          name="preferred_location"
          class="form-control"
          placeholder="City or area where you want to work"
          value="<?= htmlspecialchars($preferred_location ?? '') ?>"
        >
      </div>
    </div>

    <hr class="my-4">

    <!-- ID Proof - always visible and required -->
    <div class="mb-3">
      <label for="id_proof" class="form-label">Upload ID Proof (PDF, JPG, PNG) <span class="text-danger">*</span></label>
      <input
        class="form-control"
        type="file"
        id="id_proof"
        name="id_proof"
        accept=".pdf,.jpg,.jpeg,.png"
        required
      >
    </div>

    <!-- Professional Certificate - only for Professional -->
    <div class="mb-3" id="professionalCertDiv" style="display:none;">
      <label for="professional_doc" class="form-label">Upload Professional Certificate (PDF, JPG, PNG) <span class="text-danger">*</span></label>
      <input
        class="form-control"
        type="file"
        id="professional_doc"
        name="professional_doc"
        accept=".pdf,.jpg,.jpeg,.png"
      >
    </div>

    <div class="mt-4 text-center">
      <button type="submit" class="btn btn-success btn-lg px-5">Register</button>
    </div>
  </form>
</div>

<?php
include('footer.php');
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (isset($_SESSION['success'])): ?>
  Swal.fire('Success', '<?= addslashes($_SESSION['success']) ?>', 'success');
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  Swal.fire('Error', '<?= addslashes($_SESSION['error']) ?>', 'error');
<?php unset($_SESSION['error']); endif; ?>
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