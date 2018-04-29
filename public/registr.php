<?php
require_once '../kernel/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registr</title>
  </head>
  <body>
      <form class="" action="regfunc.php" method="post">
          <label for="username">Username</label>
          <input id="username" type="text" name="username">
          <?=echoSessionError('username')?>
          <label for="password">Password</label>
          <input id="password" type="text" name="password">
          <?=echoSessionError('password')?>
          <label for="password_confirmation">Confirm your password</label>
          <input id="password_confirmation" type="text" name="password_confirmation">
          <label for="email">Email</label>
          <input id="email" type="text" name="email">
          <?=echoSessionError('email')?>
          <input type="submit">
      </form>
  </body>
</html>
