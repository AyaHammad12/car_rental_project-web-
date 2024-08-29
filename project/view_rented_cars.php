<?php
// Start the session
session_start();
// $_SESSION['user_id']=2;
// role
// $_SESSION['user_id']=2;
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
require_once 'connection.php';

// Get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Fetch rented cars for the logged-in user
// SELECT `reservationID`, `carID`, `userID`, `startDate`, `endDate`, `totalPrice`, `pickUpDate`, `returnDate`,
//  `pickUpLocation`, `returnLocation` FROM `reservations` WHERE 1


// SELECT `carID`, `carModel`, `carMake`, `carType`, `registrationYear`, `description`, `pricePerDay`, `capacityOfPeople`, `colors`, `fuelType`, `averageConsumption`, `horsepower`, `length`, 
// `width`, `plateNumber`, `mileage`, `features`, `status`, `conditions`, `carPhotoURL`, `capacityOfSuitcases`, `gearType` FROM `cars` WHERE 1

$sql = "SELECT r.reservationID, r.startDate, c.carType, c.carModel, r.pickUpDate, r.pickUpLocation, r.returnDate, r.returnLocation, r.status
        FROM reservations r
        JOIN cars c ON r.carID = c.carID
        WHERE r.userID = :user_id
        ORDER BY r.startDate DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$rentedCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rented Cars</title>
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
    <div class="container">
        <h1>Rented Cars</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Invoice Date</th>
                    <th>Car Type</th>
                    <th>Car Model</th>
                    <th>Pick-Up Date</th>
                    <th>Pick-Up Location</th>
                    <th>Return Date</th>
                    <th>Return Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentedCars as $car): 
                    $statusClass = '';
                    if ($car['status'] == 'future') {
                        $statusClass = 'future';
                    } elseif ($car['status'] == 'current') {
                        $statusClass = 'current';
                    } elseif ($car['status'] == 'past') {
                        $statusClass = 'past';
                    }
                ?>
                    <tr class="<?php echo $statusClass; ?>">
                        <td><?php echo ($car['reservationID']); ?></td>
                        <td><?php echo ($car['startDate']); ?></td>
                        <td><?php echo ($car['carType']); ?></td>
                        <td><?php echo ($car['carModel']); ?></td>
                        <td><?php echo ($car['pickUpDate']); ?></td>
                        <td><?php echo ($car['pickUpLocation']); ?></td>
                        <td><?php echo ($car['returnDate']); ?></td>
                        <td><?php echo ($car['returnLocation']); ?></td>
                        <td><?php echo (($car['status'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </main>
<footer>
    <!-- Footer content -->
    <?php
    echo getFooter();
    ?>
</footer>
</body>
</html>
