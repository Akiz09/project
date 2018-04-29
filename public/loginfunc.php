<?php

require_once '../kernel/bootstrap.php';

$auth = new \App\Auth();

if ($auth->login()) {
    $back = $_ENV['BASE_URL'];
    header('Location: ' . $back);
} else {
    back();
}

echoSessionError();
