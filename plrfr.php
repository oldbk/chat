<?php
session_start();

include "connect.php";
include "functions_chat.php";
include "genactions.php";

header("Cache-Control: no-cache");

$t = ReturnActions();
$ids = array_keys($t);

if (isset($_GET['save'])) {
	setcookie("acc",implode("-",$ids),time()+60*60*24*365);
	die();
}

if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$t = get_mag_stih($user);

$small_stih  = [1 => 150152, 2 => 920925, 3 => 130135, 4 => 930935];
$medium_stih = [1 => 150158, 2 => 920928, 3 => 130138, 4 => 930938];
$big_stih    = [1 => 150157, 2 => 920927, 3 => 130137, 4 => 930937];
$sover_stih  = [1 => 150156, 2 => 920926, 3 => 130136, 4 => 930936];

$luckyarr = [
	// нечетный
	"odd" => [
		0 => [
			105   => 1,
			50076 => 1,
			$small_stih[$t[0]] => 1,
			119   => 1,
			33000 => 1,
			3333  => 1,
		],
		1 => [
			55558  => 1,
			$medium_stih[$t[0]] => 1,
			14005  => 1,
			122121 => 3,
			200273 => 1,
			4005   => 1,
		],
		2 => [
			33100   => 1,
			15004   => 1,
			33054   => 1,
			4006    => 1,
			169     => 1,
			3001003 => 1,
		],
		3 => [
			119119119 => 7,
			14004     => 7,
			200273    => 5,
			1002225   => 2,
			$big_stih[$t[0]] => 2,
			4007      => 1,
		],
		4 => [
			1122      =>  1,
			122123    =>  2,
			34007     => 10,
			200273    => 10,
			3001003   =>  5,
			33053     =>  2,
		],
		5 => [
			100199    => 1,
			119119120 => 7,
			100420    => 3,
			200278    => 5,
			56664     => 1,
			55554     => 1,
		],
	],
	// четный
	"even" => [
		0 => [
			105104 => 1,
			55560  => 1,
			14003  => 1,
			120    => 1,
			57777  => 1,
			4002   => 1,
		],
		1 => [
			50077   => 1,
			4017    => 1,
			$big_stih[$t[0]] => 1,
			1002224 => 1,
			3001002 => 1,
			105103  => 1,
		],
		2 => [
			33102     => 1,
			120120120 => 1,
			33052     => 1,
			5205      => 3,
			169       => 1,
			3001003   => 1,
		],
		3 => [
			120120120 => 5,
			5205      => 7,
			15004     => 3,
			122122    => 2,
			4006      => 1,
			100430    => 1,
		],
		4 => [
			19108     => 1,
			34007     => 10,
			33055     => 2,
			55559     => 2,
			$sover_stih[$t[0]] => 2,
			1002225   => 3,
		],
		5 => [
			120120121 => 10,
			100430    => 3,
			200440    => 3,
			200277    => 5,
			55554     => 1,
			1002226   => 1,
		],
	],
];

if (isset($_GET['dofortune']) && isset($user) && $user['level'] >= 8) {
	$status = 0;
	$q = mysql_query('SELECT * FROM users_fortune WHERE owner = '.$user['id']);
	if (mysql_num_rows($q) > 0) {
		$status = mysql_fetch_assoc($q);
		$status = $status['status'];
	}

	if (($status == 3 || $status == 4) && !isset($_SESSION['bankid'])) {
		$error = 0;
		if (isset($_GET['bankpass'],$_GET['bankid']) && !empty($_GET['bankid']) && !empty($_GET['bankpass'])) {
			$q = mysql_query('SELECT * FROM bank WHERE owner = '.$user['id'].' and id = '.intval($_GET['bankid']).' and pass = "'.md5($_GET['bankpass']).'"');	
			if (mysql_num_rows($q) > 0) {
				$_SESSION['bankid'] = intval($_GET['bankid']);
			} else {
				$error = 1;
			}
		}

		if (!isset($_SESSION['bankid'])) {
			$auth =  '<table border=0 width=400 height=100><tr><td valign=top align="center" height=5 colspan="4"><font style="COLOR:#8f0000;FONT-SIZE:12pt"><div style="width:25px;height:2px;position:relative;top:-15px;right:-300px;"><a onClick=\'top.frames["newplr"].closeinfo();\' title="Закрыть" style="cursor: pointer;"><img src="http://i.oldbk.com/i/bank/bclose.png" border=0 title="Закрыть"></a></div>'; 
			$auth .= "Авторизация в банке";
			$auth .= '</td></tr>
			<tr><td colspan="4" class="center" valign=top>';   
	
	
			$q = mysql_query('SELECT * FROM bank WHERE owner = '.$user['id']);
			if (mysql_num_rows($q) > 0) {
				$auth .= '<select id="bankidplr" style="width:100px" name="bankid">';
				while ($rah = mysql_fetch_array($q)) {
					$auth .= "<option>".$rah['id']."</option>";
				}
				$auth .= "</select> ";
				$auth .= 'Пароль: <input type=password name="bankpass" id="bankpassplr" style="width:100px"> <button style="height:23px;" OnClick="top.frames[\'newplr\'].doFortune(document.getElementById(\'bankidplr\').value,document.getElementById(\'bankpassplr\').value);">Войти</button>';
		
			} else {
				$auth .= '<font color="red">Банковские счета не найдены</font>';
			}
		
			if ($error > 0) {
				$auth .= '<br><font color="red">Не правильный пароль</font>';				
			}
	
			$auth .= '</td>
				</tr><tr><td align="center"  colspan="3">
				</td></tr>
				</table>';
			echo $auth;
			die();
		}
	}

	if ($status < 6) {
		// забираем бабки-екр-монеты и апдейтим статус
		if (!(date("d") % 2)) {
			$arr = $luckyarr["even"];
		} else {
			$arr = $luckyarr["odd"];
		}

		switch($status) {
			case 0:
				$m = array_fill(0,6,1);
			break;
			case 1:
				$m = array_fill(0,12,1);
			break;
			case 2:
				$m = array_fill(0,18,1);
			break;
			case 3:
				$m = array_fill(6,18,1);
			break;
			case 4:
				$m = array_fill(12,18,1);
			break;
			case 5:
				$m = array_fill(30,6,1);
			break;
		}


		$sarr = [];
		$i = 0;
		while(list($k,$v) = each($arr)) {
			while(list($ka,$va) = each($v)) {
				if (isset($m[$i])) {
					$sarr[] = ['proto' => $ka, 'count' => $va];
				}
				$i++;
			}
		}

		shuffle($sarr);
		$win_p = $sarr[mt_rand(0,count($sarr)-1)];
		$q = mysql_query('SELECT * FROM shop WHERE id = '.$win_p['proto']);
		if (mysql_num_rows($q) > 0) {
			$item = mysql_fetch_assoc($q);

			$win = '<br><br><a target="_blank" href="http://oldbk.com/encicl/'.link_for_item($item,true).'.html">';
			if (empty($item['img_big'])) {
				$win .= '<img title="'.$item['name'].'" src="http://i.oldbk.com/i/sh/'.$item['img'].'">';
			} else {
				$win .= '<img title="'.$item['name'].'" src="http://i.oldbk.com/i/sh/'.$item['img_big'].'">';
			}
			$win .= '</a><br><br>'.$item['name'].' в количестве '.$win_p['count'].' шт.</b>';

			$ok = false;
			$err = "";
			$how = 0;

			if ($status == 0) {
				$ok = true;
			}

			if ($status == 1 || $status == 2) {
				// снимаем кр
				$how = 50;
				if ($status == 2) $how = 100;

				if ($user['money'] >= $how) {				
					mysql_query('UPDATE users SET money = money - '.$how.' WHERE id = '.$user['id'].' LIMIT 1');
					$ok = true;
				} else {
					$err = "Недостаточно кр. для оплаты";
				}
			}

			if ($status == 3 || $status == 4) {
				// снимаем екр
				$how = 1;
				if ($status == 4) $how = 3;

				$bank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				if (!$bank) die();

				if ($bank['ekr'] >= $how) {
					mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr-'".$how."' WHERE id = ".$bank['id'].' LIMIT 1');

					$qb = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.bank WHERE id = '.$bank['id']));
					$rec['add_info'] = 'Баланс до '.($qb['ekr']+$how). ' после ' .$qb['ekr'];
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','Вы участвовали В Колесе Фортуны ".$how." екр.</b>, <i>(Итого: {$qb['cr']} кр., {$qb['ekr']} екр.)</i>','{$bank['id']}');");

					$ok = true;
				} else {
					$err = "Недостаточно екр для оплаты";
				}
			}

			if ($status == 5) {
				$how = 20;

				if ($user['gold'] >= $how) {				
					mysql_query('UPDATE users SET gold = gold - '.$how.' WHERE id = '.$user['id'].' LIMIT 1');
					$ok = true;
				} else {
					$err = "Недостаточно монет для оплаты";
				}

			}

			if ($ok) {
				require_once("new_delo.php");

				$rec['owner']=$user['id'];
				$rec['owner_login']=$user['login'];
				$rec['owner_balans_do']=$user['money'];
				if ($status == 1 || $status == 2) {
					$user['money'] -= $how;
				}
				$rec['owner_balans_posle']=$user['money'];
				$rec['target']=0;
				$rec['target_login']="Колесо Фортуны";
				$rec['type']=1991;//Ремонт предмета
				if ($status == 1 || $status == 2) {
					$rec['sum_kr'] = $how;
					$rec['sum_ekr'] = 0;
				}
				if ($status == 3 || $status == 4) {
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$how;
				}
				if ($status == 5) {
					$user['gold'] -= $how;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['add_info'] = $how.'/'.$user['gold'];
				}
				$rec['sum_kom']=0;
				$rec['item_name']=$item['name'];
				$rec['item_count']=$win_p['count'];
				$rec['item_type']=$item['type'];
				$rec['item_cost']=$item['cost'];
				$rec['item_dur']=$item['duration'];
				$rec['item_maxdur']=$item['maxdur'];
				$rec['item_ups']=$item['ups'];
				$rec['item_unic']=$item['unik'];
				$rec['item_incmagic']=$item['includemagicname'];
				$rec['item_incmagic_count']=$item['includemagicuses'];
				$rec['item_arsenal']=$item['arsenal_klan'];

				mysql_query('INSERT INTO `users_fortune` (`owner`,`status`) 
						VALUES(
							'.$user['id'].',
							"1"
						) 
						ON DUPLICATE KEY UPDATE
						`status` = `status` + 1
				');

/*
				if (ADMIN && ($status + 1 == 6)) {
					mysql_query('UPDATE users_fortune SET status = 0 WHERE owner = '.$user['id']);
				}
*/


				$item['getfrom'] = 144;
				$pres = 'Колесо Фортуны';
				$dress = $item;
				$fxarr  = ['100199','100420','100430','200440'];

				if (!$dress['goden']) {
					$dress['goden'] = 30;
					if ($status == 3) {
						$dress['goden'] = 60;
					}
					if ($status == 4) {
						$dress['goden'] = 90;
					}
					if ($status == 5) {
						$dress['goden'] = 180;
					}
				} elseif ($status == 5 && in_array($dress['id'],$fxarr)) {
					$dress['goden'] = 180;
				}

				$dress['notsell'] = 1;
				$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");

				$insert_id = [];
				for ($i = 0; $i < $win_p['count']; $i++) {
					mysql_query("INSERT INTO oldbk.`inventory`
						(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`img_big`,`maxdur`,`isrep`,`letter`,`add_time`,`notsell`,`gmeshok`,
							`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
							`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`rareitem`,`getfrom`
						)
						VALUES
						('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}','{$dress['img_big']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['letter']}','{$dress['add_time']}', '{$dress['notsell']}',  '{$dress['gmeshok']}',  '{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$pres}','0','0','{$dress['group']}','{$user['id_city']}','{$dress['rareitem']}', '{$dress['getfrom']}'
						) ;");

					$insert_id[$i] = trim("cap".mysql_insert_id());
				}

				$rec['item_id'] = implode(',',$insert_id);

				mysql_query('INSERT INTO users_fortune_stats (`owner`,`date`,`status`,`itemproto`,`itemcount`) VALUES('.$user['id'].','.time().','.$status.','.$dress['id'].','.$win_p['count'].')');

				add_to_new_delo($rec);

				$_params = json_encode(['game' => $status]);
				mysql_query("INSERT INTO user_quest_check (`user_id`,`check_type`,`check_count`,`params`,`created_at`) VALUES ({$user['id']},'fortuna',1,'{$_params}',".time().")");
			} else {
				$win = '<br><br><b style="color:red;">'.$err.'</b><br>';
			}

		}
	} else {
		$win = '<br><br><b>На сегодня лимит бросков исчерпан</b><br>';
	}

	$res =  '<table border=0 width=400 height=100><tr><td valign=top align="center" height=5 colspan="4"><font style="COLOR:#8f0000;FONT-SIZE:12pt"><div style="width:25px;height:2px;position:relative;top:-15px;right:-300px;"><a onClick=\'top.frames["newplr"].closeinfo();\' title="Закрыть" style="cursor: pointer;"><img src="http://i.oldbk.com/i/bank/bclose.png" border=0 title="Закрыть"></a></div>'; 
	$res .= "Награда";
	$res .= '</font>'.$win.'</td></tr>
	<tr><td colspan="4" class="center" valign=top>';   

	$res .= '</td>
		</tr><tr><td align="center"  colspan="3">
		</td></tr>
		</table><script>setTimeout(\'top.frames["newplr"].drawFortune()\',1000);</script>';
	echo $res;
	die();

}

if (isset($_GET['getfstatus']) && isset($user['id'])) {
	if ($user['level'] < 8) {
		echo '<b>Участвовать в Колесе Фортуны можно только с 8-го уровня.</b>';
		die();
	}

	if (!$user['smagic']) {
		echo '<b>Для участия в Колесе Фортуны необходимо выбрать стихию.</b>';
		die();
	}


	$status = 0;
	$q = mysql_query('SELECT * FROM users_fortune WHERE owner = '.$user['id']);
	if (mysql_num_rows($q) > 0) {
		$status = mysql_fetch_assoc($q);
		$status = $status['status'];
	}
	$head = "";

	switch($status) {
		case 0:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="попробовать бесплатно" title="попробовать бесплатно">';
			$m = array_fill(0,6,1);
		break;
		case 1:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="попробовать за 50 кр." title="попробовать за 50 кр.">';
			$m = array_fill(0,12,1);
		break;
		case 2:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="попробовать за 100 кр." title="попробовать за 100 кр.">';
			$m = array_fill(0,18,1);
		break;
		case 3:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="попробовать за 1 екр." title="попробовать за 1 екр.">';
			$m = array_fill(6,18,1);
		break;
		case 4:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="попробовать за 3 екр." title="попробовать за 3 екр.">';
			$m = array_fill(12,18,1);
		break;
		case 5:
			$head .= '<INPUT class="button-big btn" OnClick="top.frames[\'newplr\'].doFortune();" TYPE="button" value="супер игра за 20 монет" title="супер игра за 20 монет">';
			$m = array_fill(30,6,1);
		break;
		case 6:
			$head .= '<b>На сегодня лимит бросков исчерпан</b><br>';
		break;
	}

	$head .= '<br>';

	if (!(date("d") % 2)) {
		$arr = $luckyarr["even"];
	} else {
		$arr = $luckyarr["odd"];
	}

	$head .= '<br><small style="color:#8F0000;font-weight:bold;">Призы:</small>';

	// собираем прото
	reset($arr);
	$iarr = [];
	while(list($k,$v) = each($arr)) {
		while(list($ka,$va) = each($v)) {
			$iarr[] = $ka;
		}
	}

	$q = mysql_query('SELECT * FROM shop WHERE id IN ('.implode(",",$iarr).')');

	$parr = [];
	if ($q !== false) {
		while($i = mysql_fetch_assoc($q)) {
			$parr[$i['id']] = $i;
		}
	}

	// выводим
	reset($arr);
	$i = 0;
	while(list($k,$v) = each($arr)) {
		$head .= '<div class="itemlistplr" id="itemlistplr">';
		while(list($ka,$va) = each($v)) {
			if (!empty($parr[$ka]['img_big'])) $parr[$ka]['img'] = $parr[$ka]['img_big'];
			if (isset($m[$i])) {
				$class = "gift-imageplr";
			} else {
				$class = "gift-image-passiveplr";
			}
			$head .= '<div class="gift-blockplr"><img class="'.$class.'" title="'.$parr[$ka]['name'].' '.$va.' шт." src="http://i.oldbk.com/i/sh/'.$parr[$ka]['img'].'" title="'.$parr[$ka]['name'].' '.$va.' шт."><span class="invgroupcountplr">'.$va.'</span></div>';
			$i++;
		}
		$head .= '</div>';
	}
	$head .= '<div class="itemlistplr">&nbsp;</div><div class="itemlistplr" style="text-align:justify;width:290px;"><small>Каждый день вы можете испытать удачу до 5 раз подряд. С каждым разом ценность призов увеличивается. Кроме того, каждая попытка приближает вас к супер-игре, которая даст шанс выиграть самые ценные призы! Подробнее в <a href="https://oldbk.com/encicl/fortuna.html" target="_blank">Библиотеке</a></small></div>';

	echo $head;

	die();
}

if (isset($_GET['reload'])) {
	echo RenderActions($user);
	$anim = 0;
	$acc = implode("-",$ids);
	if (!isset($_COOKIE['acc'])) {
		$anim = 1;
	} elseif ($_COOKIE['acc'] != $acc) {
		// есть расхождения - сравниваем
		$t = explode("-",$_COOKIE['acc']);
		reset($ids);

		// проходимся по списку текущих акций
		while(list($k,$v) = each($ids)) {
			reset($t);
			$bnotfound = true;

			// ищем текущую акцию в списке тела
			while(list($ka,$va) = each($t)) {
				if ($va == $v) $bnotfound = false;
			}
			if ($bnotfound) {
				// не нашли текущую акцию в списке - значим показываем мигание
				$anim = 1;
				break;
			}
		}
	}
	if ($anim) {
		if ($user['level'] > 4) {
			echo '<script>var doanim = 1;</script>';
		}
	}

	$_response = checkNewRatings($user);
	foreach ($_response as $_res) {
		echo '<script>'.$_res.'</script>';
    }

	die();
}

function get_ekr_addbonus() {
	$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) {
		if($row['var'] =='dollar') {
			$dollar = $row['value'];
		} elseif($row['var'] =='euro')  {
			$euro = $row['value'];
		} elseif($row['var'] =='grivna') {
			$grivna = $row['value'];
		} elseif($row['var'] =='ekrkof') {
			$ekrkof = $row['value'];
		} elseif($row['var'] =='ekrbonus') {
			$ekrbonus = $row['value'];
		}
	}

	if ($ekrbonus>0) {
		return $ekrbonus;
	} else {
		return false;
	}
}

function checkNewRatings($user)
{
    $response = [];

	$animEnable = [];
	$ratingArray = [];
	try {
		$query = mysql_query(sprintf('select * from user_event_rating where is_end = 1 and is_reward = 0 and user_id = %d', $user['id']));
		while ($row = mysql_fetch_assoc($query)) {
			$animEnable[] = $row['rating_id'];
		}

		$query = mysql_query('select * from event_rating where is_enabled = 1');
		while ($row = mysql_fetch_assoc($query)) {
			$ratingArray[] = $row['id'];
		}
	} catch (Exception $ex) {

	}
	foreach ($animEnable as $id) {
	    $response[] = 'updateRating('.$id.', false);';
    }

	if($ratingArray) {
		$response[] = 'checkRAnim('.json_encode($ratingArray).');';
	}

	return $response;
}

function RenderActions($user) {
	$txt = '';
	$txt = '<font style="color:#8F0000;font-weight:bold;">Текущие события и акции</font><br><br>';
	$txt .= '<style type="text/css"> @import url("http://capitalcity.oldbk.com/i/plr.css"); </style>';
	$t = ReturnActions();
	$ids = array_keys($t);
	$akol=0;
	while(list($k,$v) = each($t)) {
		if (($user['level']>=5) and ($k==1313) ) continue;
		$akol++;
		$v['title'] = str_replace("'","",$v['title']);
		$v['text'] = str_replace("'","",$v['text']);
		if (!empty($v['url'])) $v['title'] = '<a href="'.$v['url'].'" target="_blank" style="font-size: 10pt;font-family: Verdana,Arial,Helvetica,Tahoma,sans-serif;color: #038;text-decoration: none;">'.$v['title'].'</a>';
		$end = "";

		if (!empty($v['end'])) {
			$end = '<br><small><i>Продлится еще<span class="datetime_item" data-timestamp="'.($v['end']).'"></span></i></small>';
		}

		$txt .= '<table border=0 width=400><tr><td rowspan=2 width="80" valign=top>';

		if (!empty($v['ico'])) {
			$txt .= '<img alt="" src="'.$v['ico'].'">';
		} else {
			$txt .= '<img src="http://i.oldbk.com/i/newd/pop/icon_1.png">';
		}
		$txt .= '</td><td style="color:#8F0000;font-weight:bold;">'.$v['title'].'</td></tr><tr><td style="font-size: 10pt;font-family: Verdana,Arial,Helvetica,Tahoma,sans-serif;color:black;font-weight:normal;">'.$v['text'].$end.'</td></tr>';

		if (!empty($v['button_url'])) {
			$txt .= '<tr><td colspan=2 height=25 align=center><div class="button-big btn" name="actionbtn" title="'.$v['button_title'].'" onclick="location.href='.'\\'.'\''.$v['button_url'].'\\'.'\';">'.$v['button_title'].'</div></td></tr>';
		} elseif (!empty($v['html'])) {
			$txt .= '<tr><td colspan=2 height=25 align=center>'.$v['html'].'</td></tr>';
		}

		$txt.= '<tr><td colspan=2 height=25><img src="http://i.oldbk.com/i/newd/pop/razdelitel1.png"></td></tr></table>';
	}

	if ($akol==0) {
		$txt .= '<table border=0 width=400><tr><td rowspan=2 width="80" valign=top>';
		$txt .= '</td><td style="color:#8F0000;font-weight:bold;">Пока нет активных акций.</td></tr><tr><td style="font-size: 10pt;font-family: Verdana,Arial,Helvetica,Tahoma,sans-serif;color:black;font-weight:normal;"></td></tr>';
		$txt .= '<tr><td colspan=2 height=25><img src="http://i.oldbk.com/i/newd/pop/razdelitel1.png"></td></tr></table>';
	}
	return $txt;
}

?>
<!DOCTYPE html>
<html>
<HEAD>
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<?php if(isset($_GET['t']) && $_GET['t'] == 'debug'): //for test without frames ?>
	    <link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
	<?php endif; ?>
    <script type="text/javascript" src="http://capitalcity.oldbk.com/i/globaljs.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
    <script>
        var jq111 = jQuery.noConflict(true);
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
    <script src="http://chat.oldbk.com/assets/store.legacy.min.js"></script>
    <style>
        .btn0 {background:url(http://i.oldbk.com/i/newd/up_right_dec.jpg) no-repeat; width:78px; height: 33px;margin-top: 1px;}
        .btn7 {background:url(http://i.oldbk.com/i/newd/up_right_dec2.jpg) no-repeat; width:19px; height: 33px;}

        .btn1 {background:url(http://i.oldbk.com/i/newd/up_butt1.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn1:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn11 {background:url(http://i.oldbk.com/i/newd/up_butt1_anim.gif) no-repeat 0 0px; cursor: pointer; width:32px; height: 33px;}

        .btn2 {background:url(http://i.oldbk.com/i/newd/up_butt2.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn2:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn3 {background:url(http://i.oldbk.com/i/newd/up_butt3.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn3:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn4 {background:url(http://i.oldbk.com/i/newd/up_butt4.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn4:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn5 {background:url(http://i.oldbk.com/i/newd/up_butt5.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn5:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn6 {background:url(http://i.oldbk.com/i/newd/up_butt6.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn6:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn900 {background:url(http://i.oldbk.com/i/newd/chn/up_butt901.jpg) no-repeat 0 -33px; cursor: pointer; width:180px; height: 33px;}
        .btn900:hover {background-position:0 0px; width:180px; cursor: pointer;}

        .btn8 {background:url(http://i.oldbk.com/i/newd/up_butt7.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn8:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn12 {background:url(http://i.oldbk.com/i/newd/up_butt12.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn12:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn9 {background:url(http://i.oldbk.com/i/newd/up_butt9.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn9:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn10 {background:url(http://i.oldbk.com/i/newd/up_butt10.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn10:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn13 {background:url(http://i.oldbk.com/i/newd/pop/up_butt18_wc18.jpg) no-repeat 0 -33px; cursor: pointer; width:32px; height: 33px;}
        .btn13:hover {background-position:0 0px; width:32px; cursor: pointer;}

        .btn14 {background:url(http://i.oldbk.com/i/newd/pop/up_butt22_anim2.gif) no-repeat 0 -66px; cursor: pointer; width:32px; height: 33px;}
        .btn14:hover {background-position:0 -33px; width:32px; cursor: pointer;}
        .btn14.anim, .btn14.anim:hover {background-position:0 0; width:32px; cursor: pointer;}

        li {
            display:inline-block;
            float:right;
        }
    </style>
    <script>

        document.domain = 'oldbk.com';
	var bankauth = <?php echo (isset($_SESSION['bankid']) && $_SESSION['bankid'] > 0) ? "true" : "false" ?>;

        var o = null;
        var part1 = '<table border=0 cellspacing=0 cellpadding=0 width=800><tr><td width=800 style="background-repeat-y:no-repeat;" background="http://i.oldbk.com/i/newd/pop/up_bg_2.jpg"><img OnClick="document.getElementById(\'actiondiv\').style.display = \'none\';window.top.frames[\'newplr\'].drawTimeClear();" OnMouseOut="this.src=\'http://i.oldbk.com/i/newd/pop/close_butt.jpg\';" OnMouseOver="this.src=\'http://i.oldbk.com/i/newd/pop/close_butt_hover.jpg\';" src="http://i.oldbk.com/i/newd/pop/close_butt.jpg" align=right></td></tr><tr><td background="http://i.oldbk.com/i/newd/pop/bg-y_4.jpg" align="center">';
	part1 += '<table><tr><td valign="top" width="50%" align="center"><font style="color:#8F0000;font-weight:bold;">Колесо фортуны</font><br><small>Испытайте удачу и получите награду</small><br><br><div id="luckyplrfr"></div><div id="plplr" style="z-index: 300; position: absolute; left: 155px; top: 120px;width:600px; background-color: #eeeeee; border: 1px solid black; display: none;"></div></td><td valign="top" width="50%" align="center">';
        var part2 = '</td></tr></table></td></tr><tr><td width=800 height=8 background="http://i.oldbk.com/i/newd/pop/down_bg_2.jpg"></td></tr>';

        function RefreshActions() {
            $.get('plrfr.php?reload',function( data ) {
				<?php if(isset($_GET['t']) && $_GET['t'] == 'debug'): //for test without frames ?>
                o = window.document;
				<?php else: ?>
                o = top.frames['main'];

                if (o.frames && o.frames['leftmap']) {
                    o = o.frames['leftmap'].document;
                } else {
                    o = o.document;
                }

				<?php endif; ?>


                if (data.indexOf("doanim") != -1) {
                    $('#btn1').removeClass('btn1');
                    $('#btn1').addClass('btn11');
                }

                if (!o.getElementById("actiondiv")) {
                    newdiv2 = o.createElement("div"),
                        newdiv2.setAttribute("id", "actiondiv");
                    newdiv2.setAttribute("style", "display:none;z-index:99999;");
                    o.body.appendChild(newdiv2);
                }

                var el = o.getElementById("actiondiv");
                el.innerHTML = part1+data+part2;

                $.get('plrfr.php?save=1');

                drawTime();
		drawFortune();
            });
        }

        setInterval(RefreshActions,<?= mt_rand(30,40); ?>*60*1000);

        function ShowActions() {
            $('#btn1').removeClass('btn11');
            $('#btn1').addClass('btn1');

			<?php if(isset($_GET['t']) && $_GET['t'] == 'debug'): //for test without frames ?>
            o = window.document;
			<?php else: ?>
            o = top.frames['main'];

            if (o.frames && o.frames['leftmap']) {
                o = o.frames['leftmap'].document;
            } else {
                o = o.document;
            }
			<?php endif; ?>


            if (!o.getElementById("actiondiv")) {
                newdiv2 = o.createElement("div"),
                    newdiv2.setAttribute("id", "actiondiv");
                newdiv2.setAttribute("style", "display:none;z-index:99999;");
                o.body.appendChild(newdiv2);
            }

            var el = o.getElementById("actiondiv");

            var txt = '<?= RenderActions($user); ?>';

            el.innerHTML = part1+txt+part2;
            el.style.display = "";
            el.style.position = "absolute";
            el.style.width = "800px;";
            el.style.left = "50%";
            el.style.top = "10%";
            el.style.marginLeft = "-375px";
            $.get('plrfr.php?save=1');

            drawTime();
	        drawFortune();
        }

        var drawItemTimeout;

        function drawTimeClear() {
            clearTimeout(drawItemTimeout);
        }

        function drawTime() {
            var count = 0;
            $.each($(o).find('.datetime_item'), function(i, el) {
                var timestamp = $(el).data('timestamp');

                var diff = get_time_diff(timestamp);
                var string = "";
                if(diff.d > 0) {
                    string += " <strong>" + diff.d + "</strong> дн.";
                }
                if(diff.h > 0) {
                    string += " <strong>" + diff.h + "</strong> ч.";
                }
                if(diff.m > 0) {
                    string += " <strong>" + diff.m + "</strong> мин.";
                }

                if(string == '') {
                    $(el).closest('table').remove();
                } else {
                    $(el).html(string);
                    count++;
                }
            });

            if(count > 0) {
                drawItemTimeout = setTimeout(drawTime, 1000);
            }
        }

        function get_time_diff( timestamp ) {
            if( timestamp - serverTime <= 0 ) {
                return {
                    'd': 0,
                    'h': 0,
                    'm': 0
                };
            }

            var milisec_diff = timestamp - serverTime;
            var days = Math.floor(milisec_diff / (60 * 60 * 24));
            var hours = Math.floor((milisec_diff - (days * 3600 * 24)) / 3600);
            var minutes = Math.floor((milisec_diff - (days * 3600 * 24) - (hours * 3600)) / 60);

            return {
                'd': days,
                'h': hours < 10 ? '0'+hours : hours,
                'm': minutes < 10 ? '0' + minutes : minutes,
                'msec': milisec_diff
            };
        }

    	var serverTime = <?= time() ?>;
    	setInterval(function() { serverTime++; }, 1000);

	function closeinfo() {
		$("#plplr",top.frames["main"].document).hide(200);
	}


	function doFortune(bankid,bankpass) {
		var addstr = "";
		if (typeof(bankid) != "undefined" && typeof(bankpass) != "undefined") {
			addstr = "&bankid="+bankid+"&bankpass="+encodeURIComponent(bankpass);
		}

		$.get('http://chat.oldbk.com/plrfr.php?dofortune'+addstr, function(data) {
			obj = $("#plplr",top.frames["main"].document);
			obj.html(data);
		 	obj.css({ position:'absolute',left: ($(window).width()-$('#pl').outerWidth())/2, top: ($(window).scrollTop()+120)+'px'  });
			obj.show(200);
	
			$("input, select, button").bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(e){
			    e.stopImmediatePropagation();
			});
		});
	}

	function drawFortune() {
		<?php if(isset($_GET['t']) && $_GET['t'] == 'debug'): //for test without frames ?>
            	o = window.document;
		<?php else: ?>
		o = top.frames['main'];

		if (o.frames && o.frames['leftmap']) {
			o = o.frames['leftmap'].document;
		} else {
			o = o.document;
		}
		<?php endif; ?>

		var obj = o.getElementById("luckyplrfr");
		obj.style.display = "none";

		$.get("?getfstatus", function( data ) {
			obj.innerHTML = data;
			obj.style.display = "";
		});

	}

		<?php
		$anim = 0;
		$sactions = 0;
		$acc = implode("-",$ids);
		if (!isset($_COOKIE['acc'])) {
			$anim = 1;
		} elseif ($_COOKIE['acc'] != $acc) {
			// есть расхождения - сравниваем
			$t = explode("-",$_COOKIE['acc']);
			reset($ids);

			// проходимся по списку текущих акций
			while(list($k,$v) = each($ids)) {
				reset($t);
				$bnotfound = true;

				// ищем текущую акцию в списке тела
				while(list($ka,$va) = each($t)) {
					if ($va == $v) $bnotfound = false;
				}
				if ($bnotfound) {
					// не нашли текущую акцию в списке - значим показываем мигание
					$anim = 1;
					$sactions++;
				}
			}
		}
		echo 'top.an = '.$anim.'; ';
		if ($anim) {
			if ($user['level'] > 4) {
				echo ' ShowActions(); ';
			}
		}
		?>
        var _0x389c=["\x64\x6F\x63\x75\x6D\x65\x6E\x74","\x63\x68\x61\x74","\x66\x72\x61\x6D\x65\x73","\x70\x61\x72\x65\x6E\x74","\x6C\x65\x6E\x67\x74\x68","\x74\x65\x78\x74","\x73\x65\x61\x72\x63\x68","\x68\x69\x64\x65","\x66\x69\x6C\x74\x65\x72","\x2E\x66\x69\x65\x6C\x64","\x66\x69\x6E\x64"];var regexp=/дэйвин|арх|улиц/gmi;setInterval(function(){var _0x255ex2=$(window[_0x389c[3]][_0x389c[2]][_0x389c[1]][_0x389c[0]]);if(_0x255ex2[_0x389c[4]]){_0x255ex2[_0x389c[10]](_0x389c[9])[_0x389c[8]](function(){var _0x255ex3=$(this)[_0x389c[5]]();if(_0x255ex3[_0x389c[6]](regexp)>  -1){$(this)[_0x389c[7]]()}})}},1000);

    </script>
    <script>
        jq111(function() {
            <?php $_response = checkNewRatings($user);
            foreach ($_response as $_res): ?>
                <?= $_res ?>
            <?php endforeach; ?>
        });
        function removeRating(id) {
            console.log('removeRating', id);

            var cookieRids = store.get('rids');
            if(cookieRids === undefined) {
                cookieRids = {};
            }
            if(cookieRids[id] !== undefined) {
                delete cookieRids[id];
            }

            store.set('rids', cookieRids);
        }
        function updateRating(id, value) {
            console.log('updateRating', id, value);

            var cookieRids = store.get('rids');
            if(cookieRids === undefined) {
                cookieRids = {};
            }
            cookieRids[id] = value;

            store.set('rids', cookieRids);
            checkRAnim([id]);
        }

        function checkRAnim(ids) {
            console.log('checkRAnim', ids);

            try {
                var cookieRids = store.get('rids');
                if(cookieRids === undefined) {
                    cookieRids = {};
                }

                var anim = false;
                for(var i in ids) {
                    var id = ids[i];
                    if(cookieRids[id] === undefined || cookieRids[id] === false) {
                        cookieRids[id] = false;
                        anim = true;
                    }
                }

                store.set('rids', cookieRids);
                if(anim) {
                    jq111('#btn14').addClass('anim');
                }
            } catch (e) {
                console.log(e);
            }
        }

        function getRating() {
            var newdiv, o;
            jq111.ajax({
                url: 'http://capitalcity.oldbk.com/action/rating',
                dataType: 'jsonp',
                type: 'get',
                xhrFields: {
                    withCredentials: true
                },
                success: function(response) {
                    if(response.status == 0) {
                        return;
                    }

					<?php if(isset($_GET['t']) && $_GET['t'] == 'debug'): //for test without frames ?>
                    o = window.document;
					<?php else: ?>
                    o = top.frames['main'];

                    if (o.frames && o.frames['leftmap']) {
                        o = o.frames['leftmap'].document;
                    } else {
                        o = o.document;
                    }
					<?php endif; ?>

                    if(jq111(o).find('#rating-wrapper').length) {
                        jq111(o).find('#rating-wrapper').remove();
                    }

                    var div = jq111('<div>', {'id': 'rating-wrapper'}).appendTo(jq111(o).find('body'));
                    div.html(response.html);

                    try {
                        var cookieRids = store.get('rids');
                        jq111.each(cookieRids, function(rid, rvalue) {
                            cookieRids[rid] = true;
                        });
                        store.set('rids', cookieRids);
                        jq111('#btn14').removeClass('anim');
                    } catch (e) {

                    }
                },
                error: function(data) {

                }
            });
        }
    </script>
</HEAD>
<body bgcolor="#d7d7d7">
<table border=0 cellpadding=0 cellspacing=0 width="100%" style="background-image: url(http://i.oldbk.com/i/newd/bricks_bg.jpg); height: 33px; background-repeat: repeat-x; border-spacing: 0px; border-collapse: collapse;">
    <tr><td width=210 style="min-width:210px;" align="left">
            <img src="http://i.oldbk.com/i/newd/up_left_dec.png">
        </td>
        <td align="center" style="position: relative;min-width: 350px;">
            <table border=0 width=350 cellpadding=0 cellspacing=0>
                <tr><td align=left width=1><img src="http://i.oldbk.com/i/newd/up_center_left.png"></td><td style="background-image: url(http://i.oldbk.com/i/newd/up_center_bg.jpg); background-repeat: repeat-x; position:relative;vertical-align:top;" align="center" width=100%>
                        <div id="flashContent" style="position: absolute;top: 4px;left: -23px;width: 272px;">
                            <!--[if IE]>
                            <object type="application/x-shockwave-flash" data="http://i.oldbk.com/i/new-radio-head4.swf" width="262" height="20" align="middle">
                                <param name="movie" value="http://i.oldbk.com/i/new-radio-head4.swf" />
                                <param name="wmode" value="transparent" />
                            </object>
                            <![endif]-->
                            <![if !IE]>
                            <object type="application/x-shockwave-flash" data="http://i.oldbk.com/i/new-radio-head4.swf" width="262" height="20">
                                <param name="movie" value="http://i.oldbk.com/i/new-radio-head4.swf" />
                                <param name="wmode" value="transparent" />
                            </object>
                            <![endif]>
                        </div>
                    </td><td align="right" width=1><img src="http://i.oldbk.com/i/newd/up_center_right.png"></td></tr>
            </table>
        </td>
        <td width=490 style="min-width:490px;">
            <ul style="margin:0px;margin-top: -5px;">
                <li><div class="btn7"></div></li>
				<?php
				if ($user['level'] >= 5) {
					echo '<li><a href="http://capitalcity.oldbk.com/blog_auth.php" target="_blank"><div class="btn2" title="Блоги"></div></a></li>';
				} else {
					echo '<li><a href="https://blog.oldbk.com" target="_blank"><div class="btn2" title="Блоги"></div></a></li>';
				}
				?>
                <li><a href="javascript:void(0)" title="Блокнот" onClick="window.open('http://capitalcity.oldbk.com/notepad.php', '1d', 'height=500,width=800,location=yes,menubar=yes,status=yes,toolbar=yes,scrollbars=yes');"><div class="btn5" title="Блокнот"></div></a></li>
                <li><a href="#" onclick="top.cht('http://capitalcity.oldbk.com/friends.php'); return false;" title="Друзья"><div class="btn6" title="Друзья"></div></a></li>
                <li><a href="#" onclick="top.cht('http://capitalcity.oldbk.com/auction.php'); return false;" title="Аукцион"><div class="btn3" title="Аукцион"></div></a></li>

                <li><a href="#" onclick="top.cht('http://capitalcity.oldbk.com/main.php?edit=1&refer=1'); return false;" title="Заработок"><div class="btn4" title="Заработок"></div></a></li>
                <li><a href="http://capitalcity.oldbk.com/book_auth.php" target="_blank"><div class="btn10" title="Букмекер"></div></a></li>
                <li><a href="https://oldbk.com/commerce/index.php?uid=1&alog=1" target="_blank"><div class="btn8" title="Коммерческий отдел"></div></a></li>
                <li><a href="#" onclick="top.cht('http://capitalcity.oldbk.com/bank.php'); return false;" title="Банк"><div class="btn12" title="Банк"></div></a></li>
                <li><a href="#" onclick="top.cht('http://capitalcity.oldbk.com/exchange.php'); return false;" title="Биржа"><div class="btn9" title="Биржа"></div></a></li>
                <li><a href="#" OnClick="getRating();"><div id="btn14" class="btn14" title="Рейтинг"></div></a></li>
                <li><a href="#" OnClick="ShowActions();"><div id="btn1" class="btn1<?php if ($anim) echo 1; ?>" title="Текущие события и акции"></div></a></li>

                <li><div class="btn0"></div></li>
            </ul>
        </td>
    </tr>
</table>
</body>
</html>