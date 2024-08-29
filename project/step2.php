<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration - Step 2</title>
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
<legend><h2>Customer Registration - Step 2</h2></legend>
    <form action="step2.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required pattern=".{6,13}" title="6 to 13 characters"><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required pattern=".{8,12}" title="8 to 12 characters"><br>
        
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" required pattern=".{8,12}" title="8 to 12 characters"><br>
        
        <input type="submit" value="Next">
    </form>
    </fieldset>
    </main>
<footer>
   
    <?php
    echo getFooter();
    ?>

    
</footer>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $password_confirm = htmlspecialchars($_POST["password_confirm"]);

    // Validate password and confirmation match
    if ($password !== $password_confirm) {
        echo "Passwords do not match!";
        exit();
    }

    // Store data in session variables
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    // Redirect to step 3
    header("Location: step3.php");
    exit();
}
?>
