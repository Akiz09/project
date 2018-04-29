<?php

define('ROOT_DIR', dirname(__DIR__));
define('ADMIN', 1);
define('MODERATOR', 2);
define('USER', 3);

function echoSessionError($key = null)
{
    if (isset($_SESSION['errors'])) {
        if ($key !== null) {
            if (isset($_SESSION['errors'][$key])) {
                echo $_SESSION['errors'][$key];
            }
        } else {
            foreach ($_SESSION['errors'] as $key => $value) {
                echo $key . ' => ' . $value;
            }
        }
    }
}

/**
 * Кодирует абсолютную url строку
 * @param  string $url
 * @param  array  $params
 * @return string
 */
function url($url = null, array $params = [])
{
    return $_ENV['BASE_URL'] . $url . (!empty($params) ? '?' . http_build_query($params) : '');
}

function back()
{
    $back = isset($_REQUEST['back']) ?
        $_REQUEST['back']
        : isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url();
    header('Location: ' . $back);
}
