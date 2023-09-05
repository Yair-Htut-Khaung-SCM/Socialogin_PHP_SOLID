<?php 
    include 'layout/header.php';
    include '../Enum/ProviderEnum.php';
    include '../database/Connection.php';
    include '../database/GetUserInformation.php';

    //get token for url
    $token = $_GET['token'];

    //get userinformation
    $userInfo = GetUserInfromation::getUserInformation($token, $conn);

?>

<link rel="stylesheet" href="../public/css/userprofile.css">
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <!-- Your navigation content here -->
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
        <h1> Welcome, <?php echo $userInfo['username']; ?></h1>
        <a href="UserLogin.php" class="logout">Logout</a>
        </div>
        <div class="box">
            <div class="profile-circle">
                <?php if($userInfo['itsfromprovider'] == 'Provider'): ?>
                    <?php if ($userInfo['useravatar']): ?>
                        <img src="<?php echo $userInfo['useravatar']; ?>" alt="">
                    <?php else: ?>
                        <img src="https://i.pravatar.cc/100" alt="">
                    <?php endif; ?>
                <?php else: ?>
                    <img src="https://i.pravatar.cc/100" alt="">
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <h4><?php echo $userInfo['username']; ?></h4>
                
                <p> Member of the System with<span style="color:rgb(48, 71, 245);font-weight:bold;">
                        <?php echo $userInfo['provider_name']; ?></span>
                </p>

            </div>
            <?php if ($userInfo['useremail']): ?>
                    <p class="provider-mail"><?php echo $userInfo['useremail']; ?></p>
            <?php endif; ?>

            <div class="social-icon">
                <!-- Social icons here -->
            </div>

            <div class="btns">
                <button>Message</button>
                <button>Setting</button>
            </div>
        </div>
    </div>
</body>

</html>








