<?php
session_start();//!DOCTYPEより上に記入
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>パスワード変更</title>
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
                <li><a href="ログイン.php">ログアウト</a></li>
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
      <h2>パスワードの変更</h2>
<div class="form">
      <form method="post">
      現在のPASS<input type="text" class="inp" name="gpass" />

      <br><br>
        
      新しいPASS<input type="password" class="inp" name="hpass" 
      /><br>
      もう一度入力<input type="password" class="inp" name="hhpass" /><br><br>
    <input type="submit" class="btn" value="変更"name="hsub"/>
      </form>
</div>
      <br>
      <?php
      $name=$_SESSION['name'];
      // DB接続設定*/
	   $dsn='mysql:dbname=******;host=localhost';
	   $user='******';
	   $password='******';
	   $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

     //入力したpassがユーザーのpassと一致するか判断
     if(isset($_POST["hsub"])&&$_POST["gpass"]!=null){
         $gpass=$_POST["gpass"];
         //ユーザ一覧のテーブル召喚(名前とPASSが一致するかカウント)
        $sql = "SELECT * FROM user WHERE name='$name'
        AND comment='$gpass'";
        
        $stmt = $pdo->query($sql);
	    //データの行数知りたい
	    $count=$stmt->rowCount();

     if($count!=0){
         //もし一致したら新しいpassも取得して変更する
        $hpass = $_POST["hpass"];
        $hhpass = $_POST["hhpass"];
        if($hpass==$hhpass){
            //変更
            
            $comment=$hpass;
            $sql = "UPDATE user SET comment=:comment WHERE 
            name='$name'";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();
            echo "変更完了";
        }else{
            //新しいやつ一致してない
            echo "新しくするPASSが一致しません";
        }
     }else{//一致しなかったらエラー文だす。
         echo "passが違います";
     }
     
    
     }//ボタン押されたときの一連の動作終了
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