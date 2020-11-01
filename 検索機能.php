<?php
session_start();//!DOCTYPEより上に記入
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&family=Trispace:wght@600&display=swap"
    rel="stylesheet">
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
    <h2>本棚から検索する</h2>

<div class="kensaku">

    <form  method="post" class="ser">
        <input type="text" name="musi"
        placeholder="ワードで絞り込む" class="inp">
        <input type="submit" name="ksubmit"
        class="btns" value="検索">
    </form>
    
    ---------------------------------------<br>
    【結果】<br>
    <?php
    $name=$_SESSION['name'];
    $musi=$_SESSION['musi'];
    //DB接続設定
	$dsn='mysql:dbname=******;host=localhost';
	$user='******';
	$password='******';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

    //また飛ぶ（さらにそこで検索した場合）
    if(isset($_POST["ksubmit"]) && $_POST["musi"]!=null){
        $_SESSION['musi']=$_POST['musi'];
        header("Location: 検索機能.php");
    }?>
    <?php
        //部分一致してるか
        $sql = "SELECT * FROM tana WHERE user_name='$name'
        AND (memo LIKE '%$musi%'
        OR saku LIKE '%$musi%'
        OR title LIKE '%$musi%'
        )";//%は空白明けない！！
	    $stmt = $pdo->query($sql);
	    //データの行数知りたい
	    $count=$stmt->rowCount();
        //何件あるか(分岐で、「ありません」も？)
        echo "[".$musi."]は".$count."件あります。".'<br>';
        if($count!=0){
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
        
        //表示
        $sql = "SELECT * FROM tana WHERE user_name='$name'
        AND (memo LIKE '%$musi%'
        OR saku LIKE '%$musi%'
        OR title LIKE '%$musi%'
        ) LIMIT $start_no,5";
        
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        
        foreach ($results as $row){
	    echo '<div class="ran">';
	    echo '<div class="data">'."『".$row['title']."』".'<br>';
		echo "著者：".$row['saku'];
		echo '<div class="memo">'.$row['memo'].'</div>'.'</div>'.'　';
		echo '<div class="sya">'.$row['picurl'].'</div>';
	    echo '</div>';
	}
            
        }//foreach了
        ?>
        <div class="page">
        <?php
        if($count!=0){
         //最大数文のページリンク
    for($i = 1; $i <= $max_page; $i++){
       echo '<div class="bnum">'.
       '<a href="/main.php?page_id=' .$i. ' ">'
       .$i.'</a>'.'</div>';}
        }
    //}if文了
    
           ?>
         </div>
</div>
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