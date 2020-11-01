<?php
session_start();//!DOCTYPEより上に記入
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本棚追加</title>
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
    <h2>本を追加する</h2>
<div class="form">
    <form  method="post" enctype="multipart/form-data">
    【投稿フォーム】<br>
        タイトル<br><input type="text" name="tit" class="inp"><br>
        作者<br><input type="text" name="com" class="inp"><br>
        メモ<br><textarea name="memo" class="inp"></textarea><br>
        画像：<input type="file" name="upimg" accept="image/*" ><br><br>
        <input type="submit" name="submit" class="btn">
    </form>
</div>
    <br>
    <?php
    $name=$_SESSION['name'];
    
    ini_set("display_errors", "Off");
    
    //DB接続設定
	$dsn='mysql:dbname=******;host=localhost';
	$user='******';
	$password='******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

    //テーブル作成
	$sql = "CREATE TABLE IF NOT EXISTS tana"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "user_name char(32),"
	. "title char(32),"
	. "saku TEXT,"
	. "picurl TEXT,"
	. "memo TEXT"
	.");";
	
	$stmt = $pdo->query($sql);

    //データ入力
    if(isset($_POST["submit"]) && $_POST['com']!=null && 
    $_POST['tit']!=null){
        
    $fp = fopen($_FILES['upimg']['tmp_name'], "rb");
    $img = fread($fp, filesize($_FILES['upimg']['tmp_name']));
    fclose($fp);

    $enc_img = base64_encode($img);

    $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);

        
	$sql = $pdo -> prepare("INSERT INTO tana (saku,title,memo,picurl,user_name) 
	VALUES (:saku,:title,:memo,:picurl,:user_name)");
    $sql -> bindParam(':saku', $saku, PDO::PARAM_STR);
    $sql -> bindParam(':title', $title, PDO::PARAM_STR);
    $sql -> bindParam(':memo', $memo, PDO::PARAM_STR);
    $sql -> bindParam(':picurl', $picurl, PDO::PARAM_STR);
    $sql -> bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $saku=$_POST['com'];
    $user_name=$name;
    $title=$_POST['tit'];
    $memo=$_POST['memo'];
    $picurl='<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'">';
    $sql -> execute();
    
    //テーブル内にあるか確認
    $sql = "SELECT * FROM tana WHERE user_name='$name'
        AND saku='$saku'
        AND title='$title'
        AND memo='$memo'";
        
        $stmt = $pdo->query($sql);
	    //データの行数知りたい
	    $count=$stmt->rowCount();

     if($count!=0){
         //もし一致したら
	    echo '<div class="ran">'.'<div class="data">'."『".$title."』".'<br>'."著者：".$saku.'<br>'.'<div class="memo">'.$memo.'</div>'.'</div>'.'<div class="sya">'.$picurl.'</div>'.'</div>'.'<br>'.
	    "以上を追加しました！".'<br>';
	    
    }else{
        echo "画像サイズが大きく、登録できません";
    }
    }//全体のif文
    ?>
<footer></footer>
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