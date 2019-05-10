<?php
// Include configuration file
require_once 'config.php';

// Include User class
require_once 'User.class.php';

// Log in and Retrieve user information (Fill userdata or an output message/Login button)
require_once 'login.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Login with Facebook using PHP</title>
<meta charset="utf-8">

<!-- CDN of Bootstrap and Font Awesome CSS-->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- My CSS -->
<link href="css/index.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="row">
        <!-- Begin of User profile -->
        <div class="col-lg-4 col-lg-offset-4">

            <?php 
            // Check if the data were successfully retrieved
            if(!empty($userData)){  ?>

            <div class="card card-profile">
                <!-- Cover photo -->
                <div style="background-color: grey" class="card-header">
                </div>
                <!-- Profile picturee / User information -->
                <div class="card-body text-center">
                    <img src="<?php echo $userData['picture']; ?>" class="card-profile-img">
                    <h3 class="mb-3"><?php echo $userData['first_name'].' '.$userData['last_name'] ?></h3>
                    <p class="mb-4"></p>
                    <a href="<?php echo $logoutURL; ?>" class="btn btn-outline-dark btn-sm" style="margin: 5%;">
                        Logout
                     </a>
                </div>
            </div>
            <?php }else{  
                echo $output;
            } ?>
        </div>
        <!-- End of User profile -->

    </div>
</div>
</body>
<!-- CDN of bootstrap and Jquery JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>