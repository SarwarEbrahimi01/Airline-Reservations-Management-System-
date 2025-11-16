<?php
// =============================
// Database Connection Settings
// =============================
$serverName = "localhost"; // or your SQL Server name, e.g. "DESKTOP-1234\SQLEXPRESS"
$connectionOptions = array(
    "Database" => "AirlineReservationDB",
    "Uid" => "", // if SQL Authentication, add username
    "PWD" => ""  // if SQL Authentication, add password
);

// Create Connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check Connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// =============================
// Insert Data
// =============================
if (isset($_POST['insert'])) {
    $AirlineId= $_POST['AirlineId'];
    $AirlineName = $_POST['AirlineName'];
    $AirlineCode = $_POST['AirlineCode'];

    $sql = "INSERT INTO Airline ( AirlineId,AirlineName, AirlineCode) VALUES (?, ?, ?)";
    $params = array($AirlineId, $AirlineName, $AirlineCode);

    if (sqlsrv_query($conn, $sql, $params)) {
        echo "<p style='color:green;'>✅ Record inserted successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error inserting data.</p>";
    }
}

// =============================
// Update Data
// =============================
if (isset($_POST['update'])) {
    $AirlineId = $_POST['AirlineId'];
    $AirlineName = $_POST['AirlineName'];
    $AirlineCode = $_POST['AirlineCode'];

    $sql = "UPDATE Airline SET AirlineName=?, AirlineCode=? WHERE AirlineId=?";
    $params = array($AirlineName, $AirlineCode, $AirlineId);

    if (sqlsrv_query($conn, $sql, $params)) {
        echo "<p style='color:green;'>✅ Record updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error updating record.</p>";
    }
}

// =============================
// Delete Data
// =============================
if (isset($_POST['delete'])) {
    $AirlineId = $_POST['AirlineId'];

    $sql = "DELETE FROM Airline WHERE AirlineId=?";
    $params = array($AirlineId);

    if (sqlsrv_query($conn, $sql, $params)) {
        echo "<p style='color:green;'>✅ Record deleted successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error deleting record.</p>";
    }
}

// =============================
// Show Data
// =============================
$sql = "SELECT * FROM Airline";
$result = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Airline Management</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f4f4f4; }
        table { border-collapse: collapse; width: 70%; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 8px; text-align: center; }
        th { background: #333; color: white; }
        input[type=text], input[type=number] { padding: 6px; width: 200px; }
        button { padding: 6px 12px; margin: 4px; cursor: pointer; }
    </style>
</head>
<body>

<h2>✈ Airline Management System</h2>

<form method="post">
    <label>Airline ID:</label><br>
    <input type="number" name="AirlineId" placeholder="For update/delete"><br><br>

    <label>Airline Name:</label><br>
    <input type="text" name="AirlineName" required><br><br>

    <label>Airline Code:</label><br>
    <input type="text" name="AirlineCode" required><br><br>

    <button type="submit" name="insert">Insert</button>
    <button type="submit" name="update">Update</button>
    <button type="submit" name="delete">Delete</button>
</form>

<h3>📋 Airline Records:</h3>
<table>
    <tr>
        <th>Airline ID</th>
        <th>Airline Name</th>
        <th>Airline Code</th>
    </tr>

    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
        <tr>
            <td><?php echo $row['AirlineId']; ?></td>
            <td><?php echo $row['AirlineName']; ?></td>
            <td><?php echo $row['AirlineCode']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
