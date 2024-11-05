<?php
require 'db.php';

// SQL query to add a new column 'reason' after the 'status' column in the 'paperworkdetails' table
$sql = "ALTER TABLE paperworkdetails ADD COLUMN reason TEXT AFTER status";

if ($conn->query($sql) === TRUE) {
    echo "Column 'reason' added successfully after 'status' in 'paperworkdetails' table.";
} else {
    echo "Error adding column: " . $conn->error;
}

// Close connection
$conn->close();
?>
