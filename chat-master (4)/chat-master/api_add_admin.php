<?
session_start();
$html_code_on_post=true;

if (!($_SESSION['uid'] >0)) {
	echo "<script>top.window.location='http://capitalcity.oldbk.com/index.php?exit=0.560057875997465.{$_SESSION['uid']}.000.{$_COOKIE['battle']}'</script>";
	die();
}

header("Cache-Control: no-cache");
header('Content-Type: text/html; charset=windows-1251');
$off_html_code_in_post=true;
include 'connect.php';

function BNewHist($user) {

	if (strpos($user['login'],'Невидимка (клон') !== FALSE)
	{
	$user['login'] = '<i>'.$user['login'].'</i>';
	$user['align'] = 0;
	$user['level'] = "??";
	$user['klan'] = "";
	}
	else
	if ($user['hidden'] > 0 ) {
		if ($user[hiddenlog] != '') {
			$user= load_perevopl($user);
		} else {
			$user['id'] = $user['hidden'];
			$user['login'] = '<i>Невидимка</i>';
			$user['align'] = 0;
			$user['level'] = "??";
			$user['klan'] = "";
		}
	}
	return $user['id'].'|'.$user['level'].'|'.$user['align'].'|'.$user['klan'].'|'.$user['login'].'#';
}

function close_dangling_tags($html){

  $html=str_replace('/>','>',$html);
  #put all opened tags into an array
  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
  $openedtags=$result[1];

  #put all closed tags into an array
  preg_match_all("#</([a-z]+)>#iU",$html,$result);
  $closedtags=$result[1];
  $len_opened = count($openedtags);
  # all tags are closed
  if(count($closedtags) == $len_opened){
    return $html;
  }

  $openedtags = array_reverse($openedtags);
  # close tags
  for($i=0;$i < $len_opened;$i++) {
    if (!in_array($openedtags[$i],$closedtags)){
      $html .= '</'.$openedtags[$i].'>';
    } else {
      unset($closedtags[array_search($openedtags[$i],$closedtags)]);
    }
  }
  return $html;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<script>
document.domain = "oldbk.com";
</script>
</HEAD>
<BODY>
<?

if (!isset($_POST['textmess'])) $_POST['textmess'] = "";

if (isset($_SESSION['uid'])) 
	{
		$query = mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
		if (mysql_num_rows($query) != 1) 
		{
		die();
		}
		$user = mysql_fetch_assoc($query);
		if (($user['klan']=='Adminion') OR ($user['klan']=='radminion') )
		{


						if (!isset($_POST['ord'])) $_POST['ord'] = "";
						if (!isset($_POST['addnews'])) $_POST['addnews'] = "";
						if (!isset($_POST['cancel'])) $_POST['cancel'] = "";
						if (!isset($_POST['updatenews'])) $_POST['updatenews'] = "";
						if (!isset($_POST['updateid'])) $_POST['updateid'] = "";

						if (!isset($_GET['hide'])) $_GET['hide'] = "";
						if (!isset($_GET['show'])) $_GET['show'] = "";
						if (!isset($_GET['edit'])) $_GET['edit'] = "";



						if (($_POST['addnews']) and ($_POST['textmess']!=''))
						{
						//постим новость
						mysql_query("INSERT INTO `oldbk`.`new_updates` SET `owner`='{$user['id']}',`owner_data`='".BNewHist($user)."',`message`='".mysql_real_escape_string(close_dangling_tags($_POST['textmess']))."',`top`='".(int)($_POST['ord'])."',`hide`=1;");
						unset($_POST['textmess']);
						//echo "<script> top.frames['chat'].ctab(9); </script>";
						}
						elseif ($_POST['cancel'])
						{
						unset($_GET);
						unset($_POST);						
						}
						elseif ($_POST['updatenews'])
						{
						// апдейт
						$eid=($_POST['updateid']);
						mysql_query("UPDATE  `oldbk`.`new_updates` SET `owner`='{$user['id']}',`owner_data`='".BNewHist($user)."',`message`='".mysql_real_escape_string(close_dangling_tags($_POST['textmess']))."',`top`='".(int)($_POST['ord'])."'   where id='{$eid}' ");
						unset($_POST['textmess']);
						unset($_POST['updateid']);
						$editid=0;
						//echo "<script> top.ctab(9); </script>";
						}						
						elseif ($_GET['delid'])
						{
						$did=(int)$_GET['delid'];
						mysql_query("DELETE FROM `new_updates` WHERE `id`='{$did}'");
						//echo "<script> top.ctab(9); </script>";
						}
						elseif ($_GET['hide'])
						{
						$did=(int)$_GET['hide'];
						mysql_query("UPDATE oldbk.`new_updates` set hide=1 WHERE `id`='{$did}'");
						}						
						elseif ($_GET['show'])
						{
						$did=(int)$_GET['show'];
						mysql_query("UPDATE oldbk.`new_updates` set hide=0, cdate=NOW() WHERE `id`='{$did}'");
						}						
						elseif ($_GET['edit'])
						{
						$gid=($_GET['edit']);
						$ndat=mysql_fetch_assoc(mysql_query("select * from oldbk.new_updates where id='{$gid}'"));
						 if ($ndat['id']>0)
						 	{
						 	$_POST['textmess']=$ndat['message'];
						 	$_POST['ord']=$ndat['top'];
						 	$editid=$ndat['id'];
						 	}
						}

						
					?>
					<form method=POST action="api_add_admin.php">
					<textarea name="textmess"  rows="5" cols="100" style="width: 90%; height: 108px;"><? if (isset($_POST['textmess'])) echo close_dangling_tags($_POST['textmess']);?></textarea>
					<br>
					<small>Позиция</small><input type=text size=4 name=ord value='<?php if (isset($_POST['ord'])) echo $_POST['ord'];?>'>
					<input type=submit name=prenews value='Предварительный просмотр'>
					<?
					if (!isset($editid)) $editid = 0;

					if (($editid>0) or (isset($_POST['updateid']) && $_POST['updateid']>0))
					{

					if (!($editid>0))  {
						if (isset($_POST['updateid'])) {
							$editid=(int)$_POST['updateid'];
						} else {
							$editid=0;
						}
					}

					echo "Index:<input type=text size=3 name=updateid value='".$editid."'>";
					echo "<input type=submit name=updatenews value='Обновить'>";
					echo "<input type=submit name=cancel value='Отмена'>";					
					}
					else
					{
					echo "<input type=submit name=addnews value='Отправить'>";
					}
					?>
					</form>
					<?
	
			$data=mysql_query("select * from oldbk.new_updates order by top desc , cdate desc limit 20; ");
			while($row=mysql_fetch_array($data)) 
			{
			if ((isset($_POST['updateid']) && $row['id']==$_POST['updateid']) and (isset($_POST['prenews']) && !empty($_POST['prenews'])) )
					{
					echo "<span class=date>".date( 'd-m-Y H:i:s', time() )."</span> <span class=stext id=news".$row['id'].">".close_dangling_tags($_POST['textmess'])."</span><br>";
					} 
			else
				{
				$phpdate = strtotime($row['cdate']);
					echo "<span class=date>".date( 'd-m-Y H:i:s', $phpdate )."</span> <span class=stext id=news".$row['id'].">".$row['message']."</span>
					<a href='/api_add_admin.php?delid=".$row['id']."'> <img src='http://i.oldbk.com/i/clear.gif' title='Удалить' alt='Удалить'></a>";
					if ($row['hide']==0)
						{
						echo " <a href='/api_add_admin.php?hide=".$row['id']."'><img src='http://i.oldbk.com/i/down.gif' title='Спрятать' alt='Спрятать'></a>";
						}
						else
						{
						echo " <a href='/api_add_admin.php?show=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' title='Показать' alt='Показать'></a>";
						}
					echo " <a href='/api_add_admin.php?edit=".$row['id']."'><img src='http://i.oldbk.com/i/frendlist/edit_button.png' title='Редактировать' alt='Редактировать'></a>";	
					echo "<br>";
				}	
			}			
					
						if ((isset($_POST['prenews']) && !empty($_POST['prenews'])) and !isset($_POST['updateid']) )
						{
					
						echo "<span class=date>".date( 'd-m-Y H:i:s', time() )."</span> <span class=stext id=news".$editid.">".close_dangling_tags($_POST['textmess'])."</span><br>";

						}					
		}
	}
?>
</BODY>
</HTML>