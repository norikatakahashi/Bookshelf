<?php
session_start();//!DOCTYPEより上に記入
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本棚</title>
    <link rel="stylesheet" href="menu.css">
     <style>
         img{
             height:50px;
         }
     </style>
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
    
    
    <h1><?php $name=$_SESSION['name'];
    echo $name."の本棚".'<br>';
    ?></h1>
    <a href="本棚追加.php">追加する</a>
          <a href="本棚削除.php">削除する</a><br>
    <form method="post">
        検索:<input type="text" name="musi">
        <input type="submit" name="ksubmit">
    </form>
    <?php
    //$name=$_SESSION['name'];
    //echo $name."の本棚".'<br>';

    //検索ボタン押されたら飛ぶ
    if(isset($_POST["ksubmit"]) && $_POST["musi"]!=null){
        $_SESSION['musi']=$_POST['musi'];
        header("Location: 検索機能.php");
    }



    //DB接続設定
	$dsn='mysql:dbname=******;host=localhost';
	$user='******';
	$password='9******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

    $sql = "SELECT * FROM tana WHERE user_name='$name'";
	$stmt = $pdo->query($sql);
	//データの行数知りたい
	$count=$stmt->rowCount();
    //echo $count;

    //1pごとに表示する個数
    define('MAX','5');
    //必要なページ数
    $max_page = ceil($count/ MAX); 
    
    // $_GET['page_id'] はURLに渡された現在のページ数
    if(!isset($_GET['page_id']))
    { 
    $now = 1; // 設定されてない場合は1ページ目にする
    //echo $now;
    }else{
        $now = $_GET['page_id'];
        //echo $now;
        }

    //配列の何番目から取得？3x0,3x1 2pは配列[3]！
    $start_no = ($now - 1) * MAX;

    $sql = "SELECT * FROM tana WHERE user_name='$name'
    LIMIT $start_no,5";
    $stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
	    echo $row['title'].'　';
		echo $row['saku'].'　';
		echo $row['memo'].'　';
		echo "画像：".$row['picurl'].'<br>';
	    echo '<hr>';
	}
        
     //最大数文のページリンク
    for($i = 1; $i <= $max_page; $i++){
       echo'<a href="/main.php?page_id=' .$i. ' ">'.$i.'</a>';
        
    }
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