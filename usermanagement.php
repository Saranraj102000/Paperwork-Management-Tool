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
                    <a href="allrecords.php">
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

            <!-- Add User Button -->
            <button class="add-user-btn" onclick="openModal()">Add New User</button>

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
                        echo "<tr><td colspan='5'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

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
