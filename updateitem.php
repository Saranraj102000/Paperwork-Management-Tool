<?php



session_start();

include 'db.php';


// Enable error reporting

error_reporting(E_ALL);

ini_set('display_errors', 1);



// Database connection

// $servername = "localhost";

// $username = "root";

// $password = "";

// $database = "formdata";



// $conn = new mysqli($servername, $username, $password, $database);



// // Check connection

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }



// Check if form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if 'id' exists in the POST data

    if (!isset($_POST['id'])) {

        die("ID is required.");

    }



    // Sanitize and retrieve form data

    $id = htmlspecialchars($_POST['id']);

    $cfirstname = isset($_POST['cfirstname']) ? htmlspecialchars($_POST['cfirstname']) : '';

    $clastname = isset($_POST['clastname']) ? htmlspecialchars($_POST['clastname']) : '';

    $ceipalid = isset($_POST['ceipalid']) ? htmlspecialchars($_POST['ceipalid']) : '';

    $clinkedinurl = isset($_POST['clinkedin_url']) ? htmlspecialchars($_POST['clinkedin_url']) : '';

    $cdob = isset($_POST['cdob']) ? htmlspecialchars($_POST['cdob']) : '';

    $cmobilenumber = isset($_POST['cmobilenumber']) ? htmlspecialchars($_POST['cmobilenumber']) : '';

    $cemail = isset($_POST['cemail']) ? htmlspecialchars($_POST['cemail']) : '';

    $clocation = isset($_POST['clocation']) ? htmlspecialchars($_POST['clocation']) : '';

    $chomeaddress = isset($_POST['chomeaddress']) ? htmlspecialchars($_POST['chomeaddress']) : '';

    $cssn = isset($_POST['cssn']) ? htmlspecialchars($_POST['cssn']) : '';

    $cwork_authorization_status = isset($_POST['cwork_authorization_status']) ? htmlspecialchars($_POST['cwork_authorization_status']) : '';

    $cv_validate_status = isset($_POST['cv_validate_status']) ? htmlspecialchars($_POST['cv_validate_status']) : '';

    $ccertifications = isset($_POST['ccertifications']) ? htmlspecialchars($_POST['ccertifications']) : '';

    $coverall_experience = isset($_POST['coverall_experience']) ? htmlspecialchars($_POST['coverall_experience']) : '';

    $crecent_job_title = isset($_POST['crecent_job_title']) ? htmlspecialchars($_POST['crecent_job_title']) : '';

    $final_candidate_source = isset($_POST['final_candidate_source']) ? htmlspecialchars($_POST['final_candidate_source']) : ''; // Retrieve final candidate source

    $cresume_attached = isset($_POST['cresume_attached']) ? htmlspecialchars($_POST['cresume_attached']) : '';

    $cphoto_id_attached = isset($_POST['cphoto_id_attached']) ? htmlspecialchars($_POST['cphoto_id_attached']) : '';

    $cwa_attached = isset($_POST['cwa_attached']) ? htmlspecialchars($_POST['cwa_attached']) : '';

    $cany_other_specify = isset($_POST['cany_other_specify']) ? htmlspecialchars($_POST['cany_other_specify']) : '';

    $employer_own_corporation = isset($_POST['employer_own_corporation']) ? htmlspecialchars($_POST['cemployer_own_corporation']) : '';

    $employer_corporation_name = isset($_POST['employer_corporation_name']) ? htmlspecialchars($_POST['employer_corporation_name']) : '';

    $fed_id_number = isset($_POST['fed_id_number']) ? htmlspecialchars($_POST['fed_id_number']) : '';

    $contact_person_name = isset($_POST['contact_person_name']) ? htmlspecialchars($_POST['contact_person_name']) : '';

    $contact_person_designation = isset($_POST['contact_person_designation']) ? htmlspecialchars($_POST['contact_person_designation']) : '';

    $contact_person_address = isset($_POST['contact_person_address']) ? htmlspecialchars($_POST['contact_person_address']) : '';

    $contact_person_phone_number = isset($_POST['contact_person_phone_number']) ? htmlspecialchars($_POST['contact_person_phone_number']) : '';

    $contact_person_extension_number = isset($_POST['contact_person_extension_number']) ? htmlspecialchars($_POST['contact_person_extension_number']) : '';

    $contact_person_email_id = isset($_POST['contact_person_email_id']) ? htmlspecialchars($_POST['contact_person_email_id']) : '';

    $benchsale_recruiter_name = isset($_POST['benchsale_recruiter_name']) ? htmlspecialchars($_POST['benchsale_recruiter_name']) : '';

    $benchsale_recruiter_phone_number = isset($_POST['benchsale_recruiter_phone_number']) ? htmlspecialchars($_POST['benchsale_recruiter_phone_number']) : '';

    $benchsale_recruiter_extension_number = isset($_POST['benchsale_recruiter_extension_number']) ? htmlspecialchars($_POST['benchsale_recruiter_extension_number']) : '';

    $benchsale_recruiter_email_id = isset($_POST['benchsale_recruiter_email_id']) ? htmlspecialchars($_POST['benchsale_recruiter_emailid']) : '';

    $website_link = isset($_POST['website_link']) ? htmlspecialchars($_POST['website_link']) : '';

    $employer_linkedin_url = isset($_POST['employer_linkedin_url']) ? htmlspecialchars($_POST['employer_linkedin_url']) : '';

    $employer_type = isset($_POST['employer_type']) ? htmlspecialchars($_POST['employer_type']) : '';

    $employer_corporation_name1 = isset($_POST['employer_corporation_name1']) ? htmlspecialchars($_POST['employer_corporation_name1']) : '';

    $fed_id_number1 = isset($_POST['fed_id_number1']) ? htmlspecialchars($_POST['fed_id_number1']) : '';

    $contact_person_name1 = isset($_POST['contact_person_name1']) ? htmlspecialchars($_POST['contact_person_name1']) : '';

    $contact_person_designation1 = isset($_POST['contact_person_designation1']) ? htmlspecialchars($_POST['contact_person_designation1']) : '';

    $contact_person_address1 = isset($_POST['contact_person_address1']) ? htmlspecialchars($_POST['contact_person_address1']) : '';

    $contact_person_phone_number1 = isset($_POST['contact_person_phone_number1']) ? htmlspecialchars($_POST['contact_person_phone_number1']) : '';

    $contact_person_extension_number1 = isset($_POST['contact_person_extension_number1']) ? htmlspecialchars($_POST['contact_person_extension_number1']) : '';

    $contact_person_email_id1 = isset($_POST['contact_person_email_id1']) ? htmlspecialchars($_POST['contact_person_email_id1']) : '';

    $collaboration_collaborate = isset($_POST['collaboration_collaborate']) ? htmlspecialchars($_POST['collaboration_collaborate']) : '';

    $delivery_manager = isset($_POST['delivery_manager']) ? htmlspecialchars($_POST['delivery_manager']) : '';

    $delivery_account_lead = isset($_POST['delivery_account_lead']) ? htmlspecialchars($_POST['delivery_account_lead']) : '';

    $team_lead = isset($_POST['team_lead']) ? htmlspecialchars($_POST['team_lead']) : '';

    $associate_team_lead = isset($_POST['associate_team_lead']) ? htmlspecialchars($_POST['associate_team_lead']) : '';

    $business_unit = isset($_POST['business_unit']) ? htmlspecialchars($_POST['business_unit']) : '';

    $client_account_lead = isset($_POST['client_account_lead']) ? htmlspecialchars($_POST['client_account_lead']) : '';

    $associate_director_delivery = isset($_POST['associate_director_delivery']) ? htmlspecialchars($_POST['associate_director_delivery']) : '';

    $delivery_manager1 = isset($_POST['delivery_manager1']) ? htmlspecialchars($_POST['delivery_manager1']) : '';

    $delivery_account_lead1 = isset($_POST['delivery_account_lead1']) ? htmlspecialchars($_POST['delivery_account_lead1']) : '';

    $team_lead1 = isset($_POST['team_lead1']) ? htmlspecialchars($_POST['team_lead1']) : '';

    $associate_team_lead1 = isset($_POST['associate_team_lead1']) ? htmlspecialchars($_POST['associate_team_lead1']) : '';

    $recruiter_name = isset($_POST['recruiter_name']) ? htmlspecialchars($_POST['recruiter_name']) : '';

    $recruiter_employee_id = isset($_POST['recruiter_employee_id']) ? htmlspecialchars($_POST['recruiter_employee_id']) : '';

    $pt_support = isset($_POST['pt_support']) ? htmlspecialchars($_POST['pt_support']) : '';

    $pt_ownership = isset($_POST['pt_ownership']) ? htmlspecialchars($_POST['pt_ownership']) : '';

    $coe_non_coe = isset($_POST['coe_non_coe']) ? htmlspecialchars($_POST['coe_non_coe']) : '';

    $geo = isset($_POST['geo']) ? htmlspecialchars($_POST['geo']) : '';

    $entity = isset($_POST['entity']) ? htmlspecialchars($_POST['entity']) : '';

    $client = isset($_POST['client']) ? htmlspecialchars($_POST['client']) : '';

    $client_manager = isset($_POST['client_manager']) ? htmlspecialchars($_POST['client_manager']) : '';

    $client_manager_email_id = isset($_POST['client_manager_email_id']) ? htmlspecialchars($_POST['client_manager_email_id']) : '';

    $end_client = isset($_POST['end_client']) ? htmlspecialchars($_POST['end_client']) : '';

    $business_track = isset($_POST['business_track']) ? htmlspecialchars($_POST['business_track']) : '';

    $industry = isset($_POST['industry']) ? htmlspecialchars($_POST['industry']) : '';

    $experience_in_expertise_role = isset($_POST['experience_in_expertise_role']) ? htmlspecialchars($_POST['experience_in_expertise_role']) : '';

    $job_code = isset($_POST['job_code']) ? htmlspecialchars($_POST['job_code']) : '';

    $job_title = isset($_POST['job_title']) ? htmlspecialchars($_POST['job_title']) : '';

    $primary_skill = isset($_POST['primary_skill']) ? htmlspecialchars($_POST['primary_skill']) : '';

    $secondary_skill = isset($_POST['secondary_skill']) ? htmlspecialchars($_POST['secondary_skill']) : '';

    $term = isset($_POST['term']) ? htmlspecialchars($_POST['term']) : '';

    $duration = isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : '';

    $project_location = isset($_POST['project_location']) ? htmlspecialchars($_POST['project_location']) : '';

    $start_date = isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : '';

    $end_date = isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '';

    $payrate = isset($_POST['payrate']) ? htmlspecialchars($_POST['payrate']) : '';

    $clientrate = isset($_POST['clientrate']) ? htmlspecialchars($_POST['clientrate']) : '';

    $margin = isset($_POST['margin']) ? htmlspecialchars($_POST['margin']) : '';

    $vendor_fee = isset($_POST['vendor_fee']) ? htmlspecialchars($_POST['vendor_fee']) : '';

    $margin_deviation_approval = isset($_POST['margin_deviation_approval']) ? htmlspecialchars($_POST['margin_deviation_approval']) : '';

    $margin_deviation_reason = isset($_POST['margin_deviation_reason']) ? htmlspecialchars($_POST['margin_deviation_reason']) : '';

    $ratecard_adherence = isset($_POST['ratecard_adherence']) ? htmlspecialchars($_POST['ratecard_adherence']) : '';

    $ratecard_deviation_reason = isset($_POST['ratecard_deviation_reason']) ? htmlspecialchars($_POST['ratecard_deviation_reason']) : '';

    $ratecard_deviation_approved = isset($_POST['ratecard_deviation_approved']) ? htmlspecialchars($_POST['ratecard_deviation_approved']) : '';

    $payment_term = isset($_POST['payment_term']) ? htmlspecialchars($_POST['payment_term']) : '';

    $payment_term_approval = isset($_POST['payment_term_approval']) ? htmlspecialchars($_POST['payment_term_approval']) : '';

    $payment_term_deviation_reason = isset($_POST['payment_term_deviation_reason']) ? htmlspecialchars($_POST['payment_term_deviation_reason']) : '';

    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';



    // Prepare an update statement

    $stmt = $conn->prepare("UPDATE paperworkdetails SET 

            cfirstname=?, clastname=?, ceipalid=?, clinkedinurl=?, cdob=?, cmobilenumber=?, cemail=?, clocation=?, 

            chomeaddress=?, cssn=?, cwork_authorization_status=?, cv_validate_status=?, ccertifications=?, 

            coverall_experience=?, crecent_job_title=?, ccandidate_source=?, cresume_attached=?, cphoto_id_attached=?, 

            cwa_attached=?, cany_other_specify=?, employer_own_corporation=?, employer_corporation_name=?, 

            fed_id_number=?, contact_person_name=?, contact_person_designation=?, contact_person_address=?, 

            contact_person_phone_number=?, contact_person_extension_number=?, contact_person_email_id=?, 

            benchsale_recruiter_name=?, benchsale_recruiter_phone_number=?, benchsale_recruiter_extension_number=?, 

            benchsale_recruiter_email_id=?, website_link=?, employer_linkedin_url=?, employer_type=?, 

            employer_corporation_name1=?, fed_id_number1=?, contact_person_name1=?, contact_person_designation1=?, 

            contact_person_address1=?, contact_person_phone_number1=?, contact_person_extension_number1=?, 

            contact_person_email_id1=?, collaboration_collaborate=?, delivery_manager=?, delivery_account_lead=?, 

            team_lead=?, associate_team_lead=?, business_unit=?, client_account_lead=?, associate_director_delivery=?, 

            delivery_manager1=?, delivery_account_lead1=?, team_lead1=?, associate_team_lead1=?, recruiter_name=?, 

            recruiter_employee_id=?, pt_support=?, pt_ownership=?, coe_non_coe=?, geo=?, entity=?, client=?, 

            client_manager=?, client_manager_email_id=?, end_client=?, business_track=?, industry=?, 

            experience_in_expertise_role=?, job_code=?, job_title=?, primary_skill=?, secondary_skill=?, term=?, 

            duration=?, project_location=?, start_date=?, end_date=?, payrate=?, clientrate=?, margin=?, vendor_fee=?, 

            margin_deviation_approval=?, margin_deviation_reason=?, ratecard_adherence=?, ratecard_deviation_reason=?, 

            ratecard_deviation_approved=?, payment_term=?, payment_term_approval=?, payment_term_deviation_reason=?, 

            type=? WHERE id=?");



    // Check if statement preparation was successful

    if (!$stmt) {

        die("Prepare failed: " . $conn->error);

    }



    // Bind parameters (types should match placeholders in the SQL query)

    $stmt->bind_param(

        'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', // Types of the bound parameters (all 's' for string)

        $cfirstname, $clastname, $ceipalid, $clinkedinurl, $cdob, $cmobilenumber, $cemail, $clocation, $chomeaddress, $cssn, 

        $cwork_authorization_status, $cv_validate_status, $ccertifications, $coverall_experience, $crecent_job_title, $final_candidate_source, 

        $cresume_attached, $cphoto_id_attached, $cwa_attached, $cany_other_specify, $employer_own_corporation, $employer_corporation_name, 

        $fed_id_number, $contact_person_name, $contact_person_designation, $contact_person_address, $contact_person_phone_number, 

        $contact_person_extension_number, $contact_person_email_id, $benchsale_recruiter_name, $benchsale_recruiter_phone_number, 

        $benchsale_recruiter_extension_number, $benchsale_recruiter_email_id, $website_link, $employer_linkedin_url, $employer_type, 

        $employer_corporation_name1, $fed_id_number1, $contact_person_name1, $contact_person_designation1, $contact_person_address1, 

        $contact_person_phone_number1, $contact_person_extension_number1, $contact_person_email_id1, $collaboration_collaborate, 

        $delivery_manager, $delivery_account_lead, $team_lead, $associate_team_lead, $business_unit, $client_account_lead, 

        $associate_director_delivery, $delivery_manager1, $delivery_account_lead1, $team_lead1, $associate_team_lead1, $recruiter_name, 

        $recruiter_employee_id, $pt_support, $pt_ownership, $coe_non_coe, $geo, $entity, $client, $client_manager, $client_manager_email_id, 

        $end_client, $business_track, $industry, $experience_in_expertise_role, $job_code, $job_title, $primary_skill, $secondary_skill, 

        $term, $duration, $project_location, $start_date, $end_date, $payrate, $clientrate, $margin, $vendor_fee, $margin_deviation_approval, 

        $margin_deviation_reason, $ratecard_adherence, $ratecard_deviation_reason, $ratecard_deviation_approved, $payment_term, 

        $payment_term_approval, $payment_term_deviation_reason, $type, $id

    );



// Assuming $record_id is the ID of the record being updated

$record_id = $_POST['id'];



// Retrieve the original record from the database

$original_sql = "SELECT * FROM paperworkdetails WHERE id = ?";

$original_stmt = $conn->prepare($original_sql);

$original_stmt->bind_param("i", $record_id);

$original_stmt->execute();

$original_result = $original_stmt->get_result();

$original_data = $original_result->fetch_assoc();



    // Assuming $stmt is the statement that updates the main record

    if ($stmt->execute()) {

        // Prepare to store modification history

        $modified_by = $_SESSION['email']; // Capture logged-in user's email

        $modified_date = date('Y-m-d H:i:s');

        

        // Iterate over all fields and compare

        foreach ($original_data as $field => $original_value) {

            if (isset($_POST[$field]) && $_POST[$field] != $original_value) {

                $new_value = $_POST[$field];

                

                // Insert each change into the record_history table

                $history_sql = "INSERT INTO record_history (record_id, modified_by, modified_date, modification_details, old_value, new_value) 

                                VALUES (?, ?, ?, ?, ?, ?)";

                $history_stmt = $conn->prepare($history_sql);

                $history_stmt->bind_param("isssss", $record_id, $modified_by, $modified_date, $field, $original_value, $new_value);

                $history_stmt->execute();

                $history_stmt->close();

            }

        }



        $response = [

            'status' => 'success',

            'message' => 'Record updated and modification history stored successfully.'

        ];

    } else {

        $response = [

            'status' => 'error',

            'message' => 'Failed to update record.'

        ];

    }



    $stmt->close();

    $conn->close();



    echo json_encode($response);

}



?>





