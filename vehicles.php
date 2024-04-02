<?php
include 'conn.php';

// Function to fetch vehicles from the database
function getVehicles() {
    global $conn;
    $sql = "SELECT * FROM Vehicles";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new vehicle
function addVehicle($vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate) {
    global $conn;
    $sql = "INSERT INTO Vehicles (VehicleType, LicensePlate, Model, Year, Mileage, LastMaintenanceDate, Status) VALUES (?, ?, ?, ?, ?, ?, 'Active')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssids", $vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to update an existing vehicle
function updateVehicle($vehicleId, $vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate) {
    global $conn;
    $sql = "UPDATE Vehicles SET VehicleType = ?, LicensePlate = ?, Model = ?, Year = ?, Mileage = ?, LastMaintenanceDate = ? WHERE VehicleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssidsi", $vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate, $vehicleId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to delete a vehicle
function deleteVehicle($vehicleId) {
    global $conn;
    $sql = "DELETE FROM Vehicles WHERE VehicleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicleId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}
?>
