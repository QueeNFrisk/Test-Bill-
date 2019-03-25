<?php

class auther {
  public function signin($email, $password){
    $db = new \PDO('mysql:dbname=Bill;host=192.168.50.36;charset=utf8mb4', 'Daniel', '');
    $auth = new \Delight\Auth\Auth($db);
    try {
    $auth->login($email, $password);
        header('Location: '.$_SERVER['HTTP_HOST'] . '/profile.php?=' . $userId);
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
    $db = new \PDO('mysql:dbname=Bill;host=192.168.50.36;charset=utf8mb4', 'Daniel', '');
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
    $db = new \PDO('mysql:dbname=Bill;host=192.168.50.36;charset=utf8mb4', 'Daniel', '');
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


  public function __load() {
    $ct = $this->signin('daniel4581@protonmail.com', 'ickasdkck');
    if($ct==2 ){
      echo "$('.basic.test.modal').modal('setting', 'closable', true).modal('show');";
    }
  }
}
$a = new auther();
$a->__load();
//$a->signin('soulfantasy_kilua@live.com', 'ickkck');
//$a->emailValidation('emKqfh5448Rx_SQh','3OVfKiq_DyvENrc1');

















//
