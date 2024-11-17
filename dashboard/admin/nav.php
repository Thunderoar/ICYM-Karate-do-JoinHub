<?php

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<ul id="main-menu">
    <?php if (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in']) { ?>
        <li id="dash"><a href="index.php" onclick="checkForChangesAndNavigate(event, 'index.php')"><i class="entypo-gauge"></i><span>Dashboard</span></a></li>
        <li id="regis"><a href="new_entry.php" onclick="checkForChangesAndNavigate(event, 'new_entry.php')"><i class="entypo-user-add"></i><span>New Registration</span></a></li>
        <li id="paymnt"><a href="payments.php" onclick="checkForChangesAndNavigate(event, 'payments.php')"><i class="entypo-star"></i><span>Payments</span></a></li>
        <li class="active"><a href="view_mem.php" onclick="checkForChangesAndNavigate(event, 'view_mem.php')"><i class="entypo-users"></i><span>Members</span></a></li>
        <li><a href="view_plan.php" onclick="checkForChangesAndNavigate(event, 'view_plan.php')"><i class="entypo-quote"></i><span>Event Planning</span></a></li>
        <li id="messageCenter"><a href="messageCenter.php" onclick="checkForChangesAndNavigate(event, 'messageCenter.php')"><i class="entypo-mail"></i><span>Message Center</span></a></li>
        <li id="adminprofile"><a href="more-userprofile.php" onclick="checkForChangesAndNavigate(event, 'more-userprofile.php')"><i class="entypo-folder"></i><span>Profile</span></a></li>
        <li><a href="logout.php"><i class="entypo-logout"></i><span>Logout</span></a></li>
    <?php } elseif (isset($_SESSION['is_coach_logged_in']) && $_SESSION['is_coach_logged_in']) { ?>
        <li id="dash"><a href="index.php" onclick="checkForChangesAndNavigate(event, 'index.php')"><i class="entypo-gauge"></i><span>Dashboard</span></a></li>
        <li id="paymnt"><a href="payments.php" onclick="checkForChangesAndNavigate(event, 'payments.php')"><i class="entypo-star"></i><span>Payments</span></a></li>
        <li><a href="view_plan.php" onclick="checkForChangesAndNavigate(event, 'view_plan.php')"><i class="entypo-quote"></i><span>Event Planning</span></a></li>
        <li><a href="view_mem.php" onclick="checkForChangesAndNavigate(event, 'view_mem.php')"><i class="entypo-users"></i><span>Your Student</span></a></li>
        <li id="adminprofile"><a href="more-userprofile.php" onclick="checkForChangesAndNavigate(event, 'more-userprofile.php')"><i class="entypo-folder"></i><span>Profile</span></a></li>
        <li><a href="logout.php"><i class="entypo-logout"></i><span>Logout</span></a></li>
    <?php } ?>
</ul>


<!-- JavaScript to check for changes before navigating -->
<script>
let originalData = {};

document.addEventListener("DOMContentLoaded", function() {
    const formElements = document.querySelectorAll("#form1 input, #form1 textarea, #form1 select");
    formElements.forEach(element => {
        if (element.type !== "hidden") {
            originalData[element.name] = element.value;
        }
    });
    
    // Add event listener to warn before reloading the page
    window.addEventListener("beforeunload", function(event) {
        if (isFormChanged()) {
            event.preventDefault();
            event.returnValue = '';
        }
    });
});

function isFormChanged() {
    const formElements = document.querySelectorAll("#form1 input, #form1 textarea, #form1 select");
    return [...formElements].some(element => element.type !== "hidden" && originalData[element.name] !== element.value);
}

function handleFormChanges(event, message, callback) {
    if (isFormChanged()) {
        const confirmAction = confirm(message);
        if (!confirmAction) {
            event.preventDefault();
            return;
        }
    }
    if (callback) callback();
}

function checkForChanges(event) {
    handleFormChanges(event, "There are unsaved changes. Are you sure you want to reset?");
}

function checkForChangesAndRedirect(event, url) {
    handleFormChanges(event, "There are unsaved changes. Are you sure you want to leave?", () => {
        window.location.href = url;
    });
}

function checkForChangesAndNavigate(event, url) {
    checkForChangesAndRedirect(event, url);
}

</script>