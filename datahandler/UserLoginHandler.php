<?php
// responsible for handling manual login

include '../database/Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$email = $_POST['email'] ? $_POST['email'] : '' ;
$password = $_POST['password'] ? $_POST['password'] : '';
$error = '';

$query = "SELECT id, email, password, remember_token FROM users WHERE email = ? AND password IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $hashedPassword = ($user['password'] ? $user['password'] : '');
        $remember_token = $user['remember_token'];

        // Verify the entered password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, start a session and redirect to UserProfileDetail.php
            echo 'Password is correct.';
            header("Location: ../view/UserProfileDetail.php?token=". $remember_token );
            exit;
        } else {
            $error = 'invalid email or password';
            header("Location: ../view/UserLogin.php?error=". $error );
            exit;
        }
    }
} else {
    $error = 'invalid email or password';
    header("Location: ../view/UserLogin.php?error=". $error );
    exit;
}
}


