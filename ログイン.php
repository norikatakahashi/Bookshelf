<?php
session_start();//!DOCTYPEより上に記入
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <h1>ログイン画面</h1>
      <form  method="post">
         <div>ユーザー名<input type="text" name="user">
         </div>
         <div>パスワード<input type="password" 
         readonly onfocus="this.removeAttribute('readonly');"
         name="rpass">
         </div>
         <input type="submit" name="submit">
      </form>
<?php 
    // DB接続設定*/
	$dsn='mysql:dbname=******tb220702db;host=localhost';
	$user='******';
	$password='******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

//ボタン押されたら
if(isset($_POST["submit"]) && $_POST["user"]!=null
&& $_POST["rpass"]!=null){

    $name=$_POST["user"];
    $rpass=$_POST["rpass"];
    //ユーザ一覧のテーブル召喚(名前とPASSが一致するかカウント)
        $sql = "SELECT * FROM user WHERE name='$name'
        AND comment='$rpass'";
        
        $stmt = $pdo->query($sql);
	    //データの行数知りたい
	    $count=$stmt->rowCount();

     if($count!=0){
         //もし一致したらログイン成功
        $results=$pdo->query($sql);
	    foreach($results as $row){
	        
	    $_SESSION['id']=$row['id'];
	    $_SESSION['name']=$row['name'];
	    $_SESSION['comment']=$row['comment'];
	    $_SESSION['OK']="OK";
	    header("Location: main.php");
	    }
     }else{//完全一致しなかったらエラー文だす。
         echo "ユーザー名またはpassが違います";
     }
}//「ボタン押されたら」了
        
	?>
	 <br>新規登録の方:
      <a href="新規登録.php">新しく登録</a></p>
</body>
</html>