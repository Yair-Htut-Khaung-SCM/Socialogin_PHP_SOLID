<?php

$servername = "localhost";
$username = "Yair";
$password = "zerozero";
$db = "SocialLogin";



$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error)
{
    $error = "Connection failed: " . $conn->connect_error;
    header("Location: ../view/UserLogin.php?error=". $error );
    exit;
}

