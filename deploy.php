<?php
if( $_GET["u"]=="pichayuth" && $_GET["p"]=="9090A" && $_GET["m"]=="69cee9970ec7fbafe87e719773b1fc7d" ){
	$branch = empty($isTest)?"master":$isTest;
	echo "<pre>";
	system("sudo git pull origin {$branch}");	
	echo "</pre>";
}else{
	header("Location: index.php");
}
?>
