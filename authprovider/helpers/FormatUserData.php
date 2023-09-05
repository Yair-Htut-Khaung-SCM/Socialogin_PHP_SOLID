<?php
// Responsible for formatting user data

class FormattedUserData {
    /**
    * Get the user's formatted profile information.
    * @param string $selectedProvider The selected social media provider (e.g., 'TWITTER', 'FACEBOOK').
    * @param array $userData The user's data received from the provider.
    * @param string $accessToken The user's access token.
    * @return array An associative array containing the user's profile formatted information.
    */
    public static function formatUserData($selectedProvider, $userData, $accessToken) : array {
        $provider_user_id = '';
        $provider_user_name = '';
        $provider_user_picture = '';
        $provider_user_email = '';

        switch ($selectedProvider) {
            case ProviderEnum::LINE:
                $provider_user_id = $userData['userId'];
                $provider_user_name = $userData['displayName'];
                $provider_user_picture = $userData['pictureUrl'];
                $provider_user_email = isset($userData['email']) ? $userData['email'] : '';
                break;
            case ProviderEnum::FACEBOOK:
                $provider_user_id = $userData['id'];
                $provider_user_name = $userData['name'];
                $provider_user_picture = $userData['picture']['data']['url'];
                $provider_user_email = isset($userData['email']) ? $userData['email'] : '';
                break;
            case ProviderEnum::GOOGLE:
                $provider_user_id = $userData['sub'];
                $provider_user_name = $userData['name'];
                $provider_user_picture = $userData['picture'];
                $provider_user_email = isset($userData['email']) ? $userData['email'] : '';
                break;
            case ProviderEnum::TWITTER:
                $provider_user_id = $userData['data']['id'];
                $provider_user_name = $userData['data']['name'];
                $provider_user_picture = $userData['data']['profile_image_url'];
                $provider_user_email = isset($userData['email']) ? $userData['email'] : '';
                break;
            case ProviderEnum::GITHUB:
                $provider_user_id = $userData['id'];
                $provider_user_name = $userData['login'];
                $provider_user_picture = $userData['avatar_url'];
                $provider_user_email = isset($userData['email']) ? $userData['email'] : '';
                break;
            default:
                $error = 'invalid provider';
                header("Location: ../../view/UserLogin.php?error=". $error );
                exit;

        }

        $userDataFormatted['provider_user_id'] = $provider_user_id;
        $userDataFormatted['provider_user_name'] = $provider_user_name;
        $userDataFormatted['provider_user_picture'] = $provider_user_picture;
        $userDataFormatted['provider_user_email'] = $provider_user_email;
        $userDataFormatted['providerName'] = strtolower($selectedProvider);
        $userDataFormatted['access_token'] = $accessToken;

        return $userDataFormatted;
    }
}
