<?php
require '../../include/db_conn.php';
page_protect();

$msgid = $_POST['name'];

if ($msgid === 'MRBDPX') {
    echo "<html><head><script>alert('You cannot delete a core plan');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
} elseif (strlen($msgid) > 0) {
    mysqli_query($con, "update plan set active ='no' WHERE pid='$msgid'");
    echo "<html><head><script>alert('Plan Deleted');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
} else {
    echo "<html><head><script>alert('ERROR! Delete Opertaion Unsucessfull');</script></head></html>";
   echo "error".mysqli_error($con);
}

?>
