<?php
include_once("../db.php");
include_once("../province.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $db = new Database();
    $prov = new Province($db);
    $provData = $prov->read($id);

    if ($provData) {

    } else {
        echo "Province not found.";
    }
} else {
    echo "province ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $prov = new Province($db);

    if ($prov->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Province</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Province Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $provData['id']; ?>">
        
        <label for="name">Province Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $provData['name']; ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
