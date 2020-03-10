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
        $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
            WHT_REPO_URL,
            WHT_MAIN,
            'whatarmy-watchtower-plugin'
        );

        $use_beta = (get_option('watchtower')['use_beta'] == 1) ? "develop" : "master";

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