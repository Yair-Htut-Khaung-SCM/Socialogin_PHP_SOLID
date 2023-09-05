## SocialLogin PHP with SOLID design principle

create project folder

```
mkdir socialphp
```

git clone the project

```
git clone https://github.com/Yair-Htut-Khaung-SCM/Socialogin_PHP_SOLID.git
```

go to the `Enum > Oauth2.0` and  `make change your facebook, twitter, line, github, google client_id, client secret, redirect url`

### Add new provider 
 define your `provider` in `Enum > ProviderEnum.php`

 and create new file `YOURPROVIDER_ENUM.php` and add like other provider

### First create database with the name of `database>DatabaseInitializer.php`

if it's output say successfully create users, and provider_information table then you good to run the project


#### In web url

```
https://yourngrok.app/socialphp/view/UserLogin.php
```


What's ngrok ? see [here](https://github.com/Yair-Htut-Khaung-SCM/SocialLoginLaravelSocialite)

also you can see how to create developer account for `facebook,line,twitter,google,github` there

