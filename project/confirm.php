<?php
session_start();
try {
    //code...

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if session variables are set
    if (
        isset($_SESSION["name"], $_SESSION["dob"], $_SESSION["id_number"], $_SESSION["email"],
            $_SESSION["telephone"], $_SESSION["flat_house"], $_SESSION["street"], $_SESSION["city"],
            $_SESSION["country"], $_SESSION["cc_number"], $_SESSION["cc_expiry"], $_SESSION["cc_name"],
            $_SESSION["cc_bank"], $_SESSION["username"], $_SESSION["password"])
    ) {

        try {
            // Include database connection
            require_once 'connection.php';
            $pdo = db_connect();
            
            // Start a transaction
            $pdo->beginTransaction();

            // Insert address data into the 'addresses' table
            $sql_address = "INSERT INTO addresses (flat, street, city, country) VALUES (?, ?, ?, ?)";
            $stmt_address = $pdo->prepare($sql_address);
            $stmt_address->execute([$_SESSION["flat_house"], $_SESSION["street"], $_SESSION["city"], $_SESSION["country"]]);
            $addressID = $pdo->lastInsertId();
            echo "addressID ID: $addressID<br>";
            // Insert credit card data into the 'credit_cards' table
            $sql_credit_card = "INSERT INTO credit_cards (cardNumber, expirationDate, cardholderName, issuingBank) VALUES (?, ?, ?, ?)";
            $stmt_credit_card = $pdo->prepare($sql_credit_card);
            $stmt_credit_card->execute([$_SESSION["cc_number"], $_SESSION["cc_expiry"], $_SESSION["cc_name"], $_SESSION["cc_bank"]]);
            $cardID = $pdo->lastInsertId();

            // Insert data into the 'users' table
            echo "cardID ID: $addressID<br>";

            // INSERT INTO `users`(`userID`, `name`, `addressID`, `dateOfBirth`, `IDNumber`, `email`, `password`, `username`, `phone`, `cardID`, `role`) 
            // VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')

            $hashed_password = password_hash($_SESSION["password"], PASSWORD_DEFAULT); // Hash the password

            $sql_user = "INSERT INTO users (name, addressID, dateOfBirth, username, password, IDNumber, email, phone, cardID, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_user = $pdo->prepare($sql_user);
            $stmt_user->execute([$_SESSION["name"], $addressID, $_SESSION["dob"], $_SESSION["username"], $hashed_password, $_SESSION["id_number"], $_SESSION["email"], $_SESSION["telephone"], $cardID, "customer"]);

            // Get the ID of the inserted user
            $user_id = $pdo->lastInsertId();

            // Commit the transaction
            $pdo->commit();
            echo "<script>alert('Registration Successful!');</script>";
            echo "Registration Successful!<br>";
            echo "Customer ID: $user_id<br>";
            echo "Confirmation message sent to your email.<br>";
            
           
            // Destroy the session (logout)
            session_destroy();
           echo "<p><a href=\"./project1/login.html\">login</a></p>";
            // header("Location: login.html");
            exit();
        } catch (PDOException $e) {
            // Rollback the transaction on error
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "Error: " . $e->getMessage();
            // Log the error to a file or database
            error_log("Error in registration process: " . $e->getMessage(), 0);
            header("Location: step1.html");
            exit();
        }
    } else {
echo " empty : ";

echo "<script>alert('empty!');</script>";
        header("Location: step1.html");
        // exit();
    }
} else {
    error_log("Error in registration process empty: " . $e->getMessage(), 0);
    // header("Location: step1.html");
    // exit();
}
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
