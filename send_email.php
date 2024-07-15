<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit('Method Not Allowed');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    $to = "muhdadil110@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission: " . $subject;
    $body = "You have received a new message from your website contact form.\n\n" .
            "Here are the details:\n\n" .
            "Full Name: $fname\n" .
            "Email: $email\n\n" .
            "Subject: $subject\n\n" .
            "Message:\n$message";

    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
    }
}

$response = [
    'success' => true,
    'message' => 'Message sent successfully!'
];

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
