<?php
include_once("db.php"); // Include the Database class file
include_once("town_city.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    

    'name' => $_POST['name'],
    ];

    // Instantiate the Database and Town City classes
    $database = new Database();
    $town_city = new TownCity($database);
    $town_city_id = $town_city->create($data);
}
?>
