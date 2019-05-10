<?php 

/*
* Log in and Retrieve user information
*
*/

if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location: ./');
    }
    


    // Getting user's profile info from Facebook
    try {
        $graphResponse = $fb->get('/me?fields=id,name,first_name,last_name,email,picture');
        $fbUser = $graphResponse->getGraphUser();
        
    } catch(FacebookResponseException $e) {

        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();

        // Redirect user back to app login page
        header("Location:logout.php");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    // Initialize User class
    $user = new User();

    // Getting user's profile data
    $fbUserData = array();
    $fbUserData['oauth_uid']  = !empty($fbUser['id'])?$fbUser['id']:'';
    $fbUserData['first_name'] = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
    $fbUserData['last_name']  = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
    $fbUserData['email']      = !empty($fbUser['email'])?$fbUser['email']:'';
    $fbUserData['gender']     = !empty($fbUser['gender'])?$fbUser['gender']:'';
    $fbUserData['picture']    = !empty($fbUser['picture']['url'])?$fbUser['picture']['url']:'';
    $fbUserData['link']       = !empty($fbUser['link'])?$fbUser['link']:'';


    // Insert or update user data to the database
    $fbUserData['oauth_provider'] = 'facebook';
    $userData = $user->checkUser($fbUserData);
    
    // Storing user data in the session
    $_SESSION['userData'] = $userData;
    

    // Get logout url
    $logoutURL = $helper->getLogoutUrl($accessToken, FB_REDIRECT_URL.'logout.php');
    
    // Render an error if user data has not been retreived successfully
    if(empty($userData)){
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}else{
    // Get login url
    $permissions = ['email']; // Optional permissions
    $loginURL = $helper->getLoginUrl(FB_REDIRECT_URL, $permissions);
    
    // Render Facebook login button
    $output = '<a type="button" href="'.htmlspecialchars($loginURL).'" class="btn btn-lg btn-fb"><i class="fa fa-facebook pr-1"></i>  Connect with Facebook</a>';
}