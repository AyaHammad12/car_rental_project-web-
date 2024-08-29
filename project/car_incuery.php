<?php
require_once 'connection.php';
require_once 'Car.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;
    $pickupLocation = $_POST['pickupLocation'] ?? null;
    $returnDate = $_POST['returnDate'] ?? null;
    $returnLocation = $_POST['returnLocation'] ?? null;
    $includeRepair = isset($_POST['includeRepair']) ? 1 : 0;
    $includeDamage = isset($_POST['includeDamage']) ? 1 : 0;
} else {
    
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+1 week'));
}

try {


    // SELECT `carID`, `carModel`, `carMake`, `carType`, `registrationYear`, `description`, `pricePerDay`, `capacityOfPeople`, `colors`, `fuelType`, `averageConsumption`, `horsepower`, `length`, 
    // `width`, `plateNumber`, `mileage`, `features`, `status`, `conditions`, `carPhotoURL`, `capacityOfSuitcases`, `gearType` FROM `cars` WHERE 1
    
    // Prepare the SQL query based on the form criteria
    // $sql = "SELECT * FROM cars WHERE 1=1"; 

    // SELECT `reservationID`, `carID`, `userID`, `startDate`
    // , `endDate`, `totalPrice`, `pickUpDate`, `returnDate`, `pickUpLocation`, `returnLocation`, `status` FROM `reservations` WHERE 1
    
    // SELECT `locationID`, `name`, `addressID`, `telephone` FROM `locations` WHERE 1

    $sql = "SELECT c.*, l.* 
    FROM cars c 
    LEFT JOIN reservations r ON c.carID = r.carID 
    LEFT JOIN locations l ON r.pickUpLocation = l.locationID 
    WHERE 1=1"; 
   
    if (!empty($startDate) && !empty($endDate)) {
        $sql .= " AND startDate >= '$startDate' AND endDate <= '$endDate'";
    }

    if (!empty($pickupLocation)) {
        $sql .= " AND l.name = '$pickupLocation'";
    }

    if (!empty($returnDate)) {
        $sql .= " AND r.returnDate = '$returnDate'";
    }

    if (!empty($returnLocation)) {
        $sql .= " AND l.name = '$returnLocation'";
    }

    if ($includeRepair) {
        $sql .= " AND c.status = 'In Repair'";
    }

    if ($includeDamage) {
        $sql .= " AND c.status = 'In Damage'";
    }

    // Execute the query
    $stmt = $pdo->query($sql);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Inquiry</title>
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
    <h1></h1>
    <fieldset>
    <legend><h2>Cars Inquiry</h2></legend>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Start Date: <input type="date" name="startDate"><br>
        End Date: <input type="date" name="endDate"><br>
        Pickup Location: <input type="text" name="pickupLocation"><br>
        Return Date: <input type="date" name="returnDate"><br>
        Return Location: <input type="text" name="returnLocation"><br>
        Include Repair: <input type="checkbox" name="includeRepair" value="1"><br>
        Include Damage: <input type="checkbox" name="includeDamage" value="1"><br>
        <input type="submit" value="Search">
    </form>
    </fieldset>

    <?php if (isset($cars)) : ?>
        <?php if (!empty($cars)) : ?>
            <h2>Search Results</h2>
            <table border="1">
                <tr>
                    <th>Car ID</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Fuel Type</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($cars as $car) : ?>
                    <?php $carObj = new Car($car); ?>
                    <tr>
                        <td><?php echo $carObj->getCarID(); ?></td>
                        <td><?php echo $carObj->getCarType(); ?></td>
                        <td><?php echo $carObj->getCarModel(); ?></td>
                        <td><?php echo $carObj->getDescription(); ?></td>
                        <td>
                            <img src="./images/<?php echo $carObj->getFirstCarPhotoURL(); ?>" alt="Car Image" style="max-width: 100px;"><br>
                            <p><?php echo $carObj->getFirstCarPhotoURL(); ?></p>
                        </td>
                        <td><?php echo $carObj->getFuelType(); ?></td>
                        <td><?php echo $carObj->getStatus(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No cars found based on the search criteria.</p>
        <?php endif; ?>
    <?php endif; ?>
    </main>
    <footer>
    <!-- Footer content -->
    <?php
    echo getFooter();
    ?>
</footer>
</body>
</html>