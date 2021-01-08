<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<title>検索結果</title>
		<link rel="stylesheet" href="result.css">
	</head>
<body class="kensaku">
<header>
	<nav>
		<ul>
			<li><a href="../TOPPAGE/TOP.html">TOP</a></li>
			<li><a href="../DETAILPAGE/detail.php">詳細</a></li>
		</ul>
	</nav>
	</header>

<main>
	<div class="title">
		<h1>検索結果</h1>
		<ol>
			<li><a href="../TOPPAGE/TOP.html">TOP</a></li>
			<li>検索結果</li>
		</ol>
	</div>
    
    <!-- みだりの枠 -->
    
    <div class="left-column">
        
	<div class="jouken">
			<form action="../RESULTPAGE/result.php" method="post">
		<div>
             <h2>選択した条件</h2>
                <table>
                    <tr><th></th><th>検索条件</th></tr>
					<tr><th>エリア</th>
						<td>	<?php
if (isset($_POST['riyu'])) {
    $riyu = implode(", ", $_POST["riyu"]);
    echo $riyu ;
} else {
    echo 'チェックされていません。<br>';
}
?><br>
<form method="post" action="check.php">
    <ul>
	<input type="checkbox" name="riyu[]" value="北海道">北海道
	<div id="area1" style="display:none">
	</div><br>
	
	<input type="checkbox" onClick="a2.display=(this.checked?'':'none')">東北
<div id="area2" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="青森" class="zisage">青森
 <input type="checkbox" name="riyu[]" value="秋田" class="zisage">秋田
 <input type="checkbox" name="riyu[]" value="岩手" class="zisage">岩手
 <input type="checkbox" name="riyu[]" value="山形" class="zisage">山形
 <input type="checkbox" name="riyu[]" value="宮城" class="zisage">宮城
 <input type="checkbox" name="riyu[]" value="福島" class="zisage">福島
</div><br>

	<input type="checkbox" onClick="a3.display=(this.checked?'':'none')">関東
	<div id="area3" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="群馬">群馬
 <input type="checkbox" name="riyu[]" value="栃木">栃木
 <input type="checkbox" name="riyu[]" value="茨城">茨城
 <input type="checkbox" name="riyu[]" value="千葉">千葉
 <input type="checkbox" name="riyu[]" value="埼玉">埼玉
 <input type="checkbox" name="riyu[]" value="東京">東京
 <input type="checkbox" name="riyu[]" value="神奈川">神奈川
	</div><br>

		
	<input type="checkbox" onClick="a4.display=(this.checked?'':'none')">中部・東海
	<div id="area4" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="長野">長野
 <input type="checkbox" name="riyu[]" value="山梨">山梨
 <input type="checkbox" name="riyu[]" value="静岡">静岡
 <input type="checkbox" name="riyu[]" value="愛知">愛知
 <input type="checkbox" name="riyu[]" value="岐阜">岐阜
 <input type="checkbox" name="riyu[]" value="三重">三重
		</div><br>
		
	<input type="checkbox" onClick="a5.display=(this.checked?'':'none')">北陸
	<div id="area5" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="新潟">新潟
 <input type="checkbox" name="riyu[]" value="富山">富山
 <input type="checkbox" name="riyu[]" value="石川">石川
 <input type="checkbox" name="riyu[]" value="福井">福井
		</div><br>

	
	<input type="checkbox" onClick="a6.display=(this.checked?'':'none')">近畿
	<div id="area6" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="滋賀">滋賀
 <input type="checkbox" name="riyu[]" value="奈良">奈良
 <input type="checkbox" name="riyu[]" value="京都">京都
 <input type="checkbox" name="riyu[]" value="大阪">大阪
 <input type="checkbox" name="riyu[]" value="和歌山">和歌山
 <input type="checkbox" name="riyu[]" value="兵庫">兵庫
		</div><br>
	
	<input type="checkbox" onClick="a7.display=(this.checked?'':'none')">中国
	<div id="area7" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="鳥取">鳥取
 <input type="checkbox" name="riyu[]" value="岡山">岡山
 <input type="checkbox" name="riyu[]" value="島根">島根
 <input type="checkbox" name="riyu[]" value="広島">広島
 <input type="checkbox" name="riyu[]" value="山口">山口
		</div><br>
	
		<input type="checkbox" onClick="a8.display=(this.checked?'':'none')">四国
	<div id="area8" style="display:none">
&ensp; <input type="checkbox" name="riyu[]" value="香川">香川
 <input type="checkbox" name="riyu[]" value="徳島">徳島
 <input type="checkbox" name="riyu[]" value="高知">高知
 <input type="checkbox" name="riyu[]" value="愛媛">愛媛
		</div><br>
		
		<input type="checkbox" onClick="a9.display=(this.checked?'':'none')">九州
	<div id="area9" style="display:none">
&ensp; 
<input type="checkbox" name="riyu[]" value="福岡">福岡
 <input type="checkbox" name="riyu[]" value="佐賀">佐賀
 <input type="checkbox" name="riyu[]" value="長崎">長崎
 <input type="checkbox" name="riyu[]" value="大分">大分
 <input type="checkbox" name="riyu[]" value="熊本">熊本
 <input type="checkbox" name="riyu[]" value="宮崎">宮崎
 <input type="checkbox" name="riyu[]" value="鹿児島">鹿児島
		</div><br>
		
		<input type="checkbox" name="riyu[]" value="沖縄">沖縄<br>

	<script language="javascript">
a1=document.getElementById('area1').style
a2=document.getElementById('area2').style
a3=document.getElementById('area3').style
a4=document.getElementById('area4').style
a5=document.getElementById('area5').style
a6=document.getElementById('area6').style
a7=document.getElementById('area7').style
a8=document.getElementById('area8').style
a9=document.getElementById('area9').style
	</script>
	</ul></form></td></tr>
                    <tr><th>条件</th>
						<td><?php
if (isset($_POST['tokucho'])) {
    $tokucho = implode(", ", $_POST["tokucho"]);
    echo  $tokucho ;
} else {
    echo 'チェックされていません。<br>';
}
?>


<ul>
<!-- 折り畳まれる部分 -->

	<input type="checkbox" name="tokucho[]" value="大浴場">大浴場<br>
	<input type="checkbox" name="tokucho[]" value="足湯">足湯<br>
	<input type="checkbox" name="tokucho[]" value="露天風呂">露天風呂<br>
	<input type="checkbox" name="tokucho[]" value="混浴">混浴<br>
	<input type="checkbox" name="tokucho[]" value="夕食付">夕食付き<br>
</ul>
						</td></tr>
					<tr><th>フリーワード</th>
                        <td><?php
if (empty($_POST['in01'])){
    echo '入力されていません。<br>';
}else {
    $in01 = $_POST['in01'];
    echo $in01;
}
?></td></tr>
                </table>

						
					<p class="submit"><input type="submit" name="submit" value="再検索"></p>
				</div></form>
		</div>
        
        <form action="../TOPPAGE/TOP.html" method="post">
						
					      <p class="submit2"><input type="submit" name="submit2" value="戻る"></p>
					</form>
        </div>
    
    <!-- ここから検索結果 -->
    
        <div class="right-column">
            
			<div class="kekka">
				<div>
                <h2>検索結果</h2>
                <dl>
                <dt>1</dt><dd><?php
if (isset($_POST['riyu'])) {
    $riyu = implode(", ", $_POST["riyu"]);
    echo $riyu ;
} else {
    echo 'チェックされていません。<br>';
}
?></dd>
				<dt></dt><dd><?php
if (isset($_POST['tokucho'])) {
    $tokucho = implode(", ", $_POST["tokucho"]);
    echo  $tokucho ;
} else {
    echo 'チェックされていません。<br>';
}
?></dd>
                <dt>2</dt><dd>モンスト</dd>
                <dt>3</dt><dd>パズドラ</dd>
                </dl>
                <p>※kekkaはホームページで随時お知らせします。</p>
            </div>
			</div>
            
    </div>
	
	</main>
	</body>
</html>