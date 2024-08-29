
<?php
session_start();
// $_SESSION['user_id'] = 2; // For testing purposes; ensure this is set upon login


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php'; 

$user_id = $_SESSION['user_id'];


$sql = "SELECT r.reservationID, c.carID, c.carMake, c.carType, c.carModel, r.pickUpDate, r.returnDate, r.returnLocation 
        FROM reservations r 
        JOIN cars c ON r.carID = c.carID 
        WHERE r.userID = :user_id AND r.status = 'current'
        ORDER BY r.pickUpDate ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$activeRents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle return initiation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservationID = $_POST['reservationID'];
    $returnLocation = $_POST['returnLocation'];

    $updateSql = "UPDATE reservations SET status = 'returning', returnLocation = :returnLocation WHERE reservationID = :reservationID";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute(['returnLocation' => $returnLocation, 'reservationID' => $reservationID]);

    header("Location: customer_return_car.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return a Car</title>
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
        <h1>Return a Car</h1>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeRents as $rent): ?>
                    <tr>
                        <td><?php echo ($rent['carID']); ?></td>
                        <td><?php echo ($rent['carMake']); ?></td>
                        <td><?php echo ($rent['carType']); ?></td>
                        <td><?php echo ($rent['carModel']); ?></td>
                        <td><?php echo ($rent['pickUpDate']); ?></td>
                        <td><?php echo ($rent['returnDate']); ?></td>
                        <td><?php echo ($rent['returnLocation']); ?></td>
                        <td>
                            
                            <form method="POST" action="<?php echo ($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="reservationID" value="<?php echo ($rent['reservationID']); ?>">
                                <input type="text" name="returnLocation" value="<?php echo ($rent['returnLocation']); ?>" required>
                                <button type="submit">Return</button>
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

    <!-- Smaller Logo | &copy; Your Company Name | Address | Email | Phone | <a href="contact.php">Contact Us</a> -->
</footer>
</body>
</html>
