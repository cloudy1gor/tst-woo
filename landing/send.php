<?php
/*
 * Form mail and send it to the mailhog. ( Tried to use SMTP gmail )
 * */

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formData = $_POST;
    sendToLocalMailServer($formData);
    sendToUserEmail($formData);
}

function sendToLocalMailServer($data) {
    try {

        $hogMail = new PHPMailer(true);
        $hogMail -> CharSet = 'UTF-8';
        $hogMail -> isHTML(true);
        $hogMail -> setLanguage('en', 'phpmailer/language/');
        $hogMail -> addAddress($data['email']);
        $hogMail -> setFrom('savelyev7979@gmail.com', 'Ihor Saveliev');

        $hogMail -> isSMTP();
        $hogMail -> Host = 'mailhog';
        $hogMail -> Port = 1025;

        $hogMail -> Subject = 'Sent from Sample Form by Ihor Saveliev';
        $hogMail -> Body = "Name: " . $data['name'] . "\n" .
            "Email: " . $data['email'] . "\n" .
            "Phone: " . $data['phone'] . "\n" .
            "Password: " . $data['password'] . "\n" .
            "Country: " . $data['country'] . "\n" .
            "Checkbox: " . $data['checkbox'];

        $hogMail -> send();
        $hogMail -> smtpClose();
        echo "Mail was sent to local email server";

    } catch (Exception $e) {
        echo json_encode(array("error" => $hogMail -> ErrorInfo));
    }
}


function sendToUserEmail($data) {
    try {

        $mail = new PHPMailer(true);
        $mail -> CharSet = 'UTF-8';
        $mail -> isHTML(true);
        $mail -> setLanguage('en', 'phpmailer/language/');
        $mail -> setFrom('savelyev7979@gmail.com', 'Ihor Saveliev');
        $mail -> addAddress($data['email']);

        $mail -> isSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = 'smtp.gmail.com';
        $mail -> Username = 'savelyev7979@gmail.com';
        $mail -> Password = 'apnzjlykzvajjvlb';
        $mail -> SMTPSecure = 'TLS';
        $mail -> Port = 587;

        $mail -> Subject = 'Sent from Sample Form by Ihor Saveliev';
        $mail -> Body = "Name: " . $data['name'] . "\n" .
            "Email: " . $data['email'] . "\n" .
            "Phone: " . $data['phone'] . "\n" .
            "Password: " . $data['password'] . "\n" .
            "Country: " . $data['country'] . "\n" .
            "Checkbox: " . $data['checkbox'];

        $mail -> send();
        $mail -> smtpClose();
        echo "Mail was sent to user email";

    } catch (Exception $e) {
//        echo json_encode(array("error" => $mail -> ErrorInfo));
    }
}