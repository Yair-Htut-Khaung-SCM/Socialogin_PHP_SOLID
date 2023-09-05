<?php
// Responsible for fetching user profiles

class GetProfile {

    private $access_profile_url;
    private $selectedProvider;

    public function __construct($access_profile_url, $selectedProvider ) {

        $this->access_profile_url = $access_profile_url;
        $this->selectedProvider = $selectedProvider;
    }

    /**
     * Get the user's profile information.
     *
     * @param string $accessToken The user's access token.
     * @return array An associative array containing the user's profile information.
     */
    public function getProfile($accessToken) : array {
        // Set up cURL to make the API request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->access_profile_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            (($this->selectedProvider === ProviderEnum::GITHUB) ?  'User-Agent:' . ProviderEnum::getEnum('GITHUB_APP_NAME') : ''),
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $response = curl_exec($ch);
    
        // Check for errors and process the response
        if ($response === false) {
            $error = 'invalid profile user';
            header("Location: ../../view/UserLogin.php?error=". $error );
            exit;
        } else {
            $userData = json_decode($response, true);

            return $userData;
    
            curl_close($ch);

        }


    }
}
