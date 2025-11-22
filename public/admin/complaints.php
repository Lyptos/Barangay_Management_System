<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$complaints = getComplaints($filter_status ? $filter_status : null);

$page_title = 'All Complaints';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>All Complaints</h1>
    
    <div class="filter-bar">
        <a href="complaints.php" class="btn btn-secondary <?php echo !$filter_status ? 'active' : ''; ?>">All</a>
        <a href="?status=pending" class="btn btn-secondary <?php echo $filter_status === 'pending' ? 'active' : ''; ?>">Pending</a>
        <a href="?status=in_progress" class="btn btn-secondary <?php echo $filter_status === 'in_progress' ? 'active' : ''; ?>">In Progress</a>
        <a href="?status=resolved" class="btn btn-secondary <?php echo $filter_status === 'resolved' ? 'active' : ''; ?>">Resolved</a>
    </div>
    
    <?php if ($complaints->num_rows > 0): ?>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Tracking #</th>
                        <th>Resident</th>
                        <th>Contact</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date Filed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($complaint = $complaints->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $complaint['TrackingNumber']; ?></td>
                            <td><?php echo $complaint['full_name']; ?></td>
                            <td><?php echo $complaint['contact_number'] ?: 'N/A'; ?></td>
                            <td><?php echo $complaint['IncidentType']; ?></td>
                            <td><?php echo $complaint['IncidentType']; ?></td>
                            <td><span class="badge badge-<?php echo strtolower(str_replace(' ', '', $complaint['Status'])); ?>"><?php echo $complaint['Status']; ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($complaint['DateReported'])); ?></td>
                            <td>
                                <a href="view-complaint.php?id=<?php echo $complaint['IncidentID']; ?>" class="btn btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No complaints found.</p>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>
