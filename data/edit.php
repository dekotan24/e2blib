<?php
require_once("auth.php");
	try{
		$pdo=new PDO('mysql:dbname='.$dbnm.';host='.$serv.';charset=utf8',$user,$pass);
} catch(PDOException $e){
	$error=$e->getMessage();
}


if(!empty($_POST["delt"])){

if(preg_match("/[^0-9]/",$_POST["delt"])){
	echo "<font color='red' size='4'>数字以外は入力しないでください</font>";
	}else{
	$stmt=$pdo->query("DELETE FROM book WHERE id='".$_POST["delt"]."'");
	echo '<font color="blue" size="4">Successfully deleted post: '.$_POST["delt"].'</font>';
	}
}
if(isset($_POST["delt"])){
header('Location:admin.php');
exit;
}
?>
<table>
<form action="admin.php" method="POST">
<h3>管理者画面<font size=2>｜<a href="index.php" target="_blank">メインページ</a>｜<a href="search.php" target="_blank">タイトル・ISBN検索</a></font></h3>
<tr><td>削除したいNoを入力</td>
<td><input type="text" name="delt"></td>
<td><input type="submit" value="削除"></td></tr>
</form></table>

<pre>
<?php
echo '<form action="admin.php" method="POST">';
	$stmt=$pdo->query("SELECT*FROM book order by date DESC");
	echo "<table border=1>";
	echo "<th>No</th>";
	echo "<th>タイトル</th>";
	echo "<th>ISBN-13</th>";
	echo "<th>表紙画像</th>";
	echo "<th>分類</th>";
	echo "<th>登録日時</th>";
	echo "<th>削除</th>";

while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
	echo "<tr>";
	echo "<td>".$result['id']."</td>";
	echo "<td>".$result['name']."</td>";
	echo "<td>".$result['isbn13']."</td>";
	echo '<td><a href="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.LZZZZZZZ" target="_blank"><img src="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.MZZZZZZZ"></a></td>';
	echo "<td>".$result['division']."</td>";
	echo "<td>".$result['date']."</td>";
	echo "<td><center><input type='submit' name='delt' value='".$result['id']."' method='POST'></center></td>";
	echo "</tr>";
}
echo "</table></form>";

?>
</pre>
</body>