<?php


namespace WhatArmy\Watchtower\Mysql;


use Ifsnop\Mysqldump\Mysqldump;
use WhatArmy\Watchtower\Utils;

class Mysql_Backup
{
    private $db;

    /**
     * Backup constructor.
     */
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        add_action('add_to_dump', [$this, 'add_to_dump']);

    }

    public function prepare_jobs()
    {
        return $this->db_stats();
    }


    private function db_stats()
    {
        $tables_stats = $this->db->get_results("SELECT table_name 'name', table_rows 'rows', round(((data_length + index_length)/1024/1024),2) 'size_mb' 
                                      FROM information_schema.TABLES 
                                      WHERE table_schema = '" . DB_NAME . "';", ARRAY_N);
        $to_ret = new \stdClass();
        foreach ($tables_stats as $table) {
            $to_ret->{$table[0]} = [
                'count' => $table[1],
                'size' => $table[2],
            ];
        }
        $to_ret = json_decode(json_encode($to_ret), true);

        return array_map(function ($t, $k) {
            $t['name'] = $k;
            return $t;
        }, $to_ret, array_keys($to_ret));
    }

    private function dispatch_job($data)
    {
        as_schedule_single_action(time(), 'add_to_dump', $data, '');
    }

    private function should_separate($table_stat)
    {

    }

    private function dump_data($table, $range = array(), $dir)
    {
        $dumpSettings = array(
            'no-create-info' => true,
        );
        $dump = new Mysqldump("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, $dumpSettings);

        $dump->setTableWheres(array(
            $table => '',
        ));

        $dump->start($dir . '/dump_tmp.sql');

    }

    private function dump_structure($tables, $dir)
    {
        $dumpSettings = array(
            'no-data' => true,
        );
        $dump = new Mysqldump("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, $dumpSettings);


        $dump->start($dir . '/dump.sql');
    }

    public function run($callback_url)
    {
//        $dir = WHT_BACKUP_DIR . '/' . date('Y_m_d__H_i_s') . "_" . Utils::random_string();
        $dir = WHT_BACKUP_DIR . '/' . date('Y_m_d_');
        mkdir($dir, 0777, true);

        $stats = $this->prepare_jobs();
        $this->dump_structure($stats, $dir);
        foreach ($stats as $table) {
            $this->dump_data($table['name'], [], $dir);
//            $this->dispatch_job([
//                'job' => [
//                    "table" => $table['name'],
//                    "whole" => '',
//                    "dir" => $dir,
//                    "last" => false,
//                    "callbackHeadquarter" => $callback_url,
//                    // "queue" => $par . "/" . $jobTotal,
//                ]
//            ]);
        }
//        $this->dispatch_job([
//            'job' => [
//                "table" => null,
//                "whole" => null,
//                "dir" => $dir,
//                "last" => true,
//                "callbackHeadquarter" => $callback_url,
//                // "queue" => $par . "/" . $jobTotal,
//            ]
//        ]);

    }
}