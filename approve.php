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
$type = isset($_GET['type']) ? $_GET['type'] : 'manager';


/* FETCH DATA */

$q = mysqli_query($con,"SELECT prepared_by FROM reqentry_new WHERE code='$code'");

$row = mysqli_fetch_assoc($q);

$prepared_by = strtolower(trim($row['prepared_by']));


/* EMAIL LIST */

$email_list = array(

"mayur joshi" => "it@zetts.info",
"manager" => "it@zetts.info"

);


$prepared_email = $email_list[$prepared_by];
$manager_email = $email_list["manager"];



/* IF PREPARER APPROVES */

if($type=="prepare")
{

mysqli_query($con,"UPDATE reqentry_new 
SET approval_status='Prepared_Approved',
approved_by_prepare='Approved'
WHERE code='$code'");


/* SEND MAIL TO MANAGER */

$pdf_link="http://mypc.servequake.com:8080/Reception/reqprint.php?code=".$code;

$approve_link="http://mypc.servequake.com:8080/Reception/approve.php?code=".$code."&type=manager";

$reject_link="http://mypc.servequake.com:8080/Reception/reject.php?code=".$code;


$subject="Manager Approval Required - ".$code;

$message="

Hello Manager,

Requisition has been approved by Prepared By.

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

try{

$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;

$mail->Username='nobita82123@gmail.com';
$mail->Password='pwbytepwskyuzout';

$mail->SMTPSecure='tls';
$mail->Port=587;

$mail->SMTPOptions=array(
'ssl'=>array(
'verify_peer'=>false,
'verify_peer_name'=>false,
'allow_self_signed'=>true
)
);

$mail->setFrom('nobita82123@gmail.com','Zetts Factory');

$mail->addAddress($manager_email);

/* CC Prepared By */

$mail->addCC($prepared_email);

$mail->Subject=$subject;
$mail->Body=$message;

$mail->send();

}
catch(Exception $e)
{
echo "Mailer Error: ".$mail->ErrorInfo;
}



echo "<h2>Approved Successfully</h2>";
echo "Sent to Manager for Final Approval";

exit;

}



/* IF MANAGER APPROVES */

if($type=="manager")
{

mysqli_query($con,"UPDATE reqentry_new 
SET approval_status='Approved',
approved_by_manager='Approved'
WHERE code='$code'");

echo "<h2>Requisition Fully Approved</h2>";

}

?>