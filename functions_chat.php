<?
define("olddelo",0); //включена работа старого дела - объявляем ее так шоб она была видна везде где можно
include "configcity.php"; // подключаем настройки города

$db_city[0]='oldbk.';
$db_city[1]='avalon.';
$db_city[2]='angels.';
$city_name[0]='CapitalCity';
$city_name[1]='AvalonCity';
$city_name[2]='AngelsCity';
header("Cache-Control: no-cache");
$ip = $_SERVER['REMOTE_ADDR'];
require_once('memcache.php');

	$rooms = array ("Секретная Комната","Комната для новичков","Комната для новичков 2","Комната для новичков 3","Комната для новичков 4","Зал Воинов 1","Зал Воинов 2","Зал Воинов 3","Торговый зал",
	"Рыцарский зал","Башня рыцарей-магов","Колдовской мир","Этажи духов","Астральные этажи","Огненный мир","Зал Паладинов","Совет Белого Братства","Зал Тьмы","Царство Тьмы","Будуар",
	"Центральная площадь","Страшилкина улица","Магазин","Ремонтная мастерская","Новогодняя елка","Комиссионный магазин","Парковая улица","Почта","Регистратура кланов","Банк","Суд",
	"Башня смерти","Готический замок","Лабиринт хаоса","Цветочный магазин","Магазин 'Березка'","Зал Стихий","Готический замок - приемная","Готический замок - арсенал","Готический замок - внутренний двор",
	"Готический замок - мастерские","Готический замок - комнаты отдыха","Лотерея Сталкеров","Комната Знахаря","Комната №44","Вход в Лабиринт Хаоса","Прокатная лавка","Арендная лавка","Храмовая лавка","Храм Короля Артура","Замковая площадь",
	"Большая скамейка","Средняя скамейка","Маленькая скамейка","Зал Света","Царство Света","Царство Стихий","Зал клановых войн","Комната №58","Комната №59","Арена Богов","Комната №61","Комната №62","Комната №63","Комната №64","Комната №65","66"=>'Торговая улица',
"200"=> "Ристалище",

//Ломбард
"70" => "Ломбард",
"71" => "Аукцион",
"72" => "Ярмарка",
"75" => "Кабинет",
"76" => "Бои классов",
//
"80" => "Помойка",
"90" => "Замок Лорда Разрушителя",
"91" => "Кузница", // с 91 и по 97 забрал на крафты и 191 на улицу мастеров
"92" => "Таверна",
"93" => "Лаборатория магов и алхимиков",
"94" => "Мастерская ювелиров и портных",
"95" => "Мастерская плотника",
"96" => "Башня оружейников",
"191" => "Улица Мастеров",

//турниры
"197"=>"Оружейная Комната",
"198"=>"Оружейная Комната",
"199"=>"Оружейная Комната",

"270"=>"Вход в Одиночные сражения",
"271"=> "Одиночные сражения[1]",
"272"=> "Одиночные сражения[2]",
"273"=> "Одиночные сражения[3]",
"274"=> "Одиночные сражения[4]",
"275"=> "Одиночные сражения[5]",
"276"=> "Одиночные сражения[6]",
"277"=> "Одиночные сражения[7]",
"278"=> "Одиночные сражения[8]",
"279"=> "Одиночные сражения[9]",
"280"=> "Одиночные сражения[10]",
"281"=> "Одиночные сражения[11]",
"282"=> "Одиночные сражения[12]",
// Групповое сражение
"240"=>"Вход в Групповые сражения",
"241"=> "Групповое сражение[1]",
"242"=> "Групповое сражение[2]",
"243"=> "Групповое сражение[3]",
"244"=> "Групповое сражение[4]",
"245"=> "Групповое сражение[5]",
"246"=> "Групповое сражение[6]",
"247"=> "Групповое сражение[7]",
"248"=> "Групповое сражение[8]",
"249"=> "Групповое сражение[9]",
"250"=> "Групповое сражение[10]",
"251"=> "Групповое сражение[11]",
"252"=> "Групповое сражение[12]",
"253"=> "Групповое сражение[13]",
//Сражение отрядов
"210"=>"Вход в Сражения отрядов",
"211"=> "Сражение отрядов[1]",
"212"=> "Сражение отрядов[2]",
"213"=> "Сражение отрядов[3]",
"214"=> "Сражение отрядов[4]",
"215"=> "Сражение отрядов[5]",
"216"=> "Сражение отрядов[6]",
"217"=> "Сражение отрядов[7]",
"218"=> "Сражение отрядов[8]",
"219"=> "Сражение отрядов[9]",
"220"=> "Сражение отрядов[10]",
"221"=> "Сражение отрядов[11]",
"222"=> "Сражение отрядов[12]",
"223"=> "Сражение отрядов[13]",


//Бои с пойманными монстрами
"300" => "Бои с пойманными монстрами",

//Клан замок 400-450
"400" => "Клановый замок",
"401" => "Вход в Клановый турнир",
"402" => "Клановый турнир",

// БС
"501" => "Восточная Крыша",
"502" => "Бойница",
"503" => "Келья 3",
"504" => "Келья 2",
"505" => "Западная Крыша 2",
"506" => "Келья 4",
"507" => "Келья 1",
"508" => "Служебная комната",
"509" => "Зал Отдыха 2",
"510" => "Западная Крыша 1",
"511" => "Выход на Крышу",
"512" => "Зал Статуй 2",
"513" => "Храм",
"514" => "Восточная комната",
"515" => "Зал Отдыха 1",
"516" => "Старый Зал 2",
"517" => "Старый Зал 1",
"518" => "Красный Зал 3",
"519" => "Зал Статуй 1",
"520" => "Зал Статуй 3",
"521" => "Трапезная 3",
"522" => "Зал Ожиданий",
"523" => "Оружейная",
"524" => "Красный Зал-Окна",
"525" => "Красный Зал",
"526" => "Гостинная",
"527" => "Трапезная 1",
"528" => "Внутренний Двор",
"529" => "Внутр.Двор-Вход",
"530" => "Желтый Коридор",
"531" => "Мраморный Зал 1",
"532" => "Красный Зал 2",
"533" => "Библиотека 1",
"534" => "Трапезная 2",
"535" => "Проход Внутр. Двора",
"536" => "Комната с Камином",
"537" => "Библиотека 3",
"538" => "Выход из Мрам.Зала",
"539" => "Красный Зал-Коридор",
"540" => "Лестница в Подвал 1",
"541" => "Южный Внутр. Двор",
"542" => "Трапезная 4",
"543" => "Мраморный Зал 3",
"544" => "Мраморный Зал 2",
"545" => "Картинная Галерея 1",
"546" => "Лестница в Подвал 2",
"547" => "Проход Внутр. Двора 2",
"548" => "Внутр.Двор-Выход",
"549" => "Библиотека 2",
"550" => "Картинная Галерея 3",
"551" => "Картинная Галерея 2",
"552" => "Лестница в Подвал 3",
"553" => "Терасса",
"554" => "Оранжерея",
"555" => "Зал Ораторов",
"556" => "Лестница в Подвал 4",
"557" => "Темная Комната",
"558" => "Винный Погреб",
"559" => "Комната в Подвале",
"560" => "Подвал" ,
"600" => "Темница",

"10000" => "Башня смерти",
"999" => "Вход в Руины",
"61000" => "Вокзал",
"72001" => "Замковые турниры",
"72002" => "Осада замка",
);

if (CITY_ID == 0) {
	$rooms[49] = "Храм Древних";
}

function get_mag_stih($telo,$effect=null)
{
 					if ($telo['smagic']==0)
					{
					$dt=$telo['borndate'];
					$out_array=array();
					$month=substr($dt,3,2);
					$day=substr($dt,0,2);
				
					$month=(int)$month;
					$day=(int)$day;
				
					  if ($month == 1) {
				         if ($day >= 21) {$zodik=11;} else {$zodik=10;}}
				      else if ($month == 2) {
				         if ($day >= 21) {$zodik=12;} else {$zodik=11;} }
				       else if ($month == 3) {
				         if ($day >= 21) {$zodik=1;} else {$zodik=12;} }
				       else if ($month == 4) {
				         if ($day >= 21) {$zodik=2;} else {$zodik=1;} }
				       else if ($month == 5) {
				         if ($day >= 21) {$zodik=3;} else {$zodik=2;} }
				       else if ($month == 6) {
				         if ($day >= 22) {$zodik=4;} else {$zodik=3;} }
				       else if ($month == 7) {
				         if ($day >= 23) {$zodik=5;} else {$zodik=4;} }
				       else if ($month == 8) {
				         if ($day >= 24) {$zodik=6;} else {$zodik=5;} }
				       else if ($month == 9) {
				         if ($day >= 24) {$zodik=7;} else {$zodik=6;} }
				       else if ($month == 10) {
				         if ($day >= 24) {$zodik=8;} else {$zodik=7;} }
				       else if ($month == 11) {
				         if ($day >= 23) {$zodik=9;} else {$zodik=8;} }
				       else if ($month == 12) {
				         if ($day >= 22) {$zodik=10;} else {$zodik=9;}}
				         
				         
				         if (($zodik==1) OR ($zodik==5) OR ($zodik==9) )
				         {
				         $out_array[]=1; // Огонь (Овен, Лев, Стрелец)
				         }
				         else if (($zodik==2) OR ($zodik==6) OR ($zodik==10))
				         {
				         $out_array[]=2; // Земля (Козерог. Телец, Дева)
				         }
				         else if (($zodik==3) OR ($zodik==7) OR ($zodik==11))
				         {
				         $out_array[]=3; //Воздух (Весы, Водолей, Близнецы)
				         }
				         else if (($zodik==4) OR ($zodik==8) OR ($zodik==12) )
				         {
				         $out_array[]=4; //Вода (Рак, Скорпион, Рыбы)
				         } 
				        }
				        else
				        {
					$out_array[]=$telo['smagic']; //родная магия ставится из базы а не вычисляется от даты рождения как было до 20/02/2016				        
				        }
        
        
        //дополнительные 
         if (is_array($effect[10901]))
         	{
	         $out_array[]=1; // Огонь (Овен, Лев, Стрелец)         	
         	}
	elseif (is_array($effect[10902]))
         	{
	         $out_array[]=2; // Земля (Козерог. Телец, Дева)
         	}         	
	elseif (is_array($effect[10903]))
         	{
         	$out_array[]=3; //Воздух (Весы, Водолей, Близнецы)
         	}     
	elseif (is_array($effect[10904]))
         	{
	         $out_array[]=4; //Вода (Рак, Скорпион, Рыбы)
         	}              	    	         
         	
 return $out_array;        
}


	function GetSalt(&$salt,$len) {
		$ret = substr($salt,0,$len);
		$salt = substr($salt,$len);
		return $ret;
	}


	function xorit($input) {
		for ($i = 0; $i < strlen($input); $i++) {
			$input[$i] = chr(ord($input[$i]) ^ 0xAF);
		}
		return base64_encode($input);
	}

	function codein($input) {
		$input = strval($input);
		$salt = "b42q9y";
		$salt = sha1($input.$salt).sha1($input.$input.$salt).sha1($input.$salt.sha1($input));
		$salt = preg_replace('~[a-z]~iU','',$salt);
	
		$kol=strlen($input);
		$input=strrev($input);
		$to_out = "";
		$c=0;
		for ($x=0; $x<$kol; $x++) {
 			$c++;
			if ($c==1)  { $to_out.=GetSalt($salt,1).$input[$x]; }
			else  if ($c==2)  { $to_out.=GetSalt($salt,2).$input[$x]; }
			else  if ($c==3)  { $to_out.=GetSalt($salt,3).$input[$x]; $c=0;} 
		}
		return $to_out;
	}


function open_clan_war_files($klan_short)
	{
       	if (!file_exists("/www/logs/combats_wars/".$klan_short))
		{
			return FALSE;
		}
		else
		{
			$load = file("/www/logs/combats_wars/".$klan_short);
			return $load;
        }
	}



function addchp ($text,$who,$room=0,$city=-1) {
			global $user;
			if ($room==0) {
				$room = $user['room'];
			}


			$city=$city+1;


			$txt_to_file=":[".time()."]:[{$who}]:[".($text)."]:[".$room."]";
			$room=-1; // TEST only by Fred
			$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='".($city)."', `room`={$room} ;");
			if ($q !== FALSE) return true;
			return false;

			/*
			$fp = fopen ("/w/www/chat/chat.txt","a"); //открытие
			flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
			fputs($fp ,":[".time()."]:[{$who}]:[".($text)."]:[".$room."]\r\n"); //работа с файлом
			fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
			flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
			fclose ($fp); //закрытие
			*/
}

function err($t) {
	echo '<font color=red>',$t,'</font>';
}

function round_time($ts, $step) 
{
	return(floor(floor($ts/60)/60)*3600+floor(date("i",$ts)/$step)*$step*60);
}



	if (isset($_SESSION['uid'])) 
	{
		$query = mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");

		if (mysql_num_rows($query) != 1) 
		{
		die();
		}
		
		$user = mysql_fetch_assoc($query);		

		if(($user['align']>1 && $user['align']<2) || $user['deal']==-1)
		{

			if (!isset($_SESSION['pal_viz_time'])) $_SESSION['pal_viz_time'] = 0;

			if(!$_SESSION['pal_viz_time'] || $_SESSION['pal_viz_time']<time())
			{
				$_SESSION['pal_viz_time']=time()+60*15; //каждые 5 минут чекаем местонахождения палов

				$chatactive = 1;
				if (!isset($_SESSION['lastpalupdate'])) $_SESSION['lastpalupdate'] = time();
				if ($_SESSION['lastpalupdate'] < time()-2*60) $chatactive = 0;
				mysql_query("INSERT into oldbk.pal_vizits SET owner='".$user['id']."' ,room='".$user['room']."', id_city=1, `chatactive` = ".$chatactive." ,`date`='".round_time(time(),15)."';");

			}
		}

		
		if($user['klan']=='Adminion' || $user['klan']=='radminion')
		{
			define("ADMIN",true);
		}
		else
		{
			define("ADMIN",false);
		}	

		if  ($user['block'] == 1) 
 		{
		 $_SESSION['block']=1;
		 die("<script>location.href='index.php?exit=3.14zde';</script>");
		}
		
		if($_SESSION['sid'] != $user['sid'])
		{
		  $_SESSION['uid'] = null;
		  $paramsz=mt_rand(11111111,999999999);
		   die ("<script>top.location.href='index.php?exit=$paramsz';</script>");
		}
		
		//fix sex
		if ($user['hidden']>0) {$user['sex']=1; }
		
		                if (isset($_SESSION['adm_view']) && $_SESSION['adm_view']==1)
				{
				}
				else
				{
				if (!isset($_SESSION['o_up'])) $_SESSION['o_up'] = 0;
				//кеширование запросов для онлайна
				if ($_SESSION['o_up']<time()-20)
						{
							if (($user['ldate']<time()) OR ($user['bot']>0) )   // если время меньше чем текущее то ставим новое - если больше знач не трогаем
						 	{
							mysql_query("UPDATE users set ldate='".time()."' where id={$user['id']}; ");
//							save_otime_to_file_2($user['id']);
							}
						
						$_SESSION['o_up']=time();
						}
				//раз в час - делаем обновление счетчика для линейки
				
				require_once('config_ko.php');
				if ((time()>$KO_start_time3) and (time()<$KO_fin_time3))
						{
						//акция включена - ЛЕТО
						if (!(isset($_SESSION['onl_1up']))) { $_SESSION['onl_1up']=time(); } // нет данных в сессии - то ставит текущее время и ждем час
						
						if ($_SESSION['onl_1up']<time()-3600) //1 раз в час
								{
							 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`ctime`=1,`ttime`=NOW() ON DUPLICATE KEY UPDATE `ctime`=`ctime`+1,`ttime`=NOW() ;");
								$_SESSION['onl_1up']=time();
								
																$get_user_day=mysql_fetch_array(mysql_query("select * from oldbk.users_timer where owner='{$user['id']}' "));
								if ($get_user_day)
									{
										//за бои
										$prsbat=10; //10% за бой
										if ($get_user_day['cday']==6) $prsbat=5; //5 за бой
										$myp=$get_user_day['cbattle']*$prsbat;
										if ($myp>50) $myp=50;
										//за онлайн
										$mypo=$get_user_day['ctime']*10;
										if ($mypo>50) $mypo=50;
										$myp+=$mypo;
										
										if ($myp==10)
										{
										//отправляем системку
										$txtdata[0]='«Летний дух стойкости: день первый»';
										$txtdata[1]='«Летний дух стойкости: день второй»';										
										$txtdata[2]='«Летний дух стойкости: день третий»';										
										$txtdata[3]='«Летний дух стойкости: день четвертый»';										
										$txtdata[4]='«Летний дух стойкости: день пятый»';										
										$txtdata[5]='«Летний дух стойкости: день шестой»';										
										$txtdata[6]='«Летний дух стойкости: день седьмой»';										
										
										$txtdata=$txtdata[$get_user_day['cday']];
										
										$mtext="У вас появилось новое задание <a href=http://oldbk.com/encicl/?/act_line.html target=_blank>".$txtdata."</a>! Отслеживать прогресс можно через раздел «<a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1&effects=1#quests\")>Состояние</a>» инвентаря.";
										addchp ('<font color=red>Внимание!</font>'.$mtext,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);						   		
										}
									}
								
								}
						
						}
				elseif ((time()>$KO_start_time4) and (time()<$KO_fin_time4))
						{
						//акция включена - ЗИМА
						if (!isset($_SESSION['onl_1up'])) $_SESSION['onl_1up'] = 0;
						if ($_SESSION['onl_1up']==0) { $_SESSION['onl_1up']=time(); } // нет данных в сессии - то ставит текущее время и ждем час
						
						if ($_SESSION['onl_1up']<time()-3600) //1 раз в час
								{
							 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`ctime`=1,`ttime`=NOW() ON DUPLICATE KEY UPDATE `ctime`=`ctime`+1,`ttime`=NOW() ;");
								$_SESSION['onl_1up']=time();
								}
						
						}		
					
						
						
                		}
				
		
		
	}
	else
	{
	die();
	}
		
function save_otime_to_file($text)
	{
	$fp = fopen ("/www/otime.txt","a"); //открытие
	flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
	fputs($fp , $text."\n"); //работа с файлом
	fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
	flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
	fclose ($fp); //закрытие
	}

function save_otime_to_file_2($text)
	{
	$fp = fopen ("/www/ltime.txt","a"); //открытие
	flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
	fputs($fp , $text."\n"); //работа с файлом
	fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
	flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
	fclose ($fp); //закрытие
	}

function get_item_fid($row)
 {
 $c[0]='cap';
 $c[1]='ava';
 $c[2]='ang';
 $out=$c[$row['idcity']].$row[id];

 return $out;
 }

function link_for_item($row,$retpath = false)
{

$ehtml = str_replace('.gif','',$row['img']);

	$razdel=array(
		1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
		24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda' , 72 =>''
	);

	$row['otdel'] == '' ? $xx = $row['razdel'] : $xx = $row['otdel'];

	if ($row['type']==30) 
	{
		$razdel[$xx]="runs/".$ehtml;
	} elseif($razdel[$xx] == '') 
	{
            	$dola = array(5001,5002,5003,5005,5010,5015,5020,5025);
		if (in_array($row['prototype'],$vau4)) 
		{
			$razdel[$xx]='vaucher';
		} elseif (in_array($row['prototype'],$dola)) 
		{
			$razdel[$xx]='earning';
		} else 
		{
			$oskol=array(15551,15552,15553,15554,15555,15556,15557,15558,15561,15562,15568,15563,15564,15565,15566,15567);
			if (in_array($row['prototype'],$oskol)) {
				$razdel[$xx]="amun/".$ehtml;
			} else {
				$razdel[$xx]='predmeti/'.$ehtml;
			}
		}
	} else 
	{
		$razdel[$xx]=$razdel[$xx]."/".$ehtml;

	}

	if (($row['art_param'] != '') and ($row['type']!=30)) 
	{
		if ($row['arsenal_klan'] != '')	
		{
			// клановый
			$razdel[$xx]='art_clan';
		} elseif ($row['sowner'] != 0) {
				//личный
			$razdel[$xx]='art_pers';
		}
	}

	if ($retpath) return $razdel[$xx];

	$out= "<a href=http://oldbk.com/encicl/".$razdel[$xx].".html target=_blank>".$row['name']."</a>";
	return $out;
}

?>