<?php

//require_once('../../App/Model/Users.php');
//require_once('../../App/Model/Base.php');
require_once('../../App/config.php');
//require_once('../../App/Util/Common.php');
require_once('../../App/Util/SaftyUtil.php');

use App\Model\Base;
use App\Model\Users;
use App\Util\Common;



// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['erorr']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./user_add.php');
    exit;
}

$_SESSION['login'] = $_POST;

try{
    $base = new Base();
    //$db = new Users($base->getInstance());

    $db = new Users($base->getInstance());

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