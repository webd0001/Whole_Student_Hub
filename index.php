<?php
$pageTitle = 'Home - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: bottom;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }
    
    /* Features Section */
    .features-section {
        padding: 4rem 0;
    }
    
    .feature-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 40px;
    }
    
    .feature-icon.academic {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
    }
    
    .feature-icon.mental {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
    }
    
    .feature-icon.mentorship {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: white;
    }
    
    .feature-icon.career {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        color: white;
    }
    
    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
        color: white;
        padding: 3rem 0;
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    /* Testimonials */
    .testimonial-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .testimonial-text {
        font-style: italic;
        margin-bottom: 1rem;
        color: var(--text-secondary);
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2, #1565c0);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    
    /* CTA Section */
    .cta-section {
        background: var(--card-bg);
        padding: 4rem 0;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">Your Digital Campus Companion</h1>
                <p class="hero-subtitle">
                    A unified platform for student well-being, academic guidance, mentoring, and resource access. 
                    Get the support you need, when you need it.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo BASE_URL; ?>auth/signup.php" class="btn btn-light btn-lg">
                        <span class="material-icons" style="vertical-align: middle;">person_add</span>
                        Get Started
                    </a>
                    <a href="<?php echo BASE_URL; ?>services.php" class="btn btn-outline-light btn-lg">
                        <span class="material-icons" style="vertical-align: middle;">explore</span>
                        Explore Services
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <span class="material-icons" style="font-size: 300px; opacity: 0.2;">school</span>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Comprehensive Support Services</h2>
            <p class="text-muted">Everything you need for academic success and personal well-being</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon academic">
                        <span class="material-icons">school</span>
                    </div>
                    <h5 class="fw-bold mb-3">Academic Help</h5>
                    <p class="text-muted">One-on-one tutoring, study groups, and academic resources to help you excel.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mental">
                        <span class="material-icons">psychology</span>
                    </div>
                    <h5 class="fw-bold mb-3">Mental Health Support</h5>
                    <p class="text-muted">Confidential counseling and wellness resources for your emotional well-being.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mentorship">
                        <span class="material-icons">groups</span>
                    </div>
                    <h5 class="fw-bold mb-3">Mentorship</h5>
                    <p class="text-muted">Connect with experienced mentors for guidance and career advice.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon career">
                        <span class="material-icons">work</span>
                    </div>
                    <h5 class="fw-bold mb-3">Career Guidance</h5>
                    <p class="text-muted">Resume building, interview prep, and job search assistance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Active Students</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Mentors & Counselors</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">15K+</div>
                    <div class="stat-label">Sessions Completed</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">How It Works</h2>
            <p class="text-muted">Get started in just a few simple steps</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon academic mb-3">
                        <span class="material-icons">person_add</span>
                    </div>
                    <h5 class="fw-bold">1. Sign Up</h5>
                    <p class="text-muted">Create your free account in seconds</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mental mb-3">
                        <span class="material-icons">search</span>
                    </div>
                    <h5 class="fw-bold">2. Browse Services</h5>
                    <p class="text-muted">Find the support you need</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mentorship mb-3">
                        <span class="material-icons">event</span>
                    </div>
                    <h5 class="fw-bold">3. Book Appointment</h5>
                    <p class="text-muted">Schedule a session that fits your time</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon career mb-3">
                        <span class="material-icons">check_circle</span>
                    </div>
                    <h5 class="fw-bold">4. Get Support</h5>
                    <p class="text-muted">Connect and grow with expert guidance</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="features-section" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">What Students Say</h2>
            <p class="text-muted">Real experiences from our community</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "The counseling services helped me manage stress during finals. The platform made it so easy to book sessions!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">SK</div>
                        <div>
                            <div class="fw-bold">Sarah Khan</div>
                            <small class="text-muted">Computer Science, Junior</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "Found an amazing mentor who guided me through my career decisions. This platform is a game-changer!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">RP</div>
                        <div>
                            <div class="fw-bold">Raj Patel</div>
                            <small class="text-muted">Business, Senior</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        "The academic tutoring helped me improve my grades significantly. Highly recommend to all students!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">EC</div>
                        <div>
                            <div class="fw-bold">Emily Chen</div>
                            <small class="text-muted">Engineering, Sophomore</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
        <p class="text-muted mb-4">Join thousands of students already benefiting from our platform</p>
        <a href="<?php echo BASE_URL; ?>auth/signup.php" class="btn btn-primary btn-lg">
            <span class="material-icons" style="vertical-align: middle;">rocket_launch</span>
            Get Support Now
        </a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
