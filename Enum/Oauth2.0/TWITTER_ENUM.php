<?php

class TWITTER_ENUM {

    const TWITTER = 'TWITTER';
    const TWITTER_CLIENT_ID = 'ajNDTmxlZGZ2akhaZ0tOQXB3WWI6MTpjaQ';
    const TWITTER_CLIENT_SECRET = 'rd93twNZM38QiCBB_BgbiCTwLUTwIUrqk2akAQw0kgDUDyrnaS';
    const TWITTER_CALLBACK_URL = 'https://f3d9-210-14-102-81.ngrok-free.app/socialphp/datahandler/SocialCallbackLoginHandler.php/oauth/twitter/callback';
    const TWITTER_AUTH_URL = 'https://twitter.com/i/oauth2/authorize';
    const TWITTER_TOKEN_URL = 'https://api.twitter.com/2/oauth2/token';
    const TWITTER_PROFILE_URL = 'https://api.twitter.com/2/users/me?user.fields=profile_image_url';
    const TWITTER_SCOPE = 'tweet.read users.read offline.access';

}