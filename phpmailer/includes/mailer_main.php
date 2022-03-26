<?php

require '../phpmailer/includes/PHPMailer.php';
require '../phpmailer/includes/Exception.php';
require '../phpmailer/includes/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();

$mail->Host = "smtp.hostinger.com";

$mail->SMTPAuth = true;

$mail->SMTPSecure = "tls";

$mail->Port = "465";

$mail->Username = "support@tracking.wmsuics.tech";

$mail->Password = "tracking_MARK01";

?>