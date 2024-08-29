

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Account Creation</title>
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
    
    <fieldset>
    <legend><h2>E-Account Creation</h2></legend>
    <form action="e_account.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" minlength="6" maxlength="13" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" minlength="8" maxlength="12" required><br>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        
        <input type="submit" value="Create E-Account">
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


if (!isset($_SESSION["name"])) {
    header("Location: registration.php");
    
}


include_once "connection.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  



    $username = isset($_POST["username"]) ? ($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";


    
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $_SESSION["username"] = $username;
    $_SESSION["hashed_password"] = $hashed_password;
    header("Location: addUser.php");

} else {
    
    header("Location: registration.php");
   
}
?>


