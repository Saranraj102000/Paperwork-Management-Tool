<?php 

// echo "submit form";

session_start();

ob_start(); 

require 'config.php';



require 'phpmailer/src/Exception.php';

require 'phpmailer/src/PHPMailer.php';

require 'phpmailer/src/SMTP.php';



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\SMTP;



// Check if form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data

    $email = $_POST['email'];

    $reason = $_POST['options'];

    $additionalInfo = isset($_POST['createOptions']) ? $_POST['createOptions'] : '';

    $otherReason = isset($_POST['textAreaContainer']) ? $_POST['textAreaContainer'] : '';

    $lookingRoles = isset($_POST['additionalTextArea']) ? $_POST['additionalTextArea'] : '';



    // Connect to the database (Update database credentials based on your setup)

    $conn = new mysqli("localhost", "unsubscribe", "p5?2EY46FjD+", "unsubscribe");



    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }



    // Format current date to desired format (d/m/y)

    $dateFormatted = date('d/m/y');



    // Prepare and bind the SQL statement

    $stmt = $conn->prepare("INSERT INTO unsubscribers (email, reason, additional_info, other_reason, looking_roles, date) VALUES (?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%y'))");

    $stmt->bind_param("ssssss", $email, $reason, $additionalInfo, $otherReason, $lookingRoles, $dateFormatted);



    if ($stmt->execute()) {

        // Data inserted successfully

        echo '<script>alert("Thank You! Your Feedback is Valuable to Us"); window.location.replace(document.referrer);</script>';



        try {

            $mail = new PHPMailer(true);

        

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'saranraj50540@gmail.com';

            $mail->Password = 'duxaotaxptdtniez';

            $mail->SMTPSecure = 'ssl';

            $mail->Port = 465;

        

            // Send email to admin

            $mail->setFrom('saranraj50540@gmail.com');

            $mail->addAddress('saranraj102000@gmail.com'); // Admin email address

            $mail->isHTML(true);

            $mail->Subject = 'New Feedback Submission';

            $mail->Body = 'A new feedback has been submitted:<br><br>User Email: ' . $email . '<br>Reason: ' . $reason . '<br>Additional Info: ' . $additionalInfo . '<br>Other Reason: ' . $otherReason;

            $mail->send();



            // Send confirmation email to the user

            $mail->clearAddresses();

            $mail->addAddress($email); // User email address

            $mail->Subject = 'Feedback Submitted Successfully';

            $mail->Body = 'Hi,<br><br>We have received your request to unsubscribe from our services and will ensure you no longer receive communications from us. If you need further assistance or are seeking new opportunities, please email us at csm@vdartinc.com. We are happy to help.' .

              '<br><br><div style="margin-left: 10px;"><img src="https://myfiles.space/user_files/215797_86b4cb4ecfd8b641/215797_custom_files/img1715867137.png" alt="VDart Logo" style="width:100px;height:auto;margin-top:20px;float:left;">' .

              '<span style="font-size: 12px; margin-left: 30px; font-weight: bold; font-family: Arial, sans-serif; color: #333;">Regards,<br><span style="font-weight: bold; margin-left: 30px;">Team VDart,</span><br><a href="http://www.vdart.com" target="_blank" style="color: #007bff; text-decoration: none; margin-left: 30px;">www.vdart.com</a></span></div>' .

              '<br><img src="https://myfiles.space/user_files/215797_86b4cb4ecfd8b641/215797_custom_files/img1715867137.jpeg" alt="VDart Banner" style="width:500px;height:auto;margin-top:20px;">' .

              '<br><span style="font-size:11px;line-height:110%;color:#BFBFBF;">The content of this email is confidential and intended for the recipient specified in the message only. It is strictly forbidden to share any part of this message with any third party, without the written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</span>';



            $mail->send();



            echo "<script>alert('Feedback submitted successfully, and admin notified.'); window.location.href = 'index.php';</script>";

        } catch (Exception $e) {

            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        }

    } else {

        // Handle error if insertion fails

        echo '<script>alert("Error: Feedback not submitted. Please try again."); window.location.replace(document.referrer);</script>';

    }



    // Close statement and connection

    $stmt->close();

    $conn->close();

} else {

    // Handle case where form is not submitted

    echo '<script>alert("Error: Form submission method not valid."); window.location.replace(document.referrer);</script>';

}

?>

