<?php
session_start();//!DOCTYPEより上に記入
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&family=Trispace:wght@600&display=swap" rel="stylesheet">
  
  </head>
  <body>
      <header></header>
            <h2>ログイン画面</h2>
      <div class="form">
        <form method="post">
          <div>ユーザー名:<input type="text" name="user" class="inp"></div>
          <div>パスワード:<input type="password" name="rpass" class="inp"></div><br>
          <input type="submit" name="submit"  class="btn" value="ログイン">
        </form><br>
	        新規登録の方:
          <a href="新規登録.php">こちら</a>
      </div>
<?php 
    // DB接続設定*/
	$dsn='mysql:dbname=*******;host=localhost';
	$user='*******';
	$password='*******';
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
     $alert = "<script type='text/javascript'>alert('ユーザー名またはpassが違います');</script>";
    echo $alert;
     }
}//「ボタン押されたら」了
        
	?>
</body>
</html>