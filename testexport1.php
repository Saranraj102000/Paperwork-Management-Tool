<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');

require 'db.php';
require 'PHPExcel-1.8/Classes/PHPExcel.php'; // Include PHPExcel

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
                    // Fetch the candidate's first name, last name, and record ID
                    $candidateFirstName = isset($row['cfirstname']) ? $row['cfirstname'] : 'Unknown';
                    $candidateLastName = isset($row['clastname']) ? $row['clastname'] : 'Unknown';
                    $recordId = isset($row['id']) ? $row['id'] : 'Unknown';

                    // Define the file name as candidate's first name, last name, and record ID
                    $filename = $candidateFirstName . '_' . $candidateLastName . '_Paperwork_' . $recordId . '.xlsx';

                    // Initialize PHPExcel
                    $objPHPExcel = new PHPExcel();
                    $sheet = $objPHPExcel->getActiveSheet();

                    // Set column widths for auto-fit
                    $sheet->getColumnDimension('A')->setWidth(40);
                    $sheet->getColumnDimension('B')->setWidth(60);

                    // Hide gridlines
                    $sheet->setShowGridlines(false);

                    // Set default font to Cambria
                    $objPHPExcel->getDefaultStyle()->getFont()->setName('Cambria');

                    // Define the header style
                    $headerStyle = [
                        'font' => ['bold' => true, 'color' => ['rgb' => '000000'], 'size' => 12],
                        'alignment' => [
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Center align
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Vertical center align
                        ],
                        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'FFCC00']],
                        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
                    ];

                    // Define the bold style for field names
                    $boldStyle = [
                        'font' => ['bold' => true],
                        'alignment' => [
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Center align
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Vertical center align
                        ],
                        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'F0F0F0']],
                        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
                    ];

                    // Define the normal data style
                    $dataStyle = [
                        'font' => ['size' => 11],
                        'alignment' => [
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Center align
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Vertical center align
                            'wrap' => true, // Enable text wrapping if the content is long
                        ],
                        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
                    ];

                    // Add the Read-Only notice
                    $sheet->setCellValue('A1', 'NOTICE: This document is for view only. Please do not modify.');
                    $sheet->mergeCells('A1:B1');
                    $sheet->getStyle('A1')->applyFromArray($dataStyle);

                    // Add consultant details section header
                    $sheet->setCellValue('A3', 'CONSULTANT DETAILS');
                    $sheet->mergeCells('A3:B3');
                    $sheet->getStyle('A3')->applyFromArray($headerStyle);

                    // Field name mapping for more user-friendly labels
                    $fieldMapping = [
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
                    ];

                    // Start writing data from row 5
                    $currentRow = 5;

                    // Loop through the data and write it to the Excel file
                    foreach ($row as $key => $value) {
                        $label = isset($fieldMapping[$key]) ? $fieldMapping[$key] : $key;

                        // If the field is 'created_at', format it as m-d-y
                        if ($key == 'created_at') {
                            $value = date('m-d-y', strtotime($value));
                        }

                        // Write the field name and value
                        $sheet->setCellValue('A' . $currentRow, $label);
                        $sheet->setCellValue('B' . $currentRow, $value);

                        // Apply styles
                        $sheet->getStyle('A' . $currentRow)->applyFromArray($boldStyle);
                        $sheet->getStyle('B' . $currentRow)->applyFromArray($dataStyle);

                        // Insert headers after specific keys for sectioning
                        if ($key == 'cany_other_specify') {
                            $currentRow += 2;
                            $sheet->setCellValue('A' . $currentRow, 'EMPLOYER DETAILS');
                            $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
                            $sheet->getStyle('A' . $currentRow)->applyFromArray($headerStyle);
                            $currentRow++;
                        }

                        if ($key == 'employer_linkedin_url') {
                            $currentRow += 2;
                            $sheet->setCellValue('A' . $currentRow, 'ADDITIONAL EMPLOYER DETAILS');
                            $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
                            $sheet->getStyle('A' . $currentRow)->applyFromArray($headerStyle);
                            $currentRow++;
                        }

                        if ($key == 'contact_person_email_id1') {
                            $currentRow += 2;
                            $sheet->setCellValue('A' . $currentRow, 'COLLABORATION DETAILS');
                            $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
                            $sheet->getStyle('A' . $currentRow)->applyFromArray($headerStyle);
                            $currentRow++;
                        }

                        if ($key == 'associate_team_lead') {
                            $currentRow += 2;
                            $sheet->setCellValue('A' . $currentRow, 'RECRUITER DETAILS');
                            $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
                            $sheet->getStyle('A' . $currentRow)->applyFromArray($headerStyle);
                            $currentRow++;
                        }

                        if ($key == 'coe_non_coe') {
                            $currentRow += 2;
                            $sheet->setCellValue('A' . $currentRow, 'PROJECT DETAILS');
                            $sheet->mergeCells('A' . $currentRow . ':B' . $currentRow);
                            $sheet->getStyle('A' . $currentRow)->applyFromArray($headerStyle);
                            $currentRow++;
                        }

                        $currentRow++;
                    }

                    // Protect the sheet with a password
                    $sheet->getProtection()->setSheet(true); // Enable protection
                    $sheet->getProtection()->setPassword('your_password'); // Set password
                    $sheet->getProtection()->setSort(false); // Disable sorting
                    $sheet->getProtection()->setInsertRows(false); // Disable row insertion
                    $sheet->getProtection()->setFormatCells(false); // Disable cell formatting

                    // Output the file for download
                    header('Content-disposition: attachment; filename="' . $filename . '"');
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');

                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    $objWriter->save('php://output');
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
