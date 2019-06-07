<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Plugin Name: WhatArmy Watchtower
 * Plugin URI: https://github.com/WhatArmy/WatchtowerWpClient
 * Description: The WhatArmy WordPress plugin allows us to monitor, backup, upgrade, and manage your site!
 * Author: WhatArmy
 * Version: 2.0 Beta
 * Author URI: https://whatarmy.com
 **/

define('WHT_DB_VERSION', '1.0');
define('WHT_REPO_URL', 'https://github.com/WhatArmy/WatchtowerWpClient');
define('__WHT_MAIN__', __FILE__);
define('MP_LARGE_DOWNLOADS', true);

require __DIR__.'/vendor/autoload.php';

use ClaudioSanches\WPAutoloader\Autoloader;
use WhatArmy\Watchtower\Watchtower;


$autoloader = new Autoloader();
$autoloader->addNamespace('WhatArmy\Watchtower', __DIR__.'/src');
$autoloader->register();

new Watchtower();
