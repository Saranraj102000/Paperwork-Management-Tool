

<?php

include 'db.php';

// $servername = "localhost";  // Change if using a different host

// $username = "root"; // Replace with your database username

// $password = ""; // Replace with your database password

// $dbname = "formdata"; // Replace with your database name



// // Create connection

// $conn = new mysqli($servername, $username, $password, $dbname);



// // Check connection

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }


session_start();





if (!isset($_SESSION['email'])) {
    header("Location: paperworklogin.php"); // Redirect if not logged in
    exit();
}
?>



<?php





// Check if ID is set in the URL

if (isset($_GET['id'])) {

    $id = htmlspecialchars($_GET['id']);



    // Prepare the SQL query to fetch the record

    $sql = "SELECT * FROM paperworkdetails WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();



    // Check if the record exists

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // Now $row contains the data of the specific record

    } else {

        echo "Record not found.";

        exit;

    }



    $stmt->close();

} else {

    echo "No ID specified.";

    exit;

}

?>



<!DOCTYPE html>

<!--=== Coding by CodingLab | www.codinglabweb.com === -->

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    

    <!----======== CSS ======== -->

    <link rel="stylesheet" href="updatestyles.css">

    <link rel="stylesheet" href="https://use.typekit.net/xxxxxx.css"> <!-- Replace with your actual link -->

    <!----===== Iconscout CSS ===== -->

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome Icons -->





    <title>VDart PMT</title>
    <link rel="icon" href="images.png" type="image/png">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     

</head>

<style>

    

    /* New Back Button Styles */

/* Style for the back button */

.back-button {

    display: flex;

    align-items: center;

    background: linear-gradient(135deg, #6e8efb, #a777e3); /* Gradient background */

    color: white;

    padding: 10px 20px;

    border: none;

    border-radius: 8px;

    text-decoration: none;

    font-size: 16px;

    transition: background-color 0.3s, transform 0.3s;

    position: absolute;

    top: 20px;

    left: 20px;

    z-index: 1000; /* Ensure it appears above other content */

}



.back-button i {

    margin-right: 8px; /* Space between icon and text */

}



.back-button:hover {

    background: linear-gradient(135deg, #a777e3, #6e8efb); /* Reverse gradient on hover */

    transform: translateY(-2px);

}



.back-button:active {

    transform: translateY(0);

}





/* Button styling */

.logout-button {

    position: absolute;

    top: 20px;

    right: 20px;

    background: linear-gradient(135deg, #ff7e67, #ff5743);

    color: white;

    padding: 10px 20px;

    border: none;

    border-radius: 8px;

    display: flex;

    align-items: center;

    text-decoration: none;

    font-size: 16px;

    transition: background-color 0.3s, transform 0.3s;

    z-index: 1000; /* Ensure it appears above other content */

}



.logout-button i {

    margin-right: 8px; /* Space between icon and text */

}



.logout-button:hover {

    background: linear-gradient(135deg, #ff5743, #ff7e67);

    transform: translateY(-2px);

}



.logout-button:active {

    transform: translateY(0);

}

.header-container {

    display: inline-flex;

    align-items: center;

}

body {

    font-family: Arial, sans-serif;

    background-color: #6f6f6f;

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



.container form{

    position: relative;

    margin-top: 16px;

    min-height: 3450px;

    background-color: #fff;

    overflow: hidden;

}

    .right-align {
        position: absolute; /* or you can use float: right; */
        right: 20px;
        left: 1330px;
        top: 20px; /* Adjust the top value as needed */
    }

</style>

<body>

    <div class="container scrollable-container">

    <center>

        <header>

            <img src="images.png" alt="Image" style="width: 50px; height: auto; margin-right: 5px; vertical-align: middle; margin-top: -10px;">

            <span style="font-size: 24px; color: #000;">Edit Paperwork</span>

        </header>

    </center>



    <a href="paperworkallrecords.php" class="back-button">
        <i class="fas fa-chevron-left"></i> Back
    </a>

    <a href="#" id="editBtn" class="back-button right-align">
        <i class="fas fa-edit"></i> Edit
    </a>


<br>

<?php

    // Fetch existing data to pre-fill the form (if needed)

    $id = isset($_GET['id']) ? $_GET['id'] : '';

    ?>

        <form id="myForm" method="POST" action="updateitem.php" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="form first">

            <div class="details personal">

    <span class="title">Consultant Details</span>



    <div class="fields">

        <div class="input-field">

            <label for="cfirstname">First Name:</label>

            <input type="text" name="cfirstname" value="<?php echo htmlspecialchars($row['cfirstname']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="clastname">Last Name:</label>

            <input type="text" name="clastname" value="<?php echo htmlspecialchars($row['clastname']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="ceipal_id">CEIPAL ID:</label>

            <input type="number" name="ceipal_id" value="<?php echo htmlspecialchars($row['ceipalid']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="clinkedin_url">LinkedIn URL:</label>

            <input type="text" name="clinkedin_url" value="<?php echo htmlspecialchars($row['clinkedinurl']); ?>" disabled >

        </div>



        <div class="input-field">

            <label for="cdob">Date of Birth:</label>

            <input type="text" name="cdob" value="<?php echo htmlspecialchars($row['cdob']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="cmobilenumber">Mobile Number:</label>

            <input type="text" name="cmobilenumber" value="<?php echo htmlspecialchars($row['cmobilenumber']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="cemail">Email:</label>

            <input type="text" name="cemail" value="<?php echo htmlspecialchars($row['cemail']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="clocation">Location:</label>

            <input type="text" name="clocation" value="<?php echo htmlspecialchars($row['clocation']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="chomeaddress">Home Address:</label>

            <input type="text" name="chomeaddress" value="<?php echo htmlspecialchars($row['chomeaddress']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="cssn">SSN:</label>

            <input type="text" name="cssn" value="<?php echo htmlspecialchars($row['cssn']); ?>" disabled>

        </div>



        <div class="input-field">
    <label for="cwork_authorization_status">Work Authorization Status:</label>
    <select name="cwork_authorization_status" id="cwork_authorization_status" onchange="toggleWorkAuthorization()" <?php if (!isset($_POST['edit'])) echo 'disabled'; ?>>
        <option disabled>Select option</option>
        <option value="US Citizen" <?php if ($row['cwork_authorization_status'] == 'US Citizen') echo 'selected'; ?>>US Citizen</option>
        <option value="Green Card" <?php if ($row['cwork_authorization_status'] == 'Green Card') echo 'selected'; ?>>Green Card</option>
        <option value="TN" <?php if ($row['cwork_authorization_status'] == 'TN') echo 'selected'; ?>>TN</option>
        <option value="H1B" <?php if ($row['cwork_authorization_status'] == 'H1B') echo 'selected'; ?>>H1B</option>
        <option value="Mexican Citizen" <?php if ($row['cwork_authorization_status'] == 'Mexican Citizen') echo 'selected'; ?>>Mexican Citizen</option>
        <option value="Canadian Citizen" <?php if ($row['cwork_authorization_status'] == 'Canadian Citizen') echo 'selected'; ?>>Canadian Citizen</option>
        <option value="Canadian Work Permit" <?php if ($row['cwork_authorization_status'] == 'Canadian Work Permit') echo 'selected'; ?>>Canadian Work Permit</option>
        <option value="Australian Citizen" <?php if ($row['cwork_authorization_status'] == 'Australian Citizen') echo 'selected'; ?>>Australian Citizen</option>
        <option value="CR Citizen" <?php if ($row['cwork_authorization_status'] == 'CR Citizen') echo 'selected'; ?>>CR Citizen</option>
        <option value="GC EAD" <?php if ($row['cwork_authorization_status'] == 'GC EAD') echo 'selected'; ?>>GC EAD</option>
        <option value="OPT EAD" <?php if ($row['cwork_authorization_status'] == 'OPT EAD') echo 'selected'; ?>>OPT EAD</option>
        <option value="H4 EAD" <?php if ($row['cwork_authorization_status'] == 'H4 EAD') echo 'selected'; ?>>H4 EAD</option>
        <option value="CPT" <?php if ($row['cwork_authorization_status'] == 'CPT') echo 'selected'; ?>>CPT</option>
        <option value="Others" <?php if ($row['cwork_authorization_status'] == 'Others') echo 'selected'; ?>>Others</option>
    </select>
</div>

<!-- V-Validate Status field, shown conditionally for H1B -->
<div class="input-field" id="v_validate_status_field" style="display: none;">
    <label for="v_validate_status">V-Validate Status</label>
    <select name="cv_validate_status" id="v_validate_status" onchange="setFinalWorkAuthorization()" <?php if (!isset($_POST['edit'])) echo 'disabled'; ?>>
        <option disabled selected>Select option</option>
        <option value="Genuine" <?php if ($row['cv_validate_status'] == 'Genuine') echo 'selected'; ?>>Genuine</option>
        <option value="Questionable" <?php if ($row['cv_validate_status'] == 'Questionable') echo 'selected'; ?>>Questionable</option>
        <option value="Clear" <?php if ($row['cv_validate_status'] == 'Clear') echo 'selected'; ?>>Clear</option>
        <option value="Invalid Copy" <?php if ($row['cv_validate_status'] == 'Invalid Copy') echo 'selected'; ?>>Invalid Copy</option>
        <option value="Pending" <?php if ($row['cv_validate_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Not Sent - Stamp Copy" <?php if ($row['cv_validate_status'] == 'Not Sent - Stamp Copy') echo 'selected'; ?>>Not Sent - Stamp Copy</option>
        <option value="NA" <?php if ($row['cv_validate_status'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Hidden input to store the final combined value -->
<input type="hidden" id="final_work_authorization" name="final_work_authorization" value="<?php echo htmlspecialchars($row['cwork_authorization_status']); ?>">

<script>
    function toggleWorkAuthorization() {
        var workStatus = document.getElementById("cwork_authorization_status").value;
        var validateStatusField = document.getElementById("v_validate_status_field");
        var validateStatusInput = document.getElementById("v_validate_status");

        // Initially hide the validate field
        validateStatusField.style.display = "none";
        validateStatusInput.disabled = true; // Disable select input by default

        if (workStatus === "H1B") {
            validateStatusField.style.display = "block";
            validateStatusInput.disabled = false; // Enable select input for H1B
            validateStatusInput.value = '';  // Clear the V-Validate selection
        } else {
            document.getElementById("final_work_authorization").value = workStatus; // Set final value without V-Validate
        }
    }

    function setFinalWorkAuthorization() {
        var workStatus = document.getElementById("cwork_authorization_status").value;
        var validateStatus = document.getElementById("v_validate_status").value;
        document.getElementById("final_work_authorization").value = workStatus + (validateStatus ? " - " + validateStatus : "");
    }

    // On page load, initialize the fields based on the database values
    window.onload = function() {
        var finalAuth = "<?php echo $row['cwork_authorization_status']; ?>";
        var validateStatus = "<?php echo isset($row['cv_validate_status']) ? $row['cv_validate_status'] : ''; ?>";

        // Set the work authorization dropdown to the initial database value
        document.getElementById("cwork_authorization_status").value = finalAuth;

        // If the work authorization is H1B, show and set the V-Validate Status field
        if (finalAuth === "H1B") {
            toggleWorkAuthorization(); // Show the V-Validate field for H1B
            document.getElementById("v_validate_status").value = validateStatus;
            setFinalWorkAuthorization(); // Update hidden input with combined value
        } else {
            setFinalWorkAuthorization(); // For non-H1B values, only set the work status
        }
    }
</script>








        <div class="input-field">

            <label for="ccertifications">Certifications:</label>

            <input type="text" name="ccertifications" value="<?php echo htmlspecialchars($row['ccertifications']); ?>" disabled >

        </div>



        <div class="input-field">

            <label for="coverall_experience">Overall Experience:</label>

            <input type="text" name="coverall_experience" value="<?php echo htmlspecialchars($row['coverall_experience']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="crecent_job_title">Recent Job Title:</label>

            <input type="text" name="crecent_job_title" value="<?php echo htmlspecialchars($row['crecent_job_title']); ?>" disabled>

        </div>



        <div class="input-field">
    <label for="ccandidate_source">Candidate Source:</label>
    <select name="ccandidate_source" id="ccandidate_source" onchange="toggleOptions()" <?php if (!isset($_POST['edit'])) echo 'disabled'; ?>>
        <option disabled selected>Select option</option>
        <option value="PT" <?php if ($row['ccandidate_source'] == 'PT') echo 'selected'; ?>>PT</option>
        <option value="PTR" <?php if ($row['ccandidate_source'] == 'PTR') echo 'selected'; ?>>PTR</option>
        <option value="Dice Response" <?php if ($row['ccandidate_source'] == 'Dice Response') echo 'selected'; ?>>Dice Response</option>
        <option value="CB" <?php if ($row['ccandidate_source'] == 'CB') echo 'selected'; ?>>CB</option>
        <option value="Monster" <?php if ($row['ccandidate_source'] == 'Monster') echo 'selected'; ?>>Monster</option>
        <option value="Dice" <?php if ($row['ccandidate_source'] == 'Dice') echo 'selected'; ?>>Dice</option>
        <option value="IDB-Dice" <?php if ($row['ccandidate_source'] == 'IDB-Dice') echo 'selected'; ?>>IDB-Dice</option>
        <option value="IDB-CB" <?php if ($row['ccandidate_source'] == 'IDB-CB') echo 'selected'; ?>>IDB-CB</option>
        <option value="IDB-Monster" <?php if ($row['ccandidate_source'] == 'IDB-Monster') echo 'selected'; ?>>IDB-Monster</option>
        <option value="LinkedIn Personal" <?php if ($row['ccandidate_source'] == 'LinkedIn Personal') echo 'selected'; ?>>LinkedIn Personal</option>
        <option value="LinkedIn RPS" <?php if ($row['ccandidate_source'] == 'LinkedIn RPS') echo 'selected'; ?>>LinkedIn RPS</option>
        <option value="LinkedIn RPS - Job Response" <?php if ($row['ccandidate_source'] == 'LinkedIn RPS - Job Response') echo 'selected'; ?>>LinkedIn RPS - Job Response</option>
        <option value="CX Bench" <?php if ($row['ccandidate_source'] == 'CX Bench') echo 'selected'; ?>>CX Bench</option>
        <option value="Referral Client" <?php if ($row['ccandidate_source'] == 'Referral Client') echo 'selected'; ?>>Referral Client</option>
        <option value="Vendor Consolidation" <?php if ($row['ccandidate_source'] == 'Vendor Consolidation') echo 'selected'; ?>>Vendor Consolidation</option>
        <option value="Referral Vendor" <?php if ($row['ccandidate_source'] == 'Referral Vendor') echo 'selected'; ?>>Referral Vendor</option>
        <option value="Career Portal" <?php if ($row['ccandidate_source'] == 'Career Portal') echo 'selected'; ?>>Career Portal</option>
        <option value="Indeed" <?php if ($row['ccandidate_source'] == 'Indeed') echo 'selected'; ?>>Indeed</option>
        <option value="Sourcing" <?php if ($row['ccandidate_source'] == 'Sourcing') echo 'selected'; ?>>Sourcing</option>
        <option value="Rehiring" <?php if ($row['ccandidate_source'] == 'Rehiring') echo 'selected'; ?>>Rehiring</option>
        <option value="Prohires" <?php if ($row['ccandidate_source'] == 'Prohires') echo 'selected'; ?>>Prohires</option>
        <option value="Zip Recruiter" <?php if ($row['ccandidate_source'] == 'Zip Recruiter') echo 'selected'; ?>>Zip Recruiter</option>
        <option value="Mass Mail" <?php if ($row['ccandidate_source'] == 'Mass Mail') echo 'selected'; ?>>Mass Mail</option>
        <option value="LinkedIn Sourcer" <?php if ($row['ccandidate_source'] == 'LinkedIn Sourcer') echo 'selected'; ?>>LinkedIn Sourcer</option>
        <option value="Social Media" <?php if ($row['ccandidate_source'] == 'Social Media') echo 'selected'; ?>>Social Media</option>
        <option value="SRM" <?php if ($row['ccandidate_source'] == 'SRM') echo 'selected'; ?>>SRM</option>
    </select>
</div>

<!-- Shared hidden dropdown space for CX Bench, LinkedIn RPS, SRM, and LinkedIn Sourcer -->
<div class="input-field" id="shared_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
    <label id="shared_label"></label>
    <select name="shared_option" id="shared_option" onchange="combineSource()" disabled>
        <option disabled selected>Select Option</option>
    </select>
</div>
<!-- Hidden input to store the combined value -->
<input type="hidden" name="final_candidate_source" id="final_candidate_source" value="<?php echo htmlspecialchars($row['ccandidate_source']); ?>">


<script>
    function toggleOptions(selectedValue = null) {
        var source = selectedValue || document.getElementById("ccandidate_source").value;
        var sharedField = document.getElementById("shared_field");
        var sharedLabel = document.getElementById("shared_label");
        var sharedOption = document.getElementById("shared_option");

        // Hide the shared field initially
        sharedField.style.visibility = "hidden";
        sharedField.style.height = "0";
        sharedField.style.margin = "0";
        sharedField.style.padding = "0";
        sharedOption.innerHTML = '<option disabled selected>Select Option</option>'; // Clear previous options
        sharedOption.disabled = true; // Disable shared option by default

        if (source === "CX Bench") {
            sharedLabel.innerHTML = "CX Bench Options";
            sharedOption.innerHTML += `
                <option>Sushmitha S</option>
                <option>Swarnabharathi M U</option>
            `;
            showSharedField();
        } else if (source === "LinkedIn RPS") {
            sharedLabel.innerHTML = "LinkedIn RPS Options";
            sharedOption.innerHTML += `
                <option>Balaji Kumar</option>
                <option>Balaji Mohan</option>
                <option>Kumaran</option>
                <option>Naveen Senthil Kumar</option>
                <option>Omar</option>
                <option>Prashanth Ravi</option>
                <option>Sam</option>
                <option>Sindhujaa</option>
                <option>Stephen H</option>
                <option>Team Johnathan</option>
                <option>Vijaya Kannan</option>
            `;
            showSharedField();
        } else if (source === "SRM") {
            sharedLabel.innerHTML = "SRM Options";
            sharedOption.innerHTML += `
                <option>Harish Babu M</option>
            `;
            showSharedField();
        } else if (source === "LinkedIn Sourcer") {
            sharedLabel.innerHTML = "LinkedIn Sourcer Options";
            sharedOption.innerHTML += `
                <option>Karthik T</option>
            `;
            showSharedField();
        } else {
            document.getElementById("final_candidate_source").value = source; // Set final source without additional option
        }
    }

    function showSharedField() {
        var sharedField = document.getElementById("shared_field");
        var sharedOption = document.getElementById("shared_option");
        sharedField.style.visibility = "visible";
        sharedField.style.height = "auto";
        sharedField.style.margin = "1rem 0";
        sharedField.style.padding = "initial";
        sharedOption.disabled = false; // Enable shared option
    }

    function combineSource() {
        var source = document.getElementById("ccandidate_source").value;
        var option = document.getElementById("shared_option").value;
        document.getElementById("final_candidate_source").value = source + " - " + option;
    }

    // On page load or after saving changes, populate the candidate source and dependent dropdown
    window.onload = function() {
        var finalSource = document.getElementById("final_candidate_source").value;
        
        if (finalSource.includes(" - ")) {
            var parts = finalSource.split(" - ");
            document.getElementById("ccandidate_source").value = parts[0]; // Set main candidate source
            toggleOptions(parts[0]); // Populate the dependent dropdown options
            document.getElementById("shared_option").value = parts[1]; // Set dependent dropdown value
        } else {
            toggleOptions(finalSource); // For cases without dependent dropdowns
        }
    }
</script>





        <div class="input-field">
            <label for="cresume_attached">Resume Attached:</label>
            <select name="cresume_attached" id="cresume_attached" disabled>
                <option disabled selected>Select option</option>
                <option value="Yes" <?php if ($row['cresume_attached'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($row['cresume_attached'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>

        <div class="input-field">
            <label for="cphoto_id_attached">Photo ID Attached:</label>
            <select name="cphoto_id_attached" id="cphoto_id_attached" disabled>
                <option disabled selected>Select option</option>
                <option value="Yes" <?php if ($row['cphoto_id_attached'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($row['cphoto_id_attached'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>

        <div class="input-field">
            <label for="cwa_attached">Work Authorization Attached:</label>
            <select name="cwa_attached" id="cwa_attached" disabled>
                <option disabled selected>Select option</option>
                <option value="Yes" <?php if ($row['cwa_attached'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($row['cwa_attached'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>




        <div class="input-field">

            <label for="cany_other_specify">Any Other (Specify):</label>

            <input type="text" name="cany_other_specify" value="<?php echo htmlspecialchars($row['cany_other_specify']); ?>" disabled>

        </div>

    </div>

</div>





            <br><br>

            <div>

    <span class="title">Employer Details</span>

    <div class="fields">

        <div class="input-field">
            <label for="cemployer_own_corporation">Employer Own Corporation:</label>
            <select name="cemployer_own_corporation" id="cemployer_own_corporation" disabled>
                <option disabled selected>Select option</option>
                <option value="Yes" <?php if ($row['employer_own_corporation'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option value="No" <?php if ($row['employer_own_corporation'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>




        <div class="input-field">

            <label for="employer_corporation_name">Employer Corporation Name:</label>

            <input type="text" name="employer_corporation_name" value="<?php echo htmlspecialchars($row['employer_corporation_name']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="fed_id_number">Federal ID Number:</label>

            <input type="text" name="fed_id_number" value="<?php echo htmlspecialchars($row['fed_id_number']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_name">Contact Person Name:</label>

            <input type="text" name="contact_person_name" value="<?php echo htmlspecialchars($row['contact_person_name']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_designation">Contact Person Designation:</label>

            <input type="text" name="contact_person_designation" value="<?php echo htmlspecialchars($row['contact_person_designation']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_address">Contact Person Address:</label>

            <input type="text" name="contact_person_address" value="<?php echo htmlspecialchars($row['contact_person_address']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_phone_number">Contact Person Phone Number:</label>

            <input type="text" name="contact_person_phone_number" value="<?php echo htmlspecialchars($row['contact_person_phone_number']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_extension_number">Contact Person Extension Number:</label>

            <input type="text" name="contact_person_extension_number" value="<?php echo htmlspecialchars($row['contact_person_extension_number']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_email_id">Contact Person Email ID:</label>

            <input type="text" name="contact_person_email_id" value="<?php echo htmlspecialchars($row['contact_person_email_id']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="benchsale_recruiter_name">Benchsale Recruiter Name:</label>

            <input type="text" name="benchsale_recruiter_name" value="<?php echo htmlspecialchars($row['benchsale_recruiter_name']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="benchsale_recruiter_phone_number">Benchsale Recruiter Phone Number:</label>

            <input type="text" name="benchsale_recruiter_phone_number" value="<?php echo htmlspecialchars($row['benchsale_recruiter_phone_number']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="benchsale_recruiter_extension_number">Benchsale Recruiter Extension Number:</label>

            <input type="text" name="benchsale_recruiter_extension_number" value="<?php echo htmlspecialchars($row['benchsale_recruiter_extension_number']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="benchsale_recruiter_emailid">Benchsale Recruiter Email ID:</label>

            <input type="text" name="benchsale_recruiter_emailid" value="<?php echo htmlspecialchars($row['benchsale_recruiter_email_id']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="website_link">Website Link:</label>

            <input type="text" name="website_link" value="<?php echo htmlspecialchars($row['website_link']); ?>" disabled >

        </div>



        <div class="input-field">

            <label for="employer_linkedin_url">Employer LinkedIn URL:</label>

            <input type="text" name="employer_linkedin_url" value="<?php echo htmlspecialchars($row['employer_linkedin_url']); ?>" disabled>

        </div>

    </div>         

</div>





            <br>

            <div>

    <span class="title">Additional Employer Details</span>

    <div class="fields">

        <div class="input-field">
            <label for="employer_type">Employer Type:</label>
            <select name="employer_type" id="employer_type" disabled>
                <option disabled selected>Select option</option>
                <option value="Vendor Change" <?php if ($row['employer_type'] == 'Vendor Change') echo 'selected'; ?>>Vendor Change</option>
                <option value="Vendor Reference" <?php if ($row['employer_type'] == 'Vendor Reference') echo 'selected'; ?>>Vendor Reference</option>
                <option value="NA" <?php if ($row['employer_type'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>




        <div class="input-field">

            <label for="employer_corporation_name1">Employer Corporation Name (Alternate):</label>

            <input type="text" name="employer_corporation_name1" value="<?php echo htmlspecialchars($row['employer_corporation_name1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="fed_id_number1">Federal ID Number (Alternate):</label>

            <input type="text" name="fed_id_number1" value="<?php echo htmlspecialchars($row['fed_id_number1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_name1">Contact Person Name (Alternate):</label>

            <input type="text" name="contact_person_name1" value="<?php echo htmlspecialchars($row['contact_person_name1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_designation1">Contact Person Designation (Alternate):</label>

            <input type="text" name="contact_person_designation1" value="<?php echo htmlspecialchars($row['contact_person_designation1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_address1">Contact Person Address (Alternate):</label>

            <input type="text" name="contact_person_address1" value="<?php echo htmlspecialchars($row['contact_person_address1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_phone_number1">Contact Person Phone Number (Alternate):</label>

            <input type="text" name="contact_person_phone_number1" value="<?php echo htmlspecialchars($row['contact_person_phone_number1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_extension_number1">Contact Person Extension Number (Alternate):</label>

            <input type="text" name="contact_person_extension_number1" value="<?php echo htmlspecialchars($row['contact_person_extension_number1']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="contact_person_email_id1">Contact Person Email ID (Alternate):</label>

            <input type="text" name="contact_person_email_id1" value="<?php echo htmlspecialchars($row['contact_person_email_id1']); ?>" disabled>

        </div>

    </div>         

</div>









            <br>

            <div>

    <span class="title">Collaboration Details</span>

    <div class="fields">

        <div class="input-field">
            <label for="collaboration_collaborate">Collaboration:</label>
            <select name="collaboration_collaborate" id="collaboration_collaborate" disabled>
                <option disabled selected>Select option</option>
                <option value="yes" <?php if ($row['collaboration_collaborate'] == 'yes') echo 'selected'; ?>>Yes</option>
                <option value="no" <?php if ($row['collaboration_collaborate'] == 'no') echo 'selected'; ?>>No</option>
            </select>
        </div>




        <!-- Delivery Manager Dropdown -->
        <div class="input-field">
            <label for="delivery_manager">Delivery Manager:</label>
            <select name="delivery_manager" id="delivery_manager" disabled>
                <option disabled selected>Select option</option>
                <option value="Arun Franklin Joseph - 10344" <?php if ($row['delivery_manager'] == 'Arun Franklin Joseph - 10344') echo 'selected'; ?>>Arun Franklin Joseph - 10344</option>
                <option value="DinoZeoff M - 10097" <?php if ($row['delivery_manager'] == 'DinoZeoff M - 10097') echo 'selected'; ?>>DinoZeoff M - 10097</option>
                <option value="Faisal Ahamed - 12721" <?php if ($row['delivery_manager'] == 'Faisal Ahamed - 12721') echo 'selected'; ?>>Faisal Ahamed - 12721</option>
                <option value="Jack Sherman - 10137" <?php if ($row['delivery_manager'] == 'Jack Sherman - 10137') echo 'selected'; ?>>Jack Sherman - 10137</option>
                <option value="Johnathan Liazar - 10066" <?php if ($row['delivery_manager'] == 'Johnathan Liazar - 10066') echo 'selected'; ?>>Johnathan Liazar - 10066</option>
                <option value="Lance Taylor - 10082" <?php if ($row['delivery_manager'] == 'Lance Taylor - 10082') echo 'selected'; ?>>Lance Taylor - 10082</option>
                <option value="Michael Devaraj A - 10123" <?php if ($row['delivery_manager'] == 'Michael Devaraj A - 10123') echo 'selected'; ?>>Michael Devaraj A - 10123</option>
                <option value="Omar Mohamed - 10944" <?php if ($row['delivery_manager'] == 'Omar Mohamed - 10944') echo 'selected'; ?>>Omar Mohamed - 10944</option>
                <option value="Richa Verma - 10606" <?php if ($row['delivery_manager'] == 'Richa Verma - 10606') echo 'selected'; ?>>Richa Verma - 10606</option>
                <option value="Seliyan M - 10028" <?php if ($row['delivery_manager'] == 'Seliyan M - 10028') echo 'selected'; ?>>Seliyan M - 10028</option>
                <option value="Srivijayaraghavan M - 10270" <?php if ($row['delivery_manager'] == 'Srivijayaraghavan M - 10270') echo 'selected'; ?>>Srivijayaraghavan M - 10270</option>
                <option value="Vandhana R R - 10021" <?php if ($row['delivery_manager'] == 'Vandhana R R - 10021') echo 'selected'; ?>>Vandhana R R - 10021</option>
                <option value="NA" <?php if ($row['delivery_manager'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>

        <!-- Delivery Account Lead Dropdown -->
        <div class="input-field">
            <label for="delivery_account_lead">Delivery Account Lead:</label>
            <select name="delivery_account_lead" id="delivery_account_lead" disabled>
                <option disabled selected>Select option</option>
                <option value="Celestine S - 10269" <?php if ($row['delivery_account_lead'] == 'Celestine S - 10269') echo 'selected'; ?>>Celestine S - 10269</option>
                <option value="Felix B - 10094" <?php if ($row['delivery_account_lead'] == 'Felix B - 10094') echo 'selected'; ?>>Felix B - 10094</option>
                <option value="Prassanna Kumar - 11738" <?php if ($row['delivery_account_lead'] == 'Prassanna Kumar - 11738') echo 'selected'; ?>>Prassanna Kumar - 11738</option>
                <option value="Praveenkumar Kandasamy  - 12422" <?php if ($row['delivery_account_lead'] == 'Praveenkumar Kandasamy  - 12422') echo 'selected'; ?>>Praveenkumar Kandasamy  - 12422</option>
                <option value="Sinimary X - 10365" <?php if ($row['delivery_account_lead'] == 'Sinimary X - 10365') echo 'selected'; ?>>Sinimary X - 10365</option>
                <option value="Iyngaran C  - 12706" <?php if ($row['delivery_account_lead'] == 'Iyngaran C  - 12706') echo 'selected'; ?>>Iyngaran C  - 12706</option>
                <option value="NA" <?php if ($row['delivery_account_lead'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>

        <!-- Team Lead Dropdown -->
        <div class="input-field">
            <label for="team_lead">Team Lead:</label>
            <select name="team_lead" id="team_lead" disabled>
                <option disabled selected>Select option</option>
                <option value="Balaji K - 11082" <?php if ($row['team_lead'] == 'Balaji K - 11082') echo 'selected'; ?>>Balaji K - 11082</option>
                <option value="Deepak Ganesan - 12702" <?php if ($row['team_lead'] == 'Deepak Ganesan - 12702') echo 'selected'; ?>>Deepak Ganesan - 12702</option>
                <option value="Dinakaran G - 11426" <?php if ($row['team_lead'] == 'Dinakaran G - 11426') echo 'selected'; ?>>Dinakaran G - 11426</option>
                <option value="Guna Sekaran S - 10488" <?php if ($row['team_lead'] == 'Guna Sekaran S - 10488') echo 'selected'; ?>>Guna Sekaran S - 10488</option>
                <option value="Guru Samy N - 10924" <?php if ($row['team_lead'] == 'Guru Samy N - 10924') echo 'selected'; ?>>Guru Samy N - 10924</option>
                <option value="Jeorge S - 10444" <?php if ($row['team_lead'] == 'Jeorge S - 10444') echo 'selected'; ?>>Jeorge S - 10444</option>
                <option value="Jerammica Lydia J - 11203" <?php if ($row['team_lead'] == 'Jerammica Lydia J - 11203') echo 'selected'; ?>>Jerammica Lydia J - 11203</option>
                <option value="Jerry S - 10443" <?php if ($row['team_lead'] == 'Jerry S - 10443') echo 'selected'; ?>>Jerry S - 10443</option>
                <option value="Kumuthavalli Periyannan - 10681" <?php if ($row['team_lead'] == 'Kumuthavalli Periyannan - 10681') echo 'selected'; ?>>Kumuthavalli Periyannan - 10681</option>
                <option value="M Balaji - 10509" <?php if ($row['team_lead'] == 'M Balaji - 10509') echo 'selected'; ?>>M Balaji - 10509</option>
                <option value="Maheshwari M - 10627" <?php if ($row['team_lead'] == 'Maheshwari M - 10627') echo 'selected'; ?>>Maheshwari M - 10627</option>
                <option value="Manikandan Shanmugam - 12409" <?php if ($row['team_lead'] == 'Manikandan Shanmugam - 12409') echo 'selected'; ?>>Manikandan Shanmugam - 12409</option>
                <option value="Mathew P - 10714" <?php if ($row['team_lead'] == 'Mathew P - 10714') echo 'selected'; ?>>Mathew P - 10714</option>
                <option value="Melina Jones - 10360" <?php if ($row['team_lead'] == 'Melina Jones - 10360') echo 'selected'; ?>>Melina Jones - 10360</option>
                <option value="Mohamed Al Fahd M - 11062" <?php if ($row['team_lead'] == 'Mohamed Al Fahd M - 11062') echo 'selected'; ?>>Mohamed Al Fahd M - 11062</option>
                <option value="Prasanna J - 11925" <?php if ($row['team_lead'] == 'Prasanna J - 11925') echo 'selected'; ?>>Prasanna J - 11925</option>
                <option value="Prathap T - 10672" <?php if ($row['team_lead'] == 'Prathap T - 10672') echo 'selected'; ?>>Prathap T - 10672</option>
                <option value="Priya C - 11648" <?php if ($row['team_lead'] == 'Priya C - 11648') echo 'selected'; ?>>Priya C - 11648</option>
                <option value="Rajkeran A - 10518" <?php if ($row['team_lead'] == 'Rajkeran A - 10518') echo 'selected'; ?>>Rajkeran A - 10518</option>
                <option value="Ramesh Murugan - 10766" <?php if ($row['team_lead'] == 'Ramesh Murugan - 10766') echo 'selected'; ?>>Ramesh Murugan - 10766</option>
                <option value="Saral E - 10201" <?php if ($row['team_lead'] == 'Saral E - 10201') echo 'selected'; ?>>Saral E - 10201</option>
                <option value="Sastha Karthick M - 10662" <?php if ($row['team_lead'] == 'Sastha Karthick M - 10662') echo 'selected'; ?>>Sastha Karthick M - 10662</option>
                <option value="Selvakumar J - 10727" <?php if ($row['team_lead'] == 'Selvakumar J - 10727') echo 'selected'; ?>>Selvakumar J - 10727</option>
                <option value="Siraj Basha M - 10711" <?php if ($row['team_lead'] == 'Siraj Basha M - 10711') echo 'selected'; ?>>Siraj Basha M - 10711</option>
                <option value="Suriya Senthilnathan - 10643" <?php if ($row['team_lead'] == 'Suriya Senthilnathan - 10643') echo 'selected'; ?>>Suriya Senthilnathan - 10643</option>
                <option value="Veerabathiran B - 10717" <?php if ($row['team_lead'] == 'Veerabathiran B - 10717') echo 'selected'; ?>>Veerabathiran B - 10717</option>
                <option value="Vijay Karthick M - 11075" <?php if ($row['team_lead'] == 'Vijay Karthick M - 11075') echo 'selected'; ?>>Vijay Karthick M - 11075</option>
                <option value="NA" <?php if ($row['team_lead'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>

        <!-- Associate Team Lead Dropdown -->
        <div class="input-field">
            <label for="associate_team_lead">Associate Team Lead:</label>
            <select name="associate_team_lead" id="associate_team_lead" disabled>
                <option disabled selected>Select option</option>
                <option value="Abarna S - 11538" <?php if ($row['associate_team_lead'] == 'Abarna S - 11538') echo 'selected'; ?>>Abarna S - 11538</option>
                <option value="Abirami Ramdoss - 11276" <?php if ($row['associate_team_lead'] == 'Abirami Ramdoss - 11276') echo 'selected'; ?>>Abirami Ramdoss - 11276</option>
                <option value="Balaji R - 11333" <?php if ($row['associate_team_lead'] == 'Balaji R - 11333') echo 'selected'; ?>>Balaji R - 11333</option>
                <option value="Elankumaran V - 11110" <?php if ($row['associate_team_lead'] == 'Elankumaran V - 11110') echo 'selected'; ?>>Elankumaran V - 11110</option>
                <option value="K Elango V.Krishnaswamy - 12368" <?php if ($row['associate_team_lead'] == 'K Elango V.Krishnaswamy - 12368') echo 'selected'; ?>>K Elango V.Krishnaswamy - 12368</option>
                <option value="Lingaprasanth Srinivasan - 11370" <?php if ($row['associate_team_lead'] == 'Lingaprasanth Srinivasan - 11370') echo 'selected'; ?>>Lingaprasanth Srinivasan - 11370</option>
                <option value="Manojkumar B - 10780" <?php if ($row['associate_team_lead'] == 'Manojkumar B - 10780') echo 'selected'; ?>>Manojkumar B - 10780</option>
                <option value="Myvizhi Sekar - 11478" <?php if ($row['associate_team_lead'] == 'Myvizhi Sekar - 11478') echo 'selected'; ?>>Myvizhi Sekar - 11478</option>
                <option value="Naveen Senthilkumar - 11281" <?php if ($row['associate_team_lead'] == 'Naveen Senthilkumar - 11281') echo 'selected'; ?>>Naveen Senthilkumar - 11281</option>
                <option value="Pavan Kumar - 11921" <?php if ($row['associate_team_lead'] == 'Pavan Kumar - 11921') echo 'selected'; ?>>Pavan Kumar - 11921</option>
                <option value="Radhika R - 10815" <?php if ($row['associate_team_lead'] == 'Radhika R - 10815') echo 'selected'; ?>>Radhika R - 10815</option>
                <option value="Sheema H - 11042" <?php if ($row['associate_team_lead'] == 'Sheema H - 11042') echo 'selected'; ?>>Sheema H - 11042</option>
                <option value="Surya Sekar - 11224" <?php if ($row['associate_team_lead'] == 'Surya Sekar - 11224') echo 'selected'; ?>>Surya Sekar - 11224</option>
                <option value="Umera Ismail Khan - 11389" <?php if ($row['associate_team_lead'] == 'Umera Ismail Khan - 11389') echo 'selected'; ?>>Umera Ismail Khan - 11389</option>
                <option value="Venkatesan Sudharsanam - 11631" <?php if ($row['associate_team_lead'] == 'Venkatesan Sudharsanam - 11631') echo 'selected'; ?>>Venkatesan Sudharsanam - 11631</option>
                <option value="Vijay C - 11120" <?php if ($row['associate_team_lead'] == 'Vijay C - 11120') echo 'selected'; ?>>Vijay C - 11120</option>
                <option value="Vijaya Kannan S - 12568" <?php if ($row['associate_team_lead'] == 'Vijaya Kannan S - 12568') echo 'selected'; ?>>Vijaya Kannan S - 12568</option>
                <option value="TBD" <?php if ($row['associate_team_lead'] == 'TBD') echo 'selected'; ?>>TBD</option>
                <option value="NA" <?php if ($row['associate_team_lead'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>

    </div>         

</div>







                <br>

                <div>

    <span class="title">Recruiter Details</span>

    <div class="fields">



        <!-- Business Unit -->
<div class="input-field">
    <label for="business_unit">Business Unit:</label>
    <select name="business_unit" disabled>
        <option disabled selected>Select option</option>
        <option value="Sidd" <?php if ($row['business_unit'] == 'Sidd') echo 'selected'; ?>>Sidd</option>
        <option value="Oliver" <?php if ($row['business_unit'] == 'Oliver') echo 'selected'; ?>>Oliver</option>
        <option value="Nambu" <?php if ($row['business_unit'] == 'Nambu') echo 'selected'; ?>>Nambu</option>
        <option value="Rohit" <?php if ($row['business_unit'] == 'Rohit') echo 'selected'; ?>>Rohit</option>
        <option value="Vinay" <?php if ($row['business_unit'] == 'Vinay') echo 'selected'; ?>>Vinay</option>
    </select>
</div>

<!-- Client Account Lead -->
<div class="input-field">
    <label for="client_account_lead">Client Account Lead:</label>
    <select name="client_account_lead" disabled>
        <option disabled selected>Select option</option>
        <option value="Amit" <?php if ($row['client_account_lead'] == 'Amit') echo 'selected'; ?>>Amit</option>
        <option value="Abhishek" <?php if ($row['client_account_lead'] == 'Abhishek') echo 'selected'; ?>>Abhishek</option>
        <option value="Aditya" <?php if ($row['client_account_lead'] == 'Aditya') echo 'selected'; ?>>Aditya</option>
        <option value="Abhishek / Aditya" <?php if ($row['client_account_lead'] == 'Abhishek / Aditya') echo 'selected'; ?>>Abhishek / Aditya</option>
        <option value="Vijay Methani" <?php if ($row['client_account_lead'] == 'Vijay Methani') echo 'selected'; ?>>Vijay Methani</option>
        <option value="David" <?php if ($row['client_account_lead'] == 'David') echo 'selected'; ?>>David</option>
        <option value="Devna" <?php if ($row['client_account_lead'] == 'Devna') echo 'selected'; ?>>Devna</option>
        <option value="Don" <?php if ($row['client_account_lead'] == 'Don') echo 'selected'; ?>>Don</option>
        <option value="Monse" <?php if ($row['client_account_lead'] == 'Monse') echo 'selected'; ?>>Monse</option>
        <option value="Nambu" <?php if ($row['client_account_lead'] == 'Nambu') echo 'selected'; ?>>Nambu</option>
        <option value="Narayan" <?php if ($row['client_account_lead'] == 'Narayan') echo 'selected'; ?>>Narayan</option>
        <option value="Parijat" <?php if ($row['client_account_lead'] == 'Parijat') echo 'selected'; ?>>Parijat</option>
        <option value="Priscilla" <?php if ($row['client_account_lead'] == 'Priscilla') echo 'selected'; ?>>Priscilla</option>
        <option value="Sudip" <?php if ($row['client_account_lead'] == 'Sudip') echo 'selected'; ?>>Sudip</option>
        <option value="Vinay" <?php if ($row['client_account_lead'] == 'Vinay') echo 'selected'; ?>>Vinay</option>
        <option value="Prasanth Ravi" <?php if ($row['client_account_lead'] == 'Prasanth Ravi') echo 'selected'; ?>>Prasanth Ravi</option>
        <option value="Sachin Sinha" <?php if ($row['client_account_lead'] == 'Sachin Sinha') echo 'selected'; ?>>Sachin Sinha</option>
        <option value="Susan Johnson" <?php if ($row['client_account_lead'] == 'Susan Johnson') echo 'selected'; ?>>Susan Johnson</option>
        <option value="NA" <?php if ($row['client_account_lead'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<div class="input-field">
    <label>Client Partner</label>
    <select name="client_partner" disabled>
        <option disabled selected>Select option</option>
        <option value="Amit" <?php if ($row['client_partner'] == 'Amit') echo 'selected'; ?>>Amit</option>
        <option value="Abhishek" <?php if ($row['client_partner'] == 'Abhishek') echo 'selected'; ?>>Abhishek</option>
        <option value="Aditya" <?php if ($row['client_partner'] == 'Aditya') echo 'selected'; ?>>Aditya</option>
        <option value="Abhishek / Aditya" <?php if ($row['client_partner'] == 'Abhishek / Aditya') echo 'selected'; ?>>Abhishek / Aditya</option>
        <option value="Vijay Methani" <?php if ($row['client_partner'] == 'Vijay Methani') echo 'selected'; ?>>Vijay Methani</option>
        <option value="David" <?php if ($row['client_partner'] == 'David') echo 'selected'; ?>>David</option>
        <option value="NA" <?php if ($row['client_partner'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Associate Director of Delivery -->
<div class="input-field">
    <label for="associate_director_delivery">Associate Director of Delivery:</label>
    <select name="associate_director_delivery" disabled>
        <option disabled selected>Select option</option>
        <option value="Mohanavelu K.A - 12186" <?php if ($row['associate_director_delivery'] == 'Mohanavelu K.A - 12186') echo 'selected'; ?>>Mohanavelu K.A - 12186</option>
        <option value="Ajay D - 10009" <?php if ($row['associate_director_delivery'] == 'Ajay D - 10009') echo 'selected'; ?>>Ajay D - 10009</option>
        <option value="Soloman. S - 10006" <?php if ($row['associate_director_delivery'] == 'Soloman. S - 10006') echo 'selected'; ?>>Soloman. S - 10006</option>
        <option value="Manoj B.G - 10058" <?php if ($row['associate_director_delivery'] == 'Manoj B.G - 10058') echo 'selected'; ?>>Manoj B.G - 10058</option>
        <option value="NA" <?php if ($row['associate_director_delivery'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Delivery Manager 1 -->
<div class="input-field">
    <label for="delivery_manager1">Delivery Manager 1:</label>
    <select name="delivery_manager1" disabled>
        <option disabled selected>Select option</option>
        <option value="Arun Franklin Joseph - 10344" <?php if ($row['delivery_manager1'] == 'Arun Franklin Joseph - 10344') echo 'selected'; ?>>Arun Franklin Joseph - 10344</option>
        <option value="DinoZeoff M - 10097" <?php if ($row['delivery_manager1'] == 'DinoZeoff M - 10097') echo 'selected'; ?>>DinoZeoff M - 10097</option>
        <option value="Jack Sherman - 10137" <?php if ($row['delivery_manager1'] == 'Jack Sherman - 10137') echo 'selected'; ?>>Jack Sherman - 10137</option>
        <option value="Johnathan Liazar - 10066" <?php if ($row['delivery_manager1'] == 'Johnathan Liazar - 10066') echo 'selected'; ?>>Johnathan Liazar - 10066</option>
        <option value="Lance Taylor - 10082" <?php if ($row['delivery_manager1'] == 'Lance Taylor - 10082') echo 'selected'; ?>>Lance Taylor - 10082</option>
        <option value="Michael Devaraj A - 10123" <?php if ($row['delivery_manager1'] == 'Michael Devaraj A - 10123') echo 'selected'; ?>>Michael Devaraj A - 10123</option>
        <option value="Omar Mohamed - 10944" <?php if ($row['delivery_manager1'] == 'Omar Mohamed - 10944') echo 'selected'; ?>>Omar Mohamed - 10944</option>
        <option value="Richa Verma - 10606" <?php if ($row['delivery_manager1'] == 'Richa Verma - 10606') echo 'selected'; ?>>Richa Verma - 10606</option>
        <option value="Seliyan M - 10028" <?php if ($row['delivery_manager1'] == 'Seliyan M - 10028') echo 'selected'; ?>>Seliyan M - 10028</option>
        <option value="Srivijayaraghavan M - 10270" <?php if ($row['delivery_manager1'] == 'Srivijayaraghavan M - 10270') echo 'selected'; ?>>Srivijayaraghavan M - 10270</option>
        <option value="Vandhana R R - 10021" <?php if ($row['delivery_manager1'] == 'Vandhana R R - 10021') echo 'selected'; ?>>Vandhana R R - 10021</option>
        <option value="Faisal Ahamed - 12721" <?php if ($row['delivery_manager1'] == 'Faisal Ahamed - 12721') echo 'selected'; ?>>Faisal Ahamed - 12721</option>
        <option value="NA" <?php if ($row['delivery_manager1'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Delivery Account Lead 1 -->
<div class="input-field">
    <label for="delivery_account_lead1">Delivery Account Lead 1:</label>
    <select name="delivery_account_lead1" disabled>
        <option disabled selected>Select option</option>
        <option value="Celestine S - 10269" <?php if ($row['delivery_account_lead1'] == 'Celestine S - 10269') echo 'selected'; ?>>Celestine S - 10269</option>
        <option value="Felix B - 10094" <?php if ($row['delivery_account_lead1'] == 'Felix B - 10094') echo 'selected'; ?>>Felix B - 10094</option>
        <option value="Prassanna Kumar - 11738" <?php if ($row['delivery_account_lead1'] == 'Prassanna Kumar - 11738') echo 'selected'; ?>>Prassanna Kumar - 11738</option>
        <option value="Praveenkumar Kandasamy  - 12422" <?php if ($row['delivery_account_lead1'] == 'Praveenkumar Kandasamy  - 12422') echo 'selected'; ?>>Praveenkumar Kandasamy  - 12422</option>
        <option value="Sinimary X - 10365" <?php if ($row['delivery_account_lead1'] == 'Sinimary X - 10365') echo 'selected'; ?>>Sinimary X - 10365</option>
        <option value="Iyngaran C  - 12706" <?php if ($row['delivery_account_lead1'] == 'Iyngaran C  - 12706') echo 'selected'; ?>>Iyngaran C  - 12706</option>
        <option value="NA" <?php if ($row['delivery_account_lead1'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Team Lead 1 -->
<div class="input-field">
    <label for="team_lead1">Team Lead 1:</label>
    <select name="team_lead1" disabled>
        <option disabled selected>Select option</option>
        <option value="Balaji K - 11082" <?php if ($row['team_lead1'] == 'Balaji K - 11082') echo 'selected'; ?>>Balaji K - 11082</option>
        <option value="Deepak Ganesan - 12702" <?php if ($row['team_lead1'] == 'Deepak Ganesan - 12702') echo 'selected'; ?>>Deepak Ganesan - 12702</option>
        <option value="Dinakaran G - 11426" <?php if ($row['team_lead1'] == 'Dinakaran G - 11426') echo 'selected'; ?>>Dinakaran G - 11426</option>
        <option value="Guna Sekaran S - 10488" <?php if ($row['team_lead1'] == 'Guna Sekaran S - 10488') echo 'selected'; ?>>Guna Sekaran S - 10488</option>
        <option value="Guru Samy N - 10924" <?php if ($row['team_lead1'] == 'Guru Samy N - 10924') echo 'selected'; ?>>Guru Samy N - 10924</option>
        <option value="Jeorge S - 10444" <?php if ($row['team_lead1'] == 'Jeorge S - 10444') echo 'selected'; ?>>Jeorge S - 10444</option>
        <option value="Jerammica Lydia J - 11203" <?php if ($row['team_lead1'] == 'Jerammica Lydia J - 11203') echo 'selected'; ?>>Jerammica Lydia J - 11203</option>
        <option value="Jerry S - 10443" <?php if ($row['team_lead1'] == 'Jerry S - 10443') echo 'selected'; ?>>Jerry S - 10443</option>
        <option value="Kumuthavalli Periyannan - 10681" <?php if ($row['team_lead1'] == 'Kumuthavalli Periyannan - 10681') echo 'selected'; ?>>Kumuthavalli Periyannan - 10681</option>
        <option value="M Balaji - 10509" <?php if ($row['team_lead1'] == 'M Balaji - 10509') echo 'selected'; ?>>M Balaji - 10509</option>
        <option value="Maheshwari M - 10627" <?php if ($row['team_lead1'] == 'Maheshwari M - 10627') echo 'selected'; ?>>Maheshwari M - 10627</option>
        <option value="Manikandan Shanmugam - 12409" <?php if ($row['team_lead1'] == 'Manikandan Shanmugam - 12409') echo 'selected'; ?>>Manikandan Shanmugam - 12409</option>
        <option value="Mathew P - 10714" <?php if ($row['team_lead1'] == 'Mathew P - 10714') echo 'selected'; ?>>Mathew P - 10714</option>
        <option value="Melina Jones - 10360" <?php if ($row['team_lead1'] == 'Melina Jones - 10360') echo 'selected'; ?>>Melina Jones - 10360</option>
        <option value="Mohamed Al Fahd M - 11062" <?php if ($row['team_lead1'] == 'Mohamed Al Fahd M - 11062') echo 'selected'; ?>>Mohamed Al Fahd M - 11062</option>
        <option value="Prasanna J - 11925" <?php if ($row['team_lead1'] == 'Prasanna J - 11925') echo 'selected'; ?>>Prasanna J - 11925</option>
        <option value="Prathap T - 10672" <?php if ($row['team_lead1'] == 'Prathap T - 10672') echo 'selected'; ?>>Prathap T - 10672</option>
        <option value="Priya C - 11648" <?php if ($row['team_lead1'] == 'Priya C - 11648') echo 'selected'; ?>>Priya C - 11648</option>
        <option value="Rajkeran A - 10518" <?php if ($row['team_lead1'] == 'Rajkeran A - 10518') echo 'selected'; ?>>Rajkeran A - 10518</option>
        <option value="Ramesh Murugan - 10766" <?php if ($row['team_lead1'] == 'Ramesh Murugan - 10766') echo 'selected'; ?>>Ramesh Murugan - 10766</option>
        <option value="Saral E - 10201" <?php if ($row['team_lead1'] == 'Saral E - 10201') echo 'selected'; ?>>Saral E - 10201</option>
        <option value="Sastha Karthick M - 10662" <?php if ($row['team_lead1'] == 'Sastha Karthick M - 10662') echo 'selected'; ?>>Sastha Karthick M - 10662</option>
        <option value="Selvakumar J - 10727" <?php if ($row['team_lead1'] == 'Selvakumar J - 10727') echo 'selected'; ?>>Selvakumar J - 10727</option>
        <option value="Siraj Basha M - 10711" <?php if ($row['team_lead1'] == 'Siraj Basha M - 10711') echo 'selected'; ?>>Siraj Basha M - 10711</option>
        <option value="Suriya Senthilnathan - 10643" <?php if ($row['team_lead1'] == 'Suriya Senthilnathan - 10643') echo 'selected'; ?>>Suriya Senthilnathan - 10643</option>
        <option value="Veerabathiran B - 10717" <?php if ($row['team_lead1'] == 'Veerabathiran B - 10717') echo 'selected'; ?>>Veerabathiran B - 10717</option>
        <option value="Vijay Karthick M - 11075" <?php if ($row['team_lead1'] == 'Vijay Karthick M - 11075') echo 'selected'; ?>>Vijay Karthick M - 11075</option>
        <option value="TBD" <?php if ($row['team_lead1'] == 'TBD') echo 'selected'; ?>>TBD</option>
        <option value="NA" <?php if ($row['team_lead1'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Associate Team Lead 1 -->
<div class="input-field">
    <label for="associate_team_lead1">Associate Team Lead 1:</label>
    <select name="associate_team_lead1" disabled>
        <option disabled selected>Select option</option>
        <option value="Abarna S - 11538" <?php if ($row['associate_team_lead1'] == 'Abarna S - 11538') echo 'selected'; ?>>Abarna S - 11538</option>
        <option value="Abirami Ramdoss - 11276" <?php if ($row['associate_team_lead1'] == 'Abirami Ramdoss - 11276') echo 'selected'; ?>>Abirami Ramdoss - 11276</option>
        <option value="Balaji R - 11333" <?php if ($row['associate_team_lead1'] == 'Balaji R - 11333') echo 'selected'; ?>>Balaji R - 11333</option>
        <option value="Elankumaran V - 11110" <?php if ($row['associate_team_lead1'] == 'Elankumaran V - 11110') echo 'selected'; ?>>Elankumaran V - 11110</option>
        <option value="K Elango V.Krishnaswamy - 12368" <?php if ($row['associate_team_lead1'] == 'K Elango V.Krishnaswamy - 12368') echo 'selected'; ?>>K Elango V.Krishnaswamy - 12368</option>
        <option value="Lingaprasanth Srinivasan - 11370" <?php if ($row['associate_team_lead1'] == 'Lingaprasanth Srinivasan - 11370') echo 'selected'; ?>>Lingaprasanth Srinivasan - 11370</option>
        <option value="Manojkumar B - 10780" <?php if ($row['associate_team_lead1'] == 'Manojkumar B - 10780') echo 'selected'; ?>>Manojkumar B - 10780</option>
        <option value="Myvizhi Sekar - 11478" <?php if ($row['associate_team_lead1'] == 'Myvizhi Sekar - 11478') echo 'selected'; ?>>Myvizhi Sekar - 11478</option>
        <option value="Naveen Senthilkumar - 11281" <?php if ($row['associate_team_lead1'] == 'Naveen Senthilkumar - 11281') echo 'selected'; ?>>Naveen Senthilkumar - 11281</option>
        <option value="Pavan Kumar - 11921" <?php if ($row['associate_team_lead1'] == 'Pavan Kumar - 11921') echo 'selected'; ?>>Pavan Kumar - 11921</option>
        <option value="Radhika R - 10815" <?php if ($row['associate_team_lead1'] == 'Radhika R - 10815') echo 'selected'; ?>>Radhika R - 10815</option>
        <option value="Sheema H - 11042" <?php if ($row['associate_team_lead1'] == 'Sheema H - 11042') echo 'selected'; ?>>Sheema H - 11042</option>
        <option value="Surya Sekar - 11224" <?php if ($row['associate_team_lead1'] == 'Surya Sekar - 11224') echo 'selected'; ?>>Surya Sekar - 11224</option>
        <option value="Umera Ismail Khan - 11389" <?php if ($row['associate_team_lead1'] == 'Umera Ismail Khan - 11389') echo 'selected'; ?>>Umera Ismail Khan - 11389</option>
        <option value="Venkatesan Sudharsanam - 11631" <?php if ($row['associate_team_lead1'] == 'Venkatesan Sudharsanam - 11631') echo 'selected'; ?>>Venkatesan Sudharsanam - 11631</option>
        <option value="Vijay C - 11120" <?php if ($row['associate_team_lead1'] == 'Vijay C - 11120') echo 'selected'; ?>>Vijay C - 11120</option>
        <option value="Vijaya Kannan S - 12568" <?php if ($row['associate_team_lead1'] == 'Vijaya Kannan S - 12568') echo 'selected'; ?>>Vijaya Kannan S - 12568</option>
        <option value="TBD" <?php if ($row['associate_team_lead1'] == 'TBD') echo 'selected'; ?>>TBD</option>
        <option value="NA" <?php if ($row['associate_team_lead1'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>

<!-- Recruiter Name -->
<div class="input-field">
    <label for="recruiter_name">Recruiter Name:</label>
    <select name="recruiter_name" disabled>
        <option disabled selected>Select option</option>
        <option value="Aarthy Arockyaraj - 11862" <?php if ($row['recruiter_name'] == 'Aarthy Arockyaraj - 11862') echo 'selected'; ?>>Aarthy Arockyaraj - 11862</option>
        <option value="Aasath Khan Nashruddin - 12377" <?php if ($row['recruiter_name'] == 'Aasath Khan Nashruddin - 12377') echo 'selected'; ?>>Aasath Khan Nashruddin - 12377</option>
        <option value="Abdul Rahman - 12469" <?php if ($row['recruiter_name'] == 'Abdul Rahman - 12469') echo 'selected'; ?>>Abdul Rahman - 12469</option>
        <option value="Abinaya Ramesh - 12379" <?php if ($row['recruiter_name'] == 'Abinaya Ramesh - 12379') echo 'selected'; ?>>Abinaya Ramesh - 12379</option>
        <option value="Agnes Agalya Aron K - 12381" <?php if ($row['recruiter_name'] == 'Agnes Agalya Aron K - 12381') echo 'selected'; ?>>Agnes Agalya Aron K - 12381</option>
        <option value="Akash - 12670" <?php if ($row['recruiter_name'] == 'Akash - 12670') echo 'selected'; ?>>Akash - 12670</option>
        <option value="Allwin Charles Dane Jacobmaran - 12057" <?php if ($row['recruiter_name'] == 'Allwin Charles Dane Jacobmaran - 12057') echo 'selected'; ?>>Allwin Charles Dane Jacobmaran - 12057</option>
        <option value="Amisha Sulthana J - 12671" <?php if ($row['recruiter_name'] == 'Amisha Sulthana J - 12671') echo 'selected'; ?>>Amisha Sulthana J - 12671</option>
        <option value="AngelinSimi J - 11542" <?php if ($row['recruiter_name'] == 'AngelinSimi J - 11542') echo 'selected'; ?>>AngelinSimi J - 11542</option>
        <option value="Anitha Kumar - 12234" <?php if ($row['recruiter_name'] == 'Anitha Kumar - 12234') echo 'selected'; ?>>Anitha Kumar - 12234</option>
        <option value="Arumairaja A - 11974" <?php if ($row['recruiter_name'] == 'Arumairaja A - 11974') echo 'selected'; ?>>Arumairaja A - 11974</option>
        <option value="Arun Balan - 12254" <?php if ($row['recruiter_name'] == 'Arun Balan - 12254') echo 'selected'; ?>>Arun Balan - 12254</option>
        <option value="Arunachalam C M - 12556" <?php if ($row['recruiter_name'] == 'Arunachalam C M - 12556') echo 'selected'; ?>>Arunachalam C M - 12556</option>
        <option value="Arunkumar Ayyappan - 12627" <?php if ($row['recruiter_name'] == 'Arunkumar Ayyappan - 12627') echo 'selected'; ?>>Arunkumar Ayyappan - 12627</option>
        <option value="Arunkumar Ganesan - 12645" <?php if ($row['recruiter_name'] == 'Arunkumar Ganesan - 12645') echo 'selected'; ?>>Arunkumar Ganesan - 12645</option>
        <option value="Balaguru Vijayakumar - 12382" <?php if ($row['recruiter_name'] == 'Balaguru Vijayakumar - 12382') echo 'selected'; ?>>Balaguru Vijayakumar - 12382</option>
        <option value="Balakrishnan V - 11540" <?php if ($row['recruiter_name'] == 'Balakrishnan V - 11540') echo 'selected'; ?>>Balakrishnan V - 11540</option>
        <option value="Bharani Dharan Raja Sekar - 11799" <?php if ($row['recruiter_name'] == 'Bharani Dharan Raja Sekar - 11799') echo 'selected'; ?>>Bharani Dharan Raja Sekar - 11799</option>
        <option value="Bhuvaneswaran R - 12136" <?php if ($row['recruiter_name'] == 'Bhuvaneswaran R - 12136') echo 'selected'; ?>>Bhuvaneswaran R - 12136</option>
        <option value="Deepika Rose K - 11756" <?php if ($row['recruiter_name'] == 'Deepika Rose K - 11756') echo 'selected'; ?>>Deepika Rose K - 11756</option>
        <option value="Dharani K - 11605" <?php if ($row['recruiter_name'] == 'Dharani K - 11605') echo 'selected'; ?>>Dharani K - 11605</option>
        <option value="Dhashanee Shanmugam - 11962" <?php if ($row['recruiter_name'] == 'Dhashanee Shanmugam - 11962') echo 'selected'; ?>>Dhashanee Shanmugam - 11962</option>
        <option value="Dinesh Kannan - 11922" <?php if ($row['recruiter_name'] == 'Dinesh Kannan - 11922') echo 'selected'; ?>>Dinesh Kannan - 11922</option>
        <option value="Divya S Chitrarasu - 12343" <?php if ($row['recruiter_name'] == 'Divya S Chitrarasu - 12343') echo 'selected'; ?>>Divya S Chitrarasu - 12343</option>
        <option value="Elavenil Elambharathi - 11846" <?php if ($row['recruiter_name'] == 'Elavenil Elambharathi - 11846') echo 'selected'; ?>>Elavenil Elambharathi - 11846</option>
        <option value="G Abrar Shariff - 12235" <?php if ($row['recruiter_name'] == 'G Abrar Shariff - 12235') echo 'selected'; ?>>G Abrar Shariff - 12235</option>
        <option value="Gaya Priya N - 12067" <?php if ($row['recruiter_name'] == 'Gaya Priya N - 12067') echo 'selected'; ?>>Gaya Priya N - 12067</option>
        <option value="Giftsondaniel S - 12245" <?php if ($row['recruiter_name'] == 'Giftsondaniel S - 12245') echo 'selected'; ?>>Giftsondaniel S - 12245</option>
        <option value="Harindranath Raj - 11531" <?php if ($row['recruiter_name'] == 'Harindranath Raj - 11531') echo 'selected'; ?>>Harindranath Raj - 11531</option>
        <option value="Ibrahim Afreedeen - 12531" <?php if ($row['recruiter_name'] == 'Ibrahim Afreedeen - 12531') echo 'selected'; ?>>Ibrahim Afreedeen - 12531</option>
        <option value="Imran Tharik S - 12679" <?php if ($row['recruiter_name'] == 'Imran Tharik S - 12679') echo 'selected'; ?>>Imran Tharik S - 12679</option>
        <option value="Jeeva K - 12485" <?php if ($row['recruiter_name'] == 'Jeeva K - 12485') echo 'selected'; ?>>Jeeva K - 12485</option>
        <option value="Jenifer M - 11758" <?php if ($row['recruiter_name'] == 'Jenifer M - 11758') echo 'selected'; ?>>Jenifer M - 11758</option>
        <option value="Jerin Renold J - 12237" <?php if ($row['recruiter_name'] == 'Jerin Renold J - 12237') echo 'selected'; ?>>Jerin Renold J - 12237</option>
        <option value="Johnson Daniel Arockiaraj - 12723" <?php if ($row['recruiter_name'] == 'Johnson Daniel Arockiaraj - 12723') echo 'selected'; ?>>Johnson Daniel Arockiaraj - 12723</option>
        <option value="Justeen D - 11254" <?php if ($row['recruiter_name'] == 'Justeen D - 11254') echo 'selected'; ?>>Justeen D - 11254</option>
        <option value="Justinsamuvel M - 12486" <?php if ($row['recruiter_name'] == 'Justinsamuvel M - 12486') echo 'selected'; ?>>Justinsamuvel M - 12486</option>
        <option value="K Rakkesh Kumar - 12297" <?php if ($row['recruiter_name'] == 'K Rakkesh Kumar - 12297') echo 'selected'; ?>>K Rakkesh Kumar - 12297</option>
        <option value="Kanakavalli M - 11997" <?php if ($row['recruiter_name'] == 'Kanakavalli M - 11997') echo 'selected'; ?>>Kanakavalli M - 11997</option>
        <option value="Kanishkar Poonachi - 11393" <?php if ($row['recruiter_name'] == 'Kanishkar Poonachi - 11393') echo 'selected'; ?>>Kanishkar Poonachi - 11393</option>
        <option value="Karishma M - 12472" <?php if ($row['recruiter_name'] == 'Karishma M - 12472') echo 'selected'; ?>>Karishma M - 12472</option>
        <option value="Karkuzhali Rajendran - 11802" <?php if ($row['recruiter_name'] == 'Karkuzhali Rajendran - 11802') echo 'selected'; ?>>Karkuzhali Rajendran - 11802</option>
        <option value="Karthiga Kathiresan - 12206" <?php if ($row['recruiter_name'] == 'Karthiga Kathiresan - 12206') echo 'selected'; ?>>Karthiga Kathiresan - 12206</option>
        <option value="Kathiravan K - 11966" <?php if ($row['recruiter_name'] == 'Kathiravan K - 11966') echo 'selected'; ?>>Kathiravan K - 11966</option>
        <option value="Kiran Ram - 12514" <?php if ($row['recruiter_name'] == 'Kiran Ram - 12514') echo 'selected'; ?>>Kiran Ram - 12514</option>
        <option value="Kirupakaran P - 12615" <?php if ($row['recruiter_name'] == 'Kirupakaran P - 12615') echo 'selected'; ?>>Kirupakaran P - 12615</option>
        <option value="Kishore Bharathy K P Pandi - 12348" <?php if ($row['recruiter_name'] == 'Kishore Bharathy K P Pandi - 12348') echo 'selected'; ?>>Kishore Bharathy K P Pandi - 12348</option>
        <option value="Kojjam Rajasekar Dhanraj - 12717" <?php if ($row['recruiter_name'] == 'Kojjam Rajasekar Dhanraj - 12717') echo 'selected'; ?>>Kojjam Rajasekar Dhanraj - 12717</option>
        <option value="Laxma Nandhini Suresh K - 12386" <?php if ($row['recruiter_name'] == 'Laxma Nandhini Suresh K - 12386') echo 'selected'; ?>>Laxma Nandhini Suresh K - 12386</option>
        <option value="Mahadeenmohamed jaheerhussain - 12238" <?php if ($row['recruiter_name'] == 'Mahadeenmohamed jaheerhussain - 12238') echo 'selected'; ?>>Mahadeenmohamed jaheerhussain - 12238</option>
        <option value="Manikandan S - 11967" <?php if ($row['recruiter_name'] == 'Manikandan S - 11967') echo 'selected'; ?>>Manikandan S - 11967</option>
        <option value="Manoj .k - 12200" <?php if ($row['recruiter_name'] == 'Manoj .k - 12200') echo 'selected'; ?>>Manoj .k - 12200</option>
        <option value="Martina Arockia Samy - 12552" <?php if ($row['recruiter_name'] == 'Martina Arockia Samy - 12552') echo 'selected'; ?>>Martina Arockia Samy - 12552</option>
        <option value="Midunsathyaa R M S - 12518" <?php if ($row['recruiter_name'] == 'Midunsathyaa R M S - 12518') echo 'selected'; ?>>Midunsathyaa R M S - 12518</option>
        <option value="Mithran Jayaseelan - 12683" <?php if ($row['recruiter_name'] == 'Mithran Jayaseelan - 12683') echo 'selected'; ?>>Mithran Jayaseelan - 12683</option>
        <option value="Mohamed Ali - 11588" <?php if ($row['recruiter_name'] == 'Mohamed Ali - 11588') echo 'selected'; ?>>Mohamed Ali - 11588</option>
        <option value="Mohamed Idhirish M - 12625" <?php if ($row['recruiter_name'] == 'Mohamed Idhirish M - 12625') echo 'selected'; ?>>Mohamed Idhirish M - 12625</option>
        <option value="Mohamed Nawaz S - 11727" <?php if ($row['recruiter_name'] == 'Mohamed Nawaz S - 11727') echo 'selected'; ?>>Mohamed Nawaz S - 11727</option>
        <option value="Mohamed Rafi - 11523" <?php if ($row['recruiter_name'] == 'Mohamed Rafi - 11523') echo 'selected'; ?>>Mohamed Rafi - 11523</option>
        <option value="Mohamed Razith - 11109" <?php if ($row['recruiter_name'] == 'Mohamed Razith - 11109') echo 'selected'; ?>>Mohamed Razith - 11109</option>
        <option value="Mohamed Yasin - 11980" <?php if ($row['recruiter_name'] == 'Mohamed Yasin - 11980') echo 'selected'; ?>>Mohamed Yasin - 11980</option>
        <option value="Moorthy Muruganatham - 12682" <?php if ($row['recruiter_name'] == 'Moorthy Muruganatham - 12682') echo 'selected'; ?>>Moorthy Muruganatham - 12682</option>
        <option value="Mukesh R Rajan - 12352" <?php if ($row['recruiter_name'] == 'Mukesh R Rajan - 12352') echo 'selected'; ?>>Mukesh R Rajan - 12352</option>
        <option value="Mukundhan A - 12676" <?php if ($row['recruiter_name'] == 'Mukundhan A - 12676') echo 'selected'; ?>>Mukundhan A - 12676</option>
        <option value="Narayanan Ganesan - 12553" <?php if ($row['recruiter_name'] == 'Narayanan Ganesan - 12553') echo 'selected'; ?>>Narayanan Ganesan - 12553</option>
        <option value="Narean Karthick B - 12620" <?php if ($row['recruiter_name'] == 'Narean Karthick B - 12620') echo 'selected'; ?>>Narean Karthick B - 12620</option>
        <option value="Nesan M - 10673" <?php if ($row['recruiter_name'] == 'Nesan M - 10673') echo 'selected'; ?>>Nesan M - 10673</option>
        <option value="Niruban Chandrasekaran - 12609" <?php if ($row['recruiter_name'] == 'Niruban Chandrasekaran - 12609') echo 'selected'; ?>>Niruban Chandrasekaran - 12609</option>
        <option value="Parthipan Nadesan - 11885" <?php if ($row['recruiter_name'] == 'Parthipan Nadesan - 11885') echo 'selected'; ?>>Parthipan Nadesan - 11885</option>
        <option value="Pavish Balakrishnan - 12563" <?php if ($row['recruiter_name'] == 'Pavish Balakrishnan - 12563') echo 'selected'; ?>>Pavish Balakrishnan - 12563</option>
        <option value="Prabakaran Velupillai - 12256" <?php if ($row['recruiter_name'] == 'Prabakaran Velupillai - 12256') echo 'selected'; ?>>Prabakaran Velupillai - 12256</option>
        <option value="Prakashraj Chandrasekar MD - 12333" <?php if ($row['recruiter_name'] == 'Prakashraj Chandrasekar MD - 12333') echo 'selected'; ?>>Prakashraj Chandrasekar MD - 12333</option>
        <option value="Praveenraj P Sivakumar - 12390" <?php if ($row['recruiter_name'] == 'Praveenraj P Sivakumar - 12390') echo 'selected'; ?>>Praveenraj P Sivakumar - 12390</option>
        <option value="Rajarajeshwari Vadivel - 12391" <?php if ($row['recruiter_name'] == 'Rajarajeshwari Vadivel - 12391') echo 'selected'; ?>>Rajarajeshwari Vadivel - 12391</option>
        <option value="Rakshana B - 12542" <?php if ($row['recruiter_name'] == 'Rakshana B - 12542') echo 'selected'; ?>>Rakshana B - 12542</option>
        <option value="Ramanakrishnan Ganesan - 12677" <?php if ($row['recruiter_name'] == 'Ramanakrishnan Ganesan - 12677') echo 'selected'; ?>>Ramanakrishnan Ganesan - 12677</option>
        <option value="Ramesh Kumar Dharanya R - 12003" <?php if ($row['recruiter_name'] == 'Ramesh Kumar Dharanya R - 12003') echo 'selected'; ?>>Ramesh Kumar Dharanya R - 12003</option>
        <option value="Sahana Rajamansingh - 12562" <?php if ($row['recruiter_name'] == 'Sahana Rajamansingh - 12562') echo 'selected'; ?>>Sahana Rajamansingh - 12562</option>
        <option value="Sam Fedrick - 11929" <?php if ($row['recruiter_name'] == 'Sam Fedrick - 11929') echo 'selected'; ?>>Sam Fedrick - 11929</option>
        <option value="Sanjai Ramesh - 12626" <?php if ($row['recruiter_name'] == 'Sanjai Ramesh - 12626') echo 'selected'; ?>>Sanjai Ramesh - 12626</option>
        <option value="Santhosh M - 12075" <?php if ($row['recruiter_name'] == 'Santhosh M - 12075') echo 'selected'; ?>>Santhosh M - 12075</option>
        <option value="Saravana M - 11774" <?php if ($row['recruiter_name'] == 'Saravana M - 11774') echo 'selected'; ?>>Saravana M - 11774</option>
        <option value="Saravanan Rajendran - 12462" <?php if ($row['recruiter_name'] == 'Saravanan Rajendran - 12462') echo 'selected'; ?>>Saravanan Rajendran - 12462</option>
        <option value="Sattanathan B - 11709" <?php if ($row['recruiter_name'] == 'Sattanathan B - 11709') echo 'selected'; ?>>Sattanathan B - 11709</option>
        <option value="Selvakumar M - 12201" <?php if ($row['recruiter_name'] == 'Selvakumar M - 12201') echo 'selected'; ?>>Selvakumar M - 12201</option>
        <option value="Shabaresh Muthusamy - 12168" <?php if ($row['recruiter_name'] == 'Shabaresh Muthusamy - 12168') echo 'selected'; ?>>Shabaresh Muthusamy - 12168</option>
        <option value="Shanmuganantha Krishnan V - 11969" <?php if ($row['recruiter_name'] == 'Shanmuganantha Krishnan V - 11969') echo 'selected'; ?>>Shanmuganantha Krishnan V - 11969</option>
        <option value="Sharli Sangeetha J - 12628" <?php if ($row['recruiter_name'] == 'Sharli Sangeetha J - 12628') echo 'selected'; ?>>Sharli Sangeetha J - 12628</option>
        <option value="Sharmila Banu - 11903" <?php if ($row['recruiter_name'] == 'Sharmila Banu - 11903') echo 'selected'; ?>>Sharmila Banu - 11903</option>
        <option value="Silpha Roselin A - 11833" <?php if ($row['recruiter_name'] == 'Silpha Roselin A - 11833') echo 'selected'; ?>>Silpha Roselin A - 11833</option>
        <option value="Sivabalan D - 12122" <?php if ($row['recruiter_name'] == 'Sivabalan D - 12122') echo 'selected'; ?>>Sivabalan D - 12122</option>
        <option value="Sivakkumarvallalar - 11372" <?php if ($row['recruiter_name'] == 'Sivakkumarvallalar') echo 'selected'; ?>>Sivakkumarvallalar</option>
        <option value="Sivakumar Senthilnathan - 12007" <?php if ($row['recruiter_name'] == 'Sivakumar Senthilnathan - 12007') echo 'selected'; ?>>Sivakumar Senthilnathan - 12007</option>
        <option value="Sivaramakrishnan Murugesan - 12724" <?php if ($row['recruiter_name'] == 'Sivaramakrishnan Murugesan - 12724') echo 'selected'; ?>>Sivaramakrishnan Murugesan - 12724</option>
        <option value="Sivasangari Venkatasubramanian - 12479" <?php if ($row['recruiter_name'] == 'Sivasangari Venkatasubramanian - 12479') echo 'selected'; ?>>Sivasangari Venkatasubramanian - 12479</option>
        <option value="Sivasankar C - 11830" <?php if ($row['recruiter_name'] == 'Sivasankar C - 11830') echo 'selected'; ?>>Sivasankar C - 11830</option>
        <option value="Sri Ranjani Murugesan - 12174" <?php if ($row['recruiter_name'] == 'Sri Ranjani Murugesan - 12174') echo 'selected'; ?>>Sri Ranjani Murugesan - 12174</option>
        <option value="Subash Antony S - 12703" <?php if ($row['recruiter_name'] == 'Subash Antony S - 12703') echo 'selected'; ?>>Subash Antony S - 12703</option>
        <option value="Suganth T - 11940" <?php if ($row['recruiter_name'] == 'Suganth T - 11940') echo 'selected'; ?>>Suganth T - 11940</option>
        <option value="Sumeet - 12550" <?php if ($row['recruiter_name'] == 'Sumeet - 12550') echo 'selected'; ?>>Sumeet - 12550</option>
        <option value="Swetha M - 12681" <?php if ($row['recruiter_name'] == 'Swetha M - 12681') echo 'selected'; ?>>Swetha M - 12681</option>
        <option value="Syed Kabbar A - 11396" <?php if ($row['recruiter_name'] == 'Syed Kabbar A - 11396') echo 'selected'; ?>>Syed Kabbar A - 11396</option>
        <option value="Vignesh Moorthy Rajalingam - 12680" <?php if ($row['recruiter_name'] == 'Vignesh Moorthy Rajalingam - 12680') echo 'selected'; ?>>Vignesh Moorthy Rajalingam - 12680</option>
        <option value="Vignesh Palanisamy - 12402" <?php if ($row['recruiter_name'] == 'Vignesh Palanisamy - 12402') echo 'selected'; ?>>Vignesh Palanisamy - 12402</option>
        <option value="Vigneshwaran R - 12480" <?php if ($row['recruiter_name'] == 'Vigneshwaran R - 12480') echo 'selected'; ?>>Vigneshwaran R - 12480</option>
        <option value="Vigneshwaran Rajendran - 12481" <?php if ($row['recruiter_name'] == 'Vigneshwaran Rajendran - 12481') echo 'selected'; ?>>Vigneshwaran Rajendran - 12481</option>
        <option value="Vigraman Arumugam - 12566" <?php if ($row['recruiter_name'] == 'Vigraman Arumugam - 12566') echo 'selected'; ?>>Vigraman Arumugam - 12566</option>
        <option value="Vijay Chandran - 12726" <?php if ($row['recruiter_name'] == 'Vijay Chandran - 12726') echo 'selected'; ?>>Vijay Chandran - 12726</option>
        <option value="Vinothini Moorthy - 11373" <?php if ($row['recruiter_name'] == 'Vinothini Moorthy - 11373') echo 'selected'; ?>>Vinothini Moorthy - 11373</option>
        <option value="Vishal Agassivarma - 12171" <?php if ($row['recruiter_name'] == 'Vishal Agassivarma - 12171') echo 'selected'; ?>>Vishal Agassivarma - 12171</option>
        <option value="Vivek Kumar Panneerselvam - 12202" <?php if ($row['recruiter_name'] == 'Vivek Kumar Panneerselvam - 12202') echo 'selected'; ?>>Vivek Kumar Panneerselvam - 12202</option>
        <option value="TBD" <?php if ($row['recruiter_name'] == 'TBD') echo 'selected'; ?>>TBD</option>
        <option value="NA" <?php if ($row['recruiter_name'] == 'NA') echo 'selected'; ?>>NA</option>
    </select>
</div>




        <div class="input-field">

            <label for="recruiter_employee_id">Recruiter Employee ID:</label>

            <input type="text" name="recruiter_employee_id" value="<?php echo htmlspecialchars($row['recruiter_employee_id']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="pt_support">PT Support:</label>
            <select name="pt_support" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['pt_support'] == 'Abarna S - 11538') echo 'selected'; ?>>Abarna S - 11538</option>
                <option <?php if($row['pt_support'] == 'Abirami Ramdoss - 11276') echo 'selected'; ?>>Abirami Ramdoss - 11276</option>
                <option <?php if($row['pt_support'] == 'Ajay D - 10009') echo 'selected'; ?>>Ajay D - 10009</option>
                <option <?php if($row['pt_support'] == 'Arun Franklin Joseph - 10344') echo 'selected'; ?>>Arun Franklin Joseph - 10344</option>
                <option <?php if($row['pt_support'] == 'Balaji K - 11082') echo 'selected'; ?>>Balaji K - 11082</option>
                <option <?php if($row['pt_support'] == 'Balaji R - 11333') echo 'selected'; ?>>Balaji R - 11333</option>
                <option <?php if($row['pt_support'] == 'Celestine S - 10269') echo 'selected'; ?>>Celestine S - 10269</option>
                <option <?php if($row['pt_support'] == 'Deepak Ganesan - 12702') echo 'selected'; ?>>Deepak Ganesan - 12702</option>
                <option <?php if($row['pt_support'] == 'Dinakaran G - 11426') echo 'selected'; ?>>Dinakaran G - 11426</option>
                <option <?php if($row['pt_support'] == 'DinoZeoff M - 10097') echo 'selected'; ?>>DinoZeoff M - 10097</option>
                <option <?php if($row['pt_support'] == 'Elankumaran V - 11110') echo 'selected'; ?>>Elankumaran V - 11110</option>
                <option <?php if($row['pt_support'] == 'Faisal Ahamed - 12721') echo 'selected'; ?>>Faisal Ahamed - 12721</option>
                <option <?php if($row['pt_support'] == 'Felix B - 10094') echo 'selected'; ?>>Felix B - 10094</option>
                <option <?php if($row['pt_support'] == 'Guna Sekaran S - 10488') echo 'selected'; ?>>Guna Sekaran S - 10488</option>
                <option <?php if($row['pt_support'] == 'Guru Samy N - 10924') echo 'selected'; ?>>Guru Samy N - 10924</option>
                <option <?php if($row['pt_support'] == 'Iyngaran C  - 12706') echo 'selected'; ?>>Iyngaran C  - 12706</option>
                <option <?php if($row['pt_support'] == 'Jack Sherman - 10137') echo 'selected'; ?>>Jack Sherman - 10137</option>
                <option <?php if($row['pt_support'] == 'Jeorge S - 10444') echo 'selected'; ?>>Jeorge S - 10444</option>
                <option <?php if($row['pt_support'] == 'Jerammica Lydia J - 11203') echo 'selected'; ?>>Jerammica Lydia J - 11203</option>
                <option <?php if($row['pt_support'] == 'Jerry S - 10443') echo 'selected'; ?>>Jerry S - 10443</option>
                <option <?php if($row['pt_support'] == 'Johnathan Liazar - 10066') echo 'selected'; ?>>Johnathan Liazar - 10066</option>
                <option <?php if($row['pt_support'] == 'K Elango V.Krishnaswamy - 12368') echo 'selected'; ?>>K Elango V.Krishnaswamy - 12368</option>
                <option <?php if($row['pt_support'] == 'Kumuthavalli Periyannan - 10681') echo 'selected'; ?>>Kumuthavalli Periyannan - 10681</option>
                <option <?php if($row['pt_support'] == 'Lance Taylor - 10082') echo 'selected'; ?>>Lance Taylor - 10082</option>
                <option <?php if($row['pt_support'] == 'Lingaprasanth Srinivasan - 11370') echo 'selected'; ?>>Lingaprasanth Srinivasan - 11370</option>
                <option <?php if($row['pt_support'] == 'M Balaji - 10509') echo 'selected'; ?>>M Balaji - 10509</option>
                <option <?php if($row['pt_support'] == 'Maheshwari M - 10627') echo 'selected'; ?>>Maheshwari M - 10627</option>
                <option <?php if($row['pt_support'] == 'Manikandan Shanmugam - 12409') echo 'selected'; ?>>Manikandan Shanmugam - 12409</option>
                <option <?php if($row['pt_support'] == 'Manoj B.G - 10058') echo 'selected'; ?>>Manoj B.G - 10058</option>
                <option <?php if($row['pt_support'] == 'Manojkumar B - 10780') echo 'selected'; ?>>Manojkumar B - 10780</option>
                <option <?php if($row['pt_support'] == 'Mathew P - 10714') echo 'selected'; ?>>Mathew P - 10714</option>
                <option <?php if($row['pt_support'] == 'Melina Jones - 10360') echo 'selected'; ?>>Melina Jones - 10360</option>
                <option <?php if($row['pt_support'] == 'Michael Devaraj A - 10123') echo 'selected'; ?>>Michael Devaraj A - 10123</option>
                <option <?php if($row['pt_support'] == 'Mohamed Al Fahd M - 11062') echo 'selected'; ?>>Mohamed Al Fahd M - 11062</option>
                <option <?php if($row['pt_support'] == 'Mohanavelu K.A - 12186') echo 'selected'; ?>>Mohanavelu K.A - 12186</option>
                <option <?php if($row['pt_support'] == 'Myvizhi Sekar - 11478') echo 'selected'; ?>>Myvizhi Sekar - 11478</option>
                <option <?php if($row['pt_support'] == 'Naveen Senthilkumar - 11281') echo 'selected'; ?>>Naveen Senthilkumar - 11281</option>
                <option <?php if($row['pt_support'] == 'Omar Mohamed - 10944') echo 'selected'; ?>>Omar Mohamed - 10944</option>
                <option <?php if($row['pt_support'] == 'Pavan Kumar - 11921') echo 'selected'; ?>>Pavan Kumar - 11921</option>
                <option <?php if($row['pt_support'] == 'Prasanna J - 11925') echo 'selected'; ?>>Prasanna J - 11925</option>
                <option <?php if($row['pt_support'] == 'Prassanna Kumar - 11738') echo 'selected'; ?>>Prassanna Kumar - 11738</option>
                <option <?php if($row['pt_support'] == 'Prathap T - 10672') echo 'selected'; ?>>Prathap T - 10672</option>
                <option <?php if($row['pt_support'] == 'Praveenkumar Kandasamy  - 12422') echo 'selected'; ?>>Praveenkumar Kandasamy  - 12422</option>
                <option <?php if($row['pt_support'] == 'Priya C - 11648') echo 'selected'; ?>>Priya C - 11648</option>
                <option <?php if($row['pt_support'] == 'Radhika R - 10815') echo 'selected'; ?>>Radhika R - 10815</option>
                <option <?php if($row['pt_support'] == 'Rajkeran A - 10518') echo 'selected'; ?>>Rajkeran A - 10518</option>
                <option <?php if($row['pt_support'] == 'Ramesh Murugan - 10766') echo 'selected'; ?>>Ramesh Murugan - 10766</option>
                <option <?php if($row['pt_support'] == 'Richa Verma - 10606') echo 'selected'; ?>>Richa Verma - 10606</option>
                <option <?php if($row['pt_support'] == 'Saral E - 10201') echo 'selected'; ?>>Saral E - 10201</option>
                <option <?php if($row['pt_support'] == 'Sastha Karthick M - 10662') echo 'selected'; ?>>Sastha Karthick M - 10662</option>
                <option <?php if($row['pt_support'] == 'Seliyan M - 10028') echo 'selected'; ?>>Seliyan M - 10028</option>
                <option <?php if($row['pt_support'] == 'Selvakumar J - 10727') echo 'selected'; ?>>Selvakumar J - 10727</option>
                <option <?php if($row['pt_support'] == 'Sheema H - 11042') echo 'selected'; ?>>Sheema H - 11042</option>
                <option <?php if($row['pt_support'] == 'Sinimary X - 10365') echo 'selected'; ?>>Sinimary X - 10365</option>
                <option <?php if($row['pt_support'] == 'Siraj Basha M - 10711') echo 'selected'; ?>>Siraj Basha M - 10711</option>
                <option <?php if($row['pt_support'] == 'Soloman. S - 10006') echo 'selected'; ?>>Soloman. S - 10006</option>
                <option <?php if($row['pt_support'] == 'Srivijayaraghavan M - 10270') echo 'selected'; ?>>Srivijayaraghavan M - 10270</option>
                <option <?php if($row['pt_support'] == 'Suriya Senthilnathan - 10643') echo 'selected'; ?>>Suriya Senthilnathan - 10643</option>
                <option <?php if($row['pt_support'] == 'Surya Sekar - 11224') echo 'selected'; ?>>Surya Sekar - 11224</option>
                <option <?php if($row['pt_support'] == 'Umera Ismail Khan - 11389') echo 'selected'; ?>>Umera Ismail Khan - 11389</option>
                <option <?php if($row['pt_support'] == 'Vandhana R R - 10021') echo 'selected'; ?>>Vandhana R R - 10021</option>
                <option <?php if($row['pt_support'] == 'Veerabathiran B - 10717') echo 'selected'; ?>>Veerabathiran B - 10717</option>
                <option <?php if($row['pt_support'] == 'Venkatesan Sudharsanam - 11631') echo 'selected'; ?>>Venkatesan Sudharsanam - 11631</option>
                <option <?php if($row['pt_support'] == 'Vijay C - 11120') echo 'selected'; ?>>Vijay C - 11120</option>
                <option <?php if($row['pt_support'] == 'Vijay Karthick M - 11075') echo 'selected'; ?>>Vijay Karthick M - 11075</option>
                <option <?php if($row['pt_support'] == 'Vijaya Kannan S - 12568') echo 'selected'; ?>>Vijaya Kannan S - 12568</option>
                <option <?php if($row['pt_support'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>




        <div class="input-field">
            <label for="pt_ownership">PT Ownership:</label>
            <select name="pt_ownership" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['pt_ownership'] == 'Abarna S - 11538') echo 'selected'; ?>>Abarna S - 11538</option>
                <option <?php if($row['pt_ownership'] == 'Abirami Ramdoss - 11276') echo 'selected'; ?>>Abirami Ramdoss - 11276</option>
                <option <?php if($row['pt_ownership'] == 'Ajay D - 10009') echo 'selected'; ?>>Ajay D - 10009</option>
                <option <?php if($row['pt_ownership'] == 'Arun Franklin Joseph - 10344') echo 'selected'; ?>>Arun Franklin Joseph - 10344</option>
                <option <?php if($row['pt_ownership'] == 'Balaji K - 11082') echo 'selected'; ?>>Balaji K - 11082</option>
                <option <?php if($row['pt_ownership'] == 'Balaji R - 11333') echo 'selected'; ?>>Balaji R - 11333</option>
                <option <?php if($row['pt_ownership'] == 'Celestine S - 10269') echo 'selected'; ?>>Celestine S - 10269</option>
                <option <?php if($row['pt_ownership'] == 'Deepak Ganesan - 12702') echo 'selected'; ?>>Deepak Ganesan - 12702</option>
                <option <?php if($row['pt_ownership'] == 'Dinakaran G - 11426') echo 'selected'; ?>>Dinakaran G - 11426</option>
                <option <?php if($row['pt_ownership'] == 'DinoZeoff M - 10097') echo 'selected'; ?>>DinoZeoff M - 10097</option>
                <option <?php if($row['pt_ownership'] == 'Elankumaran V - 11110') echo 'selected'; ?>>Elankumaran V - 11110</option>
                <option <?php if($row['pt_ownership'] == 'Faisal Ahamed - 12721') echo 'selected'; ?>>Faisal Ahamed - 12721</option>
                <option <?php if($row['pt_ownership'] == 'Felix B - 10094') echo 'selected'; ?>>Felix B - 10094</option>
                <option <?php if($row['pt_ownership'] == 'Guna Sekaran S - 10488') echo 'selected'; ?>>Guna Sekaran S - 10488</option>
                <option <?php if($row['pt_ownership'] == 'Guru Samy N - 10924') echo 'selected'; ?>>Guru Samy N - 10924</option>
                <option <?php if($row['pt_ownership'] == 'Iyngaran C  - 12706') echo 'selected'; ?>>Iyngaran C  - 12706</option>
                <option <?php if($row['pt_ownership'] == 'Jack Sherman - 10137') echo 'selected'; ?>>Jack Sherman - 10137</option>
                <option <?php if($row['pt_ownership'] == 'Jeorge S - 10444') echo 'selected'; ?>>Jeorge S - 10444</option>
                <option <?php if($row['pt_ownership'] == 'Jerammica Lydia J - 11203') echo 'selected'; ?>>Jerammica Lydia J - 11203</option>
                <option <?php if($row['pt_ownership'] == 'Jerry S - 10443') echo 'selected'; ?>>Jerry S - 10443</option>
                <option <?php if($row['pt_ownership'] == 'Johnathan Liazar - 10066') echo 'selected'; ?>>Johnathan Liazar - 10066</option>
                <option <?php if($row['pt_ownership'] == 'K Elango V.Krishnaswamy - 12368') echo 'selected'; ?>>K Elango V.Krishnaswamy - 12368</option>
                <option <?php if($row['pt_ownership'] == 'Kumuthavalli Periyannan - 10681') echo 'selected'; ?>>Kumuthavalli Periyannan - 10681</option>
                <option <?php if($row['pt_ownership'] == 'Lance Taylor - 10082') echo 'selected'; ?>>Lance Taylor - 10082</option>
                <option <?php if($row['pt_ownership'] == 'Lingaprasanth Srinivasan - 11370') echo 'selected'; ?>>Lingaprasanth Srinivasan - 11370</option>
                <option <?php if($row['pt_ownership'] == 'M Balaji - 10509') echo 'selected'; ?>>M Balaji - 10509</option>
                <option <?php if($row['pt_ownership'] == 'Maheshwari M - 10627') echo 'selected'; ?>>Maheshwari M - 10627</option>
                <option <?php if($row['pt_ownership'] == 'Manikandan Shanmugam - 12409') echo 'selected'; ?>>Manikandan Shanmugam - 12409</option>
                <option <?php if($row['pt_ownership'] == 'Manoj B.G - 10058') echo 'selected'; ?>>Manoj B.G - 10058</option>
                <option <?php if($row['pt_ownership'] == 'Manojkumar B - 10780') echo 'selected'; ?>>Manojkumar B - 10780</option>
                <option <?php if($row['pt_ownership'] == 'Mathew P - 10714') echo 'selected'; ?>>Mathew P - 10714</option>
                <option <?php if($row['pt_ownership'] == 'Melina Jones - 10360') echo 'selected'; ?>>Melina Jones - 10360</option>
                <option <?php if($row['pt_ownership'] == 'Michael Devaraj A - 10123') echo 'selected'; ?>>Michael Devaraj A - 10123</option>
                <option <?php if($row['pt_ownership'] == 'Mohamed Al Fahd M - 11062') echo 'selected'; ?>>Mohamed Al Fahd M - 11062</option>
                <option <?php if($row['pt_ownership'] == 'Mohanavelu K.A - 12186') echo 'selected'; ?>>Mohanavelu K.A - 12186</option>
                <option <?php if($row['pt_ownership'] == 'Myvizhi Sekar - 11478') echo 'selected'; ?>>Myvizhi Sekar - 11478</option>
                <option <?php if($row['pt_ownership'] == 'Naveen Senthilkumar - 11281') echo 'selected'; ?>>Naveen Senthilkumar - 11281</option>
                <option <?php if($row['pt_ownership'] == 'Omar Mohamed - 10944') echo 'selected'; ?>>Omar Mohamed - 10944</option>
                <option <?php if($row['pt_ownership'] == 'Pavan Kumar - 11921') echo 'selected'; ?>>Pavan Kumar - 11921</option>
                <option <?php if($row['pt_ownership'] == 'Prasanna J - 11925') echo 'selected'; ?>>Prasanna J - 11925</option>
                <option <?php if($row['pt_ownership'] == 'Prassanna Kumar - 11738') echo 'selected'; ?>>Prassanna Kumar - 11738</option>
                <option <?php if($row['pt_ownership'] == 'Prathap T - 10672') echo 'selected'; ?>>Prathap T - 10672</option>
                <option <?php if($row['pt_ownership'] == 'Praveenkumar Kandasamy  - 12422') echo 'selected'; ?>>Praveenkumar Kandasamy  - 12422</option>
                <option <?php if($row['pt_ownership'] == 'Priya C - 11648') echo 'selected'; ?>>Priya C - 11648</option>
                <option <?php if($row['pt_ownership'] == 'Radhika R - 10815') echo 'selected'; ?>>Radhika R - 10815</option>
                <option <?php if($row['pt_ownership'] == 'Rajkeran A - 10518') echo 'selected'; ?>>Rajkeran A - 10518</option>
                <option <?php if($row['pt_ownership'] == 'Ramesh Murugan - 10766') echo 'selected'; ?>>Ramesh Murugan - 10766</option>
                <option <?php if($row['pt_ownership'] == 'Richa Verma - 10606') echo 'selected'; ?>>Richa Verma - 10606</option>
                <option <?php if($row['pt_ownership'] == 'Saral E - 10201') echo 'selected'; ?>>Saral E - 10201</option>
                <option <?php if($row['pt_ownership'] == 'Sastha Karthick M - 10662') echo 'selected'; ?>>Sastha Karthick M - 10662</option>
                <option <?php if($row['pt_ownership'] == 'Seliyan M - 10028') echo 'selected'; ?>>Seliyan M - 10028</option>
                <option <?php if($row['pt_ownership'] == 'Selvakumar J - 10727') echo 'selected'; ?>>Selvakumar J - 10727</option>
                <option <?php if($row['pt_ownership'] == 'Sheema H - 11042') echo 'selected'; ?>>Sheema H - 11042</option>
                <option <?php if($row['pt_ownership'] == 'Sinimary X - 10365') echo 'selected'; ?>>Sinimary X - 10365</option>
                <option <?php if($row['pt_ownership'] == 'Siraj Basha M - 10711') echo 'selected'; ?>>Siraj Basha M - 10711</option>
                <option <?php if($row['pt_ownership'] == 'Soloman. S - 10006') echo 'selected'; ?>>Soloman. S - 10006</option>
                <option <?php if($row['pt_ownership'] == 'Srivijayaraghavan M - 10270') echo 'selected'; ?>>Srivijayaraghavan M - 10270</option>
                <option <?php if($row['pt_ownership'] == 'Suriya Senthilnathan - 10643') echo 'selected'; ?>>Suriya Senthilnathan - 10643</option>
                <option <?php if($row['pt_ownership'] == 'Surya Sekar - 11224') echo 'selected'; ?>>Surya Sekar - 11224</option>
                <option <?php if($row['pt_ownership'] == 'Umera Ismail Khan - 11389') echo 'selected'; ?>>Umera Ismail Khan - 11389</option>
                <option <?php if($row['pt_ownership'] == 'Vandhana R R - 10021') echo 'selected'; ?>>Vandhana R R - 10021</option>
                <option <?php if($row['pt_ownership'] == 'Veerabathiran B - 10717') echo 'selected'; ?>>Veerabathiran B - 10717</option>
                <option <?php if($row['pt_ownership'] == 'Venkatesan Sudharsanam - 11631') echo 'selected'; ?>>Venkatesan Sudharsanam - 11631</option>
                <option <?php if($row['pt_ownership'] == 'Vijay C - 11120') echo 'selected'; ?>>Vijay C - 11120</option>
                <option <?php if($row['pt_ownership'] == 'Vijay Karthick M - 11075') echo 'selected'; ?>>Vijay Karthick M - 11075</option>
                <option <?php if($row['pt_ownership'] == 'Vijaya Kannan S - 12568') echo 'selected'; ?>>Vijaya Kannan S - 12568</option>
                <option <?php if($row['pt_ownership'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>

        <div class="input-field">
            <label for="coe_non_coe">COE/Non-COE:</label>
            <select name="coe_non_coe" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['coe_non_coe'] == 'COE') echo 'selected'; ?>>COE</option>
                <option <?php if($row['coe_non_coe'] == 'NON-COE') echo 'selected'; ?>>NON-COE</option>
            </select>
        </div>




    </div>         

</div>







            <br>

            <div>

    <span class="title">Project Details</span>

    <div class="fields">



    <div class="input-field">
        <label for="geo">Geography:</label>
        <select name="geo" disabled>
        <option disabled selected>Select option</option>
            <option <?php if($row['geo'] == 'USA') echo 'selected'; ?>>USA</option>
            <option <?php if($row['geo'] == 'MEX') echo 'selected'; ?>>MEX</option>
            <option <?php if($row['geo'] == 'CAN') echo 'selected'; ?>>CAN</option>
            <option <?php if($row['geo'] == 'CR') echo 'selected'; ?>>CR</option>
            <option <?php if($row['geo'] == 'AUS') echo 'selected'; ?>>AUS</option>
            <option <?php if($row['geo'] == 'JAP') echo 'selected'; ?>>JAP</option>
            <option <?php if($row['geo'] == 'Spain') echo 'selected'; ?>>Spain</option>
            <option <?php if($row['geo'] == 'UAE') echo 'selected'; ?>>UAE</option>
            <option <?php if($row['geo'] == 'UK') echo 'selected'; ?>>UK</option>
            <option <?php if($row['geo'] == 'PR') echo 'selected'; ?>>PR</option>
            <option <?php if($row['geo'] == 'Brazil') echo 'selected'; ?>>Brazil</option>
            <option <?php if($row['geo'] == 'Belgium') echo 'selected'; ?>>Belgium</option>
            <option <?php if($row['geo'] == 'IND') echo 'selected'; ?>>IND</option>
        </select>
    </div>




        <div class="input-field">

            <label for="entity">Entity:</label>

            <input type="text" name="entity" value="<?php echo htmlspecialchars($row['entity']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="client">Client:</label>

            <input type="text" name="client" value="<?php echo htmlspecialchars($row['client']); ?>" disabled>

        </div>

        

        <div class="input-field">

            <label for="client_manager">Client Manager:</label>

            <input type="text" name="client_manager" value="<?php echo htmlspecialchars($row['client_manager']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="client_manager_email_id">Client Manager Email ID:</label>

            <input type="text" name="client_manager_email_id" value="<?php echo htmlspecialchars($row['client_manager_email_id']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="end_client">End Client:</label>

            <input type="text" name="end_client" value="<?php echo htmlspecialchars($row['end_client']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="business_track">Business Track:</label>
            <select name="business_track" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['business_track'] == 'HCL - CS') echo 'selected'; ?>>HCL - CS</option>
                <option <?php if($row['business_track'] == 'HCL - FS') echo 'selected'; ?>>HCL - FS</option>
                <option <?php if($row['business_track'] == 'HCL - CI') echo 'selected'; ?>>HCL - CI</option>
                <option <?php if($row['business_track'] == 'Infra') echo 'selected'; ?>>Infra</option>
                <option <?php if($row['business_track'] == 'Infra - Noram 3') echo 'selected'; ?>>Infra - Noram 3</option>
                <option <?php if($row['business_track'] == 'IBM') echo 'selected'; ?>>IBM</option>
                <option <?php if($row['business_track'] == 'ERS') echo 'selected'; ?>>ERS</option>
                <option <?php if($row['business_track'] == 'NORAM 3') echo 'selected'; ?>>NORAM 3</option>
                <option <?php if($row['business_track'] == 'DPO') echo 'selected'; ?>>DPO</option>
                <option <?php if($row['business_track'] == 'Accenture - IT') echo 'selected'; ?>>Accenture - IT</option>
                <option <?php if($row['business_track'] == 'Engineering') echo 'selected'; ?>>Engineering</option>
                <option <?php if($row['business_track'] == 'NON IT') echo 'selected'; ?>>NON IT</option>
                <option <?php if($row['business_track'] == 'Digital') echo 'selected'; ?>>Digital</option>
                <option <?php if($row['business_track'] == 'NON Digital') echo 'selected'; ?>>NON Digital</option>
                <option <?php if($row['business_track'] == 'CIS - Cognizant Infrastructure Services') echo 'selected'; ?>>CIS - Cognizant Infrastructure Services</option>
                <option <?php if($row['business_track'] == 'NA') echo 'selected'; ?>>NA</option>
            </select>
        </div>




        <div class="input-field">

            <label for="industry">Industry:</label>

            <input type="text" name="industry" value="<?php echo htmlspecialchars($row['industry']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="experience_in_expertise_role">Experience in Expertise Role:</label>

            <input type="text" name="experience_in_expertise_role" value="<?php echo htmlspecialchars($row['experience_in_expertise_role']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="job_code">Job Code:</label>

            <input type="text" name="job_code" value="<?php echo htmlspecialchars($row['job_code']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="job_title">Job Title:</label>

            <input type="text" name="job_title" value="<?php echo htmlspecialchars($row['job_title']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="primary_skill">Primary Skill:</label>

            <input type="text" name="primary_skill" value="<?php echo htmlspecialchars($row['primary_skill']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="secondary_skill">Secondary Skill:</label>

            <input type="text" name="secondary_skill" value="<?php echo htmlspecialchars($row['secondary_skill']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="term">Term:</label>
            <select name="term" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['term'] == 'CON') echo 'selected'; ?>>CON</option>
                <option <?php if($row['term'] == 'C2H') echo 'selected'; ?>>C2H</option>
                <option <?php if($row['term'] == 'FTE') echo 'selected'; ?>>FTE</option>
                <option <?php if($row['term'] == '1099') echo 'selected'; ?>>1099</option>
            </select>
        </div>




        <div class="input-field">

            <label for="duration">Duration:</label>

            <input type="text" name="duration" value="<?php echo htmlspecialchars($row['duration']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="project_location">Project Location:</label>

            <input type="text" name="project_location" value="<?php echo htmlspecialchars($row['project_location']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="start_date">Start Date:</label>

            <input type="text" name="start_date" value="<?php echo htmlspecialchars($row['start_date']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="end_date">End Date:</label>

            <input type="text" name="end_date" value="<?php echo htmlspecialchars($row['end_date']); ?>" disabled >

        </div>



        <div class="input-field">

            <label for="payrate">Payrate:</label>

            <input type="text" name="payrate" value="<?php echo htmlspecialchars($row['payrate']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="clientrate">Client Rate:</label>

            <input type="text" name="clientrate" value="<?php echo htmlspecialchars($row['clientrate']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="margin">Margin:</label>

            <input type="text" name="margin" value="<?php echo htmlspecialchars($row['margin']); ?>" disabled>

        </div>



        <div class="input-field">

            <label for="vendor_fee">Vendor Fee:</label>

            <input type="text" name="vendor_fee" value="<?php echo htmlspecialchars($row['vendor_fee']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="margin_deviation_approval">Margin Deviation Approval (Yes/No):</label>
            <select name="margin_deviation_approval" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['margin_deviation_approval'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option <?php if($row['margin_deviation_approval'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>




        <div class="input-field">

            <label for="margin_deviation_reason">Margin Deviation Reason:</label>

            <input type="text" name="margin_deviation_reason" value="<?php echo htmlspecialchars($row['margin_deviation_reason']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="ratecard_adherence">Ratecard Adherence (Yes/No):</label>
            <select name="ratecard_adherence" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['ratecard_adherence'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option <?php if($row['ratecard_adherence'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>


        <div class="input-field">
            <label for="ratecard_deviation_approved">Ratecard Deviation Approved (Yes/No):</label>
            <select name="ratecard_deviation_approved" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['ratecard_deviation_approved'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option <?php if($row['ratecard_deviation_approved'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>



        <div class="input-field">

            <label for="ratecard_deviation_reason">Ratecard Deviation Reason:</label>

            <input type="text" name="ratecard_deviation_reason" value="<?php echo htmlspecialchars($row['ratecard_deviation_reason']); ?>" disabled>

        </div>



        



        <div class="input-field">

            <label for="payment_term">Payment Term:</label>

            <input type="text" name="payment_term" value="<?php echo htmlspecialchars($row['payment_term']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="payment_term_approval">Payment Term Approval (Yes/No):</label>
            <select name="payment_term_approval" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['payment_term_approval'] == 'Yes') echo 'selected'; ?>>Yes</option>
                <option <?php if($row['payment_term_approval'] == 'No') echo 'selected'; ?>>No</option>
            </select>
        </div>




        <div class="input-field">

            <label for="payment_term_deviation_reason">Payment Term Deviation Reason:</label>

            <input type="text" name="payment_term_deviation_reason" value="<?php echo htmlspecialchars($row['payment_term_deviation_reason']); ?>" disabled>

        </div>



        <div class="input-field">
            <label for="type">Type:</label>
            <select name="type" disabled>
            <option disabled selected>Select option</option>
                <option <?php if($row['type'] == 'Deal') echo 'selected'; ?>>Deal</option>
                <option <?php if($row['type'] == 'PT') echo 'selected'; ?>>PT</option>
                <option <?php if($row['type'] == 'PTR') echo 'selected'; ?>>PTR</option>
                <option <?php if($row['type'] == 'VC') echo 'selected'; ?>>VC</option>
            </select>
        </div>


        <!-- <div class="input-field">

            <label for="status">Status:</label>

            <input type="text" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" disabled>

        </div> -->



        <!-- Add hidden field for record ID -->

        <input type="hidden" name="record_id" value="<?php echo htmlspecialchars($row['id']); ?>">



    </div>         

</div>





                



                <div class="input-field">

                    <button type="submit">Update</button>

                </div> 



            </div>   

        </div>

    </form>

</div>



<script src="script.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script type="text/javascript">

        document.getElementById('myForm').addEventListener('submit', function(event) {

    event.preventDefault(); // Prevent the form from submitting immediately



    // Show confirmation dialog

    Swal.fire({

        title: 'Are you sure?',

        text: "Do you want to submit the form?",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#3085d6',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes, submit it!'

    }).then((result) => {

        if (result.isConfirmed) {

            // Show loading spinner

            Swal.fire({

                title: 'Submitting...',

                text: 'Please wait while we process your request.',

                didOpen: () => {

                    Swal.showLoading(); // Show the loading spinner

                },

                allowOutsideClick: false,

                allowEscapeKey: false

            });



            // Use FormData to handle the form data

            const form = event.target;

            const formData = new FormData(form);



            fetch(form.action, {

                method: 'POST',

                body: formData

            })

            .then(response => response.json())

            .then(data => {

                // Hide the loading spinner and show success or error message

                Swal.close(); // Close the loading spinner

                if (data.status === 'success') {

                    Swal.fire({

                        title: 'Submitted!',

                        text: data.message,

                        icon: 'success'

                    }).then(() => {

                        // Reload the page after successful submission

                        window.location.href = 'paperworkallrecords.php';

                    });

                } else {

                    Swal.fire({

                        title: 'Error!',

                        text: data.message,

                        icon: 'error'

                    });

                }

            })

            .catch(error => {

                // Hide the loading spinner and show error message

                Swal.close(); // Close the loading spinner

                Swal.fire({

                    title: 'Error!',

                    text: 'An error occurred while submitting the form.',

                    icon: 'error'

                });

            });

        }

    });

});



    </script>

<script>
    document.getElementById('editBtn').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default button behavior (like form submission)

        // Get all form fields inside the form (input, select, textarea)
        const formFields = document.querySelectorAll('#myForm input, #myForm select, #myForm textarea');

        // Ensure the fields are found
        if (formFields.length > 0) {
            // Check the current state of the first field
            const isDisabled = formFields[0].disabled;

            // Toggle the disabled state of all form fields
            formFields.forEach(field => {
                field.disabled = !isDisabled; // Enable if disabled, disable if enabled
            });

            // Toggle button text and icon between 'Edit' and 'Non-Edit'
            if (isDisabled) {
                this.innerHTML = '<i class="fas fa-times-circle"></i> Non-Edit'; // Switch to 'Non-Edit'
            } else {
                this.innerHTML = '<i class="fas fa-edit"></i> Edit'; // Switch to 'Edit'
            }
        } else {
            console.error('No form fields found!');
        }
    });
</script>




</body>

</html>