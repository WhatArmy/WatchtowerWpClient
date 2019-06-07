<?php
/**
 * Plugin Name: Whatarmy Watchtower
 * Plugin URI: https://github.com/c2pdev/WatchTower_Client
 * Description: The WhatArmy WordPress plugin allows us to monitor, backup, upgrade, and manage your site!
 * Author: Whatarmy
 * Version: 2.0 Beta
 * Author URI: http://whatarmy.com
 **/

define('WHT_MAIN', __FILE__);
define('MP_LARGE_DOWNLOADS', true);

require __DIR__.'/vendor/autoload.php';
/**
 * Include Plugin Class
 */
if (!function_exists('get_plugins')) {
    require_once ABSPATH.'wp-admin/includes/plugin.php';
}

use ClaudioSanches\WPAutoloader\Autoloader;
use WhatArmy\Watchtower\Self_Update;
use WhatArmy\Watchtower\Watchtower;


$autoloader = new Autoloader();
$autoloader->addNamespace('WhatArmy\Watchtower', __DIR__.'/src');
$autoloader->register();

new Watchtower();
new Self_Update();