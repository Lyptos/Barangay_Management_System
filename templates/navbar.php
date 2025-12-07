
<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <a href="<?php echo SITE_URL; ?>/public/index.php"><?php echo SITE_NAME; ?></a>
        </div>
        <ul class="nav-menu">
            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
<<<<<<< HEAD
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/dashboard.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/complaints.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'complaints.php') ? 'active' : ''; ?>">Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/residents.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'residents.php') ? 'active' : ''; ?>">Residents</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/officials.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'officials.php') ? 'active' : ''; ?>">Officials</a></li>
                    <li><a href="http://localhost/Barangay_Management_System-main/includes/auth.php?logout=1">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/dashboard.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/file-complaint.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'file-complaint.php') ? 'active' : ''; ?>">File Complaint</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/my-complaints.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'my-complaints.php') ? 'active' : ''; ?>">My Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/profile.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'profile.php') ? 'active' : ''; ?>">Profile</a></li>
                    <li><a href="http://localhost/Barangay_Management_System-main/includes/auth.php?logout=1">Logout</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?php echo SITE_URL; ?>/public/index.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/login.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'login.php') ? 'active' : ''; ?>">Login</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/register.php" class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'register.php') ? 'active' : ''; ?>">Register</a></li>
=======
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/complaints.php">Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/residents.php">Residents</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/officials.php">Officials</a></li>
                    <li><a href="http://localhost/MyWebApp/includes/auth.php?logout=1">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/file-complaint.php">File Complaint</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/my-complaints.php">My Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/profile.php">Profile</a></li>
                    <li><a href="http://localhost/MyWebApp/includes/auth.php?logout=1">Logout</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?php echo SITE_URL; ?>/public/index.php">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/login.php">Login</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/register.php">Register</a></li>
>>>>>>> af441e77e32f0536ccfd26b6f3eb2c7525158e2e
            <?php endif; ?>
        </ul>
    </div>
</nav>