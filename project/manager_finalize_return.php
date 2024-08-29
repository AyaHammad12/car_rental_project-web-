<?php
session_start();
// $_SESSION['user_id'] = 1; // For testing purposes; ensure this is set upon login

// Redirect to login if the manager is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php'; // Assumes this file contains the PDO connection setup
$pdo = db_connect();
// Fetch all cars with status 'returning'
$sql = "SELECT r.reservationID, c.carID, c.carMake, c.carType, c.carModel, r.pickUpDate, r.returnDate, r.returnLocation, r.pickUpLocation ,r.status, u.name as customerName
        FROM reservations r
        JOIN cars c ON r.carID = c.carID
        JOIN users u ON r.userID = u.userID
        WHERE r.status = 'returning'
        ORDER BY r.pickUpDate ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$returningCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
// pickUpLocation

// $sql = "SELECT r.reservationID, c.carID, c.carMake, c.carType, c.carModel, r.pickUpDate, r.returnDate, r.returnLocation 
//         FROM reservations r 
//         JOIN cars c ON r.carID = c.carID 
//         WHERE r.userID = :user_id AND r.status = 'current'";

// SELECT `reservationID`, `carID`, `userID`, 
// `startDate`, `endDate`, `totalPrice`, `pickUpDate`, `returnDate`, `pickUpLocation`, `returnLocation`, `status` FROM `reservations` WHERE 1

// Handle car return finalization
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservationID = $_POST['reservationID'];
    $pickUpLocation = $_POST['pickUpLocation'];
    $status = $_POST['status'];

    // Update reservation and car status
    // $updateReservationSql = "UPDATE reservations SET status = :status WHERE reservationID = :reservationID";
    // $updateReservationStmt = $pdo->prepare($updateReservationSql);
    // $updateReservationStmt->execute(['status' => $status, 'reservationID' => $reservationID]);


    $updateCarSql = "UPDATE cars c
                 JOIN reservations r ON c.carID = r.carID
                 SET r.pickUpLocation = :pickUpLocation, c.status = :status
                 WHERE r.reservationID = :reservationID";



    // $updateCarSql = "UPDATE cars SET pickUpLocation = :pickUpLocation, status = :status WHERE carID = (SELECT carID FROM reservations WHERE reservationID = :reservationID)";
    $updateCarStmt = $pdo->prepare($updateCarSql);
    $updateCarStmt->execute(['pickUpLocation' => $pickUpLocation, 'status' => $status, 'reservationID' => $reservationID]);
    echo "<script>alert('empty!');</script>";
    echo "<script>alert('done!');</script>";
    header("Location: car_incuery.php");
    exit();
}
function getAllLocations($pdo) {
    // SELECT `locationID`, `name`, `addressID` FROM `locations` WHERE 1
    $sql = "SELECT locationID, name FROM locations";
    $stmt = $pdo->query($sql);
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $locations;
}
function getLocationName($pdo, $locationID) {
    $sql = "SELECT name FROM locations WHERE locationID = :locationID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['locationID' => $locationID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && isset($result['name'])) {
        return $result['name'];
    } else {
        return 'Location Not Found';
    }
}

// Usage in HTML


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager - Return a Car</title>
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
<
</nav>
<main>
    <div class="container">
        <h1>Manager - Return a Car</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Car Reference Number</th>
                    <th>Car Make</th>
                    <th>Car Type</th>
                    <th>Car Model</th>
                    <th>Pick-Up Date</th>
                    <th>Return Date</th>
                    <th>Return Location</th>
                    <th>Customer Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returningCars as $car): ?>
                    <tr>
                        <td><?php echo ($car['carID']); ?></td>
                        <td><?php echo ($car['carMake']); ?></td>
                        <td><?php echo ($car['carType']); ?></td>
                        <td><?php echo ($car['carModel']); ?></td>
                        <td><?php echo ($car['pickUpDate']); ?></td>
                        <td><?php echo ($car['returnDate']); ?></td>
                       
                        <td><?php echo ($car['returnLocation']) ." -- ". getLocationName($pdo, $car['returnLocation']) ; ?></td>
                        <td><?php echo ($car['customerName']); ?></td>
                        <td>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="reservationID" value="<?php echo ($car['reservationID']); ?>">
                                <input type="hidden" name="carID" value="<?php echo ($car['carID']); ?>">
                                <input type="hidden" name="customerName" value="<?php echo ($car['customerName']); ?>">
                                <input type="hidden" name="carMake" value="<?php echo ($car['carMake']); ?>">
                                <input type="hidden" name="carType" value="<?php echo ($car['carType']); ?>">
                                <input type="hidden" name="carModel" value="<?php echo ($car['carModel']); ?>">
                                <input type="hidden" name="pickUpDate" value="<?php echo ($car['pickUpDate']); ?>">
                                <input type="hidden" name="returnDate" value="<?php echo ($car['returnDate']); ?>">
                                <input type="hidden" name="returnLocation" value="<?php echo ($car['returnLocation']); ?>">
                                
                                <input type="hidden" name="status" value="<?php echo ($car['status']); ?>">

                                
                                        
                                <select name="pickUpLocation" id="location" required>
                                    <?php 
                                            global $pdo;
                                            $locations = getAllLocations($pdo);
                                            foreach ($locations as $location): ?>
                                                <option value="<?php echo $location['locationID']." ".$location['name']; ?>">
                                                <?php echo htmlspecialchars($location['locationID']) ." -- ". $location['name']; ?>
                                                
                                                </option>
                                            <?php endforeach; ?>
                                </select>


                                <select name="status" >
                                    <option value="available" <?php if ($car['status'] == 'available') echo 'selected'; ?>>Available</option>
                                    <option value="damaged" <?php if ($car['status'] == 'damaged') echo 'selected'; ?>>Damaged</option>
                                    <option value="repair" <?php if ($car['status'] == 'repair') echo 'selected'; ?>>In Repair</option>
                                </select>
                                <button type="submit" >Finalize Return</button>
                            </form>
                        </td>
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