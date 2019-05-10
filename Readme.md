# Facebook Login using PHP

This is a small app written in PHP that allow user to login using Facebook

## Configuration

You have to fill your Database credentials and API keys in the config.php file as follow
```
define('DB_HOST', 'HOST_OF_YOUR_DB');
define('DB_USERNAME', 'USERNAME_OF_YOUR_DB);
define('DB_PASSWORD', 'PASSWORD_OF_YOUR_DB');
define('DB_NAME', 'NAME_OF_DATABASE');
define('DB_USER_TBL', 'users');

// Facebook API configuration
define('FB_APP_ID', '');
define('FB_APP_SECRET', '');
define('FB_REDIRECT_URL', 'url_at_the_root_of_your_app');
```

## Prerequisites

This app use the facebook-php-graph-SDK

## User Table

You have to run the query that is in the file createUserTable.sql