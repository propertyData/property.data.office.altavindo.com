<?php

require ('config.php');

// jika ada parameter yang dilempar dari script index.php
// maka lakukan pencarian
if (isset($_GET['kab'])) {
	$id = $_GET['kab'];
	$sql = "SELECT * from `cabang` WHERE `kabkota` = '".$id."'";
} else {
	// kalo ga, tampilkan semua lokasi
	$sql = "SELECT * from `cabang`";
}

$data = mysql_query($sql);
$json = '{"warteg": {';
$json .= '"cabang":[ ';
while($x = mysql_fetch_array($data)){
	$json .= '{';
	$json .= '"idcabang":"'.$x['id'].'",
		"nama_cabang":"'.htmlspecialchars($x['nama_cabang']).'",
		"x":"'.$x['lat'].'",
		"y":"'.$x['long'].'"
	},';
}
$json = substr($json,0,strlen($json)-1);
$json .= ']';
$json .= '}}';

echo $json;

?>
