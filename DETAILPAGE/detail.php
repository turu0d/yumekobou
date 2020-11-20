<?php

	$dsn = 'mysql:host=database-2.cnjcx8ih0byc.ap-northeast-1.rds.amazonaws.com;dbname=onsen_db;charset=utf8';
	$user = 'admin';
	$pass = 'rootroot1';
	$dbh = new PDO($dsn, $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
	$sql = 'SELECT ID, name, TEL, address, URL, reserve_site_URL, image, site_value, sns_value, characteristic FROM onsen_tb';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$data[] = $row;
	}
} catch (PDOException $e){
	echo($e->getMessage());
	die();
}
?>
<html>
  <head>
    <meta charset="UTF-8">
		<title>温泉詳細画面</title>
		<link href="css/reset.css" rel="stylesheet" type="text/css">
		<link href="css/css.css" rel="stylesheet" type="text/css">
  </head>
    
  <body>
		<header>
			<?php echo '<h1>'.$row['name'].'温泉</h1>'; ?>
			<div style="text-align: right;">
				<a href="#"><?php echo $row['TEL']; ?></a>
				<p>住所：<?php echo $row['address']; ?></p>
			</div>
		</header>
			<div id="branding">
			</div>
				<nav>
					<ul>
						<li><a href="#">口コミサイトの口コミ抜粋(まとめ)・評価(**/5.0)・数値・(グラフ)・(キーワード)</a></li>
						<li><a href="#">SNSの口コミ抜粋（まとめ）・評価（**/5.0）・数値・（グラフ）・（キーワード）</a></li>
          </ul>
				</nav>
		<section>
			<article>
				<span class="date"></span>
					<h2></h2>
					<p></p>
					<a href="#" class="btn"></a>
      </article>
    </section>
			<footer>
				<small></small>
      </footer>
    </body>
</html>