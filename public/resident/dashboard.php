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

// Get user's complaints
$sql = "SELECT * FROM Incidents WHERE ReportedBy = ? ORDER BY DateReported DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recent_complaints = $stmt->get_result();

// Get complaint stats
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN Status = 'Pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN Status = 'In Progress' THEN 1 ELSE 0 END) as in_progress,
    SUM(CASE WHEN Status = 'Resolved' THEN 1 ELSE 0 END) as resolved
    FROM Incidents WHERE ReportedBy = ?";
$stats_stmt = $conn->prepare($stats_sql);
$stats_stmt->bind_param("i", $user_id);
$stats_stmt->execute();
$stats = $stats_stmt->get_result()->fetch_assoc();

$page_title = 'Resident Dashboard';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $stats['total']; ?></h3>
            <p>Total Complaints</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['pending']; ?></h3>
            <p>Pending</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['in_progress']; ?></h3>
            <p>In Progress</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['resolved']; ?></h3>
            <p>Resolved</p>
        </div>
    </div>
    
    <div class="card">
        <h2>Recent Complaints</h2>
        <?php if ($recent_complaints->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tracking Number</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date Filed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($complaint = $recent_complaints->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $complaint['TrackingNumber']; ?></td>
                            <td><?php echo $complaint['IncidentType']; ?></td>
                            <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($complaint['DateReported'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="my-complaints.php" class="btn btn-secondary">View All Complaints</a>
        <?php else: ?>
            <p>You haven't filed any complaints yet.</p>
            <a href="file-complaint.php" class="btn btn-primary">File Your First Complaint</a>
        <?php endif; ?>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>