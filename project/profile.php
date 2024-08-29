<!-- profile.php -->
<?php
session_start();
include 'connection.php';
// $_SESSION['userID']=2;
try {
    //code...

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

$userID = $_SESSION['userID'];

// Retrieve user data from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve address data for the user
$stmt = $pdo->prepare("SELECT * FROM addresses WHERE addressID = :addressID");
$stmt->bindParam(':addressID', $user['addressID'], PDO::PARAM_INT);
$stmt->execute();
$address = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve credit card data for the user
$stmt = $pdo->prepare("SELECT * FROM credit_cards WHERE cardID = :cardID");
$stmt->bindParam(':cardID', $user['cardID'], PDO::PARAM_INT);
$stmt->execute();
$creditCard = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user data in the database
    $stmt = $pdo->prepare("UPDATE users SET name = :name, dateOfBirth = :dateOfBirth, 
        IDNumber = :IDNumber, email = :email, phone = :phone WHERE userID = :userID");
    $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindParam(':dateOfBirth', $_POST['dateOfBirth'], PDO::PARAM_STR);
    $stmt->bindParam(':IDNumber', $_POST['IDNumber'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Update address data in the database
    $stmt = $pdo->prepare("UPDATE addresses SET flat = :flat, street = :street, city = :city, 
        country = :country WHERE addressID = :addressID");
    $stmt->bindParam(':flat', $_POST['flat'], PDO::PARAM_STR);
    $stmt->bindParam(':street', $_POST['street'], PDO::PARAM_STR);
    $stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
    $stmt->bindParam(':country', $_POST['country'], PDO::PARAM_STR);
    $stmt->bindParam(':addressID', $user['addressID'], PDO::PARAM_INT);
    $stmt->execute();

    // Update credit card data in the database
    $stmt = $pdo->prepare("UPDATE credit_cards SET cardNumber = :cardNumber, expirationDate = :expirationDate, 
        cardholderName = :cardholderName, issuingBank = :issuingBank WHERE cardID = :cardID");
    $stmt->bindParam(':cardNumber', $_POST['cardNumber'], PDO::PARAM_STR);
    $stmt->bindParam(':expirationDate', $_POST['expirationDate'], PDO::PARAM_STR);
    $stmt->bindParam(':cardholderName', $_POST['cardholderName'], PDO::PARAM_STR);
    $stmt->bindParam(':issuingBank', $_POST['issuingBank'], PDO::PARAM_STR);
    $stmt->bindParam(':cardID', $user['cardID'], PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the profile page with a success message
    header("Location: profile.php?updated=1");
    exit();
}

} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<header>
<?php
    require_once 'file.php';
    session_start();
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
        
        <?php if (isset($_GET['updated'])) : ?>
            <div class="success-message">Profile updated successfully!</div>
        <?php endif; ?>
        <fieldset>
        <legend><h2>User Profile</h2></legend>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br><br>

    <label for="dateOfBirth">Date of Birth:</label>
    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $user['dateOfBirth']; ?>" required><br><br>

    <label for="IDNumber">ID Number:</label>
    <input type="text" id="IDNumber" name="IDNumber" value="<?php echo $user['IDNumber']; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required><br><br>

    <label for="flat">Flat/House No:</label>
    <input type="text" id="flat" name="flat" value="<?php echo $address['flat']; ?>" required><br><br>

    <label for="street">Street:</label>
    <input type="text" id="street" name="street" value="<?php echo $address['street']; ?>" required><br><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $address['city']; ?>" required><br><br>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country" value="<?php echo $address['country']; ?>" required><br><br>

    <label for="cardNumber">Card Number:</label>
    <input type="text" id="cardNumber" name="cardNumber" value="<?php echo $creditCard['cardNumber']; ?>" required><br><br>

    <label for="expirationDate">Expiration Date:</label>
    <input type="text" id="expirationDate" name="expirationDate" value="<?php echo $creditCard['expirationDate']; ?>" required><br><br>

    <label for="cardholderName">Cardholder Name:</label>
    <input type="text" id="cardholderName" name="cardholderName" value="<?php echo $creditCard['cardholderName']; ?>" required><br><br>

    <label for="issuingBank">Issuing Bank:</label>
    <input type="text" id="issuingBank" name="issuingBank" value="<?php echo $creditCard['issuingBank']; ?>" required><br><br>

    <button type="submit">Update Profile</button>
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