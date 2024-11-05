<?php
session_start();
ob_start(); // Start output buffering

include 'db.php'; // Your database connection file

// Capture "Submitted By" from session
$recmail = $_SESSION['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture input data from the POST request (form data)
    $formData = json_decode(file_get_contents('php://input'), true);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO paperworkdetails (
       cfirstname, clastname, ceipalid, clinkedinurl, cdob, cmobilenumber, cemail, clocation, chomeaddress, cssn, 
       cwork_authorization_status, cv_validate_status, ccertifications, coverall_experience, crecent_job_title, ccandidate_source, 
       cresume_attached, cphoto_id_attached, cwa_attached, cany_other_specify, employer_own_corporation, employer_corporation_name, 
       fed_id_number, contact_person_name, contact_person_designation, contact_person_address, contact_person_phone_number, 
       contact_person_extension_number, contact_person_email_id, benchsale_recruiter_name, benchsale_recruiter_phone_number, 
       benchsale_recruiter_extension_number, benchsale_recruiter_email_id, website_link, employer_linkedin_url, employer_type, 
       employer_corporation_name1, fed_id_number1, contact_person_name1, contact_person_designation1, contact_person_address1, 
       contact_person_phone_number1, contact_person_extension_number1, contact_person_email_id1, collaboration_collaborate, 
       delivery_manager, delivery_account_lead, team_lead, associate_team_lead, business_unit, client_account_lead, client_partner,
       associate_director_delivery, delivery_manager1, delivery_account_lead1, team_lead1, associate_team_lead1, recruiter_name, 
       recruiter_employee_id, pt_support, pt_ownership, coe_non_coe, geo, entity, client, client_manager, client_manager_email_id, 
       end_client, business_track, industry, experience_in_expertise_role, job_code, job_title, primary_skill, secondary_skill, 
       term, duration, project_location, start_date, end_date, payrate, clientrate, margin, vendor_fee, margin_deviation_approval, 
       margin_deviation_reason, ratecard_adherence, ratecard_deviation_reason, ratecard_deviation_approved, payment_term, 
       payment_term_approval, payment_term_deviation_reason, type, status, submittedby) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'initiated', ?)");

    // Bind parameters including the 'status' which is set to 'initiated'
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", 
            $formData['cfirst_name'], $formData['clast_name'], $formData['ceipal_id'], $formData['clinkedin_url'], $formData['cdob'], $formData['cmobilenumber'], 
            $formData['cemail'], $formData['clocation'], $formData['chomeaddress'], $formData['cssn'], $formData['cwork_authorization_status'], 
            $formData['cv_validate_status'], $formData['ccertifications'], $formData['coverall_experience'], $formData['crecent_job_title'], 
            $formData['final_candidate_source'], $formData['cresume_attached'], $formData['cphoto_id_attached'], $formData['cwa_attached'], 
            $formData['cany_other_specify'], $formData['cemployer_own_corporation'], $formData['employer_corporation_name'], $formData['fed_id_number'], 
            $formData['contact_person_name'], $formData['contact_person_designation'], $formData['contact_person_address'], $formData['contact_person_phone_number'], 
            $formData['contact_person_extension_number'], $formData['contact_person_email_id'], $formData['benchsale_recruiter_name'], 
            $formData['benchsale_recruiter_phone_number'], $formData['benchsale_recruiter_extension_number'], $formData['benchsale_recruiter_email_id'], 
            $formData['website_link'], $formData['employer_linkedin_url'], $formData['employer_type'], $formData['employer_corporation_name1'], 
            $formData['fed_id_number1'], $formData['contact_person_name1'], $formData['contact_person_designation1'], $formData['contact_person_address1'], 
            $formData['contact_person_phone_number1'], $formData['contact_person_extension_number1'], $formData['contact_person_email_id1'], $formData['collaboration_collaborate'], 
            $formData['delivery_manager'], $formData['delivery_account_lead'], $formData['team_lead'], $formData['associate_team_lead'], $formData['business_unit'], 
            $formData['client_account_lead'], $formData['client_partner'], $formData['associate_director_delivery'], $formData['delivery_manager1'], $formData['delivery_account_lead1'], 
            $formData['team_lead1'], $formData['associate_team_lead1'], $formData['recruiter_name'], $formData['recruiter_employee_id'], $formData['pt_support'], 
            $formData['pt_ownership'], $formData['coe_non_coe'], $formData['geo'], $formData['entity'], $formData['client'], $formData['client_manager'], 
            $formData['client_manager_email_id'], $formData['end_client'], $formData['business_track'], $formData['industry'], $formData['experience_in_expertise_role'], 
            $formData['job_code'], $formData['job_title'], $formData['primary_skill'], $formData['secondary_skill'], $formData['term'], $formData['duration'], 
            $formData['project_location'], $formData['start_date'], $formData['end_date'], $formData['payrate'], $formData['clientrate'], $formData['margin'], 
            $formData['vendor_fee'], $formData['margin_deviation_approval'], $formData['margin_deviation_reason'], $formData['ratecard_adherence'], 
            $formData['ratecard_deviation_reason'], $formData['ratecard_deviation_approved'], $formData['payment_term'], $formData['payment_term_approval'], 
            $formData['payment_term_deviation_reason'], $formData['type'], $recmail);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the ID of the last inserted record
        $record_id = $conn->insert_id;

        // Create a Paperwork code with the format "Paperwork $record_id"
        $paperwork_code = "Paperwork " . $record_id;

        // Send the response as JSON with the formatted paperwork code
        echo json_encode(['status' => 'success', 'record_id' => $record_id, 'pwcode' => $paperwork_code]);
    } else {
        // If insert failed
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
