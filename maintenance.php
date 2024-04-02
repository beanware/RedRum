<?php
include 'conn.php';

// Function to fetch maintenance schedules from the database
function getMaintenanceSchedules() {
    global $conn;
    $sql = "SELECT * FROM MaintenanceSchedule";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new maintenance schedule
function addMaintenanceSchedule($vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description) {
    global $conn;
    $sql = "INSERT INTO MaintenanceSchedule (VehicleID, MaintenanceType, ScheduledDate, CompletedDate, Description, Status) VALUES (?, ?, ?, ?, ?, 'Scheduled')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to update an existing maintenance schedule
function updateMaintenanceSchedule($maintenanceId, $vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description) {
    global $conn;
    $sql = "UPDATE MaintenanceSchedule SET VehicleID = ?, MaintenanceType = ?, ScheduledDate = ?, CompletedDate = ?, Description = ? WHERE MaintenanceID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description, $maintenanceId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}

// Function to delete a maintenance schedule
function deleteMaintenanceSchedule($maintenanceId) {
    global $conn;
    $sql = "DELETE FROM MaintenanceSchedule WHERE MaintenanceID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $maintenanceId);
    if ($stmt->execute() === false) {
        return false; // Return false if the execution fails
    }
    return true; // Return true if successful
}
?>
