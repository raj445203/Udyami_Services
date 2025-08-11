<?php

require 'db.php'; // Your DB connection file

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize & validate inputs
    $fullname = trim($_POST['fullname'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $category = $_POST['category'] ?? '';
    $skills_string = trim($_POST['skills'] ?? '');
    
    // --- DEBUGGING LINE ---
    // This line will write the received skills string to your server's error log.
    // Check your web server's error log (e.g., error.log) to see what is submitted.
    error_log("Received skills string: " . $skills_string);
    
    $skills_array = array_filter(explode(',', $skills_string));

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
            try {
                $conn->begin_transaction();

                // 1. Insert into the `taskers` table
                $sql_tasker = "INSERT INTO taskers (fullname, dob, gender, email, phone, address, category, experience_years, preferred_location, id_proof_path, professional_cert_path)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql_tasker);
                $stmt->bind_param("sssssssisss", $fullname, $dob, $gender, $email, $phone, $address, $category, $experience_years, $preferred_location, $idProofPath, $professionalDocPath);
                
                if ($stmt->execute()) {
                    $tasker_id = $conn->insert_id;
                    $stmt->close();
                    
                    // 2. Process skills and insert into `tasker_skills` table
                    foreach ($skills_array as $skill_name) {
                        $skill_name = trim($skill_name);

                        // Find or insert the skill in the `skills` table
                        $sql_find_skill = "SELECT id FROM skills WHERE skill_name = ?";
                        $stmt_find = $conn->prepare($sql_find_skill);
                        $stmt_find->bind_param("s", $skill_name);
                        $stmt_find->execute();
                        $result = $stmt_find->get_result();
                        
                        $skill_id = null;
                        if ($result->num_rows > 0) {
                            $skill = $result->fetch_assoc();
                            $skill_id = $skill['id'];
                        } else {
                            $sql_insert_skill = "INSERT INTO skills (skill_name) VALUES (?)";
                            $stmt_insert = $conn->prepare($sql_insert_skill);
                            $stmt_insert->bind_param("s", $skill_name);
                            $stmt_insert->execute();
                            $skill_id = $conn->insert_id;
                            $stmt_insert->close();
                        }
                        $stmt_find->close();

                        // Insert the relationship into the `tasker_skills` table
                        $sql_tasker_skill = "INSERT INTO tasker_skills (tasker_id, skill_id) VALUES (?, ?)";
                        $stmt_link = $conn->prepare($sql_tasker_skill);
                        $stmt_link->bind_param("ii", $tasker_id, $skill_id);
                        $stmt_link->execute();
                        $stmt_link->close();
                    }
                    
                    $conn->commit();
                    $_SESSION['success'] = "Registration successful! Thank you for joining HandyHelp.";
                } else {
                    $conn->rollback();
                    $errors[] = "Database error: " . $stmt->error;
                    if (file_exists($idProofPath)) unlink($idProofPath);
                    if ($professionalDocPath && file_exists($professionalDocPath)) unlink($professionalDocPath);
                }
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                $errors[] = "A database error occurred: " . $e->getMessage();
                if (file_exists($idProofPath)) unlink($idProofPath);
                if ($professionalDocPath && file_exists($professionalDocPath)) unlink($professionalDocPath);
            }
        }
    }
    
    // If there were any errors, store them in a session variable
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
    }

    // Redirect to the same page to show messages and prevent form resubmission
    header('Location: register-tasker.php');
    exit;
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
      <div class="col-md-6 position-relative">
    <label for="skills_input" class="form-label text-dark">Skills / Experience</label>
    <div class="skills-container form-control">
        <div id="skills_tags" class="d-flex flex-wrap gap-2">
            </div>
        <input type="text" id="skills_input" class="skills-input" placeholder="Type and select skills">
    </div>

    <input type="hidden" name="skills" id="skills_hidden">

    <div id="autocomplete_results" class="autocomplete-dropdown"></div>
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
<style>
  .skills-container {
    height: auto;
    min-height: 100px;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
    cursor: text;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.skills-input {
    flex-grow: 1;
    border: none;
    outline: none;
    padding: 0;
    margin: 5px 0;
    background-color: transparent;
}

.skill-tag {
    display: flex;
    align-items: center;
    background-color: #e2e6ea;
    color: #495057;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9rem;
    margin: 5px;
}

.skill-tag .close {
    cursor: pointer;
    margin-left: 8px;
    font-weight: bold;
    color: #888;
}

.autocomplete-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: none;
}

.autocomplete-dropdown div {
    padding: 10px;
    cursor: pointer;
    color: #495057;
}

.autocomplete-dropdown div:hover {
    background-color: #f1f1f1;
}

/* Optional: To make the dropdown appear correctly */
.col-md-6.position-relative {
    position: relative;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const skillsInput = document.getElementById('skills_input');
    const skillsTagsContainer = document.getElementById('skills_tags');
    const skillsHiddenInput = document.getElementById('skills_hidden');
    const autocompleteResults = document.getElementById('autocomplete_results');
    
    // Sample list of skills. You can replace this with a list from your database.
    const allSkills = [
        'Plumbing', 'Electrical Repair', 'Carpentry', 'Gardening', 
        'Painting', 'Cleaning', 'IT Support', 'Web Design',
        'Appliance Repair', 'Childcare', 'Pet Sitting', 'Moving Help'
    ];

    let selectedSkills = [];

    // Function to update the hidden input field with selected skills
    function updateHiddenInput() {
        skillsHiddenInput.value = selectedSkills.join(',');
    }

    // Function to render a new skill tag
    function createSkillTag(skillName) {
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.innerHTML = `${skillName} <span class="close">&times;</span>`;
        skillsTagsContainer.appendChild(tag);

        tag.querySelector('.close').addEventListener('click', function() {
            tag.remove();
            selectedSkills = selectedSkills.filter(s => s !== skillName);
            updateHiddenInput();
            skillsInput.focus();
        });
    }

    // Function to add a skill from the autocomplete list
    function addSkill(skillName) {
        if (!selectedSkills.includes(skillName)) {
            selectedSkills.push(skillName);
            createSkillTag(skillName);
            updateHiddenInput();
        }
        skillsInput.value = '';
        autocompleteResults.style.display = 'none';
        skillsInput.focus();
    }

    // Handle user typing in the input field
    skillsInput.addEventListener('input', function() {
        const query = skillsInput.value.toLowerCase();
        autocompleteResults.innerHTML = '';
        
        if (query.length > 0) {
            const filteredSkills = allSkills.filter(skill => 
                skill.toLowerCase().includes(query) && !selectedSkills.includes(skill)
            );

            if (filteredSkills.length > 0) {
                filteredSkills.forEach(skill => {
                    const div = document.createElement('div');
                    div.textContent = skill;
                    div.addEventListener('click', () => addSkill(skill));
                    autocompleteResults.appendChild(div);
                });
                autocompleteResults.style.display = 'block';
            } else {
                autocompleteResults.style.display = 'none';
            }
        } else {
            autocompleteResults.style.display = 'none';
        }
    });

    // Close dropdown if user clicks outside
    document.addEventListener('click', function(e) {
        if (!autocompleteResults.contains(e.target) && e.target !== skillsInput) {
            autocompleteResults.style.display = 'none';
        }
    });

    // Focus on the input when the skills container is clicked
    document.querySelector('.skills-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('skills-container') || e.target.id === 'skills_tags') {
            skillsInput.focus();
        }
    });

    // Handle adding a skill when the user presses Enter
    skillsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const firstResult = autocompleteResults.querySelector('div');
            if (firstResult) {
                addSkill(firstResult.textContent);
            } else if (skillsInput.value.trim() !== '') {
                // If no autocomplete result, add the typed text as a new skill
                addSkill(skillsInput.value.trim());
            }
        }
    });
});
</script>