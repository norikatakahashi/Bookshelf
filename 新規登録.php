<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>新規登録画面</title>
  </head>
  <body>
    <h1>新規登録</h1>
    <form method="post">
      <div>ユーザ名: <input type="text" name="username"></div>
      
      <div>パスワード: <input type="password" 
         readonly onfocus="this.removeAttribute('readonly');" name="pass"></div>
      
      <div><input type="submit" value="登録" name="submit" /></div>
    </form>
    <p>アカウントをお持ちの方は
    <a href="ログイン.php">こちら</a>へ</p>
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
    
    echo "登録完了".'<br>';
    echo '<a href="ログイン.php">ログイン画面へ</a>';
    }//いる場合
    else{
        echo "既にいます。".'<br>'."別の名前に変えて下さい。";
    }
    }
    ?>
</body>
</html>