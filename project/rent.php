<?php
session_start();

require_once 'connection.php';
// $_SESSION['user_id'] = $user['userID'];
// $_SESSION['userID']= $user['userID'];
// $_SESSION['username'] = $username;
// $_SESSION['role'] = 'customer';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['customer_id']=$_SESSION['user_id'];
    $_SESSION['redirect_to'] = 'rent.php?car_id=' . $_GET['car_id'];
    header('Location: login.php');
    exit;
}

$car_id = $_GET['car_id'];
$car_details = getCarDetails($car_id); // Assume this function fetches car details from the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SELECT `reservationID`, `carID`, `userID`, `startDate`, 
    // `endDate`, `totalPrice`, `pickUpDate`, `returnDate`, `pickUpLocation`, `returnLocation`, `status` FROM `reservations` WHERE 1

    $_SESSION['rental'] = [
        'car_id' => $car_id,
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'pickup_location' => $_POST['pickup_location'],
        'return_location' => $_POST['return_location'],
        'extras' => $_POST['extras'],
        'total_rent' => calculateTotalRent($car_details, $_POST) // Assume this function calculates total rent
    ];
    header('Location: rent_step2.php');
    exit;
}

function getCarDetails($car_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM cars WHERE carID = ?');
    $stmt->execute([$car_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rent a Car - Step 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Rent a Car</h1>
    <form method="POST">
        <p>Car Model: <?= htmlspecialchars($car_details['carModel']) ?></p>
        <p>Description: <?= htmlspecialchars($car_details['description']) ?></p>
        <label>Pick-up Date and Time:</label>
        <input type="datetime-local" name="start_date" required>
        <label>Return Date and Time:</label>
        <input type="datetime-local" name="end_date" required>
        <label>Pick-up Location:</label>
        <select name="pickup_location" required>
            
        </select>
        <label>Return Location:</label>
        <select name="return_location" required>
            
        </select>
        <label>Extras:</label>
        <input type="checkbox" name="extras[]" value="baby_seat"> Baby Seat
        <input type="checkbox" name="extras[]" value="insurance"> Insurance
       
        <button type="submit">Next</button>
        </form>
</fieldset>
</main>
<footer>
    <!-- Footer content -->
    <?php
    echo getFooter();
    ?>

</footer>
</body>
</html>
