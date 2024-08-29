<?php

    // Retrieve other session data
    session_start();
    $name = $_SESSION["name"];
    $dob = $_SESSION["dob"];
    $id_number = $_SESSION["id_number"];
    $email = $_SESSION["email"];
    $telephone = $_SESSION["telephone"];
    $flat_house = $_SESSION["flat_house"];
    $street = $_SESSION["street"];
    $city = $_SESSION["city"];
    $country = $_SESSION["country"];
    $cc_number = $_SESSION["cc_number"];
    $cc_expiry = $_SESSION["cc_expiry"];
    $cc_name = $_SESSION["cc_name"];
    $cc_bank = $_SESSION["cc_bank"];

    try {
      
        $pdo->beginTransaction();

        // INSERT INTO `addresses`(`addressID`, `flat`, `street`, `city`, `country`) 
        // VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

          // Insert address data into the 'addresses' table
          $sql_address = "INSERT INTO addresses ( flat, street, city, country) 
          VALUES ( ?, ?, ?, ?)";
          
            $stmt_address = $pdo->prepare($sql_address);
            $stmt_address->execute( $flat_house, $street, $city, $country);
            $addressID = $pdo->lastInsertId();
            // INSERT INTO `credit_cards`(`cardID`, `cardNumber`, `expirationDate`, `cardholderName`, `issuingBank`) 
            // VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')


            
        $sql_credit_card = "INSERT INTO credit_cards ( cardNumber, expirationDate, cardholderName, issuingBank) 
                        VALUES ( ?, ?, ?, ?)";
        $stmt_credit_card = $pdo->prepare($sql_credit_card);

        $stmt_credit_card->execute( $cc_number, $cc_expiry, $cc_name, $cc_bank);
        $cardID = $pdo->lastInsertId();



        // INSERT INTO `users`(`userID`, `name`, `addressID`, `dateOfBirth`, `IDNumber`, `email`, `password`, `username`, `phone`, `cardID`, `role`) 
        // VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]')
        
        // Insert data into the 'users' table
        $sql_user = "INSERT INTO users (name, addressID ,dob , username, password, id_number, email, telephone,cardID , role) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ? , ? , ?)";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->execute([$name, $addressID , $dob, $username   , $hashed_password, $id_number, $email, $telephone, $cardID,"customer"]);
        $user_id = $pdo->lastInsertId();

    
        $pdo->commit();

        echo "Registration Successful!<br>";
        echo "Customer ID: $user_id<br>";
        echo "Confirmation message sent to your email.<br>";

        
        session_destroy();
        header("Location: login.php");
    } catch (PDOException $e) {
       
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
        header("Location: registration.php");
    }
?>