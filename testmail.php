<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

$mail->SMTPDebug = 2;

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

$mail->Username = 'nobita82123@gmail.com';
$mail->Password = 'pwbytepwskyuzout';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom('nobita82123@gmail.com','Test Mail');
$mail->addAddress('it@zetts.info');

$mail->Subject = 'Test Mail';
$mail->Body = 'SMTP Working';

$mail->send();

echo "Mail Sent";