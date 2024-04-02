<?php
include 'conn.php';

// Function to fetch deliveries from the database
function getDeliveries() {
    global $conn;
    $sql = "SELECT * FROM Deliveries";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new delivery
function addDelivery($customerId, $routeId, $vehicleId, $driverId, $deliveryDate) {
    global $conn;
    $sql = "INSERT INTO Deliveries (CustomerID, RouteID, VehicleID, DriverID, DeliveryDate, Status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiis", $customerId, $routeId, $vehicleId, $driverId, $deliveryDate);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to update an existing delivery
function updateDelivery($deliveryId, $customerId, $routeId, $vehicleId, $driverId, $deliveryDate) {
    global $conn;
    $sql = "UPDATE Deliveries SET CustomerID = ?, RouteID = ?, VehicleID = ?, DriverID = ?, DeliveryDate = ? WHERE DeliveryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisi", $customerId, $routeId, $vehicleId, $driverId, $deliveryDate, $deliveryId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to delete a delivery
function deleteDelivery($deliveryId) {
    global $conn;
    $sql = "DELETE FROM Deliveries WHERE DeliveryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deliveryId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}
?>
