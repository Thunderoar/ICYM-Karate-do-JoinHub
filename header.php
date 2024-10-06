<?php
require 'include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_data']) && !isset($_SESSION['logged'])) {
  // If the user is NOT logged in, you can display a message or show a login form
  //echo "<p>You are not logged in. Please log in to access this page.</p>";
  // Optionally include the login form here, or any content for non-logged-in users
} else {
  // If the user IS logged in, run page_protect to ensure the page is protected
  page_protect();    
  // Now you can show content intended for logged-in users
  //echo "<p>Welcome to the protected content area!</p>";
  // Continue with the rest of your code for logged-in users
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
    <style>
	a {
		color: #a9c9fc!important}
	a:hover {
		color: white!important;}
	p {
		text-indent: 20px;}
	p:hover {
		color: #00358a!important}


    <style>
        .site-section {
            background-color: #f8f9fa; /* Light gray background */
            padding: 40px; /* Add padding around the section */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .section-title {
            font-size: 2.5rem; /* Larger title */
            font-weight: bold; /* Bold text */
            color: #343a40; /* Dark color for the title */
            margin-bottom: 20px; /* Space below the title */
            text-align: center; /* Center the title */
        }

        /* Add hover effect to images */
        img:not(.logo) {
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transform */
            border-radius: 10px; /* Round image corners */
            width: 100%; /* Make images responsive */
            height: auto; /* Maintain aspect ratio */
        }

        img:not(.logo):hover {
            transform: scale(1.05); /* Slightly enlarge the image on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }


        .menu {
    list-style-type: none; /* Remove bullet points */
    padding: 0; /* Remove default padding */
    margin: 0; /* Remove default margin */
}

.menu li {
    display: inline-block; /* Display list items inline */
    margin-right: 20px; /* Space between menu items */
}

.menu a {
    text-decoration: none; /* Remove underline from links */
    padding: 10px 15px; /* Add padding around links */
    color: #343a40; /* Text color */
    transition: transform 0.3s ease !important; /* Smooth transition for transform */
}

/* Enlarging effect on hover */
.menu a:hover {
    transform: scale(1.1) !important; /* Slightly enlarge the item on hover */
}

/* Dropdown styles (optional) */
.dropdown {
    display: none; /* Initially hide dropdowns */
    position: absolute; /* Position dropdowns absolutely */
    background-color: #fff; /* Dropdown background color */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow for dropdown */
}

.has-children:hover .dropdown {
    display: block; /* Show dropdown on hover */
}

    </style>
	</style>
  </head>
  
  <body>
      <div class="container">

      <div style="background-color:#293a8e" class="row no-gutters site-navbar align-items-center py-3" >

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

  // Display the user info (profile picture and username)
  echo "
  <li>
      <div class='user-info'>
        <button type='button' class='btn btn-primary py-3 px-4' data-toggle='modal' data-target='#exampleModalCenter'>
            <img src='dashboard/admin/$profile_pic' alt='' height='50' width='50' style='border-radius: 50%;'/>
            <span class='username'>$username</span>
        </button>
      </div>
  </li>";
} else {
  // The user is not logged in, show the login button
  echo "
  <li>
      <button type='button' class='btn btn-primary py-3 px-4' data-toggle='modal' data-target='#exampleModalCenter'>
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


	</body>
	</html>
  
