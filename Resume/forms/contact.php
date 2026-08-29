<?php
  // Recipient Email Address
  $receiving_email_address = 'mdevsinghm@gmail.com';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and capture input fields
    $name    = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject'] ?? 'Website Inquiry'), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_var(trim($_POST['message'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validation
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      http_response_code(400);
      echo "Please complete all required fields with a valid email address.";
      exit;
    }

    // Email Body
    $email_content  = "You have received a new message from your website portfolio contact form:\n\n";
    $email_content .= "Name: " . $name . "\n";
    $email_content .= "Email: " . $email . "\n";
    $email_content .= "Subject: " . $subject . "\n\n";
    $email_content .= "Message:\n" . $message . "\n";

    // Email Headers
    $email_headers  = "From: " . $name . " <" . $email . ">\r\n";
    $email_headers .= "Reply-To: " . $email . "\r\n";
    $email_headers .= "X-Mailer: PHP/" . phpversion();

    // Send Mail
    if (mail($receiving_email_address, "Portfolio Contact: " . $subject, $email_content, $email_headers)) {
      http_response_code(200);
      echo "OK";
    } else {
      http_response_code(500);
      echo "Unable to send your message. Please verify your server mail configuration.";
    }
  } else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
  }
?>