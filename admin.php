<!DOCTYPE html>
<html lang="ja">

<head>
    <title>管理者ページ - E2B Library</title>
</head>
<?php
ini_set('display_errors', 0);
	require_once("data/user_d.php");
	if(!isset($_SERVER['PHP_AUTH_USER'])){
		header('WWW-Authenticate: Basic realm="Authentication is required."');
		header('HTTP/1.0 401 Unauthorized');
		echo 'ログインが必要です</br>';
		exit;
	}else{
		if($_SERVER['PHP_AUTH_PW']==''||$_SERVER['PHP_AUTH_USER']==''){
		header('WWW-Authenticate: Basic realm="Authentication is required."');
		header('HTTP/1.0 401 Unauthorized');
		echo 'ログインが必要です</br>';
		exit;
		}else{
			if($userpass[$_SERVER['PHP_AUTH_USER']]==$_SERVER['PHP_AUTH_PW']){
			require("data/edit.php");
			}else{
				header('WWW-Authenticate: Basic realm="Authentication is required."');
				header('HTTP/1.0 401 Unauthorized');
				echo 'ログインが必要です</br>';
				exit;
			}
		}
	}
?>

</html>
