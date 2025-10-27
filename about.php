<?php
$pageTitle = 'About Us - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .about-header {
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }
    
    .about-section {
        padding: 3rem 0;
    }
    
    .feature-box {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 40px;
    }
    
    .team-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .team-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2, #1565c0);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 600;
        margin: 0 auto 1rem;
    }
</style>

<!-- Header -->
<div class="about-header">
    <div class="container text-center">
        <h1 class="fw-bold mb-3">About Whole Student Hub</h1>
        <p class="lead mb-0 opacity-90">Empowering students through comprehensive support and guidance</p>
    </div>
</div>

<!-- Mission Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Our Mission</h2>
                <p class="text-muted mb-3">
                    Whole Student Hub is dedicated to providing a unified digital platform that supports every aspect of student life. 
                    We believe that academic success goes hand-in-hand with personal well-being, and our mission is to make 
                    comprehensive support accessible to every student.
                </p>
                <p class="text-muted">
                    Through our platform, students can easily access academic tutoring, mental health counseling, career guidance, 
                    and peer mentorship—all in one place. We're committed to creating a supportive community where every student 
                    can thrive.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <span class="material-icons" style="font-size: 250px; color: var(--primary-color); opacity: 0.2;">school</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="about-section" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">favorite</span>
                    </div>
                    <h5 class="fw-bold mb-3">Student-Centered</h5>
                    <p class="text-muted">Every decision we make puts student needs and well-being first.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">lock</span>
                    </div>
                    <h5 class="fw-bold mb-3">Confidential</h5>
                    <p class="text-muted">Your privacy and confidentiality are our top priorities.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">accessibility</span>
                    </div>
                    <h5 class="fw-bold mb-3">Accessible</h5>
                    <p class="text-muted">Support should be easy to find and available when you need it.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">diversity_3</span>
                    </div>
                    <h5 class="fw-bold mb-3">Inclusive</h5>
                    <p class="text-muted">We celebrate diversity and create a welcoming space for all.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">trending_up</span>
                    </div>
                    <h5 class="fw-bold mb-3">Growth-Oriented</h5>
                    <p class="text-muted">We're committed to continuous improvement and innovation.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <span class="material-icons">groups</span>
                    </div>
                    <h5 class="fw-bold mb-3">Community-Driven</h5>
                    <p class="text-muted">Building connections and fostering peer support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What We Offer -->
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">What We Offer</h2>
            <p class="text-muted">Comprehensive support services for your success</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div>
                        <div class="feature-icon" style="width: 60px; height: 60px; font-size: 30px;">
                            <span class="material-icons">school</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Academic Support</h5>
                        <p class="text-muted">One-on-one tutoring, study groups, and academic resources to help you excel in your courses.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div>
                        <div class="feature-icon" style="width: 60px; height: 60px; font-size: 30px;">
                            <span class="material-icons">psychology</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Mental Health Counseling</h5>
                        <p class="text-muted">Professional counseling services for stress, anxiety, and personal challenges.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div>
                        <div class="feature-icon" style="width: 60px; height: 60px; font-size: 30px;">
                            <span class="material-icons">work</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Career Guidance</h5>
                        <p class="text-muted">Resume building, interview preparation, and career planning assistance.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div>
                        <div class="feature-icon" style="width: 60px; height: 60px; font-size: 30px;">
                            <span class="material-icons">groups</span>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Peer Mentorship</h5>
                        <p class="text-muted">Connect with experienced students who can guide you through your academic journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="about-section" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); color: white;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
        <p class="lead mb-4 opacity-90">Join thousands of students already benefiting from our platform</p>
        <a href="<?php echo BASE_URL; ?>auth/signup.php" class="btn btn-light btn-lg">
            <span class="material-icons" style="vertical-align: middle;">person_add</span>
            Create Your Account
        </a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
