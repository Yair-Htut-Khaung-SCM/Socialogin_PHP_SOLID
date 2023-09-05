<?php
// responsible for handling user data whether update or insert

require_once '../Enum/ProviderEnum.php';
require_once '../database/Connection.php';
require_once '../database/SocialLogin/SocialUserDataUpdater.php';
require_once '../database/SocialLogin/SocialUserDataInsert.php';

// Retrieve the encoded user data from the URL parameter
$encodedUserData = $_GET['data'];

// Decode the JSON-encoded user data
$userData = json_decode(urldecode($encodedUserData), true);

// Extract user information
$providerUserId = $userData['provider_user_id'];
$displayName = $userData['provider_user_name'];
$userPhoto = $userData['provider_user_picture'] ? $userData['provider_user_picture'] : '';
$userEmail = $userData['provider_user_email'] ? $userData['provider_user_email'] : '';
$providerName = $userData['providerName'];
$providerAccessToken = $userData['access_token'];

// check if the provider if already exist
$query = "SELECT * FROM provider_information WHERE provider_name = ? AND provider_user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $providerName, $providerUserId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    // update user and provider information if already exist
    $result = SocialUserDataUpdater::updateUserData($displayName, $userEmail, $userPhoto, $providerAccessToken, $providerName, $providerUserId, $conn);

} else {
    // insert user and provider information
    $result = SocialUserDataInsert::insertUserData($displayName, $userEmail, $userPhoto, $providerAccessToken, $providerName, $providerUserId, $conn);

}

$conn->close();
$stmt->close();


header("Location: ../view/UserProfileDetail.php?token=" . urlencode($providerAccessToken));
exit();

