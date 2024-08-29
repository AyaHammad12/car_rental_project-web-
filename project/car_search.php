<!-- //project/car_search.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Search</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
<?php session_start(); ?>
<header>
<?php
 require_once 'connection.php';
 require_once 'Car.php';
 $pdo = db_connect();
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
        <legend><h2>Car Search</h2></legend>
        <form id="carSearchForm" method="get" action="car_search.php">
            <label for="startDate">Renting From:</label>
            <input type="date" id="startDate" name="startDate" min="<?php echo date('Y-m-d'); ?>">

            <label for="endDate">Renting To:</label>
            <input type="date" id="endDate" name="endDate" min="<?php echo date('Y-m-d', strtotime('+1 days')); ?>">

            <label for="carType">Car Type:</label>
            <select id="carType" name="carType">
                <option value="">Select a Car Type</option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Van">Van</option>
            </select>

            <label for="pickupLocation">Pick-up Location:</label>
            <select id="pickupLocation" name="pickupLocation">
                <option value="">Select a location</option>
                <option value="Birzeit">Birzeit</option>
                <option value="Ramallah">Ramallah</option>
                <option value="Jerusalem">Jerusalem</option>
            </select><br><br>

            <label for="minPrice">Minimum Price:</label>
            <input type="number" id="minPrice" name="minPrice" min=200 max=1000 step="0.01" placeholder="200">

            <label for="maxPrice">Maximum Price:</label>
            <input type="number" id="maxPrice" name="maxPrice" min=200 max=1000 step="0.01" placeholder="1000">

            <button type="submit" name="search">Search</button><br><br><br>
            <!-- <button type="submit" name="shortlist">Shortlist</button> -->

            <div id="carSearchResults">
                <table id="carTable" border="1">
                    <thead>
                        <tr>
                            <!-- <th>Select</th> -->
                            <th>
                            <button type="submit" name="shortlist">Shortlist</button></th>
                            <th><a href="?sortColumn=pricePerDay&sortOrder=<?php echo getSortOrder('pricePerDay'); ?>">Price per Day</a></th>
                            <th><a href="?sortColumn=carType&sortOrder=<?php echo getSortOrder('carType'); ?>">Car Type</a></th>
                            <th><a href="?sortColumn=fuelType&sortOrder=<?php echo getSortOrder('fuelType'); ?>">Fuel Type</a></th>
                            <th>Car Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        function getSortOrder($column) {
                            if (isset($_COOKIE['sortColumn']) && $_COOKIE['sortColumn'] == $column) {
                                return (isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder'] == 'asc') ? 'desc' : 'asc';
                            }
                            return 'asc';
                        }

                        // if ($_SERVER["REQUEST_METHOD"] == "GET") {
                           

                            if (isset($_GET['shortlist']) && !empty($_GET['carCheckbox'])) {
                                // Display shortlisted cars
                                $shortlistedCars = $_GET['carCheckbox'];
                                $placeholders = rtrim(str_repeat('?,', count($shortlistedCars)), ',');
                                $sql = "SELECT * FROM cars WHERE status LIKE '%available%' AND  carID IN ($placeholders)";
                                $stmt = $pdo->prepare($sql);
                                foreach ($shortlistedCars as $index => $carID) {
                                    $stmt->bindValue($index + 1, $carID);
                                }
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } else {
                                // Default values if no search parameters are provided
                                $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date('Y-m-d');
                                $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date('Y-m-d', strtotime('+3 days'));
                                $carType = isset($_GET['carType']) ? $_GET['carType'] : '';
                                $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : 0;
                                $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 0;
                                $pickupLocation= isset($_GET['pickupLocation']) ? $_GET['pickupLocation'] : 0;

                                
                                // Initialize the SQL query with necessary joins and conditions
                                $sql = "SELECT c.*, COUNT(r.reservationID) AS reservations
                                        FROM cars c
                                        LEFT JOIN reservations r ON c.carID = r.carID
                                        WHERE c.status LIKE '%available%' "; // Start with 1 = 1 for easy conditional appending

                                $params = []; // Initialize empty array for parameters

                                // Conditionally append WHERE clauses based on search parameters
                                if (!empty($carType)) {
                                    $sql .= " AND c.carType = ?";
                                    $params[] = $carType;
                                }

                                if ($minPrice > 0 && $maxPrice == 0) {
                                    $maxPrice = 1000;
                                    $sql .= " AND c.pricePerDay BETWEEN ? AND ?";
                                    $params[] = $minPrice;
                                    $params[] = $maxPrice;
                                } else if ($minPrice == 0 && $maxPrice > 0) {
                                    $minPrice = 200;
                                    $sql .= " AND c.pricePerDay BETWEEN ? AND ?";
                                    $params[] = $minPrice;
                                    $params[] = $maxPrice;
                                } else if ($minPrice > 0 && $maxPrice > 0) {
                                    $sql .= " AND c.pricePerDay BETWEEN ? AND ?";
                                    $params[] = $minPrice;
                                    $params[] = $maxPrice;
                                }

                                if (!empty($pickupLocation)) {
                                    $sql .= " AND c.pickUpLocation = ?";
                                    $params[] = $pickupLocation;
                                }
                                // Adjust the availability check based on provided or default dates
                                if (!empty($_GET['startDate']) && !empty($_GET['endDate'])) {
                                    $sql .= " AND (r.startDate IS NULL OR r.endDate < ? OR r.startDate > ?)";
                                    $params[] = $startDate;
                                    $params[] = $endDate;
                                } else if (empty($_GET['carType']) && empty($_GET['carType']) && empty($_GET['minPrice']) && empty($_GET['maxPrice'])) {
                                    $sql .= " AND (r.startDate IS NULL OR r.endDate < ? OR r.startDate > DATE_ADD(CURDATE(), INTERVAL 3 DAY))";
                                    $params[] = $startDate;
                                }

                                // Get sorting parameters from URL or cookies
                                $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : (isset($_COOKIE['sortColumn']) ? $_COOKIE['sortColumn'] : 'pricePerDay');
                                $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : (isset($_COOKIE['sortOrder']) ? $_COOKIE['sortOrder'] : 'asc');

                                // Complete the SQL query with GROUP BY, HAVING, and ORDER BY clauses
                                $sql .= " GROUP BY c.carID HAVING reservations = 0 ORDER BY $sortColumn $sortOrder";

                                // Set cookies for sorting preferences
                                setcookie('sortColumn', $sortColumn, time() + (86400 * 30), "/");
                                setcookie('sortOrder', $sortOrder, time() + (86400 * 30), "/");

                                // Prepare and execute the SQL statement
                                $stmt = $pdo->prepare($sql);
                                foreach ($params as $index => $param) {
                                    $stmt->bindValue($index + 1, $param);
                                }
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            }

                            // Display search results in a table
                            if (count($result) > 0) {
                                foreach ($result as $row) {
                                    $car = new Car($row);
                                
                                    global $startDate;
                                    global $endDate;
                                    // $car->startDate= $startDate;
                                    // $car->endDate= $endDate;
                                    $car->setStartDate($startDate);
                                    $car->setEndDate($endDate);
                               
                                    // echo  $car->getStartDate();
                                    // echo  $car->getEndDate();
                                    // echo "<br>";

                                    echo $car->displayInTableSearch();
                                }
                            } else {
                                echo "<tr><td colspan='6'>No cars found matching your criteria.</td></tr>";
                            }
                        // }
                    ?>
                    </tbody>
                </table>
            </div>
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