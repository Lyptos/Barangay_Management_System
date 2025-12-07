<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$success = '';
$error = '';

// Handle email update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_email'])) {
    $new_email = sanitizeInput($_POST['email']);
    
    $db = new Database();
    $conn = $db->connect();
    
    // Check if email already exists for another user
    $check_sql = "SELECT ResidentID FROM Users WHERE Email = ? AND ResidentID != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $new_email, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $error = "This email is already in use by another user.";
    } else {
        $update_sql = "UPDATE Users SET Email = ? WHERE ResidentID = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_email, $user_id);
        
        if ($update_stmt->execute()) {
            $success = "Email updated successfully!";
        } else {
            $error = "Failed to update email.";
        }
    }
}

// Get resident data
$db = new Database();
$conn = $db->connect();

$sql = "SELECT * FROM Users WHERE ResidentID = ? AND Role = 'resident'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$resident = $result->fetch_assoc();

if (!$resident) {
    header('Location: residents.php');
    exit();
}

// Get resident's complaints
$complaint_sql = "SELECT * FROM Incidents WHERE ReportedBy = ? ORDER BY DateReported DESC";
$complaint_stmt = $conn->prepare($complaint_sql);
$complaint_stmt->bind_param("i", $user_id);
$complaint_stmt->execute();
$complaints = $complaint_stmt->get_result();

$page_title = 'View Resident';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <a href="residents.php" class="btn btn-secondary">← Back to Residents</a>
    
    <div class="complaint-detail">
        <h1>Resident Profile</h1>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Full Name:</strong>
                <p><?php echo $resident['FirstName'] . ' ' . $resident['LastName']; ?></p>
            </div>
            <div class="info-item">
                <strong>Email:</strong>
                <p><?php echo $resident['Email']; ?></p>
            </div>
            <div class="info-item">
                <strong>Contact Number:</strong>
                <p><?php echo $resident['ContactNumber']; ?></p>
            </div>
            <div class="info-item">
                <strong>Gender:</strong>
                <p><?php echo $resident['Gender']; ?></p>
            </div>
            <div class="info-item">
                <strong>Birth Date:</strong>
                <p><?php echo date('F d, Y', strtotime($resident['BirthDate'])); ?></p>
            </div>
            <div class="info-item">
                <strong>Age:</strong>
                <p><?php 
                    $birthDate = new DateTime($resident['BirthDate']);
                    $today = new DateTime();
                    $age = $today->diff($birthDate)->y;
                    echo $age . ' years old';
                ?></p>
            </div>
        </div>
        
        <div class="card">
            <h3>Address</h3>
            <p><?php echo nl2br($resident['Address']); ?></p>
        </div>
        
        <div class="card">
            <h3>Update Email</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($resident['Email']); ?>" required>
                </div>
                <button type="submit" name="update_email" class="btn btn-primary">Update Email</button>
            </form>
        </div>
        
        <div class="card">
            <h3>Account Information</h3>
            <p><strong>Resident ID:</strong> <?php echo $resident['ResidentID']; ?></p>
            <p><strong>Date Registered:</strong> <?php echo date('F d, Y', strtotime($resident['CreatedAt'])); ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst($resident['Role']); ?></p>
        </div>
        
        <div class="card">
            <h3>Complaint History</h3>
            <?php if ($complaints->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tracking #</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($complaint = $complaints->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $complaint['TrackingNumber']; ?></td>
                                <td><?php echo ucfirst($complaint['IncidentType']); ?></td>
                                <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span></td>
                                <td><?php echo date('M d, Y', strtotime($complaint['DateReported'])); ?></td>
                                <td>
                                    <a href="view-complaint.php?id=<?php echo $complaint['IncidentID']; ?>" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No complaints filed yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>