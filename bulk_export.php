<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log');

// Include PHPExcel library (replace with PhpSpreadsheet if needed)
require 'db.php';
require 'PHPExcel-1.8/Classes/PHPExcel.php'; // Ensure you have PHPExcel

// Check if records are selected for export
if (isset($_GET['ids']) && !empty($_GET['ids'])) {
    $recordIds = explode(',', $_GET['ids']); // Get array of selected record IDs

    // Prepare the SQL query to fetch the selected records
    $placeholders = implode(',', array_fill(0, count($recordIds), '?'));
    $sql = "SELECT * FROM paperworkdetails WHERE id IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters for selected IDs
        $types = str_repeat('i', count($recordIds)); // Integer placeholders
        $stmt->bind_param($types, ...$recordIds);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Define the filename
            $filename = 'Bulk_Consultant_Paperwork_' . date('Y-m-d') . '.xlsx';

            // Initialize PHPExcel
            $objPHPExcel = new PHPExcel();
            $sheet = $objPHPExcel->getActiveSheet();

            // Define the header style
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => '000000'], 'size' => 12],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'FFCC00']],
                'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
            ];

            // Define the data style
            $dataStyle = [
                'font' => ['size' => 11],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true,
                ],
                'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]],
            ];

            // Define the field mapping (field names for headers)
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
                'cv_validate_status' => 'V-Validated Status (for H1B)',
                'ccertifications' => 'Certifications',
                'coverall_experience' => 'Overall Experience',
                'crecent_job_title' => 'Recent Job Title / Role',
                'ccandidate_source' => 'Candidate Source',
                'cresume_attached' => 'Resume Attached (Yes / No)',
                'cphoto_id_attached' => 'Photo ID Attached (Yes/No)',
                'cwa_attached' => 'WA Attached (Yes/No)',
                'cany_other_specify' => 'Any Other Specify',
                'employer_own_corporation' => 'Own Corporation',
                'employer_corporation_name' => 'Employer Corporation Name',
                'fed_id_number' => 'FED ID Number / Tax Number',
                'contact_person_name' => 'Contact Person Name',
                'contact_person_designation' => 'Contact Person Designation',
                'contact_person_address' => 'Contact Person Address',
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
                'contact_person_name1' => 'Contact Person Name (2nd)',
                'contact_person_designation1' => 'Contact Person Designation (2nd)',
                'contact_person_address1' => 'Contact Person Address (2nd)',
                'contact_person_phone_number1' => 'Contact Person Phone Number (2nd)',
                'contact_person_extension_number1' => 'Contact Person Extension Number (2nd)',
                'contact_person_email_id1' => 'Contact Person Email ID (2nd)',
                'collaboration_collaborate' => 'Collaborate',
                'delivery_manager' => 'Delivery Manager',
                'delivery_account_lead' => 'Delivery Account Lead',
                'team_lead' => 'Team Lead',
                'associate_team_lead' => 'Lead Recruiter',
                'business_unit' => 'Business Unit',
                'client_account_lead' => 'Client Account Lead',
                'client_partner' => 'Client Partner',
                'associate_director_delivery' => 'Associate Director of Delivery',
                'delivery_manager1' => 'Delivery Manager (2nd)',
                'delivery_account_lead1' => 'Delivery Account Lead (2nd)',
                'team_lead1' => 'Team Lead (2nd)',
                'recruiter_name' => 'Recruiter Name',
                'recruiter_employee_id' => 'Recruiter Employee ID',
                'pt_support' => 'PT Support',
                'pt_ownership' => 'PT Ownership',
                'coe_non_coe' => 'COE/Non-COE',
                'geo' => 'GEO',
                'entity' => 'Entity',
                'client' => 'Client',
                'client_manager' => 'Client Manager',
                'client_manager_email_id' => 'Client Manager Email ID',
                'end_client' => 'End Client',
                'business_track' => 'Business Track',
                'industry' => 'Industry',
                'experience_in_expertise_role' => 'Experience in Expertise Role',
                'job_code' => 'Job Code',
                'job_title' => 'Job Title',
                'primary_skill' => 'Primary Skill',
                'secondary_skill' => 'Secondary Skill',
                'term' => 'Term',
                'duration' => 'Duration',
                'project_location' => 'Project Location',
                'start_date' => 'Start Date',
                'end_date' => 'End Date',
                'payrate' => 'Pay Rate',
                'clientrate' => 'Client Rate',
                'margin' => 'Margin',
                'vendor_fee' => 'Vendor Fee',
                'margin_deviation_approval' => 'Margin Deviation Approval',
                'margin_deviation_reason' => 'Margin Deviation Reason',
                'ratecard_adherence' => 'Rate Card Adherence',
                'ratecard_deviation_reason' => 'Rate Card Deviation Reason',
                'ratecard_deviation_approved' => 'Rate Card Deviation Approved',
                'payment_term' => 'Payment Term',
                'payment_term_approval' => 'Payment Term Approval',
                'payment_term_deviation_reason' => 'Payment Term Deviation Reason',
                'type' => 'Type'
            ];

            // Set headers in the first row
            $column = 'A';
            foreach ($fieldMapping as $field => $label) {
                $sheet->setCellValue($column . '1', $label);
                $sheet->getStyle($column . '1')->applyFromArray($headerStyle);
                $column++;
            }

            // Write the data (starting from row 2)
            $rowNum = 2;
            while ($row = $result->fetch_assoc()) {
                $column = 'A'; // Reset to the first column for each row

                // Write each field value for the current record
                foreach ($fieldMapping as $field => $label) {
                    $sheet->setCellValue($column . $rowNum, $row[$field]);
                    $sheet->getStyle($column . $rowNum)->applyFromArray($dataStyle);
                    $column++;
                }
                $rowNum++;
            }

            // Apply auto-fit to all columns
            foreach (range('A', $sheet->getHighestColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true); // Auto-fit columns
            }

            // Protect the sheet with a password to prevent editing
            $sheet->getProtection()->setSheet(true); // Enable sheet protection
            $sheet->getProtection()->setPassword('your_password'); // Set a password for protection
            $sheet->getProtection()->setSort(false); // Disable sorting
            $sheet->getProtection()->setInsertRows(false); // Disable inserting rows
            $sheet->getProtection()->setFormatCells(false); // Disable formatting cells

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
            echo "Error executing the SQL statement: " . $stmt->error;
        }
    } else {
        echo "Error preparing the SQL statement.";
    }
} else {
    echo "No records selected for export.";
}

// Close the database connection
$conn->close();
