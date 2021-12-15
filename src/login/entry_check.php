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
$pass2 = $_POST['pass2'];


if ($name == '') {
    $_SESSION['msg']['err'] = '名前が入力されていません';
    header('Location: ./entry.php');
} else {
    print '<h1>';
    print $name;
    print 'さん<br>でよろしいですね</h1><br><br>';
}

if ($pass == '') {
    $_SESSION['msg']['err'] = 'パスワードが入力されていません';
}

if ($pass != $pass2) {
    $_SESSION['msg']['err'] = 'パスワードが一致しません。';
}

if ($name == '' || $pass == '' || $pass != $pass2) {
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    $pass = md5($pass);
    print '<form method="post" action="entry_done.php">';
    print '<input type="hidden" name="name" value="' . $name . '">';
    print '<input type="hidden" name="pass" value="' . $pass . '">';
    print '<br />';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK";>';
    print '</form>';
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