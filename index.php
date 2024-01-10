<?php
include "./assets/php/config.php";
include "./assets/php/login.php";
// Fetch a random listing
$randomListingQuery = "SELECT * FROM listings ORDER BY RAND() LIMIT 1";
$randomListingStmt = $pdo->query($randomListingQuery);
$randomListing = $randomListingStmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
.overons {
    background-color: #FFF;
    border: 2px solid black;
    display: flex;
    padding: 40px;  /* Increased from 20px to 40px for more space */
    max-width: 900px;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}


.overons-logo {
    width: 22.5%; /* Adjusted to be 10% smaller than before */
    max-height: 100%; 
    margin-right: 20px;
}

.overons-content {
    display: flex;
    flex-direction: column;
    width: 77.5%; /* Adjusted to ensure the total width is 100% */
}

.overons-content p.title {
    margin: 0 0 10px 0;
    font-size: 1.2em; 
    text-align: center; 
}

.overons-content p {
    margin: 0;
    font-size: 0.85em;
    line-height: 1.4;
}

    </style>
</head>
<body>
<header>
    <div class="container">
        <a href="index.php"><img class="logo" src="./assets/img/Vrijwonen_makelaar.png" alt="logo"></a>
        <div class="nav">
            <a href="./woningen.php">woningen</a>
            <a href="contact.php">contact</a>
            <a href="./about.php">about</a>
        </div>
        <?php
        include "./assets/php/header.php"
        ?>
    </div>
</header>

<main>
<div class="overons">
    <img class="overons-logo" src="./assets/img/Vrijwonen_makelaar.png" alt="logo">
    <div class="overons-content">
        <p class="title">over ons</p>
        <p>Bij Vrij Wonen begrijpen we dat een huis meer is dan alleen een plek om te wonen. Het is de plek waar uw dromen en toekomstige herinneringen worden gevormd. Ons toegewijde team van fictieve makelaars staat klaar om u te begeleiden op uw reis naar het vinden van de perfecte woning, zelfs als die woning nog niet bestaat!</p>
    </div>
</div>


<div class="listing">
    <!-- Image section -->
    <div class="listing-images">
        <img class="main-image" src="./assets/php/<?php echo $randomListing['cover_image_path']; ?>" alt="Main House Image">
        <div class="more-images">
            <?php
            // Assuming extra images are stored as comma-separated values
            $extraImages = explode(',', $randomListing['extra_images']);
            foreach ($extraImages as $image):
                if (!empty($image)):
            ?>
                <img src="./assets/php/<?php echo $image; ?>" alt="House Image">
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>

    <!-- Text section -->
    <div class="listing-info">
        <h2><?php echo $randomListing['address']; ?></h2>
        <p><?php echo $randomListing['beschrijving']; ?></p>
        <div class="price-info">
            <div class="listing-price">€<?php echo $randomListing['prijs']; ?></div>
            <button class="more-info">Meer Info</button>
        </div>
    </div>
</div>






</main>

<footer>
    <img class="logo-footer" src="./assets/img/Vrijwonen_makelaar.png" alt="logo">
    <div class="address">
        <p>Disketteweg 2</p>
        <p>3815 AV Amersfoort</p>
    </div>
    <div class="contact">
        <p>info@vrijwonen.nl</p>
        <p>033-1122334</p>
    </div>
</footer>

<!-- Login Modal -->
<div id="loginModal" class="login-modal">
    <div class="login-modal-content">
        <span class="close-btn">&times;</span>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <!-- If the user is logged in, show the admin and logout buttons -->
            <a href="./assets/php/admin.php" class="login-action">Go to Admin</a>
            <a href="./assets/php/logout.php" class="login-action">Logout</a>
        <?php else: ?>
            <!-- If the user is not logged in, show the login form -->
            <form method="post" action="./assets/php/login.php">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="login-action">Login</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script src="./assets/js/inlogmodal.js"></script>
</body>
</html>