<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Baseball_Fansite_Registration</title>
</head>
<body>
	<form action="/m6_mail.php" method="post">
		<p>ID、パスワード、メールアドレスを入力してください</p>
		<p>パスワードは半角英字及び半角数字を含むようにしてください</p>
		ID：<br />
		<input type="text" name="id"><br>
		パスワード:<br />
		<input type="password" name="password"><br>
		パスワード(確認):<br />
		<input type="password" name="password2"><br>
		メールアドレス:<br />
		<input type="text" name="mailadr"><br>
		メールアドレス(確認):<br />
		<input type="text" name="mailadr2"><br><br>
		<input type="submit" value="仮登録する">
	</form>
</body>
</html>