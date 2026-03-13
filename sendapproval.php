<?php

include('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Kolkata');

if(!isset($_GET['code']))
{
    die("Invalid Request");
}

$code = mysqli_real_escape_string($con,$_GET['code']);


/* FETCH PREPARED BY */

$q = mysqli_query($con,"SELECT prepared_by FROM reqentry_new WHERE code='$code'");

if(mysqli_num_rows($q)==0)
{
    die("Requisition not found");
}

$row = mysqli_fetch_assoc($q);

$prepared_by = strtolower(trim($row['prepared_by']));


/* EMAIL LIST */

$email_list = array(

"mayur joshi" => "joshimayur039@gmail.com",
"manager" => "nobita82123@gmail.com"   // testing manager mail

);


/* GET EMAIL */

if(!isset($email_list[$prepared_by]))
{
    die("Prepared by email not found");
}

$to = $email_list[$prepared_by];


/* LINKS */

$pdf_link="http://mypc.servequake.com:8080/Reception/reqprint.php?code=".$code;

$approve_link="http://mypc.servequake.com:8080/Reception/approve.php?code=".$code."&type=prepare";

$reject_link="http://mypc.servequake.com:8080/Reception/reject.php?code=".$code;


/* EMAIL CONTENT */

$subject="Requisition Approval Required - ".$code;

$message="
Hello,

A requisition requires your approval.

Requisition Code: $code

View PDF:
$pdf_link

Approve:
$approve_link

Reject:
$reject_link

Regards
Zetts Factory System
";


$mail = new PHPMailer(true);

try {

$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

$mail->Username = 'nobita82123@gmail.com';
$mail->Password = 'your app password';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;


/* IMPORTANT FOR XAMPP */

$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);


$mail->CharSet = 'UTF-8';
$mail->isHTML(false);


/* EMAIL HEADERS */

$mail->setFrom('nobita82123@gmail.com','Zetts Factory');

$mail->addAddress($to);


/* EMAIL DATA */

$mail->Subject = $subject;
$mail->Body = $message;


/* SEND EMAIL */

$mail->send();

$mail_status = true;

}
catch (Exception $e) {

$mail_status = false;
echo "Mailer Error: " . $mail->ErrorInfo;

}


/* UPDATE STATUS */

if($mail_status)
{

mysqli_query($con,"UPDATE reqentry_new
SET approval_status='Pending_Preparer'
WHERE code='$code'");

echo "<script>
alert('Approval Email Sent Successfully');
window.location='reqsearch.php';
</script>";

}
else
{

echo "<script>
alert('Email Sending Failed');
window.location='reqsearch.php';
</script>";

}


?>
