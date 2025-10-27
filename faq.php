<?php
$pageTitle = 'FAQ - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .faq-header {
        background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .faq-section {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .accordion-button {
        background: var(--card-bg);
        color: var(--text-primary);
        font-weight: 600;
    }
    
    .accordion-button:not(.collapsed) {
        background: var(--primary-color);
        color: white;
    }
</style>

<!-- Header -->
<div class="faq-header">
    <div class="container">
        <h1 class="fw-bold mb-2">Frequently Asked Questions</h1>
        <p class="mb-0 opacity-90">Find answers to common questions about our platform</p>
    </div>
</div>

<div class="container mb-5">
    <div class="faq-section">
        <h4 class="fw-bold mb-4">General Questions</h4>
        
        <div class="accordion" id="generalAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#general1">
                        What is Whole Student Hub?
                    </button>
                </h2>
                <div id="general1" class="accordion-collapse collapse show" data-mdb-parent="#generalAccordion">
                    <div class="accordion-body">
                        Whole Student Hub is a comprehensive digital platform designed to support students in all aspects of their academic and personal lives. We provide access to academic tutoring, mental health counseling, career guidance, peer mentorship, and various resources—all in one convenient location.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#general2">
                        Who can use this platform?
                    </button>
                </h2>
                <div id="general2" class="accordion-collapse collapse" data-mdb-parent="#generalAccordion">
                    <div class="accordion-body">
                        The platform is available to all students, mentors, and counselors. Students can access support services, while mentors and counselors can provide guidance and assistance through the platform.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#general3">
                        Is the platform free to use?
                    </button>
                </h2>
                <div id="general3" class="accordion-collapse collapse" data-mdb-parent="#generalAccordion">
                    <div class="accordion-body">
                        Yes! All core services on Whole Student Hub are completely free for students. Our mission is to make support accessible to everyone.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="faq-section">
        <h4 class="fw-bold mb-4">Account & Registration</h4>
        
        <div class="accordion" id="accountAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#account1">
                        How do I create an account?
                    </button>
                </h2>
                <div id="account1" class="accordion-collapse collapse" data-mdb-parent="#accountAccordion">
                    <div class="accordion-body">
                        Click on the "Sign Up" button in the navigation bar, fill out the registration form with your details, select your role (Student/Mentor/Counselor), and submit. You'll be able to log in immediately after registration.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#account2">
                        I forgot my password. What should I do?
                    </button>
                </h2>
                <div id="account2" class="accordion-collapse collapse" data-mdb-parent="#accountAccordion">
                    <div class="accordion-body">
                        Click on "Forgot Password" on the login page, enter your registered email address, and follow the instructions sent to your email to reset your password.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="faq-section">
        <h4 class="fw-bold mb-4">Appointments & Services</h4>
        
        <div class="accordion" id="appointmentAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#appointment1">
                        How do I book an appointment?
                    </button>
                </h2>
                <div id="appointment1" class="accordion-collapse collapse" data-mdb-parent="#appointmentAccordion">
                    <div class="accordion-body">
                        Browse the available services, select the one you need, click "Book Appointment," fill out the request form with your details and concerns, and submit. You'll receive a confirmation once your request is reviewed.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#appointment2">
                        How long does it take to get a response?
                    </button>
                </h2>
                <div id="appointment2" class="accordion-collapse collapse" data-mdb-parent="#appointmentAccordion">
                    <div class="accordion-body">
                        Most appointment requests are reviewed within 24-48 hours. Urgent requests are prioritized and may receive faster responses.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#appointment3">
                        Can I cancel or reschedule an appointment?
                    </button>
                </h2>
                <div id="appointment3" class="accordion-collapse collapse" data-mdb-parent="#appointmentAccordion">
                    <div class="accordion-body">
                        Yes, you can cancel pending or accepted appointments from your "My Appointments" page. For rescheduling, please contact the assigned counselor or mentor directly.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="faq-section">
        <h4 class="fw-bold mb-4">Privacy & Security</h4>
        
        <div class="accordion" id="privacyAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#privacy1">
                        Is my information confidential?
                    </button>
                </h2>
                <div id="privacy1" class="accordion-collapse collapse" data-mdb-parent="#privacyAccordion">
                    <div class="accordion-body">
                        Absolutely. We take your privacy very seriously. All personal information and counseling sessions are kept strictly confidential and are only accessible to authorized staff members directly involved in your support.
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#privacy2">
                        How is my data protected?
                    </button>
                </h2>
                <div id="privacy2" class="accordion-collapse collapse" data-mdb-parent="#privacyAccordion">
                    <div class="accordion-body">
                        We use industry-standard security measures including encrypted connections, secure password storage, and regular security audits to protect your data.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Still Have Questions -->
    <div class="text-center mt-5">
        <h4 class="fw-bold mb-3">Still Have Questions?</h4>
        <p class="text-muted mb-4">Can't find the answer you're looking for? We're here to help!</p>
        <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-primary btn-lg">
            <span class="material-icons" style="vertical-align: middle;">contact_support</span>
            Contact Support
        </a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
