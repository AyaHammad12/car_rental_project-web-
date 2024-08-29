<!DOCTYPE html>
<html>
<head>
    <title>Add New Location</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
<?php
    require_once 'file.php';
    generateHeader();
    ?>
  
</header>
<nav>

    <?php
    displayUserLinks();
   ?> 

</nav>
<main>
    
    
    <fieldset>
     <legend><h2>Add New Location</h2></legend>
     <form action="add_location_form.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="flat">Flat/House No:</label>
        <input type="text" id="flat" name="flat" required><br><br>
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required><br><br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required><br><br>
        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code" required><br><br>
        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" required><br><br>
        <input type="submit" value="Add Location">
    </form>
    </fieldset>
    </main>
    <footer>
   
    <?php
    echo getFooter();
    ?>

</footer>
</body>
</html>
<?php
session_start();



require_once('connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postal_code = $_POST['postal_code'];
    $telephone = $_POST['telephone'];

    try {
        $pdo->beginTransaction();

      
        $stmtAddress = $pdo->prepare("INSERT INTO addresses (flat, street, city, country, postal_code) VALUES (:flat, :street, :city, :country, :postal_code)");
        $stmtAddress->bindParam(':flat', $flat);
        $stmtAddress->bindParam(':street', $street);
        $stmtAddress->bindParam(':city', $city);
        $stmtAddress->bindParam(':country', $country);
        $stmtAddress->bindParam(':postal_code', $postal_code);
        $stmtAddress->execute();

        $address_id = $pdo->lastInsertId(); 
        echo " address_id :  ". $address_id."<br>";

        // INSERT INTO `locations`(`locationID`, `name`, `addressID`, `telephone`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')

        
        $stmtLocation = $pdo->prepare("INSERT INTO locations (name, addressID, telephone) VALUES (:name, :address_id, :telephone)");
        $stmtLocation->bindParam(':name', $name);
        $stmtLocation->bindParam(':address_id', $address_id);
        $stmtLocation->bindParam(':telephone', $telephone);
        $stmtLocation->execute();

        $location_id = $pdo->lastInsertId(); 

        $pdo->commit();

        echo " Location added successfully. Location ID: $location_id";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
