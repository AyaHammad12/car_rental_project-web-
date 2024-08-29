<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['rental'])) {
    header('Location: rent.php');
    exit;
}

$rental = $_SESSION['rental'];
$customer = getCustomerDetails($_SESSION['customer_id']); // Assume this function fetches customer details from the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['payment'] = [
        'credit_card_number' => $_POST['credit_card_number'],
        'expiration_date' => $_POST['expiration_date'],
        'card_holder_name' => $_POST['card_holder_name'],
        'card_type' => $_POST['card_type'],
        'accepted_terms' => $_POST['accepted_terms']
    ];
    header('Location: rent_step3.php');
    exit;
}

function getCustomerDetails($customer_id) {
    global $pdo;
    // $sql = "SELECT * FROM `users` WHERE username = :username AND password = :password";
    // SELECT `userID`, `name`, `addressID`, `dateOfBirth`, `IDNumber`, `email`, `password`, `username`, `phone`, `cardID`, `role` FROM `users` WHERE 1
    $stmt = $pdo->prepare('SELECT * FROM users WHERE userID = ?');
    $stmt->execute([$customer_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rent a Car - Step 2</title>
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

<h1>Rent Invoice</h1>
<p>Customer ID: <?= $customer['customerID'] ?></p>
<p>Name: <?= $customer['name'] ?></p>
<p>Address: <?= $customer['address'] ?></p>
<p>Telephone: <?= $customer['telephone'] ?></p>
<p>Car Model: <?= $rental['carModel'] ?></p>
<p>Pick-up Date and Time: <?= $rental['start_date'] ?></p>
<p>Return Date and Time: <?= $rental['end_date'] ?></p>
<p>Total Rent: <?= $rental['total_rent'] ?></p>


    
    <fieldset>
    <form method="POST">
        <label>Credit Card Number:</label>
        <input type="text" name="credit_card_number" required pattern="\d{9}">
        <label>Expiration Date:</label>
        <input type="month" name="expiration_date" required>
        <label>Card Holder Name:</label>
        <input type="text" name="card_holder_name" required>
        <label>Card Type:</label>
        <input type="radio" name="card_type" value="Visa" required> Visa
        <input type="radio" name="card_type" value="MasterCard" required> MasterCard
        <label>
            <input type="checkbox" name="accepted_terms" value="1" required> I accept the terms and conditions
        </label>
        <input type="text" name="confirmation_name" placeholder="Your Name" required>
        <input type="date" name="confirmation_date" required>
        <button type="submit">Confirm Rent</button>
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