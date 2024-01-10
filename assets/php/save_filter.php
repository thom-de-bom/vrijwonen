<?php
include "config.php"; // Make sure to include your database configuration

// Check if the form data exists
if(isset($_POST['filter-name']) && !empty($_POST['filter-name'])) {
    // Retrieve the filter names and split them based on the dash
    $filterNames = explode('-', $_POST['filter-name']);

    // Prepare SQL statement for inserting filters
    $stmt = $pdo->prepare("INSERT INTO filters (name, option) VALUES (:name, :option)");

    foreach ($filterNames as $filterName) {
        // Trim whitespace from each filter name
        $filterName = trim($filterName);

        // Check if a filter type is selected
        $filterType = isset($_POST['filter-option']) ? $_POST['filter-option'] : 'default_type'; // Adjust 'default_type' as needed

        // Execute the prepared statement
        $stmt->execute(['name' => $filterName, 'option' => $filterType]);
    }

    // Redirect to admin.php or display a success message
    header('Location: admin.php?showFilters=true');
    exit;

}
?>
