<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 20.09.17
 * Time: 16:52
 */

if(isset($_GET['key']) && $_GET['key'] == 'Nbg1kRvwb81Q') {
	require_once __DIR__.'/memcache.php';
	require_once __DIR__.'/classes/ConfigKo.php';
	global $memcache;
	$ConfigKo = ConfigKo::init($memcache);

	echo $ConfigKo->invalidate();
} else {
	echo 'error';
}