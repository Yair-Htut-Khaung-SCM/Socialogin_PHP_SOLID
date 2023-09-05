<?php include 'layout/header.php';
      include '../Enum/ProviderEnum.php';

      
     $error = 'X'; 
     if(isset($_GET['error'])) {
        $error = $_GET['error'];
     }
      
?>
<link rel="stylesheet" href="../public/css/userlogin.css">
<body>
<nav class="navbar navbar-expand-lg bg-light d-flex justify-content-end">
    <a class="text-sm px-5 py-3 " href="<?php echo 'RegistrationUser.php' ?>">Register</a>
</nav>
<div class="row justify-content-center mt-5">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h1 class="card-title">Login</h1>
            </div>
            <div class="card-body">
                <?php  if($error != 'X'):  ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif ?>
                <form action="../datahandler/UserLoginHandler.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-grid">
                            <button class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
                <div class="seperator"><b>or</b></div>
                <p class="social-account">Sign in with your social media account</p>
                <div class="social-media">
                    <?php $providers = [
                                            ProviderEnum::TWITTER,
                                            ProviderEnum::FACEBOOK,
                                            ProviderEnum::LINE,
                                            ProviderEnum::GOOGLE,
                                            ProviderEnum::GITHUB,
                                        ];
                    ?>
                    <div class="social-media">
                        <?php foreach ($providers as $providereach): ?>
                            <a href="../authprovider/SocialAuthUrl.php?provider=<?php echo $providereach ?>" class="<?php echo $providereach; ?>">
                                <?php if ($providereach == ProviderEnum::LINE): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="line" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M311 196.8v81.3c0 2.1-1.6 3.7-3.7 3.7h-13c-1.3 0-2.4-.7-3-1.5l-37.3-50.3v48.2c0 2.1-1.6 3.7-3.7 3.7h-13c-2.1 0-3.7-1.6-3.7-3.7V196.9c0-2.1 1.6-3.7 3.7-3.7h12.9c1.1 0 2.4 .6 3 1.6l37.3 50.3V196.9c0-2.1 1.6-3.7 3.7-3.7h13c2.1-.1 3.8 1.6 3.8 3.5zm-93.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 2.1 1.6 3.7 3.7 3.7h13c2.1 0 3.7-1.6 3.7-3.7V196.8c0-1.9-1.6-3.7-3.7-3.7zm-31.4 68.1H150.3V196.8c0-2.1-1.6-3.7-3.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 1 .3 1.8 1 2.5c.7 .6 1.5 1 2.5 1h52.2c2.1 0 3.7-1.6 3.7-3.7v-13c0-1.9-1.6-3.7-3.5-3.7zm193.7-68.1H327.3c-1.9 0-3.7 1.6-3.7 3.7v81.3c0 1.9 1.6 3.7 3.7 3.7h52.2c2.1 0 3.7-1.6 3.7-3.7V265c0-2.1-1.6-3.7-3.7-3.7H344V247.7h35.5c2.1 0 3.7-1.6 3.7-3.7V230.9c0-2.1-1.6-3.7-3.7-3.7H344V213.5h35.5c2.1 0 3.7-1.6 3.7-3.7v-13c-.1-1.9-1.7-3.7-3.7-3.7zM512 93.4V419.4c-.1 51.2-42.1 92.7-93.4 92.6H92.6C41.4 511.9-.1 469.8 0 418.6V92.6C.1 41.4 42.2-.1 93.4 0H419.4c51.2 .1 92.7 42.1 92.6 93.4zM441.6 233.5c0-83.4-83.7-151.3-186.4-151.3s-186.4 67.9-186.4 151.3c0 74.7 66.3 137.4 155.9 149.3c21.8 4.7 19.3 12.7 14.4 42.1c-.8 4.7-3.8 18.4 16.1 10.1s107.3-63.2 146.5-108.2c27-29.7 39.9-59.8 39.9-93.1z"/></svg>
                                <?php else: ?>
                                    <i class="fa fa-brands fa-<?php echo strtolower($providereach); ?>"></i>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php include 'layout/footer.php' ?>