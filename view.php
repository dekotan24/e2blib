<?php
	require_once("data/auth.php");
	try{
		$pdo=new PDO('mysql:dbname='.$dbnm.';host='.$serv.';charset=utf8',$user,$pass);
	} catch(PDOException $e){
		$error=$e->getMessage();
	}
?>
<!doctype html>
<html lang="ja">

<head>
    <title>E2B Library Viewer</title>
</head>

<body>
    <center>
        <h1>E2B Library Viewer</h1>
        <p>Easy ISBN Based Book Manager</p>
    </center>

    <pre>
			<?php
				if(isset($errmsg)){
					echo $errmsg;
				}
				$stmt=$pdo->query("SELECT*FROM book order by id DESC");
				echo '<table border=1>';
				echo "<th>No</th>";
				echo '<th>タイトル</th>';
				echo "<th>ISBN-13</th>";
				//echo "<th>ISBN-10</th>";
				echo "<th>表紙画像</th>";
				echo "<th>分類</th>";
				echo "<th>登録日時</th>";

				while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
					echo "<tr>";
					echo "<td>".$result['id']."</td>";
					echo '<td>'.$result['name']."</td>";
					echo "<td>".$result['isbn13']."</td>";
					//echo "<td>".$result['isbn10']."</td>";
					echo '<td><a href="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.LZZZZZZZ" target="_blank"><img src="http://images-jp.amazon.com/images/P/'.$result['isbn10'].'.09.MZZZZZZZ"></a></td>';
					echo "<td>".$result['division']."</td>";
					echo "<td>".$result['date']."</td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
		</pre>


</body>

</html>
