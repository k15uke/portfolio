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
     //   $search = "";

        if (isset($_GET['search'])) {
            // GETに項目があるときは、検索
           $get = Common::sanitaize($_GET);
            $search = $get['search'];
            $isSearch = true;
            $items = $db->getpostedItemBySearch($search);
        }   else {
            // GETに項目がないときは、作業項目を全件取得
            $items = $db->getpostedItemAll();
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
    <link rel="stylesheet" href="../css/skin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
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
                    <form class="d-flex" id="search" method="get" action="index.php">
                        <input class="form-control me-2" name="search" type="text" placeholder="Search" aria-label="Search">
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
                    <form method="post" action="./post.php" enctype="multipart/form-data">
                        <div class="container2">
                            <textarea name="text" style="width:500px; height:60px;background-color:black;color:white;">
                        <?php if(isset($_SESSION['reply'])) : ?>
                            >><?= $_SESSION['reply'] ?>
                        <?php endif ?>
                        </textarea>
                            <br>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <input type="hidden" name="name" value="<?= $user['name'] ?>">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="file" name="image_file" value="image_file" id="image_file" class="form-control-file">
                            <button class="btn btn-dark" name="upload" type="submit">投稿</button>
                        </div>
                    </form>
                </div>
            </section>
            <section class="conB">
                <?php foreach ($items as $v) : ?>
                    <div class="card bg-dark" >
                        <div class="row g-1">
                            <div class="col-md-4">
                                <img src="./images/<?= $v['photo'] ?>" class="card-img-top" style="width:100%; height:100%">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                 <h5 class="card-title"><?= $v['id'] ?>.<?= $v['name'] ?>さん</h5>
                                    <p class="card-text"><?= $v['text'] ?></p>
                                    <p class="card-text"><small class="text-muted"><?= $v['posted'] ?></small></p>
                                    <form action="./post.php" method="post">
                                        <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                        <input type="hidden" name="token" value="<?= $token ?>">
                                        <?= $v['likes'] ?>
                                        <button name="like" id="like" class="btn btn-danger">いいね</button>
                                        <?= $v['dislikes'] ?>
                                        <button name="dislike" id="dislike" class="btn btn-primary">よくないね</button>
                                        <button name="delete" id="delete" class="btn btn-dark">削除</button>
                                        <?= $v['reply'] ?>
                                        <button name="reply" id="reply" class="btn btn-info">返信</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        <?php endforeach ?>
    <?php } ?>
    <section class="conA">

    </section>
    <footer>
        <div class="footC">
        </div>
    </footer>
        </body>

</html>