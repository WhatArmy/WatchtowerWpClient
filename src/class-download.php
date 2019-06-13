<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-12
 * Time: 23:57
 */

namespace WhatArmy\Watchtower;


class Download
{

    /**
     * Download constructor.
     */
    public function __construct()
    {
//todo: implement download endpoint
    }

    public function serveFile($filename)
    {
        define('WP_MEMORY_LIMIT', '512M');
        $file = WHT_BACKUP_DIR.'/'.$filename;
        $mime = mime_content_type($file);
        $this->headers($file, $mime, filesize($file), $filename);
        $chunkSize = 1024 * 8;
        $handle = fopen($file, 'rb');
        while (!feof($handle)) {
            $buffer = fread($handle, $chunkSize);
            echo $buffer;
            if (strpos($filename, 'sql.gz') === false) {
                @ob_end_flush();
            }
            flush();
        }
        fclose($handle);
        return exit;
    }

    /**
     * @param $file
     * @param $type
     * @param  null  $name
     * @param $size
     */
    private function headers($file, $type, $size, $name = null)
    {
        if (empty($name)) {
            $name = basename($file);
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename="'.$name.'";');
        header('Content-Type: '.$type);
        header('Content-Length: '.$size);
    }
}