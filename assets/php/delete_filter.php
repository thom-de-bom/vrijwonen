<?php
include "config.php"; // Include your DB config file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['filter-name-or-id'];

    // Split the input into an array
    $filters = explode('-', $input);

    foreach ($filters as $filter) {
        if (is_numeric($filter)) {
            // If $filter is numeric, treat it as an ID
            $query = "DELETE FROM filters WHERE id = :filter";
        } else {
            // Otherwise, treat it as a name
            $query = "DELETE FROM filters WHERE name = :filter";
        }

        $statement = $pdo->prepare($query);
        $statement->bindValue(':filter', $filter);
        $statement->execute();
    }
}

// Redirect back to admin page or wherever you'd like
header('Location: admin.php?showFilters=true');
exit;
?>
