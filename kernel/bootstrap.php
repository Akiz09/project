<?php

namespace Kernel;

session_start();

require_once 'declarations.php';
require_once '../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$debug = getenv('DEBUG') === 'true' ? true : false;

ini_set('display_errors', $debug);
ini_set('display_startup_errors', $debug);
ini_set('html_errors', $debug);
ini_set('error_reporting', E_ALL | E_NOTICE | E_STRICT | E_DEPRECATED);
ini_set('docref_root', 'http://php.net/manual/en/');
ini_set('docref_ext', '.php');
