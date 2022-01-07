<?php

require_once('../../App/Model/Base.php');
require_once('../../App/Model/Users.php');
require_once('../../App/config.php');
require_once('../../App/Util/Common.php');
require_once('../../App/Util/SaftyUtil.php');

use App\Util\Common;

$token = Common::generateToken();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/skin.css">
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
                            <a class="nav-link active" aria-current="page" href="../login/login.php">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../login/entry.php">会員登録</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    <section class="conA">
        <div class="container">
            <?php if (!empty($_SESSION['msg']['error'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['msg']['error'] ?>
                    <?php unset($_SESSION['msg']['error']); ?>
                </div>
            <?php endif ?>
            <h1>ログイン</h1>
            <form method="post" action="../login/login_check.php">
                <input type="hidden" name="token" value="<?= $token ?>">
                <p class="leftx">メールアドレス</p>
                <input type="text" id="email" name="email" style="width:400px;" value="<?= isset($_SESSION['post']['user']) ? $_SESSION['post']['user'] : '' ?>">
                <p class="leftx">パスワード</p>
                <input type="password" id="password" name="password" style="width:400px;">
                <br><br>
                <button type="button" onclick="location.href='../urattei/index.php'" class="btn btn-dark">戻る</button>
                <button type="submit" class="btn btn-dark">ログイン</button>

            </form>
        </div>
    </section>



    </section>

    <section class="conD">
    </section>
    <footer>
        <div class="footC">
        </div>
    </footer>
</body>


</html>