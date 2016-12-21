#!/usr/bin/env php
<?php

require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('localhost', 25);
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

$targetAddresses = file_get_contents('emails.txt');
$targetAddresses = explode("\n", trim($targetAddresses));

foreach ($targetAddresses as $i => $emailTo) {
    $message = Swift_Message::newInstance()
        // Give the message a subject
        ->setSubject('Последние новости')
        // Set the From address with an associative array
        ->setFrom(['sales@example.com' => 'Fantomas'])
        ->setCc(['it@example.com', 'sales@example.com'])
        ->setReturnPath('karl@example.com')
        // Set the To addresses with an associative array
        //    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
        ->setTo($emailTo);
        // Give it a body

    $message->setBody(
    '<html>' .
    ' <head></head>' .
    ' <body>' .
    '<p>Здравствуйте!</p>
    <p>Просим ознакомиться с сообщением в приложенных файлах.</p>
    <p>С уважением,<br/>
Карл Шустерлинг.</p>'.
    '<p><img src="' .
    $message->embed(Swift_Image::fromPath('attachments/index.jpg')) .
    '" alt="Image" /><br/>' .
    'Тел.: +7 (555) 555 55 55<br/>
    E-mail: <a href="mailto:sales@example.com">sales@example.com</a></p>' .
    '<small style="color:#404040">ООО «Государственный публичный дом имени Н.К. Крупской», ул. Отстойная, д. 13, стр. 42, Волчехуйск, Лугандония<br/>
<a href="https://example.com/">www.example.com</a></small>'.
    ' </body>' .
    '</html>',
    'text/html' // Mark the content-type as HTML
);
    // Optionally add any attachments
    $message->attach(Swift_Attachment::fromPath('attachments/ru.pdf'));
    $message->attach(Swift_Attachment::fromPath('attachments/en.pdf'));

    echo "Sending to $emailTo\n";
    $result = $mailer->send($message);
    var_dump($result);
}
