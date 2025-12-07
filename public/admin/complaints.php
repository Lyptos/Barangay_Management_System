<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$filter_status = isset($_GET['status']) ? $_GET['status'] : null;
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';

// Get incidents with search filter
if ($search) {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "SELECT i.*, CONCAT(u.FirstName, ' ', u.LastName) as resident_name, u.ContactNumber, u.Address 
            FROM Incidents i 
            LEFT JOIN Users u ON i.ReportedBy = u.ResidentID 
            WHERE (i.TrackingNumber LIKE ? OR i.IncidentType LIKE ? OR CONCAT(u.FirstName, ' ', u.LastName) LIKE ?)";
    
    if ($filter_status) {
        $sql .= " AND i.Status = ?";
    }
    
    $sql .= " ORDER BY i.DateReported DESC";
    
    $stmt = $conn->prepare($sql);
    $searchParam = "%{$search}%";
    
    if ($filter_status) {
        $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $filter_status);
    } else {
        $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
    }
    
    $stmt->execute();
    $incidents = $stmt->get_result();
} else {
    $incidents = getIncidents($filter_status);
}

$page_title = 'Manage Complaints';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Manage Complaints/Incidents</h1>
    
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by tracking number, type, or resident name..." value="<?php echo htmlspecialchars($search); ?>">
            <?php if ($filter_status): ?>
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($filter_status); ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Search</button>
            <?php if ($search): ?>
                <a href="complaints.php<?php echo $filter_status ? '?status=' . urlencode($filter_status) : ''; ?>" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <div class="filter-bar">
        <a href="complaints.php<?php echo $search ? '?search=' . urlencode($search) : ''; ?>" class="btn btn-secondary <?php echo !$filter_status ? 'active' : ''; ?>">All</a>
        <a href="?status=Pending<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-secondary <?php echo $filter_status === 'Pending' ? 'active' : ''; ?>">Pending</a>
        <a href="?status=In Progress<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-secondary <?php echo $filter_status === 'In Progress' ? 'active' : ''; ?>">In Progress</a>
        <a href="?status=Resolved<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-secondary <?php echo $filter_status === 'Resolved' ? 'active' : ''; ?>">Resolved</a>
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