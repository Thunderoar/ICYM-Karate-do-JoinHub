<?php
require '../../include/db_conn.php';
page_protect();

// Fetch messages from database
$sql = "SELECT message_id, fullname, email, subject, message, created_at FROM contact_messages";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do  | Message Center</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/insidedashboard.css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
    	.page-container .sidebar-menu #main-menu li#messageCenter > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
    </style>

</head>
      <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
			<!-- logo -->
			<?php
			 require('../../element/loggedin-logo.html');
			?>
			
					<!-- logo collapse icon -->
					<!--<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition 
					<i class="entypo-menu"></i>
				</a>
			</div>-->
							
			
		
			</header>
    		<?php include('nav.php'); ?>
    	</div>

    		<div class="main-content">
		
				<div class="row">
					
					<!-- Profile Info and Notifications -->
					<div class="col-md-6 col-sm-8 clearfix">	
							
					</div>
					
					
					<!-- Raw Links -->
					<div class="col-md-6 col-sm-4 clearfix hidden-xs">
						
						<ul class="list-inline links-list pull-right">

                        <?php
						require('../../element/loggedin-welcome.html');
					?>
							</li>								
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
						
					</div>
					
				</div>

				<h2>Message Center</h2>
<hr />
<div class="">
    <h2>Messages</h2>
    <div class="tab-buttons"  style="margin-bottom:50px;">
        <button onclick="showTab('unread')">Unread Messages (<span id="unread-count"></span>)</button>
        <button onclick="showTab('read')">Read Messages (<span id="read-count"></span>)</button>
        <button onclick="showTab('archived')">Archived Messages (<span id="archived-count"></span>)</button> <!-- New tab button -->
    </div>
    
    <!-- Unread Messages Tab -->
    <div id="unread" class="tab-content">
        <h3>Unread Messages</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Fetch distinct unread messages by content and count
            $unreadQuery = "
                SELECT COUNT(*) AS count, message_id, fullname, email, subject, message, created_at
                FROM contact_messages
                WHERE (read_status IS NULL OR read_status = 0) AND archive_status = 0
                GROUP BY message, fullname, email, subject, created_at
                ORDER BY created_at DESC
            ";
            $unreadResult = $con->query($unreadQuery);
            $unreadCount = 0;

            if ($unreadResult->num_rows > 0) {
                while ($row = $unreadResult->fetch_assoc()) {
                    $unreadCount++;
                    echo "<tr>";
                    echo "<td>" . $row["message_id"] . "</td>";
                    echo "<td>" . $row["fullname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td><a href='?mark_as_read=" . $row["message_id"] . "&tab=unread'>Mark as Read</a> | <a href='?archive=" . $row["message_id"] . "&tab=unread'>Archive</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No unread messages found</td></tr>";
            }

            // Handle marking as read
            if (isset($_GET['mark_as_read'])) {
                $message_id = $_GET['mark_as_read'];

                // Update the read_status to 1 (read)
                $query = "UPDATE contact_messages SET read_status = 1 WHERE message_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $message_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Message marked as read'); window.location.href='?tab=" . $_GET['tab'] . "';</script>";
                } else {
                    echo "Failed to update message status";
                }

                $stmt->close();
            }

            // Handle archiving
            if (isset($_GET['archive'])) {
                $message_id = $_GET['archive'];

                // Update the archive_status to 1 (archived)
                $query = "UPDATE contact_messages SET archive_status = 1 WHERE message_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $message_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Message archived'); window.location.href='?tab=" . $_GET['tab'] . "';</script>";
                } else {
                    echo "Failed to archive message";
                }

                $stmt->close();
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Read Messages Tab -->
    <div id="read" class="tab-content" style="display: none;">
        <h3>Read Messages</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th> <!-- Added Action Column -->
            </tr>
            </thead>
            <tbody>
            <?php
            // Fetch distinct read messages by content and count
            $readQuery = "
                SELECT COUNT(*) AS count, message_id, fullname, email, subject, message, created_at
                FROM contact_messages
                WHERE read_status = 1 AND archive_status = 0
                GROUP BY message, fullname, email, subject, created_at
                ORDER BY created_at DESC
            ";
            $readResult = $con->query($readQuery);
            $readCount = 0;

            if ($readResult->num_rows > 0) {
                while ($row = $readResult->fetch_assoc()) {
                    $readCount++;
                    echo "<tr>";
                    echo "<td>" . $row["message_id"] . "</td>";
                    echo "<td>" . $row["fullname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td><a href='?mark_as_unread=" . $row["message_id"] . "&tab=read'>Mark as Unread</a> | <a href='?archive=" . $row["message_id"] . "&tab=read'>Archive</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No read messages found</td></tr>"; // Updated colspan for the new column
            }

            // Handle marking as unread
            if (isset($_GET['mark_as_unread'])) {
                $message_id = $_GET['mark_as_unread'];

                // Update the read_status to 0 (unread)
                $query = "UPDATE contact_messages SET read_status = 0 WHERE message_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $message_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Message marked as unread'); window.location.href='?tab=" . $_GET['tab'] . "';</script>";
                } else {
                    echo "Failed to update message status";
                }

                $stmt->close();
            }

            // Handle archiving
            if (isset($_GET['archive'])) {
                $message_id = $_GET['archive'];

                // Update the archive_status to 1 (archived)
                $query = "UPDATE contact_messages SET archive_status = 1 WHERE message_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $message_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Message archived'); window.location.href='?tab=" . $_GET['tab'] . "';</script>";
                } else {
                    echo "Failed to archive message";
                }

                $stmt->close();
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Archived Messages Tab -->
    <div id="archived" class="tab-content" style="display: none;">
        <h3>Archived Messages</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Fetch distinct archived messages by content and count
            $archivedQuery = "
                SELECT COUNT(*) AS count, message_id, fullname, email, subject, message, created_at
                FROM contact_messages
                WHERE archive_status = 1
                GROUP BY message, fullname, email, subject, created_at
                ORDER BY created_at DESC
            ";
            $archivedResult = $con->query($archivedQuery);
            $archivedCount = 0;

            if ($archivedResult->num_rows > 0) {
                while ($row = $archivedResult->fetch_assoc()) {
                    $archivedCount++;
                    echo "<tr>";
                    echo "<td>" . $row["message_id"] . "</td>";
                    echo "<td>" . $row["fullname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No archived messages found</td></tr>"; // Updated colspan for this table
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showTab(tabId) {
    // Hide all tabs
    var tabs = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }
    // Show the selected tab
    document.getElementById(tabId).style.display = 'block';
    // Store the current tab in local storage
    localStorage.setItem('activeTab', tabId);
}

// Function to show the tab from local storage
function showTabFromLocalStorage() {
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        showTab(activeTab);
    } else {
        showTab('unread'); // Default tab
    }
}

// Function to update the message counts
function updateCounts() {
    document.getElementById('unread-count').innerText = <?= $unreadCount ?>;
    document.getElementById('read-count').innerText = <?= $readCount ?>;
    document.getElementById('archived-count').innerText = <?= $archivedCount ?>;
}

// Initialize the tab state and counts on page load
document.addEventListener('DOMContentLoaded', function() {
    showTabFromLocalStorage();
    updateCounts();
});
</script>

</body>
</html>

<?php
$con->close();
?>
