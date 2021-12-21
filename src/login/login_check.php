<?php
session_start();
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urattei</title>
</head>

<body>

    <?php

$email = $_POST['email'];
$pass = $_POST['pass'];
$pass = md5($pass);

try{
    $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT name FROM users WHERE email=? AND pass=?';
    $stmt= $dbh->prepare($sql);
    $data[]=$email;
    $data[]=$pass;
    $stmt->execute($data);

    $dbh=null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($email == '') {
        $_SESSION['msg']['err'] = 'メールアドレスが入力されていません';
        header('Location: ./login.php');
    } 
    
    if ($pass == '') {
        $_SESSION['msg']['err'] = 'パスワードが入力されていません';
        header('Location: ./login.php');
    }
    
    if ($pass != $pass2) {
        $_SESSION['msg']['err'] = '名前かパスワードが間違っています。';
        header('Location: ./login.php');
    }
    
    if($rec==false){
        $_SESSION['msg']['err'] = '名前かパスワードが間違っています。';
        header('Location: ./login.php');
    }else{
        session_start();
        $_SESSION['login']=1;
        $_SESSION['name']=$rec['name'];
        header('Location: ../index.php');
        exit();
    }

    }catch (Exception $e){
        var_dump($e);
        exit;
    }

    

?>
    </section>


    <section class="conD">
    </section>
    <footer>
        <div class="footC">
            &copy 底剋山商会. All rights reserved.
        </div>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</html>