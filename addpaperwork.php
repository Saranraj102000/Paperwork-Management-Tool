<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: paperworklogin.php"); // Redirect if not logged in
    exit();
}

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
    <link rel="stylesheet" href="addpaperworkstyles.css">
    <style>
        /* ===== Google Font Import - Poppins ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            display: flex;
            justify-content: center;
            margin: 30px;
        }

        .form-content {
            width: 100%;
            max-width: 1400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-content h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-content .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-content .form-group {
            flex: 1;
            margin-right: 15px;
        }

        .form-content .form-group:last-child {
            margin-right: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #4070f4;
            outline: none;
        }

        .form-submit {
            text-align: center;
        }

        .form-submit button {
            background-color: #4070f4;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-submit button:hover {
            background-color: #265df2;
        }

        /* Responsive adjustment for smaller screens */
        @media (max-width: 768px) {
            .form-content .form-row {
                flex-direction: column;
            }

            .form-content .form-group {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }

        /* Highlight effect for the matched field */
.highlight {
    background-color: yellow;
    transition: background-color 0.5s ease;
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
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" id="searchField" placeholder="Search for fields...">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div>
                
                </div>

                <script>
                  document.getElementById('searchField').addEventListener('keyup', function() {
                    var searchQuery = this.value.toLowerCase();
                    var formGroups = document.querySelectorAll('.form-group');
                    var found = false; // To ensure scrolling to the first matched field

                    formGroups.forEach(function(group) {
                        var labelText = group.querySelector('label').innerText.toLowerCase(); // Get the label text

                        // Scroll to the field if the label matches the search query
                        if (labelText.includes(searchQuery) && !found) {
                            found = true; // Only scroll to the first match
                            group.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Smooth scroll
                            group.classList.add('highlight'); // Add highlight effect
                            setTimeout(function() {
                                group.classList.remove('highlight'); // Remove highlight after a short delay
                            }, 2000); // Highlight for 2 seconds
                        }
                    });
                });

                </script>

                <!-- <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div> -->
            </div>



            <!-- ======================= Form Container ================== -->
            <!-- ======================= Form Container ================== -->
            <form id="myForm" method="POST" action="testsubmit.php">
                <div class="form-container">
                    <div class="form-content">
                        <h2>Consultant Details Form</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Candidate First Name <span style="color: red;">*</span></label>
                                <input type="text" name="cfirst_name" required>
                            </div>

                            <div class="form-group">
                                <label>Candidate Last Name </label>
                                <input type="text" name="clast_name" >
                            </div>
                            <div class="form-group">
                                <label>Ceipal Applicant ID</label>
                                <input type="number" name="ceipal_id" >
                            </div>

                            <div class="form-group">
                                <label>Candidate LinkedIN URL</label>
                                <input type="text" name="clinkedin_url" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="cdob" >
                            </div>
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="number" name="cmobilenumber" >
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="cemail" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Location (city, state)</label>
                                <input type="text" name="clocation" >
                            </div>
                            <div class="form-group">
                                <label>Home Address</label>
                                <input type="text" name="chomeaddress" >
                            </div>
                            <div class="form-group">
                                <label for="ssn">SSN (Last 4 digits)</label>
                                <input type="text" id="ssn" name="cssn" >
                            </div>
                        </div>

                        <div class="form-row">
    <div class="form-group">
        <label for="work-status">Work Authorization Status</label>
        <select id="work-status" name="cwork_authorization_status" onchange="toggleWorkStatusOptions()">
            <option value="" disabled selected>Select Work Status</option>
            <option value="us-citizen">US Citizen</option>
            <option value="green-card">Green Card</option>
            <option value="TN">TN</option>
            <option value="h1b">H1B</option>
            <option value="mexican">Mexican Citizen</option>
            <option value="canadian">Canadian Citizen</option>
            <option value="canadian-permit">Canadian Work Permit</option>
            <option value="aus-citizen">Australian Citizen</option>
            <option value="cr-citizen">CR Citizen</option>
            <option value="gc-ead">GC EAD</option>
            <option value="opt">OPT EAD</option>
            <option value="h4-ead">H4 EAD</option>
            <option value="cpt">CPT</option>
            <option value="others">Others</option>
        </select>
    </div>
    <!-- V-Validate Status dropdown, shown only for H1B -->
    <div class="form-group" id="v_validate_status_field" style="display: none;">
        <label for="v_validate_status">V-Validate Status</label>
        <select name="cv_validate_status" id="v_validate_status" onchange="updateFinalWorkStatus()">
            <option disabled selected>Select option</option>
            <option>Genuine</option>
            <option>Questionable</option>
            <option>Clear</option>
            <option>Invalid Copy</option>
            <option>Pending</option>
            <option>Not Sent - Stamp Copy</option>
            <option value="NA">NA</option>
        </select>
    </div>
    <input type="hidden" id="final_work_status" name="final_work_status" value="">
</div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="certifications">Certifications</label>
                                <input type="text" id="certifications" name="ccertifications" >
                            </div>
                            <div class="form-group">
                                <label for="experience">Overall Experience</label>
                                <input type="text" id="experience" name="coverall_experience" >
                            </div>
                            <div class="form-group">
                                <label for="recent-job">Recent Job Title</label>
                                <input type="text" id="recent-job" name="crecent_job_title" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Candidate Source</label>
                                <select name="ccandidate_source" id="candidate_source" onchange="toggleOptions()" >
                                    <option disabled selected>Select option</option>
                                    <option>PT</option>
                                    <option>PTR</option>
                                    <option>Dice Response</option>
                                    <option>CB</option>
                                    <option>Monster</option>
                                    <option>Dice</option>
                                    <option>IDB-Dice</option>
                                    <option>IDB-CB</option>
                                    <option>IDB-Monster</option>
                                    <option>LinkedIn Personal</option>
                                    <option>LinkedIn RPS</option>
                                    <option>LinkedIn RPS - Job Response</option>
                                    <option>CX Bench</option>
                                    <option>Referral Client</option>
                                    <option>Vendor Consolidation</option>
                                    <option>Referral Vendor</option>
                                    <option>Career Portal</option>
                                    <option>Indeed</option>
                                    <option>Sourcing</option>
                                    <option>Rehiring</option>
                                    <option>Prohires</option>
                                    <option>Zip Recruiter</option>
                                    <option>Mass Mail</option>
                                    <option>LinkedIn Sourcer</option>
                                    <option>Social Media</option>
                                    <option>SRM</option>
                                </select>
                            </div>
                            <!-- Shared hidden dropdown space for CX Bench, LinkedIn RPS, SRM, and LinkedIn Sourcer -->
                            <div class="form-group" id="shared_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
                                <label id="shared_label"></label>
                                <select name="shared_option" id="shared_option" onchange="combineSource()">
                                    <option disabled selected>Select Option</option>
                                </select>
                            </div>
                            <input type="hidden" name="final_candidate_source" id="final_candidate_source" value="">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Resume Attached</label>
                                <select name="cresume_attached" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Photo-ID Attached</label>
                                <select name="cphoto_id_attached" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>WA Attached</label>
                                <select name="cwa_attached" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Any Other Specify</label>
                                <input type="text" name="cany_other_specify" >
                            </div>
                        </div>

                        <h2>Employer Details</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Own Corporation</label>
                                <select name="cemployer_own_corporation" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Employer Corporation Name</label>
                                <input type="text" name="employer_corporation_name" >
                            </div>
                            <div class="form-group">
                                <label>FED ID Number</label>
                                <input type="text" name="fed_id_number" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Contact Person Name (Signing authority)</label>
                                <input type="text" name="contact_person_name" >
                            </div>
                            <div class="form-group">
                                <label>Contact Person Designation</label>
                                <input type="text" name="contact_person_designation" >
                            </div>
                            <div class="form-group">
                                <label>Contact Person Address</label>
                                <input type="text" name="contact_person_address" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Contact Person Phone Number</label>
                                <input type="number" name="contact_person_phone_number" >
                            </div>
                            <div class="form-group">
                                <label>Contact Person Extension Number</label>
                                <input type="number" name="contact_person_extension_number" >
                            </div>
                            <div class="form-group">
                                <label>Contact Person Email ID</label>
                                <input type="email" name="contact_person_email_id" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Benchsale Recruiter Name</label>
                                <input type="text" name="benchsale_recruiter_name" >
                            </div>
                            <div class="form-group">
                                <label>Benchsale Recruiter Phone Number</label>
                                <input type="number" name="benchsale_recruiter_phone_number" >
                            </div>
                            <div class="form-group">
                                <label>Benchsale Recruiter Extension Number</label>
                                <input type="number" name="benchsale_recruiter_extension_number" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Benchsale Recruiter Email ID</label>
                                <input type="email" name="benchsale_recruiter_email_id" >
                            </div>
                            <div class="form-group">
                                <label>Website Link</label>
                                <input type="text" name="website_link" >
                            </div>
                            <div class="form-group">
                                <label>Employer LinkedIn URL</label>
                                <input type="text" name="employer_linkedin_url" >
                            </div>
                        </div>

                        <h2>Additional Employer Details</h2>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Employer Type</label>
                                <select name="employer_type" id="employer_type" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option value="Vendor Change">Vendor Change</option>
                                    <option value="Vendor Reference">Vendor Reference</option>
                                    <option value="NA">NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4" id="employer_corporation_name_field">
                                <label>Employer Corporation Name</label>
                                <input type="text" name="employer_corporation_name1" id="employer_corporation_name1" class="form-control" >
                            </div>
                            <div class="form-group col-md-4" id="fed_id_number_field">
                                <label>FED ID Number</label>
                                <input type="text" name="fed_id_number1" id="fed_id_number1" class="form-control" >
                            </div>
                            <div class="form-group col-md-4" id="contact_person_name_field">
                                <label>Contact Person Name (Signing authority)</label>
                                <input type="text" name="contact_person_name1" id="contact_person_name1" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4" id="contact_person_designation_field">
                                <label>Contact Person Designation</label>
                                <input type="text" name="contact_person_designation1" id="contact_person_designation1" class="form-control" >
                            </div>
                            <div class="form-group col-md-4" id="contact_person_address_field">
                                <label>Contact Person Address</label>
                                <input type="text" name="contact_person_address1" id="contact_person_address1" class="form-control" >
                            </div>
                            <div class="form-group col-md-4" id="contact_person_phone_number_field">
                                <label>Contact Person Phone Number</label>
                                <input type="number" name="contact_person_phone_number1" id="contact_person_phone_number1" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4" id="contact_person_extension_number_field">
                                <label>Contact Person Extension Number</label>
                                <input type="number" name="contact_person_extension_number1" id="contact_person_extension_number1" class="form-control" >
                            </div>
                            <div class="form-group col-md-4" id="contact_person_email_id_field">
                                <label>Contact Person Email ID</label>
                                <input type="email" name="contact_person_email_id1" id="contact_person_email_id1" class="form-control" >
                            </div>
                        </div>

                        <h2>Collaboration Details</h2>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Collaborate</label>
                                <select name="collaboration_collaborate" id="collaboration_collaborate" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="delivery_row_1" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
                            <div class="form-group col-md-4" id="delivery_manager_field">
                                <label>Delivery Manager</label>
                                <select name="delivery_manager" id="delivery_manager" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Arun Franklin Joseph - 10344</option>
                                    <option>DinoZeoff M - 10097</option>
                                    <option>Faisal Ahamed - 12721</option>
                                    <option>Jack Sherman - 10137</option>
                                    <option>Johnathan Liazar - 10066</option>
                                    <option>Lance Taylor - 10082</option>
                                    <option>Michael Devaraj A - 10123</option>
                                    <option>Omar Mohamed - 10944</option>
                                    <option>Richa Verma - 10606</option>
                                    <option>Seliyan M - 10028</option>
                                    <option>Srivijayaraghavan M - 10270</option>
                                    <option>Vandhana R R - 10021</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4" id="delivery_account_lead_field">
                                <label>Delivery Account Lead</label>
                                <select name="delivery_account_lead" id="delivery_account_lead" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Celestine S - 10269</option>
                                    <option>Felix B - 10094</option>
                                    <option>Prassanna Kumar - 11738</option>
                                    <option>Praveenkumar Kandasamy - 12422</option>
                                    <option>Sinimary X - 10365</option>
                                    <option>Iyngaran C - 12706</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4" id="team_lead_field">
                                <label>Team Lead</label>
                                <select name="team_lead" id="team_lead" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Balaji K - 11082</option>
                                    <option>Deepak Ganesan - 12702</option>
                                    <option>Dinakaran G - 11426</option>
                                    <option>Guna Sekaran S - 10488</option>
                                    <option>Guru Samy N - 10924</option>
                                    <option>Jeorge S - 10444</option>
                                    <option>Jerammica Lydia J - 11203</option>
                                    <option>Jerry S - 10443</option>
                                    <option>Kumuthavalli Periyannan - 10681</option>
                                    <option>M Balaji - 10509</option>
                                    <option>Maheshwari M - 10627</option>
                                    <option>Manikandan Shanmugam - 12409</option>
                                    <option>Mathew P - 10714</option>
                                    <option>Melina Jones - 10360</option>
                                    <option>Mohamed Al Fahd M - 11062</option>
                                    <option>Prasanna J - 11925</option>
                                    <option>Prathap T - 10672</option>
                                    <option>Priya C - 11648</option>
                                    <option>Rajkeran A - 10518</option>
                                    <option>Ramesh Murugan - 10766</option>
                                    <option>Saral E - 10201</option>
                                    <option>Sastha Karthick M - 10662</option>
                                    <option>Selvakumar J - 10727</option>
                                    <option>Siraj Basha M - 10711</option>
                                    <option>Suriya Senthilnathan - 10643</option>
                                    <option>Veerabathiran B - 10717</option>
                                    <option>Vijay Karthick M - 11075</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="delivery_row_2" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
                            <div class="form-group col-md-4" id="associate_team_lead_field">
                                <label>Associate Team Lead</label>
                                <select name="associate_team_lead" id="associate_team_lead" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Abarna S - 11538</option>
                                    <option>Abirami Ramdoss - 11276</option>
                                    <option>Balaji R - 11333</option>
                                    <option>Elankumaran V - 11110</option>
                                    <option>K Elango V.Krishnaswamy - 12368</option>
                                    <option>Lingaprasanth Srinivasan - 11370</option>
                                    <option>Manojkumar B - 10780</option>
                                    <option>Myvizhi Sekar - 11478</option>
                                    <option>Naveen Senthilkumar - 11281</option>
                                    <option>Pavan Kumar - 11921</option>
                                    <option>Radhika R - 10815</option>
                                    <option>Sheema H - 11042</option>
                                    <option>Surya Sekar - 11224</option>
                                    <option>Umera Ismail Khan - 11389</option>
                                    <option>Venkatesan Sudharsanam - 11631</option>
                                    <option>Vijay C - 11120</option>
                                    <option>Vijaya Kannan S - 12568</option>
                                    <option>TBD</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>

                        <h2>Recruiter Details</h2>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Business Unit</label>
                                <select name="business_unit" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Sidd</option>
                                    <option>Oliver</option>
                                    <option>Nambu</option>
                                    <option>Rohit</option>
                                    <option>Vinay</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Client Account Lead</label>
                                <select name="client_account_lead" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Amit</option>
                                    <option>Abhishek</option>
                                    <option>Aditya</option>
                                    <option>Abhishek / Aditya</option>
                                    <option>Vijay Methani</option>
                                    <option>David</option>
                                    <option>Devna</option>
                                    <option>Don</option>
                                    <option>Monse</option>
                                    <option>Nambu</option>
                                    <option>Narayan</option>
                                    <option>Parijat</option>
                                    <option>Priscilla</option>
                                    <option>Sudip</option>
                                    <option>Vinay</option>
                                    <option>Prasanth Ravi</option>
                                    <option>Sachin Sinha</option>
                                    <option>Susan Johnson</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Client Partner</label>
                                <select name="client_partner" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Amit</option>
                                    <option>Abhishek</option>
                                    <option>Aditya</option>
                                    <option>Abhishek / Aditya</option>
                                    <option>Vijay Methani</option>
                                    <option>David</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Associate Director Delivery</label>
                                <select name="associate_director_delivery" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Mohanavelu K.A - 12186</option>
                                    <option>Ajay D - 10009</option>
                                    <option>Soloman. S - 10006</option>
                                    <option>Manoj B.G - 10058</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Delivery Manager</label>
                                <select name="delivery_manager1" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Arun Franklin Joseph - 10344</option>
                                    <option>DinoZeoff M - 10097</option>
                                    <option>Jack Sherman - 10137</option>
                                    <option>Johnathan Liazar - 10066</option>
                                    <option>Lance Taylor - 10082</option>
                                    <option>Michael Devaraj A - 10123</option>
                                    <option>Omar Mohamed - 10944</option>
                                    <option>Richa Verma - 10606</option>
                                    <option>Seliyan M - 10028</option>
                                    <option>Srivijayaraghavan M - 10270</option>
                                    <option>Vandhana R R - 10021</option>
                                    <option>Faisal Ahamed - 12721</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Delivery Account Lead</label>
                                <select name="delivery_account_lead1" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Celestine S - 10269</option>
                                    <option>Felix B - 10094</option>
                                    <option>Prassanna Kumar - 11738</option>
                                    <option>Praveenkumar Kandasamy - 12422</option>
                                    <option>Sinimary X - 10365</option>
                                    <option>Iyngaran C - 12706</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Team Lead</label>
                                <select name="team_lead1" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Balaji K - 11082</option>
                                    <option>Deepak Ganesan - 12702</option>
                                    <option>Dinakaran G - 11426</option>
                                    <option>Guna Sekaran S - 10488</option>
                                    <option>Guru Samy N - 10924</option>
                                    <option>Jeorge S - 10444</option>
                                    <option>Jerammica Lydia J - 11203</option>
                                    <option>Jerry S - 10443</option>
                                    <option>Kumuthavalli Periyannan - 10681</option>
                                    <option>M Balaji - 10509</option>
                                    <option>Maheshwari M - 10627</option>
                                    <option>Manikandan Shanmugam - 12409</option>
                                    <option>Mathew P - 10714</option>
                                    <option>Melina Jones - 10360</option>
                                    <option>Mohamed Al Fahd M - 11062</option>
                                    <option>Prasanna J - 11925</option>
                                    <option>Prathap T - 10672</option>
                                    <option>Priya C - 11648</option>
                                    <option>Rajkeran A - 10518</option>
                                    <option>Ramesh Murugan - 10766</option>
                                    <option>Saral E - 10201</option>
                                    <option>Sastha Karthick M - 10662</option>
                                    <option>Selvakumar J - 10727</option>
                                    <option>Siraj Basha M - 10711</option>
                                    <option>Suriya Senthilnathan - 10643</option>
                                    <option>Veerabathiran B - 10717</option>
                                    <option>Vijay Karthick M - 11075</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Associate Team Lead</label>
                                <select name="associate_team_lead1" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Abarna S - 11538</option>
                                    <option>Abirami Ramdoss - 11276</option>
                                    <option>Balaji R - 11333</option>
                                    <option>Elankumaran V - 11110</option>
                                    <option>K Elango V.Krishnaswamy - 12368</option>
                                    <option>Lingaprasanth Srinivasan - 11370</option>
                                    <option>Manojkumar B - 10780</option>
                                    <option>Myvizhi Sekar - 11478</option>
                                    <option>Naveen Senthilkumar - 11281</option>
                                    <option>Pavan Kumar - 11921</option>
                                    <option>Radhika R - 10815</option>
                                    <option>Sheema H - 11042</option>
                                    <option>Surya Sekar - 11224</option>
                                    <option>Umera Ismail Khan - 11389</option>
                                    <option>Venkatesan Sudharsanam - 11631</option>
                                    <option>Vijay C - 11120</option>
                                    <option>Vijaya Kannan S - 12568</option>
                                    <option>TBD</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Recruiter Name</label>
                                <select name="recruiter_name" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Aarthy Arockyaraj - 11862</option>
                                    <option>Aasath Khan Nashruddin - 12377</option>
                                    <option>Abdul Rahman - 12469</option>
                                    <option>Abinaya Ramesh - 12379</option>
                                    <option>Agnes Agalya Aron K - 12381</option>
                                    <option>Akash - 12670</option>
                                    <option>Allwin Charles Dane Jacobmaran - 12057</option>
                                    <option>Amisha Sulthana J - 12671</option>
                                    <option>AngelinSimi J - 11542</option>
                                    <option>Anitha Kumar - 12234</option>
                                    <option>Arumairaja A - 11974</option>
                                    <option>Arun Balan - 12254</option>
                                    <option>Arunachalam C M - 12556</option>
                                    <option>Arunkumar Ayyappan - 12627</option>
                                    <option>Arunkumar Ganesan - 12645</option>
                                    <option>Balaguru Vijayakumar - 12382</option>
                                    <option>Balakrishnan V - 11540</option>
                                    <option>Bharani Dharan Raja Sekar - 11799</option>
                                    <option>Bhuvaneswaran R - 12136</option>
                                    <option>Deepika Rose K - 11756</option>
                                    <option>Dharani K - 11605</option>
                                    <option>Dhashanee Shanmugam - 11962</option>
                                    <option>Dinesh Kannan - 11922</option>
                                    <option>Divya S Chitrarasu - 12343</option>
                                    <option>Elavenil Elambharathi - 11846</option>
                                    <option>G Abrar Shariff - 12235</option>
                                    <option>Gaya Priya N - 12067</option>
                                    <option>Giftsondaniel S - 12245</option>
                                    <option>Harindranath Raj - 11531</option>
                                    <option>Ibrahim Afreedeen - 12531</option>
                                    <option>Imran Tharik S - 12679</option>
                                    <option>Jeeva K - 12485</option>
                                    <option>Jenifer M - 11758</option>
                                    <option>Jerin Renold J - 12237</option>
                                    <option>Johnson Daniel Arockiaraj - 12723</option>
                                    <option>Justeen D - 11254</option>
                                    <option>Justinsamuvel M - 12486</option>
                                    <option>K Rakkesh Kumar - 12297</option>
                                    <option>Kanakavalli M - 11997</option>
                                    <option>Kanishkar Poonachi - 11393</option>
                                    <option>Karishma M - 12472</option>
                                    <option>Karkuzhali Rajendran - 11802</option>
                                    <option>Karthiga Kathiresan - 12206</option>
                                    <option>Kathiravan K - 11966</option>
                                    <option>Kiran Ram - 12514</option>
                                    <option>Kirupakaran P - 12615</option>
                                    <option>Kishore Bharathy K P Pandi - 12348</option>
                                    <option>Kojjam Rajasekar Dhanraj - 12717</option>
                                    <option>Laxma Nandhini Suresh K - 12386</option>
                                    <option>Mahadeenmohamed jaheerhussain - 12238</option>
                                    <option>Manikandan S - 11967</option>
                                    <option>Manoj .k - 12200</option>
                                    <option>Martina Arockia Samy - 12552</option>
                                    <option>Midunsathyaa R M S - 12518</option>
                                    <option>Mithran Jayaseelan - 12683</option>
                                    <option>Mohamed Ali - 11588</option>
                                    <option>Mohamed Idhirish M - 12625</option>
                                    <option>Mohamed Nawaz S - 11727</option>
                                    <option>Mohamed Rafi - 11523</option>
                                    <option>Mohamed Razith - 11109</option>
                                    <option>Mohamed Yasin - 11980</option>
                                    <option>Moorthy Muruganatham - 12682</option>
                                    <option>Mukesh R Rajan - 12352</option>
                                    <option>Mukundhan A - 12676</option>
                                    <option>Narayanan Ganesan - 12553</option>
                                    <option>Narean Karthick B - 12620</option>
                                    <option>Nesan M - 10673</option>
                                    <option>Niruban Chandrasekaran - 12609</option>
                                    <option>Parthipan Nadesan - 11885</option>
                                    <option>Pavish Balakrishnan - 12563</option>
                                    <option>Prabakaran Velupillai - 12256</option>
                                    <option>Prakashraj Chandrasekar MD - 12333</option>
                                    <option>Praveenraj P Sivakumar - 12390</option>
                                    <option>Rajarajeshwari Vadivel - 12391</option>
                                    <option>Rakshana B - 12542</option>
                                    <option>Ramanakrishnan Ganesan - 12677</option>
                                    <option>Ramesh Kumar Dharanya R - 12003</option>
                                    <option>Sahana Rajamansingh - 12562</option>
                                    <option>Sam Fedrick - 11929</option>
                                    <option>Sanjai Ramesh - 12626</option>
                                    <option>Santhosh M - 12075</option>
                                    <option>Saravana M - 11774</option>
                                    <option>Saravanan Rajendran - 12462</option>
                                    <option>Sattanathan B - 11709</option>
                                    <option>Selvakumar M - 12201</option>
                                    <option>Shabaresh Muthusamy - 12168</option>
                                    <option>Shanmuganantha Krishnan V - 11969</option>
                                    <option>Sharli Sangeetha J - 12628</option>
                                    <option>Sharmila Banu - 11903</option>
                                    <option>Silpha Roselin A - 11833</option>
                                    <option>Sivabalan D - 12122</option>
                                    <option>Sivakkumarvallalar - 11372</option>
                                    <option>Sivakumar Senthilnathan - 12007</option>
                                    <option>Sivaramakrishnan Murugesan - 12724</option>
                                    <option>Sivasangari Venkatasubramanian - 12479</option>
                                    <option>Sivasankar C - 11830</option>
                                    <option>Sri Ranjani Murugesan - 12174</option>
                                    <option>Subash Antony S - 12703</option>
                                    <option>Suganth T - 11940</option>
                                    <option>Sumeet - 12550</option>
                                    <option>Swetha M - 12681</option>
                                    <option>Syed Kabbar A - 11396</option>
                                    <option>Vignesh Moorthy Rajalingam - 12680</option>
                                    <option>Vignesh Palanisamy - 12402</option>
                                    <option>Vigneshwaran R - 12480</option>
                                    <option>Vigneshwaran Rajendran - 12481</option>
                                    <option>Vigraman Arumugam - 12566</option>
                                    <option>Vijay Chandran - 12726</option>
                                    <option>Vinothini Moorthy - 11373</option>
                                    <option>Vishal Agassivarma - 12171</option>
                                    <option>Vivek Kumar Panneerselvam - 12202</option>
                                    <option>TBD</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Recruiter Employee ID</label>
                                <input type="text" name="recruiter_employee_id" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>PT Support</label>
                                <select name="pt_support" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Abarna S - 11538</option>
                                    <option>Abirami Ramdoss - 11276</option>
                                    <option>Ajay D - 10009</option>
                                    <option>Arun Franklin Joseph - 10344</option>
                                    <option>Balaji K - 11082</option>
                                    <option>Balaji R - 11333</option>
                                    <option>Celestine S - 10269</option>
                                    <option>Deepak Ganesan - 12702</option>
                                    <option>Dinakaran G - 11426</option>
                                    <option>DinoZeoff M - 10097</option>
                                    <option>Elankumaran V - 11110</option>
                                    <option>Faisal Ahamed - 12721</option>
                                    <option>Felix B - 10094</option>
                                    <option>Guna Sekaran S - 10488</option>
                                    <option>Guru Samy N - 10924</option>
                                    <option>Iyngaran C - 12706</option>
                                    <option>Jack Sherman - 10137</option>
                                    <option>Jeorge S - 10444</option>
                                    <option>Jerammica Lydia J - 11203</option>
                                    <option>Jerry S - 10443</option>
                                    <option>Johnathan Liazar - 10066</option>
                                    <option>K Elango V.Krishnaswamy - 12368</option>
                                    <option>Kumuthavalli Periyannan - 10681</option>
                                    <option>Lance Taylor - 10082</option>
                                    <option>Lingaprasanth Srinivasan - 11370</option>
                                    <option>M Balaji - 10509</option>
                                    <option>Maheshwari M - 10627</option>
                                    <option>Manikandan Shanmugam - 12409</option>
                                    <option>Manoj B.G - 10058</option>
                                    <option>Manojkumar B - 10780</option>
                                    <option>Mathew P - 10714</option>
                                    <option>Melina Jones - 10360</option>
                                    <option>Michael Devaraj A - 10123</option>
                                    <option>Mohamed Al Fahd M - 11062</option>
                                    <option>Mohanavelu K.A - 12186</option>
                                    <option>Myvizhi Sekar - 11478</option>
                                    <option>Naveen Senthilkumar - 11281</option>
                                    <option>Omar Mohamed - 10944</option>
                                    <option>Pavan Kumar - 11921</option>
                                    <option>Prasanna J - 11925</option>
                                    <option>Prassanna Kumar - 11738</option>
                                    <option>Prathap T - 10672</option>
                                    <option>Praveenkumar Kandasamy - 12422</option>
                                    <option>Priya C - 11648</option>
                                    <option>Radhika R - 10815</option>
                                    <option>Rajkeran A - 10518</option>
                                    <option>Ramesh Murugan - 10766</option>
                                    <option>Richa Verma - 10606</option>
                                    <option>Saral E - 10201</option>
                                    <option>Sastha Karthick M - 10662</option>
                                    <option>Seliyan M - 10028</option>
                                    <option>Selvakumar J - 10727</option>
                                    <option>Sheema H - 11042</option>
                                    <option>Sinimary X - 10365</option>
                                    <option>Siraj Basha M - 10711</option>
                                    <option>Soloman. S - 10006</option>
                                    <option>Srivijayaraghavan M - 10270</option>
                                    <option>Suriya Senthilnathan - 10643</option>
                                    <option>Surya Sekar - 11224</option>
                                    <option>Umera Ismail Khan - 11389</option>
                                    <option>Vandhana R R - 10021</option>
                                    <option>Veerabathiran B - 10717</option>
                                    <option>Venkatesan Sudharsanam - 11631</option>
                                    <option>Vijay C - 11120</option>
                                    <option>Vijay Karthick M - 11075</option>
                                    <option>Vijaya Kannan S - 12568</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>PT Ownership</label>
                                <select name="pt_ownership" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Abarna S - 11538</option>
                                    <option>Abirami Ramdoss - 11276</option>
                                    <option>Ajay D - 10009</option>
                                    <option>Arun Franklin Joseph - 10344</option>
                                    <option>Balaji K - 11082</option>
                                    <option>Balaji R - 11333</option>
                                    <option>Celestine S - 10269</option>
                                    <option>Deepak Ganesan - 12702</option>
                                    <option>Dinakaran G - 11426</option>
                                    <option>DinoZeoff M - 10097</option>
                                    <option>Elankumaran V - 11110</option>
                                    <option>Faisal Ahamed - 12721</option>
                                    <option>Felix B - 10094</option>
                                    <option>Guna Sekaran S - 10488</option>
                                    <option>Guru Samy N - 10924</option>
                                    <option>Iyngaran C - 12706</option>
                                    <option>Jack Sherman - 10137</option>
                                    <option>Jeorge S - 10444</option>
                                    <option>Jerammica Lydia J - 11203</option>
                                    <option>Jerry S - 10443</option>
                                    <option>Johnathan Liazar - 10066</option>
                                    <option>K Elango V.Krishnaswamy - 12368</option>
                                    <option>Kumuthavalli Periyannan - 10681</option>
                                    <option>Lance Taylor - 10082</option>
                                    <option>Lingaprasanth Srinivasan - 11370</option>
                                    <option>M Balaji - 10509</option>
                                    <option>Maheshwari M - 10627</option>
                                    <option>Manikandan Shanmugam - 12409</option>
                                    <option>Manoj B.G - 10058</option>
                                    <option>Manojkumar B - 10780</option>
                                    <option>Mathew P - 10714</option>
                                    <option>Melina Jones - 10360</option>
                                    <option>Michael Devaraj A - 10123</option>
                                    <option>Mohamed Al Fahd M - 11062</option>
                                    <option>Mohanavelu K.A - 12186</option>
                                    <option>Myvizhi Sekar - 11478</option>
                                    <option>Naveen Senthilkumar - 11281</option>
                                    <option>Omar Mohamed - 10944</option>
                                    <option>Pavan Kumar - 11921</option>
                                    <option>Prasanna J - 11925</option>
                                    <option>Prassanna Kumar - 11738</option>
                                    <option>Prathap T - 10672</option>
                                    <option>Praveenkumar Kandasamy - 12422</option>
                                    <option>Priya C - 11648</option>
                                    <option>Radhika R - 10815</option>
                                    <option>Rajkeran A - 10518</option>
                                    <option>Ramesh Murugan - 10766</option>
                                    <option>Richa Verma - 10606</option>
                                    <option>Saral E - 10201</option>
                                    <option>Sastha Karthick M - 10662</option>
                                    <option>Seliyan M - 10028</option>
                                    <option>Selvakumar J - 10727</option>
                                    <option>Sheema H - 11042</option>
                                    <option>Sinimary X - 10365</option>
                                    <option>Siraj Basha M - 10711</option>
                                    <option>Soloman. S - 10006</option>
                                    <option>Srivijayaraghavan M - 10270</option>
                                    <option>Suriya Senthilnathan - 10643</option>
                                    <option>Surya Sekar - 11224</option>
                                    <option>Umera Ismail Khan - 11389</option>
                                    <option>Vandhana R R - 10021</option>
                                    <option>Veerabathiran B - 10717</option>
                                    <option>Venkatesan Sudharsanam - 11631</option>
                                    <option>Vijay C - 11120</option>
                                    <option>Vijay Karthick M - 11075</option>
                                    <option>Vijaya Kannan S - 12568</option>
                                    <option>NA</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>COE/NON-COE</label>
                                <select name="coe_non_coe" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>COE</option>
                                    <option>NON-COE</option>
                                </select>
                            </div>
                        </div>

                        <h2>Project Details</h2>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>GEO</label>
                                <select name="geo" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>USA</option>
                                    <option>MEX</option>
                                    <option>CAN</option>
                                    <option>CR</option>
                                    <option>AUS</option>
                                    <option>JAP</option>
                                    <option>Spain</option>
                                    <option>UAE</option>
                                    <option>UK</option>
                                    <option>PR</option>
                                    <option>Brazil</option>
                                    <option>Belgium</option>
                                    <option>IND</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Entity</label>
                                <input type="text" name="entity" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Client</label>
                                <input type="text" name="client" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Client Manager</label>
                                <input type="text" name="client_manager" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Client Manager Email ID</label>
                                <input type="email" name="client_manager_email_id" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>End Client</label>
                                <input type="text" name="end_client" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Business Track</label>
                                <select name="business_track" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>HCL - CS</option>
                                    <option>HCL - FS</option>
                                    <option>HCL - CI</option>
                                    <option>Infra</option>
                                    <option>Infra - Noram 3</option>
                                    <option>IBM</option>
                                    <option>ERS</option>
                                    <option>NORAM 3</option>
                                    <option>DPO</option>
                                    <option>Accenture - IT</option>
                                    <option>Engineering</option>
                                    <option>NON IT</option>
                                    <option>Digital</option>
                                    <option>NON Digital</option>
                                    <option>CIS - Cognizant Infrastructure Services</option>
                                    <option>NA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Industry</label>
                                <input type="text" name="industry" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Experience in Expertise Role | Hands on</label>
                                <input type="text" name="experience_in_expertise_role" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Job Code</label>
                                <input type="text" name="job_code" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Job Title / Role</label>
                                <input type="text" name="job_title" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Primary Skill</label>
                                <input type="text" name="primary_skill" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Secondary Skill</label>
                                <input type="text" name="secondary_skill" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Term</label>
                                <select name="term" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>CON</option>
                                    <option>C2H</option>
                                    <option>FTE</option>
                                    <option>1099</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Duration</label>
                                <input type="text" name="duration" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Project Location</label>
                                <input type="text" name="project_location" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Pay rate/Salary</label>
                                <input type="text" name="payrate" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Client rate/Salary</label>
                                <input type="text" name="clientrate" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Margin</label>
                                <input type="text" name="margin" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Vendor Fee (If Applicable)</label>
                                <input type="text" name="vendor_fee" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Margin Deviation Approval (Yes/No)</label>
                                <select name="margin_deviation_approval" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Margin Deviation Reason</label>
                                <input type="text" name="margin_deviation_reason" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Ratecard Adherence (Yes/No)</label>
                                <select name="ratecard_adherence" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Ratecard Deviation Approved (Yes/No)</label>
                                <select name="ratecard_deviation_approved" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Ratecard Deviation Reason</label>
                                <input type="text" name="ratecard_deviation_reason" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Payment Term</label>
                                <input type="text" name="payment_term" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Payment Term Approval (Yes/No)</label>
                                <select name="payment_term_approval" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Payment Term Deviation Reason</label>
                                <input type="text" name="payment_term_deviation_reason" class="form-control" >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Type</label>
                                <select name="type" class="form-control" >
                                    <option disabled selected>Select option</option>
                                    <option>Deal</option>
                                    <option>PT</option>
                                    <option>PTR</option>
                                    <option>VC</option>
                                </select>
                            </div>
                        </div>


                        <!-- Submit Button Row -->
                        <div class="form-row">
                            <div class="form-group col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" 
                                    style="background-color: #007bff; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; border: none;">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        // Add hovered class to selected list item
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
    </script>

<script>
        // Function to toggle visibility of V-Validate Status field
    function toggleWorkStatusOptions() {
        var workStatus = document.getElementById("work-status").value;
        var validateField = document.getElementById("v_validate_status_field");
        var validateStatusInput = document.getElementById("v_validate_status");

        // Show the V-Validate field only if H1B is selected
        if (workStatus === "h1b") {
            validateField.style.display = "block";
            validateStatusInput.value = ""; // Clear previous selection if field is shown
        } else {
            validateField.style.display = "none";
            validateStatusInput.value = "NA"; // Set to NA if field is hidden
        }

        // Update final work status with the current selections
        updateFinalWorkStatus();
    }

    // Function to update the hidden input with the combined work authorization status
    function updateFinalWorkStatus() {
        var workStatus = document.getElementById("work-status").value;
        var validateStatus = document.getElementById("v_validate_status").value;
        document.getElementById("final_work_status").value = workStatus + (validateStatus && validateStatus !== "NA" ? " - " + validateStatus : "");
    }

        // Candidate Source dropdown change script
        function toggleOptions() {
            var source = document.getElementById("candidate_source").value;
            var sharedField = document.getElementById("shared_field");
            var sharedLabel = document.getElementById("shared_label");
            var sharedOption = document.getElementById("shared_option");

            // Hide the shared field initially
            sharedField.style.visibility = "hidden";
            sharedField.style.height = "0";
            sharedField.style.margin = "0";
            sharedField.style.padding = "0";
            sharedOption.innerHTML = '<option disabled selected>Select Option</option>'; // Clear previous options

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
                // Set final candidate source if no extra options are needed
                document.getElementById("final_candidate_source").value = source;
            }
        }

        function showSharedField() {
            var sharedField = document.getElementById("shared_field");
            sharedField.style.visibility = "visible";
            sharedField.style.height = "auto";
            sharedField.style.margin = "1rem 0";
            sharedField.style.padding = "initial";
        }

        function combineSource() {
            var source = document.getElementById("candidate_source").value;
            var option = document.getElementById("shared_option").value;
            document.getElementById("final_candidate_source").value = source + " - " + option;
        }
    </script>

    <script>
        document.getElementById('employer_type').addEventListener('change', function() {
            const value = this.value;
            const fields = [
                document.getElementById('employer_corporation_name_field'),
                document.getElementById('fed_id_number_field'),
                document.getElementById('contact_person_name_field'),
                document.getElementById('contact_person_designation_field'),
                document.getElementById('contact_person_address_field'),
                document.getElementById('contact_person_phone_number_field'),
                document.getElementById('contact_person_extension_number_field'),
                document.getElementById('contact_person_email_id_field')
            ];

            const inputs = {
                employer_corporation_name1: document.getElementById('employer_corporation_name1'),
                fed_id_number1: document.getElementById('fed_id_number1'),
                contact_person_name1: document.getElementById('contact_person_name1'),
                contact_person_designation1: document.getElementById('contact_person_designation1'),
                contact_person_address1: document.getElementById('contact_person_address1'),
                contact_person_phone_number1: document.getElementById('contact_person_phone_number1'),
                contact_person_extension_number1: document.getElementById('contact_person_extension_number1'),
                contact_person_email_id1: document.getElementById('contact_person_email_id1')
            };

            if (value === 'NA') {
                fields.forEach(field => {
                    field.style.visibility = 'hidden';
                    field.style.height = '0';
                    field.style.margin = '0';
                    field.style.padding = '0';
                });

                Object.entries(inputs).forEach(([key, input]) => {
                    if (key === 'contact_person_phone_number1' || key === 'contact_person_extension_number1') {
                        input.value = '00000';
                    } else {
                        input.value = 'NA';
                    }
                    input.setAttribute('readonly', true);
                });
            } else {
                fields.forEach(field => {
                    field.style.visibility = 'visible';
                    field.style.height = '';
                    field.style.margin = '';
                    field.style.padding = '';
                });

                Object.values(inputs).forEach(input => {
                    input.value = '';
                    input.removeAttribute('readonly');
                });
            }
        });
    </script>

    <script>
        document.getElementById('collaboration_collaborate').addEventListener('change', function() {
            const value = this.value;
            const fields = [
                document.getElementById('delivery_manager_field'),
                document.getElementById('delivery_account_lead_field'),
                document.getElementById('team_lead_field'),
                document.getElementById('associate_team_lead_field')
            ];

            const rows = [
                document.getElementById('delivery_row_1'),
                document.getElementById('delivery_row_2')
            ];

            const inputs = {
                delivery_manager: document.getElementById('delivery_manager'),
                delivery_account_lead: document.getElementById('delivery_account_lead'),
                team_lead: document.getElementById('team_lead'),
                associate_team_lead: document.getElementById('associate_team_lead')
            };

            if (value === 'no') {
                // Hide the fields and rows
                rows.forEach(row => {
                    row.style.visibility = 'hidden';
                    row.style.height = '0';
                    row.style.margin = '0';
                    row.style.padding = '0';
                });

                // Set input values to 'NA'
                Object.values(inputs).forEach(input => {
                    input.value = 'NA';
                });
            } else if (value === 'yes') {
                // Show the rows
                rows.forEach(row => {
                    row.style.visibility = 'visible';
                    row.style.height = '';
                    row.style.margin = '';
                    row.style.padding = '';
                });

                // Clear input values when "Yes" is selected
                Object.values(inputs).forEach(input => {
                    input.value = '';
                });
            }
        });
    </script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript">
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent traditional form submission

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
                // Show loading spinner while processing the submission
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Display loading spinner
                    }
                });

                // Prepare form data for submission
                const form = event.target;
                const formData = new FormData(form);

                // Submit the form via AJAX/fetch
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Expect JSON response
                .then(data => {
                    // If submission is successful
                    if (data.status === 'success') {
                        // Display success message
                        Swal.fire({
                            title: 'Submitted!',
                            text: 'The paperwork has been submitted successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optionally reset the form after success
                            form.reset();

                            // Redirect to the dashboard
                            window.location.href = 'dashboard.php';
                        });
                    } else {
                        // Handle error if submission fails
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred: ' + data.message,
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    // Handle fetch errors
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



    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
    let inactivityTime = function () {
        let time;
        // Reset the timer on user activity
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.ontouchstart = resetTimer; // For mobile

        function logout() {
            alert("You have been logged out due to inactivity.");
            // Redirect to the logout or home page
            window.location.href = 'logout.php'; // Update this URL for your actual logout page
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(() => {
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
                        logout(); // Logout
                    }
                });
            }, 60 * 1000); // Timeout after 1 minute (60 seconds) of inactivity
        }
    };

    inactivityTime(); // Start the inactivity timer
</script>


<script>
    // Save data to local storage when any input changes
    const form = document.getElementById('myForm');
    form.addEventListener('input', function () {
        const formData = {};
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            formData[input.name] = input.value;
        });
        localStorage.setItem('savedFormData', JSON.stringify(formData));
    });

    // Load data from local storage on page load
    window.addEventListener('load', function () {
        const savedData = JSON.parse(localStorage.getItem('savedFormData'));
        if (savedData) {
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (savedData[input.name]) {
                    input.value = savedData[input.name];
                }
            });
        }
    });

    // Clear saved data on successful form submission
    form.addEventListener('submit', function () {
        localStorage.removeItem('savedFormData');
    });

    // Optional: Add a button to allow users to manually clear saved data
    function clearSavedData() {
        localStorage.removeItem('savedFormData');
        form.reset(); // Reset form fields if needed
        alert('Saved form data cleared.');
    }
</script>

</body>

</html>
