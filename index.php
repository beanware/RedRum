<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
<title>Fleet Manager</title>
</head>
<body>
    <header>
        <img src="./img/wheel.svg" alt="Logo" class="logo">
        <?php echo "<h1>Welcome, $username!</h1>";?>
        <form action="logout.php" method="post"><button class="logout-btn">Log Out</button></form>
    </header>
    <div class="container">
        <!-- Cards -->
        <div class="card">
        <img src="./img/vehicles.png">
            <div class="card-content">
                <h3>Vehicles</h3>
                <p>All our vehicles.</p>
                <a href="vehicles_page.php" class="btn">View Vehicles</a>
            </div>
        </div>

        <div class="card">
            <img src="./img/driver.svg" alt="Image 2">
            <div class="card-content">
                <h3>Drivers</h3>
                <p>All our drivers.</p>
                <a href="drivers_page.php" class="btn">View Drivers</a>
            </div>
        </div>

        <div class="card">
            <img src="./img/road.svg" alt="Image 1">
            <div class="card-content">
                <h3>Routes</h3>
                <p>All our routes.</p>
                <a href="route_page.php" class="btn">View Route</a>
            </div>
        </div>

        <div class="card">
            <img src="./img/tools.svg">
            <div class="card-content">
                <h3>Maintenance</h3>
                <p>All maintanance records.</p>
                <a href="maintenance_page.php" class="btn">View Maintenance</a>
            </div>
        </div>
S
        <div class="card">
            <img src="./img/inventory.svg">
            <div class="card-content">
                <h3>Inventory</h3>
                <p>Inventory records.</p>
                <a href="inventory_page.php" class="btn">View Inventory</a>
            </div>
        </div>
        <div class="card">
            <img src="./img/delivery.svg" alt="Image 2">
            <div class="card-content">
                <h3>Deliveries</h3>
                <p>Delivery Records.</p>
                <a href="deliveries_page.php" class="btn">View Deliveries</a>
            </div>
        </div>
        <!-- Cards -->
    </div>

    <script>
        function logout() {
            // Perform logout 
            alert('Logged out successfully!');
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
