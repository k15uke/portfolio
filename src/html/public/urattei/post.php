<?php


// 設定ファイルを読み込む。
require_once('../../App/config.php');

// クラスを読み込む。
use App\Util\Common;
use App\Model\Base;
use App\Model\postItems;
use App\Model\Users;

// サニタイズ

$post = Common::sanitaize($_POST);

//ワンタイムトークンのチェック
if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['error']  = '不正な処理が行われました。';
    header('Location: ./');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    try {

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $targetDir = __DIR__ . '/images/';
            $fileName = basename($_FILES["image_file"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            // 特定のファイル形式の許可
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if (in_array($fileType, $allowTypes)) {
                // サーバーにファイルをアップロード
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFilePath)) {
                    $data = array(
                        'user_id' => $post['user_id'],
                        'text' => $post['text'],
                        'name' => $post['name'],
                        'photo' => $fileName,
                    );
                    // データベースに画像ファイル名を挿入
                    $base = Base::getInstance();
                    $db = new postItems($base);
                    $db->registerPostItemWithPhoto($data);
                    $_SESSION['msg']['error'] = "画像付きで正常に投稿できました";
                    header('Location: ./ ');
                    exit;
                }
            }
        }

        if (isset($post['like'])) {
            $base = Base::getInstance();
            $db = new postItems($base);
            $id = $post['id'];

            $user_id = $_SESSION['user'];

            $db->like($id);
            header('Location: ./');
            exit;
        }

        if (isset($post['dislike'])) {
            $base = Base::getInstance();
            $db = new postItems($base);
            $id = $post['id'];
            $db->dislike($id);
            header('Location: ./');
            exit;
        }



        if (empty($post['text']) && !isset($post['likes']) && !isset($post['dislikes'])) {
            $_SESSION['msg']['error'] = '文章を入力してください。';
            header('Location: ./index.php');
            exit;
        } else {
            $data = array(
                'user_id' => $post['user_id'],
                'text' => $post['text'],
                'name' => $post['name'],
            );
            try {
                $base = Base::getInstance();
                $db = new postItems($base);
                $db->registerPostItem($data);
                $_SESSION['msg']['error'] = '投稿しました。';
                header('Location: ./index.php');
            } catch (Exception $e) {
                var_dump($e);
                header('Location: ./index.php');
                exit;
            }
        }
    } catch (Exception $e) {
        var_dump($e);
        exit;
    }

    ?>
</body>

</html>