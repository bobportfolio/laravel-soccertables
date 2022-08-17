<?php

$name = Request::get('name');
$email = Request::get('email');
$subject = Request::get('subject');
$message = Request::get('message');
$date_time = date("F j, Y, g:i a");
?>

<h4>Thank you very much for contacting me. I will get back to you as soon as possible.<br>
<br>
Kind regards Robert Smith</h4>

<p>
Name: {{ $name }}<br>
Email address: {{ $email }}<br>
Subject: {{ $subject }}<br>
-----------------------------------------------------------------------------<br>
Message:<br>
{{ nl2br($message) }}<br>
-----------------------------------------------------------------------------<br>
Date: {{ $date_time }}<br>
</p>
