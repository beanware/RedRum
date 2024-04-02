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

include 'routes.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add new route
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $distance = $_POST['distance'];
        $estimatedTime = $_POST['estimatedTime'];
        $fuelCost = $_POST['fuelCost'];
        addRoute($origin, $destination, $distance, $estimatedTime, $fuelCost);
    } elseif (isset($_POST['update'])) {
        // Update route
        $routeId = $_POST['routeId'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $distance = $_POST['distance'];
        $estimatedTime = $_POST['estimatedTime'];
        $fuelCost = $_POST['fuelCost'];
        updateRoute($routeId, $origin, $destination, $distance, $estimatedTime, $fuelCost);
    } elseif (isset($_POST['delete'])) {
        // Delete route
        $routeId = $_POST['routeId'];
        deleteRoute($routeId);
    }
}

// Fetch routes
$routes = getRoutes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Routes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Routes</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Form for adding/updating routes -->
    <form method="post" class="form-wrapper">
        <input type="hidden" name="routeId" value="">
        Origin: <input type="text" name="origin" required><br>
        Destination: <input type="text" name="destination" required><br>
        Distance: <input type="number" name="distance" step="0.01" required><br>
        Estimated Time: <input type="time" name="estimatedTime" required><br>
        Fuel Cost: <input type="number" name="fuelCost" step="0.01" required><br>
        <input type="submit" name="add" value="Add Route">
        <!-- <input type="submit" name="update" value="Update Route"> -->
    </form>

    <!-- Display existing routes -->
    <h2>Existing Routes</h2>
    </center><table border="1">
        <tr>
            <th>Route ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Distance</th>
            <th>Estimated Time</th>
            <th>Fuel Cost</th>
            <th>Action</th>
        </tr>
        <?php foreach ($routes as $route) { ?>
            <tr>
                <td><?php echo $route['RouteID']; ?></td>
                <td><?php echo $route['Origin']; ?></td>
                <td><?php echo $route['Destination']; ?></td>
                <td><?php echo $route['Distance']; ?></td>
                <td><?php echo $route['EstimatedTime']; ?></td>
                <td><?php echo $route['FuelCost']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="routeId" value="<?php echo $route['RouteID']; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>
</body>
</html>
