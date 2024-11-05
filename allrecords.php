<?php
session_start();
require 'db.php';

// Get logged-in user's email
$userEmail = $_SESSION['email'] ?? '';

// Query to fetch the user's role from the database
$roleQuery = "SELECT role FROM users WHERE email = ?";
$stmt = $conn->prepare($roleQuery);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and get their role
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userRole = $row['role']; // Fetch the role of the current user
} else {
    // Handle case where user does not exist
    echo "User not found.";
    exit; // Stop execution if the user does not exist
}

// Check if the user is an admin
$isAdmin = ($userRole === 'Admin' || $userRole === 'Contracts'); // Use 'Admin' if that's the exact string in your database

// Check if the paperwork has been submitted (assumed via status check or similar condition)
$paperworkSubmitted = ($row['status'] !== 'initiated'); // If the status is anything other than 'initiated', assume it's submitted

// Initialize variables for search, date, submitted by, and status filters
$search = $_GET['search'] ?? '';
$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';
$submittedBy = $_GET['submitted_by'] ?? '';
$status = $_GET['status'] ?? ''; // New status filter

// Pagination logic
$recordsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// SQL to get filtered record count
$sqlCount = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE 1";

// Initialize arrays to store filter parameters
$paramsCount = [];
$bindTypesCount = '';

// Only show own records for non-admin users
if (!$isAdmin) { // Apply restriction for non-admin users
    $sqlCount .= " AND submittedby = ?";
    $paramsCount[] = $userEmail;
    $bindTypesCount .= 's';
}

// Apply search filter
if (!empty($search)) {
    $sqlCount .= " AND (cfirstname LIKE ? OR clastname LIKE ? OR cemail LIKE ? OR id LIKE ?)";
    $paramsCount[] = "%$search%";
    $paramsCount[] = "%$search%";
    $paramsCount[] = "%$search%";
    $paramsCount[] = "%$search%";
    $bindTypesCount .= 'ssss';
}

// Date range filter
if (!empty($startDate) && !empty($endDate)) {
    $sqlCount .= " AND DATE(created_at) BETWEEN ? AND ?";
    $paramsCount[] = $startDate;
    $paramsCount[] = $endDate;
    $bindTypesCount .= 'ss';
}

// Submitted by filter
if (!empty($submittedBy)) {
    $sqlCount .= " AND submittedby LIKE ?";
    $paramsCount[] = "%$submittedBy%";
    $bindTypesCount .= 's';
}

// Status filter
if (!empty($status)) {
    $sqlCount .= " AND status = ?";
    $paramsCount[] = $status;
    $bindTypesCount .= 's';
}

// Prepare the count statement
$stmtCount = $conn->prepare($sqlCount);
if (!empty($paramsCount)) {
    $stmtCount->bind_param($bindTypesCount, ...$paramsCount);
}
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalFilteredRecords = $resultCount->fetch_assoc()['total'];
$totalPages = ceil($totalFilteredRecords / $recordsPerPage);

// SQL to get records with pagination
$sql = "SELECT id, cfirstname, clastname, created_at, submittedby, status 
        FROM paperworkdetails 
        WHERE 1";

// Apply the same filters to the main query
$params = [];
$bindTypes = '';

if (!$isAdmin) { // Apply restriction for non-admin users
    $sql .= " AND submittedby = ?";
    $params[] = $userEmail;
    $bindTypes .= 's';
}

if (!empty($search)) {
    $sql .= " AND (cfirstname LIKE ? OR clastname LIKE ? OR cemail LIKE ? OR id LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $bindTypes .= 'ssss';
}

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
    $bindTypes .= 'ss';
}

if (!empty($submittedBy)) {
    $sql .= " AND submittedby LIKE ?";
    $params[] = "%$submittedBy%";
    $bindTypes .= 's';
}

if (!empty($status)) {
    $sql .= " AND status = ?";
    $params[] = $status;
    $bindTypes .= 's';
}

// Add pagination limit
$sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $recordsPerPage;
$params[] = $offset;
$bindTypes .= 'ii';

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($bindTypes, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VDart PMT</title>
    <link rel="icon" href="images.png" type="image/png">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="allrecordsstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
         /* ===== Google Font Import - Poppins ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
        /* Custom styles */
        .record-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .record-list-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: white;
            border-left: 5px solid #4ca1af;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .record-list-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .record-header {
            font-size: 1.5rem;
            color: #333;
        }

        .record-info p {
            margin: 5px 0;
            color: #555;
        }

        .record-footer a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .record-footer a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            background-color: #f1f3f4;
            color: #333;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }

        .pagination .active {
            background-color: #007BFF;
            color: white;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #4ca1af;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #357f80;
            transform: translateY(-2px);
        }

        input[type="text"],
        input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        .form-container {
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1300px;
            margin: 30px auto;
            display: flex;
            justify-content: space-between;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            align-items: center;
        }

        .form-group-inline {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .form-group-inline label {
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 14px;
            color: #333;
        }

        .form-group-inline input[type="text"],
        .form-group-inline input[type="date"] {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            width: 180px;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-color: #007BFF;
            outline: none;
        }

        .form-group-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-submit,
        .btn-reset {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.2s ease, transform 0.2s;
        }

        .btn-submit {
            background-color: #007BFF;
            color: white;
        }

        .btn-submit:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .btn-reset {
            background-color: #f5f5f5;
            color: #333;
        }

        .btn-reset:hover {
            background-color: #ddd;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        @media (max-width: 1200px) {
            .form-container {
                flex-wrap: wrap;
            }

            form {
                flex-direction: row;
                justify-content: space-between;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
            }

            .form-group-inline {
                width: 100%;
            }

            .form-group-buttons {
                justify-content: flex-start;
            }
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            list-style-type: none;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            padding: 10px 18px;
            border-radius: 30px;
            background: linear-gradient(135deg, #f1f3f4 0%, #e2e6ea 100%);
            color: #333;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
            transform: translateY(-3px);
            border-color: #007BFF;
        }

        .pagination .active .page-link {
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            color: white;
            pointer-events: none;
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
            border-color: #0056b3;
            transform: scale(1.05);
        }

        .pagination .prev-next {
            font-size: 16px;
            font-weight: 500;
        }

        .pagination .prev-next i {
            margin: 0 8px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .pagination .prev-next:hover i {
            transform: translateX(-3px);
        }

        .pagination .prev-next:hover {
            color: #007BFF;
        }

        @media (max-width: 768px) {
            .pagination .page-link {
                padding: 8px 15px;
                font-size: 14px;
            }

            .pagination .prev-next {
                font-size: 14px;
            }

            .pagination .page-link:hover {
                transform: translateY(-2px);
            }

            .pagination .prev-next i {
                font-size: 16px;
            }
        }


        .heading h2 {
            margin-top: 18px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .status-dropdown-container {
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Medium-dark color codes for different statuses */
        [data-status="initiated"] {
            background-color: #ffb74d; /* Darker orange */
            color: #ffffff; /* White text for contrast */
        }

        [data-status="in_progress"] {
            background-color: #64b5f6; /* Darker blue */
            color: #ffffff;
        }

        [data-status="completed"] {
            background-color: #4caf50; /* Medium-dark green */
            color: #ffffff;
        }

        [data-status="on_hold"] {
            background-color: #ffeb3b; /* Medium-dark yellow */
            color: #212121; /* Dark text for contrast */
        }

        [data-status="candidate_drop"] {
            background-color: #e53935; /* Dark red */
            color: #ffffff;
        }

        [data-status="client_drop"] {
            background-color: #ab47bc; /* Dark purple */
            color: #ffffff;
        }

        [data-status="hold"] {
            background-color: #ffa726; /* Darker orange */
            color: #ffffff;
        }

        [data-status="starts"] {
            background-color: #81c784; /* Medium-dark green */
            color: #ffffff;
        }

        [data-status="rehired"] {
            background-color: #81c784; /* Medium-dark green */
            color: #ffffff;
        }

        [data-status="project_extension"] {
            background-color: #81c784; /* Medium-dark green */
            color: #ffffff;
        }

        /* Custom select styling */
        .status-dropdown {
            width: 100%;
            padding: 12px 20px;
            border-radius: 12px;
            border: 2px solid #ccc;
            background-color: #fff;
            background-image: linear-gradient(to bottom, #fff, #f0f0f0); /* Subtle gradient */
            font-size: 16px;
            color: #333; /* Default color for text */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease; /* Smooth transition for hover/focus effects */
            appearance: none;
            cursor: pointer;
            position: relative;
            outline: none; /* Remove default outline */
        }

        /* Remove color differentiation for dropdown options */
        .status-dropdown option {
            color: #333; /* Same color for all options */
            background-color: #fff; /* White background for all options */
        }

        /* Custom hover and focus effect */
        .status-dropdown:hover,
        .status-dropdown:focus {
            border-color: #007bff; /* Blue border on hover/focus */
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.2); /* Enhanced shadow effect */
            background-image: linear-gradient(to bottom, #f9f9f9, #ececec); /* Light background change */
            transform: scale(1.02); /* Slight zoom on hover */
        }

        /* Custom arrow styling for select */
        .status-dropdown::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #007bff; /* Blue arrow */
            pointer-events: none;
            transform: translateY(-50%);
        }

        /* Smooth transitions for dropdown and option appearance */
        .status-dropdown {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
        }

        .status-dropdown:focus {
            transform: scale(1.05); /* Slight zoom effect on focus */
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
        }

        /* Enhance dropdown option transitions */
        .status-dropdown option {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Remove option hover effect (consistent look) */
        .status-dropdown option:hover {
            background-color: #fff; /* Keep the background white on hover */
            color: #333; /* Keep the text color consistent on hover */
        }


        .dashboard-heading {
    font-family: 'Poppins', sans-serif; /* Professional, modern font */
    font-size: 40px;
    font-weight: 600; /* Semi-bold for clear visibility without being too heavy */
    color: #2c3e50; /* Dark, professional color */
    margin: 0;
    transition: color 0.3s ease, transform 0.3s ease; /* Subtle hover effect */
}

.dashboard-heading:hover {
    color: #2980b9; /* Slight color change on hover */
    transform: translateY(-5px); /* Minimal hover lift */
}




    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon" style="display: flex; align-items: center;">
                            <img src="images.png" alt="VDart Logo" style="width: 40px; height: 40px; margin-right: 30px; margin-left: 16px">
                            <h3 style="margin: -9px;">VDart</h3>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="allrecords.php">
                        <span class="icon">
                            <ion-icon name="time-outline"></ion-icon>
                        </span>
                        <span class="title">View History</span>
                    </a>
                </li>

                <?php
                if($userRole === "Admin"):?>
                <li>
                    <a href="usermanagement.php" >
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="passwordsMenu">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Reset Passwords</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Help</span>
                    </a>
                </li>
                <?php
                 endif; ?>


                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="heading-container">
                    <h1 class="dashboard-heading" style="font-size: 30px;">All Records</h1>
                </div>

                <div class="user"></div>
            </div>

            <!-- ======================= Form ================== -->
            <div class="form-container">
                <form id="filter-form" method="GET" action="">
                    <div class="form-group-inline">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name">
                    </div>
                    <div class="form-group-inline">
                        <label for="start_date">From:</label>
                        <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
                    </div>
                    <div class="form-group-inline">
                        <label for="end_date">To:</label>
                        <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
                    </div>
                    <div class="form-group-inline">
                        <label for="submitted_by">Submitted By:</label>
                        <input type="text" name="submitted_by" value="<?php echo htmlspecialchars($submittedBy); ?>">
                    </div>

                    <div class="form-group-inline">
                        <label for="statusFilter" style="margin-right: 10px;">Filter by Status:</label>
                        <select name="status" id="statusFilter" onchange="this.form.submit()" style="width: 100%; padding: 5px; font-size: 14px;">
                            <option value="">All Statuses</option>
                            <option value="initiated" <?php if (isset($_GET['status']) && $_GET['status'] == 'initiated') echo 'selected'; ?>>Initiated</option>
                            <option value="in_progress" <?php if (isset($_GET['status']) && $_GET['status'] == 'in_progress') echo 'selected'; ?>>Offer Letter Sent</option>
                            <option value="completed" <?php if (isset($_GET['status']) && $_GET['status'] == 'completed') echo 'selected'; ?>>Offer Accepted</option>
                            <option value="on_hold" <?php if (isset($_GET['status']) && $_GET['status'] == 'on_hold') echo 'selected'; ?>>Background Check</option>
                            <option value="candidate_drop" <?php if (isset($_GET['status']) && $_GET['status'] == 'candidate_drop') echo 'selected'; ?>>Candidate Drop</option>
                            <option value="client_drop" <?php if (isset($_GET['status']) && $_GET['status'] == 'client_drop') echo 'selected'; ?>>Client Drop</option>
                            <option value="hold" <?php if (isset($_GET['status']) && $_GET['status'] == 'hold') echo 'selected'; ?>>Hold</option>
                            <option value="starts" <?php if (isset($_GET['status']) && $_GET['status'] == 'starts') echo 'selected'; ?>>Starts</option>
                            <option value="starts" <?php if (isset($_GET['status']) && $_GET['status'] == 'rehired') echo 'selected'; ?>>Rehired</option>
                            <option value="starts" <?php if (isset($_GET['status']) && $_GET['status'] == 'project_extension') echo 'selected'; ?>>Project Extension</option>
                        </select>
                    </div>

                    <div class="form-group-buttons">
                        <button type="submit" class="btn-submit">Go</button>
                        <button type="reset" id="reset-button" class="btn-reset">Reset</button>
                    </div>
                </form>
            </div>

            <!-- Records List -->
            <?php if ($result->num_rows > 0): ?>
                <div class="record-container">

                <?php if($userRole === "Admin" || $userRole === "Contracts") : ?>
                    <div class="action-buttons" id="action-buttons" style="display: none;">
                        <!-- Export button for both Admin and Contracts -->
                        <button id="bulk-export" class="btn-export" onclick="bulkExport()">Export Selected</button>

                        <!-- Delete button only for Admin -->
                        <?php if($userRole === "Admin"){ ?>
                            <button id="bulk-delete" class="btn-delete" onclick="bulkDelete()">Delete Selected</button>
                        <?php } ?>
                    </div>
                <?php endif; ?>


                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="record-list-item" style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #ccc;">

                        <?php if($userRole === 'Admin' || $userRole === 'Contracts'):?>

                            <!-- Checkbox for selecting record -->
                            <div style="flex: 0 0 30px;">
                                <input type="checkbox" class="record-checkbox" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                            </div>

                        <?php endif; ?>

                            <!-- Candidate Name -->
                            <div class="record-header" style="flex: 1; max-width: 20%;">
                                <strong><?php echo htmlspecialchars($row['cfirstname'] . ' ' . $row['clastname'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            </div>

                            <!-- Submitted By -->
                            <div class="record-info" style="flex: 1; max-width: 20%;">
                                <p style="margin: 0;">Submitted By: <?php echo htmlspecialchars($row['submittedby'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="status-dropdown-container" style="flex: 1; max-width: 20%;" data-status="<?php echo $row['status']; ?>">
                                <select class="status-dropdown" data-id="<?php echo $row['id']; ?>" style="width: 100%; padding: 5px; font-size: 14px;" <?php if (!$isAdmin) echo 'disabled'; ?>>
                                    <option value="initiated" <?php if ($row['status'] == 'initiated') echo 'selected'; ?>>Initiated</option>
                                    <option value="in_progress" <?php if ($row['status'] == 'in_progress') echo 'selected'; ?>>Offer Letter Sent</option>
                                    <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Offer Accepted</option>
                                    <option value="on_hold" <?php if ($row['status'] == 'on_hold') echo 'selected'; ?>>Background Check</option>
                                    <option value="candidate_drop" <?php if ($row['status'] == 'candidate_drop') echo 'selected'; ?>>Candidate Drop</option>
                                    <option value="client_drop" <?php if ($row['status'] == 'client_drop') echo 'selected'; ?>>Client Drop</option>
                                    <option value="hold" <?php if ($row['status'] == 'hold') echo 'selected'; ?>>Hold</option>
                                    <option value="starts" <?php if ($row['status'] == 'starts') echo 'selected'; ?>>Starts</option>
                                    <option value="rehired" <?php if ($row['status'] == 'rehired') echo 'selected'; ?>>Rehired</option>
                                    <option value="project_extension" <?php if ($row['status'] == 'project_extension') echo 'selected'; ?>>Project Extension</option>

                                </select>
                            </div>



                            <!-- Action Buttons -->
                            <div class="record-footer" style="flex: 1; max-width: 20%; text-align: right;">
                                
                            <?php
                            // // Debug output to check values
                            // echo "User Role: " . $userRole . "<br>";
                            // echo "Status: " . $row['status'] . "<br>";
                            // echo "Is Admin: " . ($isAdmin ? 'Yes' : 'No') . "<br>";
                            // echo "Paperwork Submitted: " . ($paperworkSubmitted ? 'Yes' : 'No') . "<br>";

                            // Show the icon only if conditions are met
                            if ($isAdmin || (!$isAdmin && !$paperworkSubmitted)) : ?>
                                <a href="paperworkedit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="edit-record" style="margin-right: 10px;">
                                    <i class="fas fa-eye" title="Edit"></i>
                                </a>
                            <?php endif; ?>


                                <?php if ($userRole === "Admin") : ?>
                                    <!-- Other actions (Delete, View History, Export) -->
                                    <a href="#" class="delete-record" data-id="<?php echo htmlspecialchars($row['id']); ?>" onclick="confirmDelete(event, this)" style="margin-right: 10px;">
                                        <i class="fas fa-trash" title="Delete"></i>
                                    </a>
                                <?php endif; ?>

                                <a href="#" class="view-history" data-id="<?php echo htmlspecialchars($row['id']); ?>" style="margin-right: 10px;">
                                    <i class="fas fa-history" title="View History"></i>
                                </a>

                                <?php if($userRole === 'Admin' || $userRole === 'Contracts') : ?>
                                    <a href="testexport1.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="export-record">
                                        <i class="fas fa-file-export" title="Export"></i>
                                    </a>
                                <?php endif; ?>


                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Status Change Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropdowns = document.querySelectorAll('.status-dropdown');

                        // Function to update the container's background color based on the selected status
                        function updateBackgroundColor(dropdown) {
                            const selectedStatus = dropdown.value;
                            const container = dropdown.closest('.status-dropdown-container');

                            // Update the data-status attribute to match the selected value
                            container.setAttribute('data-status', selectedStatus);

                            // Optionally, you can perform an AJAX request here to save the updated status to the server
                            const recordId = dropdown.getAttribute('data-id');
                            console.log(`Record ID: ${recordId} - Status changed to: ${selectedStatus}`);

                            // Implement your AJAX call here if necessary
                            // For example:
                            // fetch('update_status.php', {
                            //     method: 'POST',
                            //     body: JSON.stringify({ id: recordId, status: selectedStatus })
                            // }).then(response => response.json()).then(data => {
                            //     console.log(data);
                            // });
                        }

                        // Add event listeners to all dropdowns
                        dropdowns.forEach(dropdown => {
                            dropdown.addEventListener('change', function() {
                                updateBackgroundColor(this);
                            });

                            // Set the initial background color when the page loads
                            updateBackgroundColor(dropdown);
                        });
                    });
                </script>

                <!-- Pagination -->
                <div class="pagination">
                    <?php 
                        // Build the query string with the filter parameters to preserve them across pagination
                        $queryParams = http_build_query([
                            'search' => $search,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'submitted_by' => $submittedBy
                        ]);
                    ?>

                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&<?php echo $queryParams; ?>">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&<?php echo $queryParams; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&<?php echo $queryParams; ?>">Next</a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p>No records found.</p>
            <?php endif; ?>
        </div>

        <script>
           $(document).ready(function () {
    // Listen for status dropdown change
    $(document).on('change', '.status-dropdown', function () {
        var recordId = $(this).data('id'); // Record ID associated with the dropdown
        var newStatus = $(this).val(); // New status value from the dropdown
        var previousStatus = $(this).closest('.status-dropdown-container').data('status'); // Previous status

        // If 'Candidate Drop' is selected, ask for a reason
        if (newStatus === 'candidate_drop') {
            Swal.fire({
                title: 'Reason for Candidate Drop',
                input: 'textarea',
                inputPlaceholder: 'Enter the reason for candidate drop...',
                inputAttributes: {
                    'aria-label': 'Reason for candidate drop'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('You need to provide a reason');
                        return false; // Prevent the form from submitting if reason is not provided
                    }
                    return reason; // Pass the reason to the next step
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var reason = result.value; // Get the reason from the user's input

                    // Show loading indicator
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while the status is being updated.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to update status along with the reason
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            id: recordId,
                            status: newStatus,
                            reason: reason // Send the reason along with the status
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page after the status is updated
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to update status.', 'error');
                                $(this).val(previousStatus); // Reset to previous status on failure
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.close();
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to update status.', 'error');
                            $(this).val(previousStatus); // Reset to previous status on failure
                        }
                    });
                } else {
                    // Reset dropdown to previous value if action is cancelled
                    $(this).val(previousStatus);
                }
            });
        }
        // If 'Client Drop' is selected, ask for a reason
        else if (newStatus === 'client_drop') {
            Swal.fire({
                title: 'Reason for Client Drop',
                input: 'textarea',
                inputPlaceholder: 'Enter the reason for client drop...',
                inputAttributes: {
                    'aria-label': 'Reason for client drop'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('You need to provide a reason');
                        return false; // Prevent the form from submitting if reason is not provided
                    }
                    return reason; // Pass the reason to the next step
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var reason = result.value; // Get the reason from the user's input

                    // Show loading indicator
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while the status is being updated.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to update status along with the reason
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            id: recordId,
                            status: newStatus,
                            reason: reason // Send the reason along with the status
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page after the status is updated
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to update status.', 'error');
                                $(this).val(previousStatus); // Reset to previous status on failure
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.close();
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to update status.', 'error');
                            $(this).val(previousStatus); // Reset to previous status on failure
                        }
                    });
                } else {
                    // Reset dropdown to previous value if action is cancelled
                    $(this).val(previousStatus);
                }
            });
        }
        // If 'Starts' is selected, ask for a start date
        else if (newStatus === 'starts') {
            Swal.fire({
                title: 'Enter Start Date',
                input: 'date', // Use the 'date' input type for a date picker
                inputAttributes: {
                    'aria-label': 'Start date'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (startDate) => {
                    if (!startDate) {
                        Swal.showValidationMessage('You need to provide a valid start date');
                        return false; // Prevent the form from submitting if the date is invalid
                    }
                    // Format the date from YYYY-MM-DD to m-d-y
                    const dateParts = startDate.split('-');
                    const formattedDate = `${dateParts[1]}-${dateParts[2]}-${dateParts[0]}`; // m-d-y format
                    return formattedDate; // Pass the formatted start date to the next step
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var startDate = result.value; // Get the start date from the user's input

                    // Show loading indicator
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while the status is being updated.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to update status along with the start date
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            id: recordId,
                            status: newStatus,
                            start_date: startDate // Send the start date along with the status
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page after the status is updated
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to update status.', 'error');
                                $(this).val(previousStatus); // Reset to previous status on failure
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.close();
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to update status.', 'error');
                            $(this).val(previousStatus); // Reset to previous status on failure
                        }
                    });
                } else {
                    // Reset dropdown to previous value if action is cancelled
                    $(this).val(previousStatus);
                }
            });
        }
        // If 'Rehired' is selected, ask for a reason
        else if (newStatus === 'rehired') {
            Swal.fire({
                title: 'Reason for Rehire',
                input: 'textarea',
                inputPlaceholder: 'Enter the reason for rehire...',
                inputAttributes: {
                    'aria-label': 'Reason for rehire'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('You need to provide a reason');
                        return false; // Prevent the form from submitting if reason is not provided
                    }
                    return reason; // Pass the reason to the next step
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var reason = result.value; // Get the reason from the user's input

                    // Show loading indicator
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while the status is being updated.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to update status along with the reason
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            id: recordId,
                            status: newStatus,
                            reason: reason // Send the reason along with the status
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page after the status is updated
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to update status.', 'error');
                                $(this).val(previousStatus); // Reset to previous status on failure
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.close();
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to update status.', 'error');
                            $(this).val(previousStatus); // Reset to previous status on failure
                        }
                    });
                } else {
                    // Reset dropdown to previous value if action is cancelled
                    $(this).val(previousStatus);
                }
            });
        }
        // If 'Project Extension' is selected, ask for a reason
        else if (newStatus === 'project_extension') {
            Swal.fire({
                title: 'Reason for Project Extension',
                input: 'textarea',
                inputPlaceholder: 'Enter the reason for project extension...',
                inputAttributes: {
                    'aria-label': 'Reason for project extension'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('You need to provide a reason');
                        return false; // Prevent the form from submitting if reason is not provided
                    }
                    return reason; // Pass the reason to the next step
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var reason = result.value; // Get the reason from the user's input

                    // Show loading indicator
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while the status is being updated.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request to update status along with the reason
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            id: recordId,
                            status: newStatus,
                            reason: reason // Send the reason along with the status
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page after the status is updated
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire('Error', 'Failed to update status.', 'error');
                                $(this).val(previousStatus); // Reset to previous status on failure
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.close();
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to update status.', 'error');
                            $(this).val(previousStatus); // Reset to previous status on failure
                        }
                    });
                } else {
                    // Reset dropdown to previous value if action is cancelled
                    $(this).val(previousStatus);
                }
            });
        }
        else {
            // For other statuses, update without asking for a reason
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while the status is being updated.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX request to update status (no reason required)
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: {
                    id: recordId,
                    status: newStatus
                },
                success: function (response) {
                    Swal.close();
                    if (response.trim() === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Status updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Refresh the page after the status is updated
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Error', 'Failed to update status.', 'error');
                        $(this).val(previousStatus); // Reset to previous status on failure
                    }
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    console.log('Error:', xhr.responseText);
                    Swal.fire('Error', 'Unable to update status.', 'error');
                    $(this).val(previousStatus); // Reset to previous status on failure
                }
            });
        }
    });


        // Modal handling for history
        function showModal() {
            $('#historyModal').addClass('show').fadeIn(300);
        }

        function closeModal() {
            $('#historyModal').fadeOut(300, function () {
                $('#historyModal').removeClass('show');
            });
        }

        $(document).on('click', 'a.view-history', function (event) {
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
                success: function (response) {
                    if (response.trim()) {
                        $('#history-content').html(response);
                        showModal();
                    } else {
                        Swal.fire('Error', 'No history available for this record.', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire('Error', 'Unable to fetch history.', 'error');
                }
            });
        });

        // Close modal
        $(document).on('click', '.close', function () {
            closeModal();
        });

        $(window).on('click', function (event) {
            if ($(event.target).is('#historyModal')) {
                closeModal();
            }
        });

        // Reset Filter Form
        $('#reset-button').click(function (event) {
            event.preventDefault();
            $('#filter-form')[0].reset();
            window.location.href = 'allrecords.php';
        });

        // Delete record functionality
        $(document).on('click', '.delete-record', function (event) {
            event.preventDefault();
            var recordId = $(this).data('id');

            if (!recordId) {
                Swal.fire('Error', 'Record ID is missing.', 'error');
                return;
            }

            // Confirmation before deletion
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion
                    $.ajax({
                        url: 'delete.php', // Make sure you have this server-side script to handle deletion
                        type: 'POST',
                        data: {
                            id: recordId
                        },
                        success: function (response) {
                            if (response.trim() === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Refresh the page or remove the record from the DOM
                                    window.location.reload(); // Refresh the page after deletion
                                });
                            } else {
                                Swal.fire('Error', 'Failed to delete the record.', 'error');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('Error:', xhr.responseText);
                            Swal.fire('Error', 'Unable to delete the record.', 'error');
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'error');
                }
            });
        });
    });
</script>


        <div id="historyModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2 class="modal-title">History Details</h2>
                    <div id="history-content">
                        <!-- History content will be populated here -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End of Main -->

    <script>
        $(document).ready(function () {
            // Handle click event on "View History" button
            $(document).on('click', '.view-history', function (event) {
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
                    success: function (response) {
                        if (response.trim()) {
                            $('#history-content').html(response);
                            $('#historyModal').fadeIn();
                        } else {
                            Swal.fire('Error', 'No history available for this record.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Unable to fetch history.', 'error');
                    }
                });
            });

            // Close modal when clicking the close button or outside the modal content
            $(document).on('click', '.close', function () {
                $('#historyModal').fadeOut();
            });

            $(window).on('click', function (event) {
                if ($(event.target).is('#historyModal')) {
                    $('#historyModal').fadeOut();
                }
            });
        });
    </script>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        // add hovered class to selected list item
        let list = document.querySelectorAll(".navigation li");

        function activeLink() {
            list.forEach((item) => {
                item.classList.remove("hovered");
            });
            this.classList.add("hovered");
        }

        list.forEach((item) => item.addEventListener("mouseover", activeLink));

        // Menu Toggle
        let toggle = document.querySelector(".toggle");
        let navigation = document.querySelector(".navigation");
        let main = document.querySelector(".main");

        toggle.onclick = function () {
            navigation.classList.toggle("active");
            main.classList.toggle("active");
        };

        // Reset Form
        $('#reset-button').click(function (event) {
            event.preventDefault();
            $('#filter-form')[0].reset();
            window.location.href = 'allrecords.php';
        });
    </script>




    <style>
        /* Modal overlay */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
            overflow: hidden; /* Prevent body scrolling */
        }

        /* Modal dialog */
        .modal-dialog {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80vh; /* Ensure the modal doesn't go beyond the viewport */
            overflow: hidden; /* Prevent content overflow */
        }

        /* Scrollable content inside the modal */
        #history-content {
            max-height: 400px; /* Adjust based on how much content you want to show */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds the height */
            padding: 10px;
            border: 1px solid #ddd; /* Optional: Add a border to the content area */
            background-color: #f9f9f9; /* Optional: Light background color */
        }

        /* Close button */
        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }
    </style>

<script>
    $(document).ready(function() {
    // Handle record checkbox selection
    $(document).on('change', '.record-checkbox', function() {
        const selectedIds = getSelectedRecords();

        if (selectedIds.length > 0) {
            $('#action-buttons').fadeIn(); // Show the action buttons if any records are selected
        } else {
            $('#action-buttons').fadeOut(); // Hide the action buttons if no records are selected
        }
    });

    // Get selected record IDs
    function getSelectedRecords() {
        const selectedRecords = [];
        $('.record-checkbox:checked').each(function() {
            selectedRecords.push($(this).data('id'));
        });
        return selectedRecords;
    }

    // Handle bulk delete
    function bulkDelete() {
        const selectedIds = getSelectedRecords();

        if (selectedIds.length === 0) {
            Swal.fire('Error', 'No records selected.', 'error');
            return;
        }

        // Confirm deletion
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action will delete the selected records.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform delete action via AJAX
                $.ajax({
                    url: 'bulk_delete.php',
                    type: 'POST',
                    data: { ids: selectedIds },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire('Deleted!', 'Selected records have been deleted.', 'success')
                                .then(() => window.location.reload()); // Reload the page after successful deletion
                        } else {
                            Swal.fire('Error', 'Failed to delete the selected records.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Unable to delete the selected records.', 'error');
                    }
                });
            }
        });
    }

    // Handle bulk export
    function bulkExport() {
        const selectedIds = getSelectedRecords();

        if (selectedIds.length === 0) {
            Swal.fire('Error', 'No records selected.', 'error');
            return;
        }

        // Export selected records (could trigger a download, send to another page, etc.)
        window.location.href = 'bulk_export.php?ids=' + selectedIds.join(',');
    }

    // Expose the functions globally for use in buttons
    window.bulkDelete = bulkDelete;
    window.bulkExport = bulkExport;
});
</script>

</body>

</html>
