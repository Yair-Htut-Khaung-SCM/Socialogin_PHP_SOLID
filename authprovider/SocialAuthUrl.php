<?php
// Responsible for generating authorization code

include '../Enum/ProviderEnum.php';

$selectedProvider = $_GET['provider']; // Get the selected provider from the query string


// Construct the constant name for the selected provider's authorization URL
$authUrlConstant = $selectedProvider . '_AUTH_URL';
$authUrlClientConstant = $selectedProvider . '_CLIENT_ID';
$authUrlClientURLConstant = $selectedProvider . '_CALLBACK_URL';
$authUrlClientSCOPEConstant = $selectedProvider . '_SCOPE';

if(!(ProviderEnum::getEnum($authUrlConstant))) {
    $error = 'This provider is not support yet';
    header("Location: ../view/UserLogin.php?error=". $error );
    exit;
}

$authUrl = ProviderEnum::getEnum($authUrlConstant);
$authUrl .= "?response_type=code";
$authUrl .= "&client_id=" . ProviderEnum::getEnum($authUrlClientConstant);
$authUrl .= "&redirect_uri=" . ProviderEnum::getEnum($authUrlClientURLConstant);
$authUrl .= "&state=state";
$authUrl .= "&scope=" . ProviderEnum::getEnum($authUrlClientSCOPEConstant);
if($selectedProvider === ProviderEnum::TWITTER) {
    $authUrl .= "&code_challenge=challenge";
    $authUrl .= "&code_challenge_method=plain";
}

echo "<script>window.location.href = '$authUrl';</script>";

?>