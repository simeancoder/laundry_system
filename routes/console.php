<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('db:create', function () {
    $database = config('database.connections.mysql.database');
    $host = config('database.connections.mysql.host');
    $port = config('database.connections.mysql.port');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');

    try {
        $pdo = new PDO("mysql:host={$host};port={$port}", $username, $password);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $this->info("Database '{$database}' created successfully or already exists.");
    } catch (\Exception $e) {
        $this->error("Failed to create database: " . $e->getMessage());
    }
})->purpose('Create database if it does not exist');
