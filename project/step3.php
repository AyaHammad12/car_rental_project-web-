<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration - Step 3</title>
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
    
    <?php
    session_start();

    // <label for="address">Address:</label><br>
    // <input type="text" id="flat_house" name="flat_house" placeholder="Flat/House No" required>
    // <input type="text" id="street" name="street" placeholder="Street" required><br>
    // <input type="text" id="city" name="city" placeholder="City" required>
    // <input type="text" id="country" name="country" placeholder="Country" required><br>
    ?>
    <fieldset>
    <legend><h2>Confirm Your Details</h2></legend>
    <form action="confirm.php" method="POST">
        <p>Name: <?php echo htmlspecialchars($_SESSION["name"]); ?></p>
        
        

        <p>flat_house: <?php echo htmlspecialchars($_SESSION["flat_house"]); ?></p>
        
        <p>street: <?php echo htmlspecialchars($_SESSION["street"]); ?></p>
        
        <p>city: <?php echo htmlspecialchars($_SESSION["city"]); ?></p>

        <p>country: <?php echo htmlspecialchars($_SESSION["country"]); ?></p>
        

        <p>Date of Birth: <?php echo htmlspecialchars($_SESSION["dob"]); ?></p>
        <p>ID Number: <?php echo htmlspecialchars($_SESSION["id_number"]); ?></p>
        <p>Email: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
        <p>Telephone: <?php echo htmlspecialchars($_SESSION["telephone"]); ?></p>
        <p>Credit Card Number: <?php echo htmlspecialchars($_SESSION["cc_number"]); ?></p>
        <p>Credit Card Expiry: <?php echo htmlspecialchars($_SESSION["cc_expiry"]); ?></p>
        <p>Card Holder Name: <?php echo htmlspecialchars($_SESSION["cc_name"]); ?></p>
        <p>Bank Issued: <?php echo htmlspecialchars($_SESSION["cc_bank"]); ?></p>
        <p>Username: <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
        
        <input type="submit" value="Confirm">
    </form>
    </fieldset>
<    </main>
<footer>
    <!-- Footer content -->
    <?php
    echo getFooter();
    ?>

    <!-- Smaller Logo | &copy; Your Company Name | Address | Email | Phone | <a href="contact.php">Contact Us</a> -->
</footer>
</body>
</html>
