<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
requireAdmin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $contact_number = sanitizeInput($_POST['contact_number']);
    $address = sanitizeInput($_POST['address']);
    $birth_date = sanitizeInput($_POST['birth_date']);
    $gender = sanitizeInput($_POST['gender']);
    $password = 'password123'; // Default password
    
    if (register($first_name, $last_name, $email, $password, $contact_number, $address, $birth_date, $gender)) {
        $success = 'Resident added successfully! Default password: password123';
    } else {
        $error = 'Failed to add resident. Email may already exist.';
    }
}

$residents = getResidents();

$page_title = 'Manage Residents';
include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">
    <h1>Manage Residents</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="card">
        <h2>Add New Resident</h2>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Birth Date:</label>
                    <input type="date" name="birth_date" required>
                </div>
                
                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" rows="2" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Resident</button>
        </form>
    </div>
    
    <div class="card">
        <h2>All Residents</h2>
        <?php if ($residents->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($resident = $residents->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $resident['FirstName'] . ' ' . $resident['LastName']; ?></td>
                            <td><?php echo $resident['Email']; ?></td>
                            <td><?php echo $resident['ContactNumber']; ?></td>
                            <td><?php echo $resident['Address']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($resident['BirthDate'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No residents found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>