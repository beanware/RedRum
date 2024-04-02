<?php
include 'conn.php';

// Function to fetch drivers from the database
function getDrivers() {
    global $conn;
    $sql = "SELECT * FROM Drivers";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new driver
function addDriver($name, $licenseNumber, $contactInformation, $experienceLevel) {
    global $conn;
    $sql = "INSERT INTO Drivers (Name, LicenseNumber, ContactInformation, ExperienceLevel, Status) VALUES (?, ?, ?, ?, 'Active')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $licenseNumber, $contactInformation, $experienceLevel);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to update an existing driver
function updateDriver($driverId, $name, $licenseNumber, $contactInformation, $experienceLevel) {
    global $conn;
    $sql = "UPDATE Drivers SET Name = ?, LicenseNumber = ?, ContactInformation = ?, ExperienceLevel = ? WHERE DriverID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $licenseNumber, $contactInformation, $experienceLevel, $driverId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to delete a driver
function deleteDriver($driverId) {
    global $conn;
    $sql = "DELETE FROM Drivers WHERE DriverID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driverId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}
?>
