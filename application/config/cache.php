<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['cache_path'] = ''; // Default: application/cache/
$config['cache_query_string'] = FALSE;
$config['cache_driver'] = 'file'; // Change to 'redis', 'memcached', etc. if you use them

$config['memcached'] = array(
    'hostname' => '127.0.0.1',
    'port'     => 11211,
    'weight'   => 1
);
