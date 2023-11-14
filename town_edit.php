<?php
include_once("db.php"); // Include the Database class file
include_once("town_city.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch Town City data by ID from the database
    $db = new Database();
    $town_city = new TownCity($db);
    $town_city_Data = $town_city->read($id); 


} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],  
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $town_city = new TownCity($db);

    // Call the edit method to update the town city data
    if ($town_city->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
  }
?>
