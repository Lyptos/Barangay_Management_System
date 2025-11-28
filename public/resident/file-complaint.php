<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();

if (isAdmin()) {
    header('Location: ' . SITE_URL . '/public/admin/dashboard.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = sanitizeInput($_POST['subject']);
    $description = sanitizeInput($_POST['description']);
    $category = sanitizeInput($_POST['category']);
    $resident_id = $_SESSION['user_id'];
    $tracking_number = generateTrackingNumber();
    $date_reported = date('Y-m-d');
    
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "INSERT INTO Incidents (TrackingNumber, IncidentType, Description, DateReported, ReportedBy, Status) 
            VALUES (?, ?, ?, ?, ?, 'Pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $tracking_number, $category, $description, $date_reported, $resident_id);
    
    if ($stmt->execute()) {
        $success = "Complaint filed successfully! Your tracking number is: <strong>$tracking_number</strong>";
    } else {
        $error = "Failed to file complaint. Please try again.";
    }
}

$page_title = 'File Complaint';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <div class="form-container">
        <h2>File a Complaint</h2>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Category:</label>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="noise">Noise Complaint</option>
                    <option value="waste">Waste Management</option>
                    <option value="infrastructure">Infrastructure Issue</option>
                    <option value="security">Security Concern</option>
                    <option value="health">Health & Sanitation</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="6" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Complaint</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>