<?
	//データベース接続
	$dsn = 'mysql:dbname=tt_***_****_coco_com;host=localhost';
	$user = 'tt-***.****-coco';
	$password = 'PASSWORD';
	$pdo = new PDO($dsn,$user,$password);

	//テーブル作成
	$sql = "Create Table m6_data"
	."("
	."id INT,"
	."category INT,"
	."name char(32),"
	."comment TEXT,"
	."media TEXT,"
	."time char(32)"
	.");";
	$stmt = $pdo->query($sql);

	if(isset($_GET["user"]) && $_GET["user"] != ""){
        	$user = $_GET["user"];
		$category = (int)$_POST["teamid"];

		if((int)$_POST["teamid"] == 0){
			$category=1;
		}
    	}else {
        	header("Location:m6_index.php");
    	}

	for($i=0; $i<12; $i++){
		if($i+1==$category){
			$sel[$i] = "selected";
		}else{
			$sel[$i] = "";
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Baseball_Fansite_Mainpage</title>
</head>
<body>
	<h1>野球専門交流ファンサイト</h1>
	<form action="./m6_mainpage.php?user=<?php echo $user; ?>" method="post" enctype="multipart/form-data">
		<p>
			<select name="teamid">
				<option value="1" <?php echo $sel[0]; ?>>広島</option>
				<option value="2" <?php echo $sel[1]; ?>>ヤクルト</option>
				<option value="3" <?php echo $sel[2]; ?>>巨人</option>
				<option value="4" <?php echo $sel[3]; ?>>DeNA</option>
				<option value="5" <?php echo $sel[4]; ?>>中日</option>
				<option value="6" <?php echo $sel[5]; ?>>阪神</option>
				<option value="7" <?php echo $sel[6]; ?>>西武</option>
				<option value="8" <?php echo $sel[7]; ?>>ソフトバンク</option>
				<option value="9" <?php echo $sel[8]; ?>>日本ハム</option>
				<option value="10" <?php echo $sel[9]; ?>>オリックス</option>
				<option value="11" <?php echo $sel[10]; ?>>ロッテ</option>
				<option value="12" <?php echo $sel[11]; ?>>楽天</option>
			</select>
			<input type="submit" value="送信する">
		</p>

		<?php
			$comment = $_POST['comment'];
			$name = $_POST['name'];
			$media = "";
			$border = False;

			if (isset ($_FILES['media']) && is_uploaded_file ($_FILES ['media'] ['tmp_name'])) {
				$old_name = $_FILES ['media'] ['tmp_name'];
				if (! file_exists ( 'm6_upload' )) {
			        	mkdir ( 'm6_upload' );
				}
				$new_name = date ( "YmdHis" );
				$new_name .= mt_rand ();

			    	$tmp = pathinfo($_FILES["media"]["name"]);
			        $extension = $tmp["extension"];
			        if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
					$new_name .= '.jpeg';
			        }elseif($extension === "png" || $extension === "PNG"){
					$new_name .= '.png';
			        }elseif($extension === "gif" || $extension === "GIF"){
			               	$new_name .= '.gif';
			        }elseif($extension === "mp4" || $extension === "MP4"){
			                $new_name .= '.mp4';
			        }else{
			                echo "非対応ファイルです．<br/>";
			                exit(1);
				}

				$media = $new_name;
				move_uploaded_file ( $old_name, 'm6_upload/' . $new_name );
			}

			if($comment != '' && $name != ''){
				$sql = 'SELECT * FROM m6_data order by id';
				$results = $pdo -> query($sql);
				$results->execute();
				$cnt = $results->rowCount();

				$sql=$pdo->prepare("INSERT INTO m6_data (id,category,name,comment,media,time) VALUES(:id,:category,:name,:comment,:media,:time)");
				$sql->bindParam(':id',$id,PDO::PARAM_INT);
				$sql->bindParam(':category',$category,PDO::PARAM_INT);
				$sql->bindParam(':name',$name,PDO::PARAM_STR);
				$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
				$sql->bindParam(':media',$media,PDO::PARAM_STR);
				$sql->bindParam(':time',$time,PDO::PARAM_STR);

				$id = $cnt+1;
				$time = date("Y/m/d H:i:s");
				$sql->execute();
			}

			$sql = 'SELECT * FROM m6_data order by id';
			$results = $pdo -> query($sql);
			$i = 0;

			foreach($results as $row){
				if($row['category'] == $category){
					$border = True;
					$i++;
					echo '<br>-------------------------------<br>';
					echo "{$i} {$row['name']}: {$row['time']}<br />\n";
					echo nl2br($row['comment'])."<br />\n<br />\n";
					$fn = $row['media'];

					if($fn != ''){
						$file = "./m6_upload/$fn";
						$tmp = pathinfo($file);
					        $extension = $tmp["extension"];
						$mediainfo = getimagesize($file);
						$wid = 640;
						$hei = $mediainfo[1] * (640 / $mediainfo[0]);
						if($extension === "mp4" || $extension === "MP4"){
							echo '<br><video width="640" height="360" controls><source src="'.$file.'" type="video/mp4"></video><br>';
						}else{
							echo '<br><p><img src="',$file,'"  width="',$wid,'" height="',$hei,'"></p><br>';
						}
					}
				}
			}

			echo '<br>-------------------------------<br>';
			if($border == False){
				echo '<br>まだコメントはありません<br>';
				echo '<br>-------------------------------<br>';
			}
		?>

		<p>
			名前：<br />
			<input type="text" name="name" size="30"/><br />
		</p>
		<p>
			コメント：<br />
			<textarea name="comment" cols="50" rows="20"></textarea><br/>
		</p>
		<p>
			動画・画像：<br />
			<input type="file" name="media"><br/>
		</p>
		<p>
			<input type="submit" value="送信する">
		</p>
	</form>
</body>
</html>