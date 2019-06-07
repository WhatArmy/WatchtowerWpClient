<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 17:31
 */

namespace WhatArmy\Watchtower;


class Core
{
    public $plugin_data;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $this->plugin_data = $this->plugin_data();
    }

    private function plugin_data()
    {
        $main_file = explode('/', plugin_basename(__WHT_MAIN__))[1];

        return get_plugin_data(plugin_dir_path(__WHT_MAIN__).$main_file);
    }

    public function test()
    {
        return [
            'version' => $this->plugin_data['Version'],
        ];
    }
}