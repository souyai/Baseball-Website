<?php

	$dsn = 'mysql:dbname=tt_***_***_coco_com;host=localhost';
	$user = 'tt-***.****-coco';
	$password = 'PASSWORD';
	$pdo = new PDO($dsn,$user,$password);

	$sql = "CREATE TABLE m6_registration" 
	."("
	."id varchar(32) NOT NULL,"
	."password varchar(32) NOT NULL,"
	."mailadr varchar(64) NOT NULL,"
	."reg_key varchar(64) NOT NULL"
	.");";

	$stmt = $pdo->query($sql);

	$reg_id = $_POST['id'];
	$reg_password = $_POST['password'];

	$sql = 'SELECT * FROM m6_registration';
	$results = $pdo -> query($sql);
	$results->execute();

	foreach($results as $row){
		if(strcmp($row['id'],$reg_id)==0 && strcmp($row['password'],$reg_password)==0){
			header("Location:./m6_mainpage.php?user={$row['reg_key']}");
		}
	}

	if($reg_password != "" && $reg_id != ""){
		echo "ログインできませんでした。<br/>";
	}else{
		echo "idとpasswordを入力してください。<br/>";
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Baseball_Fansite_Login</title>
</head>
<body>
	<form action="/m6_login.php" method="post">
		<br />ID：<br />
		<input type="text" name="id"><br>
		パスワード:<br />
		<input type="password" name="password"><br><br>
		<input type="submit" value="送信">
	</form>
</body>
</html>
