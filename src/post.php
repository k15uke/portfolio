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

        ?>
</body>
</html>