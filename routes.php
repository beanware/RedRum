<?php
include 'conn.php';

// Function to fetch routes from the database
function getRoutes() {
    global $conn;
    $sql = "SELECT * FROM Routes";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new route
function addRoute($origin, $destination, $distance, $estimatedTime, $fuelCost) {
    global $conn;
    $sql = "INSERT INTO Routes (Origin, Destination, Distance, EstimatedTime, FuelCost) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsd", $origin, $destination, $distance, $estimatedTime, $fuelCost);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to update an existing route
function updateRoute($routeId, $origin, $destination, $distance, $estimatedTime, $fuelCost) {
    global $conn;
    $sql = "UPDATE Routes SET Origin = ?, Destination = ?, Distance = ?, EstimatedTime = ?, FuelCost = ? WHERE RouteID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsdi", $origin, $destination, $distance, $estimatedTime, $fuelCost, $routeId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to delete a route
function deleteRoute($routeId) {
    global $conn;
    $sql = "DELETE FROM Routes WHERE RouteID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $routeId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}
?>
