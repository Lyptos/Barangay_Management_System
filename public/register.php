<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

if (isLoggedIn()) {
    header('Location: ' . SITE_URL . '/public/resident/dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $contact_number = sanitizeInput($_POST['contact_number']);
    $address = sanitizeInput($_POST['address']);
    
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        if (register($full_name, $email, $password, $contact_number, $address)) {
            $success = 'Registration successful! You can now login.';
        } else {
            $error = 'Email already exists or registration failed';
        }
    }
}

$page_title = 'Register';
include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="container">
    <div class="form-container">
        <h2>Register as Resident</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" name="contact_number" required>
            </div>
            
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" rows="3" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

<?php include '../templates/footer.php'; ?>