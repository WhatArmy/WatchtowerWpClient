<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 18:26
 */

namespace WhatArmy\Watchtower;

use \Puc_v4_Factory as Puc_v4_Factory;

class Self_Update
{

    /**
     * Self_Update constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/WhatArmy/WatchtowerWpClient',
            __FILE__,
            'whatarmy-watchtower-plugin'
        );

        $myUpdateChecker->setBranch('master');
    }
}