<?php

class auther {
  public function signin($email, $password){
    $db = new \PDO('mysql:dbname=prestashop;host=127.0.0.1;charset=utf8mb4', 'root', '');
    $auth = new \Delight\Auth\Auth($db);
    try {
    $auth->login($email, $password);
        header('Location: executor/');
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        return 1;
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        return 2;
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        return 3;
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        return 4;
    }
  }

  public function signup($email, $password, $username){
    $db = new \PDO('mysql:dbname=prestashop;host=127.0.0.1;charset=utf8mb4', 'root', '');
    $auth = new \Delight\Auth\Auth($db);
    try {
    $userId = $auth->register($email, $password, $username, function ($selector, $token) {
        echo $url = 'http://'.$_SERVER['HTTP_HOST'].'/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
    });
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        return 5;
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        return 6;
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        return 7;
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        return 8;
    }
  }

  public function emailValidation($selector, $token){
    $db = new \PDO('mysql:dbname=prestashop;host=127.0.0.1;charset=utf8mb4', 'root', '');
    $auth = new \Delight\Auth\Auth($db);
    try {
      $auth->confirmEmail($selector, $token);
      header('Location: '.$_SERVER['HTTP_HOST'] . '/' . $userId . '/verified');
    }
    catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
      return 9;
    }
    catch (\Delight\Auth\TokenExpiredException $e) {
      return 10;
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
      return 11;
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
      return 12;
    }
  }
}
$a = new auther();
$x = $a->signin('daniel4581@protonmail.com', 'ickkck1415121316');
















//
