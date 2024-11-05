<?php
// Database connection parameters
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "formdata"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the record ID from the query parameter
$record_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Prepare and execute the query to fetch activity history
$sql = "SELECT * FROM activity_history WHERE record_id = ? ORDER BY modified_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $record_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Activity History</title>
    <!-- Include any CSS or JS files you need -->
</head>
<body>
    <h1>Activity History for Record ID: <?php echo htmlspecialchars($record_id); ?></h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Details</th>
                    <th>Modified By</th>
                    <th>Modified Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['action']); ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['modified_by']); ?></td>
                        <td><?php echo htmlspecialchars($row['modified_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No history available for this record.</p>
    <?php endif; ?>

    <a href="index.php">Back to Records</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
