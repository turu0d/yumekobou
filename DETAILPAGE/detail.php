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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> <!-- ChartJSのインポート -->
  </head>
    
  <body>
		<header>
		<?php foreach($data as $row): ?>
			<h1><?php echo $row['name']; ?></h1>
			<div style="text-align: right;">
				<p>TEL：<?php echo $row['TEL']; ?></p>
				<p>住所：<?php echo $row['address']; ?></p>
			</div>
		<?php endforeach; ?>
		</header>
			<div id="branding">
			</div>
				<nav>
					<ul>
						<li> <!-- SNS評価のグラフ -->
								<div style="height:350px; width:500px; margin:0 auto;">   <!-- グラフ表示枠を規定 -->
    							<canvas id="SNSChart"></canvas>   <!-- ここにグラフを表示 -->
  							</div>
						</li>
						<li> <!-- 口コミ評価のグラフ -->
								<div style="height:350px; width:500px; margin:0 auto;">   <!-- グラフ表示枠を規定 -->
    							<canvas id="KuchikomiChart"></canvas>   <!-- ここにグラフを表示 -->
  							</div>
						</li>
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
<script>
var ctx = document.getElementById("SNSChart");
var myRadarChart = new Chart(ctx, {
  //グラフの種類
  type: 'radar',
  //データの設定
  data: {
      //データ項目のラベル
      labels: ["満足度", "価格", "心地よさ", "泉質", "料理"],
      //データセット
      datasets: [
          {
              label: "SNS評価",
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
              data: [4,3,4,4,4]
          }
      ]
  },
 options: {
    // レスポンシブ指定
    responsive: true,
    scale: {
      ticks: {
        // 最小値の値を0指定
        beginAtZero:true,
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
<script>
var ctx = document.getElementById("KuchikomiChart");
var myRadarChart = new Chart(ctx, {
  //グラフの種類
  type: 'radar',
  //データの設定
  data: {
      //データ項目のラベル
      labels: ["満足度", "価格", "心地よさ", "泉質", "料理"],
      //データセット
      datasets: [
          {
              label: "SNS評価",
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
              data: [5,2,3,1,6]
          }
      ]
  },
 options: {
    // レスポンシブ指定
    responsive: true,
    scale: {
      ticks: {
        // 最小値の値を0指定
        beginAtZero:true,
        min: 0,
        // 最大値を指定
        max: 5,
      }
    },
		title: {
			display: true, //タイトルの表示可否
			text: 'AIを用いた口コミ評価解析結果' //タイトル
		}
  }
});
</script>
    </body>
</html>