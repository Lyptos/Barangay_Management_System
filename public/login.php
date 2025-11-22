<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        redirect('admin/dashboard.php');
    } else {
        redirect('resident/dashboard.php');
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $login_type = $_POST['login_type'];
    
    $isAdmin = ($login_type === 'admin');
    
    if (login($username, $password, $isAdmin)) {
        if ($isAdmin) {
            redirect('admin/dashboard.php');
        } else {
            redirect('resident/dashboard.php');
        }
    } else {
        $error = 'Invalid username or password';
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
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Login As:</label>
                <select name="login_type" required>
                    <option value="resident">Resident</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Username/Email:</label>
                <input type="text" name="username" required>
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