#!/usr/bin/env php
<?php

require_once './vendor/autoload.php';

$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
    ->setUsername('username@gmail.com')
    ->setPassword('password');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$targetAddresses = file_get_contents('emails.txt');
$targetAddresses = explode("\n", trim($targetAddresses));

foreach ($targetAddresses as $i => $emailTo) {
    $message = new Swift_Message();
    $message
        // Give the message a subject
        ->setSubject('Merry Christmas')
        // Set the From address with an associative array
        ->setFrom(['sales@example.com' => 'Fantomas'])
        // ->setCc(['it@example.com', 'sales@example.com'])
        ->setReturnPath('info@example.com')
        // Set the To addresses with an associative array
        //    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
        ->setTo($emailTo);
        // Give it a body

    $body = file_get_contents('tpl/xmas.html');
    $message->setEncoder( new Swift_Mime_ContentEncoder_PlainContentEncoder('8bit'));

    $message->setBody($body, 'text/html');

    echo "Sending to $emailTo\n";
    $result = $mailer->send($message);
    var_dump($result);
}
