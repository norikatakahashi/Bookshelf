<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>新規登録画面</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&family=Trispace:wght@600&display=swap" rel="stylesheet">
  </head>
  <body>
    <header></header>
    <h2>新規登録</h2>
    <div class="form">
        <form method="post">
            <div>ユーザ名: <input type="text" name="username" class="inp"></div>
            <div>パスワード: <input type="password" name="pass" class="inp"></div>
            <br>
            <input type="submit" value="登録する"name="submit" class="btn"/>
    </form><br>
    アカウントをお持ちの方:<a href="ログイン.php">こちら</a>
    
    <?php 
    // DB接続設定*/
	$dsn='mysql:dbname=******;host=localhost';
	$user='******';
	$password='******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

    //テーブル作成
	$sql = "CREATE TABLE IF NOT EXISTS user"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	.");";
	$stmt = $pdo->query($sql);
    

    if(isset($_POST["submit"]) && $_POST["username"]!=null
    && $_POST["pass"]!=null){ //送信ボタン押されたら
    //ユーザー名かぶった人いるか検索
    $name=$_POST["username"];
    $sql = "SELECT * FROM user WHERE name='$name'";
        
        $stmt = $pdo->query($sql);
	    //データの行数知りたい
	    $count=$stmt->rowCount();

    //いない場合:登録する
    if($count==0){

    //テーブル内に入れる
    $sql = $pdo -> prepare("INSERT INTO user (name, comment)VALUES(:name, :comment)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $name=$_POST["username"];
    $comment=$_POST["pass"];
    $sql -> execute();
    
    $alert = "<script type='text/javascript'>alert
    ('登録成功！');</script>";
    echo $alert;
    }//いる場合
    else{
        $alert = "<script type='text/javascript'>alert('同じ名前のユーザーが既にいます。別の名前に変えて下さい。');</script>";
        echo $alert;
    }
    }
    ?></div>
</body>
</html>