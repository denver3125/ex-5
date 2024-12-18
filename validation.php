<?php
// validation.php - Handles the AJAX request

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Validate message
    if (empty($message)) {
        $errors['message'] = 'Message is required.';
    }

    if (!empty($errors)) {
        // Return validation errors
        echo json_encode(['status' => 'error', 'errors' => $errors]);
    } else {
        // Save to a file or handle the data (e.g., send email)
        $feedback = "Name: $name\nEmail: $email\nMessage: $message\n---\n";
        file_put_contents('feedback.txt', $feedback, FILE_APPEND | LOCK_EX);

        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
    }
    exit;
}
