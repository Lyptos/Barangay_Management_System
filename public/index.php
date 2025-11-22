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
                <a href="register.php" class="btn btn-secondary">Register</a>
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
    <section class="features">
        <h2>How It Works</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>1. Register</h3>
                <p>Create your account as a barangay resident</p>
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