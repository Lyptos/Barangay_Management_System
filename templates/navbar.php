<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <a href="<?php echo SITE_URL; ?>/public/index.php"><?php echo SITE_NAME; ?></a>
        </div>
        <ul class="nav-menu">
            <?php 
            // Get current page filename
            $current_page = basename($_SERVER['PHP_SELF']);
            ?>
            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/complaints.php" class="<?php echo ($current_page == 'complaints.php' || $current_page == 'view-complaint.php') ? 'active' : ''; ?>">Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/residents.php" class="<?php echo ($current_page == 'residents.php') ? 'active' : ''; ?>">Residents</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/admin/officials.php" class="<?php echo ($current_page == 'officials.php') ? 'active' : ''; ?>">Officials</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/includes/auth.php?logout=1">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/file-complaint.php" class="<?php echo ($current_page == 'file-complaint.php') ? 'active' : ''; ?>">File Complaint</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/my-complaints.php" class="<?php echo ($current_page == 'my-complaints.php') ? 'active' : ''; ?>">My Complaints</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/public/resident/profile.php" class="<?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">Profile</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/includes/auth.php?logout=1">Logout</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?php echo SITE_URL; ?>/public/index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>/public/login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>