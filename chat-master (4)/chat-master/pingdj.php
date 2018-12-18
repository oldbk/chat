<?php
	include 'connect.php';

	function addchp ($text,$who,$room=0,$city=-1) {
		$city=$city+1;

		$txt_to_file=":[".time()."]:[{$who}]:[".($text)."]:[".$room."]";
		$room = -1;

		$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='".($city)."', `room`={$room} ;");
		if ($q !== FALSE) {
			return true;
		}
		return false;
	}

	
	if (!isset($_GET['key']) || $_GET['key'] != "4654272uw4atsr537q43") die();
	if (!isset($_GET['alias']) || empty($_GET['alias'])) die();
	if (!isset($_GET['login']) || empty($_GET['login'])) die();

	if(addchp ('<font color=red>Внимание!</font> <a href="http://blog.oldbk.com/radio/request/'.rawurlencode($_GET['alias']).'.html" target="_blank">http://blog.oldbk.com/radio/request/'.rawurlencode($_GET['alias']).'.html','{[]}'.$_GET['login'].'{[]}',-1,-1)) {
		echo "OK";
	} else{
		echo 'FALSE';
	}

?>