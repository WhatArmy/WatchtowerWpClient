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

    public static function cancel_queue_and_cleanup($filename)
    {

    }

    /**
     * @param null $group
     * @param string $hook
     */
    public static function clean_queue($group = null, $hook = 'add_to_zip')
    {
        global $wpdb;

        if ($group != null) {
            $gr = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'actionscheduler_groups WHERE slug =  "' . Utils::slugify($group) . '"');
            $actions = $wpdb->get_results('SELECT action_id,group_id  FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE hook = "' . $hook . '" AND group_id = "' . $gr->group_id . '"');
            $wpdb->delete($wpdb->prefix . 'actionscheduler_groups', ['group_id' => $gr->group_id]);

        } else {
            $actions = $wpdb->get_results('SELECT action_id,group_id  FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE hook = "' . $hook . '"');
        }
        foreach ($actions as $action) {
            $wpdb->delete($wpdb->prefix . 'actionscheduler_logs', ['action_id' => $action->action_id]);
            $wpdb->delete($wpdb->prefix . 'actionscheduler_actions', ['action_id' => $action->action_id]);
            $wpdb->delete($wpdb->prefix . 'actionscheduler_groups', ['group_id' => $action->group_id]);
        }
    }

    /**
     * @param $status
     * @param null $group
     * @return int
     */
    public static function status($status, $group = null)
    {
        global $wpdb;
        if ($group != null) {
            $gr = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'actionscheduler_groups WHERE slug =  "' . Utils::slugify($group) . '"');
            $results = $wpdb->get_results('SELECT action_id  FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE hook = "add_to_zip" AND status = "' . $status . '" AND group_id = "' . $gr->group_id . '"');

        } else {
            $results = $wpdb->get_results('SELECT action_id  FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE hook = "add_to_zip" AND status = "' . $status . '"');
        }

        return count($results);
    }
}