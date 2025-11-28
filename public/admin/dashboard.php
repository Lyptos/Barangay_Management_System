<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$stats = getIncidentStats();
$recent_incidents = getIncidents();

$total_residents = getTotalResidents();
$total_officials = getTotalOfficials();

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
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $total_residents; ?></h3>
            <p>Total Residents</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total_officials; ?></h3>
            <p>Barangay Officials</p>
        </div>
    </div>
    
    <div class="card">
        <h2>Recent Complaints</h2>
        <?php if ($recent_incidents->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tracking #</th>
                        <th>Type</th>
                        <th>Reported By</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 0;
                    while ($incident = $recent_incidents->fetch_assoc()): 
                        if ($count >= 10) break;
                        $count++;
                    ?>
                        <tr>
                            <td><?php echo $incident['TrackingNumber']; ?></td>
                            <td><?php echo $incident['IncidentType']; ?></td>
                            <td><?php echo $incident['resident_name']; ?></td>
                            <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '-', $incident['Status'])); ?>"><?php echo $incident['Status']; ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($incident['DateReported'])); ?></td>
                            <td>
                                <a href="view-complaint.php?id=<?php echo $incident['IncidentID']; ?>" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="complaints.php" class="btn btn-secondary">View All Complaints</a>
        <?php else: ?>
            <p>No complaints filed yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>