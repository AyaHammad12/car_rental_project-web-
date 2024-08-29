<?php
// Start the session
session_start();

// Include database connection
require_once 'connection.php';
try{
// Mock user authentication for demonstration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database check for user credentials here
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query securely
    $sql = "SELECT * FROM `users` WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $user['role'] == 'customer'){
            $_SESSION['user_id'] = $user['userID'];
             $_SESSION['userID']= $user['userID'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'customer';
            
            header('Location: car_search.php');
            exit();
        }elseif ( $user['role'] == 'maneger'){
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['userID']= $user['userID'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'maneger';
            // header("Location: car_incuery.php");
            header("Location: car_search.php");
            exit();
        }
        

       
    } else {
        $error = "Invalid username or password";
    }
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
    <title>Login</title>
   
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
        
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <fieldset>
        <legend><h2>Login</h2></legend>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        </fieldset>
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


