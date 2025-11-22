<?php
require_once 'db.php';

function redirect($url) {
    header("Location: " . SITE_URL . "/" . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function generateTrackingNumber() {
    return 'TRK-' . date('Y') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getIncidents($status = null) {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "SELECT i.*, 
            CONCAT(r.FirstName, ' ', r.LastName) as resident_name, 
            r.ContactNumber,
            o.FullName as handled_by_name
            FROM Incidents i 
            LEFT JOIN Residents r ON i.ReportedBy = r.ResidentID
            LEFT JOIN Officials o ON i.HandledBy = o.OfficialID";
    
    if ($status) {
        $sql .= " WHERE i.Status = ?";
    }
    
    $sql .= " ORDER BY i.DateReported DESC, i.IncidentID DESC";
    
    $stmt = $conn->prepare($sql);
    if ($status) {
        $stmt->bind_param("s", $status);
    }
    $stmt->execute();
    return $stmt->get_result();
}

function getIncidentById($id) {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "SELECT i.*, 
            CONCAT(r.FirstName, ' ', r.LastName) as resident_name,
            r.ContactNumber, 
            r.Address,
            r.Email,
            o.FullName as handled_by_name
            FROM Incidents i 
            LEFT JOIN Residents r ON i.ReportedBy = r.ResidentID
            LEFT JOIN Officials o ON i.HandledBy = o.OfficialID
            WHERE i.IncidentID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getComplaintStats() {
    $db = new Database();
    $conn = $db->connect();
    
    $stats = [];
    
    $result = $conn->query("SELECT COUNT(*) as total FROM Incidents");
    $stats['total'] = $result->fetch_assoc()['total'];
    
    $result = $conn->query("SELECT COUNT(*) as pending FROM Incidents WHERE Status = 'Pending'");
    $stats['pending'] = $result->fetch_assoc()['pending'];
    
    $result = $conn->query("SELECT COUNT(*) as in_progress FROM Incidents WHERE Status = 'In Progress'");
    $stats['in_progress'] = $result->fetch_assoc()['in_progress'];
    
    $result = $conn->query("SELECT COUNT(*) as resolved FROM Incidents WHERE Status = 'Resolved'");
    $stats['resolved'] = $result->fetch_assoc()['resolved'];
    
    return $stats;
}

function getOfficials() {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "SELECT * FROM Officials ORDER BY Position, FullName";
    return $conn->query($sql);
}

function getResidents() {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "SELECT * FROM Residents ORDER BY LastName, FirstName";
    return $conn->query($sql);
}

function getTotalResidents() {
    $db = new Database();
    $conn = $db->connect();
    
    $result = $conn->query("SELECT COUNT(*) as total FROM Residents");
    return $result->fetch_assoc()['total'];
}

function getTotalOfficials() {
    $db = new Database();
    $conn = $db->connect();
    
    $result = $conn->query("SELECT COUNT(*) as total FROM Officials");
    return $result->fetch_assoc()['total'];
}
?>