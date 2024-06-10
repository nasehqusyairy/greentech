<?php
function set_mail($title, $message, $redirect = null, $button = null): array
{
  return [
    'title' => $title,
    'message' => $message,
    'redirect' => $redirect,
    'button' => $button
  ];
}

// "Hello, <strong>$name</strong>! Thanks for joining us! We're excited to have you as part of our community. To get started, please activate your account by clicking the button below."

function send_email(array $mail, $address): bool
{
  $email = \Config\Services::email();
  $email->setFrom(getenv('SMTP_USER'), getenv('SMTP_NAME'));
  $email->setTo($address);
  $email->setSubject($mail['title']);
  $email->setMessage(view('email/index', $mail));
  return $email->send();
}
