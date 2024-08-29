<?php
session_start();

if (!isset($_SESSION['payment'])) {
    header('Location: rent.php');
    exit;
}

// $rental = $_SESSION['rental'];
// $payment = $_SESSION['payment'];
// $customer_id = $_SESSION['customer_id'];

// Generate a 10-digit invoice ID
// $invoice_id = generateInvoiceID();

// Update the database with the rental details
// processRental($customer_id, $rental, $payment, $invoice_id);

// Clear the session data
// session_unset();



function processRental($customer_id, $rental, $payment, $invoice_id) {
    global $pdo;
    try {
        $pdo->beginTransaction();

        // INSERT INTO `reservations`(`reservationID`, `carID`, `userID`, `startDate`, `endDate`, `totalPrice`, `pickUpDate`, `returnDate`, `pickUpLocation`, `returnLocation`, `status`)
        //  VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
        // $stmt = $pdo->prepare('INSERT INTO reservations (userID, carID, startDate, endDate, pickUpLocation, returnLocation, extras, total_rent) VALUES (?, ?,  ?, ?, ?, ?, ?, ?)');
        // $stmt->execute([
        //     $customer_id,
        //     $rental['car_id'],
        //     $rental['start_date'],
        //     $rental['end_date'],
        //     $rental['pickup_location'],
        //     $rental['return_location'],
        //     implode(',', $rental['extras']),
        //     $rental['total_rent'],
            
        // ]);

        // Update car status to rented
        $stmt = $pdo->prepare('UPDATE cars SET status = "rented" WHERE carID = ?');
        $stmt->execute([$rental['car_id']]);

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rent a Car - Confirmation</title>
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
<legend><h2>Customer Registration - Step 1</h2></legend>
<form>
    <h1>Confirmation</h1>
    <p>Thank you for renting with us!</p>
    <p>Your car has been successfully rented.</p>
    <p>Invoice ID: <?= htmlspecialchars($invoice_id) ?></p>
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
