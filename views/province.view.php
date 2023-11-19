<?php
include_once("../db.php");
include_once("../province.php");

$db = new Database();
$connection = $db->getConnection();
$prov = new Province($db);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Province Records</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <?php include('../templates/header.html'); ?>
        <?php include('../includes/navbar.php'); ?>

        <div class="content">
            <h2>Province Records</h2>
            <table class="orange-theme">
                <thead>
                    <tr>
                        <th>Name</th> <!-- will change -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr> -->
                    <?php
                    $results = $prov->displayAll();
                    foreach ($results as $x) {
                        echo '<tr>';
                        echo "<td>" . $x['name'] . "</td>";
                        echo "<td><a href=province_edit.php?id=". $x['id'].">Edit</a>|<a href=province_delete.php?id=". $x['id'].">Delete</a></td>";
                        echo '</tr>';
                    }
                    ?>
                    <!-- </tr> -->
                </tbody>
            </table>
            <a class="button-link" href="province_add.php">Add New Record</a>
        </div>
    </body>
</html>