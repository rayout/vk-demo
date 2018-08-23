<?php
require __DIR__ . '/../vendor/autoload.php';

use Phpmig\Adapter;
use Pimple\Container;
use Phpmig\Api\PhpmigApplication;

$output = new \Symfony\Component\Console\Output\NullOutput();

$database = config()->get('database');

$container = new Container();

$container['db'] = function () use ($database) {
    $dbh = new PDO("mysql:dbname={$database['database']};port={$database['port']};host={$database['host']}",$database['user'],$database['pass']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\PDO\Sql($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

$app = new PhpmigApplication($container, $output);

// run the migrations
$app->up();