<?php

require_once '../kernel/bootstrap.php';

$registration = new \App\Auth();

if ($registration->reg()) {
    $back = $_ENV['BASE_URL'];
    header('Location: ' . $back);
} else {
    back();
}

echoSessionError();
