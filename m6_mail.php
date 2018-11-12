<?php

	$dsn = 'mysql:dbname=tt_***_****_coco_com;host=localhost';
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
	$reg_password_conf = $_POST['password2'];
	$reg_mailadr = $_POST['mailadr'];
	$reg_mailadr_conf = $_POST['mailadr2'];

	if(strcmp($reg_password,$reg_password_conf)==0 && strcmp($reg_mailadr,$reg_mailadr_conf)==0){

		if(ctype_alnum($reg_password) && !ctype_digit($reg_password) && !ctype_alpha($reg_password)){
			$sql=$pdo->prepare("INSERT INTO m6_registration (id,password,mailadr,reg_key) VALUES(:id,:password,:mailadr,:reg_key)");
			$sql->bindParam(':id',$reg_id,PDO::PARAM_STR);
			$sql->bindParam(':password',$reg_password,PDO::PARAM_STR);
			$sql->bindParam(':mailadr',$reg_mailadr,PDO::PARAM_STR);
			$sql->bindParam(':reg_key',$reg_key,PDO::PARAM_STR);

			$reg_key = sha1(uniqid(rand(),1));
			
			$sql->execute();

			$to = $reg_mailadr;
			$subject = 'e-mail confirm';
			$message = "http://tt-***.****-coco.com/m6_regcomp.php";
			$headers = 'From : ********@example.com';

			echo $reg_mailadr.'宛に確認メールを送信しました。<br />';
			mail($to, $subject, $message, $headers);
		}else{
			echo "パスワードは、半角英字及び半角数字を含めてください。<br />";
			echo "<a href=\"m6_regist.php\">戻る</a><br>";
		}
	}else{
		if(strcmp($reg_password,$reg_password_conf)!=0){
			echo "パスワードが異なります。<br />";
		}

		if(strcmp($reg_mailadr,$reg_mailadr_conf)!=0){
			echo "メールアドレスが異なります。<br />";
		}

		echo "<a href=\"m6_regist.php\">戻る</a><br>";
	}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Baseball_Fansite_SendMail</title>
</head>
<body>
</body>
</html>