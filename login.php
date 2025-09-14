<?php
// Start the session
session_start();

// Initialize message variables
$message = '';
$message_type = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db.php';

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
            $message_type = 'danger';
        }
    } else {
        $message = "No user found with that email.";
        $message_type = 'danger';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandyHelp - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    
</head>
<body>

    


    <nav class="navbar navbar-light bg-white border-bottom p-3 px-4 navbar-fixed-top">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <img src="images/logo2.png" alt="HandyHelp" height="50"> HandyHelp
        </a>
        <div class="d-flex gap-3 align-items-center">
              <a href="index.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Home</a>
            <a href="Services2.php" class="text-dark fw-semibold text-decoration-none">Services</a>
            <a href="signup.html" class="text-dark fw-semibold text-decoration-none">Sign up</a>
            <a href="become-a-tasker.php" class="btn btn-outline-success">Become a Tasker</a>
        </div>
    </nav>

    <div class="login-container text-center mt-5">
        <h2>Log in to HandyHelp</h2>
        <p>Or <a href="signup.html" class="link-text">sign up for a new account</a></p>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> mt-4" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-social btn-google mb-3">
            <i class="fab fa-google me-2"></i> Log in with Google
        </button>

        <div class="divider">or</div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mt-3">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email address" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="#" class="link-text">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log in</button>
        </form>
    </div>

</body>


<script type="module">
    // Import the required Firebase services
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.2.1/firebase-app.js";
    import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.2.1/firebase-auth.js";

    const firebaseConfig = {
      apiKey: "AIzaSyD-84LrmbOuwIRfi6Olj9LbFi_EVAc_Jew",
      authDomain: "udyami-2cf62.firebaseapp.com",
      projectId: "udyami-2cf62",
      storageBucket: "udyami-2cf62.firebasestorage.app",
      messagingSenderId: "404146319005",
      appId: "1:404146319005:web:2226ea2b10bac68da86e74",
      measurementId: "G-CYY61V2DRE"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    // Get the Google login button from the DOM
    const googleLoginBtn = document.querySelector('.btn-social.btn-google');

    // Add a click event listener to the button
    googleLoginBtn.addEventListener('click', () => {
        signInWithPopup(auth, provider)
            .then((result) => {
                // This gives you a Google Access Token.
                const user = result.user;
                const email = user.email;
                const uid = user.uid; // This is the unique Google User ID
                const fullName = user.displayName;

                // Send this user info to your PHP backend to handle
                fetch('google_auth_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        google_id: uid,
                        fullname: fullName
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'dashboard.php'; // Redirect on success
                    } else {
                        console.error('Login failed on backend:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error sending data to backend:', error);
                });
            })
            .catch((error) => {
                // Handle Errors here
                console.error("Google sign-in error:", error.message);
            });
    });
</script>
</html>