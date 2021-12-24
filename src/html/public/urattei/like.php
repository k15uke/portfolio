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
    if(isset($_POST['like'])){
        try{
           
            $_SESSION['msg']['err'] = 'いいねしました';
            header('Location: ./index.php');
            exit;

        }catch(Exception $e){
            $_SESSION['msg']['err'] = 'いいねできませんでした';
            var_dump($e);
            exit();
        }
    }elseif(isset($_POST['dislike'])){
        try{

            $_SESSION['msg']['err'] = 'よくないねしました';
            header('Location: ./index.php');
            exit;

        }catch(Exception $e){
            $_SESSION['msg']['err'] = 'よくないねできませんでした';
            var_dump($e);
            exit();
        }
    }

        ?>
</body>
</html>