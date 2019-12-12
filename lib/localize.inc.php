<?php

/**
 * Function to localize our site
 * @param Noir\Site $site The Site object
 */
return function(BT\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('trainesben68@gmail.com');
    $site->setRoot('/BT');
    $site->dbConfigure('mysql:host=localhost;dbname=bt_glass',
        'root',       // Database user
        '',     // Database password
        '');            // table prefix
};