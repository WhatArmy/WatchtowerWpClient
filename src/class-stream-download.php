<?php


namespace WhatArmy\Watchtower;


class Stream_Download
{

    /**
     * @param $file
     * @param  null  $name
     */
    protected function sendHeaders($file, $name = null)
    {
        $mime = mime_content_type($file);
        if ($name == null) {
            $name = basename($file);
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename="'.$name.'";');
        header('Content-Type: '.$mime);
        header('Content-Length: '.filesize($file));
    }

    /**
     * @param $file
     * @param $basename
     */
    public function downloadFile($file, $basename)
    {
        self::sendHeaders($file, $basename);
        $download_rate = 600 * 10;
        $handle = fopen($file, 'r');
        while (!feof($handle)) {
            $buffer = fread($handle, round($download_rate * 1024));
            echo $buffer;
            if (strpos($file, 'sql.gz') === false) {
                @ob_end_flush();
            }
            flush();
            sleep(1);
        }
        fclose($handle);
        unlink($file);
        exit;
    }
}