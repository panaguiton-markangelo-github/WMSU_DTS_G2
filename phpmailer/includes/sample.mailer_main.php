<?php

require '../phpmailer/includes/PHPMailer.php';
require '../phpmailer/includes/Exception.php';
require '../phpmailer/includes/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail->isSMTP();

$mail->Host = "smtp.hostinger.ph";

$mail->SMTPAuth = true;

$mail->SMTPSecure = "tls";

$mail->Port = "587";

$mail->Username = "XXXXXXXXX";

$mail->Password = "XXXXXXXXX";

?>