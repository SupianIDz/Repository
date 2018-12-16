<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

use Octopy\Support\Schema;
use Octopy\Database\Migration;
use Octopy\Database\Migration\BluePrint;

class Statistics extends Migration
{
    /**
     * @return void
     */
    public function create()
    {
        Schema::create('statistics', function (BluePrint $table) {
            $table->increment('id');
            $table->string('name', 100);
            $table->time('time');
            $table->date('date');
        });
    }

    /**
     * @return void
     */
    public function drop()
    {
        Schema::drop('statistics');
    }
}
