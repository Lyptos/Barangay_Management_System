<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();

if (isAdmin()) {
    header('Location: ' . SITE_URL . '/public/admin/dashboard.php');
    exit();
}

$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Get current user data
$sql = "SELECT * FROM Users WHERE ResidentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $contact_number = sanitizeInput($_POST['contact_number']);
    $address = sanitizeInput($_POST['address']);
    
    $sql = "UPDATE Users SET FirstName = ?, LastName = ?, ContactNumber = ?, Address = ? WHERE ResidentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $contact_number, $address, $user_id);
    
    if ($stmt->execute()) {
        $success = 'Profile updated successfully!';
        // Refresh user data
        $_SESSION['full_name'] = $first_name . ' ' . $last_name;
        $sql = "SELECT * FROM Users WHERE ResidentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        $error = 'Failed to update profile.';
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    if (!password_verify($current_password, $user['Password'])) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $sql = "UPDATE Users SET Password = ? WHERE ResidentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            $success = 'Password changed successfully!';
        } else {
            $error = 'Failed to change password.';
        }
    }
}

$page_title = 'My Profile';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>My Profile</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="card">
        <h2>Personal Information</h2>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="<?php echo $user['FirstName']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo $user['LastName']; ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" value="<?php echo $user['Email']; ?>" disabled>
                    <small>Email cannot be changed</small>
                </div>
                
                <div class="form-group">
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" value="<?php echo $user['ContactNumber']; ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Birth Date:</label>
                    <input type="date" value="<?php echo $user['BirthDate']; ?>" disabled>
                    <small>Birth date cannot be changed</small>
                </div>
                
                <div class="form-group">
                    <label>Gender:</label>
                    <input type="text" value="<?php echo $user['Gender']; ?>" disabled>
                    <small>Gender cannot be changed</small>
                </div>
            </div>
            
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" rows="3" required><?php echo $user['Address']; ?></textarea>
            </div>
            
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
    
    <div class="card">
        <h2>Change Password</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>Current Password:</label>
                <input type="password" name="current_password" required>
            </div>
            
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="new_password" required minlength="6">
                <small>Minimum 6 characters</small>
            </div>
            
            <div class="form-group">
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_password" required minlength="6">
            </div>
            
            <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>