<?php
require 'include/db_conn.php'; // Make sure this file correctly establishes the $con connection

// Handle the form submission for deleting a plan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePlan'])) {
    $planid = mysqli_real_escape_string($con, $_POST['planid']);
    
    $delete_query = "DELETE FROM plan WHERE planid = '$planid'";
    if (mysqli_query($con, $delete_query)) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?message=Plan Deleted Successfully');
        exit;
    } else {
        echo "Error deleting plan: " . mysqli_error($con);
    }
}

// Handle the form submission for editing a plan
if (isset($_POST['editPlan'])) {
    $planid = mysqli_real_escape_string($con, $_POST['planid']);
    $planName = mysqli_real_escape_string($con, $_POST['planName']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $validity = mysqli_real_escape_string($con, $_POST['validity']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);

    // Update query
    $sql = "UPDATE plan SET planName='$planName', description='$description', validity='$validity', amount='$amount' WHERE planid='$planid'";
    
    if (mysqli_query($con, $sql)) {
        // Redirect to the updated page or success message
        header('Location: plans.php?status=success');
        exit;
    } else {
        // Handle failure
        echo "Error: " . mysqli_error($con);
    }
}

// Fetch plan details
if (isset($_GET['planId'])) {
    $planId = mysqli_real_escape_string($con, $_GET['planId']); // Sanitize input
    $query = "SELECT * FROM plan WHERE planid = '$planId'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);

}

// Close the connection
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sports Team &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/customBanner.css?v=<?php echo time(); ?>">
	<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/homepagestyle.css">
    
  </head>
  <body>
  
    
  
  <div>


    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
	
<?php
require('header.php');
?>
    
<div class="container-fluid">
  <section class="custom-hero-section" aria-label="Gallery Hero Section">
    <div class="row">
      <div class="col-lg-12">
        <div class="custom-hero-image" role="img" aria-label="Karate background" data-stellar-background-ratio="0.5">
          <div class="custom-hero-contents text-center">
            <h2 class="custom-hero-title">Event</h2>
            <nav aria-label="breadcrumb">
              <p>
                <a href="index.php" class="custom-breadcrumb-link">Home</a>
                <span class="mx-2">/</span> 
                <strong>Event</strong>
              </p>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
require 'include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Fetch active plans from the database
$query = "SELECT * FROM plan WHERE active = 'yes'"; // Fetch only active plans
$result = mysqli_query($con, $query);

// Check if there are any plans available
if (mysqli_num_rows($result) > 0):
?>


<div class="row mb-5">
<?php
// Assuming the user's authority level is stored in session
$user_authority = $_SESSION['authority'] ?? ''; // Replace this with your actual session variable

// Loop through the plans and display them
while ($plan = mysqli_fetch_assoc($result)):
  $planid = mysqli_real_escape_string($con, $plan['planid']);
  $image_query = "SELECT image_path FROM images WHERE planid = '$planid' LIMIT 1";
  $image_result = mysqli_query($con, $image_query);
  $image_path = ($image_result && mysqli_num_rows($image_result) > 0) ? 'dashboard/admin/' . mysqli_fetch_assoc($image_result)['image_path'] : 'images/default_plan_image.jpg';
?>
  <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
    <div class="card">
      <img src="<?php echo $image_path; ?>" alt="Plan Image" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $plan['planName']; ?></h5>
        <p class="card-text"><?php echo $plan['description']; ?></p>
        <!-- <p><strong>Validity:</strong> <?php echo $plan['validity']; ?> days</p> -->
        <!-- <p><strong>Amount:</strong> $<?php echo $plan['amount']; ?></p> -->
        
        <?php if ($user_authority === 'admin'): // Change 'admin' to your actual admin role identifier ?>
          <!-- Edit button for Bootstrap 4 -->
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPlanModal" 
            data-planid="<?php echo $planid; ?>" 
            data-planname="<?php echo $plan['planName']; ?>" 
            data-description="<?php echo $plan['description']; ?>" 
            data-validity="<?php echo $plan['validity']; ?>" 
            data-amount="<?php echo $plan['amount']; ?>">
            Edit
          </button>

          <!-- Delete button -->
          <form method="POST" action="" style="display:inline;">
            <input type="hidden" name="planid" value="<?php echo $planid; ?>">
            <button type="submit" name="deletePlan" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this plan?');">
              Delete
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>


<?php else: ?>
  <p>No plans available at the moment.</p>
<?php endif; ?>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-labelledby="editPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPlanModalLabel">Edit Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="dashboard/admin/updateplan.php">
	  <input type="hidden" name="origin" value="eventpage">
        <div class="modal-body">
          <input type="hidden" name="planid" id="editPlanId">
          <div class="mb-3">
            <label for="planName" class="form-label">Plan Name</label>
            <input type="text" class="form-control" id="editPlanName" name="planname" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="editDescription" name="desc" required></textarea>
          </div>
          <div class="mb-3">
            <label for="validity" class="form-label">Validity (in days/months)</label>
            <input type="number" class="form-control" id="editValidity" name="planval" required>
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="editAmount" name="amount" required>
          </div>
        </div>
<div class="d-flex justify-content-between">
    <button type="submit" name="editPlan" class="btn btn-primary">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
      </form>
    </div>
  </div>
  </div>



<?php
require('footer.html');
?>


<!-- Bootstrap 4 JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
    
  </body>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var editPlanModal = document.getElementById('editPlanModal');

  // Use Bootstrap 4's event `show.bs.modal`
  editPlanModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    
    // Fetch the data-* attributes from the button
    var planId = button.getAttribute('data-planid');
    var planName = button.getAttribute('data-planname');
    var description = button.getAttribute('data-description');
    var validity = button.getAttribute('data-validity');
    var amount = button.getAttribute('data-amount');

    // Populate modal fields with fetched data
    document.getElementById('editPlanId').value = planId;
    document.getElementById('editPlanName').value = planName;
    document.getElementById('editDescription').value = description;
    document.getElementById('editValidity').value = validity;
    document.getElementById('editAmount').value = amount;
  });
});

// Assuming you have jQuery included in your project
$(document).ready(function() {
  $('#editPlanModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var planId = button.data('planid'); // Extract info from data-* attributes
    var modal = $(this);
    modal.find('#editPlanId').val(planId);

    // Fetch and populate the rest of the fields via AJAX if needed
    $.ajax({
      url: 'dashboard/admin/fetch_plan_details.php', // Ensure correct URL format
      method: 'GET',
      data: { planid: planId },
      success: function(response) {
        // Assuming response is a JSON object with plan details
        modal.find('#editPlanName').val(response.planname);
        modal.find('#editDescription').val(response.desc);
        modal.find('#editValidity').val(response.planval);
        modal.find('#editAmount').val(response.amount);
      },
      error: function(xhr, status, error) {
        console.error('Error fetching plan details:', error);
      }
    });
  });
});
</script>

</html>
<?php
require 'important_include.php';
?>   
<?php
// Close the database connection
mysqli_close($con);
?>