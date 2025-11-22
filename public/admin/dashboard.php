<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$stats = getComplaintStats();

$db = new Database();
$conn = $db->connect();

// Get recent complaints
$recent_complaints = $conn->query("SELECT i.*, CONCAT(r.FirstName, ' ', r.LastName) as full_name FROM Incidents i 
                                   LEFT JOIN Residents r ON i.ReportedBy = r.ResidentID 
                                   ORDER BY i.DateReported DESC LIMIT 10");

$page_title = 'Admin Dashboard';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Admin Dashboard</h1>
    
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
                        <th>Tracking #</th>
                        <th>Resident</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($complaint = $recent_complaints->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $complaint['TrackingNumber']; ?></td>
                            <td><?php echo $complaint['full_name']; ?></td>
                            <td><?php echo $complaint['IncidentType']; ?></td>
                            <td><?php echo ucfirst($complaint['IncidentType']); ?></td>
                            <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($complaint['DateReported'])); ?></td>
                            <td>
                                <a href="view-complaint.php?id=<?php echo $complaint['IncidentID']; ?>" class="btn btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No complaints yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>
