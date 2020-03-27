<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 18:26
 */

namespace WhatArmy\Watchtower;

/**
 * Class Self_Update
 * @package WhatArmy\Watchtower
 */
class Self_Update
{

    /**
     * Self_Update constructor.
     */
    public function __construct()
    {
        $use_beta = (get_option('watchtower')['use_beta'] == true) ? "develop" : "master";
        $info_path = "https://raw.githubusercontent.com/WhatArmy/WatchtowerWpClient/{$use_beta}/info.json";
        $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
            $info_path,
            WHT_MAIN,
            'whatarmy-watchtower-plugin'
        );

        $myUpdateChecker->setBranch($use_beta);
        $myUpdateChecker->addResultFilter(function ($info, $response = null) {
            $info->icons = array(
                '1x' => WHT_MAIN_URI . '/assets/images/logo1x.png',
                '2x' => WHT_MAIN_URI . '/assets/images/logo2x.png',
            );
            return $info;
        });
    }

}