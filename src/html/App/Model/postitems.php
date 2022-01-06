<?php

namespace App\Model;

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
    public function __construct($pdo) {
        // 引数に指定されたPDOクラスのインスタンスをプロパティに代入します。
        // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
        $this->pdo = $pdo;
    }

    /**
     * 作業項目を全件取得します。（削除済みの作業項目は含みません）
     *
     * @return array 作業項目の配列
     */
    public function getPostedItemAll() {
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
        $sql .= 'order by posted desc';   // 期限日の順番に並べる
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
    public function getPostedItemBySearch($search) {
        $sql = '';
        $sql .= 'select ';
        $sql .= 'p.id,';
        $sql .= 'p.user_id,';
        $sql .= 'p.text,';
        $sql .= 'p.likes,';
        $sql .= 'p.dislikes,';
        $sql .= 'p.posted,';
        $sql .= 'p.photo ';
        $sql .= 'from urattei p ';
        $sql .= 'inner join users u on p.user_id=u.id ';
        $sql .= 'where p.is_deleted=0 ';    // 論理削除されている作業項目は表示対象外
        $sql .= "and (";
        $sql .= "p.text like :text ";
        $sql .= "or u.id like :id ";
        $sql .= ") ";
        $sql .= 'order by p.expire_date asc';

        // bindParam()の第2引数には値を直接入れることができないので
        // 下記のようにして、検索ワードを変数に入れる。
        $likeWord = "%$search%";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $likeWord, \PDO::PARAM_INT);
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
    public function getPostedItemById($id) {
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
    public function registerPostItem($data) {
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

    public function registerPostItemWithPhoto($data) {
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
    public function updatePostedById($data) {
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
    public function makeTodoItemComplete($id, $date = null) {
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
    public function deletePostedById($id) {
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

    public function like(int $id){
        try{

            $sql = '';
            $sql .= 'select likes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute(); 
            $ret = $stmt->fetch();
            $likes = $ret['likes'];
            $likes++;

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

        }catch(Exception $e){
            $_SESSION['msg']['error'] = 'いいねできませんでした';
            exit();
        }
    }

    public function like2(int $id,int $user_id){


            $sql = '';
            $sql .= 'select * from posts ';
            $sql .= 'where id=:id  AND user_id = :user_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt->execute(); 
            $favorite = $stmt->fetch();

            return $favorite;
    }

    public function dislike2(int $id,int $user_id){
        
    }

    public function dislike(int $id){
        try{
            $sql = '';
            $sql .= 'select dislikes from posts ';
            $sql .= 'where id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute(); 
            $ret = $stmt->fetch();
            $dislikes = $ret['dislikes'];
            $dislikes++;

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

        }catch(Exception $e){
            $_SESSION['msg']['error'] = 'よくないねできませんでした';
            exit();
        }
    }

}
