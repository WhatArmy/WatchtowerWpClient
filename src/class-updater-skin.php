<?php


namespace WhatArmy\Watchtower;

if (!function_exists('\WP_Upgrader_Skin')) {
    require_once ABSPATH.'wp-admin/includes/class-wp-upgrader-skin.php';
}

class Updater_Skin extends \WP_Upgrader_Skin
{
    public $feedback = false;

    public function header()
    {
    }

    public function footer()
    {
    }

    public function before()
    {
    }

    public function after()
    {
    }

    public function feedback($feedback)
    {
        $this->feedback = $feedback;
    }
}