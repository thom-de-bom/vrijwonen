<?php
ini_set('display_errors', 1); error_reporting(E_ALL);
include "./assets/php/login.php";
include "./assets/php/config.php";

// Initialize variables
$filtered_listings = [];
$totalPages = 0;
$perPage = 3;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $perPage;

// Fetch filter options from the database
$filtersQuery = "SELECT * FROM filters"; // Adjust the table name if different
$filtersResult = $pdo->query($filtersQuery);
$allFilters = $filtersResult->fetchAll(PDO::FETCH_ASSOC);

$liggingFilters = [];
$eigenschappenFilters = [];

foreach ($allFilters as $filter) {
    if ($filter['option'] == 'ligging') {
        $liggingFilters[] = $filter;
    } elseif ($filter['option'] == 'eigenschappen') {
        $eigenschappenFilters[] = $filter;
    }
}

// Function to fetch listings based on filters
function fetchListingsBasedOnFilters($pdo, $filters) {
    $query = "SELECT * FROM listings WHERE ";
    $conditions = [];
    $parameters = [];

    if (!empty($filters['ligging'])) {
        $conditions[] = "ligging IN (" . implode(', ', array_fill(0, count($filters['ligging']), '?')) . ")";
        $parameters = array_merge($parameters, $filters['ligging']);
    }

    if (!empty($filters['eigenschappen'])) {
        $conditions[] = "eigenschappen IN (" . implode(', ', array_fill(0, count($filters['eigenschappen']), '?')) . ")";
        $parameters = array_merge($parameters, $filters['eigenschappen']);
    }

    if (empty($conditions)) {
        $query = "SELECT * FROM listings"; // Default query if no filters
    } else {
        $query .= implode(' AND ', $conditions);
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($parameters);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check for POST request to apply filters
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $liggingFilters = isset($_POST['ligging']) ? $_POST['ligging'] : [];
    $eigenschappenFilters = isset($_POST['eigenschappen']) ? $_POST['eigenschappen'] : [];

    $filters = [
        'ligging' => $liggingFilters,
        'eigenschappen' => $eigenschappenFilters
    ];

    $filtered_listings = fetchListingsBasedOnFilters($pdo, $filters);
    echo $filtered_listings;
    $totalListings = count($filtered_listings);
    $totalPages = ceil($totalListings / $perPage);
} else {
    // Fetch all listings if no filters are applied
    $sql = "SELECT * FROM listings LIMIT :perPage OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $filtered_listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalSql = "SELECT COUNT(*) FROM listings";
    $totalListings = $pdo->query($totalSql)->fetchColumn();
    $totalPages = ceil($totalListings / $perPage);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>

    .filter-button {
    display: flex;
    background-color: #FFF;
    border: 1px solid black;
    padding: 10px 20px;
    cursor: pointer;
    max-width: 3%;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    justify-content: center;
    margin-top: 10px;
    text-decoration: none;
}

.bars {
    margin-left: 10px;
}

.modal {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;  /* This value ensures the modal is above most other elements */
}

.modal-content {
    background-color: #FFF;
    margin: 8% auto;
    padding: 20px;
    width: 50%;
    z-index: 1001;  /* This value ensures the content is above the modal background */
}


.close-btn {
    cursor: pointer;
    float: right;
    font-size: 28px;
}


.filterhouder{
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 5%;
}
.ligging{
    display: flex;
    flex-direction: column;
}
.eigenschappen{
    display: flex;
    flex-direction: column;
}

.overig{
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.page-button {
    background-color: #FFF;
    border: 1px solid black;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.page-button:hover {
    background-color: #f5f5f5;
}

.page-button.dots, .page-button.last {
    width: auto;
    padding: 0 10px;
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

<a href="#" id="filterBtn" class="filter-button">
    Filters
    <span class="bars">☰</span>
</a>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="filterhouder">
        <div class="ligging">
            <h2>Ligging</h2>
            <?php foreach ($liggingFilters as $filter): ?>
                <label>
                    <input type="checkbox" name="ligging[]" value="<?= htmlspecialchars($filter['id']) ?>"> <!-- Corrected name -->
                    <?= htmlspecialchars($filter['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
            
        <div class="eigenschappen">
            <h2>Eigenschappen</h2>
            <?php foreach ($eigenschappenFilters as $filter): ?>
                <label>
                    <input type="checkbox" name="eigenschappen[]" value="<?= htmlspecialchars($filter['id']) ?>"> <!-- Corrected name -->
                    <?= htmlspecialchars($filter['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
            <div class="overig">
                <label><input type="checkbox" name="filterOption11"> postcode: <input type="text" name="postcode" id="postcode"></label>
                <label><input type="checkbox" name="filterOption13"> prijs (max): <input type="text" name="prijsmax" id="prijsmax"></label>
            </div>
            
        </div>
    </div>
</div>




<div id="listingsContainer">
    <?php foreach ($filtered_listings as $row): ?>
            <div class="listing">
                <!-- Image section -->
                <div class="listing-images">
                    <img class="main-image" src="./assets/php/<?php echo $row['cover_image_path']; ?>" alt="Main House Image">
                    <div class="more-images">
                        <?php
                        // Assuming extra images are stored as comma-separated values
                        $extraImages = explode(',', $row['extra_images']);
                        // Loop through the extra images and display a maximum of three images
                        for ($i = 0; $i < min(3, count($extraImages)); $i++):
                        ?>
                            <img src="./assets/php/<?php echo $extraImages[$i]; ?>" alt="House Image">
                        <?php endfor; ?>
                    </div>    
                </div>

                <!-- Text section -->
                <div class="listing-info">
                    <h2><?php echo $row['address']; ?></h2>
                    <p><?php echo $row['beschrijving']; ?></p>
                    <div class="price-info">
                        <div class="listing-price"><?php echo '€ ' . $row['prijs']; ?></div>
                        <button class="more-info">Meer Info</button>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
</div>

    <div class="pagination" style="padding-bottom: 10px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="page-button <?php echo $i == $currentPage ? 'active' : ''; ?>">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
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
<script>
// modal script
let modal = document.getElementById('modal');
let btn = document.getElementById('filterBtn');
let span = document.getElementsByClassName('close-btn')[0];

btn.onclick = function() {
    modal.style.display = 'block';
}

span.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
// buttons script

let buttons = document.querySelectorAll(".page-button");
for (let button of buttons) {
    button.addEventListener("click", function() {
        let pageNumber = this.innerText;

        // You can use the pageNumber to fetch the respective listings for that page
        // Example: loadListings(pageNumber);
    });
}
</script>

<script>
   // Object to store current filters
let currentFilters = {};

document.addEventListener('DOMContentLoaded', function() {
    // Handle filter changes
    document.querySelectorAll('.filterhouder input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            currentFilters = {};
            document.querySelectorAll('.filterhouder input[type="checkbox"]:checked').forEach(function(checkedBox) {
                if (!currentFilters[checkedBox.name]) {
                    currentFilters[checkedBox.name] = [];
                }
                currentFilters[checkedBox.name].push(checkedBox.value);
            });
            updateListings(1); // Always revert to the first page when filters change
        });
    });

    // Handle pagination
    document.querySelector('.pagination').addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            event.preventDefault();
            let page = parseInt(event.target.textContent);
            updateListings(page);
        }
    });
});

function updateListings(page) {
    let filterData = new FormData();
    filterData.append('page', page);

    for (let filter in currentFilters) {
        currentFilters[filter].forEach(value => {
            filterData.append(`${filter}[]`, value);
        });
    }

    // Additional filters for postcode and maximum price
    if (document.querySelector('input[name="filterOption11"]').checked) {
        filterData.append('postcode', document.getElementById('postcode').value);
    }
    if (document.querySelector('input[name="filterOption13"]').checked) {
        filterData.append('prijsmax', document.getElementById('prijsmax').value);
    }

    fetch('./assets/php/fetch_filtered_listings.php', {
            method: 'POST',
            body: filterData
        })
        .then(response => response.json())
        .then(data => updateUI(data, page))
        .catch(error => console.error('Error:', error));
}


    function updateUI(data, currentPage) {
        let listingsContainer = document.querySelector('#listingsContainer');
        listingsContainer.innerHTML = '';

        data.listings.forEach(listing => {
            let listingElement = document.createElement('div');
            listingElement.className = 'listing';
            
            // Additional checks for image URLs and other properties
            let mainImage = listing.cover_image_path ? `<img class="main-image" src="./assets/php/${listing.cover_image_path}" alt="Main House Image">` : '';
            let extraImagesHtml = listing.extra_images ? listing.extra_images.split(',').map(image => `<img src="./assets/php/${image.trim()}" alt="House Image">`).join('') : '';

            listingElement.innerHTML = `
                <div class="listing-images">
                    ${mainImage}
                    <div class="more-images">${extraImagesHtml}</div>
                </div>
                <div class="listing-info">
                    <h2>${listing.address || ''}</h2>
                    <p>${listing.beschrijving || ''}</p>
                    <div class="price-info">
                        <div class="listing-price">€${listing.prijs || ''}</div>
                        <button class="more-info">Meer Info</button>
                    </div>
                </div>
            `;
            listingsContainer.appendChild(listingElement);
        });

        // Update pagination
        updatePagination(data.total, currentPage);
    }

    function updatePagination(totalItems, currentPage) {
        let paginationContainer = document.querySelector('.pagination');
        paginationContainer.innerHTML = '';
        let totalPages = Math.ceil(totalItems / 3);

        for (let i = 1; i <= totalPages; i++) {
            let pageButton = document.createElement('a');
            pageButton.href = `?page=${i}`;
            pageButton.textContent = i;
            pageButton.className = 'page-button ' + (i === currentPage ? 'active' : '');
            pageButton.addEventListener('click', function(event) {
                event.preventDefault();
                updateListings(i);
            });
            paginationContainer.appendChild(pageButton);
        }
    }
</script>




</body>
</html>