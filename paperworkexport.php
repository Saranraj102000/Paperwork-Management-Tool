<?php
require 'db.php'; // Include the database connection file
require 'PHPExcel-1.8/Classes/PHPExcel.php'; // Include PHPExcel library

// Define filter variables based on form input
$search = isset($_GET['search']) ? $_GET['search'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$submittedBy = isset($_GET['submitted_by']) ? $_GET['submitted_by'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Define field name mappings for user-friendly labels
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

// Function to fetch data from the database using filters
function fetchData($pdo, $search, $startDate, $endDate, $submittedBy, $status) {
    $query = "SELECT * FROM paperworkdetails WHERE 1=1";

    // Add filters to the query
    if (!empty($search)) {
        $query .= " AND name LIKE :search";
    }
    if (!empty($startDate)) {
        $query .= " AND date >= :startDate";
    }
    if (!empty($endDate)) {
        $query .= " AND date <= :endDate";
    }
    if (!empty($submittedBy)) {
        $query .= " AND submitted_by = :submittedBy";
    }
    if (!empty($status)) {
        $query .= " AND status = :status";
    }

    $stmt = $pdo->prepare($query);

    // Bind values to parameters
    if (!empty($search)) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }
    if (!empty($startDate)) {
        $stmt->bindValue(':startDate', $startDate);
    }
    if (!empty($endDate)) {
        $stmt->bindValue(':endDate', $endDate);
    }
    if (!empty($submittedBy)) {
        $stmt->bindValue(':submittedBy', $submittedBy);
    }
    if (!empty($status)) {
        $stmt->bindValue(':status', $status);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['export'])) {
    // Get the database connection from db.php
    $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password'); // Edit with actual db details
    
    $data = fetchData($pdo, $search, $startDate, $endDate, $submittedBy, $status);

    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();

    // Set the headers using the user-friendly labels
    $col = 'A';
    foreach ($fieldMapping as $field => $label) {
        $sheet->setCellValue($col . '1', $label);
        $col++;
    }

    // Populate the data
    $row = 2;
    foreach ($data as $record) {
        $col = 'A';
        foreach ($fieldMapping as $field => $label) {
            $sheet->setCellValue($col . $row, isset($record[$field]) ? $record[$field] : '');
            $col++;
        }
        $row++;
    }

    // Redirect output to a client’s web browser (Excel)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="PaperworkExport.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $writer->save('php://output');
    exit;
}
?>
