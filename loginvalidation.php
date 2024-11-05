<?php



session_start();

// Database connection code (you need to fill in your database details)

$servername = "localhost";

$username = "formdata";

$password = "formdata@123";

$dbname = "formdata";



$conn = new mysqli($servername, $username, $password, $dbname);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];

    $password = $_POST['password'];



// Check if user credentials exist in the database (you need to write your own SQL query)

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

$result = $conn->query($sql);



if ($result->num_rows > 0) {



    $_SESSION['email'] = $email; // Store the username in the session

    $_SESSION['loggedin'] = true;

    // Redirect user to the next page

    header("Location: home.php");

    exit;

} else {

    echo "Invalid credentials"; // You can handle invalid credentials here

}

}

$conn->close();

?>







