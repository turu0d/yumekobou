<?php

	if(!isset($_POST['onsen'])){
		http_response_code( 301 ) ;
		header("Location: ../TOPPAGE/TOP.html");
		exit ;
	}

	$dsn = 'mysql:host=database-2.cnjcx8ih0byc.ap-northeast-1.rds.amazonaws.com;dbname=onsen_db;charset=utf8';//MySQLのonsen_dbというデータベースに接続。文字エンコーディングの指定。
	$user = 'admin';
	$pass = 'rootroot1';
	$dbh = new PDO($dsn, $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートの表示。 PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます。

	$array = $_POST['onsen'];

try{
	$sql = 'SELECT * FROM onsen_info_tb WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $array, PDO::PARAM_STR);
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
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
	<link rel="stylesheet" href="detail.css">
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a href="../RESULTPAGE/result.php">検索結果</a></li>
				<li><a href="../DETAILPAGE/detail.php">詳細</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<div class="title">
			<?php foreach($data as $row): ?>
			<h1><?php echo $row['name']; ?></h1>
		</div>

		<div class="pan">
			<ol>
				<!--　パンくずリスト -->
				<li><a href="../TOPPAGE/TOP.html">TOP</a></li>
				<li><a href="../RESULTPAGE/result.php">検索結果</a></li>
				<li>詳細</li>
			</ol>
		</div>

		<div class="picture" style="float: left;">
			<!-- 写真div要素-->
			<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" title="<?php echo $row['name']; ?>" width="300" height="200" style="margin: 0 30 30 0">
		</div>

		<div class="information" style="text-align: right;">
			<!-- 電話番号、住所div要素-->
			<p>TEL：<?php echo $row['tel']; ?></p>
			<p>FAX：<?php echo $row['fax']; ?></p>
			<p>住所：<?php echo $row['address']; ?></p>
			<p><a href="<?php echo $row['url']; ?>">公式サイトはこちら</a></p>
			<p><a href="<?php echo $row['reserve_site_url']; ?>">予約サイトはこちら</a></p>
		</div>
		<div class="hyou" style="clear: both;">
			<table border="1">
				<caption>温泉情報</caption>
				<tr>
					<th>客室数</th>
					<td><?php echo $row['number_of_rooms']; ?></td>
				</tr>
				<tr>
					<th>宿泊定員</th>
					<td><?php echo $row['accommodation_capacity']; ?></td>
				</tr>
				<tr>
					<th>立地環境</th>
					<td><?php echo $row['location_environment']; ?></td>
				</tr>
				<tr>
					<th>泉質</th>
					<td><?php echo $row['spring_quality']; ?></td>
				</tr>
				<tr>
					<th>泉温</th>
					<td><?php echo $row['spring_temperatuar']; ?></td>
				</tr>
				<tr>
					<th>色</th>
					<td><?php echo $row['spring_color']; ?></td>
				</tr>
				<tr>
					<th>適応症</th>
					<td><?php echo $row['indications']; ?></td>
				</tr>
				<tr>
					<th>日帰入浴</th>
					<td><?php echo $row['one_day_bath']; ?></td>
				</tr>
				<tr>
					<th>日帰入浴時間</th>
					<td><?php echo $row['one_day_bath_time']; ?></td>
				</tr>
				<tr>
					<th>日帰入浴料金</th>
					<td><?php echo $row['one_day_bath_fee']; ?></td>
				</tr>
				<tr>
					<th>素泊まり</th>
					<td><?php echo $row['stay_without_meals']; ?></td>
				</tr>
				<tr>
					<th>1名宿泊</th>
					<td><?php echo $row['one_person_accounnodation']; ?></td>
				</tr>
				<tr>
					<th>露天風呂数</th>
					<td><?php echo $row['number_of_open_air_baths']; ?></td>
				</tr>
				<tr>
					<th>貸切浴場数</th>
					<td><?php echo $row['number_of_private_baths']; ?></td>
				</tr>
				<tr>
					<th>露天風呂付客室数</th>
					<td><?php echo $row['number_of_guest_rooms_with_open_air_bath']; ?></td>
				</tr>
				<tr>
					<th>掛け流し</th>
					<td><?php echo $row['flowing']; ?></td>
				</tr>
			</table>
		</div>
		<?php endforeach; ?>
	</main>

	<footer>
		<div class="topfoot">
			<div class="footertitle">
				<a href="../TOPPAGE/TOP.html" id="footera">
					<h1 id="footerh1">夢工房</h1>
					<p id="footerp">誰もが利用できる温泉サイト。</p>
				</a>
			</div>
			<ul class="clearfix">
				<li class="member clearfix">
					<div class="left">Creators.</div>
					<ul class="right">
						<li>Shin Tsuruga</li>
						<li>Arimichi Hirao</li>
						<li>Hiroki Takeshita</li>
						<li>Keisuke Kuroki</li>
						<li>Toshiyuki Iwai</li>
						<li>Shunsuke Asayama</li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="underfoot">
			<p style="text-align: center;">&copy; 2020 yumekoubou All rights reserved</p>
		</div>
	</footer>
</body>

</html>
