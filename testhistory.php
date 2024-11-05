<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: animatedlogin.php"); // Redirect if not logged in
    exit();
}

require 'db.php';

$userEmail = $_SESSION['email']; // Get the logged-in user email

// Initialize variables for search and date filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$submittedBy = isset($_GET['submitted_by']) ? $_GET['submitted_by'] : '';

// Pagination logic
$recordsPerPage = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// SQL to get filtered record count
$sqlCount = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE 1";

if ($userEmail !== 'saranraj50540@gmail.com') {
    $sqlCount .= " AND submittedby = ?";
}

if (!empty($search)) {
    $sqlCount .= " AND (cfirstname LIKE ? OR clastname LIKE ?)";
}

if (!empty($startDate) && !empty($endDate)) {
    $sqlCount .= " AND DATE(created_at) BETWEEN ? AND ?";
}

if (!empty($submittedBy)) {
    $sqlCount .= " AND submittedby LIKE ?";
}

// Prepare the SQL statement for the total count
$stmtCount = $conn->prepare($sqlCount);

// Bind parameters similar to your main query
$bindTypesCount = $userEmail === 'saranraj50540@gmail.com' ? '' : 's';
$paramsCount = [];

if ($userEmail !== 'saranraj50540@gmail.com') {
    $paramsCount[] = $userEmail;
}

if (!empty($search)) {
    $bindTypesCount .= 'ss';
    $paramsCount[] = "%$search%";
    $paramsCount[] = "%$search%";
}

if (!empty($startDate) && !empty($endDate)) {
    $bindTypesCount .= 'ss';
    $paramsCount[] = $startDate;
    $paramsCount[] = $endDate;
}

if (!empty($submittedBy)) {
    $bindTypesCount .= 's';
    $paramsCount[] = "%$submittedBy%";
}

if (!empty($paramsCount)) {
    $stmtCount->bind_param($bindTypesCount, ...$paramsCount);
}

// Execute the count statement
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalFilteredRecords = $resultCount->fetch_assoc()['total']; // Total filtered records

$totalPages = ceil($totalFilteredRecords / $recordsPerPage);

// Build the query with search and date filter
$sql = "SELECT id, cfirstname, clastname, created_at, submittedby FROM paperworkdetails WHERE 1";

if ($userEmail !== 'saranraj50540@gmail.com') {
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

$sql .= " LIMIT ? OFFSET ?"; // Add LIMIT and OFFSET for pagination

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters
$bindTypes = $userEmail === 'saranraj50540@gmail.com' ? '' : 's';
$params = [];

if ($userEmail !== 'saranraj50540@gmail.com') {
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

$params[] = $recordsPerPage; // Add LIMIT
$params[] = $offset; // Add OFFSET
$bindTypes .= 'ii'; // Bind integers for LIMIT and OFFSET

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Global Styles */
        /* Add your CSS here */

        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        body {
            background-color: #6f6f6f;
            color: #6f6f6f;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* h1 {
            background: linear-gradient(90deg, #2c3e50, #4ca1af);
            color: #eeeeee;
            padding: 20px;
            text-align: center;
            border-radius: 1px;
            margin-bottom: 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            font-size: 2.5em;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            position: relative;
        } */

        h1::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #ff6a00, #ee0979);
            animation: animate-bar 5s linear infinite;
        }

        /* @keyframes animate-bar {
            0% { left: -100%; }
            100% { left: 100%; }
        } */

        /* Form Styles */
        .form-container {
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1300px;
            margin: 0 auto 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            width: 100%;
        }

        input[type="text"], input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            background-color: white;
            transition: box-shadow 0.3s ease;
            width: 100%;
            max-width: 180px;
        }

        input[type="text"]:focus, input[type="date"]:focus {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        label {
            font-weight: 500;
            font-size: 14px;
            color: #2c3e50;
            margin-right: 5px;
        }

        button[type="submit"], button[type="reset"] {
            padding: 10px 18px;
            background-color: #00a8ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        button[type="submit"]:hover, button[type="reset"]:hover {
            background-color: #007BFF;
            transform: translateY(-2px);
        }

        button[type="reset"] {
            background-color: #ecf0f1;
            color: #333;
        }

        /* Record Container Styles */
        .record-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 12px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .record-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            border-left: 5px solid #4ca1af;
            cursor: pointer;
        }

        .record-list-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .record-header {
            flex: 2;
            font-size: 1.4em;
            font-weight: 600;
            color: #333;
        }

        .record-info {
            flex: 3;
            color: #555;
            font-size: 15px;
        }

        .record-info p {
            margin: 5px 0;
        }

        .record-footer {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
        }

        .record-footer a {
            text-decoration: none;
            font-size: 15px;
            color: #007BFF;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .record-footer a:hover {
            color: #0056b3;
            transform: translateX(5px);
        }

        .record-footer a i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .record-footer a:hover i {
            transform: scale(1.2);
        }

        .record-footer a:last-child {
            color: #ff6a00;
        }

        .record-footer a:last-child:hover {
            color: #ff4500;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            list-style-type: none;
        }

        .pagination a {
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 15px;
            border-radius: 6px;
            background-color: #f1f3f4;
            color: #333;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }

        .pagination .active {
            background-color: #007BFF;
            color: white;
            pointer-events: none;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5); /* Dimmed background */
        }

        .modal-dialog {
            max-width: 600px;
            margin: 1.75rem auto;
            height: calc(100% - 3.5rem); /* Adjust height to make modal scrollable */
        }

        .modal-dialog-scrollable {
            overflow-y: auto;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
            max-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            margin: 0;
        }

        .modal-body {
            padding: 20px;
            font-size: 16px;
            overflow-y: auto;
            flex-grow: 1; /* Allows body to expand and make it scrollable */
        }

        .modal-footer {
            padding: 10px;
            border-top: 1px solid #e5e5e5;
            display: flex;
            justify-content: flex-end;
        }

        .close {
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .close:hover {
            color: red; /* Change color when hovering for better UX */
            cursor: pointer;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d; /* Bootstrap-like secondary color */
            color: #fff; /* White text */
        }

        .btn-secondary:hover {
            background-color: #5a6268; /* Darker shade on hover */
            border-color: #545b62; /* Border change on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
        }

        .btn-secondary:focus {
            background-color: #5a6268;
            border-color: #545b62;
            outline: none;
            box-shadow: 0 0 0 3px rgba(108, 117, 125, 0.25); /* Focus ring */
        }

        .btn-secondary:active {
            background-color: #545b62; /* Even darker shade on click */
            border-color: #4e555b;
            box-shadow: none; /* Remove shadow on click */
        }




        /* Responsive Styles */
        @media (max-width: 1024px) {
            body {
                font-size: 14px;
            }

            h1 {
                font-size: 2em;
                padding: 15px;
            }

            .record-header {
                font-size: 1.3em;
            }

            .record-info p {
                font-size: 14px;
            }

            .record-footer a {
                font-size: 13px;
            }

            .pagination a {
                padding: 8px 12px;
                margin: 0 5px;
            }
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
            }

            input[type="text"], input[type="date"] {
                width: 100%;
            }

            .record-list-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .record-footer {
                justify-content: flex-start;
                margin-top: 10px;
            }

            button {
                width: 100%;
            }

            .pagination a {
                padding: 6px 10px;
                margin: 0 4px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8em;
                padding: 15px 3%;
            }

            .record-header {
                font-size: 1.2em;
            }

            .record-info, .record-footer a {
                font-size: 13px;
            }

            .pagination a {
                padding: 5px 8px;
                margin: 0 3px;
            }
        }
        .back-button {
            display: inline-block;
            padding: 5px 10px; /* Reduced padding */
            background-color: #3085d6; /* Button background color */
            color: white; /* Button text color */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Rounded corners */
            position: absolute; /* Absolute positioning */
            left: 0; /* Aligns the button fully to the left */
            top: 30px; /* Adjust the top position as needed */
            font-size: 20px; /* Reduced font size */
            margin-left: 4px;
        }

        .back-button i {
            margin-right: 5px; /* Space between icon and text */
            font-size: 20px; /* Reduced icon size */
        }


    </style>
</head>
<body>
<h1 style="display: flex; align-items: center; justify-content: center; margin-bottom: 30px; padding: 20px; background: linear-gradient(90deg, #f0f0f0, #b0b0b0); color: #333333; border-radius: 1px; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); font-size: 2.1em; letter-spacing: 1.5px; text-transform: uppercase; position: relative;">
    
    <!-- Back option with icon on the left -->
    <!-- <a href="home.php" style="text-decoration: none; color: #333333; font-size: 0.6em; display: flex; align-items: center; position: absolute; left: 20px;">
        <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
        <span>Back</span>
    </a> -->

    <a href="dashboard.php" class="back-button">
        <i class="fas fa-home"></i> Home
    </a>


    <!-- Image and title in the center -->
    <div style="display: flex; align-items: center;">
        <img src="images1.png" alt="Image" style="width: 60px; height: auto; margin-right: 10px;">
        <span>All Records</span>
    </div>
</h1>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


    <div class="form-container">
        <form id="filter-form" method="GET" action="">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">

            <label for="start_date">From:</label>
            <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($startDate); ?>">

            <label for="end_date">To:</label>
            <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($endDate); ?>">

            <label for="submitted_by">Submitted By:</label>
            <input type="text" name="submitted_by" placeholder="Submitted By" value="<?php echo htmlspecialchars($submittedBy); ?>">

            <button type="submit">Go</button>
            <button type="reset" id="reset-button">Reset</button>
        </form>
    </div>

    <?php
    // SQL Query with filter and order applied
    $sql = "SELECT * FROM paperworkdetails WHERE 1=1";

    // Apply search filter if set
    if (!empty($search)) {
        $sql .= " AND (cfirstname LIKE '%" . $conn->real_escape_string($search) . "%' OR clastname LIKE '%" . $conn->real_escape_string($search) . "%')";
    }

    // Apply date range filter if both start and end dates are provided
    if (!empty($startDate) && !empty($endDate)) {
        $sql .= " AND (created_at BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "')";
    }

    // Apply 'submitted by' filter if set
    if (!empty($submittedBy)) {
        $sql .= " AND submittedby = '" . $conn->real_escape_string($submittedBy) . "'";
    }

    // Always order the results by created_at field in descending order
    $sql .= " ORDER BY created_at DESC";

    // Pagination logic can be added here
    $sql .= " LIMIT $offset, $recordsPerPage";

    // Execute query
    $result = $conn->query($sql);
    ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="record-container">
            <?php while ($row = $result->fetch_assoc()): 
                $createdAt = isset($row['created_at']) ? new DateTime($row['created_at']) : null;
                $formattedDate = $createdAt ? $createdAt->format('m-d-Y H:i:s') : 'Not Available';
                $fullName = htmlspecialchars($row['cfirstname'] . ' ' . $row['clastname']);
            ?>
                <div class="record-list-item">
                    <div class="record-header"><strong><?php echo $fullName; ?></strong></div>
                    <div class="record-info">
                        <p>Submitted By: <span class="info"><?php echo htmlspecialchars($row['submittedby']); ?></span></p>
                        <p>Created At: <span class="info"><?php echo htmlspecialchars($formattedDate); ?></span></p>
                    </div>
                    <div class="record-footer">
                        <!-- <a href="#" class="view-details" data-id="<?php echo htmlspecialchars($row['id']); ?>">View</a> -->
                        <!-- <span>&nbsp;|&nbsp;</span> -->
                        <a href="testedit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="edit-record">
                            <i class="fas fa-eye" title="Edit"></i>
                        </a>
                        <span>&nbsp;&nbsp;</span>
                        <a href="#" class="delete-record" data-id="<?php echo htmlspecialchars($row['id']); ?>" onclick="confirmDelete(event, this)">
                            <i class="fas fa-trash" title="Delete"></i>
                        </a>
                        <span>&nbsp;&nbsp;</span>
                        <a href="#" class="view-history" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                            <i class="fas fa-history" title="View History"></i>
                        </a>
                        <span>&nbsp;&nbsp;</span>
                        <a href="testexport1.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="export-record">
                            <i class="fas fa-file-export" title="Export"></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <ul class="pagination">
            <?php
            $queryParams = http_build_query([
                'search' => $search,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'submitted_by' => $submittedBy
            ]);
            if ($page > 1): ?>
                <li><a href="?page=<?php echo $page - 1 . '&' . $queryParams; ?>">Previous</a></li>
            <?php endif;
            for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="<?php echo $i == $page ? 'active' : ''; ?>"><a href="?page=<?php echo $i . '&' . $queryParams; ?>"><?php echo $i; ?></a></li>
            <?php endfor;
            if ($page < $totalPages): ?>
                <li><a href="?page=<?php echo $page + 1 . '&' . $queryParams; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>

    <!-- Modal for Viewing Record Details -->
    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Record Details</h5>
                    <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body (Scrollable) -->
                <div class="modal-body" id="modal-content">
                    <!-- Record details will be loaded here via AJAX -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- History Modal -->
    <div id="historyModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Activity History</h5>
                    <button type="button" class="close" aria-label="Close" onclick="closeHistoryModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body (Scrollable) -->
                <div class="modal-body" id="history-content" style="max-height: 400px; overflow-y: auto;">
                    <!-- Activity history details will load here via AJAX -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeHistoryModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

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

    // Confirm Delete Operation
    $(document).on('click', '.delete-record', function(event) {
        event.preventDefault();
        var recordId = $(this).data('id');

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
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: { id: recordId },
                    success: function(response) {
                        if (response.trim() === 'success') {
                            Swal.fire('Deleted!', 'The record has been deleted.', 'success')
                            .then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Unable to process the request.', 'error');
                    }
                });
            }
        });
    });

    // Close Modal
    $(document).on('click', '.close', function() {
        $('#myModal, #historyModal').fadeOut();
    });

    $(window).on('click', function(event) {
        if ($(event.target).is('#myModal, #historyModal')) {
            $(event.target).fadeOut();
        }
    });

    // Reset Form
    $('#reset-button').click(function(event) {
        event.preventDefault();
        $('#filter-form')[0].reset();
        window.location.href = 'testhistory.php';
    });

    // View History
    $(document).on('click', 'a.view-history', function(event) {
        event.preventDefault();
        var id = $(this).data('id');

        if (!id) {
            Swal.fire('Error', 'Record ID is missing.', 'error');
            return;
        }

        $.ajax({
            url: 'fetch_history.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                if (response.trim()) {
                    $('#history-content').html(response);
                    $('#historyModal').fadeIn();
                } else {
                    Swal.fire('Error', 'No history available for this record.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Unable to fetch history.', 'error');
            }
        });
    });
});

function closeModal() {
    $('#myModal').fadeOut(); // Hide modal using fade out effect
}
</script>
</body>

</html>
