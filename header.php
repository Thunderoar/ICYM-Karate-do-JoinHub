<?php
require 'include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_data']) || !isset($_SESSION['logged'])) {
} else {
    // If the user IS logged in, ensure the page is protected
    page_protect(); // Ensure this function exists
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/homepagestyle.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        a:not(.not) {
            color: #a9c9fc!important;
        }
        a:not(.not):hover {
            color: white!important;
        }
        p {
            text-indent: 20px;
        }
        p:hover {
            color: #00358a!important;
        }
        .site-section {
            background-color: #f8f9fa; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        }
        .section-title {
            font-size: 2.5rem; 
            font-weight: bold; 
            color: #343a40; 
            margin-bottom: 20px; 
            text-align: center; 
        }
        img:not(.logo) {
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
            border-radius: 10px; 
            width: 100%; 
            height: auto; 
        }
        img:not(.logo):hover {
            transform: scale(1.05); 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); 
        }
        .menu {
            list-style-type: none; 
            padding: 0; 
            margin: 0; 
        }
        .menu li {
            display: inline-block; 
            margin-right: 20px; 
        }
        .menu a {
            text-decoration: none; 
            padding: 10px 15px; 
            color: #343a40; 
            transition: transform 0.3s ease !important; 
        }
        .menu a:hover {
            transform: scale(1.1) !important; 
        }
        .dropdown {
            position: relative; 
            width: 230px; 
            filter: url(#goo);
        }
        .dropdown__face,
        .dropdown__items {
            background-color: #fff; 
            padding: 20px; 
            border-radius: 25px; 
        }
        .dropdown__face {
            display: block; 
            position: relative; 
            cursor: pointer; 
        }
        .dropdown__items {
    margin: 0;
    position: absolute;
    right: 0;
    top: 100%; /* Ensure the dropdown is below the button */
    list-style: none;
    display: flex;
    flex-direction: column; /* Stack items vertically */
    visibility: hidden;
    z-index: -1;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.93, 0.88, 0.1, 0.8);
    background-color: #fff; /* Set background color */
    border-radius: 5px; /* Optional: round the corners */
}

.dropdown__items.visible {
    visibility: visible;
    opacity: 1;
    z-index: 1;
}

/* Dropdown item styles */
.dropdown__items li {
    padding: 10px 15px; /* Add some padding around items */
    white-space: nowrap; /* Prevent text wrapping */
}

.dropdown__items li:hover {
    background-color: #f0f0f0; /* Optional: highlight on hover */
}

        .dropdown__arrow {
            border-bottom: 2px solid #000; 
            border-right: 2px solid #000; 
            position: absolute; 
            top: 50%; 
            right: 30px; 
            width: 10px; 
            height: 10px; 
            transform: rotate(45deg) translateY(-50%); 
            transform-origin: right; 
        }
        body {
            background-image: linear-gradient(140deg, #e2e2e2, #cdcdcd); 
            display: grid; 
            place-items: center; 
            font-family: "Lato", Arial, sans-serif; 
            height: 100vh; 
            margin: 0; 
        }
        * {
            box-sizing: border-box; 
        }
        svg {
            display: none; 
        }
    </style>
</head>

<body>
    <div>
        <div style="background-color:#00003c" class="row no-gutters site-navbar align-items-center py-3">
            <div class="col-6 col-lg-2 site-logo">
                <img src="images/logok.png" alt="" height="50" class="logo" />
                <a style="font-size:15px; color: #a9c9fc!important;" href="index.php">ICYM Karate-Do</a>
            </div>
            <div class="col-6 col-lg-10 text-right menu">
                <nav class="site-navigation text-right text-md-right">
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li class="has-children">
                            <a href="players.php">Coach</a>
                            <ul class="dropdown arrow-top">
                                <li><p>Jakub Bates</p></li>
                                <li><p>Russell Vance</p></li>
                                <li><p>Carson Hodgson</p></li>
                                <li class="has-children">
                                    <p href="#">Sub Menu  ></p>
                                    <ul class="dropdown">
                                        <li><p>Joshua Fugueroa</p></li>
                                        <li><p>Jakub Bates</p></li>
                                        <li><p>Russell Vance</p></li>
                                        <li><p>Carson Hodgson</p></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="events.php">Events</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>

                        <?php
// Check if the user is logged in and session data is set
if (isset($_SESSION['user_data']) && isset($_SESSION['logged'])) {
  // Get profile picture and username from session
  $profile_pic = $_SESSION['profile_pic']; // Path or URL to profile picture
  $username = $_SESSION['username']; // Username from the session

  // Determine whether the user is an admin or member based on their role
  $dashboard_link = '';
  $logout_link = '';

  if ($_SESSION['authority'] == 'admin') {
      // If the user is an admin, use the admin dashboard and logout links
      $dashboard_link = 'dashboard/admin/';
      $logout_link = 'dashboard/admin/logout.php';
  } elseif ($_SESSION['authority'] == 'member') {
      // If the user is a member, use the member dashboard and logout links
      $dashboard_link = 'dashboard/member/';
      $logout_link = 'dashboard/member/logout.php';
  }

  // Display the user info (profile picture, username, and appropriate links)
  echo "
  <li class='nav-item'>
      <div class='user-info d-flex align-items-center'>
          <button class='btn btn-primary btn-sm px-2 py-1 d-flex align-items-center' id='dropdownButton'>
              <img src='$dashboard_link$profile_pic' alt='' class='img-fluid' style='height: 40px; width: 40px; border-radius: 50%; object-fit: cover;'/>
              <span class='username ml-2'>$username</span>
          </button>

          <!-- Custom Dropdown -->
          <ul class='dropdown__items' id='dropdownItems'>
              <li><a class='not' href='$dashboard_link'>Dashboard</a></li> <!-- Dynamic Dashboard Link -->

              <li><a class='not' href='$logout_link'>Log Out</a></li> <!-- Dynamic Logout Link -->
          </ul>
      </div>
  </li>
  <svg>
      <filter id='goo'>
          <feGaussianBlur in='SourceGraphic' stdDeviation='10' result='blur'/>
          <feColorMatrix in='blur' type='matrix' values='1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7' result='goo'/>
          <feBlend in='SourceGraphic' in2='goo'/>
      </filter>
  </svg>";
} else {
  // The user is not logged in, show the login button
  echo "
  <li class='nav-item'>
      <button type='button' class='btn btn-primary btn-sm px-4 py-3' data-toggle='modal' data-target='#exampleModalCenter'>
          Login
      </button>
  </li>";
}
?>
                    </ul>

                    <a href="#" class="site-menu-toggle js-menu-toggle text-black d-inline-block d-lg-none"><span class="icon-menu h3"></span></a>
                </nav>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // JavaScript to toggle the dropdown visibility
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownItems = document.getElementById('dropdownItems');

        dropdownButton.addEventListener('click', function() {
            dropdownItems.classList.toggle('visible');
        });
    });
</script>
</body>
</html>
