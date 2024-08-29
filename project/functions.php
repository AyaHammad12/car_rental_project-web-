<?php
require_once 'connection.php';

function getCarDetails($car_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM cars WHERE carID = ?');
    $stmt->execute([$car_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCustomerDetails($customer_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE customerID = ?');
    $stmt->execute([$customer_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function calculateTotalRent($car_details, $rental_details) {
    $base_rent = $car_details['price_per_day'];
    $days = (strtotime($rental_details['end_date']) - strtotime($rental_details['start_date'])) / (60 * 60 * 24);
    $extras_cost = 0;
    if (in_array('baby_seat', $rental_details['extras'])) {
        $extras_cost += 50; // Example cost
    }
    if (in_array('insurance', $rental_details['extras'])) {
        $extras_cost += 100; // Example cost
    }
    return $base_rent * $days + $extras_cost;
}
?>
