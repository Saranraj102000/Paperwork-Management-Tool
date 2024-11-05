<?php

session_start();
ob_start();

include 'db.php'; // Include your database connection file

// Capture "Submitted By" from session
$recmail = $_SESSION['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $final_candidate_source = $_POST['final_candidate_source'];

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO paperworkdetails (
            cfirstname, clastname, ceipalid, clinkedinurl, cdob, cmobilenumber, cemail, clocation, chomeaddress, cssn, 
            cwork_authorization_status, cv_validate_status, ccertifications, coverall_experience, crecent_job_title, ccandidate_source, 
            cresume_attached, cphoto_id_attached, cwa_attached, cany_other_specify, employer_own_corporation, employer_corporation_name, 
            fed_id_number, contact_person_name, contact_person_designation, contact_person_address, contact_person_phone_number, 
            contact_person_extension_number, contact_person_email_id, benchsale_recruiter_name, benchsale_recruiter_phone_number, 
            benchsale_recruiter_extension_number, benchsale_recruiter_email_id, website_link, employer_linkedin_url, employer_type, 
            employer_corporation_name1, fed_id_number1, contact_person_name1, contact_person_designation1, contact_person_address1, 
            contact_person_phone_number1, contact_person_extension_number1, contact_person_email_id1, collaboration_collaborate, 
            delivery_manager, delivery_account_lead, team_lead, associate_team_lead, business_unit, client_account_lead,
            associate_director_delivery, delivery_manager1, delivery_account_lead1, team_lead1, associate_team_lead1, recruiter_name, 
            recruiter_employee_id, pt_support, pt_ownership, coe_non_coe, geo, entity, client, client_manager, client_manager_email_id, 
            end_client, business_track, industry, experience_in_expertise_role, job_code, job_title, primary_skill, secondary_skill, 
            term, duration, project_location, start_date, end_date, payrate, clientrate, margin, vendor_fee, margin_deviation_approval, 
            margin_deviation_reason, ratecard_adherence, ratecard_deviation_reason, ratecard_deviation_approved, payment_term, 
            payment_term_approval, payment_term_deviation_reason, type, status, submittedby) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'paperwork_created', ?)");

        // Bind parameters
        $stmt->bind_param(
            "sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", 
            $_POST['cfirst_name'], $_POST['clast_name'], $_POST['ceipal_id'], $_POST['clinkedin_url'], $_POST['cdob'], $_POST['cmobilenumber'], 
            $_POST['cemail'], $_POST['clocation'], $_POST['chomeaddress'], $_POST['cssn'], $_POST['cwork_authorization_status'], 
            $_POST['cv_validate_status'], $_POST['ccertifications'], $_POST['coverall_experience'], $_POST['crecent_job_title'], 
            $final_candidate_source, $_POST['cresume_attached'], $_POST['cphoto_id_attached'], $_POST['cwa_attached'], 
            $_POST['cany_other_specify'], $_POST['cemployer_own_corporation'], $_POST['employer_corporation_name'], $_POST['fed_id_number'], 
            $_POST['contact_person_name'], $_POST['contact_person_designation'], $_POST['contact_person_address'], $_POST['contact_person_phone_number'], 
            $_POST['contact_person_extension_number'], $_POST['contact_person_email_id'], $_POST['benchsale_recruiter_name'], 
            $_POST['benchsale_recruiter_phone_number'], $_POST['benchsale_recruiter_extension_number'], $_POST['benchsale_recruiter_email_id'], 
            $_POST['website_link'], $_POST['employer_linkedin_url'], $_POST['employer_type'], $_POST['employer_corporation_name1'], 
            $_POST['fed_id_number1'], $_POST['contact_person_name1'], $_POST['contact_person_designation1'], $_POST['contact_person_address1'], 
            $_POST['contact_person_phone_number1'], $_POST['contact_person_extension_number1'], $_POST['contact_person_email_id1'], $_POST['collaboration_collaborate'], 
            $_POST['delivery_manager'], $_POST['delivery_account_lead'], $_POST['team_lead'], $_POST['associate_team_lead'], $_POST['business_unit'], 
            $_POST['client_account_lead'], $_POST['associate_director_delivery'], $_POST['delivery_manager1'], $_POST['delivery_account_lead1'], 
            $_POST['team_lead1'], $_POST['associate_team_lead1'], $_POST['recruiter_name'], $_POST['recruiter_employee_id'], $_POST['pt_support'], 
            $_POST['pt_ownership'], $_POST['coe_non_coe'], $_POST['geo'], $_POST['entity'], $_POST['client'], $_POST['client_manager'], 
            $_POST['client_manager_email_id'], $_POST['end_client'], $_POST['business_track'], $_POST['industry'], $_POST['experience_in_expertise_role'], 
            $_POST['job_code'], $_POST['job_title'], $_POST['primary_skill'], $_POST['secondary_skill'], $_POST['term'], $_POST['duration'], 
            $_POST['project_location'], $_POST['start_date'], $_POST['end_date'], $_POST['payrate'], $_POST['clientrate'], $_POST['margin'], 
            $_POST['vendor_fee'], $_POST['margin_deviation_approval'], $_POST['margin_deviation_reason'], $_POST['ratecard_adherence'], 
            $_POST['ratecard_deviation_reason'], $_POST['ratecard_deviation_approved'], $_POST['payment_term'], $_POST['payment_term_approval'], 
            $_POST['payment_term_deviation_reason'], $_POST['type'], $recmail
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Send the success response as JSON without the edit URL
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    } finally {
        // Close statement and connection
        if ($stmt) $stmt->close();
        $conn->close();
    }
}
?>
