<?php
	$dsn = 'mysql:host=database-2.cnjcx8ih0byc.ap-northeast-1.rds.amazonaws.com;dbname=onsen_db;charset=utf8';
	$user = 'admin';
	$pass = 'rootroot1';
	$dbh = new PDO($dsn, $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
	$sql1 = 'SELECT ID, name, TEL, address, URL, reserve_site_URL, image, characteristic FROM onsen_info_tb';
	$sql2 = 'SELECT ID, site_senshitsu, site_manzoku, site_kakaku, site_kokochi, site_food, sns_senshitsu, sns_manzoku, sns_kakaku, sns_kokochi, sns_food FROM onsen_value_tb';
	$stmt1 = $dbh->prepare($sql1); //温泉の情報テーブルを用いたSQL文の発行
	$stmt1->execute();
	while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
		$data1[] = $row;
	}
	
	$stmt2 = $dbh->prepare($sql2); //温泉の情報テーブルを用いたSQL文の発行
	$stmt2->execute();
	while($row=$stmt2->fetch(PDO::FETCH_ASSOC)){
		$data2[] = $row;
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> <!-- ChartJSのインポート -->
	<link rel="stylesheet" href="detail.css">
</head>

<body>
	<header>
		<?php foreach($data1 as $row1): ?>
		<h1><?php echo $row1['name']; ?></h1>
		<div style="float: left;"> <!-- 写真div要素-->
			<img src="atami.jpg" alt="熱海温泉の写真" title="熱海温泉" width="300" height="200">
		</div>
		<div style="text-align: right;"><!-- 電話番号、住所div要素-->
			<p>TEL：<?php echo $row1['TEL']; ?></p>
			<p>住所：<?php echo $row1['address']; ?></p>
		</div>
		<div style="text-align: left;"> <!-- 説明文div要素(文字数210文字程度)-->
			<p>伊豆半島北東端、熱海駅の北東から南東にかけて、相模灘に面する海沿いに旅館やホテルが立ち並ぶ。眺望を求めて山腹に立地する施設もある。昔からの温泉街は山のすそ野にある駅近辺から海岸沿いまで広がる。熱海駅併設のラスカ熱海や駅近くの商店街、起雲閣のような観光施設、海浜の海水浴場や、さらに南側にある錦ヶ浦や熱海城、沖合に浮かぶ初島まで含めた観光地となっている。
			熱海駅は伊東線の始発駅で、伊豆観光の東の玄関口的な立地ともなっている。
			</p>
		</div>
		<?php endforeach; ?>
	</header>
	<div style="height:350px; width:500px; float:left; clear:both;">
		<!-- グラフ表示枠を規定 -->
		<canvas id="KuchikomiChart"></canvas> <!-- ここにグラフを表示 -->
	</div>
	<div style="height:350px; width:500px; float:left;">
		<!-- グラフ表示枠を規定 -->
		<canvas id="SNSChart"></canvas> <!-- ここにグラフを表示 -->
	</div>
	<script>
		var jsondata = JSON.parse('<?php echo json_encode($data2); ?>')
		var k1 = jsondata[0]["site_senshitsu"];
		var k2 = jsondata[0]["site_manzoku"];
		var k3 = jsondata[0]["site_kakaku"];
		var k4 = jsondata[0]["site_kokochi"];
		var k5 = jsondata[0]["site_food"];
		var s1 = jsondata[0]["sns_senshitsu"];
		var s2 = jsondata[0]["sns_manzoku"];
		var s3 = jsondata[0]["sns_kakaku"];
		var s4 = jsondata[0]["sns_kokochi"];
		var s5 = jsondata[0]["sns_food"];
		
		var ctx = document.getElementById("KuchikomiChart");
		
		var myRadarChart = new Chart(ctx, {
			//グラフの種類
			type: 'radar',
			//データの設定
			data: {
				//データ項目のラベル
				labels: ["泉質", "満足度", "価格", "心地よさ", "料理"],
				//データセット
				datasets: [{
					label: "評価値",
					//背景色
					backgroundColor: "rgba(0,0,255,0.5)",
					//枠線の色
					borderColor: "rgba(0,0,255,1)",
					//結合点の背景色
					pointBackgroundColor: "rgba(0,0,255,1)",
					//結合点の枠線の色
					pointBorderColor: "#fff",
					//結合点の背景色（ホバ時）
					pointHoverBackgroundColor: "#fff",
					//結合点の枠線の色（ホバー時）
					pointHoverBorderColor: "rgba(200,112,126,1)",
					//結合点より外でマウスホバーを認識する範囲（ピクセル単位）
					hitRadius: 5,
					//グラフのデータ
					data: [k1,k2,k3,k4,k5]
				}]
			},
			options: {
				// レスポンシブ指定
				responsive: true,
				scale: {
					ticks: {
						// 最小値の値を0指定
						beginAtZero: true,
						min: 0,
						// 最大値を指定
						max: 5,
					}
				},
				title: {
					display: true, //タイトルの表示可否
					text: 'AIを用いた口コミサイト評価解析結果' //タイトル
				}
			}
		});
		
		var ctx = document.getElementById("SNSChart");
		
		var myRadarChart = new Chart(ctx, {
			//グラフの種類
			type: 'radar',
			//データの設定
			data: {
				//データ項目のラベル
				labels: ["泉質", "満足度", "価格", "心地よさ", "料理"],
				//データセット
				datasets: [{
					label: "評価値",
					//背景色
					backgroundColor: "rgba(200,112,126,0.5)",
					//枠線の色
					borderColor: "rgba(200,112,126,1)",
					//結合点の背景色
					pointBackgroundColor: "rgba(200,112,126,1)",
					//結合点の枠線の色
					pointBorderColor: "#fff",
					//結合点の背景色（ホバ時）
					pointHoverBackgroundColor: "#fff",
					//結合点の枠線の色（ホバー時）
					pointHoverBorderColor: "rgba(200,112,126,1)",
					//結合点より外でマウスホバーを認識する範囲（ピクセル単位）
					hitRadius: 5,
					//グラフのデータ
					data: [s1, s2, s3, s4, s5]
				}]
			},
			options: {
				// レスポンシブ指定
				responsive: true,
				scale: {
					ticks: {
						// 最小値の値を0指定
						beginAtZero: true,
						min: 0,
						// 最大値を指定
						max: 5,
					}
				},
				title: {
					display: true, //タイトルの表示可否
					text: 'AIを用いたSNS評価解析結果' //タイトル
				}
			}
		});
	</script>

</body>

</html>