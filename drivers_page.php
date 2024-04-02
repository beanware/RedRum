<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

include 'drivers.php';

//Form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add new 
        $name = $_POST['name'];
        $licenseNumber = $_POST['licenseNumber'];
        $contactInformation = $_POST['contactInformation'];
        $experienceLevel = $_POST['experienceLevel'];
        addDriver($name, $licenseNumber, $contactInformation, $experienceLevel);
    } elseif (isset($_POST['update'])) {
        // Update 
        $driverId = $_POST['driverId'];
        $name = $_POST['name'];
        $licenseNumber = $_POST['licenseNumber'];
        $contactInformation = $_POST['contactInformation'];
        $experienceLevel = $_POST['experienceLevel'];
        updateDriver($driverId, $name, $licenseNumber, $contactInformation, $experienceLevel);
    } elseif (isset($_POST['delete'])) {
        // Delete 
        $driverId = $_POST['driverId'];
        deleteDriver($driverId);
    }
}

// Fetch 
$drivers = getDrivers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Drivers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Drivers</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Form for adding/updating-->
    <form method="post" class="form-wrapper">
        <input type="hidden" name="driverId" value="">
        Name: <input type="text" name="name" required><br>
        License Number: <input type="text" name="licenseNumber" required><br>
        Contact Information: <input type="text" name="contactInformation" required><br>
        Experience Level:
        <select name="experienceLevel" required>
            <option value="Beginner">Beginner</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Advanced">Advanced</option>
        </select><br>
        <input type="submit" name="add" value="Add Driver">
        <!-- <input type="submit" name="update" value="Update Driver"> -->
    </form>

    <!-- Display  -->
    <h2>Existing Drivers</h2>
    <center><table border="1">
        <tr>
            <th>Driver ID</th>
            <th>Name</th>
            <th>License Number</th>
            <th>Contact Information</th>
            <th>Experience Level</th>
            <th>Action</th>
        </tr>
        <?php foreach ($drivers as $driver) { ?>
            <tr>
                <td><?php echo $driver['DriverID']; ?></td>
                <td><?php echo $driver['Name']; ?></td>
                <td><?php echo $driver['LicenseNumber']; ?></td>
                <td><?php echo $driver['ContactInformation']; ?></td>
                <td><?php echo $driver['ExperienceLevel']; ?></td>
                <td>
                    <form method="post" >
                        <input type="hidden" name="driverId" value="<?php echo $driver['DriverID']; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>
</body>
</html>
