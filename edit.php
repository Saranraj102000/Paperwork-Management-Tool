<?php
$servername = "localhost";  // Change if using a different host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "formdata"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php


// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    // Prepare the SQL query to fetch the record
    $sql = "SELECT * FROM paperworkdetails WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the record exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Now $row contains the data of the specific record
    } else {
        echo "Record not found.";
        exit;
    }

    $stmt->close();
} else {
    echo "No ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="editstyles.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- Include your CSS and other resources -->
</head>

<body>

<div class="container">
        <h2 class="text-center">Edit Record</h2>

<form action="update.php" method="post">

<div class="form first">
<div class="details personal">
    <span class="title">Personal Details</span>

    <div class="fields">

    <div class="input-field">
    <!-- Hidden input to pass the ID -->
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    
    <!-- Replace 'your_column_name' with actual column names -->
    <label for="column1">Column 1:</label>
    <input type="text" name="column1" value="<?php echo htmlspecialchars($row['cfirstname']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['clastname']); ?>" required><br>

    <!-- <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ceipal_id']); ?>" required><br> -->

    <!-- <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['clinkedin_url']); ?>" required><br> -->

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cdob']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cmobilenumber']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cemail']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['clocation']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['chomeaddress']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cssn']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cwork_authorization_status']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cv_validate_status']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ccertifications']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['coverall_experience']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['crecent_job_title']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ccandidate_source']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cresume_attached']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cphoto_id_attached']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cwa_attached']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cany_other_specify']); ?>" required><br>




    <!-- <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['cemployer_own_corporation']); ?>" required><br> -->

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['employer_corporation_name']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['fed_id_number']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_name']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_designation']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_address']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_phone_number']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_extension_number']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_email_id']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['benchsale_recruiter_name']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['benchsale_recruiter_phone_number']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['benchsale_recruiter_extension_number']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['website_link']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['employer_linkedin_url']); ?>" required><br>






    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['employer_type']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['employer_corporation_name1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['fed_id_number1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_name1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_designation1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_address1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_phone_number1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_extension_number1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['contact_person_email_id1']); ?>" required><br>






    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['collaboration_collaborate']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['delivery_manager']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['delivery_account_lead']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['team_lead']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['associate_team_lead']); ?>" required><br>





    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['business_unit']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['client_account_lead']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['associate_director_delivery']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['delivery_manager1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['delivery_account_lead1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['team_lead1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['associate_team_lead1']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['recruiter_name']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['recruiter_employee_id']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['pt_support']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['pt_ownership']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['coe_non_coe']); ?>" required><br>






    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['geo']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['entity']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['client']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['client_manager']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['client_manager_email_id']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['end_client']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['business_track']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['industry']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['experience_in_expertise_role']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['job_code']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['job_title']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['primary_skill']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['secondary_skill']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['term']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['duration']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['project_location']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['start_date']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['end_date']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['payrate']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['clientrate']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['margin']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['vendor_fee']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['margin_deviation_approval']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['margin_deviation_reason']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ratecard_adherence']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ratecard_deviation_reason']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['ratecard_deviation_approved']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['payment_term']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['payment_term_approval']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['payment_term_deviation_reason']); ?>" required><br>

    <label for="column2">Column 2:</label>
    <input type="text" name="column2" value="<?php echo htmlspecialchars($row['type']); ?>" required><br>



    <!-- Add more fields as needed -->

    <input type="submit" value="Update">

</div>
</div>
</div>
</div>
</form>
    </div>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Input validation on form submission
document.querySelector('form').addEventListener('submit', function(event) {
    const inputs = document.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'red';
            isValid = false;
        } else {
            input.style.borderColor = '#ced4da';
        }
    });

    if (!isValid) {
        event.preventDefault(); // Prevent form submission
        alert('Please fill out all required fields.');
    }
});

// Smooth scroll to form
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').scrollIntoView({
        behavior: 'smooth'
    });
});
</script>


<script>
const form = document.querySelector("form"),
        nextBtn = form.querySelector(".nextBtn"),
        backBtn = form.querySelector(".backBtn"),
        allInput = form.querySelectorAll(".first input");


nextBtn.addEventListener("click", ()=> {
    allInput.forEach(input => {
        if(input.value != ""){
            form.classList.add('secActive');
        }else{
            form.classList.remove('secActive');
        }
    })
})

backBtn.addEventListener("click", () => form.classList.remove('secActive'));
</script>

</html>
