<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Display dashboard content for logged-in users
$username = $_SESSION['username'];
$role = $_SESSION['role'];

include 'maintenance.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add new maintenance schedule
        $vehicleId = $_POST['vehicleId'];
        $maintenanceType = $_POST['maintenanceType'];
        $scheduledDate = $_POST['scheduledDate'];
        $completedDate = $_POST['completedDate'];
        $description = $_POST['description'];
        addMaintenanceSchedule($vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description);
    } elseif (isset($_POST['update'])) {
        // Update maintenance schedule
        $maintenanceId = $_POST['maintenanceId'];
        $vehicleId = $_POST['vehicleId'];
        $maintenanceType = $_POST['maintenanceType'];
        $scheduledDate = $_POST['scheduledDate'];
        $completedDate = $_POST['completedDate'];
        $description = $_POST['description'];
        updateMaintenanceSchedule($maintenanceId, $vehicleId, $maintenanceType, $scheduledDate, $completedDate, $description);
    } elseif (isset($_POST['delete'])) {
        // Delete maintenance schedule
        $maintenanceId = $_POST['maintenanceId'];
        deleteMaintenanceSchedule($maintenanceId);
    }
}

// Fetch maintenance schedules
$maintenanceSchedules = getMaintenanceSchedules();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Maintenance Schedules</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Maintenance Schedules</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Form for adding/updating maintenance schedules -->
    <form method="post" class="form-wrapper">
        <input type="hidden" name="maintenanceId" value="">
        Vehicle ID: <input type="number" name="vehicleId" required><br>
        Maintenance Type: <input type="text" name="maintenanceType" required><br>
        Scheduled Date: <input type="date" name="scheduledDate" required><br>
        Completed Date: <input type="date" name="completedDate"><br>
        Description: <textarea name="description" rows="4" cols="50"></textarea><br>
        <input type="submit" name="add" value="Add Maintenance Schedule">
        <!-- <input type="submit" name="update" value="Update Maintenance Schedule"> -->
    </form>

    <!-- Display existing maintenance schedules -->
    <h2>Existing Maintenance Schedules</h2>
    </center><table border="1">
        <tr>
            <th>Maintenance ID</th>
            <th>Vehicle ID</th>
            <th>Maintenance Type</th>
            <th>Scheduled Date</th>
            <th>Completed Date</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($maintenanceSchedules as $maintenance) { ?>
            <tr>
                <td><?php echo $maintenance['MaintenanceID']; ?></td>
                <td><?php echo $maintenance['VehicleID']; ?></td>
                <td><?php echo $maintenance['MaintenanceType']; ?></td>
                <td><?php echo $maintenance['ScheduledDate']; ?></td>
                <td><?php echo $maintenance['CompletedDate']; ?></td>
                <td><?php echo $maintenance['Description']; ?></td>
                <td><?php echo $maintenance['Status']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="maintenanceId" value="<?php echo $maintenance['MaintenanceID']; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>
</body>
</html>
