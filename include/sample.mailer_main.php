<?php

require __DIR__.'/phpmailer/includes/PHPMailer.php';
require __DIR__.'/phpmailer/includes/Exception.php';
require __DIR__.'/phpmailer/includes/SMTP.php';

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