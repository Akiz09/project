<?php

namespace App;

require_once '../kernel/bootstrap.php';
$auth = new Auth();
$user = $auth->user();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    if ($user) {
        $username = $user['username'];
    ?>
    <h1>Welcome to !osu <?=$username?></h1>
    <a href="logout.php">logout</a>
    <?php
  } else {
    ?>
    <h1>Register NOW</h1>
    <a href="login.php">Login</a>
    <a href="registr.php">Registr</a>
    <?php
    }
    ?>
  </body>
</html>
