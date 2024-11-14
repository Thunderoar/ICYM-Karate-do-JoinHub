<?php

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<ul id="main-menu">
    <?php if (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in']) { ?>
        <li id="dash"><a href="index.php"><i class="entypo-gauge"></i><span>Dashboard</span></a></li>
        <li id="regis"><a href="new_entry.php"><i class="entypo-user-add"></i><span>New Registration</span></a></li>
        <li id="paymnt"><a href="payments.php"><i class="entypo-star"></i><span>Payments</span></a></li>
        <li class="active"><a href="view_mem.php"><i class="entypo-users"></i><span>Members</span></a></li>
        <li><a href="view_plan.php"><i class="entypo-quote"></i><span>Event Planning</span></a></li>
        <li id="messageCenter"><a href="messageCenter.php"><i class="entypo-mail"></i><span>Message Center</span></a></li>
        <li id="adminprofile"><a href="more-userprofile.php"><i class="entypo-folder"></i><span>Profile</span></a></li>
        <li><a href="logout.php"><i class="entypo-logout"></i><span>Logout</span></a></li>
    <?php } elseif (isset($_SESSION['is_coach_logged_in']) && $_SESSION['is_coach_logged_in']) { ?>
        <li id="dash"><a href="index.php"><i class="entypo-gauge"></i><span>Dashboard</span></a></li>
        <li id="paymnt"><a href="payments.php"><i class="entypo-star"></i><span>Payments</span></a></li>
        <li><a href="view_plan.php"><i class="entypo-quote"></i><span>Event Planning</span></a></li>
        <li><a href="view_mem.php"><i class="entypo-users"></i><span>Your Student</span></a></li>
        <li id="adminprofile"><a href="more-userprofile.php"><i class="entypo-folder"></i><span>Profile</span></a></li>
        <li><a href="logout.php"><i class="entypo-logout"></i><span>Logout</span></a></li>
    <?php } ?>
</ul>


