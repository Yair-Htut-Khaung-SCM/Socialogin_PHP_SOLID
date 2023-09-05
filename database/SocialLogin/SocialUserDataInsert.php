<?php
// responsible for data inserting by social login ( users and provider_information )

class SocialUserDataInsert {

    /**
     * Insert user data into the database.
     *
     * @param string $displayName The user's display name.
     * @param string $userEmail The user's email address.
     * @param string $userPhoto The URL of the user's photo.
     * @param string $providerAccessToken The access token provided by the OAuth provider.
     * @param string $providerName The name of the OAuth provider (e.g., Twitter, Facebook).
     * @param string $providerUserId The unique user ID provided by the OAuth provider.
     * @param mysqli $conn The MySQLi database connection object.
     *
     * @return void
     */
    public static function insertUserData(
        $displayName, 
        $userEmail, 
        $userPhoto, 
        $providerAccessToken, 
        $providerName, 
        $providerUserId,
        $conn
    ) : void {

        $sql = "INSERT INTO users (provider_user_id, provider_name, name, email, remember_token) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $providerUserId, $providerName, $displayName, $userEmail, $providerAccessToken);

        if ($stmt->execute()) {
            // Retrieve the inserted user_id
            $userId = $conn->insert_id;

            // Now you can use $userId in the next SQL query
            $sql = "INSERT INTO provider_information (user_id, provider_name, provider_user_id, provider_user_name, provider_user_email, provider_user_picture, access_token) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $userId, $providerName, $providerUserId, $displayName, $userEmail, $userPhoto, $providerAccessToken);

            if ($stmt->execute()) {
                echo 'User data inserted successfully.';
            } else {
                $error = 'Error inserting user data into provider_information: ' . $stmt->error;
                header("Location: ../../view/UserLogin.php?error=". $error );
                exit;
            }
        } else {
            $error = 'Error inserting user data into users: ' . $stmt->error;
            header("Location: ../../view/UserLogin.php?error=". $error );
            exit;
        }
    }
}
