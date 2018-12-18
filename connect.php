<?php
//date_default_timezone_set("Asia/Dubai");
if (!isset($html_code_on_post)) $html_code_on_post=false;

$__profiler = '/www/chat.oldbk.com/profiler/';
$__profilermin = 0.9;

require_once('/www/chat.oldbk.com/mysql-ext.php');

function myadderror ($error) {
	$fp = fopen ("/www/logs/php/chatmyerr.txt","a"); //открытие
	flock ($fp,LOCK_EX);
	fputs($fp ,":[".date("d/m/Y H:i:s",time())."]:".$error."\r\n"); //работа с файлом
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose ($fp);
}

function writeLog($message, $filename)
{
	$filePath = rtrim(dirname(__FILE__), '/').'/logs/'.$filename;

	$date = new \DateTime();
	$text = "--------START ".$date->format('d.m.Y H:i:s')."-------\n";
	$text .= $message."\n";
	$text .= "--------END ".$date->format('d.m.Y H:i:s')."-------\n\n";

	$h = fopen($filePath, "a");
	fwrite($h, $text);
	fclose($h);
}

function fatalErrorCatcher()
{
	$error = error_get_last();
	if(isset($error)) {
		$message = sprintf('Level error: %s | message: %s | file: %s | line: %s', $error['type'], $error['message'], $error['file'], $error['line']);

		$filename = 'other.txt';
		$write = false;
		try {
			switch ($error['type']) {
				case E_ERROR:
				case E_PARSE:
				case E_COMPILE_ERROR:
				case E_CORE_ERROR:
					$filename = 'fatal.txt';
					$write = true;
					break;
				case E_USER_ERROR:
				case E_RECOVERABLE_ERROR:
					$filename = 'error.txt';
					$write = true;
					break;
				case E_WARNING:
				case E_CORE_WARNING:
				case E_COMPILE_WARNING:
				case E_USER_WARNING:
					$filename = 'warn.txt';
					$write = false;
					break;
				case E_NOTICE:
				case E_USER_NOTICE:
					$filename = 'info.txt';
					$write = false;
					break;
				case E_STRICT:
					$filename = 'debug.txt';
					$write = true;
					break;
			}
			if($write === true) {
				writeLog($message, $filename);
			}
		} catch (\Exception $ex) {

		}
	}
}

register_shutdown_function('fatalErrorCatcher');

$off_html_code_in_post = false;

Error_Reporting(0);
if (isset($_SESSION['block']) && $_SESSION['block'] == 1) {
	die("block");
}


	$mysql = mysql_connect("oldbk-db","oldbk","4FfdomepwtT30W18xpQ");
	if ($mysql === FALSE) {
		myadderror(mysqli_connect_error());
		die();
	}
	mysql_select_db ("oldbk", $mysql);
	mysql_query("SET NAMES CP1251");
	mysql_query("SET time_zone = '+3:00';");

	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
			}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
			{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		else
			{
			if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) )     	 	{     	$_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_CF_CONNECTING_IP'];    	}
			$ip=$_SERVER['REMOTE_ADDR'];
			}

  		if($ip == "77.120.192.136" || $ip == "188.19.171.169" || $ip=="84.52.34.215")
		{
			echo "<html><head><META http-equiv=Content-type content='text/html; charset=windows-1251'><title>Произошла ошибка</title></head><body><BR>Произошла ошибка!<BR>Неверный пароль, войдите с <a href=index.php>главной страницы</a>.<BR><BR><BR><hr><table width=100%><tr><td align=left><b><a href='javascript:window.history.go(-1);'>Назад</a></b></td><td align=right>(C) OldBK</td></tr></table></body></html>";
			die();
		}

    $logstamp=date("d-m-Y H:i:s::u");
	$logdate=date("d.m.Y--H.i");
	$pathlog = '/w/www/';

	// $savelog = fopen($pathlog.'phplog2/post-'.$logdate.'.log',"a+");
	// $savelog1 = fopen($pathlog.'phplog2/get-'.$logdate.'.log',"a+");
	// $savelog2 = fopen($pathlog.'phplog2/req-'.$logdate.'.log',"a+");
	// $savelog3 = fopen($pathlog.'phplog2/cook-'.$logdate.'.log',"a+");
	//$savelog4 = fopen($pathlog.'phplog/srv-'.$logdate.'.log',"a+");

//if (!$google)

// {
	$script_exec = $_SERVER['SCRIPT_FILENAME'];

//	if($_POST) {fwrite($savelog,$logstamp." REQUEST _POST {$script_exec} BEGIN\r\n");}
//	if($_GET) {fwrite($savelog1,$logstamp." REQUEST _GET {$script_exec} BEGIN\r\n");}
//	if($_REQUEST) {fwrite($savelog2,$logstamp." REQUEST _REQUEST {$script_exec} BEGIN\r\n");}
//	if($_COOKIE) {fwrite($savelog3,$logstamp." REQUEST _COOKIE {$script_exec} BEGIN\r\n");}
	//if($_SERVER) {fwrite($savelog4,$logstamp." REQUEST _SERVER {$script_exec} BEGIN\r\n");}
	

	
	if (($off_html_code_in_post!=true) and ($html_code_on_post!=true))
	{
	
	foreach ($_POST as $k=>$v) {
		
		if (!(is_array($_POST[$k])))
		{
		//исключение
		$_POST[$k] = get_out_shit_js($v);
		//$_POST[$k] = htmlspecialchars(($_POST[$k]));
//		fwrite($savelog,$logstamp." NOT_CLEAR | ".$ip." | _POST[".$k."]=".$v."\r\n");
		$_POST[$k] = get_out_shit_sql($_POST[$k]);
//		fwrite($savelog,$logstamp." YES_CLEAR | ".$ip." | _POST[".$k."]=".$_POST[$k]."\r\n");
		}
		else
		{
		//пока нет фильтров		
		}
	
		}
	}
	
	foreach ($_GET as $k=>$v) {
		$_GET[$k] = get_out_shit_js($v);
		//$_GET[$k] = htmlspecialchars(mysql_real_escape_string($_GET[$k]));
//		fwrite($savelog1,$logstamp." NOT_CLEAR | ".$ip." | _GET[".$k."]=".$v."\r\n");
		$_GET[$k] = get_out_shit_sql($_GET[$k]);
//		fwrite($savelog1,$logstamp." YES_CLEAR | ".$ip." | _GET[".$k."]=".$_GET[$k]."\r\n");
	}
	foreach ($_REQUEST as $k=>$v) {
		$_REQUEST[$k] = get_out_shit_js($v);
		$_REQUEST[$k] = htmlspecialchars(mysql_real_escape_string($_REQUEST[$k]),ENT_COMPAT | ENT_HTML401,'win-1251');
//		fwrite($savelog2,$logstamp." NOT_CLEAR | ".$ip." | _REQUEST [".$k."]=".$v."\r\n");
		$_REQUEST[$k] = get_out_shit_sql($_REQUEST[$k]);
//		fwrite($savelog2,$logstamp." YES_CLEAR | ".$ip." | _REQUEST[".$k."]=".$_REQUEST[$k]."\r\n");
	}

	foreach ($_COOKIE as $k=>$v) {
		$_COOKIE[$k] = get_out_shit_js($v);
		$_COOKIE[$k] = htmlspecialchars(mysql_real_escape_string($_COOKIE[$k]),ENT_COMPAT | ENT_HTML401,'win-1251');
//		fwrite($savelog3,$logstamp." NOT_CLEAR | ".$ip." | _COOKIE[".$k."]=".$v."\r\n");
		$_COOKIE[$k] = get_out_shit_sql($_COOKIE[$k]);
//		fwrite($savelog3,$logstamp." YES_CLEAR | ".$ip." | _COOKIE[".$k."]=".$_COOKIE[$k]."\r\n");
	}
	foreach ($_SERVER as $k=>$v) {
		$_SERVER[$k] = get_out_shit_js($v);
		//$_SERVER[$k] = htmlspecialchars(mysql_real_escape_string($_SERVER[$k]));
		//fwrite($savelog4,$logstamp." NOT_CLEAR | ".$ip." | _SERVER[".$k."]=".$v."\r\n");
		$_SERVER[$k] = get_out_shit_sql($_SERVER[$k]);
		//fwrite($savelog4,$logstamp." YES_CLEAR | ".$ip." | _SERVER[".$k."]=".$_SERVER[$k]."\r\n");
	}
//	if($_POST) {fwrite($savelog,$logstamp." REQUEST _POST {$script_exec} END\r\n");}
//	if($_GET) {fwrite($savelog1,$logstamp." REQUEST _GET {$script_exec} END\r\n");}
//	if($_REQUEST) {fwrite($savelog2,$logstamp." REQUEST _REQUEST {$script_exec} END\r\n");}
//	if($_COOKIE) {fwrite($savelog3,$logstamp." REQUEST _COOKIE {$script_exec} END\r\n");}
	//if($_SERVER) {fwrite($savelog4,$logstamp." REQUEST _SERVER {$script_exec} END\r\n");}
//}


$rvs_readers='28453,326,7937,8540,14897';


     function rvs_log($tm)
	{
       /* $load = file("rvs_log");
        $load=implode('',$load);
		$tm=$load.$tm.'
		';
		$save = fopen("rvs_log","w");
		fwrite($save,$tm);
		fclose($save);  */
	}

function search_rvs($where_to_search)
{
        $rvs_readers='28453,326,7937,8540,14897';
        
            if (!($_SESSION['uid']>0))
        	{
        	return 'OK';
        	}
        
        $_SESSION['uid']=(int)($_SESSION['uid']);
	$rvser=mysql_fetch_assoc(mysql_query('select * from users where id = '.$_SESSION['uid'].' LIMIT 1;'));
	
	$return='OK';


	if($rvser['level']>7)
	{
		return $return;
	}

	$to_lichka=$where_to_search;
	$where_to_search=mb_strtolower($where_to_search);
	setlocale (LC_ALL, 'ru_RU');
	$load_i = file("list_clans.php"); //список клановых сайтов
	$load_i=implode('',$load_i);
	$iskluchenija=explode(',',$load_i);
	$iskluchenija[]='@bk\.ru';
	$iskluchenija[]='forum\.php';
	$iskluchenija[]='oldbk\.com';
	$iskluchenija[]='\.combats\.com';
	$iskluchenija[]='oldbk\.net';
	$iskluchenija[]='OLDBK BRUTalov';
	$iskluchenija[]='OM\_oldbk\@mail\.ru';
	$iskluchenija[]='_';
	$iskluchenija[]='private\s\[[a-zA-Zа-яА-Я0-9_\s-]{3,21}\]';
	$iskluchenija[]='рубиновые';
	$iskluchenija[]='арсенал';
	$iskluchenija[]='квартир';
	$iskluchenija[]='успешно';
	$iskluchenija[]='OlD_Bk';
	$iskluchenija[]='Полтергейст';
	$iskluchenija[]='в арсе';
	$iskluchenija[]='inf.php?login=Old_bk';
	$iskluchenija[]='dtoldbk.jr1.ru';
	$iskluchenija[]='олдбк круто';
	$iskluchenija[]='олдбк рулит';
	$iskluchenija[]='против';
	$iskluchenija[]='колдовской';
	$iskluchenija[]='Колдовской';
	$iskluchenija[]='в колдовской';
	$iskluchenija[]='в колдовско';
	$iskluchenija[]='колдовсом';
	$iskluchenija[]='кол';
	$iskluchenija[]='олдов';
	$iskluchenija[]='MortalKombat';
	$iskluchenija[]='titansoldbk';
	$iskluchenija[]='к в арс';
	$iskluchenija[]='knl-oldbk.blogsuper.ru';
	$iskluchenija[]='combats.stalkers.ru';
	$iskluchenija[]='установку образра';
	$iskluchenija[]='новку образр';
	$iskluchenija[]='новка образр';
	$iskluchenija[]='новке образр';
	$iskluchenija[]='новки образр';
	$iskluchenija[]='образ';
	$iskluchenija[]='Сдам в Аренду';
	$iskluchenija[]='rupor';
	$iskluchenija[]='руслан';
	$iskluchenija[]='navi-oldbkclan.ucoz.ru';
	$iskluchenija[]='Hero of OldBk';
	$iskluchenija[]='олдбк.рф';
	$iskluchenija[]='dimonti98@nm.ru';
	$iskluchenija[]='commerce';
				
	
	

    $where_to_search=preg_replace('/(.)\\1{3,}/i','$1',$where_to_search);
    $where_to_search=preg_replace('/\s{2,}/','$1',$where_to_search);

	for($d=0;$d<count($iskluchenija);$d++)
	{
		$where_to_search=preg_replace('/'.$iskluchenija[$d].'/i','',$where_to_search);
	}
	$kill = 0;
	$stop = 0;

	$load = file("rvs_search_pal.php");
	$load=implode('',$load);
	$load=mb_strtolower($load);
	$search=explode('{|}',$load);

	for($b=0;$b<count($search);$b++)
	{
		$pos=stripos($where_to_search, $search[$b]);
       		if($pos!==false)
		{
			$kill=1;
			$stop=1;
		}
	
	}
 	
	if(preg_match('/Гуси (\d)/i',$where_to_search))
	{
			$kill=1;
			$stop=1;
	}
 	
    if(!$stop)
    {
		//$where_to_search='wer wer wr w f d*W*О*r*l*d*s(ОГОГОГО)net wer';
                //   x.ru
                //   кс
    		include "rvs_search.php";
		$map_en = Array(
		'-'=>'–—','a'=>'а','b'=>'бв','c'=>'сцк','d'=>'д','e'=>'еф','f'=>'фй','j'=>'г',
		'h'=>'х','i'=>'йи1іа','g'=>'г','k'=>'к','l'=>'1л','m'=>'м','n'=>'н','o'=>'о0',
		'p'=>'п','q'=>'ку','r'=>'р','s'=>'с','t'=>'т','u'=>'у','v'=>'в','w'=>'в','x'=>'х','x'=>'кс','y'=>'ыюуя','y'=>'у','z'=>'з','y'=>'я','y'=>'ы','ya'=>'я',
		'а'=>'а','б'=>'б','в'=>'в','г'=>'г','д'=>'д','е'=>'е','ж'=>'ж','з'=>'з','и'=>'и','к'=>'к','л'=>'л','м'=>'м','н'=>'н','о'=>'о','п'=>'п','р'=>'р','с'=>'с','т'=>'т','у'=>'у','ф'=>'ф',
		'х'=>'х','ц'=>'ц','ч'=>'ч','ш'=>'ш','щ'=>'щ','ъ'=>'ъ','ы'=>'ы','ь'=>'ь','э'=>'э','ю'=>'ю','я'=>'я','ё'=>'ё');
	    
	   // ардания
	    
	    setlocale (LC_ALL, 'ru_RU');
	    
	    for($f=0;$f<count($search);$f++)
	    {
		$regexp='';
		$replacement='<font color=red><b>';
		for ($i=0; $i<=strlen($search[$f])-1; $i++)
		{
			//побуквенно собираем маски поиска.
			//'Берем адрес из словаря fdworlds.net и кладем его на маску, чтоб определять
			// f*dw*or*ld*s.net  f-d-w-o-r-lds.net  f d w o r l d s(точка)net  и тд
			//'[fф](\W*)[dд](\W*)[wв](\W*)[oо](\W*)[rр](\W*)[lл](\W*)[dд](\W*)[sс](\W*)(.?){10}(\W*)[nн](\W*)[eеэ](\W*)[tт]'
			if($rvser['level']<=4)
			{				  
				if($search[$f][$i]=='.')
				{
					$regexp=substr($regexp,0,-5);
					$regexp.='(.?){10}(\W*)';
				}
				else
				{
					if (isset($map_en[$search[$f][$i]])) {
						$regexp.='['.$search[$f][$i].$map_en[$search[$f][$i]].']';
					} else {
						$regexp.='['.$search[$f][$i].']';
					}
					if($i<strlen($search[$f])-1)
					{
						$regexp.='(\W*)';
					}
					$replacement.= "\$".$i;
				}
			}
			else
			if($rvser['level']>4 && $rvser['level']<=7)
			{
				if($search[$f][$i]=='.')
				{
					$regexp=substr($regexp,0,-9);
					$regexp.='(.?){3}';
				}
				else
				{
					if (isset($map_en[$search[$f][$i]])) {
						$regexp.='['.$search[$f][$i].$map_en[$search[$f][$i]].']';
					} else {
						$regexp.='['.$search[$f][$i].']';
					}

					if($i<strlen($search[$f])-1)
					{
						$regexp.='(\W{0,1})';
					}
					$replacement.= "\$".$i;
				}
			
			}
			else
			if($rvser['level']>7)
			{
			//return в начале функции на это условие	
				
				/*
				if($search[$f][$i]=='.')
				{
					$regexp=substr($regexp,0,-5);
					$regexp.='(.?)';
				}
				else
				{
					$regexp.='['.$search[$f][$i].$map_en[$search[$f][$i]].']';
					$replacement.= "\$".$i;
				}*/
			}
		}
		$replacement.='</b></font>';
		$regexp='/'.$regexp.'/i';
			if(preg_match($regexp,$where_to_search))
			{
				$to_lichka=preg_replace($regexp,$replacement,$to_lichka) . '. Отработал фильтр на сайт:' .$search[$f];
				$kill=1;
				break;
			}
	    }

	    //echo $kill;
	}

	if($kill==1)
	{
	        $ok = 0;
		rvs_log($rvser['login'].': '.$to_lichka);

            $data=mysql_query('SELECT * from effects where type = 2 AND owner = '.$_SESSION['uid'].' limit 1');
            if(mysql_affected_rows()>0)
			    {
                   while($row=mysql_fetch_assoc($data))
                   {
                      mysql_query('update effects set time=time+60 where id='.$row['id'].' and owner = '.$_SESSION['uid'].' AND type=2 limit 1');
                   }
                }
                else
                {
					if ($rvser['level']<8) {
						$sql[0]="('".$_SESSION['uid']."','Заклятие молчания','".(time()+("1440"*60))."',2)";
					}
					else {
						$sql[0]="('".$_SESSION['uid']."','Заклятие молчания','".(time()+("360"*60))."',2)";
					}
                	$ok=1;
                }

            $data=mysql_query('SELECT * from effects where type = 3 AND owner = '.$_SESSION['uid'].' limit 1');
            if(mysql_affected_rows()>0)
			    {
                   while($row=mysql_fetch_assoc($data))
                   {
                      mysql_query('update effects set time=time+60 where owner = '.$_SESSION['uid'].' AND type=3 limit 1');
                   }
                }
                else
                {
					$sql[1]="('".$_SESSION['uid']."','Заклятие форумного молчания','".(time()+("1440"*60))."',3)";
                	$ok=1;
                }

            $data=mysql_query('SELECT * from effects where type = 5 AND owner = '.$_SESSION['uid'].' limit 1');
            if(mysql_affected_rows()>0)
			    {
                   while($row=mysql_fetch_assoc($data))
                   {
                      mysql_query('update effects set time=time+60 where owner = '.$_SESSION['uid'].' AND type=5 limit 1');
                   }
                }
                else
                {

					if ($rvser['level']<6) {
						$sql[2]="('".$_SESSION['uid']."','Заклятие обезличивания','".(time()+60*60*4320)."',5)";
						$ok=1;
					}
                }
            //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`)
            //values ;")


            if($ok==1)
            {
            	if(($rvser['align']>1 && $rvser['align']<2) || ($rvser['align']>2 && $rvser['align']<3))
                {

                }
            	else
            	{
		            mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`)
					            values
					            ".(implode(',',$sql)).";
					");
                    mysql_query("UPDATE users set slp=1 where id={$_SESSION['uid']} ;");

					if (isset($sql[2])) {
						$mess="Автобот наложил заклятие ".($sql[0]?"молчания,":"")." ".($sql[1]?"форумного молчания,":"")." ".($sql[2]?"Заклятие обезличивания,":"")." за <b>".$to_lichka."</b> ";
					}
					else {
						$mess="Автобот наложил заклятие ".($sql[0]?"молчания,":"")." ".($sql[1]?"форумного молчания,":"")." за <b>".$to_lichka."</b> ";
					}
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");
					mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`) VALUES ('','1','$mess','".time()."');");
			        $txt='<font color=red>Внимание! <b>РВСник,  ID <a href=http://capitalcity.oldbk.com/inf.php?'.$_SESSION['uid'].' target=_blank>'.$rvser['login'].' '.$_SESSION['uid'].'</a></b></font>';

		            $data=mysql_query('SELECT * FROM users WHERE  (align>=1.9 and align<2 AND align !=1.92) or id in ('.$rvs_readers.')');
		            while($row=mysql_fetch_array($data))
		            {
			            mysql_query("INSERT INTO oldbk.`telegraph`
			           		(`owner`,`date`,`text`) values
			           		('".$row['id']."','','".$txt."');
			            ");
		            }
                }
            }

            $return='DEL';
	}

   return $return;
}
  /*
if($_SESSION[uid]==142461)
{
	временный фильтр
}
else*/
if ($_SERVER['PHP_SELF']=='/klanedit.php')
{
	//ссылка на сайт в клан реге
}
else
if(isset($_POST['autoanswer']) || isset($_POST['login']) || isset($_POST['homepage']) || isset($_POST['hobby']) || isset($_POST['about']) || isset($_GET['text']) || isset($_POST['text']) || isset($_POST['txt']) || isset($_POST['podarok2']) || isset($_POST['message']) || isset($_POST['title']))
{
	if(isset($_POST['autoanswer']))
	{
		if(search_rvs($_POST['autoanswer'])=='DEL')
		{
			$_POST['autoanswer']=' ';
		}
	}
	if(isset($_POST['login']))
	{
		if(search_rvs($_POST['login'])=='DEL')
		{
			$_POST['login']=' ';
		}
	}
	if(isset($_POST['homepage']))
	{
		if(search_rvs($_POST['homepage'])=='DEL')
		{
			$_POST['homepage']=' oldbk.com ';
		}
	}
	if(isset($_POST['hobby']))
	{
		if(search_rvs($_POST['hobby'])=='DEL')
		{
			$_POST['hobby']=' I Love THIS game! oldbk.com  - наше все! ';
		}

	}
	if(isset($_POST['about']))
	{
		if(search_rvs($_POST['about'])=='DEL')
		{
			$_POST['about']=' I Love THIS game! oldbk.com  - наше все! ';
		}
	}


	if(isset($_POST['title']))
	{
		if(search_rvs($_POST['title'])=='DEL')
		{
			$_POST['title']=' ';
		}
	}

	if(isset($_GET['text']))
	{
	 if (isset($_SESSION['uid']) && $_SESSION['uid']>0)
	  {
		$qwe=mysql_fetch_array(mysql_query('select * from users where id = '.$_SESSION['uid'].' LIMIT 1;'));
		
		if(search_rvs($_GET['text'])=='DEL' && $qwe['id']!=8540)
		{
			if($qwe['level']<7)
			{
				$_GET['text']='Супер проект! Я '.($qwe['sex']==1?'рад':'рада').' что тут зарегистрировал'.($qwe['sex']==1?'ся':'лась').'! Живой народ, новые локации, красивый дизайн, отзывчивые админы! Все другие клоны - ниочем! Я скажу всем - OLDBK.COM - форева!';
 			}
 			elseif($qwe['level']>=7)
 			{
 				$_GET['text']='ОлдБК - настоящий проект! Без лагов, с быстрым развитием, плюс отзывчивые админы и много народа. Все другие клоны - ниочем! Мне нравится только здесь - в OLDBK.COM!';
 			}
		}
	   }
	}

	if(isset($_POST['text']) && $_GET['topic']!=228661586)
	{
		if(search_rvs($_POST['text'])=='DEL')
		{
			$_POST['text']=' ';
		}
	}
	if(isset($_POST['txt']))
	{
		if(search_rvs($_POST['txt'])=='DEL')
		{
			$_POST['txt']=' ';
		}
	}
	if(isset($_POST['podarok2']))
	{
		if(search_rvs($_POST['podarok2'])=='DEL')
		{
			$_POST['podarok2']=' ';
		}
	}
	if(isset($_POST['message']))
	{
		if(search_rvs($_POST['message'])=='DEL')
		{
			$_POST['message']=' ';
		}
	}
}


function get_out_shit_js($in)
{
	if (is_array($in)) return $in;
	$in=htmlspecialchars($in,ENT_COMPAT | ENT_HTML401,'win-1251');
	$in = str_ireplace("&amp;","&",$in);
	$in = str_ireplace("script","",$in);
	$in = str_ireplace("onClick","",$in);
	$in = str_ireplace("onDblClick","",$in);
	$in = str_ireplace("onLoad","",$in);
	$in = str_ireplace("onUnLoad","",$in);
	$in = str_ireplace("onMouseDown","",$in);
	$in = str_ireplace("onMouseUp","",$in);
	$in = str_ireplace("onMouseOver","",$in);
	$in = str_ireplace("onMouseMove","",$in);
	$in = str_ireplace("onMouseOut","",$in);
	$in = str_ireplace("onFocus","",$in);
	$in = str_ireplace("onBlur","",$in);

	$in = str_ireplace("onAbort","",$in);
	$in = str_ireplace("onError","",$in);
	$in = str_ireplace("onKeyDown","",$in);
	$in = str_ireplace("onKeyPress","",$in);
	$in = str_ireplace("onKeyUp","",$in);
	$in = str_ireplace("onMove","",$in);
	$in = str_ireplace("onReset","",$in);
	$in = str_ireplace("onResize","",$in);
	$in = str_ireplace("onSelect","",$in);
	$in = str_ireplace("onSubmit","",$in);
	$in = str_ireplace("onUnload","",$in);

	return $in;
}

function get_out_shit_sql($in) {
	if (is_array($in)) return $in;
	$in=htmlspecialchars($in,ENT_COMPAT | ENT_HTML401,'win-1251');
	$in = str_ireplace("&amp;","&",$in);
	$in = str_ireplace("select","",$in);
	$in = str_ireplace("update","",$in);
	$in = str_ireplace("replace","",$in);
	$in = str_ireplace("benchmark","",$in);
	$in = str_ireplace("ignore","",$in);
	$in = str_ireplace("ascii","",$in);
	$in = str_ireplace("md5","",$in);
	$in = str_ireplace("inner ","",$in);
	$in = str_ireplace(" inner","",$in);
	$in = str_ireplace(" inner ","",$in);
	$in = str_ireplace("inner join","",$in);
	$in = str_ireplace("where","",$in);
	$in = str_ireplace("deztow","",$in);
	$in = str_ireplace("users","",$in);
	$in = str_ireplace("concat","",$in);
	$in = str_ireplace("'", "&#39;", $in);
	$in = str_ireplace("x3c", "&lt;", $in);
	$in = str_ireplace("x3e", "&gt;", $in);
	$in = str_ireplace("http://fight-club.ml/", "", $in);
	$in = str_ireplace("http://fight-club.ml", "", $in);
	$in = str_ireplace("fight-club.ml", "", $in);
	//$in = str_ireplace("style", "stуle", $in);
	
	$in = str_ireplace("<", "&lt;", $in);
	$in = str_ireplace(">", "&gt;", $in);
	$_Ary_TagsList= array('<!-', '<', '>', '%3C', '&#60', '&#060', '&#0060', '&#00060', '&#000060', '&#0000060', '&#60;', '&#060;', '&#0060;', '&#00060;', '&#000060;', '&#0000060;', '&#x3c', '&#x03c', '&#x003c', '&#x0003c', '&#x00003c', '&#x000003c', '&#x3c;', '&#x03c;', '&#x003c;', '&#x0003c;', '&#x00003c;', '&#x000003c;', '&#X3c', '&#X03c', '&#X003c', '&#X0003c', '&#X00003c', '&#X000003c', '&#X3c;', '&#X03c;', '&#X003c;', '&#X0003c;', '&#X00003c;', '&#X000003c;', '&#x3C', '&#x03C', '&#x003C', '&#x0003C', '&#x00003C', '&#x000003C', '&#x3C;', '&#x03C;', '&#x003C;', '&#x0003C;', '&#x00003C;', '&#x000003C;', '&#X3C', '&#X03C', '&#X003C', '&#X0003C', '&#X00003C', '&#X000003C', '&#X3C;', '&#X03C;', '&#X003C;', '&#X0003C;', '&#X00003C;', '&#X000003C;', 'x3c', 'x3C', 'u003c', 'u003C');
	$in= str_ireplace($_Ary_TagsList, '', $in);
	
	$in = str_ireplace("|", "&#0124;", $in);
	$in = str_ireplace("`", "&#96;", $in);
	$in = str_ireplace("’", "&#146;", $in);
	$in = str_ireplace("dawin.info","",$in);
	$in = str_ireplace("dawin","",$in);
	return $in;
}

//fclose($savelog);
//fclose($savelog1);
//fclose($savelog2);
//fclose($savelog3);

?>
