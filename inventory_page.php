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

include 'conn.php';

// Function to fetch inventory items from the database
function getInventory() {
    global $conn;
    $sql = "SELECT * FROM Inventory";
    $result = $conn->query($sql);
    if ($result === false) {
        return false; // Return false if there's an error
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}


function addInventory($productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel) {
    global $conn;
    $sql = "INSERT INTO Inventory (ProductName, Description, Quantity, UnitPrice, Supplier, ReorderLevel) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiss", $productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel);
    if ($stmt->execute() === false) {
        return false; 
    }
    return true; 
}


function updateInventory($productId, $productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel) {
    global $conn;
    $sql = "UPDATE Inventory SET ProductName = ?, Description = ?, Quantity = ?, UnitPrice = ?, Supplier = ?, ReorderLevel = ? WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiissi", $productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel, $productId);
    if ($stmt->execute() === false) {
        return false; 
    }
    return true; 
}

// Function to delete 
function deleteInventory($productId) {
    global $conn;
    $sql = "DELETE FROM Inventory WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute() === false) {
        return false; 
    }
    return true; 
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addInventory'])) {
        // Add new
        $productName = $_POST['productName'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $unitPrice = $_POST['unitPrice'];
        $supplier = $_POST['supplier'];
        $reorderLevel = $_POST['reorderLevel'];
        addInventory($productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel);
    } elseif (isset($_POST['updateInventory'])) {
        // Update 
        $productId = $_POST['productId'];
        $productName = $_POST['productName'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $unitPrice = $_POST['unitPrice'];
        $supplier = $_POST['supplier'];
        $reorderLevel = $_POST['reorderLevel'];
        updateInventory($productId, $productName, $description, $quantity, $unitPrice, $supplier, $reorderLevel);
    } elseif (isset($_POST['deleteInventory'])) {
        
        $productId = $_POST['productId'];
        deleteInventory($productId);
    }
}

// Fetch
$inventory = getInventory();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Inventory</h1>

    <center><a href="index.php" class="back-btn">Home</a></center>
    
    <!-- Form for adding/updating -->
    <form method="post" class="form-wrapper">
        <input type="hidden" name="productId" value="">
        Product Name: <input type="text" name="productName" required><br>
        Description: <textarea name="description"></textarea><br>
        Quantity: <input type="number" name="quantity" required><br>
        Unit Price: <input type="number" step="0.01" name="unitPrice" required><br>
        Supplier: <input type="text" name="supplier"><br>
        Reorder Level: <input type="number" name="reorderLevel" value="0"><br>
        <input type="submit" name="addInventory" value="Add Inventory">
        <!-- <input type="submit" name="updateInventory" value="Update Inventory"> -->
    </form>

    <!-- Display existing items -->
    <h2>Existing Inventory</h2>
    <center><table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Supplier</th>
            <th>Reorder Level</th>
            <th>Action</th>
        </tr>
        <?php foreach ($inventory as $item) { ?>
            <tr>
                <td><?php echo $item['ProductID']; ?></td>
                <td><?php echo $item['ProductName']; ?></td>
                <td><?php echo $item['Description']; ?></td>
                <td><?php echo $item['Quantity']; ?></td>
                <td><?php echo $item['UnitPrice']; ?></td>
                <td><?php echo $item['Supplier']; ?></td>
                <td><?php echo $item['ReorderLevel']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="productId" value="<?php echo $item['ProductID']; ?>">
                        <input type="submit" name="deleteInventory" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table></center>
</body>
</html>
