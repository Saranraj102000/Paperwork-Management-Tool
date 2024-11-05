<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Team Info and Tools</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        /* Header */
        header {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2em;
            font-weight: 600;
        }
        /* Footer */
        footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.9em;
            letter-spacing: 1px;
        }
        /* Scrollable Table Container */
        .table-container {
            margin: 20px;
            max-height: 400px;
            overflow-x: auto; /* Horizontal scrollbar */
            overflow-y: scroll; /* Vertical scrollbar */
            border: 1px solid #ddd;
            background-color: white;
        }
        table {
            width: 100%;
            min-width: 1000px; /* Minimum width to ensure horizontal scrolling */
            border-collapse: collapse;
            table-layout: fixed; /* Ensures fixed-width columns */
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #34495E;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        td {
            vertical-align: top;
        }

        /* Fixed Width for Columns */
        th, td {
            width: 150px;
        }

        /* Add Button Icon */
        .add-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 40px;
            background-color: #1ABC9C;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 15px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        .add-btn:hover {
            background-color: #16A085;
        }

        /* Modal (Popup) Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #ddd;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

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

        .modal input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #1ABC9C;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
        }

        .modal button:hover {
            background-color: #16A085;
        }

        /* Style for the first column (headers) */
        .attribute-header {
            background-color: #ecf0f1; /* Light grey background */
            font-weight: bold; /* Bold text */
            text-transform: uppercase; /* Uppercase text for distinction */
            position: sticky;
            left: 0;
            z-index: 2;
        }

    </style>
</head>
<body>

<header>
    <h1>Team: Development & Tools Management</h1>
</header>

<!-- Scrollable Table -->
<div class="table-container">
    <table id="toolTable">
        <thead>
            <tr>
                <th>Attributes</th>
                <!-- Dynamically added tool names as columns -->
            </tr>
        </thead>
        <tbody id="toolTableBody">
            <!-- Rows for each attribute will be dynamically added here -->
        </tbody>
    </table>
</div>

<!-- Add New Tool Button (Plus Icon) -->
<div>
    <button class="add-btn" onclick="showAddToolPopup()">+</button>
</div>

<!-- Modal for Adding New Tool -->
<div id="addToolModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Add New Tool</h3>
        <form id="toolForm">
            <label>Tool Name</label>
            <input type="text" id="newToolName" required>
            
            <label>Reason for Using</label>
            <input type="text" id="newToolReason" required>
            
            <label>Cost</label>
            <input type="text" id="newToolCost" required>
            
            <label>Payment Frequency</label>
            <input type="text" id="newToolFrequency" required>
            
            <label>Last Renewal</label>
            <input type="text" id="newToolLastRenewal" required>
            
            <label>Next Renewal</label>
            <input type="text" id="newToolNextRenewal" required>
            
            <label>Comments</label>
            <input type="text" id="newToolComments" required>
            
            <label>SPOC (Internal)</label>
            <input type="text" id="newToolSPOCInternal" required>
            
            <label>SPOC (External)</label>
            <input type="text" id="newToolSPOCExternal" required>
            
            <label>Lookup Report URL</label>
            <input type="text" id="newToolLookupURL" required>
            
            <button type="button" onclick="addTool()">Save</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 Team Development - All Rights Reserved</p>
</footer>

<script>
    // Load tools from localStorage or use an empty array
    let tools = JSON.parse(localStorage.getItem('tools')) || [];

    // Function to render all tools into columns
    function renderTools() {
        let tableBody = document.getElementById('toolTableBody');
        let tableHead = document.querySelector('#toolTable thead tr');
        
        tableBody.innerHTML = '';
        tableHead.innerHTML = '<th>Attributes</th>'; // Reset table head

        const attributes = [
            'Reason for Using', 'Cost', 'Payment Frequency', 'Last Renewal', 'Next Renewal',
            'Comments', 'SPOC (Internal)', 'SPOC (External)', 'Lookup Report'
        ];

        // Add tool names as columns
        tools.forEach((tool, index) => {
            tableHead.innerHTML += `<th>${tool[0]}</th>`;
        });

        // Add rows for each attribute
        attributes.forEach((attribute, index) => {
            let row = `<tr><td class="attribute-header">${attribute}</td>`;
            tools.forEach((tool) => {
                row += `<td>${tool[index + 1]}</td>`;
            });
            row += '</tr>';
            tableBody.innerHTML += row;
        });
    }

    // Function to show the Add Tool popup (modal)
    function showAddToolPopup() {
        document.getElementById('addToolModal').style.display = 'block';
    }

    // Function to close the modal (popup)
    function closeModal() {
        document.getElementById('addToolModal').style.display = 'none';
    }

    // Function to add a new tool
    function addTool() {
        let newTool = [
            document.getElementById('newToolName').value,
            document.getElementById('newToolReason').value,
            document.getElementById('newToolCost').value,
            document.getElementById('newToolFrequency').value,
            document.getElementById('newToolLastRenewal').value,
            document.getElementById('newToolNextRenewal').value,
            document.getElementById('newToolComments').value,
            document.getElementById('newToolSPOCInternal').value,
            document.getElementById('newToolSPOCExternal').value,
            document.getElementById('newToolLookupURL').value
        ];

        // Add the new tool to the list and save it to localStorage
        tools.push(newTool);
        localStorage.setItem('tools', JSON.stringify(tools));
        renderTools();
        closeModal(); // Close the modal after submission
        document.getElementById('toolForm').reset(); // Reset the form
    }

    // Initial render of tools
    renderTools();
</script>

</body>
</html>
