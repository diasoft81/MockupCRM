<?php
function send_email($to, $subject, $message, $link = '') {
    $headers = "From: noreply@example.com\r\nContent-Type: text/html; charset=UTF-8";
    $body = "<p>$message</p>";
    if ($link) $body .= "<p><a href='$link'>Approve Now</a></p>";
    mail($to, $subject, $body, $headers);
}
