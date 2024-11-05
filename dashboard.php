
<?php
require 'db.php'; // Include your database connection
session_start(); // Ensure the session is started
// $currentUserEmail = $_SESSION['email'];

if (!isset($_SESSION['email'])) {
    header("Location: paperworklogin.php"); // Redirect if not logged in
    exit();
}

// Define the admin email(s)
// $adminEmail = "saranraj.s@vdartinc.com"; // Replace with the actual admin email address

// Get the user's email from the session, or set to an empty string if not set
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

// Check if the user is an admin or has Contracts role
$isAdmin = ($userRole === 'Admin' || $userRole === 'Contracts'); // Use 'Admin' and 'Contracts' for role check


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
    <link rel="stylesheet" href="dashboardstyles.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
    /* ===== Google Font Import - Poppins ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
    .recentCustomers {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
    }

    table th, table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    h4 {
        font-size: 16px;
        margin: 0;
        text-align: center;
    }

    .imgBx span {
        font-size: 18px;
        font-weight: bold;
        display: inline-block;
        width: 100%;
        text-align: center;
    }

    .widget {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 130%;
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .widgetContent {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .widgetContent h4 {
        font-size: 18px;
        margin-top: 10px;
        font-weight: bold;
        color: #007bff;
    }

    /* Modal Background Blur Effect */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
    }

    /* Modal Content Box */
    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 10px;
        width: 30%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    /* Close Button Style */
    .close-button {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-button:hover,
    .close-button:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Form Elements Styling */
    .modal-content h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        margin-top: 10px;
        display: block;
        font-weight: bold;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Blur effect for the background */
    .blur-background {
        filter: blur(5px);
        transition: filter 0.3s ease;
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

/* Animation for the view details link */
.view-details {
    text-decoration: none;
    color: #007bff; /* Default link color */
    transition: color 0.3s ease, transform 0.3s ease; /* Smooth transition for color and transform */
}

.view-details:hover {
    color: #fff; /* Darker color on hover */
    transform: translateY(-3px); /* Slight lift effect on hover */
    /* Optionally add a subtle box shadow */
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2); /* Shadow effect */
}

/* Keyframe animation for initial appearance */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Applying the fadeIn animation to the link when it is loaded */
.view-details {
    animation: fadeIn 0.5s ease forwards; /* Animation on page load */
}




</style>

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
                    <a href="paperworkallrecords.php">
                        <span class="icon">
                            <ion-icon name="time-outline"></ion-icon>
                        </span>
                        <span class="title">View History</span>
                    </a>
                </li>
                <?php
                if($userRole === "Admin"){
                    ?>
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
                }?>
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
        <!-- User Modal -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close-button" id="closeUserModal">&times;</span>
                <h2>Create a New User</h2>
                <form id="createUserForm" action="newuser.php" method="POST">
                    <label for="userName">Name:</label>
                    <input type="text" id="userName" name="name" required>
                    
                    <label for="userEmail">Email:</label>
                    <input type="email" id="userEmail" name="email" required>
                    
                    <label for="userPassword">Password:</label>
                    <input type="password" id="userPassword" name="password" required>
                    
                    <button type="submit">Create User</button>
                </form>
            </div>
        </div>

       
                    
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                
                <div class="heading-container">
                    <h1 class="dashboard-heading" style="font-size: 30px;">Paperwork Dashboard</h1>
                </div>




                <div class="widget">
                    <div class="widgetContent">
                        <br><br>
                        <a href="addpaperwork.php">
                            <lottie-player src="https://lottie.host/a357b23c-28d5-478c-b43a-1040d1cb0e0e/UYBBvi1mKq.json" background="transparent" speed="1" style="width: 75px; height: 70px;" loop autoplay></lottie-player>
                        </a>
                        <h4>Add Paperwork</h4>
                    </div>
                </div>
            </div>



            
            <!-- ======================= Cards ================== -->
             <?php
            // Adjust queries based on whether the user is an admin or not
if ($userRole === 'Admin' || $userRole === 'Contracts') {
    // Admin can see all records
    $totalPaperworksQuery = "SELECT COUNT(*) AS total FROM paperworkdetails";
    $totalDealsQuery = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE type = 'Deal'";
    $combinedPTPTRQuery = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE type IN ('PT', 'PTR')";
} else {
    // Non-admin users can only see their own records
    $totalPaperworksQuery = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE submittedby = '$userEmail'";
    $totalDealsQuery = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE type = 'Deal' AND submittedby = '$userEmail'";
    $combinedPTPTRQuery = "SELECT COUNT(*) AS total FROM paperworkdetails WHERE type IN ('PT', 'PTR') AND submittedby = '$userEmail'";
}

// Execute queries
$totalPaperworksResult = $conn->query($totalPaperworksQuery);
$totalPaperworks = $totalPaperworksResult->fetch_assoc()['total'];

$dealResult = $conn->query($totalDealsQuery);
$totalDeals = $dealResult->fetch_assoc()['total'];

$combinedPTPTRResult = $conn->query($combinedPTPTRQuery);
$combinedTotal = $combinedPTPTRResult->fetch_assoc()['total'];
?>

<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers"><?php echo $totalPaperworks; ?></div>
            <div class="cardName">Overall Paperworks Created</div>
        </div>
        <div class="iconBx">
            <ion-icon name="eye-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $totalDeals; ?></div>
            <div class="cardName">Deals</div>
        </div>
        <div class="iconBx">
            <ion-icon name="briefcase-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $combinedTotal; ?></div>
            <div class="cardName">PT / PTR</div>
        </div>
        <div class="iconBx">
            <ion-icon name="clipboard-outline"></ion-icon>
        </div>
    </div>
</div>


<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Container for Candidate Information and Buttons -->
<div id="candidateContainer" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin: 20px; display: none; background-color: #f9f9f9; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h3 style="margin: 0;">Draft Information:</h3>
        <p id="candidateInfo" style="margin: 0;"></p>
    </div>

    <!-- Buttons for actions -->
    <div>
        <button id="continueButton" onclick="confirmContinue()" style="margin-left: 10px;">
            Continue with Saved Data
        </button>
        <button id="deleteButton" onclick="confirmDelete()" style="margin-left: 10px;">
            Delete Saved Data
        </button>
    </div>
</div>

<!-- CSS for button animation -->
<style>
    button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    button:active {
        transform: scale(0.95);
    }
</style>

<!-- JavaScript for displaying the continue button if there's saved data -->
<script>
    window.addEventListener('load', function () {
        const savedData = localStorage.getItem('savedFormData');
        if (savedData) {
            const data = JSON.parse(savedData); // Parse the saved JSON data
            document.getElementById('continueButton').style.display = 'inline-block';
            document.getElementById('candidateInfo').innerText = `Name : ${data.cfirst_name} ${data.clast_name} | Email : ${data.cemail}`;
            document.getElementById('candidateContainer').style.display = 'flex'; // Show the container
        }
    });

    // Confirm Continue action with SweetAlert
    function confirmContinue() {
        Swal.fire({
            title: 'Continue with Saved Data?',
            text: "Are you sure you want to continue with the saved data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the addpaperwork.php page
                window.location.href = 'addpaperwork.php';
            }
        });
    }

    // Confirm Delete action with SweetAlert
    function confirmDelete() {
        Swal.fire({
            title: 'Delete Saved Data?',
            text: "Are you sure you want to delete all saved data? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteSavedData();
            }
        });
    }

    // Function to clear saved data and reload the current page
    function deleteSavedData() {
        // Clear saved form data from local storage
        localStorage.removeItem('savedFormData');

        // Notify the user that the data has been cleared
        Swal.fire({
            title: 'Data Cleared!',
            text: 'All previous data has been cleared.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            // Reload the current page
            location.reload();
        });
    }
</script>








<!-- ================ Order Details List ================= -->
<?php
// Initialize variables for pagination
$limit = 10; // Number of records to display per page

// Check if the current user is the admin
if ($userRole === 'Admin' || $userRole === 'Contracts') {
    // Admin can see all records
    $recentPaperworksQuery = "SELECT id, CONCAT(cfirstname, ' ', clastname) AS full_name, client, business_unit, created_at, submittedby
                              FROM paperworkdetails
                              ORDER BY created_at DESC LIMIT $limit";
} else {
    // Non-admin users can only see their own records
    $recentPaperworksQuery = "SELECT id, CONCAT(cfirstname, ' ', clastname) AS full_name, client, business_unit, created_at, submittedby
                              FROM paperworkdetails
                              WHERE submittedby = '$userEmail'
                              ORDER BY created_at DESC LIMIT $limit";
}

$recentPaperworksResult = $conn->query($recentPaperworksQuery);
?>

<div class="recentCustomers">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Recent Paperworks</h2>
        </div>
        <br>

        <!-- Displaying recent paperworks in a table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Candidate Name</th>
                    <th>Client</th>
                    <th>Business Unit</th>
                    <th>Date Submitted</th>
                    <th>Submitted By</th>
                    <th>Actions</th> <!-- Added Actions Column -->
                </tr>
            </thead>
            <tbody>
                <?php if ($recentPaperworksResult->num_rows > 0): ?>
                    <?php while ($paperwork = $recentPaperworksResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paperwork['id']); ?></td>
                        <td><?php echo htmlspecialchars($paperwork['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($paperwork['client']); ?></td>
                        <td><?php echo htmlspecialchars($paperwork['business_unit']); ?></td>
                        <td><?php echo htmlspecialchars(date('M-d-y', strtotime($paperwork['created_at']))); ?></td>
                        <td><?php echo htmlspecialchars($paperwork['submittedby']); ?></td>
                        <td>
                            <!-- View Details Link with data-id -->
                            <a href="#" class="view-details" data-id="<?php echo htmlspecialchars($paperwork['id']); ?>" title="View Details">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No records found</td> <!-- Updated colspan for the new Actions column -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal Structure -->
        <div id="myModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center; ">
            <div class="modal-content" id="modal-content" style=" margin-top:20px; background-color:#fff; padding:20px; border-radius:8px; width:500px; max-height:80%; overflow-y:auto; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
                <!-- Fetched content will be injected here -->
            </div>
        </div>


    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    // Close modal when clicking outside the modal content
    $(document).on('click', '#myModal', function(event) {
        if (event.target.id === 'myModal') {
            $('#myModal').fadeOut(); // Close modal with fade out effect
        }
    });
});
</script>




            <!-- ================ Recent Users ================= -->
<?php

            
            // Only run the query if the current user is an admin
if ($userRole === "Admin") {
    $recentUsersQuery = "SELECT id, name, email, password FROM users ORDER BY id DESC LIMIT 8";
    $recentUsersResult = $conn->query($recentUsersQuery);
?>
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Recent Users</h2>
        </div>
        <br>

        <?php $serialNumber = 1; ?>
        <table>
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $recentUsersResult->fetch_assoc()): ?>
                <tr>
                    <td width="60px">
                        <div class="imgBx">
                            <span><?php echo $serialNumber++; ?></span>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span id="password_<?php echo $user['id']; ?>" class="password" style="font-family: monospace;">
                            <?php echo str_repeat('*', strlen($user['password'])); ?>
                        </span>
                        <button type="button" onclick="togglePassword(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['password']); ?>')" style="border: none; background: none; cursor: pointer;">
                            <i class="fas fa-eye" id="eye_<?php echo $user['id']; ?>"></i>
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php
} else {
    // If not admin, show a message or nothing
    // echo "<p>You do not have permission to view this data.</p>";
}
?>
        </div>
    </div>


     <!-- Password Reset Popup Modal -->
<div id="popup" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closePopup()">&times;</span>
        <h2>Reset Password</h2>
        <form id="forgotPasswordForm" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="new_password" placeholder="Enter new password" required>
            
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>


    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- JavaScript for Password Toggle -->
    <script>
        function togglePassword(id, password) {
            const passwordSpan = document.getElementById(`password_${id}`);
            const eyeIcon = document.getElementById(`eye_${id}`);

            if (passwordSpan.textContent.includes('*')) {
                passwordSpan.textContent = password;
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordSpan.textContent = '*'.repeat(password.length);
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- JavaScript for Modal Handling -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("userModal");
            const openModalBtn = document.getElementById("createUserButton");
            const closeModalBtn = document.getElementById("closeUserModal");
            const createUserForm = document.getElementById("createUserForm");

            openModalBtn.addEventListener("click", function () {
                modal.style.display = "block";
            });

            closeModalBtn.addEventListener("click", function () {
                modal.style.display = "none";
            });

            window.addEventListener("click", function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });

            createUserForm.addEventListener("submit", function (event) {
                event.preventDefault();

                const formData = new FormData(createUserForm);

                fetch('newuser.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        modal.style.display = "none";
                        createUserForm.reset();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error creating user. Please try again.');
                    console.error('Error:', error);
                });
            });
        });
    </script>

    <!-- JavaScript for Password Reset Popup -->
    <script>
        function showPopup() {
            document.getElementById("popup").style.display = "flex";
            document.getElementById("content").classList.add("blur-background");
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("content").classList.remove("blur-background");
        }

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('forgotPasswordForm');
            var passwordsMenu = document.getElementById('passwordsMenu');

            passwordsMenu.addEventListener('click', function(event) {
                event.preventDefault();
                showPopup();
            });

            if (form) {
                form.onsubmit = function(event) {
                    event.preventDefault();

                    var email = document.getElementById('email').value;
                    var newPassword = document.getElementById('newPassword').value;

                    if (email === "" || newPassword === "") {
                        alert("Both fields are required.");
                        return;
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'reset_password.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            closePopup();
                        } else {
                            alert("An error occurred. Please try again.");
                        }
                    };

                    xhr.onerror = function() {
                        alert("Request failed. Please check your network connection.");
                    };

                    xhr.send('email=' + encodeURIComponent(email) + '&new_password=' + encodeURIComponent(newPassword));
                };
            }

            var popup = document.getElementById('popup');
            popup.addEventListener('click', function(event) {
                if (event.target === popup) {
                    closePopup();
                }
            });
        });
    </script>




    <script>
        // Get all list items in the navigation
let list = document.querySelectorAll(".navigation li");

// Function to add the hovered class
function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

// Function to remove the hovered class when the cursor leaves
function removeHover() {
  this.classList.remove("hovered");
}

// Add mouseover and mouseout event listeners to each list item
list.forEach((item) => {
  item.addEventListener("mouseover", activeLink); // Add hover effect
  item.addEventListener("mouseout", removeHover); // Remove hover effect
});

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

</script>

<script>
    let inactivityTime = function () {
        let time;
        // Reset the timer on user activity
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.ontouchstart = resetTimer; // For mobile

        // Capture form data before logging out
        function captureFormData() {
            const formData = {}; // Initialize an object to store form data
            const inputs = document.querySelectorAll('input, textarea, select'); // Select form elements
            
            inputs.forEach(input => {
                formData[input.name] = input.value; // Store input name and value in the object
            });
            
            // Send the form data to the server using AJAX
            fetch('save_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Form data saved:', data);
            })
            .catch(error => {
                console.error('Error saving form data:', error);
            });
        }

        function logout() {
            captureFormData(); // Save data before logging out
            alert("You have been logged out due to inactivity.");
            // Redirect to the logout or home page
            window.location.href = 'logout.php'; // Update this URL for your actual logout page
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(() => {
                captureFormData(); // Capture form data when inactivity timeout is reached
                Swal.fire({
                    title: 'Session Timeout',
                    text: 'You will be logged out in 60 seconds due to inactivity.',
                    timer: 60000, // 1 minute (60 seconds)
                    timerProgressBar: true,
                    confirmButtonText: 'Stay Logged In',
                    showCancelButton: true,
                    cancelButtonText: 'Log Out',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reset timer if the user clicks 'Stay Logged In'
                        resetTimer();
                    } else {
                        logout(); // Logout after capturing data
                    }
                });
            }, 30 * 1000); // Timeout after 30 seconds of inactivity
        }
    };

    inactivityTime();
</script>

</body>
</html>
