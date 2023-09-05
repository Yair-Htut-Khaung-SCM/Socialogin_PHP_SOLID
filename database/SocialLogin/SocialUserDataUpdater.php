<?php
// responsible for data updating by social login ( users and provider_information )

class SocialUserDataUpdater {

    /**
     * Update user data into the database.
     *
     * @param string $displayName The user's display name.
     * @param string $userEmail The user's email address.
     * @param string $userPhoto The URL of the user's photo.
     * @param string $providerAccessToken The access token provided by the OAuth provider.
     * @param string $providerName The name of the OAuth provider (e.g., Twitter, Facebook).
     * @param string $providerUserId The unique user ID provided by the OAuth provider.
     * @param mysqli $conn The MySQLi database connection object.
     *
     * @return void current make it void .. for futher change's can chnage this toa a string
     */
    public static function updateUserData(
        $displayName, 
        $userEmail, 
        $userPhoto, 
        $providerAccessToken, 
        $providerName, 
        $providerUserId,
        $conn
    ) : string {


        // Update user information in provider_information table
        $sqlUpdate = "UPDATE provider_information 
        SET provider_user_name = ?, 
            provider_user_email = ?, 
            provider_user_picture = ?, 
            access_token = ? 
        WHERE provider_name = ? AND provider_user_id = ?";

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssssss", $displayName, $userEmail, $userPhoto, $providerAccessToken, $providerName, $providerUserId);

        if ($stmtUpdate->execute() && $stmtUpdate->affected_rows > 0) {
            // Fetch the updated user's id from provider_information
            $sqlFetchUserId = "SELECT user_id FROM provider_information WHERE provider_name = ? AND provider_user_id = ?";
            $stmtFetchUserId = $conn->prepare($sqlFetchUserId);
            $stmtFetchUserId->bind_param("ss", $providerName, $providerUserId);

            if ($stmtFetchUserId->execute()) {
                $resultUserId = $stmtFetchUserId->get_result();

                if ($resultUserId->num_rows > 0) {
                    $userData = $resultUserId->fetch_assoc();

                    // Update the corresponding user information in users table
                    $sqlUpdateUser = "UPDATE users 
                    SET name = ?, 
                        email = ?, 
                        provider_name = ?, 
                        provider_user_id = ?,
                        remember_token = ?
                    WHERE id = ?";
                    $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
                    $stmtUpdateUser->bind_param("ssssss", $displayName, $userEmail, $providerName, $providerUserId, $providerAccessToken, $userData['user_id']);

                    if ($stmtUpdateUser->execute()) {
                        return 'User data updated successfully.';
                    } else {
                        $error = 'Error updating user data in users table: ' . $stmtUpdateUser->error;
                        header("Location: ../../view/UserLogin.php?error=". $error );
                        exit;
                    }
                } else {
                    
                    $error = 'No matching record found in provider_information.';
                    header("Location: ../../view/UserLogin.php?error=". $error );
                    exit;
                }
            } else {
                 
                $error = 'Error fetching updated user id: ' . $stmtFetchUserId->error;
                header("Location: ../view/UserLogin.php?error=". $error );
                exit;
            }
        } else {
            
            $error = 'No matching record found for update.';
            header("Location: ../view/UserLogin.php?error=". $error );
            exit;
        }
    }
}


