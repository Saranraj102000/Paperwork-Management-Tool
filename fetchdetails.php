<?php

// Database connection

include 'db.php';





// Array to map database field names to display names

$fieldMapping = [

    'cfirstname' => 'Candidate First Name',

                'clastname' => 'Candidate Last Name',

                'ceipalid' => 'CEIPAL Applicant ID',

                'clinkedinurl' => 'Candidate Linkedin URL',

                'cdob' => 'Date of Birth (DD-MMM)',

                'cmobilenumber' => 'Phone Number',

                'cemail' => 'Email ID',

                'clocation' => 'Location (City, State)',

                'chomeaddress' => 'Home Address',

                'cssn' => 'SSN Number (Last 4 Digits Only) / SIN Number / Cedula ID',

                'cwork_authorization_status' => 'Work Authorization Status',

                'cv_validate_status' => 'V-Validated Status(Applicable only for H1B)',

                'ccertifications' => 'Certifications (If Yes please enter the proper certification details)',

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

                'contact_person_extension_number' => 'Contact Person Extn.Number',

                'contact_person_email_id' => 'Contact Person  Email ID',

                'benchsale_recruiter_name' => 'Bench Sale Recruiter Name',

                'benchsale_recruiter_phone_number' => 'Bench Sale Recruiter Phone Number',

                'benchsale_recruiter_extension_number' => 'Bench Sale Recruiter Extn Number',

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

                'contact_person_extension_number1' => 'Contact Person Extn.Number',

                'contact_person_email_id1' => 'Contact Person  Email ID',

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

                'recruiter_name' => 'Recruiter Name (As per HR Record)',

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

                'primary_skill' => 'Primary Skill (Candidate)',

                'secondary_skill' => 'Secondary Skill (Candidate)',

                'term' => 'Term',

                'duration' => 'Duration',

                'project_location' => 'Project Location',

                'start_date' => 'Start Date (DD-MMM-YYYY)',

                'end_date' => 'End Date (DD-MMM-YYYY) / Tentative',

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

                'type' => 'Type',

                'status' => 'Status'

];



// Fetch record details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM paperworkdetails WHERE id = ?");
    $stmt->bind_param('i', $id);  // 'i' stands for integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if results were returned
    if ($result && $result->num_rows > 0) {
        // Display the records in a table
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='text-align: left; padding: 8px; background-color: #f2f2f2; border-bottom: 1px solid #ddd;'>Field</th>
                  <th style='text-align: left; padding: 8px; background-color: #f2f2f2; border-bottom: 1px solid #ddd;'>Value</th></tr>";

        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                // Use the mapping array to display the custom field name
                $displayName = isset($fieldMapping[$key]) ? $fieldMapping[$key] : $key;

                // Format the created_at or updated_at fields if present
                if (in_array($key, ['created_at', 'updated_at'])) {
                    $value = (new DateTime($value))->format('Y-m-d H:i:s');
                }

                // Display field and value in table row
                echo "<tr>";
                echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($displayName) . "</td>";
                echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($value) . "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
    } else {
        echo "<p>No details found for this ID.</p>";
    }

    // Close statement
    $stmt->close();
} else {
    echo "<p>No ID provided.</p>";
}

// Close connection
$conn->close();
?>



