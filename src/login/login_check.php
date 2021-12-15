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
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/5c9d39bbd7.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script>
        $(function() {
            $(".headC").click(function() {
                $(".headB").slideToggle();
            });
        });
    </script>
    <title>Urattei</title>
</head>

<body>
    <header>
        <header class="head-fixed">
            <div class="head-color">
                <div class="container">
                    <div class="container-small">
                        <a href="../index.php" class="headA">U r a t t e i</a>

                        <button type="button" class="headC">
                            <span class="fa fa-bars" title="MENU"></span>
                        </button>
                    </div>
                    <nav class="headB">
                        <ul>
                        <li><a href="./login/entry.php">Sign up</a></li>
                            <li><a href="./login/login.php">Login</a></li>
                            <li><a href="mailto:admin@teikokutyo.com">Contact</a></li>
                            <li><a href="./login/logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
    </header>
    <section class="conA">
    <?php

$name = $_POST['name'];
$pass = $_POST['pass'];
$pass = md5($pass);



try{
    $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT name FROM users WHERE name=? AND pass=?';
    $stmt= $dbh->prepare($sql);
    $data[]=$name;
    $data[]=$pass;
    $stmt->execute($data);

    $dbh=null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($name == '') {
        $_SESSION['msg']['err'] = '名前が入力されていません';
        header('Location: ./login.php');
    } 
    
    if ($pass == '') {
        $_SESSION['msg']['err'] = 'パスワードが入力されていません';
        header('Location: ./login.php');
    }
    
    if ($pass != $pass2) {
        $_SESSION['msg']['err'] = 'パスワードが一致しません。';
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