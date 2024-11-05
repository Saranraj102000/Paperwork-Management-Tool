<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');

require 'db.php';
require 'simplexlsxgen-master/src/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;

if (isset($_GET['id'])) {
    $recordId = intval($_GET['id']);

    if ($recordId > 0) {
        $sql = "SELECT * FROM paperworkdetails WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $recordId);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result && $row = $result->fetch_assoc()) {
                    $data = [];

                    // Add a "Read-Only" notice at the top of the Excel sheet
                    $data[] = ['NOTICE: This document is for view only. Please do not modify.'];
                    $data[] = []; // Empty row for spacing
                    
                    // Field name mapping for more user-friendly labels
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
                        'contact_person_email_id' => 'Contact Person Email ID',
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
                        'type' => 'Type'
                    ];

                    // Add CONSULTANT DETAILS section
                    $data[] = ['CONSULTANT DETAILS']; // Header
                    $data[] = []; // Empty row for spacing

                    // Loop through data and build the Excel content
                    foreach ($row as $key => $value) {
                        // Use the friendly label from the mapping if it exists, otherwise use the original key
                        $label = isset($fieldMapping[$key]) ? $fieldMapping[$key] : $key;
                        $data[] = [$label, $value]; // Add label and value to the data array

                        // Insert headers after specific keys as per requirements
                        if ($key == 'cany_other_specify') {
                            $data[] = []; // Empty row for spacing
                            $data[] = ['EMPLOYER DETAILS']; // Header
                            $data[] = []; // Empty row for spacing
                        }
                        if ($key == 'employer_linkedin_url') {
                            $data[] = []; // Empty row for spacing
                            $data[] = ['ADDITIONAL EMPLOYER DETAILS']; // Header
                            $data[] = []; // Empty row for spacing
                        }
                        if ($key == 'contact_person_email_id1') {
                            $data[] = []; // Empty row for spacing
                            $data[] = ['COLLABORATION DETAILS']; // Header
                            $data[] = []; // Empty row for spacing
                        }
                        if ($key == 'associate_team_lead') {
                            $data[] = []; // Empty row for spacing
                            $data[] = ['RECRUITER DETAILS']; // Header
                            $data[] = []; // Empty row for spacing
                        }
                        if ($key == 'coe_non_coe') {
                            $data[] = []; // Empty row for spacing
                            $data[] = ['PROJECT DETAILS']; // Header
                            $data[] = []; // Empty row for spacing
                        }
                    }

                    // Create the Excel file using SimpleXLSXGen
                    $xlsx = SimpleXLSXGen::fromArray($data);

                    // Generate the filename
                    $filename = 'Consultant_Paperwork_' . $recordId . '.xlsx';

                    // Output the file to the browser
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="' . $filename . '";');
                    $xlsx->downloadAs($filename);
                    exit();

                } else {
                    echo "Error: No data found for the given ID.";
                }
            } else {
                echo "Error executing the SQL statement: " . $stmt->error;
            }
        } else {
            echo "Error preparing the SQL statement.";
        }
    } else {
        echo "Invalid ID provided.";
    }
} else {
    echo "No ID parameter provided.";
}

// Close the database connection
$conn->close();
?>
