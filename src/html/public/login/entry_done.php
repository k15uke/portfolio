<?php

require_once('../../App/Model/users.php');
require_once('../../App/Model/Base.php');
require_once('../../App/config.php');
require_once('../../App/Util/Common.php');
require_once('../../App/Util/SaftyUtil.php');

// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['erorr']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./user_add.php');
    exit;
}

$_SESSION['login'] = $_POST;

try{
    $db = new Users();

    $ret = $db->addUser($_POST['email'],$_POST['password'],$_POST['name']);
    if(!$ret){
        $_SESSION['msg']['error'] = 'すでに同じメールアドレスが登録されています。';
        header('Location: ./entry.php');
        exit;
    }

    unset($_SESSION['login']);
    unset($_SESSION['error']);
    $_SESSION['msg']['error'] = "登録が完了しました。";
    header('Location: ./login.php');
    exit;
}catch (Exception $e){
    $_SESSION['msg']['error'] = $e ;
    header('Location: ./entry.php');
    exit;
}