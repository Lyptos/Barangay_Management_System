<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$filter_status = isset($_GET['status']) ? $_GET['status'] : null;
$incidents = getIncidents($filter_status);

$page_title = 'Manage Complaints';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Manage Complaints/Incidents</h1>
    
    <div class="filter-bar">
        <a href="complaints.php" class="btn btn-secondary <?php echo !$filter_status ? 'active' : ''; ?>">All</a>
        <a href="?status=Pending" class="btn btn-secondary <?php echo $filter_status === 'Pending' ? 'active' : ''; ?>">Pending</a>
        <a href="?status=In Progress" class="btn btn-secondary <?php echo $filter_status === 'In Progress' ? 'active' : ''; ?>">In Progress</a>
        <a href="?status=Resolved" class="btn btn-secondary <?php echo $filter_status === 'Resolved' ? 'active' : ''; ?>">Resolved</a>
    </div>
    
    <?php if ($incidents->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Tracking #</th>
                    <th>Type</th>
                    <th>Reported By</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($incident = $incidents->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $incident['TrackingNumber']; ?></td>
                        <td><?php echo $incident['IncidentType']; ?></td>
                        <td><?php echo $incident['resident_name']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($incident['DateReported'])); ?></td>
                        <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '-', $incident['Status'])); ?>"><?php echo $incident['Status']; ?></span></td>
                        <td>
                            <a href="view-complaint.php?id=<?php echo $incident['IncidentID']; ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No complaints found.</p>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>