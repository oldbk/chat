<?php
session_start();

include "connect.php";
include "functions_chat.php";

header("Cache-Control: no-cache");


if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

if (isset($_GET['tsound']) && $_GET['tsound']=='on') {
	$_SESSION['tsound']=1;
	exit();
}

if (isset($_GET['tsound']) && $_GET['tsound']=='off') {
	$_SESSION['tsound']=0;
	exit();
}

if (isset($_GET['answ']) && $_GET['answ']=='turnoff') {
	mysql_query("UPDATE oldbk.`autoanswer` SET `status` = 0 WHERE `id` = '{$_SESSION['uid']}';");
	exit();
}

if (isset($_GET['answ']) && $_GET['answ']=='turnon') {
	$answer="Извините, в данный момент я отсутствую и не могу ответить на ваше сообщение.";
	mysql_query("INSERT oldbk.`autoanswer` (`id`,`answer`,`status`)values('{$_SESSION['uid']}','".$answer."','1') ON DUPLICATE KEY UPDATE `status` ='1';");
	exit();
}

$hsmiles = array(
	"h1" => "http://i.oldbk.com/i/newd/chn/butt1_chat.jpg",
	"h2" => "http://i.oldbk.com/i/newd/chn/butt2_chat.jpg",
	"h3" => "http://i.oldbk.com/i/newd/chn/butt3_chat.jpg",
	"h4" => "http://i.oldbk.com/i/newd/chn/butt4_chat.jpg",
	"h5" => "http://i.oldbk.com/i/newd/chn/butt5_chat.jpg",
	"h6" => "http://i.oldbk.com/i/newd/chn/butt6_chat.jpg",
	"h7" => "http://i.oldbk.com/i/newd/chn/butt7_chat.jpg",
	"h8" => "http://i.oldbk.com/i/newd/chn/up_butt1_chat.jpg",
	"h9" => "http://i.oldbk.com/i/newd/chn/up_butt2_chat.jpg",
	"h10" => "http://i.oldbk.com/i/newd/chn/up_butt3_chat.jpg",
	"h11" => "http://i.oldbk.com/i/newd/chn/up_butt4_chat.jpg",
	"h12" => "http://i.oldbk.com/i/newd/chn/up_butt5_chat.jpg",
	"h13" => "http://i.oldbk.com/i/newd/chn/up_butt6_chat.jpg",
	"h14" => "http://i.oldbk.com/i/newd/chn/m_link1_chat.png",
	"h15" => "http://i.oldbk.com/i/newd/chn/m_link2_chat.png",
	"h16" => "http://i.oldbk.com/i/newd/chn/m_link3_chat.png",
	"h17" => "http://i.oldbk.com/i/newd/chn/m_link4_chat.png",
	"h18" => "http://i.oldbk.com/i/newd/chn/m_link5_chat.png",
	"h19" => "http://i.oldbk.com/i/newd/chn/m_link6_chat.png",
	"h20" => "http://i.oldbk.com/i/newd/chn/m_link7_chat.png",
	"h21" => "http://i.oldbk.com/i/newd/chn/m_link8_chat.png",
	"h22" => "http://i.oldbk.com/i/newd/chn/m_link9_chat.png",
	"h23" => "http://i.oldbk.com/i/newd/chn/m_link10_chat.png",
	"h24" => "http://i.oldbk.com/i/newd/chn/m_link11_chat.png",
	"h25" => "http://i.oldbk.com/i/newd/chn/m_link12_chat.png",
	"h26" => "http://i.oldbk.com/i/newd/chn/m_link13_chat.png",
	"h27" => "http://i.oldbk.com/i/align_3.gif",
	"h28" => "http://i.oldbk.com/i/align_1.5.gif",
	"h29" => "http://i.oldbk.com/i/align_2.gif",
	"h30" => "http://i.oldbk.com/i/align_6.gif",
	"h31" => "http://i.oldbk.com/i/lock.gif",
	"h32" => "http://i.oldbk.com/i/newd/chn/butt41_chat.jpg",
	"h33" => "http://i.oldbk.com/i/newd/chn/butt42_chat.jpg",
	"h34" => "http://i.oldbk.com/i/newd/chn/up_butt8_chat2.jpg",
	"h35" => "http://i.oldbk.com/i/newd/chn/up_butt8_chat3.jpg",
	"h36" => "http://i.oldbk.com/i/newd/chn/bzrh.gif",
	"h37" => "http://i.oldbk.com/i/smiles/up_butt11chat.jpg",
	"h38" => "http://i.oldbk.com/i/newd/m_link22_chat.png",
	"h39" => "http://i.oldbk.com/i/newd/butt10_chat.jpg",
	"h40" => "http://i.oldbk.com/i/newd/m_link23_chat.png",
	"h41" => "http://i.oldbk.com/i/newd/butt11_chat.jpg",
	"h42" => "http://i.oldbk.com/i/newd/butt12_chat.jpg",
);

if (isset($_SESSION['toold'])) $_GET['scan2'] = 1;

if (isset($_GET['showie'])) {
?>
	<HTML><HEAD><meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<TITLE>Смайлики</TITLE>
	<SCRIPT>
	document.domain = "oldbk.com";
	function S(name)
	{
		var sData = parent.dialogArguments;
		sData.F1.text.focus();
		sData.F1.text.value = sData.F1.text.value + ':'+name+': ';
	}
	</SCRIPT>
	</HEAD><BODY leftmargin=2 topmargin=2 marginheight=2 style="cursor:hand" bgcolor=f2f0f0><CENTER>
	<SCRIPT>
	var sm = new Array(
		<?php
			$klansm = "";
			if (strlen($user['klan'])) $klansm = ' or (owner = 0 and klan = "'.$user['klan'].'")';

			$q = mysql_query_cache('SELECT * FROM oldbk.smiles WHERE (klan = "" and (owner = 0 OR owner = '.$user['id'].')) '.$klansm,false,60*5);
			$d = "";
			while(list($k,$s) = each($q)) {
				$d .= '"'.$s['name'].'",'.$s['w'].','.$s['h'].',';
			}
			if (strlen($d)) {
				$d = substr($d,0,strlen($d)-1);
				echo $d;
			}
		?>
	);

	var i=0;
	while(i<sm.length) {
		var s = sm[i++];
		document.write('<IMG SRC=http://i.oldbk.com/i/smiles/'+s+'.gif WIDTH='+sm[i++]+' HEIGHT='+sm[i++]+' BORDER=0 ALT="" onclick="S(\''+s+'\')"> ');
	}

	<?php
		if ($user['deal'] == -1 || $user['id'] == 7108 || $user['klan'] == "pal" || $user['id'] == 14897 ) {
			reset($hsmiles);
			while(list($k,$v) = each($hsmiles)) {
				echo "document.write('<IMG SRC=\"".$v."\" BORDER=0 ALT=\"\" onclick=\"S(\'".$k."\');\"> ');";
			}
		}
	?>

	</SCRIPT>

	<BR><INPUT TYPE="button" value=" Закрыть " onclick="window.close()" style="border: solid 1pt #B0B0B0; font-family: MS Sans Serif; font-size: 10px; color: #191970; MARGIN-BOTTOM: 2px; MARGIN-TOP: 1px;">
	</CENTER></BODY>
	</HTML>
<?php
	die();
}
?>
<!DOCTYPE html>
<HTML><HEAD><link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<script type="text/javascript" src="https://www.gstatic.com/swiffy/v7.4/runtime.js"></script>
<script>
      swiffyobject = {"as3":false,"frameRate":10,"frameCount":3,"backgroundColor":-4408905,"frameSize":{"ymin":0,"xmin":0,"ymax":520,"xmax":1400},"fileSize":5630,"v":"7.4.1","internedStrings":["_global","alarm_sound","alarm_mode","::::40N1I","::::::","gotoAndStop","timer_start","timer_mode","alarm_hourl","alarm_hourh","timer_stop","43D7Y7z35e","::::89k:",":::9x46q23d",":9y7Ga:p","98E0P96k20c","AlarmStat","alarm_minl","alarm_start","94k3c95e5k","alarm_minh","::::49k:","b8i4d3m7j","alarm_dots","b6k8i4l6k","::::53k:","clock_mode","63k2c62f8k","50k3c79f5k","1015E::4237d09Ck",":::9x46j23d","TimerStartKey","a6k8i6k6k","TimerD","alarm_i",":98E0Pa:20ca96k:a:20Cc",":6y0EbW:7CqbLmP9caG8cbHzZ1ca3eFa1dBa3dca1dfaOLaEFaFHa:AaBEaCLaDZaCMbL3D9D3DbA:B:bA:C:c"],"version":6,"tags":[{"data":"data:audio/mpeg;base64,AAD/4yDAAAAAAlgBQAAA/8MD7Mo45C/+YEQKYwMf+FgMETFwnlROArIHpkG+t0w74b0AUAbF/qYG1A9wLhBsig/0PcFIBuWHTiFxpjmf3+wbWHoClBHAyIgmSH/+/FfEAw+MehmBhizBwP/jIMBbJbPmMAGbkAA6v///xkBzxsEDImQEXGXBYxyBwE1////+OAzFKDrFLkDImoUuPgXAShBEyCf/////+WSDkVHeRQvlIhAEWGEYGIvlBqAN7DNh6l1y+kyNO/L5fTV1L+1ab7/9/+MgwB8bA+agAYmgAAQQKhAyJ//5BDSggh///UaIGBOEHL7l////8vpmZu6JfNycW5p/////0GMy+455P0ygQQMt////UgaP//HocAGFGgaN2BwTIGgGBYoe///9+v/1nT3er+tn/7f/4yDADhHzguPpwJgA7r6qR5Jf2V/1V7rb2t9tVeqtJup3t1u1e6C6L0q27r2u9Fa7GpqkYHiiPkRiA6YDahBw0SdMU3cwSPdrrbZHJbAQMExkDRYKnjYGBkQnRE8q8SnYLFQV8FXRL//jIMAhE6AO/l9MAAJYKncsDT1g1UDQcDUiVBosDTwoHYlUocy9IiPYi8qdEsqGrFu///rYJQkFQCGgEqjTiSSgkuupqgAKlUpo/j9qGIoMkpnRUmpB1HNZ1/3rUpbIm180W6mk9k6c/+MgwC0dg+LmVYNpAKzW2n9RgqpFFaNVbv83qezXVoUNbPQQoXTU1admpvSrs7st/bQaggghtq9v+v7/70wugHoG4BRB4Hv/0TFITYFJJr//+kARyYpQ1//Td9f1df6lLbqf6Vzp7rP/4yDAEhRD3tQBgWgAFn/U1J3SU6ka//XTapmUjMUbI//+n+tvXV//qdtS1K69vqZanZN///qFUAKBTZ//zA6URGwAACJik3/9KiZKgYjFgsFgsFgsFgtFdgZ9u7o+s4TnvR/v0Pcz6P/jIMAcGcPfJl+COSbc5TXN/mMQWY5orGn/RiCu7mFR2j//e5/oiiI6HkP//ulr2HB8XmDg3NMInJ//8zpMaYyiQfNe9dqsfaxz//6njUA9BeOFv/9TQnSIiHff//bb4EDbl5mazHic/+MgwBAREU8u/8YQAnna3f/DM7zXZnSld9uDou7kS+sGT90VvIPx+2GcsdFM1ERUKPCZYFmRAPdndS1ZJv///wWAjFjkEkbckGp5f/oZzqtVVV2/31/7ujlauX66l//zOrf/925SmKz/4yDAJhCrYuu3QxADhjZe39/VvSqohZnbpR5aft//////uirRAwoGJThJxKNRmExGAQGARJgABaXDMipSEYXJ0Td16bVpG1m3XRUqtHMmtTY8YLL6DOjOtvOtOGrkToKapDWnrrZndv/jIMA+IQPe3l+DkAAvsxuhQTo9Cypx+dPpLemgkYNtZ7O9eg7smp9SaCdBm0GVl8rWpq1Lq0Xbe+/ozE4Uhzw+AZo63/7ZDAGFI1L//ZZeBUyMiAd23+2u22CAQqMhf+GtaiVVvWma/+MgwBUR22Mi/8gQAlZW/6G7WR1b9P1KXsmrGlahja/2upVL0MoV1+hit9W6/1L+hnVvTQ3yt///////pKxhQGmxBJJf0oAkPCivMrvzf9O7+qPakXT/yTSMwHcmWcBlm/K/dnZ21T//4yDAKBHTXs/+UETb3v//t/rVl+1DP1pcmtF7NRv3a/9+dNaVtzGOGKc46kAgpBpuf9KgLTFTpVFRfVKebmpc+NGnJqnN+TizTmpp6IRsm2+rbqraO2bfv3VuXm+b/skvL6GKxnunNv/jIMA7Eutes/44RNtUry6m/p/Xy3lpSZWAq1b/MABcFGLYWNCFenE+rHCNKg6s5KGdDL1CgnQy4oWOh/FCwHKgmIzixUWbFhcVrFRZsWFxWsVFsWF2ViotiwvrFW6hfivUIAAgACAA/+MgwEoQ+L4UAHjGbCAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACD/4yDAYQAAAlgAAAAAACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgAD8OCQAAAAE\u003d","format":"MP3","id":1,"type":11},{"data":{"bell":1},"type":16},{"type":9,"actions":[{"constants":["Key","#0","ikey2","KE","_root","#5","onLoad","ikey1","KAS","ST","#26","#7","#6","#10","start_time","hours","minutes","sec","#2","#9","#8","#20","#17","#1","Sound","bell","attachSound","setVolume","last_sec","onEnterFrame","time","sub","sub_h","sub_m","sub_s","sech","secl","minh","minl","hourh","hourl","hourf","t_sech","t_secl","t_minh","t_minl","t_hourh","t_hourl","am1","am2","ah1","ah2","#18","#23","#34","play","start","#31","TimerStopKey","#33","s1","s2","m1","m2","h1","h2","TimeD","#16"],"type":136},{"index":0,"type":304},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"type":71},{"type":305,"value":0},{"type":305,"value":52.3},{"type":35},{"index":3,"type":304},{"type":305,"value":0},{"type":305,"value":17.8},{"type":35},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":3,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":7},{"index":4,"type":304},{"type":28},{"index":6,"type":304},{"args":[],"type":155,"body":[{"index":1,"type":304},{"type":28},{"index":7,"type":304},{"type":305,"value":3},{"type":79},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":2},{"type":79},{"index":1,"type":304},{"type":28},{"index":8,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":9,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":305,"value":1},{"type":79},{"index":1,"type":304},{"type":28},{"index":11,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":12,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":13,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":14,"type":304},{"index":4,"type":304},{"type":28},{"index":15,"type":304},{"type":78},{"type":305,"value":3600000},{"type":12},{"index":4,"type":304},{"type":28},{"index":16,"type":304},{"type":78},{"type":305,"value":60000},{"type":12},{"type":71},{"index":4,"type":304},{"type":28},{"index":17,"type":304},{"type":78},{"type":305,"value":1000},{"type":12},{"type":71},{"type":79},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":19,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":20,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":21,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":22,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":23,"type":304},{"type":305,"value":0},{"index":24,"type":304},{"type":64},{"type":79},{"index":25,"type":304},{"type":305,"value":1},{"index":1,"type":304},{"type":28},{"index":23,"type":304},{"type":78},{"index":26,"type":304},{"type":82},{"type":23},{"type":305,"value":100},{"type":305,"value":1},{"index":1,"type":304},{"type":28},{"index":23,"type":304},{"type":78},{"index":27,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":28,"type":304},{"type":305,"value":0},{"type":79}]},{"type":79},{"index":4,"type":304},{"type":28},{"index":29,"type":304},{"args":[],"type":155,"body":[{"index":30,"type":304},{"type":65},{"index":31,"type":304},{"type":65},{"index":32,"type":304},{"type":65},{"index":33,"type":304},{"type":65},{"index":34,"type":304},{"type":65},{"index":35,"type":304},{"type":65},{"index":36,"type":304},{"type":65},{"index":37,"type":304},{"type":65},{"index":38,"type":304},{"type":65},{"index":39,"type":304},{"type":65},{"index":40,"type":304},{"type":65},{"index":41,"type":304},{"type":65},{"index":42,"type":304},{"type":65},{"index":43,"type":304},{"type":65},{"index":44,"type":304},{"type":65},{"index":45,"type":304},{"type":65},{"index":46,"type":304},{"type":65},{"index":47,"type":304},{"type":65},{"index":17,"type":304},{"type":65},{"index":1,"type":304},{"type":28},{"index":8,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":18},{"type":157,"target":146},{"index":31,"type":304},{"type":52},{"index":1,"type":304},{"type":28},{"index":8,"type":304},{"type":78},{"type":11},{"type":305,"value":50},{"type":13},{"type":24},{"type":29},{"index":31,"type":304},{"type":28},{"type":305,"value":10},{"type":103},{"type":18},{"type":18},{"type":157,"target":112},{"index":0,"type":304},{"index":1,"type":304},{"type":28},{"index":7,"type":304},{"type":78},{"type":71},{"type":305,"value":0},{"type":305,"value":52.3},{"type":305,"value":35},{"type":305,"value":3.5},{"index":31,"type":304},{"type":28},{"type":12},{"type":11},{"type":24},{"type":71},{"type":35},{"index":0,"type":304},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"type":71},{"type":305,"value":0},{"type":305,"value":0.5},{"type":305,"value":52.3},{"type":305,"value":3.5},{"index":31,"type":304},{"type":28},{"type":12},{"type":11},{"type":24},{"type":71},{"type":35},{"index":3,"type":304},{"type":305,"value":0},{"type":305,"value":-34.5},{"type":305,"value":52.3},{"type":305,"value":3.5},{"index":31,"type":304},{"type":28},{"type":12},{"type":11},{"type":24},{"type":71},{"type":35},{"type":153,"target":146},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"index":1,"type":304},{"type":28},{"index":7,"type":304},{"type":78},{"type":79},{"index":1,"type":304},{"type":28},{"index":7,"type":304},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":78},{"type":79},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"index":1,"type":304},{"type":28},{"index":9,"type":304},{"type":78},{"type":79},{"index":1,"type":304},{"type":28},{"index":9,"type":304},{"type":78},{"play":false,"frameBias":0,"type":159},{"index":1,"type":304},{"type":28},{"index":8,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":78},{"type":305,"value":3},{"type":73},{"type":18},{"type":157,"target":300},{"index":1,"type":304},{"type":28},{"index":21,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":157,"target":166},{"index":1,"type":304},{"type":28},{"index":21,"type":304},{"type":78},{"type":153,"target":167},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":48,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":22,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":157,"target":187},{"index":1,"type":304},{"type":28},{"index":22,"type":304},{"type":78},{"type":153,"target":188},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":49,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":19,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":157,"target":208},{"index":1,"type":304},{"type":28},{"index":19,"type":304},{"type":78},{"type":153,"target":209},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":50,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":20,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":157,"target":229},{"index":1,"type":304},{"type":28},{"index":20,"type":304},{"type":78},{"type":153,"target":230},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":51,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":265},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":52,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":53,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":153,"target":274},{"type":305,"value":2},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":52,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":291},{"type":305,"value":0},{"index":4,"type":304},{"type":28},{"index":54,"type":304},{"type":78},{"index":55,"type":304},{"type":82},{"type":23},{"type":153,"target":300},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":54,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":78},{"type":305,"value":1},{"type":73},{"type":18},{"type":157,"target":466},{"index":31,"type":304},{"index":1,"type":304},{"type":28},{"index":14,"type":304},{"type":78},{"type":52},{"type":71},{"type":29},{"index":17,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":305,"value":2},{"type":63},{"type":29},{"index":38,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":600000},{"type":63},{"type":305,"value":60000},{"type":13},{"type":24},{"type":29},{"index":37,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":63},{"type":305,"value":600000},{"type":13},{"type":24},{"type":29},{"index":40,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":63},{"type":29},{"index":39,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":13},{"type":24},{"type":29},{"index":17,"type":304},{"type":28},{"type":305,"value":1},{"type":73},{"type":18},{"type":157,"target":384},{"type":305,"value":2},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":53,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":153,"target":393},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":53,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":19,"type":304},{"type":78},{"index":39,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":411},{"type":23},{"index":1,"type":304},{"type":28},{"index":20,"type":304},{"type":78},{"index":40,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":422},{"type":23},{"index":1,"type":304},{"type":28},{"index":21,"type":304},{"type":78},{"index":37,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":433},{"type":23},{"index":1,"type":304},{"type":28},{"index":22,"type":304},{"type":78},{"index":38,"type":304},{"type":28},{"type":73},{"type":18},{"type":157,"target":466},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":305,"value":2},{"type":79},{"index":1,"type":304},{"type":28},{"index":7,"type":304},{"type":305,"value":2},{"type":79},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":1},{"type":79},{"index":1,"type":304},{"type":28},{"index":8,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":9,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":305,"value":3},{"type":79},{"type":129,"frame":2},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":632},{"index":31,"type":304},{"index":1,"type":304},{"type":28},{"index":14,"type":304},{"type":78},{"type":52},{"type":71},{"type":29},{"index":17,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":305,"value":2},{"type":63},{"type":29},{"index":38,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":600000},{"type":63},{"type":305,"value":60000},{"type":13},{"type":24},{"type":29},{"index":37,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":63},{"type":305,"value":600000},{"type":13},{"type":24},{"type":29},{"index":40,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":63},{"type":29},{"index":39,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":13},{"type":24},{"type":29},{"index":1,"type":304},{"type":28},{"index":19,"type":304},{"type":78},{"index":39,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":552},{"type":23},{"index":1,"type":304},{"type":28},{"index":20,"type":304},{"type":78},{"index":40,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":563},{"type":23},{"index":1,"type":304},{"type":28},{"index":21,"type":304},{"type":78},{"index":37,"type":304},{"type":28},{"type":73},{"type":76},{"type":18},{"type":157,"target":574},{"type":23},{"index":1,"type":304},{"type":28},{"index":22,"type":304},{"type":78},{"index":38,"type":304},{"type":28},{"type":73},{"type":18},{"type":157,"target":627},{"index":31,"type":304},{"type":52},{"type":29},{"index":17,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":29},{"index":1,"type":304},{"type":28},{"index":28,"type":304},{"type":78},{"index":17,"type":304},{"type":28},{"type":73},{"type":18},{"type":18},{"type":157,"target":626},{"index":1,"type":304},{"type":28},{"index":28,"type":304},{"index":17,"type":304},{"type":28},{"type":79},{"index":17,"type":304},{"index":17,"type":304},{"type":28},{"type":305,"value":2},{"type":63},{"type":29},{"index":17,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":626},{"type":305,"value":1},{"type":305,"value":0},{"type":305,"value":2},{"index":1,"type":304},{"type":28},{"index":23,"type":304},{"type":78},{"index":56,"type":304},{"type":82},{"type":23},{"type":153,"target":632},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":305,"value":0},{"type":79},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":973},{"index":1,"type":304},{"type":28},{"index":12,"type":304},{"type":78},{"index":1,"type":304},{"type":28},{"index":13,"type":304},{"type":78},{"type":73},{"type":18},{"type":157,"target":693},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":57,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":305,"value":3},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":58,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":42,"type":304},{"index":43,"type":304},{"index":44,"type":304},{"index":45,"type":304},{"index":46,"type":304},{"index":47,"type":304},{"type":305,"value":0},{"index":0,"type":135},{"type":29},{"index":0,"type":303},{"index":0,"type":135},{"type":29},{"index":0,"type":303},{"index":0,"type":135},{"type":29},{"index":0,"type":303},{"index":0,"type":135},{"type":29},{"index":0,"type":303},{"index":0,"type":135},{"type":29},{"index":0,"type":303},{"type":29},{"type":153,"target":859},{"index":1,"type":304},{"type":28},{"index":11,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":722},{"type":305,"value":1},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":57,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":31,"type":304},{"index":1,"type":304},{"type":28},{"index":13,"type":304},{"type":78},{"index":1,"type":304},{"type":28},{"index":12,"type":304},{"type":78},{"type":11},{"type":29},{"type":153,"target":739},{"type":305,"value":2},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":57,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":31,"type":304},{"type":52},{"index":1,"type":304},{"type":28},{"index":12,"type":304},{"type":78},{"type":11},{"type":29},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":72},{"type":18},{"type":157,"target":800},{"index":43,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":100},{"type":63},{"type":305,"value":10},{"type":13},{"type":24},{"type":29},{"index":42,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":1000},{"type":63},{"type":305,"value":100},{"type":13},{"type":24},{"type":29},{"index":45,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":29},{"index":44,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":60000},{"type":63},{"type":305,"value":10000},{"type":13},{"type":24},{"type":29},{"index":47,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":600000},{"type":63},{"type":305,"value":60000},{"type":13},{"type":24},{"type":29},{"index":46,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":63},{"type":305,"value":600000},{"type":13},{"type":24},{"type":29},{"type":153,"target":859},{"index":43,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":29},{"index":42,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":60000},{"type":63},{"type":305,"value":10000},{"type":13},{"type":24},{"type":29},{"index":45,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":600000},{"type":63},{"type":305,"value":60000},{"type":13},{"type":24},{"type":29},{"index":44,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":63},{"type":305,"value":600000},{"type":13},{"type":24},{"type":29},{"index":47,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":63},{"type":29},{"index":46,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":13},{"type":24},{"type":29},{"index":42,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":867},{"index":42,"type":304},{"type":28},{"type":153,"target":868},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":60,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":43,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":886},{"index":43,"type":304},{"type":28},{"type":153,"target":887},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":61,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":44,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":905},{"index":44,"type":304},{"type":28},{"type":153,"target":906},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":62,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":45,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":924},{"index":45,"type":304},{"type":28},{"type":153,"target":925},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":63,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":46,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":943},{"index":46,"type":304},{"type":28},{"type":153,"target":944},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":64,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":47,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":962},{"index":47,"type":304},{"type":28},{"type":153,"target":963},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":59,"type":304},{"type":78},{"index":65,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":10,"type":304},{"type":78},{"type":305,"value":1},{"type":73},{"type":18},{"type":157,"target":1190},{"index":31,"type":304},{"index":1,"type":304},{"type":28},{"index":14,"type":304},{"type":78},{"type":52},{"type":71},{"type":29},{"index":36,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":10000},{"type":63},{"type":305,"value":1000},{"type":13},{"type":24},{"type":29},{"index":35,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":60000},{"type":63},{"type":305,"value":10000},{"type":13},{"type":24},{"type":29},{"index":38,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":600000},{"type":63},{"type":305,"value":60000},{"type":13},{"type":24},{"type":29},{"index":37,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":3600000},{"type":63},{"type":305,"value":600000},{"type":13},{"type":24},{"type":29},{"index":40,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":63},{"type":29},{"index":39,"type":304},{"index":31,"type":304},{"type":28},{"type":305,"value":86400000},{"type":63},{"type":305,"value":3600000},{"type":13},{"type":24},{"type":305,"value":10},{"type":13},{"type":24},{"type":29},{"index":35,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1056},{"index":35,"type":304},{"type":28},{"type":153,"target":1057},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":60,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":36,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1075},{"index":36,"type":304},{"type":28},{"type":153,"target":1076},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":61,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":37,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1094},{"index":37,"type":304},{"type":28},{"type":153,"target":1095},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":62,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":38,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1113},{"index":38,"type":304},{"type":28},{"type":153,"target":1114},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":63,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":39,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1132},{"index":39,"type":304},{"type":28},{"type":153,"target":1133},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":64,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":40,"type":304},{"type":28},{"type":305,"value":0},{"type":73},{"type":157,"target":1151},{"index":40,"type":304},{"type":28},{"type":153,"target":1152},{"type":305,"value":10},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":66,"type":304},{"type":78},{"index":65,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"index":1,"type":304},{"type":28},{"index":18,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":18},{"type":157,"target":1181},{"type":305,"value":2},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":67,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":153,"target":1190},{"type":305,"value":3},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":67,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23}]},{"type":79}]},{"paths":[{"data":[":92m16ea92F:"],"line":0},{"data":[":00g16ea92F:a:4R"],"line":0}],"bounds":"c27c94m4s","linestyles":[{"color":-16777165,"width":10}],"id":2,"type":1},{"depth":1,"id":2,"type":3,"matrix":0},{"paths":[{"data":[":46c2Ia:4ra92F:a:4Ra92f:"],"line":0,"fill":0}],"bounds":"48C4I96f8r","fillstyles":[{"color":-4408905,"type":1}],"linestyles":[{"color":-16777165,"width":5}],"id":3,"type":1},{"descent":13,"ascent":745,"name":"Arial","glyphs":[{"data":":62c62Ea1j72ba0T:a9i72Bc:6G1Qa86B33ga7o:a1f6Pa93b:a4f6pa1p:a94B33Gc","unicode":"A","advance":864},{"data":":92c45Gb4O:9X1jb4I1j4I84bb:3q4i73bb4i0j0x0jb8k:5s8Eb6g9E9j9Qa3N5DbS0h1F8kb3D7c2J7cb0H:0M9Eb0E9E0E8Sb:1M1e9Rb1e9E2m9Eb9e:1j3cb1d3c4e0ia6n5CbY8H5G5Mb4H9G8U9Gc","unicode":"C","advance":766},{"data":":5g33Ga:33ga57e:a:3La09D:a:0Ta68c:a:3La68C:a:3Pa95c:a:4Lc","unicode":"E","advance":685},{"data":":0g33Ga:33ga8n:a:33Gc","unicode":"I","advance":276},{"data":":7g33Ga:33ga8n:a:1Va0l3La1t44ca2s:a91B47Da76b86Ba9S:a99B26ca:26Cc","unicode":"K","advance":789},{"data":":9g27Ga:27ga16e:a:3La68C:a:04Fc","unicode":"L","advance":644},{"data":":3g33Ga:33ga7m:a:77Ea5n77ea3n:a5n77Ea:77ea8m:a:33Ga2V:a2M00ea3M00Ec","unicode":"M","advance":836},{"data":":01d19Fb1i:7n2fb5e2f5e8rb:8l7E2sb7E3f5N3fb9H:6N4Fb8E4F8E9Rb:6L6e9Rb6e3F8n3Fc:B6Lb9H:8O9bb1Eu4I6fb4D4d9F0jb3C6g3C8rb:5q6i75bb7i0j0z0jb2p:8y0Jb7i1J7i78Bb:9Q7I80Bb8I0J0Z0Jc","unicode":"O","advance":839},{"data":":39c09Fa8jcb6cf6e9bbsvs9eb:3cO5ebOv1D1ca3Mia0K:a:6Rc:8N4La:33ga8n:a:06Ca0c:a5gia4d0cbuv8g8ja7j9oa7q:a9H3Nb3E5H4H9Kb2C3C0H1Fb7iN5n8Fb9d4E9d6Mb:5F2C6Kb2C0E5H0Gb4ET1QTc","unicode":"R","advance":787},{"data":":v33Ga:4la8u:a:09fa8n:a:09Fa7u:a:4Lc","unicode":"T","advance":711}],"id":4,"bold":true,"type":5},{"mode":0,"records":[{"color":-16777165,"x":"#32","y":148,"glyphs":":eEhB","text":"ALARM","font":4,"height":160}],"thickness":0,"bounds":"#28","id":5,"gridFit":0,"sharpness":0,"type":6,"matrix":"#21"},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":5,"states":15}],"id":6,"type":10,"actions":[]},{"depth":2,"name":"key3","id":6,"type":3,"matrix":"#13"},{"mode":0,"records":[{"color":-16777165,"x":"#22","y":148,"glyphs":"iFcDf","text":"TIMER","font":4,"height":160}],"thickness":0,"bounds":"#19","id":7,"gridFit":0,"sharpness":0,"type":6,"matrix":"#12"},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":7,"states":15}],"id":8,"type":10,"actions":[{"actions":[{"constants":["#0","KAS","ST"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":2},{"type":79}],"events":2048,"key":0}]},{"depth":5,"name":"Key2","id":8,"type":3,"matrix":"#30"},{"mode":0,"records":[{"color":-65536,"x":"#24","y":148,"glyphs":"adbFc","text":"CLOCK","font":4,"height":160}],"thickness":0,"bounds":"#27","id":9,"gridFit":0,"sharpness":0,"type":6,"matrix":"#25"},{"paths":[{"data":[":46c72ca92F:a:4Ra92f:a:4r"],"line":0,"fill":0}],"bounds":"48C6r96f8r","fillstyles":[{"color":-4408905,"type":1}],"linestyles":[{"color":-16777165,"width":5}],"id":10,"type":1},{"mode":0,"records":[{"color":-65536,"x":"#22","y":148,"glyphs":"iFcDf","text":"TIMER","font":4,"height":160}],"thickness":0,"bounds":"#19","id":11,"gridFit":0,"sharpness":0,"type":6,"matrix":"#12"},{"mode":0,"records":[{"color":-65536,"x":"#32","y":148,"glyphs":":eEhB","text":"ALARM","font":4,"height":160}],"thickness":0,"bounds":"#28","id":12,"gridFit":0,"sharpness":0,"type":6,"matrix":"#21"},{"frameCount":3,"id":13,"type":7,"tags":[{"depth":1,"id":3,"type":3,"matrix":":::::80b"},{"depth":2,"id":9,"type":3,"matrix":"::::40N9r"},{"type":2},{"depth":1,"replace":true,"id":10,"type":3,"matrix":0},{"depth":2,"replace":true,"id":11,"type":3},{"type":2},{"depth":2,"replace":true,"id":12,"type":3},{"type":2}]},{"depth":12,"name":"KE","id":13,"type":3,"matrix":":::9x56c2n"},{"paths":[{"data":["#36"],"fill":0},{"data":[":0q5ga3eFa1dBa3dca1df"],"line":0},{"data":[":9u3CboR0dQb9cA1e3dacmadzaclabea:a:3J3HbLmP9caG8cbHzZ1c:8qaaOLaEFaFH"],"line":0},{"data":["#14"],"line":1},{"data":[":22c0ea2e1db6d5C7d5HbA0E8D5Hb6D6C1K6Cb1F:6J1ca3f1e:3j3ha3J3H:5o4laAab6D5c1K6cb6FA3K6Cb7D6C6D6HbA0E6d5HagE"],"line":2}],"bounds":"8h0M48c73b","fillstyles":[{"color":-13312,"type":1}],"linestyles":[{"color":-16777165,"width":20},{"color":-16777165,"width":40},{"color":-65536,"width":30}],"id":14,"type":1},{"paths":[{"data":["#36"],"fill":0},{"data":["#14"],"line":0},{"data":[":9y0Eb9cA1e3dacmadzaclabea:aafhaefaola1DFa3DCa1Dba3EfbrEz1Cag8CbdZp9CboR0dQ"],"line":1}],"bounds":"0p7I8s3r","fillstyles":[{"color":-13312,"type":1}],"linestyles":[{"color":-16777165,"width":40},{"color":-16777165,"width":20}],"id":15,"type":1},{"frameCount":3,"id":16,"type":7,"tags":[{"type":9,"actions":[{"type":7}]},{"depth":1,"id":14,"type":3,"matrix":0},{"type":2},{"type":9,"actions":[{"type":7}]},{"depth":1,"replace":true,"id":15,"type":3},{"type":2},{"depth":1,"type":4},{"type":9,"actions":[{"type":7}]},{"type":2}]},{"depth":15,"name":"#16","id":16,"type":3,"matrix":"289T::631U95j2g","actions":[{"actions":[{"constants":["#0","ikey1","ikey2","KAS","ST","#26","_root","#5"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":2},{"type":79},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":1},{"type":79},{"index":0,"type":304},{"type":28},{"index":3,"type":304},{"type":305,"value":0},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79},{"index":0,"type":304},{"type":28},{"index":5,"type":304},{"type":305,"value":3},{"type":79},{"type":305,"value":3},{"type":305,"value":1},{"index":6,"type":304},{"type":28},{"index":7,"type":304},{"type":82},{"type":23}],"events":2048,"key":0}]},{"paths":[{"data":[":1Q9Ha:tay:a:Tc"],"fill":0}],"flat":true,"bounds":"1Q9Hyt","fillstyles":[{"color":-3355444,"type":1}],"id":17,"type":1},{"paths":[{"data":["#35"],"fill":0}],"flat":true,"bounds":"#15","fillstyles":[{"color":-4408905,"type":1}],"id":18,"type":1},{"paths":[{"data":[":1T3Ra:8n:A9wa:8N"],"line":0}],"flat":true,"bounds":"7V8T1e37d","linestyles":[{"color":-16777165,"width":50}],"id":19,"type":1},{"paths":[{"data":[":6W2Wa8N::3r9da:8n:7U9wa:8N:5c7sa8n::A4Xa8N:"],"line":0}],"flat":true,"bounds":"#11","linestyles":[{"color":-16777165,"width":50}],"id":20,"type":1},{"paths":[{"data":[":6W2Wa8N::3r9da:8n:A9wa:8N:1R7sa8n::A4Xa8N:"],"line":0}],"flat":true,"bounds":"09D7Y3w35e","linestyles":[{"color":-16777165,"width":50}],"id":21,"type":1},{"paths":[{"data":[":17D3Ra:8n:6u8Na:8n:A9wa:8N:4C7Da8N:"],"line":0}],"flat":true,"bounds":"42D8T6z37d","linestyles":[{"color":-16777165,"width":50}],"id":22,"type":1},{"paths":[{"data":[":6W2Wa8N::3C9da:8n:1r4da8N::2r5sa:8N:1R7sa8n:"],"line":0}],"flat":true,"bounds":"42D7Y5z35e","linestyles":[{"color":-16777165,"width":50}],"id":23,"type":1},{"paths":[{"data":[":6W2Wa8N::3C9da:8n:A9wa:8N:6u8na:8N:1R7sa8n::A4Xa8N:"],"line":0}],"flat":true,"bounds":"43D7Y6z35e","linestyles":[{"color":-16777165,"width":50}],"id":24,"type":1},{"paths":[{"data":[":6W2Wa8N::3r9da:8n:A9wa:8N"],"line":0}],"flat":true,"bounds":"09D7Y3w86d","linestyles":[{"color":-16777165,"width":50}],"id":25,"type":1},{"paths":[{"data":[":6W2Wa8N::3C9da:8n:6u8Na:8n:7U9wa:8N:6u8na:8N:1R7sa8n::A4Xa8N:"],"line":0}],"flat":true,"bounds":"#11","linestyles":[{"color":-16777165,"width":50}],"id":26,"type":1},{"paths":[{"data":[":6W2Wa8N::3C9da:8n:6u8Na:8n:A9wa:8N:1R7sa8n::A4Xa8N:"],"line":0}],"flat":true,"bounds":"42D7Y6z35e","linestyles":[{"color":-16777165,"width":50}],"id":27,"type":1},{"paths":[{"data":[":6W2Wa8N::3C9da:8n:6u8Na:8n:7U9wa:8N:6u8na:8N:1R7sa8n:"],"line":0}],"flat":true,"bounds":"#11","linestyles":[{"color":-16777165,"width":50}],"id":28,"type":1},{"frameCount":10,"id":29,"type":7,"tags":[{"type":9,"actions":[{"type":7}]},{"depth":1,"id":18,"type":3,"matrix":"#29"},{"depth":2,"id":19,"type":3,"matrix":0},{"type":2},{"depth":2,"replace":true,"id":20,"type":3},{"type":2},{"depth":2,"replace":true,"id":21,"type":3},{"type":2},{"depth":2,"replace":true,"id":22,"type":3},{"type":2},{"depth":2,"replace":true,"id":23,"type":3},{"type":2},{"depth":2,"replace":true,"id":24,"type":3},{"type":2},{"depth":2,"replace":true,"id":25,"type":3},{"type":2},{"depth":2,"replace":true,"id":26,"type":3},{"type":2},{"depth":2,"replace":true,"id":27,"type":3},{"type":2},{"depth":2,"replace":true,"id":28,"type":3},{"type":2}]},{"frameCount":10,"id":30,"type":7,"tags":[{"type":9,"actions":[{"type":7}]},{"depth":1,"id":18,"type":3,"matrix":"#29"},{"depth":2,"id":19,"type":3,"matrix":0},{"type":2},{"depth":2,"replace":true,"id":20,"type":3},{"type":2},{"depth":2,"replace":true,"id":21,"type":3},{"type":2},{"depth":2,"replace":true,"id":22,"type":3},{"type":2},{"depth":2,"replace":true,"id":23,"type":3},{"type":2},{"depth":2,"replace":true,"id":24,"type":3},{"type":2},{"depth":2,"replace":true,"id":25,"type":3},{"type":2},{"depth":2,"replace":true,"id":26,"type":3},{"type":2},{"depth":2,"replace":true,"id":27,"type":3},{"type":2},{"depth":2,"replace":true,"id":28,"type":3},{"type":2}]},{"paths":[{"data":[":1R0fay:a:taY:a:T::8May:a:saY:a:S"],"line":0}],"flat":true,"bounds":"1S8H5d8q","linestyles":[{"color":-16777165,"width":20}],"id":31,"type":1},{"frameCount":1,"id":32,"type":7,"tags":[{"depth":1,"id":17,"type":3,"matrix":0},{"depth":2,"name":"h1","id":29,"type":3,"matrix":"034N::397Y51CF"},{"depth":5,"name":"h2","id":29,"type":3,"matrix":"034N::397Y2JF"},{"depth":8,"name":"m1","id":29,"type":3,"matrix":"034N::397Y0yF"},{"depth":11,"name":"m2","id":29,"type":3,"matrix":"034N::397Y98dF"},{"depth":14,"name":"s1","id":30,"type":3,"matrix":"5305C::1974D31f8e"},{"depth":17,"name":"s2","id":30,"type":3,"matrix":"5305C::1974D73g8e"},{"depth":20,"id":31,"type":3,"matrix":0},{"type":2}]},{"depth":17,"name":"TimeD","id":32,"type":3,"matrix":"754E::515N00g0q"},{"type":2},{"depth":2,"type":4},{"depth":5,"type":4},{"depth":15,"type":4},{"depth":17,"type":4},{"type":9,"actions":[{"constants":["Key","#0","ikey2","KE","_root","#5"],"type":136},{"index":0,"type":304},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"type":71},{"type":305,"value":0},{"type":305,"value":52.3},{"type":35},{"index":3,"type":304},{"type":305,"value":0},{"type":305,"value":17.8},{"type":35},{"type":305,"value":2},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":3,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":7}]},{"paths":[{"data":[":54m7hb:wU9cbUq9Dqb0C:0EQbUPU9Cb:Wu0DbtP0ePby:4dlaedbuqu0d"],"line":0},{"data":[":92m32ca:4ra92F:"],"line":1},{"data":[":28m3da3D2daww"],"line":0},{"data":[":80k32ca2u::92F4ra92F:a:4R"],"line":1}],"bounds":"c9b94m92d","linestyles":[{"color":-16777165,"width":5},{"color":-16777165,"width":10}],"id":33,"type":1},{"depth":1,"replace":true,"id":33,"type":3},{"paths":[{"data":[":0D2EaA0jasJa3g9Cb6DZ1I1Ec"],"fill":0},{"data":[":2D6Ea6i4eaAaa8E1ca8Cta:Aa:Aaa2Ja:Aa:Ac:3FZa:1pa:aa3u:a:Aa:1Pc"],"fill":1},{"data":[":3eAa8E1c:8Craa2J:t2iaqH:6CraBa:bAasJ:3H2da:Aa:1Pa3u:a:1p:Caa7O:a3EA:3f4Ma5i4e"],"line":0}],"bounds":"7J4H7u6p","fillstyles":[{"color":-13421773,"type":1},{"color":-4408905,"type":1}],"linestyles":[{"color":-16777165,"width":5}],"id":34,"type":1},{"paths":[{"data":[":6E0Da:3ha0k:a:3Hc"],"fill":0},{"data":[":4e0Da:3ha0K:a:3Hc:0E1Da:0pa:aa:aa3u:a:Aa:5Ka:6Dc"],"fill":1},{"data":[":4e3da0K:a:3Ha0k:a:3h:2e4Laa6da:5k:3UAa:0Pa2u::a1pa3U:"],"line":0}],"bounds":"8J3H7u5p","fillstyles":[{"color":-13421773,"type":1},{"color":-4408905,"type":1}],"linestyles":[{"color":-16777165,"width":5}],"id":35,"type":1},{"frameCount":2,"id":36,"type":7,"tags":[{"type":9,"actions":[{"type":7}]},{"depth":1,"id":34,"type":3,"matrix":0},{"type":2},{"type":9,"actions":[{"type":7}]},{"depth":1,"replace":true,"id":35,"type":3},{"type":2}]},{"depth":2,"name":"#31","id":36,"type":3,"matrix":"::::86l6x","actions":[{"actions":[{"constants":["#0","#7","#6","#10"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":20},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":1},{"type":79},{"type":153,"target":30},{"index":0,"type":304},{"type":28},{"index":3,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":1},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":5,"states":15}],"id":37,"type":10,"actions":[{"actions":[{"constants":["#0","KAS","ST"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":3},{"type":79}],"events":2048,"key":0}]},{"depth":4,"name":"Key3","id":37,"type":3,"matrix":"#30","ratio":1},{"mode":0,"records":[{"color":-16777165,"x":"#24","y":148,"glyphs":"adbFc","text":"CLOCK","font":4,"height":160}],"thickness":0,"bounds":"#27","id":38,"gridFit":0,"sharpness":0,"type":6,"matrix":"#25"},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":38,"states":15}],"id":39,"type":10,"actions":[]},{"depth":15,"name":"Key1","id":39,"type":3,"matrix":"#13","ratio":1},{"depth":18,"name":"#33","id":32,"type":3,"matrix":"082O::805L97e2q","actions":[{"actions":[{"constants":["#0","#7","#6","#10"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":20},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":1},{"type":79},{"type":153,"target":30},{"index":0,"type":304},{"type":28},{"index":3,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":1},{"type":2},{"depth":2,"type":4},{"depth":4,"type":4},{"depth":15,"type":4},{"depth":18,"type":4},{"type":9,"actions":[{"constants":["Key","#0","ikey2","KE","_root","#5"],"type":136},{"index":0,"type":304},{"index":1,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"type":71},{"type":305,"value":0},{"type":305,"value":52.3},{"type":35},{"index":3,"type":304},{"type":305,"value":0},{"type":305,"value":17.8},{"type":35},{"type":305,"value":3},{"type":305,"value":1},{"index":4,"type":304},{"type":28},{"index":3,"type":304},{"type":78},{"index":5,"type":304},{"type":82},{"type":23},{"type":7}]},{"depth":1,"replace":true,"id":2,"type":3},{"paths":[{"data":["#35"],"fill":0}],"flat":true,"bounds":"#15","fillstyles":[{"color":-16711936,"type":1}],"id":40,"type":1},{"frameCount":9,"id":41,"type":7,"tags":[{"depth":1,"id":18,"type":3,"matrix":0},{"type":2},{"type":2},{"type":2},{"type":2},{"depth":1,"replace":true,"id":40,"type":3},{"type":2},{"type":2},{"type":2},{"type":2},{"type":2}]},{"depth":2,"name":"#34","id":41,"type":3,"matrix":"831i:::98f6p","actions":[{"actions":[{"constants":["#0","#2","#1","stop"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":22},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":38,"states":15}],"id":42,"type":10,"actions":[{"actions":[{"constants":["#0","KAS","ST"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":52},{"type":79},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":305,"value":1},{"type":79}],"events":2048,"key":0}]},{"depth":4,"name":"Key1","id":42,"type":3,"matrix":"8D::9x46j23d","ratio":2},{"sounds":[],"records":[{"transform":"#4","depth":1,"id":3,"states":15},{"transform":"#3","depth":2,"id":7,"states":15}],"id":43,"type":10,"actions":[]},{"depth":7,"name":"Key2","id":43,"type":3,"matrix":"8D::9x46q23d","ratio":2},{"depth":10,"name":"#18","id":16,"type":3,"matrix":"681G:::75i9o","actions":[{"actions":[{"constants":["#0","#2","#1","stop"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":0},{"type":73},{"type":18},{"type":157,"target":23},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":1},{"type":79},{"type":153,"target":28},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"depth":15,"name":"ah1","id":29,"type":3,"matrix":"620P::4527C95c2p","actions":[{"actions":[{"constants":["#0","#2","#1","stop","#9","#8"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":23},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79},{"type":153,"target":68},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":80},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":76},{"type":18},{"type":157,"target":48},{"type":23},{"index":0,"type":304},{"type":28},{"index":5,"type":304},{"type":78},{"type":305,"value":4},{"type":103},{"type":18},{"type":157,"target":55},{"index":0,"type":304},{"type":28},{"index":5,"type":304},{"type":305,"value":3},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":3},{"type":73},{"type":18},{"type":157,"target":68},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"depth":18,"name":"ah2","id":29,"type":3,"matrix":"620P::4527C28f2p","actions":[{"actions":[{"constants":["#0","#2","#1","stop","#8","#9"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":23},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79},{"type":153,"target":68},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":80},{"type":79},{"index":0,"type":304},{"type":28},{"index":5,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":76},{"type":18},{"type":157,"target":48},{"type":23},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":3},{"type":103},{"type":18},{"type":157,"target":55},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":10},{"type":73},{"type":18},{"type":157,"target":68},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"depth":21,"name":"am1","id":29,"type":3,"matrix":"620P::4527C03i2p","actions":[{"actions":[{"constants":["#0","#2","#1","stop","#20"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":23},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79},{"type":153,"target":45},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":80},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":6},{"type":73},{"type":18},{"type":157,"target":45},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"depth":24,"name":"am2","id":29,"type":3,"matrix":"620P::4527C37k2p","actions":[{"actions":[{"constants":["#0","#2","#1","stop","#17"],"type":136},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":78},{"type":305,"value":2},{"type":73},{"type":18},{"type":157,"target":23},{"type":305,"value":0},{"index":0,"type":304},{"type":28},{"index":2,"type":304},{"type":78},{"index":3,"type":304},{"type":82},{"type":23},{"index":0,"type":304},{"type":28},{"index":1,"type":304},{"type":305,"value":0},{"type":79},{"type":153,"target":45},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":80},{"type":79},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":78},{"type":305,"value":10},{"type":73},{"type":18},{"type":157,"target":45},{"index":0,"type":304},{"type":28},{"index":4,"type":304},{"type":305,"value":0},{"type":79}],"events":2048,"key":0}],"ratio":2},{"paths":[{"data":[":K6eaw:a:raW:a:R::0Maw:a:raW:a:R"],"line":0}],"flat":true,"bounds":"U4H3d8p","linestyles":[{"color":-16777165,"width":20}],"id":44,"type":1},{"frameCount":2,"id":45,"type":7,"tags":[{"type":9,"actions":[{"type":7}]},{"depth":1,"id":44,"type":3,"matrix":0},{"type":2},{"depth":1,"type":4},{"type":9,"actions":[{"type":7}]},{"type":2}]},{"depth":27,"name":"#23","id":45,"type":3,"matrix":"809C:::33e6p","ratio":2},{"type":2}]};
    </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">
document.domain = 'oldbk.com';
var map_en = new Array('s`h','S`h','S`H','s`Х','sh`','Sh`','SH`',"'o",'yo',"'O",'Yo','YO','zh','w','Zh','ZH','W','ch','Ch','CH','sh','Sh','SH','e`','E`',"'u",'yu',"'U",'Yu',"YU","'a",'ya',"'A",'Ya','YA','a','A','b','B','v','V','g','G','d','D','e','E','z','Z','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','r','R','s','S','t','T','u','U','f','F','h','H','c','C','`','y','Y',"'")
var map_ru = new Array('сх','Сх','СХ','сХ','щ','Щ','Щ','ё','ё','Ё','Ё','Ё','ж','ж','Ж','Ж','Ж','ч','Ч','Ч','ш','Ш','Ш','э','Э','ю','ю','Ю','Ю','Ю','я','я','Я','Я','Я','а','А','б','Б','в','В','г','Г','д','Д','е','Е','з','З','и','И','й','Й','к','К','л','Л','м','М','н','Н','о','О','п','П','р','Р','с','С','т','Т','у','У','ф','Ф','х','Х','ц','Ц','ъ','ы','Ы','ь')

function convert(str)
{	for(var i=0;i<map_en.length;++i) while(str.indexOf(map_en[i])>=0) str = str.replace(map_en[i],map_ru[i]);
	return str;
}

function send(adm) {
	document.write(adm); 
}

function defPosition2(event) {
      var isIE11 = navigator.userAgent.match(/Trident\/7.0.*rv.*11\.0/);
      var x = y = 0;
      if (document.attachEvent != null || isIE11) { // Internet Explorer & Opera
            x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
            y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
			if (window.event.clientY + 10 > document.body.clientHeight) { y-=6 } else { y-=2 }
      } else if (!document.attachEvent && document.addEventListener) { // Gecko
            x = event.clientX + window.scrollX;
            y = event.clientY + window.scrollY;
			if (event.clientY + 10 > document.body.clientHeight) { y-=6 } else { y-=2 }
      } else {
            // Do nothing
      }
      return {x:x, y:y};
}


function translate() {	// translates latin to russian
	var strarr = new Array();
	strarr = document.F1.text.value.split(' ');
	for(var k=0;k<strarr.length;k++) {
		// check for NO url & NO smiles
		if(strarr[k].indexOf("http://") < 0 && strarr[k].indexOf('@') < 0 && strarr[k].indexOf("www.") < 0 && !(strarr[k].charAt(0)==":" && strarr[k].charAt(strarr[k].length-1)==":")) {
			// check for "to [some nick] / private [some nick]"
			if ((k<strarr.length-1)&&(strarr[k]=="to" || strarr[k]=="private")&&(strarr[k+1].charAt(0)=="[")) {
				while ( (k<strarr.length-1) && (strarr[k].charAt(strarr[k].length-1)!="]") ) k++;
			} else { strarr[k] = convert(strarr[k]) }
		}
	}
	document.F1.text.value = strarr.join(' ');
}

function sw_translit()
{
   top.ChatTranslit = ! top.ChatTranslit;
   if (top.ChatTranslit) {
	   $('#b___translit').addClass('btn6active');
       //document.getElementById('b___translit').src = b___translit_on.src;
	   document.getElementById('b___translit').alt = b___translit_on.alt;
	   document.getElementById('b___translit').title = b___translit_on.alt;
   } else {
	   $('#b___translit').removeClass('btn6active');
       //document.getElementById('b___translit').src = b___translit_off.src;
	   document.getElementById('b___translit').alt = b___translit_off.alt;
	   document.getElementById('b___translit').title = b___translit_off.alt;
   }
}

function sw_filter()
{
   top.ChatOm = ! top.ChatOm;
   if (top.ChatOm) {
       //document.getElementById('b___filter').src = b___filter_on.src;
	   $('#b___filter').addClass('btn3active');
	   document.getElementById('b___filter').alt = b___filter_on.alt;
	   document.getElementById('b___filter').title = b___filter_on.alt;
	   document.forms["F1"].om.value = '1';
   } else {
	   $('#b___filter').removeClass('btn3active');
       //document.getElementById('b___filter').src = b___filter_off.src;
	   document.getElementById('b___filter').alt = b___filter_off.alt;
	   document.getElementById('b___filter').title = b___filter_off.alt;
	   document.forms["F1"].om.value = '';
   }
}

function sw_sys()
{
   top.ChatSys = ! top.ChatSys;
   if (top.ChatSys) {
	   $('#b___sys').addClass('btn4active');
       //document.getElementById('b___sys').src = b___sys_on.src;
	   document.getElementById('b___sys').alt = b___sys_on.alt;
	   document.getElementById('b___sys').title = b___sys_on.alt;
	   document.forms["F1"].sys.value = '1';
   } else {
	   $('#b___sys').removeClass('btn4active');
       //document.getElementById('b___sys').src = b___sys_off.src;
	   document.getElementById('b___sys').alt = b___sys_off.alt;
	   document.getElementById('b___sys').title = b___sys_off.alt;
	   document.forms["F1"].sys.value = '';
   }
}

var Answ = false;

function sw_answ()
{
   Answ = !Answ;
   if (Answ) {
       	//document.getElementById('but_answ').src = b___answ_on.src;
	   $('#but_answ').removeClass('btn9active');
	   $('#but_answ').addClass('btn9');
	document.getElementById('but_answ').alt = b___answ_on.alt;
	document.getElementById('but_answ').title = b___answ_on.alt;
        $.get('buttons.php?answ=turnoff', function(data) {});

   } else {
	//document.getElementById('but_answ').src = b___answ_off.src;
	   $('#but_answ').removeClass('btn9');
	   $('#but_answ').addClass('btn9active');
	document.getElementById('but_answ').alt = b___answ_off.alt;
	document.getElementById('but_answ').title = b___answ_off.alt;
        $.get('buttons.php?answ=turnon', function(data) {});
   }
}



function sw_slow()
{
   if (top.ChatSlow) {
     if (top.ChatTimerID >= 0) { // выключаем чат
	   $('#b___slow').removeClass('btn51');
	   $('#b___slow').removeClass('btn52');
	   $('#b___slow').removeClass('btn53');
	   $('#b___slow').addClass('btn53');
	     top.StopRefreshChat();
         //document.getElementById('b___slow').src = b___chat_off.src; 
		document.getElementById('b___slow').alt = b___chat_off.alt;
		document.getElementById('b___slow').title = b___chat_off.alt;
	 } else { // Запускаем чат на нормальную скорость
	   $('#b___slow').removeClass('btn51');
	   $('#b___slow').removeClass('btn52');
	   $('#b___slow').removeClass('btn53');
	   $('#b___slow').addClass('btn51');

	     top.ChatSlow = false;
	     top.ChatDelay=top.ChatNormDelay;
		 top.RefreshChat();
         	//document.getElementById('b___slow').src = b___slow_off.src; 
		document.getElementById('b___slow').alt = b___slow_off.alt;
		document.getElementById('b___slow').title = b___slow_off.alt;
	 }
   } else { // замедляем чат
	   $('#b___slow').removeClass('btn51');
	   $('#b___slow').removeClass('btn52');
	   $('#b___slow').removeClass('btn53');
	   $('#b___slow').addClass('btn52');

     top.ChatSlow = true;
     	//document.getElementById('b___slow').src = b___slow_on.src; 
	document.getElementById('b___slow').alt = b___slow_on.alt;
	document.getElementById('b___slow').title = b___slow_on.alt;
	 top.ChatDelay=top.ChatSlowDelay;
	 top.RefreshChat();
   }
}

function subm()
{
	t = top.frames['chat'].currenttab;
	if (top.ChatTranslit) translate();
	document.getElementById("chtype").value = t;
}

var b___translit_on = new Image; b___translit_on.src="http://i.oldbk.com/i/b___translit_on.gif"; b___translit_on.alt="(включено) Преобразовывать транслит в русский текст";
var b___translit_off = new Image; b___translit_off.src="http://i.oldbk.com/i/b___translit_off.gif"; b___translit_off.alt="(выключено) Преобразовывать транслит в русский текст";
var b___filter_on = new Image; b___filter_on.src="http://i.oldbk.com/i/b___filter_on.gif"; b___filter_on.alt="(включено) Показывать в чате только сообщения адресованные мне";
var b___filter_off = new Image; b___filter_off.src="http://i.oldbk.com/i/b___filter_off.gif"; b___filter_off.alt="(выключено) Показывать в чате только сообщения адресованные мне";
var b___sys_on = new Image; b___sys_on.src="http://i.oldbk.com/i/b___sys_on.gif"; b___sys_on.alt="(включено) Показывать в чате системные сообщения";
var b___sys_off = new Image; b___sys_off.src="http://i.oldbk.com/i/b___sys_off.gif"; b___sys_off.alt="(выключено) Показывать в чате системные сообщения";
var b___slow_on = new Image; b___slow_on.src="http://i.oldbk.com/i/b___slow_on.gif"; b___slow_on.alt="(включено) Медленное обновление чата (раз в минуту)";
var b___slow_off = new Image; b___slow_off.src="http://i.oldbk.com/i/b___slow_off.gif"; b___slow_off.alt="(выключено) Медленное обновление чата (раз в минуту)";
var b___chat_off = new Image; b___chat_off.src="http://i.oldbk.com/i/b___chat_off.gif"; b___chat_off.alt="Обновление чата выключено!";

var b___answ_on = new Image; b___answ_on.src="http://i.oldbk.com/i/answ_start.gif"; b___answ_on.alt="Автоответчик выключен! Включить!";
var b___answ_off = new Image; b___answ_off.src="http://i.oldbk.com/i/answ_stop.gif"; b___answ_off.alt="Автоответчик включен! Выключить!";




function IsIE(elem){ //также эта функция есть выше
	//----------IE,FF,Opera----------------------------no support Safari, Chrome
	ss=top.frames['chat'].document.getElementById('mes').offsetHeight;
	if (ss>0 && (ss-140)>0) ss-=144;
		elem.style.position = 'absolute';
	elem.style.top=ss+'px';
}

function smiles(){
if (false/*document.all && document.all.item && !window.opera && !document.layers*/){
	//rof IE only
   var x = event.screenX - 150;
   var y = event.screenY - 320;
   var sFeatures = 'dialogLeft:'+x+'px;dialogTop:'+y+'px;dialogHeight:310px;dialogWidth:300px;help:no;status:no;unadorned:yes';
   window.showModelessDialog("buttons.php?showie", window, sFeatures);
} else{ 
	//все остальные браузеры
	var sm = new Array(
		<?php
			$klansm = "";
			if (strlen($user['klan'])) $klansm = ' or (owner = 0 and klan = "'.$user['klan'].'")';
			$q = mysql_query_cache('SELECT * FROM oldbk.smiles WHERE (klan = "" and (owner = 0 OR owner = '.$user['id'].')) '.$klansm,false,60*5);

			$d = "";
			while(list($k,$s) = each($q)) {
				$d .= '"'.$s['name'].'",'.$s['w'].','.$s['h'].',';
			}
			if (strlen($d)) {
				$d = substr($d,0,strlen($d)-1);
				echo $d;
			}
		?>
	);
	function createMessage(title, body) {
		var container = document.createElement('div');
		var i=0;
		body='';
		while(i<sm.length){
			var s = sm[i++];
			//javascript:top.AddToPrivate('Baks', top.CtrlPress)
			body +='<a class="hoversmile" href="javascript:void(0)" onClick="SSm(\''+s+'\')"><IMG SRC=http://i.oldbk.com/i/smiles/'+s+'.gif WIDTH='+sm[i++]+' HEIGHT='+sm[i++]+' BORDER=0 ALT="" ></a>';
		}
	
		<?php
			if ($user['deal'] == -1 || $user['id'] == 7108 || $user['klan'] == "pal" || $user['id'] == 14897) {
				reset($hsmiles);
				while(list($k,$v) = each($hsmiles)) {
					echo "body += ' <a class=\'hoversmile\' href=\'javascript:void(0);\' onClick=\"SSm(\'".$k."\');\"><IMG SRC=\"".$v."\"  BORDER=0 ALT=\"\" ></a>';";
				}
			}
		?>


		//container.innerHTML = '<div id="ssmsmilediv" class="ssm-smile"><div class="ssm-smile-title">'+title+'</div><div class="ssm-smile-body">'+body+'</div><input class="ssm-smile-ok" type="button" value="Закрыть"/></div>';
		container.innerHTML = '<div id="ssmsmilediv" class="ssm-smile"><div class="ssm-smile-body">'+body+'</div><input class="ssm-smile-ok" type="button" value="Закрыть"/></div>';

		return container.firstChild;
	}

	function positionMessage(elem) {
		var ua = navigator.userAgent.toLowerCase();
		// Определим Internet Explorer
		//if (ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1) {
		//	IsIE(elem);
		 //}
		//else{
			//------------all browser------------------not support IE
			elem.style.position = 'fixed';
			elem.style.bottom =0+'px';
		//}

		elem.style.right = 2+'px';
	}

	function addCloseOnClick(messageElem) {
		var input = messageElem.getElementsByTagName('INPUT')[0];
		input.onclick = function() {
			messageElem.parentNode.removeChild(messageElem);
		}
	}

	function setupMessageButton(title, body) {
		var messageElem = createMessage(title, body);
		positionMessage(messageElem);
		addCloseOnClick(messageElem);
		top.frames['chat'].document.body.appendChild(messageElem);
	}
	try{
		el=top.frames['chat'].document.getElementById('ssmsmilediv');
		el.parentNode.removeChild(el);
	}
	catch(err){
	}
	setupMessageButton('Смайлики ;)', '');
	}
}
function rslength() // изменяет размер строки ввода текста
{
	var size = document.body.clientWidth-(2*30)-66-256-30;
	if (size<100) { size=100 }
	document.F1.text.width = size;
	document.getElementById('T2').width = size;
}

function clearc()
{
	if (document.forms[0].text.value == '') {
		if(confirm('Очистить окно чата?')) {
			top.frames['chat'].clrchat();
		}
	} else { 
		document.F1.text.value=''; 
	}

	document.F1.text.focus();
}

function clearnew(evt) {
	if (document.forms[0].text.value == '') {
		menu = top.frames['chat'].document.getElementById("ClearMenu");
		if (menu.style.display == "none") {
    			evt = evt || window.event;
    			evt.cancelBubble = true;
                
    			var html = '<p style="margin:10px;"><input type="button" style="cursor:pointer;" OnClick="clearfull();" value="Очистить весь чат"><br style="margin-top:5px;"> \
				    <input type="button" style="font-weight:bold;cursor:pointer;" OnClick="clearpanel();" value="Очистить текущую вкладку"><br style="margin-top:5px;"> \
				    <input type="button" style="cursor:pointer;" value="Отменить" OnClick="top.frames[\'chat\'].document.getElementById(\'ClearMenu\').style.display=\'none\';"><br style="margin-top:5px;"></p> \
			';
                                                         
			 // Если есть что показать - показываем
			if (html) {
        			menu.innerHTML = html;
				var ua = navigator.userAgent.toLowerCase();
				if (false/*ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1*/) {
					ss=top.frames['chat'].document.getElementById('mes').offsetHeight;
					if (ss>0 && (ss-140)>0) ss-=144;
					menu.style.position = 'absolute';
					menu.style.top=ss+'px';
				} else {
					menu.style.position = 'fixed';
					menu.style.bottom =0+'px';
				}

				menu.style.left = defPosition2(evt).x + "px";
				menu.style.display = "";
			}
		} else {
			menu.style.display = "none";
		}
	} else { 
		document.F1.text.value=''; 
	}

	document.F1.text.focus();
}

window.onresize=rslength;

</SCRIPT>

<!--[if IE]>
		<script type="text/javascript" event="FSCommand(command,args)" for="flashsound">
		flashsound_DoFSCommand(command, args);
		</script>
<![endif]-->

<SCRIPT language=JavaScript>
function flashsound_DoFSCommand(command, args) {
	top.frames['bottom'].document.getElementById('soundM').innerHTML='';
}

function SoundB() {
	if (top.SoundOff==true) {
		//top.frames['bottom'].document.getElementById('but_sound').src='http://i.oldbk.com/i/sound.gif';
		document.forms["F1"].tsound.value = 'on'; 
		   $('#but_sound').removeClass('btn81');
		   $('#but_sound').addClass('btn82');

	} else {
		//top.frames['bottom'].document.getElementById('but_sound').src='http://i.oldbk.com/i/sound_off.gif';
		   $('#but_sound').removeClass('btn82');
		   $('#but_sound').addClass('btn81');

		document.forms["F1"].tsound.value = 'off'; }
		top.SoundOff=!top.SoundOff;
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}

function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

var chatsizepos = getCookie("csp");
if (chatsizepos == null) chatsizepos = 1;


chchatpos(0);

function chchatpos(change) {
	if (change == 1) {
	   	$('#but_chchat').removeClass('btnch'+chatsizepos);
		chatsizepos++;
		if (chatsizepos > 3) chatsizepos = 1;
	   	$('#but_chchat').addClass('btnch'+chatsizepos);
	
		setCookie("csp",chatsizepos,"Mon, 01-Jan-2025 00:00:00 GMT");
	}

	var obj = top.document.getElementById("mainchat");

	if (chatsizepos == 1) {
		// 50-50
		obj.rows = "60%,*,0";
	} else if (chatsizepos == 2) {
		obj.rows = "90%,*,0";
		// 90-10
	} else if (chatsizepos == 3) {
		// 10-90
		obj.rows = "10%,*,0";
	}
}

</SCRIPT>

<style>                                                                                                                       

.btn1 {background:url(http://i.oldbk.com/i/newd/butt0_enter.jpg) no-repeat 0 -34px; cursor: pointer; width:47px; height: 34px; display:inline-block;}
.btn1:hover {background-position:0 0px; width:47px; cursor: pointer;}

.btn2 {background:url(http://i.oldbk.com/i/newd/butt1.jpg) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn2:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn3 {background:url(http://i.oldbk.com/i/newd/butt2.jpg) no-repeat 0 -68px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn3:hover {background-position:0 -34px; width:28px; cursor: pointer; }
.btn3active {background:url(http://i.oldbk.com/i/newd/butt2.jpg) no-repeat 0 0px; cursor: pointer; width:28px; height: 34px; display:inline-block;}

.btn4 {background:url(http://i.oldbk.com/i/newd/butt3.jpg) no-repeat 0 -68px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn4:hover {background-position:0 -34px; width:28px; cursor: pointer; }
.btn4active {background:url(http://i.oldbk.com/i/newd/butt3.jpg) no-repeat 0 0px; cursor: pointer; width:28px; height: 34px; display:inline-block;}

.btn51 {background:url(http://i.oldbk.com/i/newd/butt4.jpg) no-repeat 0 -170px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn51:hover {background-position:0 -136px; width:28px; cursor: pointer; }

.btn52 {background:url(http://i.oldbk.com/i/newd/butt4.jpg) no-repeat 0 -102px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn52:hover {background-position:0 -68px; width:28px; cursor: pointer; }

.btn53 {background:url(http://i.oldbk.com/i/newd/butt4.jpg) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn53:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn6 {background:url(http://i.oldbk.com/i/newd/butt5.jpg) no-repeat 0 -68px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn6:hover {background-position:0 -34px; width:28px; cursor: pointer; }
.btn6active {background:url(http://i.oldbk.com/i/newd/butt5.jpg) no-repeat 0 0px; cursor: pointer; width:28px; height: 34px; display:inline-block;}

.btn7 {background:url(http://i.oldbk.com/i/newd/butt6.jpg) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn7:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn81 {background:url(http://i.oldbk.com/i/newd/butt7nn.jpg) no-repeat 0 -102px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn81:hover {background-position:0 -68px; width:28px; cursor: pointer; }

.btn82 {background:url(http://i.oldbk.com/i/newd/butt7nn.jpg) no-repeat 0 0px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn82:hover {background-position:0 -34px; width:28px; cursor: pointer; }

.btn9 {background:url(http://i.oldbk.com/i/newd/butt8.jpg) no-repeat 0 -68px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn9:hover {background-position:0 -34px; width:28px; cursor: pointer; }
.btn9active {background:url(http://i.oldbk.com/i/newd/butt8.jpg) no-repeat 0 0px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn9active:hover {background-position:0 -34px; width:28px; cursor: pointer; }

.btn10 {background:url(http://i.oldbk.com/i/newd/m_link1.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn10:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn11 {background:url(http://i.oldbk.com/i/newd/m_link6.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn11:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn12 {background:url(http://i.oldbk.com/i/newd/m_link2.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn12:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn13 {background:url(http://i.oldbk.com/i/newd/m_link3.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn13:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn14 {background:url(http://i.oldbk.com/i/newd/m_link13.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn14:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn15 {background:url(http://i.oldbk.com/i/newd/m_link10.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn15:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn16 {background:url(http://i.oldbk.com/i/newd/m_link9.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn16:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn17 {background:url(http://i.oldbk.com/i/newd/m_link11.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn17:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn18 {background:url(http://i.oldbk.com/i/newd/m_link4.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn18:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn19 {background:url(http://i.oldbk.com/i/newd/m_link8.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn19:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn20 {background:url(http://i.oldbk.com/i/newd/m_link12.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn20:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn21 {background:url(http://i.oldbk.com/i/newd/m_link5.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn21:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btn22 {background:url(http://i.oldbk.com/i/newd/m_link7.png) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btn22:hover {background-position:0 0px; width:28px; cursor: pointer; }


.btnch3 {background:url(http://i.oldbk.com/i/newd/buttch.jpg) no-repeat 0 -34px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btnch3:hover {background-position:0 0px; width:28px; cursor: pointer; }

.btnch2 {background:url(http://i.oldbk.com/i/newd/buttch.jpg) no-repeat 0 -102px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btnch2:hover {background-position:0 -68px; width:28px; cursor: pointer; }

.btnch1 {background:url(http://i.oldbk.com/i/newd/buttch.jpg) no-repeat 0 -170px; cursor: pointer; width:28px; height: 34px; display:inline-block;}
.btnch1:hover {background-position:0 -136px; width:28px; cursor: pointer; }


#T5 span { font-size:1px; font-weight: 1px;}
</style>

</HEAD>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 bgcolor=#E6E6E6 onload="top.strt(); rslength();" onfocus="document.forms[0].text.focus()">

<FORM action="http://chat.oldbk.com/ch.php" target="refreshed" method=GET name="F1" onSubmit="subm();top.NextRefreshChat();">
<INPUT TYPE="hidden" name="chtype" id="chtype" value="0">
<INPUT TYPE="hidden" name="om" id="om" value="">
<INPUT TYPE="hidden" name="sys" id="om" value="">

<TABLE border=0 width=100% height=30 cellspacing=0 cellpadding=0><TR>
<TD valign=top background="http://i.oldbk.com/i/newd/chat_bg.jpg" id="T1" width=30><IMG SRC="http://i.oldbk.com/i/newd/chat_left_dec.jpg" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Чат"><div id="soundM" style="position:absolute;"></div>
</TD>
<TD style="padding-bottom:4px;" background="http://i.oldbk.com/i/newd/chat_bg.jpg" id="T2"><input type="text" id="ssmtext" name="text" maxlength="400" size=70 style="width:100%;border:0px;"></TD>
<TD valign=top id="T3" style="font-size:1;font-weight:1;" nowrap background="http://i.oldbk.com/i/newd/down_buttons_bg.jpg" bgcolor="#BAB7B3">
<a href="javascript:void(0)" onClick="subm(); document.forms[0].submit();" title="Добавить текст в чат"><span class="btn1"></span></a><?php
if (isset($_GET['scan2'])) { ?>
<a href="javascript:void(0)" onClick="clearc();" title="Очистить строку ввода"><span class="btn2" title="Очистить строку ввода"></span></a><?php } else { ?>
<a href="javascript:void(0)" onClick="clearnew(event);" title="Очистить строку ввода"><span class="btn2" title="Очистить строку ввода"></span></a><?php } ?><a href="javascript:void(0)" onClick="sw_filter();" title="(выключено) Показывать в чате только сообщения адресованные мне"><span id="b___filter" class=btn3 title="(выключено) Показывать в чате только сообщения адресованные мне"></span></a><a href="javascript:void(0)" onClick="sw_sys();" title="(выключено) Показывать в чате системные сообщения"><span class="btn4" id="b___sys" title="(выключено) Показывать в чате системные сообщения"></span></a><a href="javascript:void(0)" onClick="sw_slow();" title="(выключено) Медленное обновление чата (раз в минуту)"><span class="btn51" name="b___slow" id="b___slow" title="(выключено) Медленное обновление чата (раз в минуту)"></span></a><a href="javascript:void(0)" onClick="sw_translit();" title="(выключено) Преобразовывать транслит в русский текст (правила перевода см. в энциклопедии)"><span class="btn6" id="b___translit" name="b___translit" title="(выключено) Преобразовывать транслит в русский текст (правила перевода см. в энциклопедии)"></span></a><a href="javascript:void(0)" onClick="smiles()" title="Смайлики"><span class="btn7" title="Смайлики"></span></a><input type="hidden" name="tsound" id="tsound" value=""><a href="javascript:void(0)" onClick="SoundB(); document.forms[0].action='buttons.php'; document.forms[0].submit(); document.forms[0].action='http://chat.oldbk.com/ch.php'; " title="Звук"><span class="btn81" id="but_sound"></span></a><?php
$answ = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`autoanswer` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
if ($answ['status']==1) {
?><span class="btn9active" title="Автоответчик" OnClick="sw_answ();" id="but_answ"></span><script>Answ=false;</script><?php
} else {
?><span class="btn9" title="Автоответчик" OnClick="sw_answ();" id="but_answ"></span><script>Answ=true;</script><?php
}
?>
<script>document.write('<span class="btnch'+chatsizepos+'" title="Высота чата" OnClick="chchatpos(1);" id="but_chchat"></span>');</script>
</TD>
<TD valign=top id="T4" background="http://i.oldbk.com/i/newd/down_buttons_bg.jpg" bgcolor="#BAB7B3"><IMG SRC="http://i.oldbk.com/i/newd/chat_rigth_dec.jpg" BORDER=0 ALT=""></TD>
<TD valign=top nowrap id="T5" style="font-size:1;font-weight:1;" align=right background="http://i.oldbk.com/i/newd/down_buttons_bg.jpg" bgcolor="#BAB7B3">
	<a href="javascript:void(0)" title="Настройки/Инвентарь"><span class="btn10" ALT="Настройки/Инвентарь" onClick="top.cht('http://<?=CITY_DOMEN;?>/main.php?edit='+Math.random())"></span></a>
<a href="javascript:void(0)" title="Состояние"><span class="btn11" ALT="Состояние" onClick="top.cht('http://<?=CITY_DOMEN;?>/main.php?effects=1&edit='+Math.random());"></span></a>

<?php
	if ($user['level'] >=4) {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/give.php')\" title=\"Передачи\"><span class=btn12 ALT=\"Передачи\" ></span></a>\r\n";
		//echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/auction.php')\" title=\"Аукцион\"><IMG SRC=\"http://i.oldbk.com/i/b_auction2.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Аукцион\" ></a>";
		//echo "<a href='http://oldbk.com/commerce/index.php?act=money&uid={$_SESSION['uid']}&alog={$_SESSION['sid']}' target=_blank title=\"Вывод средств\"><IMG SRC=\"http://i.oldbk.com/i/btn_money.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Вывод средств\" ></a>";
	}
	
	if ($user['klan']) {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/klan.php?'+Math.random())\" title=\"Клан\"><span class=btn13 ALT=\"Клан\"></span></a>\r\n";
	}
	if ((($user['align']>1) && ($user['align']<2)) || (($user['align']>2) && ($user['align']<3))) {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/palklan.php?'+Math.random())\" title=\"Клан\"><span class=btn13 ALT=\"Клан\"></span></a>\r\n";
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/orden.php')\" title=\"Склонность\"><span class=btn14 ALT=\"Склонность\"></span></a>\r\n";
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Склонность\"><span class=btn15 ALT=\"Склонность\"></span></a>\r\n";
	}

	if ($user['id']==5)
	{
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/orden.php')\" title=\"Склонность\"><span class=btn14 ALT=\"Склонность\"></span></a>\r\n";
	}

	if ($user['align'] == 0 && $user['level'] >= 4)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Возможности\"><span class=btn16 ALT=\"Возможности\"></span></a>\r\n";
	}
	// склонки-личные абилки
	if ($user['align']==2)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Склонность\"><span class=btn17 ALT=\"Склонность\"></span></a>\r\n";
	}
	if ($user['align']==3)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Склонность\"><span class=btn18 ALT=\"Склонность\"></span></a>\r\n";
	}
	if ($user['align']==4)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Склонность\"><span class=btn19 ALT=\"Склонность\"></span></a>\r\n";
	}
	if ($user['align']==6)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/myabil.php')\" title=\"Склонность\"><span class=btn15 ALT=\"Склонность\"></span></a>\r\n";
	}

	// абсолютный хаос
	if ($user['align']==5)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/orden.php')\" title=\"Склонность\"><span class=btn19 ALT=\"Склонность\"></span></a>\r\n";
	}
	
	if ($user['align']==7)  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/orden.php')\" title=\"Склонность\"><span class=btn14 ALT=\"Склонность\"></span></a>\r\n";
	}
	//временно пока не закончится баланс 7363
	if (($user['deal']==1) || ($user['id']=='326') || ($user['id']=='8540') || ($user['id']=='14897') || ($user['id']=='6745')   )  {
		echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('http://".CITY_DOMEN."/dealer.php')\" title=\"Дилер\"><span class=btn20 ALT=\"Дилер\"></span></a>\r\n";
	}
	//echo "<a href=\"#\" onclick=\"top.cht('http://".CITY_DOMEN."/friends.php'); return false;\" title=\"Друзья\"><IMG SRC=\"http://i.oldbk.com/i/b___friend.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Друзья\"></a>";
?>
<a href="https://oldbk.com/forum.php" target=_blank title="Форум"><span class=btn21></span></a>

<?php
	/*
	if ($user['level'] >= 5) {
		echo '<a href="http://'.CITY_DOMEN.'/blog_auth.php" target=_blank title="Блоги"><IMG SRC="http://i.oldbk.com/i/4gif.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Блоги"></a>';
	} else {
		echo '<a href="http://blog.oldbk.com/" target=_blank title="Блоги"><IMG SRC="http://i.oldbk.com/i/4gif.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Блоги"></a>';
	}*/
?>
<!--a href="javascript:void(0)" title="Блокнот" onClick="window.open('http://<?=CITY_DOMEN;?>/notepad.php', '1d', 'height=500,width=800,location=yes,menubar=yes,status=yes,toolbar=yes,scrollbars=yes')"><IMG SRC="http://i.oldbk.com/i/b_notepad.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Блокнот"></a>
-->
 <span style="width:5px;display:inline-block;">&nbsp;</span>
<a onclick="if (confirm('Выйти из игры?')) top.window.location='http://<?=CITY_DOMEN;?>/index.php?exit=0.560057875997465'" href="javascript:void(0)" title="Выход из игры"><span class="btn22" ALT="Выход из игры"></span></a>
<span style="width:5px;display:inline-block;">&nbsp;</span>

</TD>

<td width="70" valign="middle" background="http://i.oldbk.com/i/newd/time_bg.jpg" bgcolor="BAB7B3" id="T6">

<div id="swiffycontainer" style="width: 70px; height: 26px">
    </div>
    <script>
      
      var stage = new swiffy.Stage(document.getElementById('swiffycontainer'),
          swiffyobject, {});
	  stage.setFlashVars('hours=<?=date("H")?>&minutes=<?=date("i")?>&sec=<?=date("s")?>');      
	  stage.start();
	  //console.log(stage);
    </script>

</TD>
</TR>
</TABLE>

<SCRIPT language="JavaScript">
var user = top.getCookie("ChatColor");
if ((user != null)&&(user != "")) document.F1.color.value = user;
document.F1.text.focus();
</SCRIPT>
</FORM>
</body>
</html>