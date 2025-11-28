<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$incident_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$incident = getIncidentById($incident_id);

if (!$incident) {
    redirect('admin/complaints.php');
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = sanitizeInput($_POST['status']);
    $admin_response = sanitizeInput($_POST['admin_response']);
    
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "UPDATE Incidents SET Status = ?, AdminResponse = ? WHERE IncidentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $admin_response, $incident_id);
    
    if ($stmt->execute()) {
        $success = "Complaint updated successfully!";
        $incident = getIncidentById($incident_id);
    } else {
        $error = "Failed to update complaint.";
    }
}

$page_title = 'View Complaint';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Complaint Details</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="card">
        <div class="complaint-detail">
            <p><strong>Tracking Number:</strong> <?php echo $incident['TrackingNumber']; ?></p>
            <p><strong>Incident Type:</strong> <?php echo $incident['IncidentType']; ?></p>
            <p><strong>Status:</strong> <span class="badge badge-<?php echo strtolower(str_replace(' ', '-', $incident['Status'])); ?>"><?php echo $incident['Status']; ?></span></p>
            <p><strong>Date Reported:</strong> <?php echo date('F d, Y g:i A', strtotime($incident['DateReported'])); ?></p>
        </div>
        
        <h3>Resident Information</h3>
        <div class="complaint-detail">
            <p><strong>Name:</strong> <?php echo $incident['resident_name']; ?></p>
            <p><strong>Contact:</strong> <?php echo $incident['ContactNumber']; ?></p>
            <p><strong>Email:</strong> <?php echo $incident['Email']; ?></p>
            <p><strong>Address:</strong> <?php echo $incident['Address']; ?></p>
        </div>
        
        <h3>Description</h3>
        <p><?php echo nl2br($incident['Description']); ?></p>
        
        <?php if ($incident['AdminResponse']): ?>
            <h3>Admin Response</h3>
            <p><?php echo nl2br($incident['AdminResponse']); ?></p>
        <?php endif; ?>
        
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
                <textarea name="admin_response" rows="4"><?php echo $incident['AdminResponse']; ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Complaint</button>
            <a href="complaints.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>