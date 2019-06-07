<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 15:16
 */

namespace WhatArmy\Watchtower;


class Watchtower
{
    /**
     * Watchtower constructor.
     */
    public function __construct()
    {
        new Api();
        new Backup();
        new Self_Update();

        register_activation_hook(WHT_MAIN, array($this, 'install_hook'));
        register_activation_hook(WHT_MAIN, array($this, 'db_hook'));
    }

    public function install_hook()
    {
        $token = Token::generate();
        add_option( 'watchtower', array(
            'access_token' => $token,
            'file_backup'  => 0
        ) );
        flush_rewrite_rules();
    }

    public function db_hook()
    {

    }
}