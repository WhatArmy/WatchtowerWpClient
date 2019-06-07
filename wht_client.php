<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: WhatArmy Watchtower
 * Plugin URI: https://github.com/WhatArmy/WatchtowerWpClient
 * Description: The WhatArmy WordPress plugin allows us to monitor, backup, upgrade, and manage your site!
 * Author: WhatArmy
 * Version: 2.0 Beta
 * Author URI: https://whatarmy.com
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
use WhatArmy\Watchtower\Watchtower;


$autoloader = new Autoloader();
$autoloader->addNamespace('WhatArmy\Watchtower', __DIR__.'/src');
$autoloader->register();

new Watchtower();
