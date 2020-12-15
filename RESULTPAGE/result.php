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
			<li><a href="TOP.html">TOP</a></li>
			<li>検索結果</li>
		</ol>
	</div>
	<div class="jouken">
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
?></td></tr>
                    <tr><th>条件</th>
						<td><?php
if (isset($_POST['tokucho'])) {
    $tokucho = implode(", ", $_POST["tokucho"]);
    echo  $tokucho ;
} else {
    echo 'チェックされていません。<br>';
}
?></td></tr>
                </table>
						<form action="" method="post">
						
					      <p class="submit"><input type="submit" name="submit" value="再検索"></p>
					</form>
		</div>
	</div>
			<div class="kekka">
				<div>
                <h2>検索結果</h2>
                <dl>
                <dt>1</dt><dd>東京都大田区蒲田</dd>
                <dt>2</dt><dd>モンスト</dd>
                <dt>3</dt><dd>パズドラ</dd>
                </dl>
                <p>※kekkaはホームページで随時お知らせします。</p>
            </div>
			</div>
	<form action="phpを記入" method="post">
						
					      <p class="submit2"><input type="submit" name="submit2" value="戻る"></p>
					</form>
	</main>
	</body>
</html>