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
     *
     */
    public static function clean_queue()
    {
        global $wpdb;
        $tasks = $wpdb->get_results('SELECT ID  FROM '.$wpdb->posts.' WHERE post_type = "scheduled-action" AND post_title = "add_to_zip"');

        foreach ($tasks as $task) {
            $task_id = $task->ID;
            $wpdb->delete($wpdb->prefix.'comments',
                ['comment_author' => 'ActionScheduler', 'comment_post_ID' => $task_id]);
            $wpdb->delete($wpdb->prefix.'postmeta',
                ['meta_key' => '_action_manager_schedule', 'post_id' => $task_id]);
            $wpdb->delete($wpdb->prefix.'posts',
                ['post_type' => 'scheduled-action', 'post_title' => 'add_to_zip', 'ID' => $task_id]);
        }
    }
}