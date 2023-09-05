<?php
// responsible for handling various provider common
class ProviderEnum {

    const TWITTER = 'TWITTER';
    const FACEBOOK = 'FACEBOOK';
    const LINE = 'LINE';
    const GOOGLE = 'GOOGLE';
    const GITHUB = 'GITHUB';
    //add another provider

    public static function getEnum($constantName) {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $Enum = explode('_', $constantName)[0];
        if ($reflectionClass->hasConstant($Enum)) {
            $enumClassName = $Enum . '_ENUM';
            $enumFileName = $enumClassName . '.php';
        
        if (file_exists(('../Enum/Oauth2.0/' . $enumFileName))) {

            require_once ('../Enum/Oauth2.0/' . $enumFileName);
            if (class_exists($enumClassName)) {
                if (defined("$enumClassName::$constantName")) {
                    
                    return constant("$enumClassName::$constantName");
                }
            }
        } //make file_exists ('../Enum/Oauth1.0/' . $enumFileName) if using 

        } else {
            return null; // Or handle the case where the constant doesn't exist
        }
    }

    const GRANT_TYPE = 'authorization_code';
    const CODE_VERIFIER = 'challenge';
    
}
?>
