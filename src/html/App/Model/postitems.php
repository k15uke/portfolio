<?php

namespace App\Model;

use Exception;

/**
 * 作業項目モデルクラスです。
 */
class postItems extends Base
{
    /** @var \PDO $pdo PDOクラスインスタンス */
    private $pdo;

    /**
     * コンストラクタです。
     *
     * @param \PDO $pdo \PDOクラスインスタンス
     */
    public function __construct($pdo)
    {
        // 引数に指定されたPDOクラスのインスタンスをプロパティに代入します。
        // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
        $this->pdo = $pdo;
    }

    /**
     * 作業項目を全件取得します。（削除済みの作業項目は含みません）
     *
     * @return array 作業項目の配列
     */
    public function getPostedItemAll()
    {
        $sql = '';
        $sql .= 'select ';
        $sql .= 'posts.id,';
        $sql .= 'posts.user_id,';
        $sql .= 'posts.name,';
        $sql .= 'posts.likes,';
        $sql .= 'posts.dislikes,';
        $sql .= 'posts.posted,';
        $sql .= 'posts.photo,';
        $sql .= 'posts.text,';
        $sql .= 'posts.reply ';
        $sql .= 'from urattei.posts ';
        $sql .= 'inner join users on posts.user_id = users.user_id ';
        $sql .= 'where posts.is_deleted=0 ';

        // 論理削除されている作業項目は表示対象外
        $sql .= 'order by posted desc ';   // 期限日の順番に並べる

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $ret = $stmt->fetchAll();

        return $ret;
    }

    /**
     * 作業項目を検索条件で抽出して取得します。（削除済みの作業項目は含みません）
     *
     * @param mixed $search 検索キーワード
     * @return array 作業項目の配列
     */
    public function getPostedItemBySearch($search)
    {
        $sql = '';
        $sql .= 'select ';
        $sql .= 'posts.id,';
        $sql .= 'posts.user_id,';
        $sql .= 'posts.name,';
        $sql .= 'posts.likes,';
        $sql .= 'posts.dislikes,';
        $sql .= 'posts.posted,';
        $sql .= 'posts.photo,';
        $sql .= 'posts.text ';
        $sql .= 'from urattei.posts ';
        $sql .= 'inner join users on posts.user_id = users.user_id ';
        // 論理削除されている作業項目は表示対象外
        $sql .= "and (";
        $sql .= "posts.text like :text";
        $sql .= ") ";
        $sql .= 'order by posted desc';   // 期限日の順番に並べる

        // bindParam()の第2引数には値を直接入れることができないので
        // 下記のようにして、検索ワードを変数に入れる。
        $likeWord = "%$search%";

        $stmt = $this->pdo->prepare($sql);
        // $stmt->bindParam(':id', $likeWord, \PDO::PARAM_INT);
        $stmt->bindParam(':text', $likeWord, \PDO::PARAM_STR);
        //$stmt->bindParam(':text', $search, \PDO::PARAM_STR);
        $stmt->execute();
        $ret = $stmt->fetchAll();

        return $ret;
    }

    /**
     * 指定IDの作業項目を1件取得します。（削除済みの作業項目は含みません）
     * @param int $id 作業項目のID番号
     * @return array 作業項目の配列
     */
    public function getPostedItemById($id)
    {
        // $idが数字でなかったら、falseを返却する。
        if (!is_numeric($id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'p.id,';
        $sql .= 'p.user_id,';
        $sql .= 'u.id,';
        $sql .= 'p.text ';
        $sql .= 'from posts t ';
        $sql .= 'inner join users u on t.user_id=u.id ';
        $sql .= 'where t.id=:id ';
        $sql .= 'and t.is_deleted=0';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetch();

        return $ret;
    }

    /**
     * 作業項目を1件登録します。
     *
     * @param array $data 作業項目の連想配列
     * @return bool 成功した場合:TRUE、失敗した場合:FALSE
     */
    public function registerPostItem($data)
    {
        // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。


        $sql = '';
        $sql .= 'insert into posts (';
        $sql .= 'user_id,';
        $sql .= 'text,';
        $sql .= 'name';
        $sql .= ') values (';
        $sql .= ':user_id,';
        $sql .= ':text,';
        $sql .= ':name';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':text', $data['text'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);

        $ret = $stmt->execute();

        return $ret;
    }

    public function registerPostItemWithPhoto($data)
    {
        // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。

        $sql = '';
        $sql .= 'insert into posts (';
        $sql .= 'user_id,';
        $sql .= 'text,';
        $sql .= 'name,';
        $sql .= 'photo';
        $sql .= ') values (';
        $sql .= ':user_id,';
        $sql .= ':text,';
        $sql .= ':name,';
        $sql .= ':photo';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':text', $data['text'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':photo', $data['photo'], \PDO::PARAM_STR);


        $ret = $stmt->execute();

        return $ret;
    }


    /**
     * 指定IDの1件の作業項目を更新ます。
     *
     * @param array $data 更新する作業項目の連想配列
     * @return bool 成功した場合:TRUE、失敗した場合:FALSE
     */
    public function updatePostedById($data)
    {
        // $data['id']が存在しなかったら、falseを返却
        if (!isset($data['id'])) {
            return false;
        }

        // $data['id']が数字でなかったら、falseを返却する。
        if (!is_numeric($data['id'])) {
            return false;
        }

        // $data['id']が0以下はありえないので、falseを返却
        if ($data['id'] <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'update posts set ';
        $sql .= 'user_id=:user_id,';
        $sql .= 'text=:text,';
        $sql .= 'edit_date=:edit_date ';
        $sql .= 'where id=:id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':text', $data['text'], \PDO::PARAM_STR);
        $stmt->bindParam(':edit_date', $data['edit_date'], \PDO::PARAM_STR);

        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }

    /**
     * 指定IDの1件の作業項目を完了にします。
     *
     * @param int $id 作業項目ID
     * @param string $date 完了日（NULLの場合は今日の日付）
     * @return bool 成功した場合:TRUE、失敗した場合:FALSE
     */
    public function makeTodoItemComplete($id, $date = null)
    {
        // $idが数字でなかったら、falseを返却する。
        if (!is_numeric($id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($id <= 0) {
            return false;
        }

        // $dateがnullだったら、今日の日付を設定する。
        // date()については、
        // https://www.php.net/manual/ja/function.date.php
        // を参照
        if (is_null($date)) {
            $date = date('Y-m-d');
        }

        $sql = '';
        $sql .= 'update todo_items set ';
        $sql .= 'finished_date=:finished_date ';
        $sql .= 'where id=:id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':finished_date', $date, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }

    /**
     * 指定IDの1件の作業項目を論理削除します。
     *
     * @param int $id 作業項目ID
     * @return bool 成功した場合:TRUE、失敗した場合:FALSE
     */
    public function deletePostedById($id)
    {
        // $idが数字でなかったら、falseを返却する。
        if (!is_numeric($id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'update posts set ';
        $sql .= 'is_deleted=1 ';
        $sql .= 'where id=:id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }

    public function deletePostedById2(int $id, int $user_id)
    {
        // $idが数字でなかったら、falseを返却する。
        if (!is_numeric($id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($id <= 0) {
            return false;
        }

        try {

            $sql = '';
            $sql .= 'select p.user_id,';
            $sql .= 'p.id,';
            $sql .= 'u.user_id ';
            $sql .= 'from posts p ';
            $sql .= 'inner join users u ';
            $sql .= 'on p.user_id = u.user_id ';
            $sql .= 'where p.id=:id and u.user_id=:user_id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);

            $stmt->execute();
            $ret2 = $stmt->fetch();

            if ($ret2['user_id'] = $_SESSION['user']['user_id']) {
                $sql = '';
                $sql .= 'update posts set ';
                $sql .= 'is_deleted=1 ';
                $sql .= 'where id=:id';

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

                $ret = $stmt->execute();
            } else {
                $_SESSION['msg']['error'] = 'あなたの投稿ではないので、削除できませんでした';
                header('Location: ./');
                exit();
            }

            $_SESSION['msg']['error'] = '削除しました';
            header('Location: ./index.php');
            exit;
        } catch (Exception $e) {
            var_dump($e);
            exit;
            $_SESSION['msg']['error'] = '削除できませんでした';
        }
    }

    public function like(int $id)
    {
        try {
            $sql = '';
            $sql .= 'select likes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret = $stmt->fetch();
            $likes = $ret['likes'];
            if ($likes == 0) {
                $likes++;
            } else {
                $_SESSION['msg']['error'] = '既にいいねしています。';
                header('Location: ./index.php');
                exit;
            }

            $sql = '';
            $sql .= 'update posts set ';
            $sql .= 'likes=:likes ';
            $sql .= 'where id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':likes', $likes, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $ret = $stmt->execute();

            $_SESSION['msg']['error'] = 'いいねしました';
            header('Location: ./index.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['msg']['error'] = 'いいねできませんでした';
            exit();
        }
    }

    public function like2(int $id, int $user_id)
    {
        try {


            $sql = '';
            $sql .= 'select likes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret = $stmt->fetch();
            $likes = $ret['likes'];


            $sql = '';
            $sql .= 'select p.user_id,';
            $sql .= 'p.likes,';
            $sql .= 'l.user_id ';
            $sql .= 'from posts p ';
            $sql .= 'inner join users u ';
            $sql .= 'on p.user_id = u.user_id ';
            $sql .= 'inner join likedislike l ';
            $sql .= 'on p.user_id = l.user_id ';
            $sql .= 'where p.id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret2 = $stmt->fetch();

            // var_dump($ret2['user_id']);
            //var_dump($_SESSION['user']['user_id']);
            //var_dump($ret2['likes']);
            // exit;

            if ($ret2['user_id'] == $_SESSION['user']['user_id'] && $ret2['likes'] == 0) {
                $likes++;
            } else {
                $likes--;
            }

            $sql = '';
            $sql .= 'update posts set ';
            $sql .= 'likes=:likes ';
            $sql .= 'where id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':likes', $likes, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $ret = $stmt->execute();

            $sql = '';
            $sql .= 'insert into likedislike (';
            $sql .= 'post_id,';
            $sql .= 'user_id,';
            $sql .= 'likes';
            $sql .= ') values (';
            $sql .= ':post_id,';
            $sql .= ':user_id,';
            $sql .= ':likes';
            $sql .= ')';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $stmt->bindParam(':likes', $likes, \PDO::PARAM_STR);

            $ret = $stmt->execute();

            $_SESSION['msg']['error'] = 'いいねしました';
            header('Location: ./index.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['msg']['error'] = 'いいねできませんでした';
            exit();
        }
    }


    public function dislike(int $id)
    {
        try {
            $sql = '';
            $sql .= 'select dislikes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret = $stmt->fetch();
            $dislikes = $ret['dislikes'];
            if ($dislikes == 0) {
                $dislikes++;
            } else {
                $dislikes--;
            }

            $sql = '';
            $sql .= 'update posts set ';
            $sql .= 'dislikes=:dislikes ';
            $sql .= 'where id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':dislikes', $dislikes, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $ret = $stmt->execute();

            $_SESSION['msg']['error'] = 'よくないねしました';
            header('Location: ./index.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['msg']['error'] = 'よくないねできませんでした';
            exit();
        }
    }

    public function dislike2(int $id, int $user_id)
    {
        try {


            $sql = '';
            $sql .= 'select dislikes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret = $stmt->fetch();
            $dislikes = $ret['dislikes'];


            $sql = '';
            $sql .= 'select p.user_id,';
            $sql .= 'p.dislikes,';
            $sql .= 'l.user_id ';
            $sql .= 'from posts p ';
            $sql .= 'inner join users u ';
            $sql .= 'on p.user_id = u.user_id ';
            $sql .= 'inner join likedislike l ';
            $sql .= 'on p.user_id = l.user_id ';
            $sql .= 'where p.id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $ret2 = $stmt->fetch();

            // var_dump($ret2['user_id']);
            //var_dump($_SESSION['user']['user_id']);
            //var_dump($ret2['likes']);
            // exit;

            if ($ret2['user_id'] == $_SESSION['user']['user_id'] && $ret2['dislikes'] == 0) {
                $dislikes++;
            } else {
                $dislikes--;
            }

            $sql = '';
            $sql .= 'update posts set ';
            $sql .= 'dislikes=:dislikes ';
            $sql .= 'where id=:id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':likes', $dislikes, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            $ret = $stmt->execute();

            $sql = '';
            $sql .= 'insert into likedislike (';
            $sql .= 'post_id,';
            $sql .= 'user_id,';
            $sql .= 'dislikes';
            $sql .= ') values (';
            $sql .= ':post_id,';
            $sql .= ':user_id,';
            $sql .= ':dislikes';
            $sql .= ')';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':post_id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $stmt->bindParam(':dislikes', $likes, \PDO::PARAM_STR);

            $ret = $stmt->execute();

            $_SESSION['msg']['error'] = 'よくないねしました';
            header('Location: ./index.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['msg']['error'] = 'よくないねできませんでした';
            exit();
        }
    }




    public function getUserInfo(int $user_id)
    {
        // $idが数字でなかったら、falseを返却する。
        if (!is_numeric($user_id)) {
            return false;
        }

        // $idが0以下はありえないので、falseを返却
        if ($user_id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'user_id,';
        $sql .= 'name,';
        $sql .= 'email,';
        $sql .= 'create_date ';
        $sql .= 'from users ';
        $sql .= 'where user_id=:user_id ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetch();

        return $ret;
    }


    public function reply($data)
    {
            try {


                $sql = '';
                $sql .= 'insert into posts (';
                $sql .= 'user_id,';
                $sql .= 'text,';
                $sql .= 'name';
                $sql .= ') values (';
                $sql .= ':user_id,';
                $sql .= ':text,';
                $sql .= ':name';
                $sql .= ')';
        
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
                $stmt->bindParam(':text', $data['text'], \PDO::PARAM_STR);
                $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        
                $ret = $stmt->execute();

                $sql = '';
                $sql .= 'select reply from posts ';
                $sql .= 'where id=:id';
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
                $stmt->execute();
                $ret = $stmt->fetch();
                $reply = $ret['reply'];
                $reply++;

                $sql = '';
                $sql .= 'update posts set ';
                $sql .= 'reply=:reply ';
                $sql .= 'where id=:id';
    
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':reply', $reply, \PDO::PARAM_INT);
                $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
    
                $ret = $stmt->execute();
    
                $_SESSION['msg']['error'] = '返信しました。';
                unset($_SESSION['reply']);
                header('Location: ./index.php');
                exit;
            } catch (Exception $e) {
                var_dump($e);
                $_SESSION['msg']['error'] = '返信できませんでした。';
                exit();
            }
        }
}
