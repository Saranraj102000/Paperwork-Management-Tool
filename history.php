<?php

session_start();

include 'db.php'; // Include the database connection




// Check if the user is logged in

if (!isset($_SESSION['email'])) {

    die("You must be logged in to view records.");

}



$userEmail = $_SESSION['email']; // Get the logged-in user email



// Handle AJAX delete request

if (isset($_GET['delete_id']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {

    $deleteId = $_GET['delete_id'];



    // Prepare the DELETE SQL statement

    $sql = "DELETE FROM paperworkdetails WHERE id = ? AND submittedby = ?";



    // Initialize a statement

    $stmt = $conn->prepare($sql);



    if ($stmt) {

        // Bind the ID parameter and user email to the SQL query

        $stmt->bind_param('ss', $deleteId, $userEmail);



        // Execute the statement

        if ($stmt->execute()) {

            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);

        } else {

            echo json_encode(['status' => 'error', 'message' => 'Could not execute the delete operation.']);

        }



        // Close the statement

        $stmt->close();

    } else {

        echo json_encode(['status' => 'error', 'message' => 'Could not prepare the delete statement.']);

    }



    // Close the database connection

    $conn->close();

    exit();

}



// Initialize variables for search and date filter

$search = isset($_GET['search']) ? $_GET['search'] : '';

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';

$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$submittedBy = isset($_GET['submitted_by']) ? $_GET['submitted_by'] : '';



// Build the query with search and date filter

$sql = "SELECT id, cfirstname, clastname, created_at, submittedby FROM paperworkdetails WHERE 1";



if ($userEmail !== 'saranraj.s@vdartinc.com') {

    $sql .= " AND submittedby = ?";

}



if (!empty($search)) {

    $sql .= " AND (cfirstname LIKE ? OR clastname LIKE ?)";

}



if (!empty($startDate) && !empty($endDate)) {

    $sql .= " AND DATE(created_at) BETWEEN ? AND ?";

}



if (!empty($submittedBy)) {

    $sql .= " AND submittedby LIKE ?";

}



// Prepare the SQL statement

$stmt = $conn->prepare($sql);



// Bind parameters

$bindTypes = $userEmail === 'saranraj.s@vdartinc.com' ? '' : 's';

$params = [];



if ($userEmail !== 'saranraj.s@vdartinc.com') {

    $params[] = $userEmail;

}



if (!empty($search)) {

    $bindTypes .= 'ss';

    $params[] = "%$search%";

    $params[] = "%$search%";

}



if (!empty($startDate) && !empty($endDate)) {

    $bindTypes .= 'ss';

    $params[] = $startDate;

    $params[] = $endDate;

}



if (!empty($submittedBy)) {

    $bindTypes .= 's';

    $params[] = "%$submittedBy%";

}



if (!empty($params)) {

    $stmt->bind_param($bindTypes, ...$params);

}



// Execute the statement and get results

$stmt->execute();

$result = $stmt->get_result();

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>History Records</title>

    <link rel="stylesheet" href="historystyles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(document).ready(function(){

            $('a.record-link').click(function(event) {

                event.preventDefault();

                var id = $(this).data('id');

                $.ajax({

                    url: 'fetchdetails.php',

                    type: 'GET',

                    data: { id: id },

                    success: function(data) {

                        $('#modal-content').html(data);

                        $('#myModal').show();

                    }

                });

            });



            $('.close').click(function() {

                $('#myModal').hide();

            });



            $(window).click(function(event) {

                if ($(event.target).is('#myModal')) {

                    $('#myModal').hide();

                }

            });



            $('#reset-button').click(function(event) {

                event.preventDefault(); // Prevent the default button action

                // Clear form fields

                $('#filter-form')[0].reset();

                // Redirect to the page without query parameters

                window.location.href = 'history.php'; // Make sure to point to the correct page

            });

        });



        function confirmDelete(event, element) {

            event.preventDefault(); // Prevent the default link behavior

            

            const deleteId = element.getAttribute('data-id');

            

            Swal.fire({

                title: 'Are you sure?',

                text: "Do you want to delete this record?",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {

                if (result.isConfirmed) {

                    // Perform the AJAX request

                    fetch('?delete_id=' + deleteId, {

                        method: 'GET',

                        headers: {

                            'X-Requested-With': 'XMLHttpRequest'

                        }

                    })

                    .then(response => response.json())

                    .then(data => {

                        if (data.status === 'success') {

                            Swal.fire(

                                'Deleted!',

                                data.message,

                                'success'

                            ).then(() => {

                                // Optionally refresh the page or remove the record from the DOM

                                location.reload(); // Reload the page

                            });

                        } else {

                            Swal.fire(

                                'Error!',

                                data.message,

                                'error'

                            );

                        }

                    })

                    .catch(error => {

                        Swal.fire(

                            'Error!',

                            'An error occurred while deleting the record.',

                            'error'

                        );

                    });

                }

            });

        }

    </script>

</head>

<style>

    

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

*{

    margin: 0;

    padding: 0;

    box-sizing: border-box;

    font-family: 'Poppins', sans-serif;

}



body {

    font-family: Arial, sans-serif;

    background: linear-gradient(45deg, #fdbb2d, #22c1c3, #fdbb2d);

    background-size: 300% 300%;

    color: #333;

    margin: 0;

    padding: 0;

    animation: gradientAnimation 3s ease infinite;

}



/* @keyframes gradientAnimation {

    0% { background-position: 0% 50%; }

    50% { background-position: 100% 50%; }

    100% { background-position: 0% 50%; }

} */









h1 {

    background: linear-gradient(45deg, #1b1b1b, #2c3e50); /* Darker, more professional gradient */

    color: #ffffff; /* White text color for contrast */

    padding: 20px 40px; /* Adequate padding for prominence */

    text-align: center; /* Center align text */

    border-radius: 5px; /* Slightly rounded corners for a polished look */

    margin-bottom: 30px; /* Space below the header */

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Subtle shadow for depth */

    position: relative; /* For positioning pseudo-elements */

    font-family: 'Poppins', sans-serif; /* Modern and clean font */

    font-size: 2.5em; /* Larger font size for emphasis */

    letter-spacing: 1px; /* Subtle letter spacing for a refined look */

}









h1::before {

    content: ''; /* Empty content for the pseudo-element */

    position: absolute;

    top: 50%; /* Center vertically */

    left: 50%; /* Center horizontally */

    width: 50%; /* Slightly larger than the header */

    height: 60%; /* Slightly larger than the header */

    background: rgba(255, 255, 255, 0.1); /* Light overlay */

    border-radius: 50%; /* Circular shape */

    transform: translate(-50%, -50%); /* Center it */

    z-index: 0; /* Behind the text */

}



h1 span {

    position: relative; /* For stacking text over the pseudo-element */

    z-index: 1; /* Ensure text is above the pseudo-element */

}



/* h1:hover {

    background: linear-gradient(135deg, #9013fe, #4a90e2);

    transition: background 0.5s ease;

} */



h1 a {

    color: #fff;

    text-decoration: underline;

    font-weight: bold;

}



ul {

    list-style-type: none;

    padding: 0;

    display: flex;

    flex-wrap: wrap;

    justify-content: center;

    gap: 20px; /* Add some gap between items */

}



ul li {

    width: 200px; /* Fixed width for rectangular shape */

    height: 120px; /* Fixed height for rectangular shape */

    margin: 10px;

    text-align: center;

    display: flex;

    align-items: center;

    justify-content: center;

    

    border-radius: 8px; /* Rounded corners */

    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for depth */

    transition: transform 0.3s, background-color 0.3s;

}



ul li a {

    text-decoration: none;

    color: #fff;

    background-color: #333333;

    padding: 15px;

    display: block;

    width: 100%; /* Full width to fill the rectangle */

    height: 100%; /* Full height to fill the rectangle */

    display: flex;

    align-items: center;

    justify-content: center;

}



ul li a:hover {

    transform: scale(1.05); /* Slightly enlarge on hover */

    background-color: #4f4f4f; /* Darker background on hover */

}



/* Modal Background */

.modal {

    display: none;

    position: fixed;

    z-index: 1000;

    left: 0;

    top: 0;

    width: 100%;

    height: 100%;

    overflow: auto;

    background-color: rgba(0, 0, 0, 0.5);

    transition: opacity 0.3s ease;

}



/* Modal Content */

.modal-content {

    background-color: #fff;

    margin: 5% auto;

    padding: 20px;

    border-radius: 10px;

    width: 80%;

    max-width: 800px;

    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

    animation: fadeIn 0.3s ease;

}



/* Modal Header */

.modal-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding-bottom: 15px;

    border-bottom: 1px solid #ddd;

    margin-bottom: 15px;

}



.modal-header h2 {

    margin: 0;

    font-size: 24px;

    color: #333;

}



.modal-header .close {

    font-size: 30px;

    color: #666;

    cursor: pointer;

}



.modal-header .close:hover {

    color: #000;

}



/* Modal Body */

.modal-body {

    font-size: 16px;

    line-height: 1.5;

    color: #555;

}



/* Modal Footer */

.modal-footer {

    display: flex;

    justify-content: flex-end;

    padding-top: 15px;

    border-top: 1px solid #ddd;

}



.modal-footer .btn {

    background-color: #007bff;

    color: #fff;

    border: none;

    padding: 10px 20px;

    font-size: 16px;

    border-radius: 5px;

    cursor: pointer;

    transition: background-color 0.3s ease;

}



.modal-footer .btn:hover {

    background-color: #0056b3;

}



/* Fade In Animation */

@keyframes fadeIn {

    from { opacity: 0; }

    to { opacity: 1; }

}





table {

    width: 100%;

    border-collapse: collapse;

}



table, th, td {

    border: 1px solid #ddd;

}



th, td {

    padding: 12px;

    text-align: left;

}



th {

    background-color: #f4f4f4;

    color: #333;

}



/* New Back Button Styles */

.back-button {

    display: inline-block;

    padding: 10px 20px;

    margin: 20px;

    color: #fff;

    background-color: #007BFF;

    border: none;

    border-radius: 5px;

    text-align: center;

    text-decoration: none;

    font-size: 16px;

    transition: background-color 0.3s, transform 0.3s;

    cursor: pointer;

}



.back-button:hover {

    background-color: #0056b3;

    transform: scale(1.05);

}



.form-container {

    padding: 20px;

    background: linear-gradient(45deg, #1b1b1b, #2c3e50); /* Darker, more professional gradient */

    border-radius: 15px;

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

    color: white;

    width: 100%; /* Full width to accommodate different screen sizes */

    max-width: 1250px; /* Limit maximum width */

    margin: 20px auto; /* Center align and add vertical margin */

    display: flex; /* Flexbox for horizontal alignment */

    flex-direction: row; /* Horizontal alignment */

    align-items: center;

    box-sizing: border-box; /* Include padding in width calculation */

}



/* Style the search and date filter form */

form {

    display: flex;

    flex-direction: row; /* Arrange elements horizontally */

    align-items: center;

    gap: 15px; /* Space between elements */

    width: 100%; /* Full width for responsive design */

    flex-wrap: wrap; /* Allow elements to wrap on smaller screens */

}



/* Input and label styling */

input[type="text"], input[type="date"] {

    padding: 10px;

    border: none;

    border-radius: 8px;

    font-size: 14px;

    color: #333;

    background-color: white;

    flex: 1; /* Allow inputs to grow and shrink */

}



label {

    font-weight: bold;

    margin-right: 10px;

    font-size: 14px;

    white-space: nowrap; /* Prevent labels from wrapping */

}



button[type="submit"] {

    padding: 12px;

    background-color: #ff7e67;

    color: white;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    font-size: 16px;

    transition: background-color 0.3s, transform 0.3s;

}



button[type="submit"]:hover {

    background-color: #ff5743;

    transform: translateY(-2px);

}



button[type="submit"]:active {

    transform: translateY(0);

}

/* Reset button styling */

button[type="reset"] {

    padding: 12px;

    background-color: #e0e0e0; /* Light gray color for the reset button */

    color: #333;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    font-size: 16px;

    transition: background-color 0.3s, transform 0.3s;

    margin-left: 10px; /* Space between submit and reset buttons */

}



button[type="reset"]:hover {

    background-color: #c0c0c0; /* Darker gray on hover */

    transform: translateY(-2px);

}



button[type="reset"]:active {

    transform: translateY(0);

}



/* Container for record cards */

.record-container {

    display: flex;

    flex-wrap: wrap;

    justify-content: center;

    gap: 20px; /* Space between cards */

    padding: 20px;

}



/* Individual record card */

.record-card {

    background: #fff;

    border-radius: 8px;

    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

    width: 300px; /* Fixed width for each card */

    padding: 15px;

    text-align: center;

    transition: transform 0.3s, box-shadow 0.3s;

}



.record-card:hover {

    transform: translateY(-5px);

    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);

}



.record-header {

    font-size: 18px;

    margin-bottom: 10px;

}



.record-body p {

    margin: 5px 0;

}



.info {

    font-weight: bold;

}



.record-footer {

    margin-top: 15px;

}



.view-details {

    text-decoration: none;

    color: #007BFF;

    font-weight: bold;

    transition: color 0.3s;

}



.view-details:hover {

    color: #0056b3;

}



/* Style for icons */

.edit-record i,

.delete-record i,

.view-history i {

    color: #007bff; /* Blue color for icons */

    font-size: 18px; /* Adjust size as needed */

    transition: color 0.3s, transform 0.3s;

    cursor: pointer;

}



/* Hover effect for icons */

.edit-record i:hover {

    color: #0056b3; /* Darker blue for hover */

}



.delete-record i:hover {

    color: #dc3545; /* Red for hover */

    transform: scale(1.1); /* Slightly enlarge icon on hover */

}



.view-history i:hover {

    color: #28a745; /* Green for hover */

}



/* Optional: active state if needed */

.edit-record i:active,

.delete-record i:active,

.view-history i:active {

    transform: scale(0.95); /* Slightly shrink icon when clicked */

}



.record-footer {

    padding: 10px 0;

    border-top: 1px solid #ddd;

    display: flex;

    align-items: center;

    justify-content: space-between;

}



/* Style for icons and links */

.record-footer a {

    color: #007bff; /* Blue color for icons and links */

    font-size: 18px; /* Adjust size as needed */

    text-decoration: none; /* Remove underline */

}



.record-footer a:hover {

    color: #0056b3; /* Darker blue for hover effect */

}



.record-footer span {

    color: #333; /* Color for separators */

    font-size: 18px; /* Ensure separators match icon size */

}









/* Basic modal styles */

.modal {

    display: none; /* Hidden by default */

    position: fixed; /* Stay in place */

    z-index: 1000; /* Sit on top */

    left: 0;

    top: 0;

    width: 100%; /* Full width */

    height: 100%; /* Full height */

    overflow: hidden; /* Disable background scrolling */

    background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */

}



/* Modal content */

.modal-content {

    background-color: #fefefe;

    margin: 5% auto;

    padding: 20px;

    border: 1px solid #888;

    width: 60%; /* Width of the modal */

    max-height: 80vh; /* Limit the modal height to 80% of the viewport */

    overflow-y: auto; /* Add vertical scrollbar if content exceeds modal height */

    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    border-radius: 8px;

}



/* Style the close button */

.close {

    color: #aaa;

    float: right;

    font-size: 28px;

    font-weight: bold;

}



.close:hover, .close:focus {

    color: black;

    text-decoration: none;

    cursor: pointer;

}





    /* Scrollable content area */

    .scrollable-content {

        max-height: 50vh; /* Adjust the height for scrollable area */

        overflow-y: auto; /* Enable vertical scroll */

        padding-right: 15px; /* Prevent content from being cut off by scrollbar */

        margin-top: 20px;

    }



    /* Custom scrollbar styling */

    .scrollable-content::-webkit-scrollbar {

        width: 8px;

    }



    .scrollable-content::-webkit-scrollbar-thumb {

        background: #888; 

        border-radius: 4px;

    }



    .scrollable-content::-webkit-scrollbar-thumb:hover {

        background: #555;

    }









/* Responsive Design */

@media (max-width: 1200px) {

    .form-container {

        padding: 15px;

    }

}



@media (max-width: 992px) {

    .form-container {

        flex-direction: column; /* Stack elements vertically on smaller screens */

        margin: 20px; /* Adjust margin to fit smaller screens */

    }



    form {

        flex-direction: column; /* Stack form elements vertically */

        gap: 10px; /* Reduced gap for smaller screens */

    }



    input[type="text"], input[type="date"], button[type="submit"] {

        width: 100%; /* Full width for form elements */

        margin-bottom: 10px;

    }

}



@media (max-width: 768px) {

    .form-container {

        margin: 10px; /* Further adjust margin for mobile screens */

    }

}



/* Responsive Design */

@media (max-width: 992px) {

    ul li {

        width: 180px; /* Adjust width for smaller screens */

        height: 110px; /* Adjust height for smaller screens */

    }

}



@media (max-width: 768px) {

    ul li {

        width: 150px; /* Adjust width for smaller tablet screens */

        height: 100px; /* Adjust height for smaller tablet screens */

    }

}



@media (max-width: 576px) {

    ul li {

        width: 100%; /* Full width for mobile screens */

        height: auto; /* Auto height for better fit */

    }

}

</style>

<body>

    <h1>History Records</h1>

    <div class="form-container">

        <form id="filter-form" method="GET" action="">

            <label for="search">Search:</label>

            <input type="text" name="search" placeholder="Name" value="<?php echo htmlspecialchars($search); ?>">

            

            <label for="start_date">From:</label>

            <input type="date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">

            

            <label for="end_date">To:</label>

            <input type="date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">

            

            <label for="submitted_by">Submitted By:</label>

            <input type="text" name="submitted_by" placeholder="Submitted By" value="<?php echo htmlspecialchars($submittedBy); ?>" style="width: 50px;">

            

            <button type="submit">Go</button>

            <button type="reset" id="reset-button">Reset</button>

        </form>

    </div>



    <?php

    if ($result->num_rows > 0) {

        echo "<div class='record-container'>";

        while ($row = $result->fetch_assoc()) {

            $createdAt = isset($row['created_at']) ? new DateTime($row['created_at']) : null;

            $formattedDate = $createdAt ? $createdAt->format('Y-m-d H:i:s') : 'Not Available';

            

            $firstName = isset($row['cfirstname']) ? $row['cfirstname'] : 'Not Available';

            $lastName = isset($row['clastname']) ? $row['clastname'] : 'Not Available';

            $submittedBy = isset($row['submittedby']) ? $row['submittedby'] : 'Not Available';

            

            $fullName = htmlspecialchars($firstName . ' ' . $lastName);

            

            echo "<div class='record-card'>

                        <div class='record-header'>

                            <strong>" . htmlspecialchars($fullName) . "</strong>

                        </div>

                        <div class='record-body'>

                            <p>Submitted By: <span class='info'>" . htmlspecialchars($submittedBy) . "</span></p>

                            <p>Created At: <span class='info'>" . htmlspecialchars($formattedDate) . "</span></p>

                        </div>

                        <div class='record-footer'>

                            <a href='#' class='view-details' data-id='" . htmlspecialchars($row['id']) . "'>View Details</a>

                            <span>&nbsp;|&nbsp;</span>

                            <a href='testedit.php?id=" . htmlspecialchars($row['id']) . "' class='edit-record'>

                                <i class='fas fa-edit' title='Edit'></i>

                            </a>

                            <span></span>

                            <a href='#' class='delete-record' data-id='" . htmlspecialchars($row['id']) . "' onclick='confirmDelete(event, this)'>

                                <i class='fas fa-trash' title='Delete'></i>

                            </a>

                            <span></span>

                            <a href='#' class='view-history' data-id='" . htmlspecialchars($row['id']) . "'>

                                <i class='fas fa-history' title='View History'></i>

                            </a>

                            <span></span>

                            <a href='export.php?id=" . htmlspecialchars($row['id']) . "' class='export-record'>

                                <i class='fas fa-file-export' title='Export'></i>

                            </a>

                        </div>

            </div>";





        }

        echo "</div>";

    } else {

        echo "<p>No records found.</p>";

    }



    $conn->close();

    ?>



    <!-- The Modal -->

<div id="myModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Record Details</h2>

            <span class="close">&times;</span>

        </div>

        <div id="modal-content" class="modal-body">

            <!-- Record details will be loaded here via AJAX -->

        </div>

        <div class="modal-footer">

            <button class="btn btn-primary close">Close</button>

        </div>

    </div>

</div>





<!-- History Modal Structure -->

<div id="historyModal" class="modal" style="display: none;">

    <div class="modal-content">

        <span class="close">&times;</span>

        <h2>Activity History</h2>

        <div id="history-content" class="scrollable-content"></div> <!-- Scrollable content section -->

    </div>

</div>

<script>

    function confirmDelete(event, element) {

        event.preventDefault(); // Prevent default action



        var recordId = $(element).data('id'); // Get the record ID



        // SweetAlert2 confirmation popup

        Swal.fire({

            title: 'Are you sure?',

            text: "This action cannot be undone!",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {

            if (result.isConfirmed) {

                // Send AJAX request to delete the record

                $.ajax({

                    url: 'delete.php', // The PHP script for deletion

                    type: 'POST',

                    data: { id: recordId },

                    success: function(response) {

                        if (response.trim() === 'success') {

                            Swal.fire(

                                'Deleted!',

                                'The record has been deleted.',

                                'success'

                            ).then(() => {

                                // Reload the page after the success message

                                location.reload();

                            });

                        } else {

                            Swal.fire(

                                'Error!',

                                'An error occurred while deleting the record.',

                                'error'

                            );

                        }

                    },

                    error: function() {

                        Swal.fire(

                            'Error!',

                            'Unable to process the request. Please try again later.',

                            'error'

                        );

                    }

                });

            }

        });

    }

</script>



<script>

$(document).ready(function() {

    // Click event for "View Details"

    $(document).on('click', 'a.view-details', function(event) {

        event.preventDefault(); // Prevent default link behavior

        var id = $(this).data('id'); // Get record ID



        if (!id) {

            Swal.fire('Error', 'Record ID is missing.', 'error');

            return;

        }



        // AJAX request to fetch record details

        $.ajax({

            url: 'fetchdetails.php', // File to fetch record details

            type: 'GET',

            data: { id: id },

            success: function(response) {

                // Check if the response contains data

                if (response.trim()) {

                    $('#modal-content').html(response); // Display details in modal

                    $('#myModal').fadeIn(); // Show modal with fade in effect

                } else {

                    Swal.fire('Error', 'No details available for this record.', 'error');

                }

            },

            error: function(xhr, status, error) {

                console.log('Error:', xhr.responseText); // Log error details for debugging

                Swal.fire('Error', 'Unable to fetch details.', 'error');

            }

        });

    });



    // Click event for closing the modal

    $(document).on('click', '.close', function() {

        $('#myModal').fadeOut(); // Hide modal with fade out effect

    });



    // Close modal when clicking outside of it

    $(window).on('click', function(event) {

        if ($(event.target).is('#myModal')) {

            $('#myModal').fadeOut(); // Hide modal with fade out effect

        }

    });



    // Click event for resetting the filter form

    $('#reset-button').click(function(event) {

        event.preventDefault(); // Prevent default button action

        $('#filter-form')[0].reset(); // Clear form fields

        window.location.href = 'history.php'; // Redirect to page without query parameters

    });

});

</script>



<script>

    // Click event for "View History"

    $('a.view-history').click(function(event) {

        event.preventDefault(); // Prevent default link behavior

        var id = $(this).data('id'); // Get record ID

        

        // AJAX request to fetch activity history

        $.ajax({

            url: 'fetch_history.php', // File to fetch activity history

            type: 'GET',

            data: { id: id },

            success: function(response) {

                $('#history-content').html(response); // Display history in modal

                $('#historyModal').fadeIn(); // Show history modal with fade in effect

            },

            error: function() {

                Swal.fire('Error', 'Unable to fetch history.', 'error');

            }

        });

    });



    // Click event for closing the modals

    $('.close').click(function() {

        $(this).closest('.modal').fadeOut(); // Hide the closest modal with fade out effect

    });



    // Close modal when clicking outside of it

    $(window).click(function(event) {

        if ($(event.target).is('.modal')) {

            $(event.target).fadeOut(); // Hide the clicked modal with fade out effect

        }

    });

</script>

</body>

</html>

