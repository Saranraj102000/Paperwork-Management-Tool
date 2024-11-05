<?php
// Start session
session_start();

// If there is no tools session data, initialize with sample data
if (!isset($_SESSION['tools'])) {
    $_SESSION['tools'] = [
        [
            'name' => 'Tool A',
            'nature' => 'Cloud',
            'monthly_cost' => '$200',
            'annual_cost' => '$2400',
            'licenses' => '50',
            'payment_frequency' => 'Monthly',
            'last_renewal' => '2024-01-01',
            'next_renewal' => '2025-01-01',
            'internal_spoc' => 'John Doe',
            'external_spoc' => [
                'name' => 'Jane Smith',
                'phone' => '123-456-7890',
                'email' => 'jane@example.com',
                'mode' => 'Email'
            ],
            'report_link' => 'https://example.com/report-tool-a'
        ]
    ];
}

// Handle removing a tool
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_tool'])) {
    $index = $_POST['index'];
    array_splice($_SESSION['tools'], $index, 1);  // Remove the tool from the array
}

// Handle editing an existing tool
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_tool'])) {
    $index = $_POST['index'];
    $_SESSION['tools'][$index] = [
        'name' => $_POST['name'],
        'nature' => $_POST['nature'],
        'monthly_cost' => $_POST['monthly_cost'],
        'annual_cost' => $_POST['annual_cost'],
        'licenses' => $_POST['licenses'],
        'payment_frequency' => $_POST['payment_frequency'],
        'last_renewal' => $_POST['last_renewal'],
        'next_renewal' => $_POST['next_renewal'],
        'internal_spoc' => $_POST['internal_spoc'],
        'external_spoc' => [
            'name' => $_POST['external_spoc_name'],
            'phone' => $_POST['external_spoc_phone'],
            'email' => $_POST['external_spoc_email'],
            'mode' => $_POST['external_spoc_mode']
        ],
        'report_link' => $_POST['report_link']
    ];
}

// Handle adding a new tool
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tool'])) {
    $new_tool = [
        'name' => $_POST['name'],
        'nature' => $_POST['nature'],
        'monthly_cost' => $_POST['monthly_cost'],
        'annual_cost' => $_POST['annual_cost'],
        'licenses' => $_POST['licenses'],
        'payment_frequency' => $_POST['payment_frequency'],
        'last_renewal' => $_POST['last_renewal'],
        'next_renewal' => $_POST['next_renewal'],
        'internal_spoc' => $_POST['internal_spoc'],
        'external_spoc' => [
            'name' => $_POST['external_spoc_name'],
            'phone' => $_POST['external_spoc_phone'],
            'email' => $_POST['external_spoc_email'],
            'mode' => $_POST['external_spoc_mode']
        ],
        'report_link' => $_POST['report_link']
    ];

    // Add the new tool to the session
    $_SESSION['tools'][] = $new_tool;
}

// Handle export to CSV
if (isset($_POST['export_csv'])) {
    $filename = "tools_list_" . date('Ymd') . ".csv";
    
    // Set headers to trigger file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Output the headers of the CSV
    fputcsv($output, ['Tool Name', 'Tool Nature', 'Monthly Cost', 'Annual Cost', 'Licenses Purchased', 'Payment Frequency', 'Last Renewal Date', 'Next Renewal Date', 'Internal SPOC', 'External SPOC Name', 'Phone', 'Email', 'Mode of Communication', 'Report Link']);

    // Output the data from the session
    foreach ($_SESSION['tools'] as $tool) {
        fputcsv($output, [
            $tool['name'],
            $tool['nature'],
            $tool['monthly_cost'],
            $tool['annual_cost'],
            $tool['licenses'],
            $tool['payment_frequency'],
            $tool['last_renewal'],
            $tool['next_renewal'],
            $tool['internal_spoc'],
            $tool['external_spoc']['name'],
            $tool['external_spoc']['phone'],
            $tool['external_spoc']['email'],
            $tool['external_spoc']['mode'],
            $tool['report_link']
        ]);
    }

    // Close the output stream
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Overview - Delivery Team</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Portal Overview</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="dashboard-container">
        <!-- Main Content Area with Scrollable Table -->
        <div class="content-area">
            <h2>Current Tools Overview</h2>

            <!-- Export to CSV Form -->
            <form method="post" action="">
                <button type="submit" name="export_csv" class="export-btn">Export to CSV</button>
            </form>

            <div class="table-wrapper">
                <table id="tools-table">
                    <thead>
                        <tr>
                            <th>Tool Name</th>
                            <th>Tool Nature</th>
                            <th>Monthly Cost</th>
                            <th>Annual Cost</th>
                            <th>Licenses Purchased</th>
                            <th>Payment Frequency</th>
                            <th>Last Renewal Date</th>
                            <th>Next Renewal Date</th>
                            <th>Internal SPOC</th>
                            <th>External SPOC Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Mode of Communication</th>
                            <th>Report</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['tools'] as $index => $tool): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tool['name']); ?></td>
                            <td><?php echo htmlspecialchars($tool['nature']); ?></td>
                            <td><?php echo htmlspecialchars($tool['monthly_cost']); ?></td>
                            <td><?php echo htmlspecialchars($tool['annual_cost']); ?></td>
                            <td><?php echo htmlspecialchars($tool['licenses']); ?></td>
                            <td><?php echo htmlspecialchars($tool['payment_frequency']); ?></td>
                            <td><?php echo htmlspecialchars($tool['last_renewal']); ?></td>
                            <td><?php echo htmlspecialchars($tool['next_renewal']); ?></td>
                            <td><?php echo htmlspecialchars($tool['internal_spoc']); ?></td>
                            <td><?php echo htmlspecialchars($tool['external_spoc']['name']); ?></td>
                            <td><?php echo htmlspecialchars($tool['external_spoc']['phone']); ?></td>
                            <td><?php echo htmlspecialchars($tool['external_spoc']['email']); ?></td>
                            <td><?php echo htmlspecialchars($tool['external_spoc']['mode']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($tool['report_link']); ?>" target="_blank">View Report</a></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="edit-btn" data-index="<?php echo $index; ?>">✏️ Edit</button>

                                <!-- Remove Button -->
                                <form method="POST" action="portal_overview.php" style="display:inline;">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit" name="remove_tool" class="remove-btn">❌ Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add New Tool Button -->
            <button id="add-tool-btn">+ Add New Tool</button>

            <!-- Pop-up Modal for Adding New Tool -->
            <div id="add-tool-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3>Add New Tool</h3>
                    <form method="POST" action="portal_overview.php">
                        <table class="form-table">
                            <tr>
                                <td><label for="name">Tool Name:</label></td>
                                <td><input type="text" id="name" name="name" required></td>
                            </tr>
                            <tr>
                                <td><label for="nature">Tool Nature:</label></td>
                                <td><input type="text" id="nature" name="nature" required></td>
                            </tr>
                            <tr>
                                <td><label for="monthly_cost">Monthly Cost:</label></td>
                                <td><input type="text" id="monthly_cost" name="monthly_cost" required></td>
                            </tr>
                            <tr>
                                <td><label for="annual_cost">Annual Cost:</label></td>
                                <td><input type="text" id="annual_cost" name="annual_cost" required></td>
                            </tr>
                            <tr>
                                <td><label for="licenses">Licenses Purchased:</label></td>
                                <td><input type="number" id="licenses" name="licenses" required></td>
                            </tr>
                            <tr>
                                <td><label for="payment_frequency">Payment Frequency:</label></td>
                                <td><input type="text" id="payment_frequency" name="payment_frequency" required></td>
                            </tr>
                            <tr>
                                <td><label for="last_renewal">Last Renewal Date:</label></td>
                                <td><input type="date" id="last_renewal" name="last_renewal" required></td>
                            </tr>
                            <tr>
                                <td><label for="next_renewal">Next Renewal Date:</label></td>
                                <td><input type="date" id="next_renewal" name="next_renewal" required></td>
                            </tr>
                            <tr>
                                <td><label for="internal_spoc">Internal SPOC:</label></td>
                                <td><input type="text" id="internal_spoc" name="internal_spoc" required></td>
                            </tr>
                            <tr>
                                <td><label for="external_spoc_name">External SPOC Name:</label></td>
                                <td><input type="text" id="external_spoc_name" name="external_spoc_name" required></td>
                            </tr>
                            <tr>
                                <td><label for="external_spoc_phone">External SPOC Phone:</label></td>
                                <td><input type="text" id="external_spoc_phone" name="external_spoc_phone" required></td>
                            </tr>
                            <tr>
                                <td><label for="external_spoc_email">External SPOC Email:</label></td>
                                <td><input type="email" id="external_spoc_email" name="external_spoc_email" required></td>
                            </tr>
                            <tr>
                                <td><label for="external_spoc_mode">Mode of Communication:</label></td>
                                <td><input type="text" id="external_spoc_mode" name="external_spoc_mode" required></td>
                            </tr>
                            <tr>
                                <td><label for="report_link">Report Link:</label></td>
                                <td><input type="url" id="report_link" name="report_link" required></td>
                            </tr>
                        </table>
                        <button type="submit" name="add_tool">Add Tool</button>
                    </form>
                </div>
            </div>

            <!-- Pop-up Modal for Editing Tool -->
            <div id="edit-tool-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3>Edit Tool Information</h3>
                    <form method="POST" action="portal_overview.php" id="edit-tool-form">
                        <input type="hidden" name="index" id="edit-index">
                        <table class="form-table">
                            <tr>
                                <td><label for="edit-name">Tool Name:</label></td>
                                <td><input type="text" id="edit-name" name="name" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-nature">Tool Nature:</label></td>
                                <td><input type="text" id="edit-nature" name="nature" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-monthly_cost">Monthly Cost:</label></td>
                                <td><input type="text" id="edit-monthly_cost" name="monthly_cost" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-annual_cost">Annual Cost:</label></td>
                                <td><input type="text" id="edit-annual_cost" name="annual_cost" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-licenses">Licenses Purchased:</label></td>
                                <td><input type="number" id="edit-licenses" name="licenses" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-payment_frequency">Payment Frequency:</label></td>
                                <td><input type="text" id="edit-payment_frequency" name="payment_frequency" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-last_renewal">Last Renewal Date:</label></td>
                                <td><input type="date" id="edit-last_renewal" name="last_renewal" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-next_renewal">Next Renewal Date:</label></td>
                                <td><input type="date" id="edit-next_renewal" name="next_renewal" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-internal_spoc">Internal SPOC:</label></td>
                                <td><input type="text" id="edit-internal_spoc" name="internal_spoc" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-external_spoc_name">External SPOC Name:</label></td>
                                <td><input type="text" id="edit-external_spoc_name" name="external_spoc_name" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-external_spoc_phone">External SPOC Phone:</label></td>
                                <td><input type="text" id="edit-external_spoc_phone" name="external_spoc_phone" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-external_spoc_email">External SPOC Email:</label></td>
                                <td><input type="email" id="edit-external_spoc_email" name="external_spoc_email" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-external_spoc_mode">Mode of Communication:</label></td>
                                <td><input type="text" id="edit-external_spoc_mode" name="external_spoc_mode" required></td>
                            </tr>
                            <tr>
                                <td><label for="edit-report_link">Report Link:</label></td>
                                <td><input type="url" id="edit-report_link" name="report_link" required></td>
                            </tr>
                        </table>
                        <button type="submit" name="edit_tool">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add tool modal handling
        const addToolModal = document.getElementById("add-tool-modal");
        const addToolBtn = document.getElementById("add-tool-btn");
        const closeAddToolModal = document.getElementsByClassName("close")[0];

        addToolBtn.onclick = function() {
            addToolModal.style.display = "block";
        }

        closeAddToolModal.onclick = function() {
            addToolModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == addToolModal) {
                addToolModal.style.display = "none";
            }
        }

        // Handle modal pop-up for editing
        const editButtons = document.querySelectorAll('.edit-btn');
        const editModal = document.getElementById('edit-tool-modal');
        const closeEditModal = document.getElementsByClassName('close')[1];

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const index = button.getAttribute('data-index');
                const tool = <?php echo json_encode($_SESSION['tools']); ?>[index];

                document.getElementById('edit-name').value = tool.name;
                document.getElementById('edit-nature').value = tool.nature;
                document.getElementById('edit-monthly_cost').value = tool.monthly_cost;
                document.getElementById('edit-annual_cost').value = tool.annual_cost;
                document.getElementById('edit-licenses').value = tool.licenses;
                document.getElementById('edit-payment_frequency').value = tool.payment_frequency;
                document.getElementById('edit-last_renewal').value = tool.last_renewal;
                document.getElementById('edit-next_renewal').value = tool.next_renewal;
                document.getElementById('edit-internal_spoc').value = tool.internal_spoc;
                document.getElementById('edit-external_spoc_name').value = tool.external_spoc.name;
                document.getElementById('edit-external_spoc_phone').value = tool.external_spoc.phone;
                document.getElementById('edit-external_spoc_email').value = tool.external_spoc.email;
                document.getElementById('edit-external_spoc_mode').value = tool.external_spoc.mode;
                document.getElementById('edit-report_link').value = tool.report_link;
                document.getElementById('edit-index').value = index;

                editModal.style.display = "block";
            });
        });

        closeEditModal.onclick = function() {
            editModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
