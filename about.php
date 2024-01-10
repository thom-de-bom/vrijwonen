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
main {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - /* header height */ 60px - /* footer height */ 60px); 
    /* Adjust the heights in the calc() function based on your actual header and footer heights */
}

.overons {
    margin-top: 0; /* Resetting margin-top to 0 as we are centering it using flexbox */
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
    width: 185px; /* Setting fixed width */
    height: 90px; /* Setting fixed height */
    padding-right: 15px;
    
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
    color: #333; /* Making text a bit darker */
    text-shadow: 1px 1px 2px rgba(255,255,255,0.5); /* Adding subtle shadow for better readability */
    margin: 0;
    font-size: 0.85em;
    line-height: 1.4;
    text-align: left;
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
        <p>Welkom bij Vrij Wonen - Uw Partner in Woninggeluk!
        Bij Vrij Wonen begrijpen we dat een huis meer is dan alleen een plek om te wonen. Het is de plek waar uw dromen en
        toekomstige herinneringen worden gevormd. Ons toegewijde team van fictieve makelaars staat klaar om u te begeleiden op
        uw reis naar het vinden van de perfecte woning, zelfs als die woning nog niet bestaat!
        Wat Maakt Ons Uniek?
        Bij Vrij Wonen geloven we in het creéren van woningmagie. Hier zijn enkele redenen waarom u voor ons zou moeten kiezen:
        1. Maatwerk: We zijn gespecialiseerd in het vinden of creéren van woningen die aansluiten bij uw unieke wensen en
        behoeften. Als het huis van uw dromen niet op de markt is, kunnen we het voor u vinden of zelfs helpen bouwen.
        2. Verbeeldingskracht: Onze fictieve makelaars beschikken over een ongeévenaarde verbeeldingskracht. Ze kunnen u
        helpen bij het visualiseren van mogelijkheden voor elke ruimte en u inspireren met innovatieve ontwerpen.
        3. Onbeperkte Locaties: Bij Vrij Wonen zijn we niet beperkt tot specifieke geografische gebieden. Of u nu een
        stadsappartement, een landhuis of zelfs een drijvende villa wilt, Wij kunnen u helpen het te vinden.
        4. Persoonlijke Aandacht: We begrijpen dat het kopen of verkopen van een woning een belangrijke beslissing is. Daarom
        bieden we persoonlijke begeleiding en ondersteuning gedurende het hele proces.
        5. Vrijheid en Avontuur: We omarmen het concept van "vrij wonen" en moedigen u aan om out-of-the-box te denken.
        Samen kunnen we de woning van uw dromen ontdekken, waar die 00k mag zijn.
        Bij Vrij Wonen geloven we dat uw ideale woning binnen handbereik is, zelfs als die nog niet bestaat. Laat ons u helpen bij
        het ontdekken van de mogelijkheden en het realiseren van uw woondromen. Neem vandaag nog contact met ons op en
        ervaar de magie van Vrij Wonen!
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