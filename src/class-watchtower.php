<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 15:16
 */

namespace WhatArmy\Watchtower;


class Watchtower
{
    /**
     * Watchtower constructor.
     */
    public function __construct()
    {
        new Api();
        new Backup();
    }
}