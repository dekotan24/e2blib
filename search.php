<!DOCTYPE html>
<html lang="ja">

<head>
    <title>タイトル・ISBN-13検索 - E2B Library</title>
    <meta charset="utf-8">
</head>

<body>
    <form action="search.php" method="post">
        <h3>タイトル・ISBN-13検索<font size=2>｜<a href="index.php" target="_blank">メインページ</a>｜<a href="admin.php" target="_blank">管理者用</a></font>
        </h3>
        タイトル<input type="text" name="name" title="タイトルを絞込対象とする場合は入力"> ｜ ISBN-13<input type="text" name="isbn13c" title="ISBN-13を絞込対象とする場合は入力">　を含む投稿を<input type="submit" value="検索" title="and検索">
    </form>

    <?php
require_once("data/auth.php");
	try{
		$pdo=new PDO('mysql:dbname='.$dbnm.';host='.$serv.';charset=utf8',$user,$pass);
} catch(PDOException $e){
	$error=$e->getMessage();
}
if(!isset($_POST["name"])&&!isset($_POST["isbn13c"])){
$stmt=$pdo->query("SELECT*FROM book");
}

else{
if($_POST["name"]==""&&$_POST["isbn13c"]==""){
$stmt=$pdo->query("SELECT*FROM book");
}
else if($_POST["name"]!=""&&$_POST["isbn13c"]==""){
$stmt=$pdo->query("SELECT*FROM book where name like '%".$_POST['name']."%'");
echo "≪検索キーワード≫</br>タイトル：<b>".$_POST["name"]."</b>";
}
else if($_POST["name"]==""&&$_POST["isbn13c"]!=""){
$stmt=$pdo->query("SELECT*FROM book where isbn13 like '%".$_POST["isbn13c"]."%'");
echo "≪検索キーワード≫</br>ISBN-13：<b>".$_POST["isbn13c"]."</b>";
}
else if($_POST["name"]!=""&&$_POST["isbn13c"]!=""){
$stmt=$pdo->query("SELECT*FROM book where name like '%".$_POST["name"]."%' AND isbn13 like '%".$_POST["isbn13c"]."%'");
echo "≪検索キーワード≫</br>タイトル：<b>".$_POST["name"]."</b></br>ISBN-13：<b>".$_POST["isbn13c"]."</b>";
}
else{
$stmt=$pdo->query("SELECT*FROM book");
}
}

?>

    <pre>
<?php
echo "<table border=5>";
echo "<tr><td alien=left>No</td><td alien=left>タイトル</td><td alien=left>ISBN-13</td><td alien=left>表紙画像</td><td alien=left>分類</td><td alien=left>登録日時</td></tr>";

while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<tr>";
		echo "<td alien=left>".$result['id']."</td>";
		echo "<td alien=left>".$result['name']."</td>";
		echo "<td alien=left>".$result['isbn13']."</td>";
		echo '<td><a href="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.LZZZZZZZ" target="_blank"><img src="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.MZZZZZZZ"></a></td>';
		echo "<td alien=left>".$result['division']."</td>";
		echo "<td alien=left>".$result['date']."</td></tr>";
}
?>
</body>
</html>
