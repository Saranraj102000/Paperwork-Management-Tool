<?php

// Database connection

include 'db.php';

// $servername = "localhost";

// $username = "root";

// $password = "";

// $dbname = "formdata";



// $conn = new mysqli($servername, $username, $password, $dbname);



// // Check connection

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }



if (isset($_GET['id'])) {

    $id = $_GET['id'];



    // Prepare the SQL query to fetch the record by id

    $stmt = $pdo->prepare("SELECT * FROM paperworkdetails WHERE id = ?");

    $stmt->execute([$id]);



    $record = $stmt->fetch(PDO::FETCH_ASSOC);



    if ($record) {

        echo json_encode($record);

    } else {

        echo json_encode(['error' => 'Record not found']);

    }

}

?>

