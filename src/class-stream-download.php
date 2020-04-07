<?php


namespace WhatArmy\Watchtower;


class Stream_Download
{
    public function downloadFile($sourceFile, $fileName, $chunkSize = 1)
    {
        $file = $sourceFile;
        $bufferSize = $chunkSize * (1024 * 1024);

        // don't forget to send the data too
        ini_set('memory_limit', '-1');

        $fileInfo = $this->getFileInfo($sourceFile);

        $this->setHeaders($fileInfo['mimeType'], $fileName, $fileInfo['fileSize'], $fileInfo['offset'],
            $fileInfo['end']);

        $sourceFile = fopen($sourceFile, 'r');
        // seek to the requested offset, this is 0 if it's not a partial content request
        fseek($sourceFile, $fileInfo['offset']);

        while ($fileInfo['length'] >= $bufferSize) {
            print(fread($sourceFile, $bufferSize));
            $fileInfo['length'] -= $bufferSize;
        }

        if ($fileInfo['length']) {
            print(fread($sourceFile, $fileInfo['length']));
        }

        fclose($sourceFile);
        unlink($file);
        exit;
    }

    private function getFileInfo($sourceFile)
    {
        $fileSize = filesize($sourceFile);
        $offset = 0;
        $end = $fileSize - 1;
        $length = $fileSize;

        if (isset($_SERVER['HTTP_RANGE'])) {
            // if the HTTP_RANGE header is set we're dealing with partial content
            // find the requested range
            // this might be too simplistic, apparently the client can request
            // multiple ranges, which can become pretty complex, so ignore it for now
            preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
            $offset = intval($matches[1]);
            $end = $matches[2] || $matches[2] === '0' ? intval($matches[2]) : $fileSize - 1;
            $length = $end + 1 - $offset;
        }

        return [
            'length'   => $length,
            'offset'   => $offset,
            'end'      => $end,
            'fileSize' => $fileSize,
            'mimeType' => 'application/gzip',
        ];
    }

    private function setHeaders($mimeType, $fileName, $fileSize, $offset, $end)
    {
        if (isset($_SERVER['HTTP_RANGE'])) {
            // output the right headers for partial content
            header('HTTP/1.1 206 Partial Content');
            header("Content-Range: bytes $offset-$end/$fileSize");
        }

        // output the regular HTTP headers
        header('Content-Type: '.$mimeType);
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Accept-Ranges: bytes');
    }
}