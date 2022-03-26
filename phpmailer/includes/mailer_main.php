<?php

require '../phpmailer/includes/PHPMailer.php';
require '../phpmailer/includes/Exception.php';
require '../phpmailer/includes/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();

$mail->Host = "localhost";
$mail->SMTPAuth = false;
$mail->SMTPAuthTLS = false;
$mail->Port = 25;

$mail->Username = "wmsudts.noreply@gmail.com";

$mail->Password = "wmsu12345";

?>