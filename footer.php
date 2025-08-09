<footer class="footer-section bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-3">HandyHelp</h5>
                    <p>Connecting you with trusted local professionals for all your home service needs — quick, reliable, and affordable.</p>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">About</a></li>
                        <li><a href="#" class="footer-link">How it Works</a></li>
                        <li><a href="become-a-tasker.php" class="footer-link">Become a Tasker</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h6 class="mb-3">Popular Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Furniture Assembly</a></li>
                        <li><a href="#" class="footer-link">House Cleaning</a></li>
                        <li><a href="#" class="footer-link">Plumbing</a></li>
                        <li><a href="#" class="footer-link">TV Mounting</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3">Stay Updated</h6>
                    <form class="d-flex mb-3" onsubmit="return false;">
        <input type="email" class="form-control me-2 email-link" placeholder="Your email">
        <button class="btn btn-custom-orange">→</button>
    </form>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 border-top pt-3 small text-secondary">
                &copy; 2025 HandyHelp. All rights reserved.
            </div>
        </div>
    </footer>
    <script>
    document.querySelector(".email-link").addEventListener("focus", function() {
        window.location.href = "contact.php"; // Change to your Contact Us page link
    });
</script>
<style>
    .email-link {
    cursor: pointer;
}

.email-link:focus {
    outline: 2px solid #FF7E38; /* Orange border when clicked */
    background-color: #fff6f0;   /* Light orange background */
}
</style>