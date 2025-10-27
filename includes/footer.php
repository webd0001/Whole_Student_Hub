    <!-- Footer -->
    <footer class="mt-5 py-4" style="background: var(--card-bg); border-top: 1px solid rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">
                        <span class="material-icons" style="vertical-align: middle;">school</span>
                        Whole Student Hub
                    </h5>
                    <p class="text-muted">Your comprehensive digital companion for academic success and well-being.</p>
                </div>
                <div class="col-md-2 mb-3">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>about.php" class="text-muted text-decoration-none">About Us</a></li>
                        <li><a href="<?php echo BASE_URL; ?>services.php" class="text-muted text-decoration-none">Services</a></li>
                        <li><a href="<?php echo BASE_URL; ?>resources.php" class="text-muted text-decoration-none">Resources</a></li>
                        <li><a href="<?php echo BASE_URL; ?>faq.php" class="text-muted text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h6 class="fw-bold">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>contact.php" class="text-muted text-decoration-none">Contact Us</a></li>
                        <li><a href="<?php echo BASE_URL; ?>support-tickets.php" class="text-muted text-decoration-none">Help Center</a></li>
                        <li><a href="<?php echo BASE_URL; ?>privacy.php" class="text-muted text-decoration-none">Privacy Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>terms.php" class="text-muted text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Contact Info</h6>
                    <p class="text-muted mb-1">
                        <span class="material-icons" style="vertical-align: middle; font-size: 18px;">email</span>
                        support@wholestudent.com
                    </p>
                    <p class="text-muted mb-1">
                        <span class="material-icons" style="vertical-align: middle; font-size: 18px;">phone</span>
                        +91 123 456 7890
                    </p>
                    <p class="text-muted">
                        <span class="material-icons" style="vertical-align: middle; font-size: 18px;">location_on</span>
                        Campus Student Center
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center text-muted">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Whole Student Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- MDB UI Kit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    
    <?php if (isset($additionalJS)) echo $additionalJS; ?>
</body>
</html>
