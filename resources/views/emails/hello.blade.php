<?php

$name = Request::get('name');
$email = Request::get('email');
$subject = Request::get('subject');
$message = Request::get('message');
$date_time = date("F j, Y, g:i a");
$userIpAddress = Request::getClientIp();
?>

<h3>We've been contacted by.... </h3>

<p>
Name: {{ $name }}<br>
Email address: {{ $email }}<br>
Subject: {{ $subject }}<br>
-----------------------------------------------------------------------------<br>
Message:<br>
{{ nl2br($message) }}<br>
-----------------------------------------------------------------------------<br>
Date: {{ $date_time }}<br>
User IP address: {{ $userIpAddress }}
</p>
