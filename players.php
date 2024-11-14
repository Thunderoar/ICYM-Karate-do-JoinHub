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

// Get filter parameters
$position = isset($_GET['position']) ? $_GET['position'] : '';

// Fetch featured players for carousel (e.g., top performers or team captains)
$featured_query = "SELECT member_id, full_name, position, image_path, display_order 
                  FROM team_members 
                  WHERE active = 1 
                  AND featured = 1 
                  ORDER BY display_order ASC 
                  LIMIT 8";

$featured_result = $con->query($featured_query);
$featured_players = [];
while($row = $featured_result->fetch_assoc()) {
    $featured_players[] = $row;
}

// Fetch all positions for filter
$positions_query = "SELECT DISTINCT position FROM team_members WHERE active = 1";
$positions_result = $con->query($positions_query);
$positions = [];
while($row = $positions_result->fetch_assoc()) {
    $positions[] = $row['position'];
}

// Fetch remaining players for grid
$grid_query = "SELECT tm.member_id, tm.full_name, tm.position, tm.image_path 
               FROM team_members tm 
               WHERE tm.active = 1 
               AND tm.featured = 0";

if ($position) {
    $grid_query .= " AND tm.position = '" . $con->real_escape_string($position) . "'";
}

$grid_query .= " ORDER BY tm.display_order ASC";

$grid_result = $con->query($grid_query);
$grid_players = [];
while($row = $grid_result->fetch_assoc()) {
    $grid_players[] = $row;
}

$con->close();
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
	<link rel="stylesheet" href="css/customBanner.css?v=<?php echo time(); ?>">
    
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/homepagestyle.css">
    
    <style>
        /* Common styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .site-section {
            padding: 4rem 0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Carousel styles */
        .carousel-container {
            position: relative;
            overflow: hidden;
            margin-bottom: 4rem;
        }

        .carousel-wrapper {
            display: flex;
            transition: transform 0.3s ease-in-out;
        }

        .carousel-card {
            flex: 0 0 calc(25% - 20px);
            margin: 0 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            z-index: 2;
        }

        .prev-button { left: -20px; }
        .next-button { right: -20px; }

        /* Grid styles */
        .filter-controls {
            margin-bottom: 2rem;
        }

        .filter-button {
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-button.active {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .players-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .player-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .player-card:hover {
            transform: translateY(-5px);
        }

        .player-image {
            position: relative;
            padding-top: 100%;
        }

        .player-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .player-info {
            padding: 1rem;
            text-align: center;
        }

        .player-info h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .player-info p {
            margin: 0.5rem 0 0;
            color: #666;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            max-width: 600px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive styles */
        @media (max-width: 1024px) {
            .carousel-card { flex: 0 0 calc(33.333% - 20px); }
            .players-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 768px) {
            .carousel-card { flex: 0 0 calc(50% - 20px); }
            .players-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .carousel-card { flex: 0 0 calc(100% - 20px); }
            .players-grid { grid-template-columns: 1fr; }
        }
		/* Add this CSS */
.editable-content {
    display: none;
}

.edit-mode-button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 10px;
}

.edit-mode-button:hover {
    background-color: #0056b3;
}

.carousel-card.editing {
    pointer-events: none;
}
    </style>
	
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
            <h2 class="custom-hero-title">Members</h2>
            <nav aria-label="breadcrumb">
              <p>
                <a href="index.php" class="custom-breadcrumb-link">Home</a>
                <span class="mx-2">/</span> 
                <strong>Members</strong>
              </p>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="site-section">
    <div class="section-header">
        <h2 class="section-title">Our Prominent Member</h2>
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'start' && $_SESSION['authority'] == 'admin'): ?>
            <button id="editModeButton" class="edit-mode-button" onclick="toggleEditMode()">Enter Edit Mode</button>
        <?php endif; ?>
    </div>
    <div class="carousel-container">
        <button class="carousel-button prev-button" onclick="moveCarousel(-1)">←</button>
        <!-- Global Form Wrapper -->
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'start' && $_SESSION['authority'] == 'admin'): ?>
            <form action="dashboard/admin/edit_memberfront.php" method="POST" enctype="multipart/form-data">
        <?php endif; ?>
        <div class="carousel-wrapper">
            <?php foreach($featured_players as $index => $player): ?>
                <div class="carousel-card" data-player-id="<?php echo $player['member_id']; ?>">
                    <div class="player-image">
                        <img id="preview-<?php echo $index; ?>" src="<?php echo htmlspecialchars('dashboard/admin/' . $player['image_path']); ?>" alt="Player Image">
                    </div>
                    <div class="player-info">
                        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'start' && $_SESSION['authority'] == 'admin'): ?>
                            <!-- Editable Content -->
                            <div class="view-content">
                                <h3><?php echo htmlspecialchars($player['full_name']); ?></h3>
                                <p><?php echo htmlspecialchars($player['position']); ?></p>
                            </div>
                            <div class="editable-content">
                                <input type="hidden" name="members[<?php echo $index; ?>][member_id]" value="<?php echo $player['member_id']; ?>">
                                <label>
                                    Name:
                                    <input type="text" name="members[<?php echo $index; ?>][full_name]" value="<?php echo htmlspecialchars($player['full_name']); ?>">
                                </label>
                                <label>
                                    Position:
                                    <input type="text" name="members[<?php echo $index; ?>][position]" value="<?php echo htmlspecialchars($player['position']); ?>">
                                </label>
                                <label>
                                    Image:
                                    <input type="file" name="members[<?php echo $index; ?>][image_path]" onchange="previewImage(event, 'preview-<?php echo $index; ?>')">
                                </label>
                            </div>
                        <?php elseif (isset($_SESSION['logged']) && $_SESSION['logged'] == 'start'): ?>
                            <!-- Display Only for Non-Admin Logged-in Users -->
                            <h3><?php echo htmlspecialchars($player['full_name']); ?></h3>
                            <p><?php echo htmlspecialchars($player['position']); ?></p>
                        <?php else: ?>
                            <!-- Display Only for Guests -->
                            <h3><?php echo htmlspecialchars($player['full_name']); ?></h3>
                            <p><?php echo htmlspecialchars($player['position']); ?></p>
                            <p class="login-prompt">Log in to see more details!</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Global Save Changes Button for Admins -->
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'start' && $_SESSION['authority'] == 'admin'): ?>
            <button type="submit" class="global-save-button editable-content">Save Changes</button>
            </form> <!-- End of Global Form Wrapper -->
        <?php endif; ?>
        <button class="carousel-button next-button" onclick="moveCarousel(1)">→</button>
    </div>
</div>




    <!-- More Players Grid Section -->
    <div class="site-section bg-light">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">More Members</h2>
            </div>

            <div class="filter-controls">
                <button class="filter-button <?php echo $position === '' ? 'active' : ''; ?>" 
                        onclick="filterPlayers('')">All</button>
                <?php foreach($positions as $pos): ?>
                    <button class="filter-button <?php echo $position === $pos ? 'active' : ''; ?>"
                            onclick="filterPlayers('<?php echo htmlspecialchars($pos); ?>')">
                        <?php echo htmlspecialchars($pos); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="players-grid">
                <?php foreach($grid_players as $player): ?>
                    <div class="player-card" data-player-id="<?php echo $player['member_id']; ?>">
                        <div class="player-image">
                            <img src="<?php echo htmlspecialchars($player['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($player['full_name']); ?>">
                        </div>
                        <div class="player-info">
                            <h3><?php echo htmlspecialchars($player['full_name']); ?></h3>
                            <p><?php echo htmlspecialchars($player['position']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Player Details Modal -->
    <div id="playerModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="playerDetails"></div>
        </div>
    </div>

<?php
require('footer.html');
?>
    

  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  
       <!-- Player Details Modal -->
    <div id="playerModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="playerDetails"></div>
        </div>
    </div>
    <script>
// Existing carousel variables
let currentPosition = 0;
const wrapper = document.querySelector('.carousel-wrapper');
const cards = document.querySelectorAll('.carousel-card');
const cardWidth = cards[0].offsetWidth + 20; // Including margin
let maxPosition = cards.length - 4; // Show 4 cards at once

// Add edit mode state
let isEditMode = true;

// Edit mode toggle function
function toggleEditMode() {
    const editButton = document.getElementById('editModeButton');
    const editableElements = document.querySelectorAll('.editable-content');
    const viewElements = document.querySelectorAll('.view-content');
    const saveButton = document.querySelector('.global-save-button');
    
    isEditMode = !isEditMode;
    
    if (isEditMode) {
        editButton.textContent = 'Enter Edit Mode';
        editableElements.forEach(el => el.style.display = 'none');
        viewElements.forEach(el => el.style.display = 'block');
        if (saveButton) saveButton.style.display = 'none';
        
        // Disable card click events in edit mode
        playerCards.forEach(card => {
            card.style.pointerEvents = 'none';
        });
    } else {
        editButton.textContent = 'Exit Edit Mode';
        editableElements.forEach(el => el.style.display = 'block');
        viewElements.forEach(el => el.style.display = 'none');
        if (saveButton) saveButton.style.display = 'block';
        
        // Re-enable card click events
        playerCards.forEach(card => {
            card.style.pointerEvents = 'auto';
        });
    }
}

// Carousel functionality
function moveCarousel(direction) {
    currentPosition = Math.min(Math.max(currentPosition + direction, 0), maxPosition);
    wrapper.style.transform = `translateX(-${currentPosition * cardWidth}px)`;
    
    // Update button states
    document.querySelector('.prev-button').disabled = currentPosition === 0;
    document.querySelector('.next-button').disabled = currentPosition === maxPosition;
}

// Filter functionality
function filterPlayers(position) {
    window.location.href = `?position=${encodeURIComponent(position)}`;
}

// Modal functionality
const modal = document.getElementById('playerModal');
const playerCards = document.querySelectorAll('.player-card, .carousel-card');
const closeModal = document.querySelector('.close-modal');

playerCards.forEach(card => {
    card.addEventListener('click', async () => {
        // Don't open modal if in edit mode
        if (isEditMode) return;
        
        const playerId = card.dataset.playerId;
        try {
            const response = await fetch(`get_player_details.php?id=${playerId}`);
            const playerDetails = await response.json();
            
            document.getElementById('playerDetails').innerHTML = `
                <div class="player-modal-content">
                    <img src="${playerDetails.image_path}" alt="${playerDetails.full_name}" 
                         style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; margin: 0 auto; display: block;">
                    <h2>${playerDetails.full_name}</h2>
                    <p>Position: ${playerDetails.position}</p>
                    <p>Jersey Number: ${playerDetails.jersey_number}</p>
                </div>
            `;
            modal.style.display = 'block';
        } catch (error) {
            console.error('Error fetching player details:', error);
        }
    });
});

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Handle responsive viewing
function updateCarouselView() {
    const viewportWidth = window.innerWidth;
    let cardsToShow;
    
    if (viewportWidth <= 480) cardsToShow = 1;
    else if (viewportWidth <= 768) cardsToShow = 2;
    else if (viewportWidth <= 1024) cardsToShow = 3;
    else cardsToShow = 4;
    
    maxPosition = cards.length - cardsToShow;
    currentPosition = Math.min(currentPosition, maxPosition);
    wrapper.style.transform = `translateX(-${currentPosition * cardWidth}px)`;
}

// Image preview functionality
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
    };
    if (file) {
        reader.readAsDataURL(file);
    }
}

// Initialize
window.addEventListener('resize', updateCarouselView);
updateCarouselView(); // Initial setup

// Initialize edit mode state on page load
document.addEventListener('DOMContentLoaded', function() {
    const editableElements = document.querySelectorAll('.editable-content');
    const saveButton = document.querySelector('.global-save-button');
    editableElements.forEach(el => el.style.display = 'none');
    if (saveButton) saveButton.style.display = 'none';
});
    </script>
  </body>
  
</html>
<?php
require 'important_include.php';
?>   