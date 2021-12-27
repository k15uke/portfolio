<?php


class Config
{
    
    /** データベース関連 **/

    /** ワンタイムトークン **/

    /** @var int openssl_random_pseudo_bytes()で使用する文字列の長さ */
    const RANDOM_PSEUDO_STRING_LENGTH = 32;


    /** メッセージ関連 **/

    /** @var string ワンタイムトークンが一致しないとき */
    const MSG_INVALID_PROCESS = '不正な処理が行われました。';

    /** @var string 例外がスローされたときのエラーメッセージ */
    const MSG_EXCEPTION = '申し訳ございません。エラーが発生しました。';

    /** @var string ユーザーが重複しているときのメッセージ */
    const MSG_USER_DUPLICATE = '既に同じメールアドレスが登録されています。';

    /** @var string ログイン失敗 */
    const MSG_USER_LOGIN_FAILURE = 'メールアドレス、または、パスワードに誤りがあります。';


    /** @var string ログイン試行回数オーバー */
    const MSG_USER_LOGIN_TRY_TIMES_OVER = 'ログインできません';

    /** @var string アップロード失敗 */
    const MSG_UPLOAD_FAILURE = 'アップロードに失敗しました。';
}

/**
 * 動作設定
 */

/** @var string データベース接続文字列 */
define('DSN', 'mysql:dbname=urattei;host=localhost;charset=utf8mb4');

/** @var string データベース接続ユーザー名 */
define('DB_USER', 'root');

/** @var string データベース接続パスワード */
define('DB_PASS', 'root');

/** セッション自動スタート */
// 各ページでセッションをスタートする必要があるので、ここでスタートさせておく
session_start();
session_regenerate_id(true);

/** クラスの自動読み込み */
spl_autoload_register(function ($class) {
    // useで読み込んだクラス名が自動的に$classに代入されるようになっている。
    // __DIR__はPHPの組み込み定数で、config.phpがあるディレクトリ名（絶対パス）が格納されている。
    // sprintf()を使って、「/絶対パス/クラスファイル.php」という文字列を作成する。
    // 「クラス名 = ファイル名」にする必要があることに注意。
    $file = sprintf(__DIR__ . '/%s.php', $class);
    // 各クラスはAppから始まる名前空間をつけているため、「/App/App」とパスが重なってしまうので、
    // 「/App/App」を「/App」に変換する。
    $file = str_replace('/App/App', '/App', $file);
    // クラス名の区切り文字である\を/に変換する。
    $file = str_replace('\\', '/', $file);

    if (file_exists($file)) {
        // ファイルが存在したら読み込む。ファイルは1回しか読み込まれないので、require()を使う。
        require($file);
    } else {
        // ファイルが存在しなかったら、エラー表示する。
        echo 'File not found: ' . $file;
        exit;
    }
});

