<?php

// delete.php

include 'db.php';

if (isset($_POST['id'])) {

    $id = intval($_POST['id']); // Secure the ID by casting it to an integer



    // Include your database connection file

    // Database connection

// $servername = "localhost";

// $username = "root";

// $password = "";

// $dbname = "formdata";



// $conn = new mysqli($servername, $username, $password, $dbname);



// // Check connection

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }



    // SQL query to delete the record

    $query = "DELETE FROM paperworkdetails WHERE id = ?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param('i', $id); // Bind the ID as an integer



    if ($stmt->execute()) {

        echo 'success'; // Send 'success' response if the record is deleted

    } else {

        echo 'error'; // Send 'error' response if something goes wrong

    }



    $stmt->close();

    $conn->close();

}

?>

