<?php
require ("data/auth.php");

	try{
		$pdo=new PDO('mysql:dbname='.$dbnm.';host='.$serv.';charset=utf8',$user,$pass);
	} catch(PDOException $e){
		$error=$e->getMessage();
	}

	if(empty($_POST["name"])){
		$_POST["name"]="タイトルなし";
	}

	if(!empty($_POST["msg"])){
		//isbn変換ここから
		$sum = 0;
		$isbn13 = $_POST["msg"];				//Raw ISBN
		$isbn9 = substr($isbn13,3,9);				//9 ISBN

		for($i=0; $i<9; $i++){
			$num[$i] = substr($isbn9,$i,1);			//1文字ずつ抽出
			$isbn10[$i] = $num[$i]*(10-$i);			//掛け算
			$sum = $sum + $isbn10[$i];			//合計計算
		}

		$code = 11 - ($sum % 11);				//チェックディジット計算

		
		if($code == 11){					//値を識別
			$code = 0;
		}else if($code == 10){
			$code = X;
		}
		$_POST["msg"] = $isbn9.$code;
		//isbn変換ここまで

		if(empty($_POST["msg"])){
			header('Location:index.php?err=isbnempty');
		}else{
			$date=getdate();
			$d=$date["year"]."-".$date["mon"]."-".$date["mday"]."
			".$date["hours"].":".$date["minutes"].":".$date["seconds"];
			$_POST["msg"]=str_replace(' ','&nbsp;',$_POST["msg"]);
			$_POST["msg"]=str_replace('　','&nbsp;',$_POST["msg"]);

			$stmt=$pdo->query("INSERT INTO book(name,isbn13,isbn10,division,date) VALUES('".$_POST["name"]."','$isbn13','".nl2br($_POST["msg"])."','".$_POST["division"]."','$d')");

			$_POST["msg"]="";
			$_POST["name"]="";
			if(isset($_POST["msg"])){
				header('Location:index.php');
	  			exit;
			}

		}
	}

	if(isset($_GET['err'])) {
		$err = $_GET['err'];
		if($err=="isbnempty"){
			$errmsg="ISBNコードが不正です。";
		}
	}
?>

<!doctype html>
<html lang="ja">

<head>
    <title>deko's Purchase Books Sharing System</title>
</head>

<body>
    <center>
        <h1>書籍購入情報共有システム</h1>
        <p>Purchase Books Information Sharing System</p>
    </center>
    <center>
        <font size="2"><a href="search.php" target="_blank">タイトル・作品ID検索</a>｜<a href="admin.php" target="_blank">管理者用</a></font>
    </center></br>
    <table>
        <form action="index.php" method="POST">
            <tr>
                <td>タイトル</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>作品ID</td>
                <td><input type="text" name="msg"></td>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="division" value="ライトノベル" checked>ライトノベル</br>
                    <input type="radio" name="division" value="官能小説">官能小説</br>
                    <input type="radio" name="division" value="漫画">漫画</br>
                    <input type="radio" name="division" value="参考書">参考書</br>
                    <input type="radio" name="division" value="その他">その他</br>

                </td>
            </tr>
            <tr>
                <td><input type="submit" value="追加" title="Nice boat."></td>
            </tr>
        </form>
    </table>

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
