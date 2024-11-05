<?php

session_start();





if (!isset($_SESSION['email'])) {
    header("Location: animatedlogin.php"); // Redirect if not logged in
    exit();
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

    <link rel="stylesheet" href="homestyles.css">

    <link rel="stylesheet" href="https://use.typekit.net/xxxxxx.css"> <!-- Replace with your actual link -->

    <!----===== Iconscout CSS ===== -->

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome Icons -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <title>Responsive Registration Form </title>

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

.container form{

position: relative;

margin-top: 16px;

min-height: 3350px;

background-color: #fff;

overflow: hidden;

}


/* @keyframes gradientAnimation {

    0% { background-position: 0% 50%; }

    50% { background-position: 100% 50%; }

    100% { background-position: 0% 50%; }

} */


/* =============== Globals ============== */
* {
  font-family: "Ubuntu", sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --blue: #2a2185;
  --white: #fff;
  --gray: #f5f5f5;
  --black1: #222;
  --black2: #999;
}

body {
  min-height: 100vh;
  overflow-x: hidden;
}

.container {
  position: relative;
  width: 100%;
}

/* =============== Navigation ================ */
.navigation {
  position: fixed;
  width: 300px;
  height: 100%;
  background: var(--blue);
  border-left: 10px solid var(--blue);
  transition: 0.5s;
  overflow: hidden;
}
.navigation.active {
  width: 80px;
}

.navigation ul {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}

.navigation ul li {
  position: relative;
  width: 100%;
  list-style: none;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}

.navigation ul li:hover,
.navigation ul li.hovered {
  background-color: var(--white);
}

.navigation ul li:nth-child(1) {
  margin-bottom: 40px;
  pointer-events: none;
}

.navigation ul li a {
  position: relative;
  display: block;
  width: 100%;
  display: flex;
  text-decoration: none;
  color: var(--white);
}
.navigation ul li:hover a,
.navigation ul li.hovered a {
  color: var(--blue);
}

.navigation ul li a .icon {
  position: relative;
  display: block;
  min-width: 60px;
  height: 60px;
  line-height: 75px;
  text-align: center;
}
.navigation ul li a .icon ion-icon {
  font-size: 1.75rem;
}

.navigation ul li a .title {
  position: relative;
  display: block;
  padding: 0 10px;
  height: 60px;
  line-height: 60px;
  text-align: start;
  white-space: nowrap;
}

/* --------- curve outside ---------- */
.navigation ul li:hover a::before,
.navigation ul li.hovered a::before {
  content: "";
  position: absolute;
  right: 0;
  top: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px 35px 0 10px var(--white);
  pointer-events: none;
}
.navigation ul li:hover a::after,
.navigation ul li.hovered a::after {
  content: "";
  position: absolute;
  right: 0;
  bottom: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px -35px 0 10px var(--white);
  pointer-events: none;
}



    </style>


<body>


    <div class="container scrollable-container">

    <center>

        <header>

            <img src="images.png" alt="Image" style="width: 50px; height: auto; margin-right: 5px; vertical-align: middle; margin-top: -10px;">

            <span style="font-size: 24px; color: #000;">Paperwork Form</span>

        </header>

    </center>







        <!-- <a href="logout.php" class="logout-button">

            <i class="fa fa-sign-out-alt"></i> Logout

        </a> -->



        <a href="dashboard.php" class="back-button">
            <i class="fas fa-home"></i> Home
        </a>




<br>

        <form id="myForm" method="POST" action="testsubmit.php" enctype="multipart/form-data">

            <div class="form first">

                <div class="details personal">

                    <span class="title">Consultant Details</span>



                    <div class="fields">

                        <div class="input-field">

                            <label>Candidate First Name</label>

                            <input type="text"   name="cfirst_name" >

                        </div>



                        <div class="input-field">

                            <label>Candidate Last Name</label>

                            <input type="text"   name="clast_name" >

                        </div>



                        <div class="input-field">
                            <label>Ceipal Applicant ID</label>
                            <input type="number" name="ceipal_id">
                        </div>




                        <div class="input-field">

                            <label>Candidate LinkedIn URL</label>

                            <input type="text"   name="clinkedin_url" >

                        </div>



                        <div class="input-field">

                            <label>Date of Birth</label>

                            <input type="date"  name="cdob" >

                        </div>



                        <div class="input-field">

                            <label>Mobile Number</label>

                            <input type="number"  name="cmobilenumber" >

                        </div>



                        <div class="input-field">

                            <label>Email</label>

                            <input type="email"  name="cemail" >

                        </div>



                        <div class="input-field">

                            <label>Location(city,state)</label>

                            <input type="text"   name="clocation" >

                        </div>



                        <div class="input-field">

                            <label>Home Address</label>

                            <input type="text"   name="chomeaddress" >

                        </div>

                        

                        <div class="input-field">

                            <label>SSN number (Last 4digits only)</label>

                            <input type="text"  name="cssn" >

                        </div>



                        <div class="input-field">
                            <label>Work Authorization Status</label>
                            <select name="cwork_authorization_status" id="work_authorization_status">
                                <option disabled selected>Select visa type</option>
                                <option>US Citizen</option>
                                <option>Green Card</option>
                                <option>TN</option>
                                <option>H1B</option>
                                <option>Mexican Citizen</option>
                                <option>Canadian Citizen</option>
                                <option>Canada Work Permit</option>
                                <option>Australian Citizen</option>
                                <option>CR Citizen</option>
                                <option>GC EAD</option>
                                <option>OPT EAD</option>
                                <option>H4 EAD</option>
                                <option>CPT</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="input-field" id="v_validate_status_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
                            <label for="v_validate_status">V-Validate Status</label>
                            <select name="cv_validate_status" id="v_validate_status">
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

                        <input type="hidden" id="cv_validate_status_hidden" name="cv_validate_status_hidden" value="">

                        <script>
                            document.getElementById('work_authorization_status').addEventListener('change', function() {
                                const value = this.value;  // Get the selected value from the dropdown

                                // Get the V-Validate Status field container and inputs
                                const vValidateStatusField = document.getElementById('v_validate_status_field'); // Container for V-Validate Status field
                                const vValidateStatusInput = document.getElementById('v_validate_status'); // V-Validate dropdown
                                const vValidateStatusHidden = document.getElementById('cv_validate_status_hidden'); // Hidden input field

                                if (value !== 'H1B') {
                                    // Hide the V-Validate Status field when non-H1B is selected
                                    vValidateStatusField.style.visibility = 'hidden';
                                    vValidateStatusField.style.height = '0';
                                    vValidateStatusField.style.margin = '0';
                                    vValidateStatusField.style.padding = '0';

                                    // Set the visible select input and hidden input to 'NA'
                                    vValidateStatusInput.value = 'NA'; // Set select to 'NA'
                                    vValidateStatusHidden.value = 'NA'; // Set hidden input to 'NA'
                                } else {
                                    // Show the V-Validate Status field when H1B is selected
                                    vValidateStatusField.style.visibility = 'visible';
                                    vValidateStatusField.style.height = 'auto';  // Restore to default height
                                    vValidateStatusField.style.margin = '1em 0';  // Restore to default margin
                                    vValidateStatusField.style.padding = '1em 0'; // Restore to default padding

                                    // Clear the values for select and hidden inputs when H1B is selected
                                    vValidateStatusInput.value = '';  // Clear the select input
                                    vValidateStatusHidden.value = '';  // Clear the hidden input
                                }
                            });

                            // On page load, hide the V-Validate field initially
                            window.onload = function() {
                                const vValidateStatusField = document.getElementById('v_validate_status_field');
                                vValidateStatusField.style.visibility = 'hidden';
                                vValidateStatusField.style.height = '0';
                                vValidateStatusField.style.margin = '0';
                                vValidateStatusField.style.padding = '0';
                            }
                        </script>




                        <div class="input-field">

                            <label>Certifications</label>

                            <input type="text"  name="ccertifications" >

                        </div>



                        <div class="input-field">

                            <label>Overall Experience</label>

                            <input type="text"  name="coverall_experience" >

                        </div>



                        <div class="input-field">

                            <label>Recent Job Title</label>

                            <input type="text"  name="crecent_job_title" >

                        </div>



                        <div class="input-field">
                            <label>Candidate Source</label>
                            <select name="ccandidate_source" id="candidate_source" onchange="toggleOptions()">
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
                        <div class="input-field" id="shared_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
                            <label id="shared_label"></label>
                            <select name="shared_option" id="shared_option" onchange="combineSource()">
                                <option disabled selected>Select Option</option>
                            </select>
                        </div>

                        <!-- Hidden input to store the combined value -->
                        <input type="hidden" name="final_candidate_source" id="final_candidate_source" value="">

                        <script>
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



                        <div class="input-field">

                            <label>Resume Attached</label>

                            <select name="cresume_attached">

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Photo-ID Attached</label>

                            <select name="cphoto_id_attached" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>WA Attached</label>

                            <select name="cwa_attached" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>

                        

                        <div class="input-field">

                            <label>Anyother Specify</label>

                            <input type="text"  name="cany_other_specify" >

                        </div>

                    </div>

                </div>



            <br><br>

            <div>

                <span class="title">Employer Details</span>

                    <div class="fields">

                        <div class="input-field">

                            <label>Own Corporation</label>

                            <select name="cemployer_own_corporation" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Employer Corporation Name</label>

                            <input type="text"  name="employer_corporation_name" >

                        </div>



                        <div class="input-field">

                            <label>FED ID Number</label>

                            <input type="text"  name="fed_id_number" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Name(Signing authority)</label>

                            <input type="text"  name="contact_person_name" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Designation</label>

                            <input type="text"  name="contact_person_designation" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Address</label>

                            <input type="text"  name="contact_person_address" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Phone Number</label>

                            <input type="number"  name="contact_person_phone_number" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Extension Number</label>

                            <input type="number"  name="contact_person_extension_number" >

                        </div>



                        <div class="input-field">

                            <label>Contact Person Email ID</label>

                            <input type="email"  name="contact_person_email_id" >

                        </div>



                        <div class="input-field">

                            <label>Benchsale Recruiter Name</label>

                            <input type="text"  name="benchsale_recruiter_name" >

                        </div>



                        <div class="input-field">

                            <label>Benchsale Recruiter Phone Number</label>

                            <input type="number"  name="benchsale_recruiter_phone_number" >

                        </div>



                        <div class="input-field">

                            <label>Benchsale Recruiter Extension Number</label>

                            <input type="number"  name="benchsale_recruiter_extension_number" >

                        </div>



                        <div class="input-field">

                            <label>Benchsale Recruiter Email ID</label>

                            <input type="email"  name="benchsale_recruiter_extension_number" >

                        </div>



                        <div class="input-field">

                            <label>Website Link</label>

                            <input type="text"  name="website_link" >

                        </div>



                        <div class="input-field">

                            <label>Employer LinkedIn URL</label>

                            <input type="text"  name="employer_linkedin_url" >

                        </div>

                        

                    </div>         

                </div>



            <br><br>

            <div>
    <span class="title">Additional Employer Details</span>
    <div class="fields">
        <div class="input-field">
            <label>Employer Type</label>
            <select name="employer_type" id="employer_type">
                <option disabled selected>Select option</option>
                <option value="Vendor Change">Vendor Change</option>
                <option value="Vendor Reference">Vendor Reference</option>
                <option value="NA">NA</option>
            </select>
        </div>

        <div class="input-field" id="employer_corporation_name_field">
            <label>Employer Corporation Name</label>
            <input type="text" name="employer_corporation_name1" id="employer_corporation_name1">
        </div>

        <div class="input-field" id="fed_id_number_field">
            <label>FED ID Number</label>
            <input type="text" name="fed_id_number1" id="fed_id_number1">
        </div>

        <div class="input-field" id="contact_person_name_field">
            <label>Contact Person Name (Signing authority)</label>
            <input type="text" name="contact_person_name1" id="contact_person_name1">
        </div>

        <div class="input-field" id="contact_person_designation_field">
            <label>Contact Person Designation</label>
            <input type="text" name="contact_person_designation1" id="contact_person_designation1">
        </div>

        <div class="input-field" id="contact_person_address_field">
            <label>Contact Person Address</label>
            <input type="text" name="contact_person_address1" id="contact_person_address1">
        </div>

        <div class="input-field" id="contact_person_phone_number_field">
            <label>Contact Person Phone Number</label>
            <input type="number" name="contact_person_phone_number1" id="contact_person_phone_number1">
        </div>

        <div class="input-field" id="contact_person_extension_number_field">
            <label>Contact Person Extension Number</label>
            <input type="number" name="contact_person_extension_number1" id="contact_person_extension_number1">
        </div>

        <div class="input-field" id="contact_person_email_id_field">
            <label>Contact Person Email ID</label>
            <input type="email" name="contact_person_email_id1" id="contact_person_email_id1">
        </div>
    </div>
</div>

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

        // Get the input elements to set their values to 'NA' or '00000' for phone number and extension number if 'NA' is selected
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
            // Hide the fields and set values to 'NA', except for the phone number and extension number
            fields.forEach(field => {
                field.style.visibility = 'hidden';
                field.style.height = '0';
                field.style.margin = '0';
                field.style.padding = '0';
            });

            Object.entries(inputs).forEach(([key, input]) => {
                if (key === 'contact_person_phone_number1' || key === 'contact_person_extension_number1') {
                    input.value = '00000';  // Set phone and extension number to '00000'
                } else {
                    input.value = 'NA';  // Set other inputs to 'NA'
                }
                input.setAttribute('readonly', true); // Optional: prevent further changes
            });
        } else {
            // Show the fields and clear their values
            fields.forEach(field => {
                field.style.visibility = 'visible';
                field.style.height = '';
                field.style.margin = '';
                field.style.padding = '';
            });

            Object.values(inputs).forEach(input => {
                input.value = ''; // Clear input fields for valid employer types
                input.removeAttribute('readonly'); // Optional: allow changes again
            });
        }
    });
</script>







            <br><br>

            <!-- <div>

                <span class="title">Collaboration Details</span>

                    <div class="fields">

                        <div class="input-field">

                            <label>Collaborate</label>

                            <select name="collaboration_collaborate" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Delivery Manager</label>

                            <select name="delivery_manager" >

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



                        <div class="input-field">

                            <label>Delivery Account Lead</label>

                            <input type="text"  name="delivery_account_lead" >

                        </div>



                        <div class="input-field">

                            <label>Team Lead</label>

                            <input type="text"  name="team_lead" >

                        </div>

                

                        <div class="input-field">

                            <label>Associate Team Lead</label>

                            <input type="text"  name="associate_team_lead" >

                        </div>

                    </div>         

                </div> -->







                <div>
    <span class="title">Collaboration Details</span>
    <div class="fields">
        <div class="input-field">
            <label>Collaborate</label>
            <select name="collaboration_collaborate" id="collaboration_collaborate">
                <option disabled selected>Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="input-field" id="delivery_manager_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
            <label>Delivery Manager</label>
            <select name="delivery_manager" id="delivery_manager">
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

        <div class="input-field" id="delivery_account_lead_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
            <label>Delivery Account Lead</label>
            <!-- <input type="text" name="delivery_account_lead" id="delivery_account_lead"> -->

            <select name="delivery_account_lead" id="delivery_account_lead">
                <option disabled selected>Select option</option>
                <option>Celestine S - 10269</option>
                <option>Felix B - 10094</option>
                <option>Prassanna Kumar - 11738</option>
                <option>Praveenkumar Kandasamy  - 12422</option>
                <option>Sinimary X - 10365</option>
                <option>Iyngaran C  - 12706</option>
                <option>NA</option>
            </select>

        </div>

        <div class="input-field" id="team_lead_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
            <label>Team Lead</label>
            <!-- <input type="text" name="team_lead" id="team_lead"> -->

            <select name="team_lead" id="team_lead">
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

        <div class="input-field" id="associate_team_lead_field" style="visibility: hidden; height: 0; margin: 0; padding: 0;">
            <label>Associate Team Lead</label>
            <!-- <input type="text" name="associate_team_lead" id="associate_team_lead"> -->

            <select name="associate_team_lead" id="associate_team_lead" >
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
</div>

<script>
    document.getElementById('collaboration_collaborate').addEventListener('change', function() {
        const value = this.value;
        const fields = [
            document.getElementById('delivery_manager_field'),
            document.getElementById('delivery_account_lead_field'),
            document.getElementById('team_lead_field'),
            document.getElementById('associate_team_lead_field')
        ];

        // Get the input elements to set their values to 'NA' if 'No' is selected
        const inputs = {
            delivery_manager: document.getElementById('delivery_manager'),
            delivery_account_lead: document.getElementById('delivery_account_lead'),
            team_lead: document.getElementById('team_lead'),
            associate_team_lead: document.getElementById('associate_team_lead')
        };

        if (value === 'no') {
            // Hide the fields
            fields.forEach(field => {
                field.style.visibility = 'hidden';
                field.style.height = '0';
                field.style.margin = '0';
                field.style.padding = '0';
            });
            
            // Set input values to 'NA'
            Object.values(inputs).forEach(input => {
                if (input.tagName === 'SELECT') {
                    input.value = 'NA';  // For select fields, set value to 'NA'
                } else {
                    input.value = 'NA';  // For text input fields, set value to 'NA'
                }
            });
        } else if (value === 'yes') {
            // Show the fields
            fields.forEach(field => {
                field.style.visibility = 'visible';
                field.style.height = '';
                field.style.margin = '';
                field.style.padding = '';
            });
            
            // Clear input values if the user selects 'Yes'
            Object.values(inputs).forEach(input => {
                input.value = '';  // Clear the inputs if collaboration is 'Yes'
            });
        }
    });
</script>





                <br><br>

            <div>

                <span class="title">Recruiter Details</span>

                    <div class="fields">

<!-- 

                        <div class="input-field">

                            <label>Business unit</label>

                            <input type="text"   name="business_unit" >

                        </div> -->





                        <div class="input-field">

                            <label>Business Unit</label>

                            <select name="business_unit" >

                                <option disabled selected>Select option</option>

                                <option>Sidd</option>

                                <option>Oliver</option>

                                <option>Nambu</option>

                                <option>Rohit</option>

                                <option>Vinay</option>

                            </select>

                        </div>



                        <!-- <div class="input-field">

                            <label>Client account lead / Client partner</label>

                            <input type="text"   name="client_account_lead" >

                        </div> -->



                        <div class="input-field">

                            <label>Client Account Lead</label>

                            <select name="client_account_lead" >

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


                        <div class="input-field">

                            <label>Client Partner</label>

                            <select name="client_partner" >

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



                        <!-- <div class="input-field">

                            <label>Associate Director Delivery</label>

                            <input type="text"   name="associate_director_delivery" >

                        </div> -->



                        <div class="input-field">

                            <label>Associate Director Delivery</label>

                            <select name="associate_director_delivery" >

                                <option disabled selected>Select option</option>

                                <option>Mohanavelu K.A - 12186</option>
                                <option>Ajay D - 10009</option>
                                <option>Soloman. S - 10006</option>
                                <option>Manoj B.G - 10058</option>
                                <option>NA</option>

                            </select>

                        </div>

<!--                 

                        <div class="input-field">

                            <label>Delivery Manager</label>

                            <input type="text"   name="delivery_manager1" >

                        </div> -->



                        <div class="input-field">

                            <label>Delivery Manager</label>

                            <select name="delivery_manager1" >

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



                        <!-- <div class="input-field">

                            <label>Delivery Account Lead</label>

                            <input type="text"   name="delivery_account_lead1" >

                        </div> -->





                        <div class="input-field">

                            <label>Delivery Account Lead</label>

                            <select name="delivery_account_lead1" >

                                <option disabled selected>Select option</option>

                                <option>Celestine S - 10269</option>
                                <option>Felix B - 10094</option>
                                <option>Prassanna Kumar - 11738</option>
                                <option>Praveenkumar Kandasamy  - 12422</option>
                                <option>Sinimary X - 10365</option>
                                <option>Iyngaran C  - 12706</option>
                                <option>NA</option>

                            </select>

                        </div>

<!-- 

                        <div class="input-field">

                            <label>Team Lead</label>

                            <input type="text"   name="team_lead1" >

                        </div> -->





                        <div class="input-field">

                            <label>Team Lead</label>

                            <select name="team_lead1" >

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
                                <option>TBD</option>
                                <option>NA</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Associate Team Lead</label>

                            <!-- <input type="text"   name="associate_team_lead1" > -->
                            <select name="associate_team_lead1" >
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



                        <!-- <div class="input-field">

                            <label>Recruiter Name (As per HR record)</label>

                            <input type="text"   name="recruiter_name" >

                        </div> -->





                        <div class="input-field">

                            <label>Recruiter Name</label>

                            <select name="recruiter_name" >

                                <option disabled selected>Select option</option>

                                <option>Aarthy Arockyaraj - 11862</option>
                                <option>Aasath Khan Nashruddin - 12377</option>
                                <option>Abdul Rahman - 12469</option>
                                <option>Abinaya Ramesh - 12379</option>
                                <option>Agnes Agalya Aron K - 12381</option>
                                <option>Akash  - 12670</option>
                                <option>Allwin Charles Dane Jacobmaran - 12057</option>
                                <option>Amisha  Sulthana J - 12671</option>
                                <option>AngelinSimi J - 11542</option>
                                <option>Anitha Kumar - 12234</option>
                                <option>Arumairaja A - 11974</option>
                                <option>Arun Balan - 12254</option>
                                <option>Arunachalam C M - 12556</option>
                                <option>Arunkumar Ayyappan - 12627</option>
                                <option>Arunkumar Ganesan - 12645</option>
                                <option>Balaguru Vijayakumar - 12382</option>
                                <option>Balakrishnan V - 11540</option>
                                <option><option>Bharani Dharan Raja Sekar - 11799</option>
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
                                <option>Kojjam  Rajasekar Dhanraj - 12717</option>
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
                                <option>Sivakkumarvallalar  - 11372</option>
                                <option>Sivakumar Senthilnathan - 12007</option>
                                <option>Sivaramakrishnan  Murugesan - 12724</option>
                                <option>Sivasangari Venkatasubramanian - 12479</option>
                                <option>Sivasankar C - 11830</option>
                                <option>Sri Ranjani Murugesan - 12174</option>
                                <option>Subash  Antony S - 12703</option>
                                <option>Suganth T - 11940</option>
                                <option>Sumeet  - 12550</option>
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





                        <div class="input-field">

                            <label>Recruiter Employee ID</label>

                            <input type="text"   name="recruiter_employee_id" >

                        </div>



                        <div class="input-field">

                            <label>PT Support</label>

                            <!-- <input type="text"   name="pt_support" > -->

                            <select name="pt_support" >

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
                                <option>Iyngaran C  - 12706</option>
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
                                <option>Praveenkumar Kandasamy  - 12422</option>
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



                        <div class="input-field">

                            <label>PT Ownership</label>

                            <!-- <input type="text"   name="pt_ownership" > -->

                            <select name="pt_ownership" >

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
                                <option>Iyngaran C  - 12706</option>
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
                                <option>Praveenkumar Kandasamy  - 12422</option>
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



                        <div class="input-field">

                            <label>COE/NON-COE</label>

                            <select name="coe_non_coe" >

                                <option disabled selected>Select option</option>

                                <option>COE</option>

                                <option>NON-COE</option>

                            </select>

                        </div>



                    </div>         

                </div>





            <br><br>

            <div>

                <span class="title">Project Details</span>

                    <div class="fields">



                        <!-- <div class="input-field">

                            <label>GEO</label>

                            <input type="text"   name="geo" >

                        </div> -->



                        <div class="input-field">

                            <label>GEO</label>

                            <select name="geo" >

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

                                <!-- <option>Priscilla</option> -->

                                <option>Belgium</option>

                                <option>IND</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Entity</label>

                            <input type="text"   name="entity" >

                        </div>



                        <div class="input-field">

                            <label>Client</label>

                            <input type="text"   name="client" >

                        </div>

                

                        <div class="input-field">

                            <label>Client Manager</label>

                            <input type="text"   name="client_manager" >

                        </div>



                        <div class="input-field">

                            <label>Client Manager Email ID</label>

                            <input type="email"  name="client_manager_email_id" >

                        </div>



                        <div class="input-field">

                            <label>End Client</label>

                            <input type="text"   name="end_client" >

                        </div>



                        <div class="input-field">

                            <label>Business Track</label>

                            <select name="business_track" >

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

                        <div class="input-field">

                            <label>Industry</label>

                            <input type="text"   name="industry" >

                        </div>



                        <div class="input-field">

                            <label>Experience in Expertise Role | Hands on</label>

                            <input type="text"   name="experience_in_expertise_role" >

                        </div>



                        <div class="input-field">

                            <label>Job Code</label>

                            <input type="text"   name="job_code" >

                        </div>



                        <div class="input-field">

                            <label>Job Title / Role</label>

                            <input type="text"   name="job_title" >

                        </div>



                        <div class="input-field">

                            <label>Primary Skill</label>

                            <input type="text"   name="primary_skill" >

                        </div>



                        <div class="input-field">

                            <label>Secondary Skill</label>

                            <input type="text"   name="secondary_skill" >

                        </div>



                        <div class="input-field">

                            <label>Term</label>

                            <select name="term" >

                                <option disabled selected>Select option</option>

                                <option>CON</option>

                                <option>C2H</option>

                                <option>FTE</option>

                                <option>1099</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Duration</label>

                            <input type="text"   name="duration" >

                        </div>



                        <div class="input-field">

                            <label>Project Location</label>

                            <input type="text"   name="project_location" >

                        </div>



                        <div class="input-field">

                            <label>Start Date</label>

                            <input type="date"  name="start_date" >

                        </div>



                        <div class="input-field">

                            <label>End Date</label>

                            <input type="date"  name="end_date" >

                        </div>



                        <div class="input-field">

                            <label>Pay rate/Salary</label>

                            <input type="text"   name="payrate" >

                        </div>



                        <div class="input-field">

                            <label>Client rate/Salary</label>

                            <input type="text"   name="clientrate" >

                        </div>



                        <div class="input-field">

                            <label>Margin</label>

                            <input type="text"   name="margin" >

                        </div>



                        <div class="input-field">

                            <label>Vendor Fee (If Applicable)</label>

                            <input type="text"   name="vendor_fee" >

                        </div>



                        <div class="input-field">

                            <label>Margin Deviation Approval (Yes/No)</label>

                            <select name="margin_deviation_approval" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Margin Deviation Reason</label>

                            <input type="text"   name="margin_deviation_reason" >

                        </div>



                        <div class="input-field">

                            <label>Ratecard Adherence (Yes/No)</label>

                            <select name="ratecard_adherence" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>


                        <div class="input-field">

                            <label>Ratecard Deviation Approved (Yes/No)</label>

                            <select name="ratecard_deviation_approved" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>


                        <div class="input-field">

                            <label>Ratecard Deviation Reason</label>

                            <input type="text"   name="ratecard_deviation_reason" >

                        </div>



                        <div class="input-field">

                            <label>Payment Term</label>

                            <input type="text"   name="payment_term" >

                        </div>



                        <div class="input-field">

                            <label>Payment Term Approval (Yes/No)</label>

                            <select name="payment_term_approval" >

                                <option disabled selected>Select option</option>

                                <option>Yes</option>

                                <option>No</option>

                            </select>

                        </div>



                        <div class="input-field">

                            <label>Payment Term Deviation Reason</label>

                            <input type="text"   name="payment_term_deviation_reason" >

                        </div>



                        <div class="input-field">

                            <label>Type</label>

                            <select name="type" >

                                <option disabled selected>Select option</option>

                                <option>Deal</option>

                                <option>PT</option>

                                <option>PTR</option>

                                <option>VC</option>

                            </select>

                        </div>



                    </div>         

                </div>



                <!-- File upload fields -->

        <!-- <label for="resume">Resume:</label>

        <input type="file" id="resume" name="resume" required>

        <br>

        <label for="photo_id">Photo ID:</label>

        <input type="file" id="photo_id" name="photo_id" >

        

        <label for="wa_document">Work Authorization:</label>

        <input type="file" id="wa_document" name="wa_document" >-->



                <div class="input-field">

                    <button type="submit">Submit</button>

                </div> 



            </div>   

        </div>

    </form>

</div>



<script src="script.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from immediately submitting

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
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your request.',
                didOpen: () => {
                    Swal.showLoading(); // Show loading spinner
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
            .then(response => response.json()) // Expect a JSON response
            .then(data => {
                if (data.status === 'success') {
                    // Hide loading spinner and show success with record_id link
                    Swal.fire({
                        title: 'Submitted!',
                        html: `
                            
                            <p><strong>Paperwork ID:</strong> ${data.record_id}</p>
                            <button onclick="copyToClipboard('${data.record_id}')" style="margin-top: 10px;" class="swal2-confirm swal2-styled">
                                Copy Record ID
                            </button>
                        `,
                        icon: 'success'
                    }).then(() => {
                        // Reset the form if needed
                        form.reset();

                        // Scroll the container (form's parent container) to the top smoothly
                        const container = document.querySelector('.your-container-class'); // Change this to your container's class or ID
                        if (container) {
                            container.scrollTo({ top: 0, behavior: 'smooth' });
                        }

                        // Refresh the page after showing the success message
                        setTimeout(() => {
                            window.location.reload(); // This will refresh the page
                        }, 2000); // Adjust the timeout as per your needs (e.g., 2 seconds)
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: `An error occurred: ${data.message}`,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while submitting the form.',
                    icon: 'error'
                });
            });
        }
    });
});

// Function to copy the record ID to clipboard
function copyToClipboard(recordId) {
    navigator.clipboard.writeText(`Paperwork ID: ${recordId}`)
        .then(() => {
            Swal.fire({
                title: 'Paperwork ID copied!',
                icon: 'success',
                timer: 1000,
                showConfirmButton: false
            });
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to copy the Paperwork ID.',
                icon: 'error'
            });
        });
}


</script>



<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- <script>

        $(document).ready(function() {

            $('select[name="recruiter_name"]').select2({

                placeholder: "Select option",

                allowClear: true

            });

        });

    </script> -->


    <!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f3604674c7806354da646b9/1i9a2marl';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

    <!-- <script>
        $(document).ready(function() {
            $('select[name="recruiter_name"]').select2({
                placeholder: "Select option",
                allowClear: true
            });
        });
    </script> -->


    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/66ff070e256fb1049b1c95a2/1i9a3904g';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>

</html>