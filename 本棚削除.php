<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本を削除</title>
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
    <h2>本を削除する</h2>
<div class="form">
   <form method="post">
       <p>削除したい本のタイトルを入力して下さい</p>
       <input type="text" name="del" class="inp"><br><br>
       <input type="submit" value="削除"  class="btn" name="submit">
   </form>
</div>
<br>
    <?php
    // DB接続設定*/
	$dsn='mysql:dbname=******;host=localhost';
	$user='******';
	$password='******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

    if(isset($_POST["submit"])&& $_POST["del"]!=null){
    $title=$_POST["del"];
    $sql = "SELECT * FROM tana WHERE title='$title'";
    $stmt = $pdo->query($sql);
        $count=$stmt->rowCount();
    if($count!=0){
        //echo "あります";
        $results = $stmt->fetchAll();
    foreach ($results as $row){
	    echo '<div class="ran">'.'<div class="data">'."『".$row['title']."』".'<br>';
		echo "著者：".$row['saku'].'<br>';
		echo '<div class="memo">'.$row['memo'].'</div>'.'</div>';
		echo '<div class="sya">'.$row['picurl'].'</div>'.'</div>';
	}
	//削除機能
        $sql = "DELETE FROM tana WHERE title='$title'";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':title',$title, PDO::PARAM_INT);
        $stmt->execute();
        echo "以上を削除しました".'<br>';
    }else{
        echo "存在しないです";
    }
    
    }//if文了

    
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