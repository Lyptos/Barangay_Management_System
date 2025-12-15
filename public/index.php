<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
$page_title = 'Home';
include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="hero">
    <div class="container">
        <h1>Welcome to Barangay Complaint Management System</h1>
        <p>Submit and track your complaints easily</p>
        <?php if (!isLoggedIn()): ?>
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-primary">Login</a>
            </div>
        <?php else: ?>
            <div class="hero-buttons">
                <?php if (isAdmin()): ?>
                    <a href="admin/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                <?php else: ?>
                    <a href="resident/file-complaint.php" class="btn btn-primary">File a Complaint</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="emergency-warning">
        <h3>⚠️ IMPORTANT NOTICE</h3>
        <p><strong>This system is for NON-EMERGENCY complaints and minor barangay incidents only.</strong></p>
        <p>For emergencies, please call the appropriate hotline immediately:</p>
        <div class="hotline-grid">
            <div class="hotline-item">
                <strong>🚨 National Emergency Hotline:</strong> 911
            </div>
            <div class="hotline-item">
                <strong>👮 PNP Hotline:</strong> 117
            </div>
            <div class="hotline-item">
                <strong>🚒 BFP Fire Emergency:</strong> 160
            </div>
            <div class="hotline-item">
                <strong>🚑 Red Cross Emergency:</strong> 143
            </div>
            <div class="hotline-item">
                <strong>📞 NDRRMC Hotline:</strong> 1-6-3-6-5
            </div>
            <div class="hotline-item">
                <strong>👥 DSWD Crisis Line:</strong> 1-5-0-5
            </div>
        </div>
    </div>

<div class="container">
    <section class="features">
        <h2>How It Works</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>1. Contact Admin</h3>
                <p>Request account creation from barangay administrator</p>
            </div>
            <div class="feature-card">
                <h3>2. File Complaint</h3>
                <p>Submit your concerns and complaints</p>
            </div>
            <div class="feature-card">
                <h3>3. Track Status</h3>
                <p>Monitor the progress of your complaints</p>
            </div>
        </div>
    </section>
</div>

<?php include '../templates/footer.php'; ?>