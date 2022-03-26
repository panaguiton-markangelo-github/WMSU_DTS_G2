<?php

require '../phpmailer/includes/PHPMailer.php';
require '../phpmailer/includes/Exception.php';
require '../phpmailer/includes/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
);

$mail->isSMTP();

$mail->Host = "smtp.gmail.com";

$mail->SMTPAuth = true;

$mail->SMTPSecure = "tls";

$mail->Port = 587;

$mail->Username = "wmsudts.noreply@gmail.com";

$mail->Password = "wmsu12345";

?>