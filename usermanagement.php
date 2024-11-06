<?php
// Start the session and include the database connection
session_start();
require 'db.php'; // Assuming 'db.php' contains your database connection logic

// Pagination setup
$limit = 10; // Number of users per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total users count
$totalResult = $conn->query("SELECT COUNT(*) as count FROM users");
$totalUsers = $totalResult->fetch_assoc()['count'];
$totalPages = ceil($totalUsers / $limit);

// Fetch users from the database with pagination and order by 'id' in descending order
$sql = "SELECT id, name, email, role FROM users ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VDart PMT</title>
    <link rel="icon" href="images.png" type="image/png">
    <link rel="stylesheet" href="usermanagementstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Google Font Import - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
        }

        /* Main Content Styles */
        .main {
            flex-grow: 1;
            padding: 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-user-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-user-btn:hover {
            background: #0056b3;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        /* Table Styles */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-table th,
        .user-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background 0.3s, color 0.3s;
        }

        .user-table th {
            background: #3498db;
            color: white;
        }

        .user-table tr:hover {
            background-color: #f1f1f1;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9; /* Striped effect */
        }

        .user-table tr:nth-child(odd) {
            background-color: #ffffff; /* Striping */
        }

        /* Action Icons */
        .user-table a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s;
        }

        .user-table a:hover {
            color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .user-table {
                font-size: 14px; /* Smaller font on mobile */
            }
        }

        /* Pagination Styles */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }

        .pagination a.active {
            background-color: #0056b3;
            pointer-events: none;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.7); /* Black with opacity */
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            backdrop-filter: blur(5px); /* Optional blur effect */
            transition: opacity 0.3s ease; /* Smooth transition */
        }

        .modal-content {
            background-color: #ffffff;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 30px;
            border-radius: 10px; /* Rounded corners */
            width: 400px; /* Could be more or less, depending on screen size */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Smooth shadow */
            animation: fadeIn 0.4s; /* Fade in animation */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            transition: color 0.3s;
        }

        .btn-close:hover {
            color: #e74c3c; /* Change color on hover */
        }

        /* Input Styles */
        .modal-body input,
        .modal-body select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .modal-body input:focus,
        .modal-body select:focus {
            border-color: #007bff; /* Highlight border color */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Focus shadow effect */
        }

        /* Footer Styles */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-save {
            background-color: #007bff; /* Blue background */
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-save:hover {
            background-color: #0056b3; /* Darker blue */
            transform: translateY(-2px); /* Slight lift on hover */
        }
        /* Flex container for Add User and Search functionalities */
        .top-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            justify-content: space-between; /* Space elements across the container */
            padding: 10px;
        }

        /* Add User Button Styling */
        .add-user-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-user-btn:hover {
            background-color: #45a049; /* Darker green */
        }

        /* Search Container Styling */
        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Search Input Styling */
        .search-container input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Search Button Styling */
        .search-btn {
            background-color: #007BFF; /* Blue */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #0056b3; /* Darker blue */
        }

        

    </style>
</head>

<body>
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
                <li>
                    <a href="#" id="createUserButton">
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

        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="heading-container">
                    <h1 class="dashboard-heading" style="font-size: 30px;">User Management</h1>
                </div>
                <div class="user"></div>
            </div>

            <!-- Flex Container for Add User and Search Functionality -->
            <div class="top-controls">

            <!-- Add User Button -->
            <button class="add-user-btn" onclick="openModal()">Add New User</button>

            <?php
                $searchEmail = isset($_GET['searchEmail']) ? $_GET['searchEmail'] : '';

                $sql = "SELECT * FROM users";
                if ($searchEmail) {
                    $sql .= " WHERE email LIKE '%$searchEmail%'";
                }
                $result = $conn->query($sql);
            ?>


            <!-- Search User by Email with Inline Styling -->
            <div class="search-container" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <input type="text" id="searchEmail" placeholder="Search by Email" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; width: 250px;" />
                
                <!-- Search Button -->
                <button onclick="searchUser()" style="padding: 8px 16px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Search</button>
                
                <!-- Reset Button -->
                <button onclick="resetSearch()" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Reset</button>
            </div>



            <script>
                function searchUser() {
                    const email = document.getElementById('searchEmail').value;
                    if (email) {
                        window.location.href = `?searchEmail=${email}`;
                    } else {
                        alert("Please enter an email to search");
                    }
                }

                function resetSearch() {
                    document.getElementById('searchEmail').value = ''; // Clear the search input
                    window.location.href = '?'; // Reload page without search parameters to show all records
                }

            </script>

            </div>
            
            <!-- Modal for Adding New User -->
            <div class="modal" id="userModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add New User</h2>
                        <button class="btn-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="fullName" placeholder="Full Name" required>
                        <input type="email" id="email" placeholder="Email" required>
                        <input type="password" id="password" placeholder="Password" required>
                        <select id="role" required size="3" style="overflow-y: auto; height: 100px;">
                            <option value="" disabled selected>Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Contracts">Contracts</option>
                            <option value="User">User</option>
                        </select>

                    </div>
                    <div class="modal-footer">
                        <!-- <button class="btn-close" onclick="closeModal()">Cancel</button> -->
                        <button class="btn-save" onclick="saveUser()">Save</button>
                    </div>
                </div>
            </div>

            <!-- User Table -->
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Access Control</th> <!-- New Access Control Column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    <td>
                        <button onclick='openAccessModal({$row['id']})' 
                            style=\"
                                background-color: #4CAF50;
                                color: white;
                                padding: 8px 16px;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                font-size: 14px;
                                font-weight: bold;
                                margin: 4px 2px;
                                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                            \"
                            onmouseover=\"this.style.backgroundColor='#45a049'; this.style.boxShadow='0px 6px 8px rgba(0, 0, 0, 0.15)'\"
                            onmouseout=\"this.style.backgroundColor='#4CAF50'; this.style.boxShadow='0px 4px 6px rgba(0, 0, 0, 0.1)'\">
                            Access Control
                        </button>
                        <button onclick='openAssignedUsersModal({$row['id']})' 
                            style=\"
                                background-color: #2196F3;
                                color: white;
                                padding: 8px 16px;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                font-size: 14px;
                                font-weight: bold;
                                margin: 4px 2px;
                                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                            \"
                            onmouseover=\"this.style.backgroundColor='#1e88e5'; this.style.boxShadow='0px 6px 8px rgba(0, 0, 0, 0.15)'\"
                            onmouseout=\"this.style.backgroundColor='#2196F3'; this.style.boxShadow='0px 4px 6px rgba(0, 0, 0, 0.1)'\">
                            View Assigned Users
                        </button>
                    </td>
                    <td>
                        <a href='javascript:void(0)' onclick='openEditModal({$row['id']})' title='Edit User'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <a href='javascript:void(0)' class='delete-user' data-id='{$row['id']}' title='Delete User' onclick='confirmDelete({$row['id']})'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No users found</td></tr>";
    }
    ?>
</tbody>

<style>
  /* Background Overlay */
  .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.8));
        backdrop-filter: blur(6px); /* Enhanced blur effect */
        z-index: 999; /* Below the modal */
    }

    /* Modal Styling */
    .modal2 {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        width: 350px;
        max-width: 90%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35); /* Deeper shadow */
        z-index: 1001;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
        transform: translate(-50%, -45%); /* Initial slide-up effect */
    }
    .modal2.show {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%);
    }

    .modal2-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
    }

    .modal2-header h2 {
        font-size: 1.25rem;
        color: #333;
    }

    .modal2-body {
        max-height: 250px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #333;
        transition: color 0.3s ease;
    }
    .btn-close:hover {
        color: #e74c3c;
    }

    /* Custom Scrollbar */
    .modal2-body::-webkit-scrollbar {
        width: 8px;
    }
    .modal2-body::-webkit-scrollbar-thumb {
        background-color: #bbb;
        border-radius: 4px;
    }
    .modal2-body::-webkit-scrollbar-thumb:hover {
        background-color: #888;
    }

    /* Footer with a sticky effect */
    .modal2-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
        position: sticky;
        bottom: 0;
        background: #fff;
        z-index: 1;
    }

    /* Modern Button Styling */
    .modal2-footer .btn-save {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease, transform 0.2s ease;
    }
    .modal2-footer .btn-save:hover {
        background: linear-gradient(135deg, #45a049, #388e3c);
        transform: translateY(-2px);
    }
</style>

<!-- Background Overlay -->
<div id="modalBackdrop" class="modal-backdrop"></div>

<!-- Assigned Users Modal -->
<div id="assignedUsersModal" class="modal2">
    <div class="modal2-header">
        <h2>Assigned Users</h2>
        <button class="btn-close" onclick="closeAssignedUsersModal()">&times;</button>
    </div>
    <div class="modal2-body">
        <ul id="assignedUsersList"></ul>
    </div>
    <div class="modal2-footer">
        <button onclick="saveAccessChanges()" class="btn-save">Save Changes</button>
    </div>
</div>


<script>
// Function to open the assigned users modal and show the backdrop
function openAssignedUsersModal(userId) {
    // Display modal and backdrop
    document.getElementById('modalBackdrop').style.display = 'block';
    document.getElementById('assignedUsersModal').classList.add('show');
    document.getElementById('assignedUsersModal').dataset.userId = userId;

    // Fetch assigned users for this specific user
    fetch(`get_assigned_users.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            let assignedUsersHtml = '';
            if (data.assignedUsers && data.assignedUsers.length > 0) {
                data.assignedUsers.forEach(user => {
                    assignedUsersHtml += `
                        <li>
                            <input type="checkbox" class="assigned-user-checkbox" id="assignedUser_${user.id}" value="${user.id}" checked>
                            <label for="assignedUser_${user.id}">${user.name} (${user.email})</label>
                        </li>`;
                });
            } else {
                assignedUsersHtml = '<li>No users assigned</li>';
            }
            document.getElementById('assignedUsersList').innerHTML = assignedUsersHtml;
        })
        .catch(error => console.error('Error fetching assigned users:', error));
}

// Function to close the assigned users modal and hide the backdrop
function closeAssignedUsersModal() {
    document.getElementById('modalBackdrop').style.display = 'none';
    document.getElementById('assignedUsersModal').classList.remove('show');
}

// Function to save changes and remove unchecked users from the access list
function saveAccessChanges() {
    const userId = document.getElementById('assignedUsersModal').dataset.userId;
    const checkboxes = document.querySelectorAll('.assigned-user-checkbox');
    const remainingUserIds = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked) // Keep only checked users
        .map(checkbox => checkbox.value); // Get their IDs

    // Send updated access list to the server
    fetch('update_access_list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userId: userId, remainingUserIds: remainingUserIds })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        if (data.success) {
            alert('Access updated successfully');
            closeAssignedUsersModal();
        } else {
            alert('Error updating access: ' + data.message);
        }
    })
    .catch(error => console.error('Error updating access:', error));
}

// Close modal when clicking outside of modal content
document.addEventListener('click', function(event) {
    const modal = document.getElementById('assignedUsersModal');
    const backdrop = document.getElementById('modalBackdrop');

    if (event.target === backdrop) {
        closeAssignedUsersModal();
    }
});
</script>


            </table>



            <style>
        /* Modal Backdrop */
        .modal1-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }

        /* Main Modal Style */
        .modal1 {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90vw;
            max-width: 500px;
            max-height: 80vh;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            overflow: hidden;
            animation: slideIn 0.3s ease-out;
            box-sizing: border-box;
        }

        /* Modal Header */
        .modal1-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal1-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .btn-close {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-close:hover {
            background-color: #f3f4f6;
            border-radius: 6px;
        }

        /* Modal Body */
        .modal1-body {
            padding: 1rem;
            overflow-y: auto;
            max-height: calc(70vh - 60px); /* Prevents from pushing footer when zoomed out */
        }

        .user-list {
            max-height: 40vh;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.5rem;
        }

        .user-item {
        display: flex;
        align-items: center;
        justify-content: flex-end; /* Ensures right alignment */
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s;
        gap: 0.5rem; /* Space between checkbox and email */
    }



    .user-item:last-child {
        border-bottom: none;
    }

    .user-item:hover {
        background-color: #f9fafb;
    }

    .user-checkbox {
    margin-right: 0.75rem;
    width: 16px;
    height: 16px;
    transition: transform 0.2s ease; /* Smooth transition for size change */
}

.user-checkbox:checked {
    transform: scale(1.2); /* Increases the size by 20% when selected */
}


    .user-email {
        font-size: 0.875rem;
        color: #374151;
    }

    /* Modal Footer */
    .modal1-footer {
        display: flex;
        justify-content: flex-end;
        padding: 1rem;
        background-color: white;
        position: sticky;
        bottom: 0;
        border-top: 1px solid #e5e7eb;
        backdrop-filter: blur(6px);
        box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    /* Buttons */
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-cancel {
        background-color: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background-color: #e5e7eb;
    }

    .btn-save {
        background-color: #4CAF50;
        color: white;
    }

    .btn-save:hover {
        background-color: #45a049;
    }

    /* Keyframes for Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translate(-50%, -60%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    /* Media Query for Smaller Screens */
    @media (max-width: 480px) {
        .modal {
            width: 95vw;
            max-width: 95vw;
            max-height: 85vh;
            padding: 1rem;
        }
    }

    #userEmailList {
    text-align: left;
}

.user-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.user-email {
    flex: 1;
    text-align: left;
}

</style>



  
            <!-- Modal Backdrop -->
<div class="modal1-backdrop" id="modalBackdrop"></div>

<!-- Enhanced Access Control Modal -->
<div class="modal1" id="accessControlModal">
  <div class="modal1-header">
    <h2 class="modal1-title">
      <span class="modal1-title-icon">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
      </span>
      Access Control
    </h2>
    <button class="btn-close" onclick="closeAccessModal()">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>
  
  <div class="modal1-body">
    <div class="search-container">
      <input type="text" 
             class="search-input" 
             placeholder="Search users..." 
             onkeyup="filterUsers(this.value)"
             id="searchInput">
    </div>
<br>
    <div class="user-list" id="userEmailList">
      <!-- User items will be dynamically populated here -->
    </div>
  </div>

  <div class="modal1-footer">
    <div class="loading-spinner" id="saveSpinner"></div>
    <button class="btn btn-cancel" onclick="closeAccessModal()">Cancel</button>
    <button class="btn btn-save" onclick="saveAccessControl()">Save Changes</button>
  </div>
</div>

<script>
  function openAccessModal(userId) {
    document.getElementById('modalBackdrop').style.display = 'block';
    document.getElementById('accessControlModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    document.getElementById('accessControlModal').dataset.userId = userId;

    // Fetch and populate users
    fetch('get_all_users.php')
        .then(response => response.json())
        .then(data => {
            let userListHtml = '';
            data.users.forEach(user => {
                userListHtml += `
                    <div class="user-item">
                        <label for="user-${user.id}" class="user-email">${user.email}</label>
                        <input type="checkbox" 
                               class="user-checkbox" 
                               id="user-${user.id}" 
                               value="${user.id}">
                    </div>`;
            });
            document.getElementById('userEmailList').innerHTML = userListHtml;
        })
        .catch(error => console.error('Error loading users:', error));
}


  function closeAccessModal() {
    document.getElementById('modalBackdrop').style.display = 'none';
    document.getElementById('accessControlModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('searchInput').value = '';
    document.getElementById('userEmailList').innerHTML = '';
  }

  function filterUsers(searchTerm) {
    const userItems = document.querySelectorAll('.user-item');
    userItems.forEach(item => {
      const email = item.querySelector('.user-email').textContent.toLowerCase();
      const matches = email.includes(searchTerm.toLowerCase());
      item.style.display = matches ? 'flex' : 'none';
    });
  }

  function saveAccessControl() {
    const spinner = document.getElementById('saveSpinner');
    spinner.style.display = 'inline-block';
    
    const userId = document.getElementById('accessControlModal').dataset.userId;
    const selectedUserIds = Array.from(document.querySelectorAll('#userEmailList input[type="checkbox"]:checked'))
      .map(checkbox => checkbox.value);

    fetch('save_access_control.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ userId, selectedUserIds })
    })
    .then(response => response.json())
    .then(data => {
      spinner.style.display = 'none';
      if (data.success) {
        alert('Access control updated successfully!');
        closeAccessModal();
      } else {
        alert('Error updating access control: ' + data.message);
      }
    })
    .catch(error => {
      spinner.style.display = 'none';
      console.error('Error saving access control:', error);
      alert('Error saving access control settings');
    });
  }

  // Close modal when clicking outside
  document.getElementById('modalBackdrop').onclick = function(event) {
    if (event.target === this) {
      closeAccessModal();
    }
  };

  // Handle escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeAccessModal();
    }
  });
</script>





            <!-- Edit User Modal -->
            <div class="modal" id="editUserModal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit User</h2>
                        <button class="btn-close" onclick="closeEditModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editUserId">
                        <label for="editFullName">Full Name</label>
                        <input type="text" id="editFullName" placeholder="Full Name" required>
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" placeholder="Email" required>
                        <label for="editRole">Role</label>
                        <select id="editRole" required>
                            <option value="Admin">Admin</option>
                            <option value="Contracts">Contracts</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-save" onclick="updateUser()">Save Changes</button>
                    </div>
                </div>
            </div>

            <script>
                // Function to open the Edit User modal and populate the fields
                function openEditModal(userId) {
                    fetch(`get_user.php?id=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('editUserId').value = data.user.id;
                                document.getElementById('editFullName').value = data.user.name;
                                document.getElementById('editEmail').value = data.user.email;
                                document.getElementById('editRole').value = data.user.role;
                                document.getElementById('editUserModal').style.display = 'block';
                            } else {
                                alert('Error fetching user data');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while fetching user data');
                        });
                }

                // Function to close the Edit User modal
                function closeEditModal() {
                    document.getElementById('editUserModal').style.display = 'none';
                }

                // Function to update the user details
                function updateUser() {
                    const userId = document.getElementById('editUserId').value;
                    const fullName = document.getElementById('editFullName').value;
                    const email = document.getElementById('editEmail').value;
                    const role = document.getElementById('editRole').value;

                    fetch('update_user.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            id: userId,
                            name: fullName,
                            email: email,
                            role: role
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User updated successfully!');
                            closeEditModal();
                            location.reload(); // Refresh the page to show updated user list
                        } else {
                            alert('Error updating user');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Modal open and close functions
                function openModal() {
                    document.getElementById('userModal').style.display = 'flex';
                }

                function closeModal() {
                    document.getElementById('userModal').style.display = 'none';
                }

                // Save user function
                function saveUser() {
                    const fullName = document.getElementById('fullName').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const role = document.getElementById('role').value;

                    if (fullName && email && password && role) {
                        const formData = new FormData();
                        formData.append('fullName', fullName);
                        formData.append('email', email);
                        formData.append('password', password);
                        formData.append('role', role);

                        fetch('add_user.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('User added successfully!');
                                closeModal();
                                location.reload(); // Refresh the page to show the new user
                            } else {
                                alert('Error adding user: ' + data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    } else {
                        alert("All fields are required!");
                    }
                }

                 // Confirm delete user functionality
                function confirmDelete(userId) {
                    if (confirm("Are you sure you want to delete this user? This action cannot be undone.")) {
                        fetch('delete_user.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: userId })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('User deleted successfully!');
                                location.reload(); // Refresh the page to show the updated user list
                            } else {
                                alert('Error deleting user: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the user. Please try again.');
                        });
                    }
                }

                // Close modal if clicking outside of it
                window.onclick = function (event) {
                    const modal = document.getElementById('userModal');
                    if (event.target === modal) {
                        closeModal();
                    }
                };
            </script>

            <!-- Pagination Controls -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">« Prev</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next »</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
