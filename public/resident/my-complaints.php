<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();

if (isAdmin()) {
    redirect('../admin/dashboard.php');
}

$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION['user_id'];
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM Incidents WHERE ReportedBy = ?";
if ($filter_status) {
    $sql .= " AND Status = ?";
}
$sql .= " ORDER BY DateReported DESC";

$stmt = $conn->prepare($sql);
if ($filter_status) {
    $stmt->bind_param("is", $user_id, $filter_status);
} else {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$complaints = $stmt->get_result();

$page_title = 'My Complaints';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>My Complaints</h1>
    
    <div class="filter-bar">
        <a href="my-complaints.php" class="btn btn-secondary <?php echo !$filter_status ? 'active' : ''; ?>">All</a>
        <a href="?status=Pending" class="btn btn-secondary <?php echo $filter_status === 'Pending' ? 'active' : ''; ?>">Pending</a>
        <a href="?status=In Progress" class="btn btn-secondary <?php echo $filter_status === 'In Progress' ? 'active' : ''; ?>">In Progress</a>
        <a href="?status=Resolved" class="btn btn-secondary <?php echo $filter_status === 'Resolved' ? 'active' : ''; ?>">Resolved</a>
    </div>
    
    <?php if ($complaints->num_rows > 0): ?>
        <div class="complaints-list">
            <?php while ($complaint = $complaints->fetch_assoc()): ?>
                <div class="complaint-item">
                    <div class="complaint-header">
                        <h3><?php echo $complaint['IncidentType']; ?></h3>
                        <span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span>
                    </div>
                    <p><strong>Tracking #:</strong> <?php echo $complaint['TrackingNumber']; ?></p>
                    <p><strong>Type:</strong> <?php echo ucfirst($complaint['IncidentType']); ?></p>
                    <p><strong>Description:</strong> <?php echo $complaint['Description']; ?></p>
                    <p class="text-muted">Filed on: <?php echo date('F d, Y', strtotime($complaint['DateReported'])); ?></p>
                    <?php if ($complaint['AdminResponse']): ?>
                        <div class="admin-response">
                            <strong>Admin Response:</strong>
                            <p><?php echo $complaint['AdminResponse']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No complaints found.</p>
        <a href="file-complaint.php" class="btn btn-primary">File a Complaint</a>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>
