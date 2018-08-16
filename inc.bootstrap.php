<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/env.php';

header('Content-type: text/plain; charset=utf-8');

$db = db_sqlite::open(array('database' => __DIR__ . '/db/weather.sqlite3'));

db_generic_model::$_db = $db;

$db->ensureSchema(require 'inc.db-schema.php');
