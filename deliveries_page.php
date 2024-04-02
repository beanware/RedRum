<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

include 'deliveries.php';

// Form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add new delivery
        $customerId = $_POST['customerId'];
        $routeId = $_POST['routeId'];
        $vehicleId = $_POST['vehicleId'];
        $driverId = $_POST['driverId'];
        $deliveryDate = $_POST['deliveryDate'];
        addDelivery($customerId, $routeId, $vehicleId, $driverId, $deliveryDate);
        echo "<script>alert('Delivery added successfully!');</script>";
    } elseif (isset($_POST['update'])) {
        // Update delivery
        $deliveryId = $_POST['deliveryId'];
        $customerId = $_POST['customerId'];
        $routeId = $_POST['routeId'];
        $vehicleId = $_POST['vehicleId'];
        $driverId = $_POST['driverId'];
        $deliveryDate = $_POST['deliveryDate'];
        updateDelivery($deliveryId, $customerId, $routeId, $vehicleId, $driverId, $deliveryDate);
        echo "<script>alert('Delivery updated successfully!');</script>";
    } elseif (isset($_POST['delete'])) {
        // Delete delivery
        $deliveryId = $_POST['deliveryId'];
        deleteDelivery($deliveryId);
        echo "<script>alert('Delivery deleted successfully!');</script>";
    }
}

// Fetch deliveries
$deliveries = getDeliveries();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Deliveries</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Deliveries</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Adding/updating deliveries form -->
    <form method="post" class="form-wrapper" id="deliveryForm">
        <input type="hidden" name="deliveryId" value="">
        Customer ID: <input type="number" name="customerId" id="customerId" required><br>
        Route ID: <input type="number" name="routeId" id="routeId" required><br>
        Vehicle ID: <input type="number" name="vehicleId" id="vehicleId" required><br>
        Driver ID: <input type="number" name="driverId" id="driverId" required><br>
        Delivery Date: <input type="date" name="deliveryDate" id="deliveryDate" required><br>
        <input type="submit" name="add" value="Add Delivery">
        <!-- <input type="button" name="update" value="Update Delivery" onclick="fillUpdateForm()"> -->
    </form>
  
    <!-- Display existing deliveries -->
    <h2>Existing Deliveries</h2>
    <center><table border="1" id="deliveryTable">
        <tr>
            <th>Delivery ID</th>
            <th>Customer ID</th>
            <th>Route ID</th>
            <th>Vehicle ID</th>
            <th>Driver ID</th>
            <th>Delivery Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($deliveries as $delivery) { ?>
            <tr>
                <td><?php echo $delivery['DeliveryID']; ?></td>
                <td><?php echo $delivery['CustomerID']; ?></td>
                <td><?php echo $delivery['RouteID']; ?></td>
                <td><?php echo $delivery['VehicleID']; ?></td>
                <td><?php echo $delivery['DriverID']; ?></td>
                <td><?php echo $delivery['DeliveryDate']; ?></td>
                <td><?php echo $delivery['Status']; ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this delivery?');">
                        <input type="hidden" name="deliveryId" value="<?php echo $delivery['DeliveryID']; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>


    <script>
        function fillUpdateForm() {
            var form = document.getElementById('deliveryForm');
            var selectedRow = document.querySelector('input[name="selectedDelivery"]:checked');
            if (selectedRow) {
                var cells = selectedRow.parentNode.parentNode.getElementsByTagName('td');
                form.elements['deliveryId'].value = cells[1].innerText;
                form.elements['customerId'].value = cells[2].innerText;
                form.elements['routeId'].value = cells[3].innerText;
                form.elements['vehicleId'].value = cells[4].innerText;
                form.elements['driverId'].value = cells[5].innerText;
                form.elements['deliveryDate'].value = cells[6].innerText;
            } else {
                alert('Please select a delivery to update.');
            }
        }
    </script>
</body>
</html>
