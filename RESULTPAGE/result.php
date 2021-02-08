<?php
	session_start();
	if(!isset($_GET['page_id'])){
		if(!isset($_POST['riyu']) OR !isset($_POST['tokucho'])){
			ini_set('display_errors', 0);			
			echo '<meta http-equiv="Refresh" content="3; url=../TOPPAGE/TOP.html">[error]都道府県と特徴を選択してください。5秒後に遷移します。</meta>';
		}
		$dsn = 'mysql:host=database-2.cnjcx8ih0byc.ap-northeast-1.rds.amazonaws.com;dbname=onsen_db;charset=utf8';//MySQLのonsen_dbというデータベースに接続。文字エンコーディングの指定。
		$user = 'admin';
		$pass = 'rootroot1';
		$dbh = new PDO($dsn, $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートの表示。 PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます。

		$data = array(); //都道府県絞り込みのSELECT文の結果格納
		$miseru = array(); //ユーザーに表示する配列
		$riyu = $_POST['riyu']; //ユーザーが選択した都道府県を格納
		$tokucho = $_POST['tokucho']; //ユーザーが選択した特徴を格納
		$i = 0;

		//「都」「道」「府」「県」を連結する
		for($i=0; $i<count($riyu); $i++){
			if($riyu[$i] == '北海道'){
			}elseif($riyu[$i] == '大阪' OR $riyu[$i] == '京都'){
				$riyu[$i] .= '府';
			}elseif($riyu[$i] == '東京'){
				$riyu[$i] .= '都';
			}else{
				$riyu[$i] .= '県';
			}
		}

		//ユーザーが選択した都道府県をDBから絞り込み
		$sql = "SELECT * FROM onsen_info_tb_2 where prefecture in (";
		$where = array(); //where句を記述するための配列
		foreach($riyu as $value){
			$where[] = '"'.$value.'"';
		}
		if(count($where)>0){
			$sql.= implode($where, ", ");
		}
		$sql .= ")";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$data[] = $row;
			$i++;
		}
		for($x=0; $x<$i; $x++){
			$data[$x]["point"] = 0;	
		}

		//ユーザーが選択した特徴に一致する数を$data[]['point']に格納
		for($x=0; $x<$i; $x++){
			for($y=0; $y<count($tokucho); $y++){
				if(!empty($data[$x]["spring_quality"])){
					if(strrpos($data[$x]["spring_quality"], $tokucho[$y]) !== false){
						$data[$x]["point"] ++;
					}	
					if(strrpos($data[$x]["spring_color"], $tokucho[$y]) !== false){
						$data[$x]["point"] ++;
					}	
					if(strrpos($data[$x]["stay_without_meals"], $tokucho[$y]) !== false){
						$data[$x]["point"] ++;
					}	
					if(strrpos($data[$x]["one_person_accounnodation"], $tokucho[$y]) !== false){
						$data[$x]["point"] ++;
					}	
					if(strrpos($data[$x]["flowing"], $tokucho[$y]) !== false){
						$data[$x]["point"] ++;
					}	
				}
			}
		}

		//キー基準ソート関数
		function sortByKey($key_name, $sort_order, $array) {
			foreach ($array as $key => $value) {
					$standard_key_array[$key] = $value[$key_name];
			}
			array_multisort($standard_key_array, $sort_order, $array);
			return $array;
		}

		//$data[]['point']基準で降順ソートし$arrayに結果を代入
		$array = sortByKey('point', SORT_DESC, $data);

		//$array[]['point']>=1 かつ $array[]['name'] or $array[]['prefecture']がnot nullの要素を$miseruに代入
		for($i=0; $i<count($array); $i++){
			if($array[$i]["point"] >= 1){
				if(isset($array[$i]["name"]) AND isset($array[$i]["prefecture"])){
					array_push($miseru, $array[$i]);
				}	
			}
		}
		$_SESSION['array'] = $miseru;	
	}

	//ページング
	define('MAX', 5); //1ページ当たりの表示件数
	$data_num = count($_SESSION['array']); //データ数
	$page_num = ceil($data_num / MAX); //ページ数

	if(!isset($_GET['page_id'])){
		$now = 1;
	}else{
		$now = $_GET['page_id'];
	}

	$start_no = ($now - 1) * MAX; //配列の何番目から取得するかの添え字
	$disp_data = array_slice($_SESSION['array'], $start_no, MAX, true); //表示用配列
?>
<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<title>検索結果</title>
	<link rel="stylesheet" href="result.css">
</head>

<body class="kensaku">


	<main>
		<div class="title">
			<h1>検索結果</h1>
			<header>
				<nav>
					<ul>
						<li><a href="../TOPPAGE/TOP.html">TOP</a></li>
						<li><a href="../DETAILPAGE/detail.php">詳細</a></li>
					</ul>
				</nav>
			</header>
			<!-- パンくずリスト -->
			<ol>
				<li><a href="../TOPPAGE/TOP.html">TOP</a></li>
				<li>検索結果</li>
			</ol>
		</div>

		<!-- ひだりの枠 -->

		<div class="left-column">

			<div class="jouken">
				<form action="../RESULTPAGE/result.php" method="post">
					<div>
						<h2>選択した条件</h2>

						検索条件<br>
						エリア <?php
if (isset($_POST['riyu'])) {
    $riyu = implode(", ", $_POST["riyu"]);
    echo $riyu ;
} else {
    echo 'チェックされていません。<br>';
}
?><br>
						<!-- 検索条件・エリア -->
						<form method="post" action="check.php">
							<ul>
								<input type="checkbox" name="riyu[]" value="北海道">北海道
								<div id="area1" style="display:none">
								</div><br>
<!-- 折り畳み展開ポインタ -->
								<a>▼ 東北</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="open">
									<input type="checkbox" name="riyu[]" value="青森">青森
									<input type="checkbox" name="riyu[]" value="秋田">秋田
									<input type="checkbox" name="riyu[]" value="岩手">岩手
									<input type="checkbox" name="riyu[]" value="山形">山形
									<input type="checkbox" name="riyu[]" value="宮城">宮城
									<input type="checkbox" name="riyu[]" value="福島">福島
								</div>
<!-- 折り畳み展開ポインタ -->
								<div onclick="obj=document.getElementById('kantou').style; obj.display=(obj.display=='none')?'block':'none';">
									<a style="cursor:pointer;">▼関東</a>
								</div>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="kantou" style="display:none;clear:both;">
									<input type="checkbox" name="riyu[]" value="群馬">群馬
									<input type="checkbox" name="riyu[]" value="栃木">栃木
									<input type="checkbox" name="riyu[]" value="茨城">茨城
									<input type="checkbox" name="riyu[]" value="千葉">千葉
									<input type="checkbox" name="riyu[]" value="埼玉">埼玉
									<input type="checkbox" name="riyu[]" value="東京">東京
									<input type="checkbox" name="riyu[]" value="神奈川">神奈川
								</div>

<!-- 折り畳み展開ポインタ -->
								<a>▼ 中部・関東</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="chuubu">
									<input type="checkbox" name="riyu[]" value="長野">長野
									<input type="checkbox" name="riyu[]" value="山梨">山梨
									<input type="checkbox" name="riyu[]" value="静岡">静岡
									<input type="checkbox" name="riyu[]" value="愛知">愛知
									<input type="checkbox" name="riyu[]" value="岐阜">岐阜
									<input type="checkbox" name="riyu[]" value="三重">三重
								</div>
<!-- 折り畳み展開ポインタ -->
								<a>▼ 北陸</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="hokuriku">
									<input type="checkbox" name="riyu[]" value="新潟">新潟
									<input type="checkbox" name="riyu[]" value="富山">富山
									<input type="checkbox" name="riyu[]" value="石川">石川
									<input type="checkbox" name="riyu[]" value="福井">福井
								</div>

<!-- 折り畳み展開ポインタ -->
								<a>▼ 近畿</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="kinki">
									<input type="checkbox" name="riyu[]" value="滋賀">滋賀
									<input type="checkbox" name="riyu[]" value="奈良">奈良
									<input type="checkbox" name="riyu[]" value="京都">京都
									<input type="checkbox" name="riyu[]" value="大阪">大阪
									<input type="checkbox" name="riyu[]" value="和歌山">和歌山
									<input type="checkbox" name="riyu[]" value="兵庫">兵庫
								</div>
<!-- 折り畳み展開ポインタ -->
								<a>▼ 中国</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="chuugoku">
									<input type="checkbox" name="riyu[]" value="鳥取">鳥取
									<input type="checkbox" name="riyu[]" value="岡山">岡山
									<input type="checkbox" name="riyu[]" value="島根">島根
									<input type="checkbox" name="riyu[]" value="広島">広島
									<input type="checkbox" name="riyu[]" value="山口">山口
								</div>
<!-- 折り畳み展開ポインタ -->
								<a>▼ 四国</a>

								<!-- 折り畳まれ部分 -->
								<div class="abc" id="sikoku">
									<input type="checkbox" name="riyu[]" value="香川" >香川
									<input type="checkbox" name="riyu[]" value="徳島" >徳島
									<input type="checkbox" name="riyu[]" value="高知" >高知
									<input type="checkbox" name="riyu[]" value="愛媛" >愛媛
								</div>
<!-- 折り畳み展開ポインタ -->
								<a>▼ 九州</a>
								<!-- 折り畳まれ部分 -->
								<div class="abc" id="kyuushuu">
									<input type="checkbox" name="riyu[]" value="福岡" >福岡
									<input type="checkbox" name="riyu[]" value="佐賀" >佐賀
									<input type="checkbox" name="riyu[]" value="長崎" >長崎
									<input type="checkbox" name="riyu[]" value="大分" >大分
									<input type="checkbox" name="riyu[]" value="熊本" >熊本
									<input type="checkbox" name="riyu[]" value="宮崎" >宮崎
									<input type="checkbox" name="riyu[]" value="鹿児島" >鹿児島
								</div>
								<input type="checkbox" name="riyu[]" value="沖縄">沖縄<br>

								
							</ul>
						</form>
						条件<br>
						<?php
if (isset($_POST['tokucho'])) {
    $tokucho = implode(", ", $_POST["tokucho"]);
    echo  $tokucho ;
} else {
    echo 'チェックされていません。<br>';
}
?>
						<!-- 検索条件・条件 -->
									<ul>
										<!-- 折り畳み展開ポインタ -->
										<a>▼ 泉質</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="sensitu">
											<input type="checkbox" name="tokucho[]" value="単純温泉">単純温泉
											<input type="checkbox" name="tokucho[]" value="塩化物泉">塩化物泉
											<input type="checkbox" name="tokucho[]" value="硫黄泉">硫黄泉
											<input type="checkbox" name="tokucho[]" value="硫酸塩泉">硫酸塩泉
											<input type="checkbox" name="tokucho[]" value="炭酸水素塩泉">炭酸水素塩泉
											<input type="checkbox" name="tokucho[]" value="放射能泉">放射能泉
										</div>

										<!-- 折り畳み展開ポインタ -->
										<a>▼ 温泉の色</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="iro">
											<input type="checkbox" name="tokucho[]" value="無色透明">無色透明
											<input type="checkbox" name="tokucho[]" value="白色">白
											<input type="checkbox" name="tokucho[]" value="赤褐色">赤褐色
											<input type="checkbox" name="tokucho[]" value="黄褐色">黄褐色
											<input type="checkbox" name="tokucho[]" value="緑色">緑
											<input type="checkbox" name="tokucho[]" value="茶褐色">茶褐色
											<input type="checkbox" name="tokucho[]" value="乳白色">乳白色
											<input type="checkbox" name="tokucho[]" value="青色">青
										</div>


										<!-- 折り畳み展開ポインタ -->
										<a>▼ 日帰り入浴</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="nyuuyoku">
											<input type="checkbox" name="tokucho[]" value="可">あり
											<input type="checkbox" name="tokucho[]" value="否">なし
										</div>

										<!-- 折り畳み展開ポインタ -->
										<a>▼ 素泊まり</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="sudomari">
											<input type="checkbox" name="tokucho[]" value="可">あり
											<input type="checkbox" name="tokucho[]" value="不可">なし
										</div>


										<!-- 折り畳み展開ポインタ -->
										<a>▼ 1名宿泊</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="shukuhaku">
											<input type="checkbox" name="tokucho[]" value="可">あり
											<input type="checkbox" name="tokucho[]" value="不可">なし
										</div>

										<!-- 折り畳み展開ポインタ -->
										<a>▼ 掛け流し</a>
										<!-- 折り畳まれ部分 -->
										<div class="abc" id="kakenagasi">
											<input type="checkbox" name="tokucho[]" value="有">あり
											<input type="checkbox" name="tokucho[]" value="無">なし
										</div>

									</ul>
						<p class="submit"><input type="submit" name="submit" value="再検索"></p>
					</div>
				</form>
			</div>

			<form action="../TOPPAGE/TOP.html" method="post">

				<p class="submit2"><input type="submit" name="submit2" value="戻る"></p>
			</form>
		</div>

		<!-- ここから検索結果 -->

		<div class="right-column">

			<div class="kekka">
					<h2>検索結果</h2>
						<?php
							$a = $start_no;
							$err_flag = 0;
							foreach($disp_data as $val){
								$no = $a + 1; //表示用添え字
								
								//温泉名、都道府県がnullならエラーログ
								if(!isset($val['name']) OR !isset($val['prefecture'])){
									echo "<div>{$no}. ごめんなさい、データを表示できませんでした。</div>";
									continue;
								}
								
								echo '<div class="oneOfKekka">';
								echo '<div><form method="post" name="form'."{$a}".'" action="../DETAILPAGE/detail.php">';
								echo "{$no}. {$val['name']} ({$val['prefecture']})</div>";
								
								echo '<div><input type="hidden" name="onsen"'." value='{$val["id"]}'>";
								echo '<a href="#" onclick="document.form'."{$a}".'.submit();">';
								echo "<img src={$val["image"]}".' width="250px" height="190px">';
								echo '</img></a></form></div>';
								echo '</div><br>';
								$a++;
							}
							echo '<br>';
							for($i = 1; $i <= $page_num; $i++){ // 最大ページ数分リンクを作成
									if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
											echo $now. '　'; 
									} else {
											echo "<a href='../RESULTPAGE/result.php?page_id=". $i. "'>". $i. '</a>'. '　';
									}
							}
						?>
			</div>
		</div>

	</main>
</body>

</html>
