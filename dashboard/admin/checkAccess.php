<?php

function check_access($role, $page) {
    if ($role == 'admin' && !isset($_SESSION['is_admin_logged_in'])) {
        redirect_user($page, 'coach');
    } elseif ($role == 'coach' && !isset($_SESSION['is_coach_logged_in'])) {
        redirect_user($page, 'admin');
    }
}

function redirect_user($page, $role) {
    $redirect_pages = [
        'index.php' => '../../dashboard/coach/index.php',
        'new_entry.php' => '../../dashboard/coach/index.php',
        'payments.php' => '../../dashboard/coach/payments.php',
        'view_mem.php' => '../../dashboard/coach/view_mem.php',
        'view_plan.php' => '../../dashboard/coach/view_plan.php',
        'messageCenter.php' => '../../dashboard/coach/index.php',
        'more-userprofile.php' => '../../dashboard/coach/more-userprofile.php',
        'logout.php' => 'logout.php'
    ];
    if (isset($redirect_pages[$page])) {
        header('Location: '.$redirect_pages[$page]);
        exit;
    } else {
        header('Location: '.$role.'_dashboard.php'); // Default fallback
        exit;
    }
}
?>
