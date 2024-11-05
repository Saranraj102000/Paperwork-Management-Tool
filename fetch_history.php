<style>
/* Container for the history section */
.history-container {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header for history section */
.history-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

/* List of history items */
.history-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Card for each history item */
.history-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
    display: flex;
    flex-direction: column;
}

/* Header of each history card */
.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

/* Modified by and date in header */
.history-modified-by {
    font-weight: bold;
    color: #007bff;
    font-size: 16px;
}

.history-modified-date {
    color: #888;
    font-size: 14px;
}

/* Body of each history card */
.history-body {
    line-height: 1.6;
}

.history-body p {
    margin-bottom: 10px;
    font-size: 16px;
    color: #333;
}

.history-body pre {
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    overflow-x: auto;
    white-space: pre-wrap; /* Ensure long lines break correctly */
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
    color: #444;
}

/* Add some padding for better visual structure */
.history-body strong {
    color: #000;
    font-weight: bold;
}
</style>


<?php

// Include the database connection file
include 'db.php';

// Field name mapping array (database field name => display name)
$fieldMapping = array(
    'cfirstname' => 'Candidate First Name',
                        'clastname' => 'Candidate Last Name',
                        'ceipalid' => 'CEIPAL Applicant ID',
                        'clinkedinurl' => 'Candidate LinkedIn URL',
                        'cdob' => 'Date of Birth (DD-MM)',
                        'cmobilenumber' => 'Phone Number',
                        'cemail' => 'Email ID',
                        'clocation' => 'Location (City, State)',
                        'chomeaddress' => 'Home Address',
                        'cssn' => 'SSN Number (Last 4 Digits Only)',
                        'cwork_authorization_status' => 'Work Authorization Status',
                        'cv_validate_status' => 'V-Validated Status(Applicable only for H1B)',
                        'ccertifications' => 'Certifications',
                        'coverall_experience' => 'Overall Experience',
                        'crecent_job_title' => 'Recent Job Title / Role (Current role)',
                        'ccandidate_source' => 'Candidate Source',
                        'cresume_attached' => 'Resume Attached (Yes / No)',
                        'cphoto_id_attached' => 'Photo ID Attached (Yes/No)',
                        'cwa_attached' => 'WA Attached (Yes/No)',
                        'cany_other_specify' => 'Any Other Specify',
                        'employer_own_corporation' => 'Own Corporation',
                        'employer_corporation_name' => 'Employer Corporation Name',
                        'fed_id_number' => 'FED ID Number / Tax Number',
                        'contact_person_name' => 'Contact Person Name (Signing Authority)',
                        'contact_person_designation' => 'Contact Person Designation',
                        'contact_person_address' => 'Contact person Address',
                        'contact_person_phone_number' => 'Contact Person Phone Number',
                        'contact_person_extension_number' => 'Contact Person Extension Number',
                        'contact_person_email_id' => 'Contact Person Email ID',
                        'benchsale_recruiter_name' => 'Bench Sale Recruiter Name',
                        'benchsale_recruiter_phone_number' => 'Bench Sale Recruiter Phone Number',
                        'benchsale_recruiter_extension_number' => 'Bench Sale Recruiter Extension Number',
                        'benchsale_recruiter_email_id' => 'Bench Sale Recruiter Email Id',
                        'website_link' => 'Web Site',
                        'employer_linkedin_url' => 'Employer LinkedIn URL',
                        'employer_type' => 'Employer Type',
                        'employer_corporation_name1' => 'Employer Corporation Name',
                        'fed_id_number1' => 'FED ID Number / Tax Number',
                        'contact_person_name1' => 'Contact Person Name (Signing Authority)',
                        'contact_person_designation1' => 'Contact Person Designation',
                        'contact_person_address1' => 'Contact Person Address',
                        'contact_person_phone_number1' => 'Contact Person Phone Number',
                        'contact_person_extension_number1' => 'Contact Person Extension Number',
                        'contact_person_email_id1' => 'Contact Person Email ID',
                        'collaboration_collaborate' => 'Collaborate',
                        'delivery_manager' => 'Delivery Manager - Collaboration',
                        'delivery_account_lead' => 'Delivery Account Lead - Collaboration',
                        'team_lead' => 'Team Lead - Collaboration',
                        'associate_team_lead' => 'Lead Recruiter - Collaboration',
                        'business_unit' => 'Business Unit',
                        'client_account_lead' => 'Client Account Lead',
                        'client_partner' => 'Client Partner',
                        'associate_director_delivery' => 'Associate Director Delivery',
                        'delivery_manager1' => 'Delivery Manager',
                        'delivery_account_lead1' => 'Delivery Account Lead',
                        'team_lead1' => 'Team Lead',
                        'associate_team_lead1' => 'Lead Recruiter',
                        'recruiter_name' => 'Recruiter Name',
                        'recruiter_employee_id' => 'Recruiter Emp ID',
                        'pt_support' => 'PT Support',
                        'pt_ownership' => 'PT Ownership',
                        'coe_non_coe' => 'Any Other (Specify Like COE/Non-COE)',
                        'geo' => 'GEO',
                        'entity' => 'Entity',
                        'client' => 'Client',
                        'client_manager' => 'Client Manager',
                        'client_manager_email_id' => 'Client Manager Email ID',
                        'end_client' => 'End Client',
                        'business_track' => 'Business Track',
                        'industry' => 'Industry',
                        'experience_in_expertise_role' => 'Experience in Expertise role|Hands on',
                        'job_code' => 'Job Code',
                        'job_title' => 'Job Title / Role',
                        'primary_skill' => 'Primary Skill',
                        'secondary_skill' => 'Secondary Skill',
                        'term' => 'Term',
                        'duration' => 'Duration',
                        'project_location' => 'Project Location',
                        'start_date' => 'Start Date (DD-MM-YYYY)',
                        'end_date' => 'End Date (DD-MM-YYYY) / Tentative',
                        'payrate' => 'Pay Rate / Salary',
                        'clientrate' => 'Client Rate / Salary',
                        'margin' => 'Margin',
                        'vendor_fee' => 'Additional Vendor Fee (If applicable)',
                        'margin_deviation_approval' => 'Margin Deviation Approval (Yes/No)',
                        'margin_deviation_reason' => 'Margin Deviation Reason',
                        'ratecard_adherence' => 'Rate Card Adherence(Yes/No)',
                        'ratecard_deviation_reason' => 'Rate Card Deviation Reason',
                        'ratecard_deviation_approved' => 'Rate Card Deviation Approved (Yes/No)',
                        'payment_term' => 'Payment Term',
                        'payment_term_approval' => 'Payment Term Approval (Yes/No)',
                        'payment_term_deviation_reason' => 'Payment Term Deviation Reason',
                        'type' => 'Type'
);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure the ID is valid and passed as an integer

if ($id === 0) {
    echo '<p>No history available (invalid record ID).</p>';
    exit;
}

// Prepare the SQL query to fetch history records based on the record ID
$sql = "SELECT * FROM record_history WHERE record_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any results were returned
if ($result->num_rows > 0) {
    echo '<div class="history-container">';
    echo '<h2>Modification History</h2>';
    echo '<div class="history-list">';

    // Loop through each record and display the information
    while ($row = $result->fetch_assoc()) {
        echo '<div class="history-card">';
        echo '<div class="history-header">';
        echo '<span class="history-modified-by">' . htmlspecialchars($row['modified_by']) . '</span>';
        echo '<span class="history-modified-date">' . htmlspecialchars($row['modified_date']) . '</span>';
        echo '</div>'; // Close history-header

        echo '<div class="history-body">';
        echo '<p><strong>Fields Modified:</strong></p>';

        // Get the modification details
        $modificationDetails = $row['modification_details'];

        // Replace the raw field names with friendly names using the $fieldMapping array
        foreach ($fieldMapping as $dbField => $friendlyName) {
            $modificationDetails = str_replace($dbField, $friendlyName, $modificationDetails);
        }

        // Display the modified details after field mapping
        echo '<pre>' . htmlspecialchars($modificationDetails) . '</pre>'; // Use <pre> for better formatting

        // Display old and new values if they exist
        if (!empty($row['old_value']) || !empty($row['new_value'])) {
            echo '<p><strong>Old Value:</strong> ' . htmlspecialchars($row['old_value']) . '</p>';
            echo '<p><strong>New Value:</strong> ' . htmlspecialchars($row['new_value']) . '</p>';
        }

        echo '</div>'; // Close history-body
        echo '</div>'; // Close history-card
    }

    echo '</div>'; // Close history-list
    echo '</div>'; // Close history-container

} else {
    echo '<p>No history available for this record.</p>';
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

?>

