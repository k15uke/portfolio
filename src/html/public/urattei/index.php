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
require_once('../../App/config.php');

// クラスを読み込む
use App\Util\Common;
use App\Model\Base;
use App\Model\postitems;

// セッションに保存されたPOSTデータを削除（念の為）
unset($_SESSION['post']);

// 保存されているエラーメッセージを削除（念の為）
unset($_SESSION['msg']['error']);

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
                <?php if (isset($_SESSION['msg']['err'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $_SESSION['msg']['err'] ?>
                        <?php unset($_SESSION['msg']['err']); ?>
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
                    <a class="nav-link" href="./user-info.php">プロフィール</a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login/logout.php" tabindex="-1">ログアウト</a>
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

try {
    // 通常の一覧表示か、検索結果かを保存するフラグ
    $isSearch = false;

    $base = Base::getInstance();
    $db = new postitems($base);

    // 検索キーワード
    $search = "";

    if (isset($_GET['search'])) {
        // GETに項目があるときは、検索
        $get = Common::sanitaize($_GET);
        $search = $get['search'];
        $isSearch = true;
        $items = $db->getPostedItemBySearch($search);
    } else {
        // GETに項目がないときは、作業項目を全件取得
        $items = $db->getPostedItemAll();
    }
} catch (Exception $e) {
    var_dump($e);
    exit;
}

// ワンタイムトークンの生成
$token = Common::generateToken();

}?>

    <body>

        <?php if (isset($_SESSION['login'])) : ?>
            <?php try {
                $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
                $dbh = new PDO($dsn, 'root', 'root');
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'select * from posts order by posted desc';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                var_dump($e);
                exit;
            }

            ?>
            <?php try {
                $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
                $dbh = new PDO($dsn, 'root', 'root');
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'select * from users';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                var_dump($e);
                exit;
            }

            ?>
            <section class="conX">
                <div class="container-1">
                    <?php if (isset($_SESSION['msg']['err'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $_SESSION['msg']['err'] ?>
                            <?php unset($_SESSION['msg']['err']); ?>
                        </div>
                    <?php endif ?>
                    <form method="post" action="./post.php">
                        <div class="container2">
                            <textarea name="text" style="width:500px; height:60px;background-color:black;color:white;"></textarea>
                            <br>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-dark" type="submit" name="photo">画像を添付</button>
                            <button class="btn btn-dark" type="submit" name="text">投稿</button>
                        </div>
                    </form>
                </div>
            </section>

            <?php foreach ($list as $v) : ?>
                <?php foreach ($lists as $k) : ?>
                    <section class="conX">
                        <div class="card bg-dark" style="min-width: 200px;">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <img src="./img/top.jpg" class="card-img-top" style="width:19vh; height:17vh">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $k['name'] ?>さん</h5>
                                        <p class="card-text"><?= $v['text'] ?></p>
                                        <p class="card-text"><small class="text-muted"><?= $v['posted'] ?></small></p>
                                        <form action="./post.php" method="post">
                                            <?php
                                            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
                                            $dbh = new PDO($dsn, 'root', 'root');
                                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql = 'select likes from posts where id=:id';
                                            $stmt = $dbh->prepare($sql);
                                            $stmt->bindValue(':id', $k['id'], PDO::PARAM_INT);
                                            $stmt->execute();
                                            $listx = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($listx as $f) {
                                                echo $f['likes'];
                                                var_dump($f);
                                            }
                                            ?>
                                            <button type="submit" name="likes" class="btn btn-danger">いいね</button>
                                            <?php
                                            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
                                            $dbh = new PDO($dsn, 'root', 'root');
                                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql = 'select dislikes from posts where id=:id';
                                            $stmt = $dbh->prepare($sql);
                                            $stmt->bindValue(':id', $k['id'], PDO::PARAM_INT);
                                            $stmt->execute();
                                            $listx = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($listx as $g) {
                                                echo $g['dislikes'];
                                                var_dump($g);
                                            }
                                            ?>
                                            <button type="submit" name="dislikes" class="btn btn-primary">よくないね</button>
                                            <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach ?>
            <?php endforeach ?>
            <section class="conA">

            </section>

        <?php endif ?>
        <footer>
            <div class="footC">
            </div>
        </footer>
    </body>

</html>