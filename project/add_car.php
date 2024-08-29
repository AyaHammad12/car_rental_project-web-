
<?php
require_once 'connection.php';
$pdo = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCar"])) {
    // Extract form data
    $carModel = isset($_POST['carModel']) ? $_POST['carModel'] : "";
    $carMake = isset($_POST['carMake']) ? $_POST['carMake'] : "";
    $carType = isset($_POST['carType']) ? $_POST['carType'] : "";
    $registrationYear = isset($_POST['registrationYear']) ? $_POST['registrationYear'] : "";
    $description = isset($_POST['description']) ? $_POST['description'] : "";
    $pricePerDay = isset($_POST['pricePerDay']) ? $_POST['pricePerDay'] : "";
    $capacityPeople = isset($_POST['capacityPeople']) ? $_POST['capacityPeople'] : "";
    $capacitySuitcases = isset($_POST['capacitySuitcases']) ? $_POST['capacitySuitcases'] : "";
    $colors = isset($_POST['colors']) ? $_POST['colors'] : "";
    $fuelType = isset($_POST['fuelType']) ? $_POST['fuelType'] : "";
    $averageConsumption = isset($_POST['averageConsumption']) ? $_POST['averageConsumption'] : "";
    $horsepower = isset($_POST['horsepower']) ? $_POST['horsepower'] : "";
    $length = isset($_POST['length']) ? $_POST['length'] : "";
    $width = isset($_POST['width']) ? $_POST['width'] : "";
    $plateNumber = isset($_POST['plateNumber']) ? $_POST['plateNumber'] : "";
    $conditions = isset($_POST['conditions']) ? $_POST['conditions'] : "";

 
    $stmt = $pdo->prepare("INSERT INTO cars (carModel, carMake, carType, registrationYear, description, pricePerDay, capacityOfPeople, capacityOfSuitcases, colors, fuelType, averageConsumption, horsepower, length, width, plateNumber, conditions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([$carModel, $carMake, $carType, $registrationYear, $description, $pricePerDay, $capacityPeople, $capacitySuitcases, $colors, $fuelType, $averageConsumption, $horsepower, $length, $width, $plateNumber, $conditions])) {
        
        $carID = $pdo->lastInsertId();

       
        $targetDir = "images/";
        $uploadedFiles = [];
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['photos']['name'][$key];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $targetFilePath = $targetDir . "car" . $carID . "img" . ($key + 1) . "." . $fileExtension;
            $name=  "car" . $carID . "img" . ($key + 1) . "." . $fileExtension;

            
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $uploadedFiles[] = $name;
                } else {
                    echo "<script>alert('Failed to upload files.');</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.');</script>";
                exit;
            }
        }

        // Update the database with image URLs
        $carPhotoURL = implode(',', $uploadedFiles);
        $updateStmt = $pdo->prepare("UPDATE cars SET carPhotoURL = ? WHERE carID = ?");
        $updateStmt->execute([$carPhotoURL, $carID]);

        echo "<script>alert('Car added successfully. Car ID: $carID');</script>";
    } else {
        echo "<script>alert('Failed to add car.');</script>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Car</title>
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
    <legend><h2>Add a Car</h2></legend>
    <form method="POST" enctype="multipart/form-data">
        

        <label for="carModel">Car Model:</label>
        <input type="text" id="carModel" name="carModel" required><br><br>

    <label for="carMake">Car Make:</label>
    <select id="carMake" name="carMake" required>
        <option value="BMW">BMW</option>
        <option value="VW">Volkswagen</option>
        <option value="Volvo">Volvo</option>
       
    </select><br><br>

    <label for="carType">Car Type:</label>
    <select id="carType" name="carType" required>
        <option value="Van">Van</option>
        <option value="Min-Van">Min-Van</option>
        <option value="Sedan">Sedan</option>
        <option value="SUV">SUV</option>
       
    </select><br><br>

    <label for="registrationYear">Registration Year:</label>
    <input type="number" id="registrationYear" name="registrationYear" required><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="pricePerDay">Price per Day:</label>
    <input type="number" id="pricePerDay" name="pricePerDay" step="0.01" required><br><br>

    <label for="capacityPeople">Capacity (People):</label>
    <input type="text" id="capacityPeople" name="capacityPeople" required><br><br>

    <label for="capacitySuitcases">Capacity (Suitcases):</label>
    <input type="text" id="capacitySuitcases" name="capacitySuitcases" required><br><br>

    <label for="colors">Colors:</label>
    <input type="text" id="colors" name="colors" required><br><br>

    <label for="fuelType">Fuel Type:</label>
    <select id="fuelType" name="fuelType" required>
        <option value="petrol">Petrol</option>
        <option value="diesel">Diesel</option>
        <option value="electric">Electric</option>
        <option value="hybrid">Hybrid</option>
       
    </select><br><br>

    <label for="averageConsumption">Average Consumption (per 100 km):</label>
    <input type="number" id="averageConsumption" name="averageConsumption" step="0.01" required><br><br>

    <label for="horsepower">Horsepower:</label>
    <input type="number" id="horsepower" name="horsepower" required><br><br>

    <label for="length">Length:</label>
    <input type="number" id="length" name="length" step="0.01" required><br><br>

    <label for="width">Width:</label>
    <input type="number" id="width" name="width" step="0.01" required><br><br>

    <label for="plateNumber">Plate Number:</label>
    <input type="text" id="plateNumber" name="plateNumber" required><br><br>

    <label for="conditions">Conditions/Restrictions:</label>
    <textarea id="conditions" name="conditions"></textarea><br><br>

   

    <label for="photos">Upload Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple accept="image/jpeg, image/png, image/jpg" required><br><br>

    <label for="photos">Upload Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple accept="image/jpeg, image/png, image/jpg" required><br><br>

    <label for="photos">Upload Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple accept="image/jpeg, image/png, image/jpg" required><br><br>

    <!-- <label for="photos">Upload Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple accept="image/jpeg, image/png, image/jpg" ><br><br> -->


    <input type="submit" name="addCar" value="Add Car">
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
