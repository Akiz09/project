<?php
require_once '../kernel/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="" action="loginfunc.php" method="post">
        <label for="username">Username</label>
        <input id="username" type="text" name="username">
        <?=echoSessionError('username')?>
        <label for="password">Password</label>
        <input id="password" type="text" name="password">
        <?=echoSessionError('password')?>
        <input type="submit" name="" >
    </form>
  </body>
</html>
