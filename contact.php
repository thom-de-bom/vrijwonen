<?php
include "./assets/php/login.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
.contact-div {
    text-align: center;
    padding: 20px;
    background-color: #FFF;
    border: 2px solid black;
    width: 70%; /* Adjust to your preferred width */
    max-width: 800px; /* Limit the width, can be adjusted as per requirements */
    margin: 50px auto; /* Centers the form container horizontally and adds top and bottom margin */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: adds a subtle shadow */
    display: flex;
    flex-direction: column;
    align-items: center;
}

.contact-div p{
    margin-top: 1px;
}

.input-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.input-row input, 
textarea, 
.contact-btn {
    border: 2px solid black;
    padding: 10px;
    background: transparent;
    border-radius: 0; /* To ensure sharp rectangular corners */
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.input-row input {
    flex: 1; /* To ensure equal distribution of space */
    margin-right: 10px; /* Space between inputs */
}

.input-row input:last-child {
    margin-right: 0;
}

textarea {
    width: 100%;
    min-height: 100px; /* You can adjust this as per your requirements */
    margin-bottom: 20px;
}

.contact-btn {
    cursor: pointer;
    padding: 10px 20px; /* Adjust padding for the button */
}

.success-notification {
    background-color: #4CAF50; 
    padding: 10px;
    color: white;
    border-radius: 3px;
    text-align: center;
    margin-bottom: 20px;
}

.error-notification {
    background-color: #f44336; 
    padding: 10px;
    color: white;
    border-radius: 3px;
    text-align: center;
    margin-bottom: 20px;
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
<div id="formWrapper">
    <form action="./assets/php/handle_contact.php" method="post" class="contact-div">
        <p>Contact</p>

        <div class="input-row">
            <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email" required>  
            <input type="text" id="volledige-naam" name="volledige-naam" placeholder="Volledige Naam" required>
            <input type="tel" id="mobiel" name="mobiel" pattern="^[0-9]*$" placeholder="Mobiel" required>

        </div>

        <textarea id="bericht" name="bericht" rows="5" placeholder="Bericht" style="resize: none;" required></textarea>
        <button type="submit" class="contact-btn">Verstuur</button>
    </form>
</div>
<div id="notification" style="display:none;">Your message has been successfully submitted!</div>



</main>

<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        echo '<p class="success-notification">Your message has been successfully submitted!</p>';
    } elseif ($_GET['status'] === 'error') {
        echo '<p class="error-notification">There was an error submitting your form. Please try again.</p>';
    }
}

?>

</script>

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