<?php
require_once 'db.php';

function login($username, $password, $isAdmin = false) {
    $db = new Database();
    $conn = $db->connect();
    
    // Query the Users table (can login with email)
    $sql = "SELECT * FROM Users WHERE Email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['ResidentID'];
            $_SESSION['username'] = $user['Email'];
            $_SESSION['full_name'] = $user['FirstName'] . ' ' . $user['LastName'];
            $_SESSION['role'] = $user['Role']; // 'admin' or 'resident'
            return true;
        }
    }
    return false;
}

function register($first_name, $last_name, $email, $password, $contact_number, $address, $birth_date, $gender) {
    $db = new Database();
    $conn = $db->connect();
    
    // Check if email already exists
    $check_sql = "SELECT ResidentID FROM Users WHERE Email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        return false;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO Users (FirstName, LastName, Email, Password, ContactNumber, Address, BirthDate, Gender, Role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'resident')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $hashed_password, $contact_number, $address, $birth_date, $gender);
    
    return $stmt->execute();
}

function logout() {
    session_destroy();
    header('Location: ' . SITE_URL . '/public/index.php');
    exit();
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('public/login.php');
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        redirect('public/index.php');
    }
}

// Handle logout request
if (isset($_GET['logout'])) {
    logout();
}
?>