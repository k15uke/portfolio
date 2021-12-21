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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../skin.css">
    <title>Urattei</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">U r a t t e i</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <section class="conA">
        <div class="container">
            <?php if (isset($_SESSION['msg']['err'])) : ?>
                <div class="card-body">
                    <?= $_SESSION['msg']['err'] ?>
                    <?php unset($_SESSION['msg']['err']) ?>
                </div>
            <?php endif ?>
            <h1>入力確認</h1>
            <?php

            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];


            if ($name == '') {
                $_SESSION['msg']['err'] = '名前が入力されていません';
                header('Location: ./entry.php');
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
            ?>

                <form method="post" action="entry_done.php">
                    <input type="hidden" name="email" value="' . $email . '">
                    <input type="hidden" name="pass" value="' . $pass . '">
                    <input type="hidden" name="name" value="' . $name . '">
                    <br>
                    <h2>名前：<br>「<?= $name ?>」さん</h2>
                    <br>
                    <h2>メールアドレス：<br>「<?= $email ?>」</h2>
                    <br>
                    で間違いないですね？
                    <br>
                    <button type="button" onclick="history.back()" class="btn btn-dark">戻る</button>
                    <button type="submit" class="btn btn-dark">登録</button>
                </form>


            <?php } ?>
        </div>
    </section>



    </section>

    <section class="conD">
    </section>
    <footer>
        <div class="footC">
            &copy 底剋山商会. All rights reserved.
        </div>
    </footer>
</body>


</html>