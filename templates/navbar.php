<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <a href="<?php echo SITE_URL; ?>/index.php"><?php echo SITE_NAME; ?></a>
        </div>
        <ul class="nav-menu">
            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/complaints.php">Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/residents.php">Residents</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/includes/auth.php?logout=1">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/file-complaint.php">File Complaint</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/my-complaints.php">My Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/includes/auth.php?logout=1">Logout</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?php echo SITE_URL; ?>/public/index.php">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/login.php">Login</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>