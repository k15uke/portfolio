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
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $dsn = 'mysql:dbname=urattei;host=localhost;charset=utf8';
            $user = 'root';
            $password='root';
           
            $dbh = new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql = 'INSERT INTO users(name,email,pass) VALUES(?,?,?)';
            $stmt = $dbh->prepare($sql);
            $data[] = $name;
            $data[] = $email;
            $data[] = $pass;
            $stmt->execute($data);
            
            $_SESSION['msg']['err'] = $name. 'さんを追加しました';
            header('Location: ./login.php');
            exit;

        }catch(Exception $e){
            var_dump($e);
            exit();
        }

        ?>

        <a href="staff_list.php">戻る</a>
</body>
</html>