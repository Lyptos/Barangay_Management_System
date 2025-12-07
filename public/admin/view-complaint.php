<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$incident_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$incident = getIncidentById($incident_id);

if (!$incident) {
    header('Location: complaints.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = sanitizeInput($_POST['status']);
    $admin_response = sanitizeInput($_POST['admin_response']);
    
    $db = new Database();
    $conn = $db->connect();
    
    // Fixed: Use correct table and column names
    $sql = "UPDATE Incidents SET Status = ?, AdminResponse = ? WHERE IncidentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $admin_response, $incident_id);
    
    if ($stmt->execute()) {
        $success = "Complaint updated successfully!";
        $incident = getIncidentById($incident_id); // Refresh data
    } else {
        $error = "Failed to update complaint.";
    }
}

$page_title = 'View Complaint';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <a href="complaints.php" class="btn btn-secondary">← Back to Complaints</a>
    
    <div class="complaint-detail">
        <h1>Complaint Details</h1>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Tracking Number:</strong>
                <p><?php echo $incident['TrackingNumber']; ?></p>
            </div>
            <div class="info-item">
                <strong>Status:</strong>
                <p><span class="badge badge-<?php echo strtolower(str_replace(' ', '-', $incident['Status'])); ?>"><?php echo $incident['Status']; ?></span></p>
            </div>
            <div class="info-item">
                <strong>Type:</strong>
                <p><?php echo ucfirst($incident['IncidentType']); ?></p>
            </div>
            <div class="info-item">
                <strong>Date Filed:</strong>
                <p><?php echo date('F d, Y', strtotime($incident['DateReported'])); ?></p>
            </div>
        </div>
        
        <div class="card">
            <h3>Resident Information</h3>
            <p><strong>Name:</strong> <?php echo $incident['resident_name']; ?></p>
            <p><strong>Contact:</strong> <?php echo $incident['ContactNumber']; ?></p>
            <p><strong>Address:</strong> <?php echo $incident['Address']; ?></p>
        </div>
        
        <div class="card">
            <h3>Complaint Information</h3>
            <p><strong>Type:</strong> <?php echo $incident['IncidentType']; ?></p>
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br($incident['Description']); ?></p>
        </div>
        
        <div class="card">
            <h3>Update Complaint</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Pending" <?php echo $incident['Status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="In Progress" <?php echo $incident['Status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Resolved" <?php echo $incident['Status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                        <option value="Closed" <?php echo $incident['Status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Admin Response:</label>
                    <textarea name="admin_response" rows="5"><?php echo $incident['AdminResponse']; ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Complaint</button>
            </form>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>