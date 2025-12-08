<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$success = '';
$error = '';

// Handle delete request
if (isset($_GET['delete'])) {
    $official_id = intval($_GET['delete']);
    
    $db = new Database();
    $conn = $db->connect();
    
    $delete_sql = "DELETE FROM Officials WHERE OfficialID = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $official_id);
    
    if ($delete_stmt->execute()) {
        $success = 'Official deleted successfully!';
    } else {
        $error = 'Failed to delete official.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name']);
    $position = sanitizeInput($_POST['position']);
    $term_start = sanitizeInput($_POST['term_start']);
    $term_end = sanitizeInput($_POST['term_end']);
    $contact_number = sanitizeInput($_POST['contact_number']);
    
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "INSERT INTO Officials (FullName, Position, TermStart, TermEnd, ContactNumber) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $full_name, $position, $term_start, $term_end, $contact_number);
    
    if ($stmt->execute()) {
        $success = 'Official added successfully!';
    } else {
        $error = 'Failed to add official.';
    }
}

$officials = getOfficials();

$page_title = 'Manage Officials';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Manage Barangay Officials</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="card">
        <h2>Add New Official</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" required>
            </div>
            
            <div class="form-group">
                <label>Position:</label>
                <select name="position" required>
                    <option value="">Select Position</option>
                    <option value="Barangay Captain">Barangay Captain</option>
                    <option value="Barangay Secretary">Barangay Secretary</option>
                    <option value="Barangay Treasurer">Barangay Treasurer</option>
                    <option value="Barangay Councilor">Barangay Councilor</option>
                    <option value="SK Chairman">SK Chairman</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Term Start:</label>
                    <input type="date" name="term_start" required>
                </div>
                
                <div class="form-group">
                    <label>Term End:</label>
                    <input type="date" name="term_end" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" name="contact_number" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Official</button>
        </form>
    </div>
    
    <div class="card">
        <h2>All Officials</h2>
        <?php if ($officials->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Term</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($official = $officials->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $official['FullName']; ?></td>
                            <td><?php echo $official['Position']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($official['TermStart'])) . ' - ' . date('M d, Y', strtotime($official['TermEnd'])); ?></td>
                            <td><?php echo $official['ContactNumber']; ?></td>
                            <td>
                                <a href="officials.php?delete=<?php echo $official['OfficialID']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this official?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No officials found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>