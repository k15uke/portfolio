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
    <link rel="stylesheet" href="./skin.css">
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
    <?php if (!isset($_SESSION['login'])) : ?>
        <section class="conA">
            <div class="container">
                <?php if (isset($_SESSION['msg']['err'])) : ?>
                    <div class="col-sm-6 alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['msg']['err'] ?>
                        <?php unset($_SESSION['msg']['err']); ?>
                    </div>
                <?php endif ?>

                <h1>Urattei</h1>
                <p>Twitterでは書けないことを書く匿名会員制サイト</p>
                <a href="./login/entry.php">Let's start</a>
                <br>
                <a href="./login/entry.php">ログイン</a>

            </div>
        </section>
        <section class="conB">
            <div class="container">
                <div class="text">
                    <h2>匿名で規則のないサイトで遊びたくないですか？</h2>
                    <p>Uratteiでは、ルールは一切ありません。煮るなり焼くなり好きにしてください。
                    </p>
                    <a href="#">Let's Join</a>
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


</html>