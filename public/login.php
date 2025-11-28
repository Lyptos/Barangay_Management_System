<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: ' . SITE_URL . '/admin/dashboard.php');
        exit();
    } else {
        header('Location: ' . SITE_URL . '/resident/dashboard.php');
        exit();
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    if (login($username, $password)) {
        // Role is automatically detected from database
        if (isAdmin()) {
            header('Location: ' . SITE_URL . '/public/admin/dashboard.php');
            exit();
        } else {
            header('Location: ' . SITE_URL . '/public/resident/dashboard.php');
            exit();
        }
    } else {
        $error = 'Invalid email or password';
    }
}

$page_title = 'Login';
include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="username" required placeholder="your@email.com">
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

<?php include '../templates/footer.php'; ?>