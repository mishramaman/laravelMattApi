<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('images', function (Blueprint $table) {
    $table->integer('id');
    $table->string('path');
    $table->string('startTime');
    $table->string('endTime');
    $table->string('duration');
    $table->string('distance');
});
