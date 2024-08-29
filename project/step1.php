<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration - Step 1</title>
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
    <form action="step1.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="address">Address:</label><br><br>
        <input type="text" id="flat_house" name="flat_house" placeholder="Flat/House No" required>
        <input type="text" id="street" name="street" placeholder="Street" required><br><br>
        <input type="text" id="city" name="city" placeholder="City" required>
        <input type="text" id="country" name="country" placeholder="Country" required><br><br>
        
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>
        
        <label for="id_number">ID Number:</label>
        <input type="text" id="id_number" name="id_number" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="telephone">Phone:</label>
        <input type="tel" id="telephone" name="telephone" required><br><br>
        
        <label for="cc_number">Credit Card Number:</label>
        <input type="text" id="cc_number" name="cc_number" required><br><br>
        
        <label for="cc_expiry">Expiry Date:</label>
        <input type="date" id="cc_expiry" name="cc_expiry" required><br><br>
        
        <label for="cc_name">Card Holder Name:</label>
        <input type="text" id="cc_name" name="cc_name" required><br><br>
        
        <label for="cc_bank">Bank Issued:</label>
        <input type="text" id="cc_bank" name="cc_bank" required><br><br>
        
        <input type="submit" value="Next">
        </form>
        </fieldset>
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


<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {





    // Sanitize input data
    $name = htmlspecialchars($_POST["name"]);
    $flat_house = htmlspecialchars($_POST["flat_house"]);
    $street = htmlspecialchars($_POST["street"]);
    $city = htmlspecialchars($_POST["city"]);
    $country = htmlspecialchars($_POST["country"]);
    $dob = htmlspecialchars($_POST["dob"]);
    $id_number = htmlspecialchars($_POST["id_number"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $cc_number = htmlspecialchars($_POST["cc_number"]);
    $cc_expiry = htmlspecialchars($_POST["cc_expiry"]);
    $cc_name = htmlspecialchars($_POST["cc_name"]);
    $cc_bank = htmlspecialchars($_POST["cc_bank"]);


  



    




    // Store data in session variables
    $_SESSION["name"] = $name;
    
     $_SESSION["flat_house"]=$flat_house;
   $_SESSION["street"]= $street;
  $_SESSION["city"]= $city;
    $_SESSION["country"]=$country;


    $_SESSION["dob"] = $dob;
    $_SESSION["id_number"] = $id_number;
    $_SESSION["email"] = $email;
    $_SESSION["telephone"] = $telephone;
    $_SESSION["cc_number"] = $cc_number;
    $_SESSION["cc_expiry"] = $cc_expiry;
    $_SESSION["cc_name"] = $cc_name;
    $_SESSION["cc_bank"] = $cc_bank;

    // Redirect to step 2
    header("Location: step2.php");
    exit();
}
?>
