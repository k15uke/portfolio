<?php

namespace App\Model;

/**
 * ユーザーモデルクラスです。
 */
class Users extends Base
{
    /** @var \PDO $pdo PDOクラスインスタンス */
    private $pdo;

    /**
     * コンストラクタです。
     *
     * @param PDO $pdo PDOクラスインスタンス
     */
    public function __construct($pdo)
    {
        // 引数に指定されたPDOクラスのインスタンスをプロパティに代入します。
        // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
        $this->pdo = $pdo;

    }

    /**
     * すべてのユーザーの
     * 情報を取得します。
     *
     * @return array ユーザーのレコードの配列
     */

         /**
     * 新規ユーザー追加
     *
     * @param string $email
     * @param string $password
     * @param string $name
     * @return bool
     */
    public function getUserAll()
    {
        $sql = '';
        $sql .= 'select ';
        $sql .= 'id,';
        $sql .= 'name,';
        $sql .= 'email,';
        $sql .= 'pass,';
        $sql .= 'create_date,';
        $sql .= 'posts ';
        $sql .= 'from users ';
        $sql .= 'where is_deleted=0 ';  // 論理削除されているユーザーログイン対象外
        $sql .= 'order by id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * ユーザーを検索して、ユーザーの情報を取得します。
     *
     * @param string $user ユーザー名
     * @param string $password パスワード
     * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
     */

    public function getUser(string $email, string $password) : array
    {
        // $userが空だったら、空の配列を返却
        if (empty($email)) {
            return array();
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'id,';
        $sql .= 'name,';
        $sql .= 'email,';
        $sql .= 'pass,';
        $sql .= 'create_date ';
        $sql .= 'from users ';
        $sql .= 'where is_deleted=0 ';  // 論理削除されているユーザーはログイン対象外
        $sql .= 'and user=:user';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user', $user, \PDO::PARAM_STR);
        $stmt->execute();

        $rec = $stmt->fetch();

        // 検索結果が0件のときは、空の配列を返却
        if (!$rec) {
            return array();
        }

        // パスワードの妥当性チェックを行い、妥当性がないときは空の配列を返却
        // password_verify()については、
        // https://www.php.net/manual/ja/function.password-verify.php
        // 参照。
        if (!password_verify($password, $rec['pass'])) {
            return array();
        }

        // パスワードの情報は削除する→不要な情報は保持しない（セキュリティ対策）
        unset($rec['pass']);

        return $rec;
    }

    /**
     * 指定IDのユーザーが存在するかどうか調べます。
     *
     * @param int $id ユーザーID
     * @return boolean ユーザーが存在するとき：true、ユーザーが存在しないとき：false
     */
    public function isExistsUser($id)
    {
        // ＄idが数字でなかったら、falseを返却
        if (!is_numeric($id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'select count(id) as num from users where is_deleted=0';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $ret = $stmt->fetch(\PDO::FETCH_ASSOC);

        // レコードの数が0だったらfalseを返却
        if ($ret['num'] == 0) {
            return false;
        }

        return true;
    }


    /**
     * 新規ユーザー追加
     *
     * @param string $email
     * @param string $password
     * @param string $name
     * @return bool
     */

    public function addUser(string $email, string $password, string $name): bool
    {
        // 同じメールアドレスのユーザーがいないか調べる
        if (!empty($this->findUserByEmail($email))) {
            // 同じメールアドレスのユーザーが存在したらfalseを返却
            return false;
        }

        // パスワードをハッシュ化する
        $password = password_hash($password, PASSWORD_DEFAULT);

        // レコードをインサートする
        $sql = 'insert into users (email, password, name)';
        $sql .= ' values ';
        $sql .= '(:email, :password, :name)';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $password,\PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();

        // 処理が終了したらtrueを返却
        return true;
    }

    private function findUserByEmail(string $email):array{
        $sql = 'select * from users where email=:email';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email',$email,\PDO::PARAM_STR);
        $stmt->execute();
        $rec = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(empty($rec)){
            return[];
        }
        return $rec;
    }

}
