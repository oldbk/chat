<?
$_SERVER['REMOTE_ADDR'] = "127.0.0.1";
include '/www/chat.oldbk.com/connect.php';

//wtf? mb clear file.
$text = '';
$odate=file('/www/otime.txt');
$prep_array=array();

echo date("Y-m-d H:i:s");
echo "\n";
echo "Odate:";
echo "\n";
echo "INPUT IDS:";
echo count($odate);
echo "\n";
	foreach($odate as $k => $id)
	{
	
	if ( (!(in_array($id,$prep_array)))  and ($id>0)  )
		{
		$prep_array[]=$id;
		}
	
	}
echo "UNIC IDS:";	
echo count($prep_array);
echo "\n";
if(count($prep_array) > 0) {
	mysql_query("UPDATE `users` SET `odate` = ".time()." WHERE `id`  IN (".implode(",",$prep_array).")");
}
echo "UPDATE IDS:";	
echo mysql_affected_rows();

	$fp = fopen ("/www/otime.txt","w"); //открытие
	flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
	fputs($fp , $text."\n"); //работа с файлом
	fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
	flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
	fclose ($fp); //закрытие

echo "\n";


$ldate=file('/www/ltime.txt');
$prep_array=array();

echo "Ldate:";
echo "\n";
echo "INPUT IDS:";
echo count($ldate);
echo "\n";
	foreach($ldate as $k => $id)
	{
	
	if ( (!(in_array($id,$prep_array)))  and ($id>0)  )
		{
		$prep_array[]=$id;
		}
	
	}
echo "UNIC IDS:";	
echo count($prep_array);
echo "\n";
if(count($prep_array) > 0) {
	mysql_query("UPDATE `users` SET `ldate` = ".time()." WHERE `id`  IN (".implode(",",$prep_array).")");
}

echo "UPDATE IDS:";	
echo mysql_affected_rows();

	$fp = fopen ("/www/ltime.txt","w"); //открытие
	flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
	fputs($fp , $text."\n"); //работа с файлом
	fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
	flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
	fclose ($fp); //закрытие

echo "\n-----------------------------\n";

?>