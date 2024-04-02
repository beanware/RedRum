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

include 'vehicles.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add new vehicle
        $vehicleType = $_POST['vehicleType'];
        $licensePlate = $_POST['licensePlate'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $mileage = $_POST['mileage'];
        $lastMaintenanceDate = $_POST['lastMaintenanceDate'];
        addVehicle($vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate);
    } elseif (isset($_POST['update'])) {
        // Update vehicle
        $vehicleId = $_POST['vehicleId'];
        $vehicleType = $_POST['vehicleType'];
        $licensePlate = $_POST['licensePlate'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $mileage = $_POST['mileage'];
        $lastMaintenanceDate = $_POST['lastMaintenanceDate'];
        updateVehicle($vehicleId, $vehicleType, $licensePlate, $model, $year, $mileage, $lastMaintenanceDate);
    } elseif (isset($_POST['delete'])) {
        // Delete vehicle
        $vehicleId = $_POST['vehicleId'];
        deleteVehicle($vehicleId);
    }
}

// Fetch vehicles
$vehicles = getVehicles();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Vehicles</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Vehicles</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Form for adding/updating vehicles -->
    <form method="post" class="form-wrapper">
        <input type="hidden" name="vehicleId" value="">
        Vehicle Type: <input type="text" name="vehicleType" required><br>
        License Plate: <input type="text" name="licensePlate" required><br>
        Model: <input type="text" name="model" required><br>
        Year: <input type="number" name="year" required><br>
        Mileage: <input type="number" name="mileage" step="0.01" required><br>
        Last Maintenance Date: <input type="date" name="lastMaintenanceDate"><br>
        <input type="submit" name="add" value="Add Vehicle">
        <!-- <input type="submit" name="update" value="Update Vehicle"> -->
    </form>

    <!-- Display existing vehicles -->
    <h2>Existing Vehicles</h2>
    <center><table border="1">
        <tr>
            <th>Vehicle ID</th>
            <th>Vehicle Type</th>
            <th>License Plate</th>
            <th>Model</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Last Maintenance Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($vehicles as $vehicle) { ?>
            <tr>
                <td><?php echo $vehicle['VehicleID']; ?></td>
                <td><?php echo $vehicle['VehicleType']; ?></td>
                <td><?php echo $vehicle['LicensePlate']; ?></td>
                <td><?php echo $vehicle['Model']; ?></td>
                <td><?php echo $vehicle['Year']; ?></td>
                <td><?php echo $vehicle['Mileage']; ?></td>
                <td><?php echo $vehicle['LastMaintenanceDate']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="vehicleId" value="<?php echo $vehicle['VehicleID']; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>
</body>
</html>
