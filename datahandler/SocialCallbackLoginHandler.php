<?php
// handle for callback form social platform redirect link

include '../Enum/ProviderEnum.php';
include '../authprovider/helpers/GetProviderFromUrl.php';
include '../authprovider/social/GetToken.php';
include '../authprovider/social/GetProfile.php';
include '../authprovider/helpers/FormatUserData.php';

if(empty($_GET['code'])) {
    echo "Something wrong in Access Profile process";
}

// Check if the uppercase value exists in ProviderEnum
if (defined("ProviderEnum::$selectedProvider")) {

    $clientConstant = $selectedProvider . '_CLIENT_ID';
    $clientSecretConstant = $selectedProvider . '_CLIENT_SECRET';
    $clientCallBackConstant = $selectedProvider . '_CALLBACK_URL';
    $clientTokenUrlConstant = $selectedProvider . '_TOKEN_URL';
    $clientProfileUrlConstant = $selectedProvider . '_PROFILE_URL';


    $client_id =  ProviderEnum::getEnum($clientConstant);
    $client_secret = ProviderEnum::getEnum($clientSecretConstant);
    $redirectUri = ProviderEnum::getEnum($clientCallBackConstant);
    $access_token_url = ProviderEnum::getEnum($clientTokenUrlConstant);
    $access_profile_url = ProviderEnum::getEnum($clientProfileUrlConstant);
    $authorizationCode = $_GET['code']; 

    //get access token
    $getToken = new GetToken( $client_id, $client_secret, $redirectUri, $access_token_url, $selectedProvider, $authorizationCode);
    $accessToken = $getToken->getToken();

    //get profile detail 
    $getProfile = new GetProfile( $access_profile_url, $selectedProvider);
    $userData = $getProfile->getProfile($accessToken);

    //format profile detail
    $userDataFormatted = FormattedUserData::formatUserData($selectedProvider, $userData, $accessToken);

    //encode user data to store database
    $encodedUserData = urlencode(json_encode($userDataFormatted));

    $host = $_SERVER['HTTP_HOST'];
    $userProfileUrl = "https://$_SERVER[HTTP_HOST]";
    $userProfileUrl.= "/" .$pathSegments[1]. "/";
    $userProfileUrl.= 'datahandler/SocialUserDataHandler.php?data=' . $encodedUserData;
    
    header('Location: ' . $userProfileUrl);
    exit;

} else {
    // The value does not exist in ProviderEnum
    $error =  "Callback Segment: $callbackSegment is not valid";
    header("Location: ../view/UserLogin.php?error=". $error );
    exit;
}



