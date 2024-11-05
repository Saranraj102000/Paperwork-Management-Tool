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



$id = $_GET['id'];

$query = $conn->prepare("SELECT * FROM paperworkdetails WHERE id = ?");

$query->bind_param("i", $id);

$query->execute();

$result = $query->get_result();

$item = $result->fetch_assoc();



echo "<input type='hidden' name='id' value='{$item['id']}'>";

// echo "<label for='name'>Name:</label>";

// echo "<input type='text' name='name' value='{$item['name']}'>";

?>