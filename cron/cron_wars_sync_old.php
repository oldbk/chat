<?
$_SERVER['REMOTE_ADDR'] = "127.0.0.1";
include '/www/chat.oldbk.com/connect.php';

	//синхронизация войн
	$handle = opendir('/www_logs/combats_wars/');
	$sync_wars=array();
	while (false !== ($entry = readdir($handle))) 
	{
		if($entry!='.'&& $entry!='..')
		{
	        	$load = file("/www_logs/combats_wars/".$entry);
	        	$sync_wars[$entry]=$load[0]; //читаем все что есть в авалоне из войн
	        }
    	}
    	
	$data=mysql_query("SELECT * FROM  oldbk.clans_war_city_sync where stime<=NOW()");//смотрим что в кепе есть или появилось
	while($row=mysql_fetch_assoc($data))
	{
		$save = fopen("/www_logs/combats_wars/".$row[name],"w");//обновляем войны в аваоне (так как война может дописаться для клана)
		fwrite($save,$row[war_with]);
		unset($sync_wars[$row[name]]);//удаляем из масива имеющийся в городе войн, дописаный клан			
	}
	
	if((count($sync_wars)>0))//если что то осталось в городе, значит война кончилась. и ее надо удалить в городе
	{
		foreach($sync_wars as $k=>$v)
		{
			unlink("/www_logs/combats_wars/".$k); // удаляем файл войны
		}	
	}
echo date("Y-m-d H:i:s");
echo "- ok \n";
?>