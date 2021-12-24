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
    <title>Document</title>
</head>
<body>
<?php
    if(isset($_POST['likes'])){
        try{
            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
            $user = 'root';
            $password='root';
           
            $dbh = new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $_SESSION['likes'] +=1;

            $sql = 'update posts set likes=:likes where posts.id=:id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':likes', $_SESSION['likes'], PDO::PARAM_INT);
            $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            
           
            $_SESSION['msg']['err'] = 'いいねしました';
            header('Location: ./index.php');
            exit;

        }catch(Exception $e){
            $_SESSION['msg']['err'] = 'いいねできませんでした';
            exit();
        }
    }
    
    if(isset($_POST['dislikes'])){
        try{
            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
            $user = 'root';
            $password='root';
           
            $dbh = new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $_SESSION['dislikes'] +=1;

            $sql = 'update posts set dislikes=:dislikes where posts.id=:id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':dislikes', $_SESSION['dislikes'], PDO::PARAM_INT);
            $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['msg']['err'] = 'よくないねしました';
            header('Location: ./index.php');
            exit;

        }catch(Exception $e){
            $_SESSION['msg']['err'] = 'よくないねできませんでした';
            exit();
        }
    }

    if(isset($_POST['photo'])){
        $_SESSION['msg']['err'] = 'この機能は現在使えません';
        header('Location: ./index.php');
        exit;
    }

    if(!isset($_POST['text'])){
        $_SESSION['msg']['err'] = '文章を入力してください';
        header('Location: ./index.php');
        exit;
    }
    else {
        try{
            $email = $_POST['email'];
            $text = $_POST['text'];
            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
            $user = 'root';
            $password='root';
           
            $dbh = new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql = 'INSERT INTO posts(user_id,text) VALUES(?,?)';
            $stmt = $dbh->prepare($sql);
            $data[] = $email;
            $data[] = $text;
            $stmt->execute($data);
            
            $_SESSION['posts'] +=1;

            $_SESSION['msg']['err'] = '投稿しました';
            header('Location: ./index.php');
            exit;



        }catch(Exception $e){
            $_SESSION['msg']['err'] = '投稿できませんでした';
            var_dump($e);
            exit();
        }
    }

        ?>
</body>
</html>