<?php
// Responsible for getting token

class GetToken {
    
    private $client_id;
    private $client_secret;
    private $redirectUri;
    private $access_token_url;
    private $selectedProvider;
    private $authorizationCode;

    public function __construct($client_id, $client_secret, $redirectUri, $access_token_url, $selectedProvider, $authorizationCode) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirectUri = $redirectUri;
        $this->access_token_url = $access_token_url;
        $this->selectedProvider = $selectedProvider;
        $this->authorizationCode = $authorizationCode;
    }
    /**
     * Get the user's accesstoken.
     *
     * @return string return access token.
     */
    public function getToken() : string {
        // Set up cURL to make the API request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->access_token_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

        if ($this->selectedProvider === ProviderEnum::TWITTER) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode(ProviderEnum::getEnum('TWITTER_CLIENT_ID') . ':' . ProviderEnum::getEnum('TWITTER_CLIENT_SECRET'))));
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $this->authorizationCode,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code_verifier' => ($this->selectedProvider === ProviderEnum::TWITTER) ? 'challenge' : '',
        ]));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for errors and process the response
        if ($response === false) {
            $error = 'invalid token , expire or used';
            header("Location: ../../view/UserLogin.php?error=". $error );
            exit;
        } else {
            $responseData = json_decode($response, true);
            $accessToken = $responseData['access_token']; // Extract the access token
        }

        // Close cURL
        curl_close($ch);

        return $accessToken;
    }
}
