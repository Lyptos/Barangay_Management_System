<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$db = new Database();
$conn = $db->connect();

$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';

$sql = "SELECT * FROM Residents";
if ($search) {
    $sql .= " WHERE CONCAT(FirstName, ' ', LastName) LIKE ? OR Email LIKE ? OR ContactNumber LIKE ?";
}
$sql .= " ORDER BY LastName, FirstName ASC";

$stmt = $conn->prepare($sql);
if ($search) {
    $search_param = "%$search%";
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}
$stmt->execute();
$residents = $stmt->get_result();

$page_title = 'Residents';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Registered Residents</h1>
    
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search residents..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <?php if ($search): ?>
                <a href="residents.php" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <?php if ($residents->num_rows > 0): ?>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($resident = $residents->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $resident['ResidentID']; ?></td>
                            <td><?php echo $resident['FirstName'] . ' ' . $resident['LastName']; ?></td>
                            <td><?php echo $resident['Email'] ?: 'N/A'; ?></td>
                            <td><?php echo $resident['ContactNumber'] ?: 'N/A'; ?></td>
                            <td><?php echo $resident['Address'] ?: 'N/A'; ?></td>
                            <td><?php echo $resident['CreatedAt'] ? date('M d, Y', strtotime($resident['CreatedAt'])) : 'N/A'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No residents found.</p>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>
