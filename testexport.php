<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');

require 'db.php';
require 'PHP_XLSXWriter-master/xlsxwriter.class.php'; // Include the XLSXWriter library

if (isset($_GET['id'])) {
    $recordId = intval($_GET['id']);

    if ($recordId > 0) {
        // Prepare the SQL query
        $sql = "SELECT * FROM paperworkdetails WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $recordId);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result && $row = $result->fetch_assoc()) {
                    // Define the file name
                    $filename = 'Consultant_Paperwork_' . $recordId . '.xlsx';

                    // Initialize XLSXWriter
                    $writer = new XLSXWriter();

                    // Define the style for normal data rows
                    $border_style = [
                        'font' => 'Calibri',  // Font name
                        'font-size' => 11,  // Font size
                        'border' => 'left,right,top,bottom',  // Borders around each cell
                        'border-style' => 'thin',  // Border thickness
                        'wrap_text' => true,  // Text wrap for long content
                        'halign' => 'left',  // Horizontal alignment
                        'valign' => 'center',  // Vertical alignment
                        'color' => '#000000',  // Font color (black)
                        'fill' => '#FFFFFF',  // Cell background color (white)
                        'num_format' => 'General'  // Number format
                    ];

                    // Define the style for header rows
                    $header_style = [
                        'font' => 'Arial',  // Header font name
                        'font-size' => 12,  // Header font size
                        'font-style' => 'bold',  // Bold font for headers
                        'fill' => '#FFCC00',  // Yellow background for headers
                        'border' => 'left,right,top,bottom',  // Borders around each header cell
                        'border-style' => 'thin',  // Border thickness
                        'halign' => 'center',  // Center horizontally
                        'valign' => 'center',  // Center vertically
                        'color' => '#000000'  // Font color for headers (black)
                    ];

                    // Define bold style for field names
                    $bold_style = array_merge($border_style, [
                        'font-style' => 'bold',  // Make field names bold
                        'fill' => '#F0F0F0'  // Light grey background for bold rows
                    ]);

                    // Set column widths for auto-fit (extra space added)
                    $column_widths = [40, 60]; // Increased column widths to add extra space

                    // Add header notice
                    $writer->writeSheetHeader('Sheet1', ['Field' => 'string', 'Value' => 'string'], ['widths' => $column_widths, 'style' => $header_style]);

                    // Add the Read-Only notice
                    $writer->writeSheetRow('Sheet1', ['NOTICE: This document is for view only. Please do not modify.'], $border_style);
                    $writer->writeSheetRow('Sheet1', []); // Empty row for spacing

                    // Add consultant details section header
                    $writer->writeSheetRow('Sheet1', ['CONSULTANT DETAILS'], $header_style);
                    $writer->writeSheetRow('Sheet1', []); // Empty row for spacing

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

                    // Loop through the data and write it to the Excel file
                    foreach ($row as $key => $value) {
                        $label = isset($fieldMapping[$key]) ? $fieldMapping[$key] : $key;
                        // Apply bold style to the field name (label)
                        $writer->writeSheetRow('Sheet1', [$label, $value], [$bold_style, $border_style]);

                        // Insert headers after specific keys for sectioning
                        if ($key == 'cany_other_specify') {
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                            $writer->writeSheetRow('Sheet1', ['EMPLOYER DETAILS'], $header_style);
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                        }

                        if ($key == 'employer_linkedin_url') {
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                            $writer->writeSheetRow('Sheet1', ['ADDITIONAL EMPLOYER DETAILS'], $header_style);
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                        }

                        if ($key == 'contact_person_email_id1') {
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                            $writer->writeSheetRow('Sheet1', ['COLLABORATION DETAILS'], $header_style);
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                        }

                        if ($key == 'associate_team_lead') {
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                            $writer->writeSheetRow('Sheet1', ['RECRUITER DETAILS'], $header_style);
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                        }

                        if ($key == 'coe_non_coe') {
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                            $writer->writeSheetRow('Sheet1', ['PROJECT DETAILS'], $header_style);
                            $writer->writeSheetRow('Sheet1', []); // Empty row for spacing
                        }
                    }

                    // Output the file for download
                    header('Content-disposition: attachment; filename="' . $filename . '"');
                    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    
                    $writer->writeToStdOut();
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
