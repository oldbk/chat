<?php
///ini_set("display_errors",1);
//error_reporting(E_ALL);
if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
	$miniBB_gzipper_encoding = 'x-gzip';
}
if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
	$miniBB_gzipper_encoding = 'gzip';
}
if (isset($miniBB_gzipper_encoding)) {
	ob_start();
}
function percent($a, $b) {
	$c = $b/$a*100;
	return $c;
}

session_start();

if (!($_SESSION['uid'] >0)) {
	echo "<script>top.window.location='http://capitalcity.oldbk.com/index.php?exit=0.560057875997465.{$_SESSION['uid']}.000.{$_COOKIE['battle']}'</script>";
	die();
}

header("Cache-Control: no-cache");
header('Content-Type: text/html; charset=windows-1251');
include 'connect.php';
include 'memcache.php';
		
		//$getdata=mysql_query("select * from oldbk.new_updates where hide=0 order by top desc , cdate limit 500; ");
		//$getdata=mysql_query_cache("Select * from oldbk.new_updates where hide=0 order  by top desc , cdate limit 100,10",false,1);
		$getdata=mysql_query_cache("Select * from oldbk.new_updates where hide=0 order  by top asc , cdate desc limit 10",false,1);		

		if (count($getdata) > 0) 
		{
		sort($getdata);
		reset($getdata);
			while(list($k,$row) = each($getdata)) 
			{
				$phpdate = strtotime($row['cdate']);
					echo "<span class=date>".date( 'd-m-Y H:i:s', $phpdate )."</span> <span class=stext id=news".$row['id'].">".$row['message']."</span><br>";
			}			
		}
		

		



if (isset($miniBB_gzipper_encoding)) 
{
$miniBB_gzipper_in = ob_get_contents();
$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
$percent = round($gzpercent);
$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' Ñompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
ob_clean();
header('Content-Encoding: '.$miniBB_gzipper_encoding);
echo $miniBB_gzipper_out;
die();
}
?>