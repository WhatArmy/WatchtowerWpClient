<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 18:30
 */

namespace WhatArmy\Watchtower;

/**
 * Class Schedule
 * @package WhatArmy\Watchtower
 */
class Schedule
{

    /**
     * @param null $group
     */
    public static function clean_queue($group = null)
    {
        global $wpdb;
        $actions = $wpdb->get_results('SELECT action_id  FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE hook = "add_to_zip"');

        foreach ($actions as $action) {
            $wpdb->delete($wpdb->prefix . 'actionscheduler_logs', ['action_id' => $action->action_id]);
            $wpdb->delete($wpdb->prefix . 'actionscheduler_actions', ['action_id' => $action->action_id]);
        }
    }
}