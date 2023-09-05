<?php

$servername = "localhost";
$username = "Yair";
$password = "zerozero";
$db = "SocialLogin";

$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create the 'users' table
$sqlUsers = "
CREATE TABLE users (
    id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    provider_user_id VARCHAR(255) NULL,
    provider_name VARCHAR(255) NULL,
    name VARCHAR(255),
    email VARCHAR(255) NULL DEFAULT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
)";

if ($conn->query($sqlUsers) === TRUE) {
    echo "Table 'users' created successfully<br>";
} else {
    echo "Error creating table 'users': " . $conn->error . "<br>";
}

// SQL to create the 'provider_information' table
$sqlProviderInformation = "
CREATE TABLE provider_information (
    id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    provider_name VARCHAR(255) NOT NULL,
    provider_user_id VARCHAR(255) NOT NULL,
    provider_user_name VARCHAR(255) NOT NULL,
    provider_user_email VARCHAR(255) NOT NULL,
    provider_user_picture VARCHAR(255) NOT NULL,
    access_token VARCHAR(255) NOT NULL,
    refresh_token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sqlProviderInformation) === TRUE) {
    echo "Table 'provider_information' created successfully<br>";
} else {
    echo "Error creating table 'provider_information': " . $conn->error . "<br>";
}

// Close the database connection
$conn->close();
?>
