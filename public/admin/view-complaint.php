<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$success = '';
$error = '';

if (!isset($_GET['id'])) {
    redirect('admin/complaints.php');
}

$complaint_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = sanitizeInput($_POST['status']);
    $admin_response = sanitizeInput($_POST['admin_response']);
    
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "UPDATE complaints SET status = ?, admin_response = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $admin_response, $complaint_id);
    
    if ($stmt->execute()) {
        $success = "Complaint updated successfully!";
    } else {
        $error = "Failed to update complaint.";
    }
}

$complaint = getComplaintById($complaint_id);

if (!$complaint) {
    redirect('admin/complaints.php');
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
                <p><?php echo $complaint['TrackingNumber']; ?></p>
            </div>
            <div class="info-item">
                <strong>Status:</strong>
                <p><span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span></p>
            </div>
            <div class="info-item">
                <strong>Type:</strong>
                <p><?php echo ucfirst($complaint['IncidentType']); ?></p>
            </div>
            <div class="info-item">
                <strong>Date Filed:</strong>
                <p><?php echo date('F d, Y', strtotime($complaint['DateReported'])); ?></p>
            </div>
        </div>
        
        <div class="card">
            <h3>Resident Information</h3>
            <p><strong>Name:</strong> <?php echo $complaint['full_name']; ?></p>
            <p><strong>Contact:</strong> <?php echo $complaint['contact_number']; ?></p>
            <p><strong>Address:</strong> <?php echo $complaint['address']; ?></p>
        </div>
        
        <div class="card">
            <h3>Complaint Information</h3>
            <p><strong>Type:</strong> <?php echo $complaint['IncidentType']; ?></p>
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br($complaint['Description']); ?></p>
        </div>
        
        <div class="card">
            <h3>Update Complaint</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Pending" <?php echo $complaint['Status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="In Progress" <?php echo $complaint['Status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Resolved" <?php echo $complaint['Status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                        <option value="Closed" <?php echo $complaint['Status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Admin Response:</label>
                    <textarea name="admin_response" rows="5"><?php echo $complaint['admin_response']; ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Complaint</button>
            </form>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>
