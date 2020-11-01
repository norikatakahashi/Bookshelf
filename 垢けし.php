<?php
session_start();//!DOCTYPEより上に記入
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>アカウント削除</title>
<link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&family=Trispace:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="menu.css">
  </head>
  <body>
      <div id="navArea">
        <nav>
        <div class="inner">
            <ul>
                <li><a href="main.php">本棚</a></li>
                <li><a href="本棚追加.php">本を追加</a></li>
                <li><a href="本棚削除.php">本を削除</a></li>
                <li><a href="パス変.php">パスワード変更</a></li>
                <li><a href="index.html">ログアウト</a></li>
                <li><a href="垢けし.php">アカウント削除</a></li> 
            </ul>
        </div>
        </nav>
        <div class="toggle_btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div id="mask"></div>
    </div>
<header></header>
      <h2>アカウントの削除</h2>
      <p>本当に削除しますか？<br>
      アカウントともに、本棚も消えます。</p>
      <form method="post">
      <input type="submit" value="はい" name="yes"  class="btns"/>
    <input type="submit" value="いいえ"name="no" class="btns"/>
      </form>
      <?php
      //いいえのとき
      if(isset($_POST["no"])){
          header("Location: main.php");
      }
      
      
     // DB接続設定*/
	$dsn='mysql:dbname=*******;host=localhost';
	$user='*******';
	$password='*******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

      //もし[はい]が押されたら
      if(isset($_POST["yes"])){
      //①アカウント削除
        $name=$_SESSION['name'];
        $sql = "DELETE FROM user WHERE name='$name'";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':name',$name, PDO::PARAM_INT);
    
        $stmt->execute();

      //②本棚削除
        $sql = "DELETE FROM tana WHERE user_name='$name'";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':user_name',$user_name, PDO::PARAM_INT);
    
        $stmt->execute();
      //削除完了→ログイン画面へ
        echo "削除しました。".'<br>'.
        '<a href=新規登録.php>新規登録画面へ</a>';
        }//一連の動作終了
        ?>
        <script type="text/javascript" src="jquery-3.3.1.min.js">

</script>

<script>
(function($) {
  var $nav   = $('#navArea');
  var $btn   = $('.toggle_btn');
  var $mask  = $('#mask');
  var open   = 'open'; // class
  // menu open close
  $btn.on( 'click', function() {
    if ( ! $nav.hasClass( open ) ) {
      $nav.addClass( open );
    } else {
      $nav.removeClass( open );
    }
  });
  // mask close
  $mask.on('click', function() {
    $nav.removeClass( open );
  });
} )(jQuery);
</script>    
            
  </body>
  </html>