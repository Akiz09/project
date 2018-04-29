<?php

namespace App;

use Kernel\DB;

class Auth
{
    private static $authFields = [
        'username',
        'password'
    ];

    private static $regFields = [
        'username',
        'password',
        'password_confirmation',
        'email'
    ];

    private $db;
    private $user;

    public function __construct()
    {
      if (isset($_SESSION['errors'])) {
          unset($_SESSION['errors']);
      }
      $this->db = DB::instance();
    }

    public function reg(): bool
    {
        if (!$this->checkIfFieldsExistsAndFilled(static::$regFields)) {
            return false;
        }

        $user = $this->userQuery($_REQUEST['username']);

        if ($user) {
            $username = $user['username'];
            $_SESSION['errors']['username'] = "User {$username} already exists";
            return false;
        }

        if ($_REQUEST['password'] != $_REQUEST['password_confirmation']) {
            $_SESSION['errors']['password'] = "Password and confirmation are not equal";
            return false;
        }

        $user = [
            'username' => $_REQUEST['username'],
            'password' => md5($_REQUEST['password']),
            'email' => $_REQUEST['email']
        ];

        $this->insert('users', $user);

        $user = $this->userQuery($user['username']);

        $this->user = $user;
        $_SESSION['id'] = $this->user['id'];
        return true;
    }

    public function login(): bool
    {
      if (!$this->checkIfFieldsExistsAndFilled(static::$authFields)) {
          return false;
      }

      $user = $this->userQuery($_REQUEST['username']);

      if (!$user) {
          return false;
      }

      if ($user['password'] !== md5($_REQUEST['password'])) {
          $_SESSION['error']['password'] = "Empty username or password";
          return false;
      }

      $this->user = $user;
      $_SESSION['id'] = $this->user['id'];
      return true;
    }

    private function checkIfFieldsExistsAndFilled($fields)
    {
        foreach ($fields as $value) {
            if (!isset($_REQUEST[$value])) {
                $_SESSION['errors'][$value] = "Missing {$value}";
                return false;
            }
        }

        foreach ($fields as $value) {
            if ($_REQUEST[$value] === '') {
                $_SESSION['errors'][$value] = "Empty {$value}";
                return false;
            }
        }
        return true;
    }


    public function user()
    {
        if (!is_array($this->user) && isset($_SESSION['id'])) {
            $sql = "SELECT * FROM users WHERE id = " . (int) $_SESSION['id'] . " LIMIT 1";
            $user = $this->db->query($sql);
            $this->user = $user ? $user->fetch_assoc() : false;
        }
        return $this->user;
    }

    private function userQuery($username)
    {
      $username = $this->wrapValue($username);
      $sql = "SELECT * FROM `users` WHERE `username` = {$username} LIMIT 1";
      $user = $this->db->query($sql);
      if (!is_object($user)) {
          $_SESSION['errors']['username'] = "User not found";
          return false;
      }

      return $user->fetch_assoc();
    }

    /**
     * Вставляет ассоциативный массив в таблицу
     * @param  string  $table  Название таблицы
     * @param  array   $item   Вставляемый массив
     * @return
     */
    public function insert($table, array $item)
    {
        $keys = [];
        $values = [];
        foreach ($item as $key => $value) {
            $keys[] = $this->wrapColumn($key);
            $values[] = $this->wrapValue($value);
        }
        $table = $this->wrapColumn($table);

        $sql = "INSERT INTO " . $table . " (" . implode(", ", $keys) .
            ") VALUES (". implode(", ", $values) . ")";

        return $this->db->query($sql);
    }

    /**
     * Экранирует спецсимволы sql и оборачивает строку в обратные кавычки
     * @param  string $column Строка
     * @return [type]        Экранированная строка
     */
    private function wrapColumn($column)
    {
        return '`' . $this->db->real_escape_string($column) . '`';
    }

    /**
     * Экранирует спецсимволы sql и оборачивает строку в одинарные кавычки
     * @param  string $value Строка
     * @return [type]        Экранированная строка
     */
    private function wrapValue($value)
    {
        if (is_int($value)) {
            return $value;
        }
        return "'" . $this->db->real_escape_string($value) . "'";
    }
}
