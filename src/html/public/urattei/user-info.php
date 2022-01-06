<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\postItems;

// セッションに保存されたPOSTデータを削除（念の為）
unset($_SESSION['post']);

if (!empty($_SESSION['user'])) {
    // ログイン済みのとき
    $user = $_SESSION['user'];
}


if (isset($user)) {
    try {
        // 通常の一覧表示か、検索結果かを保存するフラグ
        $isSearch = false;

        $base = Base::getInstance();
        $db = new postItems($base);

        // 検索キーワード
        $search = "";

        if (isset($_GET['search'])) {
            // GETに項目があるときは、検索
            $get = Common::sanitaize($_GET);
            $search = $get['search'];
            $isSearch = true;
            $items = $db->getpostedItemBySearch($search);
        } else {
            // GETに項目がないときは、作業項目を全件取得
            $items = $db->getUserInfo($_SESSION['user']['user_id']);
        }
    } catch (Exception $e) {
        $_SESSION['msg']['error'] = $e;
    }

    // ワンタイムトークンの生成
    $token = Common::generateToken();
}
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

<?php

// 設定ファイルを読み込む。

if (empty($_SESSION['user'])) {      // 未ログインのとき    
?>

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
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <section class="conA">
            <div class="container">
                <?php if (isset($_SESSION['msg']['error'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['msg']['error'] ?>
                        <?php unset($_SESSION['msg']['error']); ?>
                    </div>
                <?php endif ?>
                <h1>Urattei</h1>
                <p>Twitterでは書けないことを書く匿名会員制サイト</p>
                <a href="../login/entry.php">Let's start</a>
                <br>
                <a href="../login/login.php">ログイン</a>

            </div>
        </section>
    <?php

} else {
    // ログイン済みのとき
    $user = $_SESSION['user']; ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">U r a t t e i</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">トップページ</a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./user-info.php">
                                <input type="hidden" value="<?= $token ?>">
                                <a class="nav-link" href="./user-info.php">プロフィール</a>
                            </form>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login/logout.php" tabindex="-1">ログアウト</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>

                </div>
            </div>
        </nav>
        <?php
        // ワンタイムトークンの生成
        $token = Common::generateToken();

        ?>

        <body>
            <section class="conX">
                <div class="container-1">
                    <?php if (isset($_SESSION['msg']['error'])) : ?>
                        <section class="conB">
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $_SESSION['msg']['error'] ?>
                                <?php unset($_SESSION['msg']['error']); ?>
                            </div>
                        </section>
                    <?php endif ?>
                  
                </div>
            </section>
            <section class="conX">>
            <div class="container2">
                    <div class="card bg-dark" style="min-width: 200px;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <img src="./images/0" class="card-img-top" style="width:100%; height:100%">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">User ID : <?= $items['user_id'] ?> <br> <?= $items['name'] ?>さん</h5>
                                    <p class="card-text">Email  : <?= $items['email'] ?></p>
                                    <p class="card-text"><small class="text-muted"><?= $items['create_date'] ?>　にアカウント作成</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </section>
    <?php } ?>
    <section class="conA">

    </section>
    <footer>
        <div class="footC">
        </div>
    </footer>
        </body>

</html>