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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <style>

    </style>
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
                        <a href="index.html" class="headA">U r a t t e i</a>

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
    <?php if (!isset($_SESSION['login'])) : ?>
        <section class="conA">
            <div class="container">
            <div class="col-sm-6 alert alert-danger alert-dismissible fade show">
                <?php if (isset($_SESSION['msg']['err'])) : ?>
                    <?= $_SESSION['msg']['err'] ?>
                    <?php unset($_SESSION['msg']['err']); ?>
                <?php endif ?>
                </div>
                <h1>Urattei</h1>
                <p>Twitterでは書けないことを書く匿名会員制サイト</p>
                <a href="./login/entry.php">Let's start</a>
            </div>
        </section>
        <section class="conC">
            <div class="container">
                <div class="text">
                    <h2>匿名で規則のないサイトで遊びたくないですか？</h2>
                    <p>Uratteiでは、ルールは一切ありません。煮るなり焼くなり好きにしてください。
                    </p>
                    <a href="#">Let's Join
                        <span class="fa fa-chevron-right"></span>
                    </a>
                </div>
            </div>

        </section>
    <?php endif ?>
    <?php if (isset($_SESSION['login'])) : ?>
        <section class="conA">
            <div class="container">
                <img src="img/logo.svg" alt="">
                <h1>ログイン成功</h1>
                <a href="./login/logout.php">ログアウト</a>

            </div>
        </section>
    <?php endif ?>
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