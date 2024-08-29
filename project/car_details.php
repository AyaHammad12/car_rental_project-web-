<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="styles.css">
    <!-- <style>
        /* General body styling */
/* General body styling */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.car-details-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
}


.car-photos {
    flex: 0 0 40%;
    max-width: 40%;
    margin-right: 20px;
    overflow: hidden;
}

.car-photos img {
    width: 100%;
    height: auto;
    max-height: 300px;
    object-fit: cover;
}

.car-description {
    flex: 1; /* Take remaining space */
    max-width: 60%; /* Adjust as needed */
}

/* Add margin between photos and description */
.car-photos,
.car-description {
    margin-bottom: 20px;
}




.car-details ul {
    list-style-type: none;
    padding: 0;
}

.car-details ul li {
    margin-bottom: 10px;
}

/* Example styles for the Rent-a-Car button */
.rent-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #1d6d2f;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.rent-button:hover {
    background-color: #218838;
}


    </style> -->
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

</nav>
<main>
    <?php
    require_once 'connection.php';
    require_once 'Car.php';
    $pdo = db_connect();

    // Fetch car details based on carID
    if (isset($_GET['id'])) {
        $carID = $_GET['id'];
        $startDate = $_GET['startDate'];
          $endDate = $_GET['endDate'];
        $sql = "SELECT * FROM cars WHERE carID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$carID]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($car) {
            // Create Car object
            $carDetails = new Car($car);
        } else {
            echo "<p>Car not found.</p>";
            exit;
        }
    } else {
        echo "<p>No car selected.</p>";
        exit;
    }
    function getNumberOfDays($startDate, $endDate) {
        // Convert the dates to DateTime objects
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);
    
        // Calculate the difference
        $interval = $startDateTime->diff($endDateTime);
    
        // Return the number of days
        return $interval->days;
    }
    
    // Example usage
    
    $numberOfDays = getNumberOfDays($startDate, $endDate);
    
    echo "Number of days between $startDate and $endDate: $numberOfDays";
    
    ?>

    <div class="car-details-container">
        <div class="car-photos">
            <?php 
        //    $images=$carDetails->getCarPhotoURL();
        //    foreach($images as : $image){
        //     echo "<img src="./images/<?php " alt="Car Image" style="max-width: 100%;">";
        //    }
           
           $images = $carDetails->getCarPhotoURL(); 
           
           foreach ($images as $image) {
               echo "<img src='./images/{$image}' alt='Car Image' ><br><br>";
           }
          
           
            ?>
        </div>
        <div class="car-description">
            <ul>
                <li><strong>Car Reference Number:</strong> <?php echo $carDetails->getCarID(); ?></li>
                <li><strong>Car Model:</strong> <?php echo $carDetails->getCarModel(); ?></li>
                <li><strong>Car Type:</strong> <?php echo $carDetails->getCarType(); ?></li>
                <li><strong>Car Make:</strong> <?php echo $carDetails->getCarMake(); ?></li>
                <li><strong>Registration Year:</strong> <?php echo $carDetails->getRegistrationYear(); ?></li>
                <li><strong>Color:</strong> <?php echo $carDetails->getColors(); ?></li>
                <li><strong>Description:</strong> <?php echo $carDetails->getDescription(); ?></li>
                <li><strong>Price per Day:</strong> <?php echo $carDetails->getPricePerDay(); ?></li>

                <li><strong>Capacity of People:</strong> <?php echo $carDetails->getCapacityOfPeople(); ?></li>
                <li><strong>Capacity of Suitcases:</strong> <?php echo $carDetails->getCapacityOfSuitcases(); ?></li>
                <li><strong>Total Price for the Renting Period:</strong> <?php
                
                echo $numberOfDays*$carDetails->getPricePerDay();
                ?></li>

                <li><strong>Fuel Type:</strong> <?php echo$carDetails->getFuelType(); ?></li>
                <li><strong>Average Consumption per 100km:</strong> <?php echo $carDetails->getAverageConsumption(); ?></li>
                <li><strong>Horsepower:</strong> <?php echo $carDetails->getHorsepower(); ?></li>
                <li><strong>Length:</strong> <?php echo $carDetails->getLength(); ?></li>
                <li><strong>Width:</strong> <?php echo $carDetails->getWidth(); ?></li>

                <li><strong>Gear Type:</strong> <?php echo $carDetails->getGearType(); ?></li>
                <li><strong>Conditions or Restrictions:</strong> <?php echo $carDetails->getConditions(); ?></li>
            </ul>
            <a href="rent.php?car_id=<?php echo $carDetails->getCarID(); ?>" class="rent-button">Rent-a-Car</a>
        </div>
        <div class="car-marketing-info">
            welcom --------- : 
            <p>Enjoyable to drive: Yes</p>
            <p>Discount for long period: 10% off for rentals over 7 days</p>
        </div>
    </div>
    </main>
    <footer>

    <?php
    echo getFooter();
    ?>

</footer>
</body>
</html>
