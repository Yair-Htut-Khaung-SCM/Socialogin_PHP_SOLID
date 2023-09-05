<?php
// responsible for getting user information to show profile detail

class GetUserInfromation {

    /**
     * Get user information based on an access token.
     *
     * @param string $token The access token used to retrieve user information.
     * @param mysqli $conn The MySQLi database connection object.
     *
     * @return array An associative array containing user information.
     */
    public static function getUserInformation($token, $conn) : array {
            // get userinfo from provider,user table token field
            $query = "SELECT * FROM provider_information WHERE access_token = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $token);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Fetch data from the result
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $userInfo['provider_name'] = $row['provider_name'];
                    $userInfo['username'] = $row['provider_user_name'];
                    $userInfo['useremail'] = $row['provider_user_email'];
                    $userInfo['useravatar'] = $row['provider_user_picture'];
                    $userInfo['itsfromprovider'] = 'Provider';
                }
            } else {

                $query = "SELECT * FROM users WHERE remember_token = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $token);
                $stmt->execute();
            
                // Get the result
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $userInfo['provider_name'] = $row['provider_name'];
                        $userInfo['username'] = $row['name'];
                        $userInfo['useremail'] = $row['email'];
                        $userInfo['useravatar'] = '';
                        $userInfo['itsfromprovider'] = 'System';
                    }
                } else {
                     
                    $error = "No record user found";
                    header("Location: ../view/UserLogin.php?error=". $error );
                    exit;
                }
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();

            return $userInfo;
    }
}