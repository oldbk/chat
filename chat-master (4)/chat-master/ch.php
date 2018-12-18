<?php

// Файл для работы на chat.oldbk.com V.2
if (isset($_SERVER['HTTP_REFERER'])) {
	if (stripos($_SERVER['HTTP_REFERER'],'fight-club.ml') !== false) die();
}
			

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
	if (!$a) return $a;
	$c = $b/$a*100;
	return $c;
}

session_start();

function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


function mysql_query2($query) {
	return mysql_query($query);
	/*
        $time_start = microtime_float();
	$q = mysql_query($query);

	$time_end = microtime_float();
	$time = $time_end - $time_start;

	$fp = fopen('/www/chatsql.txt','a');
	if ($fp) {
		if (flock($fp,LOCK_EX)) {
			fwrite($fp,date("d/m/Y H:i:s: ".$time.": ").$query."\r\n");
		}
		fclose($fp);
	}
	return $q;
	*/
}

/*
if (!($_SESSION['loookch'] >0)) {
	$_SESSION['loookch']=time();
} else if ($_SESSION['loookch']==time()) {
	die("AntiDDOS...refresh page");
} else {
	$_SESSION['loookch']=time();
}
*/ 

if (!isset($_SESSION['uid']) || $_SESSION['uid'] == 0) {
	echo "<script>top.window.location='http://capitalcity.oldbk.com/index.php?exit=0.560057875997465';</script>";
	die();
}

header("Cache-Control: no-cache");
header('Content-Type: text/html; charset=windows-1251');

include 'connect.php';
include 'functions_chat.php';

if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com') {
	$ci=1; 
} elseif ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') {
	$ci=2;
} elseif ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com') {
	$ci=3;
}


if ($user['battle'] > 0 && ($user['in_tower'] == 15 || $user['in_tower'] == 2)) {
	$_SESSION['dtlastattack'] = time();
	$_SESSION['ruineslastattack'] = time();
}

$ci = 1; //для нового чата 

$hidden_my['idiluz'] = $user['hidden'];

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


$l22223 = array(
	0 => "Счастье мое, солнце мое %NAME%, я не могу без твоих приватов, без твоего \"с добрым утром\". Я захожу сюда только ради этой улыбки и сладкого поцелуя в привате...",
	1 => "Я прокричу всему миру о своей любви...  Да, я люблю этот мир, но больше всего я люблю %NAME% в этом мире! Никто и никогда не жаждал и не желал %NAME%, так, как об этом мечтаю я...",
	2 => "Что я могу сказать %NAME% про свою любовь... Мы можем быть счастливы вместе, только намекни и я примчусь к тебе моя радость, мое сердцe бьется только для тебя, и в ритм твоего, и остановится если ты прикажешь...",
	3 => "Я не могу больше молчать и буду кричать на каждом углу! Я хочу тебя, %NAME%, давай займемся любовью бейби! Пусть все цветы из цветочки пусть упадут к твоим ногам, ибо никто более их не достоин!",
	4 => "Пусть все завидуют моим чуствам по отношению к %NAME%. Это самая искренняя и самая чистая любовь, которая бывает на свете! Звезды меркнут рядом с этими лучезарными глазами и солнце стыдливо скрывает свой лик, глядя на божественную красоту %NAME%...",
	5 => "Улыбка %NAME%, то, о чем мечтают миллионы, она шикарна, божественна и сводит меня с ума... Я верю, что лишь я стою того, чтобы эта небесная улыбка была предназначена только мне.",
	6 => "Пусть я уйду в блок из-за безответной любви и холодности %NAME%, но все что есть у меня достанется %NAME%, потому что главное, что я люблю!",
	7 => "Я поделюсь своими чувствами, ведь я как сжатая пружина - когда %NAME% нет онлайн, я постоянно обновляю информацию в надежде увидеть %NAME%, подарить поцелуй и цветы, только %NAME% моя радость и наслаждение!",
	8 => "Я люблю %NAME% больше, чем Костолом Ведьмочку, и на нашей свадьбе будут отплясывать все олдбкашники.",
	9 => "Я схожу с ума от любви... Как проснусь утром, сразу онлайн ищу %NAME%, ночью тоже не сплю, мониторю когда %NAME% появится, вот что чертова любовь сделала со мной...",
	10=> "Что творится со мной... Худею... уже меньше на 10 кг, ничего не ем, практически не сплю, а %NAME% где-то ходит, может %NAME% меня совсем не любит? Может это все иллюзии, которые прекратятся, как только я нажму Alt+F4...",
	11=> "Дни шли за днями, и тут я встретил %NAME%, в моем сердце что-то щелкнуло, что-то не так, когда %NAME% нет рядом, я тоскую и не могу думать ни о чем, кроме своих чувств и переживаний...",
	12=> "Я так люблю %NAME%, как вы себе даже представить не можете! Это безумие, это наслаждение, это радость и боль одновременно! Это - Любовь!",
	13=> "Каждое утро встаю и думаю %NAME%. Желаю доброго дня, солнышка, хорошего настроения... С этого начинается мой день... %NAME% - лучшее, что есть в этом безумном мире...",
	14=> "Я не могу жить без %NAME%. Хочется кричать на каждом углу - Люблю, Люблю тебя и только тебя, %NAME%!  Чувства переполняют меня и я знаю теперь - что такое любовь...",
	15=> "%NAME%, я испытываю к тебе невероятно большое и воистину прекрасное чувство, без которого человек не живет, а просто существует – это любовь. Ты для меня всё и даже больше, ради тебя я живу и дышу. Я люблю тебя, и буду любить вечно!",
	16=> "Золотце мое дорогое, %NAME%, я просто без ума от тебя! Я безгранично тебя люблю и безмерно скучаю. Ты моя единственная радость в этом мире, без тебя он серый и мрачный! Очень сильно жду тебя, жду момента, когда снова увижу тебя и смогу окунуться в сладкий мир твоих объятий.",
	17=> "Я люблю %NAME% каждыми секундами, минутами, часами, днями, и ночами. Неделями, месяцами, годами и веками… Мы нашли друг друга среди миллиона, и теперь мы две половинки одного большого сердца. Если %NAME% так не считает, то я не смогу больше жить, потому что сердце не может биться только наполовину…",
	18=> "%NAME% чудесный и очень дорогой для меня человек. Мне так хочется, чтобы мы были счастливы, и я буду, благодарен судьбе, если она разрешит мне познать это счастье!",
	19=> "Сегодня, когда %NAME% придет, я подойду и скажу слова любви. Я скажу это так нежно и ласково, что, когда %NAME% услышит мои слова, они проникнут глубоко в сердце, и разлетятся по всему телу, не пропустив ни одной клеточки, и %NAME% поймет, как сильно Я ЛЮБЛЮ!",
	20=> "Мысли о %NAME% согревают мне душу, озаряют мою жизнь,  с %NAME% я как в счастливом сне, %NAME% – чудо, и я ЛЮБЛЮ!",
	21=> "Человек в жизни влюбляется много раз, но настоящая любовь приходит однажды, и я думаю, я не упустил свою любовь. Я люблю %NAME%!",
	22=> "Я очень бережно храню в своем сердце любовь к %NAME%... Каждый взгляд этих красивых глаз, каждое слово, что произносят эти ангельские губки, каждую секунду, что мы рядом. %NAME% целиком и полностью захватывает собою мою душу и сердце… и не может моё сердечко уже без %NAME%... я люблю тебя, счастье мое!",
	23=> "Я люблю %NAME% за безумно красивые глаза, которые смотрят на меня с нежностью и заботой. Я люблю %NAME% за горячее тело, которое греет меня по ночам. Я люблю..",
	24=> "Я хочу сказать сейчас и навсегда, что я глубоко и страстно люблю %NAME%! %NAME% свет в моей жизни и единственная звезда, которая ярко светит в моем личном небе!",
	25=> "В этом мире есть только две бесконечные вещи: это Вселенная и моя любовь к %NAME%! Хотя вот насчет Вселенной вопрос еще спорный...",
	26=> "Говорят, что любовь как война: легко начать, трудно закончить и невозможно забыть! Так вот признаюсь - я не могу забыть %NAME%!",
	27=> "А вы знаете, какая самая популярная рифма к слову «любовь»? Кровь! Только кровь попадает в сердце и выходит из него, а вот %NAME% теперь навсегда в моём сердце... Потому-что я люблю тебя, %NAME%!",
	28=> "Вот как то так оно сложилось,что рука соскользнула,голова опустилась на плечо,лица не вовремя обернулись друг к другу....И наша дружба с %NAME% полетела ко всем чертям..",
	29=> "Я люблю три вещи! Солнце, луну и %NAME%! Солнце — днем, луну — ночью, и %NAME% — всегда!",
	30=> "%NAME%, Очень я тебя люблю! Взгляд твой каждый день ловлю. Я хочу тебя обнять, нежно-нежно целовать! ",
	31=> "Свеча может расплавиться, огонь — потухнуть. Но любовь к %NAME% всегда горит в моем сердце.",
	32=> "Когда я смотрю в глаза %NAME%, я не могу подобрать нужных слов, теряясь от их божественного света. Я впадаю в безмолвие каждый раз, когда я пытаюсь признаться тебе в любви. Я верю, что %NAME% простит мне эту слабость, ибо знает, что в моем сердце лишь слова любви!",
	33=> "Никогда еще солнце не светило ярче, и дни моей жизни оказались наполненными смыслом, а сердце учащенно забилось при встрече только с одним человеком. Ничего не было до того момента, как мою жизнь озарил лучик света - %NAME%! я очень хочу, чтобы эта любовь никогда не кончалась!",
	34=> "Я азартный человек и мне всегда хотелось выиграть джек-пот. А судьба повернула  так, что встреча с %NAME% оказалась для меня самым крупным выигрышем во вселенной. Без %NAME% я не могу ни есть, ни спать, ни думать. С %NAME% я летаю и мечтаю. В моих мечтах есть место только для %NAME%!",
);

$l22224 = array(
	0 => "Ну что вы такие упертые, посмотрите за окно, там люди ходят, а вы во что превратились?...",
	1 => "Если бы вы знали, как меня достали, но я промолчу, и дерзко промолчу, чтобы вам было стыдно....",
	2 => "Ну и что ты вы на меня вылупились, я что не оправдал ваших намерений в отношении меня, ну так мне пофиг на вас...",
	3 => "Как же вы меня все достали со своим нытьем, просьбами, подхалимажем и упертостью. Ну почему вы не можете радоваться каждому дню, почему вы такие угрюмые, злословные и закомплексованные в своей агресси по отношению к людям, окружающим вас..",
	4 => "Да с вашими комплектами только Исчадие Хаоса [7] пугать :)) Тоже мне, Геркулесы  0го левела нашлись! Ахахах! :))",
	5 => "Не действуйте мне на нервы. Достали уже конкретно! Идите займитесь своими делами!",
	6 => "Закровавить вас всех что ли? Или за ВЦ на ЦП подвесить? :quarrel:",
	7 => "Так, все заткнулись! Мне надоел этот тупой базар, который вы называете - общение! ",
	8 => "Это сейчас кто что сказал? Это мне токшта ктото нахамил? А за базар кто ответит?! ",
	9 => "Я предупреждаю - не трогать меня, если не хотите по башке схлопотать!",
	10=> "Слышь ты! Языком, как помелом, все горазды трепать! А в бой пойти слабо?!",
	11=> "Ну вот и пришло время собирать черепа.. черепушки... Мозги из вас вытрясу, а из черепов ожерелье сделаю...",
	12=> "Фуу... кто это так воняет тут? Советую помыться... А то запах, как из помойки...",
	13=> "Пфф... как воняет этот разговор... Мама походу не научила зубы чистить...",
	14=> "Чтобы вам всем супруги кабель вырвали с корнем, и чтоб вы в олдбк больше никогда не появлялись...",
	15=> "Какие же вы жалкие существа, местами ничтожные, но я благородно никому не расскажу о вашей ущербности...",
	16=> "Каждый день одни и теже рожи, как же вы меня достали своей прямолинейностью",
	17=> "Вместо того, чтобы клянчить у других в долг, проще заложить почку и купить себе арты самостоятельно...",
	18=> "Вас даже палы не блочат за продажу персов на черном рынке, потому что, такой шлак как ваши персы никому не уперся.",
	19=> "Если еще раз увижу эту рожу в своем привате - прямой полет в игнор, я помоему ясно выражаюсь...",
	20=> "Вот думаю я, ну на фига мне видеть ваши рожи? Там нытье, тут нытье, там боты на растишке, поговорить не с кем толком, не то, что сексом заняться...",
	21=> "У меня пост, поэтому в бои не хожу, ристалку игнорирую, и никого видеть не желаю, пошли вон...",
	22=> "Какая дрянь палам слила инфу про мою ДВП? Узнаю кто, он не жилец!",
	23=> "Жалобы на палов придумали для юродивых, потому, что такой умный человек как я, туда фиг пойдет, пока Арми не станет верховным...",
	24=> "Идите вы в лабу или в хаос, у меня при взгляде на вас, аппетит пропадает и стул жидким становится... ",
	25=> "Раньше были люди, а сейчас такие как вы желеподобные существа заполонили олдбк, хотя из вас даже холодец не получится, потому что нет в вас стержня.",
	26=> "Даже времени жалко на то, чтоб всех вас поудалять из друзей и в игнор закинуть...",
	27=> "Этот умник, как котопес, только фиг поймешь,  ум у него, как у кота или как у собаки!",
	28=> "Тебя, что Арми укусил, что ты так паладинов ненавидишь ?",
	29=> "Я конечно могу терпеть, но не такой терпила как некоторые, я ухожу.",
	30=> "Я перехожу в другую склонку, потому что с такими, как мои соотечественники, я даже на одном поле больше не сяду!",
);


$l22227 = array(
	0 => "Мне бармен ведро говорит скакалка... я автостоп уже в титьку... братва документ пьяный )) пхах ))",
	1 => "Да дышу ухом ты пистолет нажрался как ногой стукну свинья! Кто хочет напороца упади на мой валына кулак!",
	2 => "диджейсь морай,стирьхне кштихть-ПАТИ ДО УТРА,отдыхаем хорошо))))",
	3 => "я стерв как трезвышко! А хочешь я ласточку сделаю? :rolf:",
	4 => "Вот говорят: \"Напился - веди себя прилично!\"... Ага, щщщас! Нафига тогда ваааще пить!? ))))))",
	5 => "Капец меня сплю шатает. Баба зузубабулия, пиво _ водка это круто! )",
	6 => "Абсент с коньяком мой выбор, ик-ик-ик ))))) Наше поколение не выбирает Пепси! )))",
	7 => "Блин не могу по клаве попапапапасть, так нажжжжраться, эт надо суметь... ",
	8 => "Блин бухалово зло, не могу понять в каком из окном мой перс в данный момент...",
	9 => "Еееее, как же башка трещит, есть чо похмелица, а то наша раша чуть живоооееееее...",
	10=> "ббббббббббббббббббббббббб, ёпт мордой в клаву ложусь... и вот даже салатика никто не подставит... друзья называются...",
	11=> "nxnxnxnxnxnxnxnxnxnxnxnx хотелось чот написать, но никак не могу вспомнить что, синька зло короче",
	12=> "Жесть, смотрю как белка по столу бежит, рыженькая... народ, чо делать? )))) ",
	13=> "Кто даст ссылку на форум, а то с бухареста ничо найти не могу! :rolf:",
	14=> "Ну фсо... домой не пускают, говорят что я нажратая свинья, и чо делать? Замерзну же на улице!  И стану замерзшая свинья! )))) ахахах! ))",
	15=> "Что-то я, как клоун, пытаюсь всех убедить, что я добрый, веселый, хороший… А суть-то от этого не меняется. Никакой я не вежливый. И людей я не люблю… :grust:",
	16=> "А йа в опу висёёёлыы! :friday:",
	17=> "Ну чо?))) Уыпили, закусили… можна и честь тирять чтоле)))",
	18=> "Разлил бутылку водки на стол. Пичальна, што дубовыыы, нипажевать :grust:",
	19=> "В маем случаи стакан напаловину - виски, наполовину – кола))))))))))))) ыыы :beer:",
	20=> "Сухое вино!? Атсыпьте ка и мне грамуличку))))))",
	21=> "Йа нижду пятницу)))) йа пьйу каждый ден)ь)))",
	22=> "Ахахах! Вчера был бой с пьянством – пьянство победило внатуре! :beer: :rolf:",
	23=> "Мне штота падсказывает, што гдета наливают))) йа та фсё исчо туд))) нипарядак))",
	24=> "Йа много курю, многа пью у миня нед никакова распарятка дыня. И мне за….)) карашооо). :friday:",
	25=> "У миня йэсть идинственый нидатстатак — эта нидстатак алкоголя )))))) Ахахахххххх! ))",
	26=> "Хужы вотки луччи нету))) :brberbrb:",
	27=> "У миня проблемы с алкоголем... Он закончился…((((( :grust:",
	28=> "Вы фсе прикрасны :danceny:  Да, йа пьян... или пьяна... нипомню!.. )))))",
	29=> "Мне сиводня пришло асазнание, как каты пьют малако)))) токшта разлилась бутылка вина))))))))))))))",
	30=> "Када мне атветит каньяк, йа скажу иму Нед))))))))))))",
	31=> "Скажы алкаголю нед денех ))))))))))",
	32=> "Миру мир, а мне пажалуй пефка))) :beer:",
	33=> "Еси трезва смареть на весчи))) то йа бы уыпил))) :friday:",
	34=> "Хачу быть супир героем))) Ани после двацатай рюмки не лажацца на пол))) ани справляюцца с гравитацыей))))",
	35=> "В маей жызни нифсё таг плоха))) кроме таво что йа скора сапьюс))) :friday:",
	36=> "А ты сиводня такоыыы красивыы))))) А йа сиводня такаааа пьяна... пьяна... )))))))",
);

function TrimEPrivate($text) {
	$ret = "";
	preg_match_all('~((to|private)\s*\[.*\])~iU',$text,$m);
	if (isset($m[0]) && count($m[0])) {
		while(list($k,$v) = each($m[0])) {
			$ret .= $v." ";
		}
	}
	return $ret;
	
}

function ChRandomColor($t) {
	$ucolors = array("Black","Blue","Gray","Fuchsia","Green","Maroon","Navy","Olive","Purple","Orange","Chocolate","DarkKhaki","SandyBrown");

	$ret = "";
	$t = explode(" ",$t);
	$isopen = false;
	while(list($k,$v) = each($t)) {
		if (strlen($v)) {
			if (!(strtolower($v) == "to" || strtolower($v) == "private")) {
				if (strpos($v,'[') !== FALSE) {
					$isopen = true;
				}

				if (!$isopen) $v = '<font color="'.$ucolors[mt_rand(0,count($ucolors)-1)].'">'.$v.'</font>';	

				if (strpos($v,']') !== FALSE) {
					$isopen = false;
				}
			}
		}
		$ret .= $v." ";
	}
	return substr($ret,0,-1);
}

function my_strtoupper($str) {
	return str_replace('ё','Ё',preg_replace('#[а-я]#se','chr(ord("$0")-32)',$str)); 
}

function my_strtolower($str) {
	return str_replace('Ё','ё',preg_replace('#[А-Я]#se','chr(ord("$0")+32)',$str)); 
}

function ChDoRandomCaps($t) {
	for ($i = 0; $i < strlen($t); $i++) {
		if (mt_rand(0,1) == 1) {
			$t[$i] = my_strtoupper(strtoupper($t[$i]));
		} else {
			$t[$i] = my_strtolower(strtolower($t[$i]));
		}
	}
	return $t;
}

function ChRandomCaps($t) {
	$ret = "";
	$t = explode(" ",$t);
	$isopen = false;
	while(list($k,$v) = each($t)) {
		if (strlen($v)) {
			if (!(strtolower($v) == "to" || strtolower($v) == "private")) {
				if (strpos($v,'[') !== FALSE) {
					$isopen = true;
				}

				if (!$isopen) {
					$v = ChDoRandomCaps($v);
				}

				if (strpos($v,']') !== FALSE) {
					$isopen = false;
				}
			}
		}
		$ret .= $v." ";
	}
	return substr($ret,0,-1);
}

if (isset($_GET['online'])) {
	// для старого дизайна
	if (isset($_SESSION['toold'])) $_GET['scan2'] = 1;

	if (isset($_GET['room'])) {
		$_GET['room'] = intval($_GET['room']);
	} else {
		$_GET['room'] = 0;
	}


	if (!$_GET['room']) { 
		$_GET['room'] = $user['room']; 
	}

	$top = "top";
	if (isset($_GET['scan'])) {
		$top = "window.opener.top";
		$_SESSION['chview'] = 1;
	} elseif (isset($_GET['scan2'])) {
		$_SESSION['chview'] = 1;
	}

	// защита от сканирования комнат
	if (!(($_GET['room'] >= 0 && $_GET['room'] <= 57 && $user['room'] >= 0 && $user['room'] <= 57) OR ($_GET['room']==$user['room']))) {
		$_GET['room'] = $user['room']; 		
	}

	if($user['room'] < 500) {
		if($user['klan'] != '') {
			$wars=open_clan_war_files($user['klan']);
			if($wars) {
				$agrr=explode(',',$wars[0]);
			}
		}

		if ($user['naim']>0) {
			$get_helped_clan=mysql_fetch_array(mysql_query2("SELECT * from oldbk.clans where id='{$user['naim']}' ;"));
			$wars=open_clan_war_files($get_helped_clan['short']);
			if($wars)  {
				$add_agrr=explode(',',$wars[0]);
				if (isset($agrr) && is_array($agrr)) {
					$agrr=array_merge($agrr,$add_agrr);
				} else {
					$agrr=$add_agrr;
				}
			}
		}
	}

	
	if (!isset($_SESSION['chview'])) $_SESSION['chview'] = 1;
	if (isset($_GET['chview'])) $_SESSION['chview'] = intval($_GET['chview']);

	$defch = 0;
		
	if ($user['in_tower'] != 0) {
		$cache_time=1; 
	} else {
		$cache_time=10; //by default
	}
	

	//для кеширования запросов время идет 1 в 45 сек
	if (!isset($_SESSION['q_time'])) $_SESSION['q_time'] = 0;

	if ((time()-$_SESSION['q_time']) > $cache_time) {
		$_SESSION['q_time']=time();
		$q_time=time()-90;
	} else {
		$q_time=$_SESSION['q_time']-90;
	}


	$d_sql = "";

	switch($_SESSION['chview']) {
		default:
		case 1:
			$d_sql="select align,u.id,exp,klan,level,login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.hidden as iluz,slp,hiddenlog,u.naim,unikstatus,
			(SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM  `users` as u
		    	WHERE (u.`odate` >= ".($q_time)." OR u.`in_tower` = 1 OR u.`in_tower` = 2 OR u.`in_tower` = 15) AND u.`room` = ".intval($_GET['room'])." ORDER by deal DESC, `u`.`login`;";
		break;
		case 2:
			$d_sql="select align,u.id,exp,klan,level,login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.hidden as iluz,slp,u.naim,unikstatus,
			(SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM  `users` as u
					    WHERE ((u.`odate` >= ".($q_time).")) AND u.`id` IN (SELECT `friend` FROM oldbk.friends WHERE owner = ".$user['id']." and type = 0 AND klan_list = '')  ORDER by deal DESC, `u`.`login`;";

		break;
		case 3:
			$d_sql="select align,u.id,exp,klan,level,login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.hidden as iluz,slp,u.naim,unikstatus,
			(SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM  `users` as u
					    WHERE (u.`odate` >= ".($q_time).") AND u.`klan` ='pal' AND align != '1.2' ORDER by align DESC, `u`.`login`;";
		break;
		case 4:
			$d_sql="select align,u.id,exp,klan,level,login AS login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.hidden as iluz,u.id_city as id_city,slp,u.naim,unikstatus,
				(SELECT `id` FROM oldbk.effects WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal AS kdeal FROM  oldbk.`users` as u
					    WHERE (u.`odate` >= ".($q_time).") AND u.deal>0 AND id_city = 0
				ORDER by kdeal ASC, login";
		break;
		case 5:
			if ($user['klan'] != "") {
				$one = $user['klan'];
				$tow = "";

				$q = mysql_query_cache('SELECT * FROM oldbk.clans WHERE short = "'.$user['klan'].'"',false,60*60);
				if (count($q) > 0) {
					$q = $q[0];
					$defch = $q['defch'];
					if ($q['rekrut_klan'] > 0) {
						$q2 = mysql_query_cache('SELECT * FROM oldbk.clans WHERE id = "'.$q['rekrut_klan'].'"',false,60*60);
						if (count($q2) > 0) {
							$q2 = $q2[0];
							$two = $q2['short'];
						}
					} elseif ($q['base_klan'] > 0) {
						$q2 = mysql_query_cache('SELECT * FROM oldbk.clans WHERE id = "'.$q['base_klan'].'"',false,60*60);
						if (count($q2) > 0) {
							$q2 = $q2[0];
							$two = $q2['short'];
						}
					}
				}

				$sqlklan = " (u.`klan` = '".$one."' ";
				if (isset($two) && strlen($two)) $sqlklan .= " or u.`klan` = '".$two."' ";
				$sqlklan .= " ) ";

				$sort = "";
				if ($user['id_city'] == 1) {
					$sort = ' DESC ';
				} else {
					$sort = ' ASC ';
				}

				$d_sql="select align,u.id,exp,klan,level,login AS login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.id_city as id_city,u.hidden as iluz,slp,u.naim,unikstatus,
				(SELECT `id` FROM oldbk.effects WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM  oldbk.`users` as u
						    WHERE (u.`odate` >= ".($q_time).") AND ".$sqlklan. " AND id_city = 0
					ORDER by id_city ".$sort.", login
				";
			}
		break;
		case 6:
			$sort = "";
			if ($user['id_city'] == 1) {
				$sort = ' DESC ';
			} else {
				$sort = ' ASC ';
			}

			$d_sql="
			select align,u.id,exp,klan,level,login,battle,deal,odate,u.id_grup as id_grup,u.room as room,u.podarokAD as podarokAD, u.ruines as ruines,u.hidden as iluz,slp,u.naim,u.id_city as id_city, unikstatus,
			(SELECT `id` FROM oldbk.`effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM  oldbk.`users` as u
					    WHERE (u.`odate` >= ".($q_time).") AND (u.`deal`= -1)
			ORDER by id_city ".$sort.", login
			";
		break;
	}

	if ($d_sql != '') {
		//$data = mysql_query2($d_sql);
		$data = mysql_query_cache($d_sql,false,$cache_time);
	} else {
		if (isset($miniBB_gzipper_encoding)) {
			$miniBB_gzipper_in = ob_get_contents();
			$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
			$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
			$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
			$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
			$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
			$percent = round($gzpercent);
			$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' Сompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
			$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
			ob_clean();
			header('Content-Encoding: '.$miniBB_gzipper_encoding);
			echo $miniBB_gzipper_out;
			die();
	    	}     		
	}

	// название комнаты
	if (($user['room']>=1000) and ($user['room']<10000)) {
		include 'ruines_rooms.php';
		$du=(int)($user['room']*0.01);
		$du=$du*100;
		$user_room=$user['room']-$du;
		$room_name=$rooms[$user_room][0];
	} elseif ($user['room'] > 10000 && $user['room'] < 11000) {
		include 'dt_rooms.php';
		$room_name=$dt_rooms[$user['room']][0];
	} elseif ($user['room'] >= 49998 && $user['room'] <= 60000) {
		include "map_config.php";
		reset($map_locations);
		$bfound = false;
		while(list($k,$v) = each($map_locations)) {
			if ($user['room'] == $v['room']) {
			    	$room_name = $v['name'];
				$bfound = true;
			}
		}
		if (!$bfound) $room_name = 'Загород';
	} elseif ($user['room'] >= 61001 && $user['room'] <= 62000) {
		$q = mysql_query2('SELECT * FROM station_go WHERE room = '.$user['room']);
		$ci = mysql_fetch_assoc($q);
		if ($ci !== FALSE) {
			$room_name = "Карета №".$ci['num'];
		} else {
			$room_name = "Карета";
		}
	} elseif ($user['room'] >= 70000 && $user['room'] <= 72000) {
		if ($user['room'] == 70000) {
			$room_name = 'Замки';
		} else {
			require_once('castles_config.php');
			if ($user['room'] > 70000 && $user['room'] < 71000) {
				$cid = $user['room']-70000;
			} elseif ($user['room'] >= 71000 && $user['room'] <= 72000) {
				$cid = $user['room']-71000;
			}
			$c = mysql_query_cache('SELECT * FROM oldbk.castles WHERE `id` = '.$cid, false, 24*3600);
			$c = $c[0];
			$room_name = $castles_config[$c['num']]['name'].' замок ['.$c['nlevel'].']';
		}
	} elseif ($user['room'] == 72001) {
			$room_name = 'Замковые турниры';
	} elseif ($user['lab']>0) {
		$room_name = "Лабиринт Хаоса";
	} elseif ($user['in_tower'] == 3) {
		$room_name = "Турниры: Одиночные сражения";		
	} else {
		$room_name = $rooms[$_GET['room']];
	}


	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<HTML><HEAD><link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<style>
	.ahm {
		FONT-WEIGHT: bold; COLOR: #003388; TEXT-DECORATION: none
	}
	.ahm:visited {
		FONT-WEIGHT: bold; COLOR: #003388; TEXT-DECORATION: none
	}
	.ahm:active {
		COLOR: #6f0000
	}
	.ahm:hover {
		COLOR: #0066ff
	}		
	</style>
	<SCRIPT>
	document.domain = "oldbk.com";

	function w(name,id,align,klan,level,slp,trv,deal,battle,war,r,rk,hh,tlvl,us,bot) {
			var fight = '';
			var altext = '';

			if (align.length>0) {
				altext="";
				if (align>2 && align<3) altext = "Ангел";
				if (align>1 && align<2 && klan !="FallenAngels") altext = "Паладин";
				if (align>1 && align<2 && klan =="FallenAngels") altext = "Падший ангел";
				if ( align == 3 ) altext ="Тёмный";
				if ( align == 4 ) altext ="В хаосе";
				if ( align == 2 ) altext ="Нейтрал";
				if ( align == 5 ) altext ="Истинный Хаос";
				if ( align == 6 ) altext ="Светлый";
				if ( align == 1 ) altext ="Светлый";
				if ( align == "2.4") altext ="Нейтрал";
				align='<img src="http://i.oldbk.com/i/align_'+align+'.gif" title="'+altext+'" width=12 height=15>';
			}

			if (battle>0) { fight = '2'}
			if (klan.length>0) { klan='<A HREF="http://oldbk.com/encicl/klani/clans.php?clan='+klan+'" target="_blank"><img src="http://i.oldbk.com/i/klan/'+klan+'.gif" title="Клан '+klan+'. Нажмите, чтобы открыть страницу клана в библиотеке." ></A>';}
			if (deal==1 && id!=7363) { klan+='<img src="http://i.oldbk.com/i/deal.gif" width=15 height=15 title="Дилер">';}

			color = "";
			if (r > 0) { if (r == 1) { color="blue"; } if (r == 2) { color="red";} }
			colorstart = "<font color="+color+">";
			colorend = "</font>";
			if (color.length == 0) {
				colorstart = "";
				colorend = "";
			}
			keyowner = "";
			if (rk > 0) keyowner = " <img border=0 src=\"http://i.oldbk.com/i/sh/ruin_k.gif\"> ";
			if (hh > 0) keyowner = " <img border=0 src=\"http://i.oldbk.com/i/map/horse_chat.gif\"> ";

			lvlcolorstart = "";
			lvlcolorend = "";
			if (tlvl == 1) {
				lvlcolorstart = "<b style=\"color:#F03C0E;\">";
				lvlcolorend = "</b>";
			}

			document.write(keyowner+'<img OnClick="<?php echo $top; ?>.AddToPrivate(\''+name+'\', <?php echo $top; ?>.CtrlPress,event); return false;" src="http://i.oldbk.com/i/lock'+fight+'.gif" style="cursor:pointer;" title="Приват" width=20 height=15></A>'+align+klan+'<span OnClick="<?php echo $top; ?>.AddTo(\''+name+'\',event); return false;" class="ahm" style="cursor:pointer;">'+colorstart+name+colorend+'</span>'+'['+lvlcolorstart+level+lvlcolorend+']'+'<a href="http://<?=CITY_DOMEN;?>/inf.php?'+id+'" target=_blank title="Инф. о '+name+'">'+'<IMG SRC="http://i.oldbk.com/i/inf.gif" WIDTH=12 HEIGHT=11 BORDER=0 ALT="Инф. о '+name+'"></a>');
			if (slp>0) { document.write(' <IMG SRC="http://i.oldbk.com/i/sleep2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="Наложено заклятие молчания">'); }
			if (trv>0) { document.write(' <IMG SRC="http://i.oldbk.com/i/travma2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="Инвалидность">'); }
			if (war==1){ document.write(' <b><a href=# onclick="<?php echo $top; ?>.cht(\'http://capitalcity.oldbk.com/klan.php?razdel=wars&post_attack='+id+'\');"> X</a></b>'); }
			if (bot==3){ document.write(' <b><a href=# onclick="<?php echo $top; ?>.cht(\'http://capitalcity.oldbk.com/main.php?edit=1&bot_attack='+id+'\');"> X</a></b>'); }
			if (us !== undefined && us.length) {
				document.write(' <IMG SRC="http://i.oldbk.com/i/chat/chat_icon_status.png" BORDER=0 title="'+us+'" alt="'+us+'">');
			}
			document.write('<BR>');
	}
	

	
	top.rld();                        
</SCRIPT>
<script type='text/javascript' src='http://i.oldbk.com/i/js/recoverscroll.js'></script>
</HEAD>
<body style="margin:0px;padding:0px;" bgcolor="#eeeeee">
<?php if (!isset($_GET['scan'])) { ?>
<script type='text/javascript'>
RecoverScroll.start();
</script>
<?php } ?>
<center>
<?php
if (!isset($_GET['scan']) && !isset($_GET['scan2'])) {
?>
<div id="fixednew" style="position:fixed;margin:0px;padding:0px;z-index:9;width:100%;text-align:center;overflow:auto;">
<table border=0 cellpadding=0 cellspacing=0><tr>
<?php
for ($i = 1; $i <= 6; $i++) {
	if ($i == $_SESSION['chview']) {
		echo '<td><img align=left OnClick="this.src=\'http://i.oldbk.com/i/chat/ch'.$i.'_passive.jpg\';location.href=\'http://chat.oldbk.com/ch.php?online=\'+Math.random();" src="http://i.oldbk.com/i/chat/ch'.$i.'_active.jpg"></td>';
	} else {

		switch($i) {
			case 1:
				$title = "Общая";
			break;
			case 2:
				$title = "Друзья";
			break;
			case 3:
				$title = "Паладины";
			break;
			case 4:
				$title = "Дилеры";
			break;
			case 5:
				$title = "Соклановцы";
			break;
			case 6:
				$title = "Помощники";
			break;

		}

		if ($i == 5 && $user['klan'] == "") {
			echo '<td><img align=left title="'.$title.'" alt="'.$title.'" src="http://i.oldbk.com/i/chat/ch'.$i.'_passive.jpg"></td>';
			continue;
		}
		echo '<td><img align=left title="'.$title.'" alt="'.$title.'" style="cursor:pointer;" OnClick="location.href=\'http://chat.oldbk.com/ch.php?online=\'+Math.random()+\'&chview='.$i.'\';" src="http://i.oldbk.com/i/chat/ch'.$i.'_passive.jpg"></td>';
	}
}
?>
<td><img align=left src="http://i.oldbk.com/i/chat/refresh_active.jpg" style="cursor:pointer;" OnClick="this.src='http://i.oldbk.com/i/chat/refresh_passive.jpg';location.href='http://chat.oldbk.com/ch.php?online='+Math.random();" title="Обновить" alt="Обновить"></td>
</tr></table>
</div>
<br><br><br>
<?php
}
?>

<div>
<?php
	if(($user['klan'] == 'radminion' || $user['klan'] == 'Adminion' || $user['id'] == 326 || $user['id'] == 188) && isset($_GET['online'])) {
		echo "{$user['klan']} information: ".exec('hostname')."<br>";
		//echo $_SERVER['HTTP_REFERER'];
		echo "<font style='font-size:9px'>".exec('uptime')."</font><br>";
	
	}

	echo '
		<script>
			function Prv(logins) {
				top.frames[\'bottom\'].window.document.F1.text.focus();
				top.frames[\'bottom\'].document.forms[0].text.value = logins + top.frames[\'bottom\'].document.forms[0].text.value;
			}

		</script>
	';


	if ($_SESSION['chview'] == 5) {
		echo '
			<IMG SRC=http://i.oldbk.com/i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват клану" style="cursor:pointer" onClick="Prv(\'private [klan] \')"> приват клану<br>
			<IMG SRC=http://i.oldbk.com/i/lock_kl.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват межклану" style="cursor:pointer" onClick="Prv(\'private [mklan-'.$defch.'] \')"> приват межклану<br>
		';
	}

	if ($_SESSION['chview'] == 6 && ($user['deal'] == -1) ) {
		echo '
		<IMG SRC=http://i.oldbk.com/i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват помощников" style="cursor:pointer" onClick="Prv(\'private [helpers] \')"> приват помощников<br>
		';
	}


?>
<?php if (isset($_GET['scan2'])) echo '<br>'; ?>

<?php if (!isset($_GET['scan'])) { ?>
<INPUT TYPE=button value="Обновить" onclick="location='ch.php?<?php if (isset($_GET['scan2'])) echo 'scan2=1&'; ?>online='+Math.random()"><br>
<?php } ?>

<?php 
	$output = '<font style="COLOR:#8f0000;FONT-SIZE:10pt"><B>';
	
	//$chcount=mysql_num_rows($data);
	$chcount=count($data);

	switch($_SESSION['chview']) {
		default:
		case 1:
			$myroom = $room_name.' ('.$chcount.')'; 
		break;
		case 2:
			$myroom = 'Друзья онлайн ('.$chcount.')'; 
		break;
		case 3:
			$myroom = 'Паладины онлайн ('.$chcount.')'; 
		break;
		case 4:
			$myroom = 'Дилеры онлайн ('.$chcount.')'; 
		break;
		case 5:
			$myroom = 'Соклановцы '; 
		break;
		case 6:
			$myroom = 'Помощники '; 
		break;
	}

	$output2 = '
	</B></font>
	</center>

	<table border=0 width=100%><tr><td nowrap>
	<script>
	document.domain = "oldbk.com";
	';

	$ruines_map = array();
	$citycheck = -1;
	$it = 0;
	$roomok = false;
	$w = "";
	
	//while($row=mysql_fetch_array($data)) 	{
	$xxx=0;
	while (list($k,$row) = each($data)) {
	        if (strlen($row['unikstatus'])) $row['unikstatus'] = addslashes(str_replace("\r","",str_replace("\n","",htmlspecialchars($row['unikstatus'],ENT_QUOTES,"cp1251"))));
		$tlvl = 0;
		if ($row['level']==13 && $row['exp']>=8000000000) {
			$tlvl = 1;
		}
		$it++;
		if ($_SESSION['chview'] == 5 || $_SESSION['chview'] == 6) {
			if ($citycheck == -1) {
				$citycheck = $row['id_city'];
				if ($citycheck == $user['id_city']) {
					$myroom .= 'в моём городе ';
				} else {
					$myroom .= 'в другом городе ';
				}
			} elseif ($citycheck != $row['id_city']) {
				$citycheck = $row['id_city'];
				$myroom .= ' ('.($it-1).') ';
				$roomok = true;
				if ($_SESSION['chview'] == 5) {
					$w .= '</script><br><center><font style="COLOR:#8f0000;FONT-SIZE:10pt"><B>Соклановцы в другом городе ('.($chcount-($it-1)).')</b></font></center><script>';
				} elseif ($_SESSION['chview'] == 6) {
					$w .= '</script><br><center><font style="COLOR:#8f0000;FONT-SIZE:10pt"><B>Помощники в другом городе ('.($chcount-($it-1)).')</b></font></center><script>';
				}
			}
		}

		if ($row['ruines'] > 0 && !count($ruines_map)) {
			$q = mysql_query2('SELECT * FROM `ruines_map` WHERE id = '.$row['ruines']);
			if (mysql_num_rows($q) > 0) $ruines_map = mysql_fetch_assoc($q) or die();
		}


		if ($row['iluz']==0) {
			if($row['id'] == 83) {
				$ar = mysql_fetch_array(mysql_query2("SELECT battle from bots WHERE prototype='83' limit 1;"));
				if($ar[0] > 0) {
					$row['battle'] = $ar[0];
				}
			}

			if(isset($agrr) && is_array($agrr) && in_array($row['klan'],$agrr))
			{
				$xxx = 1;
			} else {
				$xxx = 0;
			}

			if ($xxx == 0 && $row['naim']>0) {
				$get_hn_clan=mysql_fetch_array(mysql_query2("SELECT * from oldbk.clans where id='{$row['naim']}' ;"));

				if($get_hn_clan !== false && isset($agrr) && is_array($agrr) && in_array($get_hn_clan['short'],$agrr)) {
					$xxx=1;
				} else {
					$xxx=0;
				}
			}

			// руины
			if ($row['ruines'] > 0 && count($ruines_map) && $user['ruines'] > 0 && $_SESSION['chview'] == 1) {
				$keyowner = ($ruines_map['k'.$row['id_grup'].'owner'] == $row['id'] ? 1 : 0);
				$w .= 'w(\''.$row['login'].'\','.$row['id'].',\''.$row['align'].'\',\''.$row['klan'].'\',\''.$row['level'].'\',\''.$row['slp'].'\',\''.$row['trv'].'\',\''.(int)$row['deal'].'\',\''.(int)$row['battle'].'\',\''.$xxx.'\',\''.$row['id_grup'].'\',\''.$keyowner.'\',0,'.$tlvl.',"'.$row['unikstatus'].'","'.$row['bot'].'");';
			} elseif ($row['id_grup'] > 0 && $row['room'] >= 50000 && $row['room'] <= 53600) {
				$w .= 'w(\''.$row['login'].'\','.$row['id'].',\''.$row['align'].'\',\''.$row['klan'].'\',\''.$row['level'].'\',\''.$row['slp'].'\',\''.$row['trv'].'\',\''.(int)$row['deal'].'\',\''.(int)$row['battle'].'\',\''.$xxx.'\',0,0,\''.$row["podarokAD"].'\','.$tlvl.',"'.$row['unikstatus'].'","'.$row['bot'].'");';
			} else {
				$w .= 'w(\''.$row['login'].'\','.$row['id'].',\''.$row['align'].'\',\''.$row['klan'].'\',\''.$row['level'].'\',\''.$row['slp'].'\',\''.$row['trv'].'\',\''.(int)$row['deal'].'\',\''.(int)$row['battle'].'\',\''.$xxx.'\',0,0,0,'.$tlvl.',"'.$row['unikstatus'].'","'.$row['bot'].'");';
			}
		} elseif (($row['iluz']>0) and (isset($row['hiddenlog']) && $row['hiddenlog'] != '')) {
			//перевоплот
			$fake=explode(",",$row['hiddenlog']);
			$row['id']=$fake[0];
			$row['login']=$fake[1];
			$row['level']=$fake[2];				
			$row['align']=$fake[3];

			$row['deal']=0;
			//sex
			$row['klan']=$fake[5];
			$w .= 'w(\''.$row['login'].'\','.$row['id'].',\''.$row['align'].'\',\''.$row['klan'].'\',\''.$row['level'].'\',\''.$row['slp'].'\',\''.$row['trv'].'\',\''.(int)$row['deal'].'\',\''.(int)$row['battle'].'\',\''.$xxx.'\',0,0,0,0,"",0);';
		}
	}

	if ($_SESSION['chview'] == 5 && $roomok == false) {
		$myroom .= ' ('.$chcount.') ';
	}

	if ($_SESSION['chview'] == 6 && $roomok == false) {
		$myroom .= ' ('.$chcount.') ';
	}

	if ($user['lab']==0) //чар не в лабе
	{
		//bots render
		if ($_SESSION['chview'] == 1) {
			$bots_data = array();
			if (isset($_GET['scan'],$_GET['room'])) {
				$bots_data=mysql_query2("select * from users_clons  where bot_room=".$_GET['room']." and bot_online > 0 ORDER by login;");
			} else {
				$bots_data=mysql_query2("select * from users_clons  where bot_room=".$user['room']." and bot_online > 0 ORDER by login;");
			}
	
			while($row=mysql_fetch_array($bots_data)) {
				$row['deal'] = 0;
				$row['trv'] = 0;
				$row['slp'] = 0;
				$w .= 'w(\''.$row['login'].'\','.$row['id'].',\''.$row['align'].'\',\''.$row['klan'].'\',\''.$row['level'].'\',\''.$row['slp'].'\',\''.$row['trv'].'\',\''.(int)$row['deal'].'\',\''.(int)$row['battle'].'\',\''.$xxx.'\',0,0,0,"","","'.$row['bot'].'");';
			}		
	
		}
	}
	
	
	echo $output;
	echo $myroom;
	echo $output2;
	echo $w;
?>
</script>
</td></tr></table>
</div>
<?php if (!isset($_GET['scan'])) { ?>
<SCRIPT>document.write('<INPUT TYPE=checkbox onclick="if(this.checked == true) { top.OnlineStop = false; } else { top.OnlineStop=true; }" '+(top.OnlineStop?'':'checked')+'> Обновлять автомат.')</SCRIPT>
<?php } ?>
</body></html>

<?php
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' Сompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
	die();
} elseif (isset($_GET['show'])) {
		// показываем чат
		if($_SESSION['sid'] != $user['sid']) {
			echo "<script>top.window.location='index.php?exit=0.560057875997465.000.{$_COOKIE['battle']}'</script>";
			die();
		}

		echo "<script>document.domain = \"oldbk.com\";";

		$ks = 0;

		$ignorelist = array();
		$q = mysql_query_cache("SELECT * FROM oldbk.friends WHERE type = 2 AND owner = ".$user['id'],false,30);
		while(list($k,$f) = each($q)) {
			$ignorelist[$f['friend']] = 1;
		}

		$auto = array();
		$q = mysql_query_cache('SELECT * FROM oldbk.autoanswer WHERE id = '.$user['id'].' AND status = 1',false,30);
		if (count($q) > 0) {
			$auto = $q[0];
		}

		$newmaxid = 0;

		if (isset($_GET['lid']) && intval($_GET['lid']) > 0) {
			$q = mysql_query2('SELECT max(id) as maxid FROM oldbk.chat') or die();
			$q = mysql_fetch_assoc($q) or die();
			$where = "(id > ".intval($_GET['lid'])." AND id <= ".$q['maxid'].')';
			if (isset($_SESSION['chatmsglast']) && $_SESSION['chatmsglast'] > 0) {
				$where .= ' or id = '.$_SESSION['chatmsglast'];
				$_SESSION['chatmsglast'] = 0;
			}
			$newmaxid = $q['maxid'];
		} else {
			$where = "UNIX_TIMESTAMP(`cdate`) > ".(time()-120);
		}

		if ($user['ruines'] > 0) {
			if (!isset($_SESSION['ruinesactivity']['chaton'])) {
				$_SESSION['ruinesactivity']['chaton'] = 1;
				$q = mysql_query2('SELECT * FROM ruines_activity_log WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "chaton"');
				if (mysql_num_rows($q) == 0) {
					mysql_query2('INSERT INTO ruines_activity_log (mapid,owner,var,val) VALUES("'.$user['ruines'].'","'.$user['id'].'","chaton","1")');
				}
			}
		}

		if(($user['align']>1 && $user['align']<2) || $user['deal']==-1) {
			// для палов и помощников - проверка включенного онлайна
			$_SESSION['lastpalupdate'] = time();
		}


		// 1 - общий
		// 2 - приваты личные
		// 3 - клан каналы, межклан каналы и тд
		// 4 - тимприваты и груп-приваты (для загорода, руин, боев)
		// 5 - системки
		// 6 - помошники
		// 7 - общая системка

		$get_chat = mysql_query2("SELECT UNIX_TIMESTAMP(`cdate`) as tt,text,id FROM oldbk.chat where (".$where.") and (city=".($user['id_city']+1)." or city=0) and (room='{$user['room']}' or room='-1' ) order by id ASC");

		$res = array();
		while($chatrow = mysql_fetch_array($get_chat)) 	{
			$res[] = $chatrow;
		}

            
		while(list($k,$chatrow) = each($res)) {
			$v = $chatrow['text'];

			preg_match("/:\[(.*)\]:\[(.*)\]:\[(.*)]:\[(.*)\]/",$v,$math);

			if (isset($math[2])) {
				$all_user_dat = explode(":|:",$math[2]);
			} else {
				$all_user_dat = array();
			}
			if (isset($all_user_dat[1])) {
				$chat_user_id = $all_user_dat[1]; //узер ид
			} else {
				$chat_user_id = 0;
			}

			// а терь возвращаем все как было
			if (isset($all_user_dat[0])) {
				$math[2] = $all_user_dat[0];
			} else {
				$math[2] = "";
			}
			if (isset($math[3])) {
				$math[3] = stripslashes(@$math[3]);
			} else {
				$math[3] = "";
			}

			$orig_math[2]=$math[2];

			if($user['klan'] != 'pal' AND $user['klan'] != 'radminion' AND $user['klan'] != 'Adminion') {
				if(preg_match("/Невидимка\:([0-9]+)/i",$math[2],$neved)) {
					//если невед, то
			     		$chat_user_id = $neved[1]; //в коде на жалобу пишем айди неведа
				}
				$math[2] = @preg_replace("~Невидимка\:([0-9]+)~i",'</a><b><i>Невидимка</i></b>',$math[2]); // и в чат не выводи его айди
			}

			$chatrowrid = $chatrow['id'];
//                      $chatrow[id] = xorit(codein($chatrow[id]));
                        
                        $chatrow['id'] = xorit(codein($chatrow['id']))."::".xorit(codein($_SESSION['uid']));
                        
			$zhaloba = " oncontextmenu=\'return OpenMenu2(event,\"".$chatrow['id']."\")\' ";

			if (!isset($_GET['sys'])) $_GET['sys'] = 0;
			if (!isset($_GET['om'])) $_GET['om'] = 0;

			$user_location = mysql_fetch_array(mysql_query2("SELECT * from oldbk.user_location where user_id='{$user['id']}' ;"));
			if(!$user_location) {
				$user_location = [
				    'user_id'               => 0,
				    'city'                  => 0,
				    'in_clan_tournament'    => 0,
				    'location_special_id'   => 0,
				    'location_special_id2'  => 0,
				    'location_special_id3'  => 0,
                ];
            }

			// фикс на яваскрипт
			$addjs = "";
			$pos = strpos($math[3],'<BR>\';');
			if ($pos !== FALSE) {
				$addjs = substr($math[3],$pos+6)." ';";
				$math[3] = substr($math[3],0,$pos);
			}

			if ((@$math[2] == '{[]}'.$user['login'].'{[]}')) {
				// персональные мессаги юзеру
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',5);".$addjs;
			} elseif(substr($math[2],0,4) == '{[]}') {
				//exit;
			} elseif ((@$math[2] == '!sys!!') && ($user['room']==$math[4]) && $_GET['om'] != 1) {
				if($_GET['sys'] == 1 OR strpos($math[3],"<img src=i/magic/" ) !== FALSE OR strpos($math[3],"<img src=http://i.oldbk.com/i/sh/" ) !== FALSE) 
				{
					echo "top.p('<span class=date ".$zhaloba.">".date("H:i",$math[1])."</span> <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',5);".$addjs;
				}
			} elseif (@$math[2] == '!sysjs!') {
				echo $math[3];
			} elseif (@$math[2] == '!sys2all!!') {
				if (strpos($math[3],'Внимание! С Небес упал подарок') !== FALSE && $user['level'] > 8 && $user['klan'] != "radminion" && $user['klan'] != "Adminion") {
					$chat_id = $chatrowrid;
					continue;
				}
				echo "top.p('<span class=date ".$zhaloba.">".date("H:i",$math[1])."</span> <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',7);".$addjs;
			} elseif ((@$math[2] == '!group!') AND (in_array($user['id'],$all_user_dat))) {
				echo "top.p('<span class=date ".$zhaloba.">".date("H:i",$math[1])."</span> <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',5);".$addjs;
			} elseif ((strpos($math[2],"!levels-" ) !== FALSE)) {
				//"!levels-7-21-!"
				$getlvls=explode("-",$math[2]);
						
				$minlvl=$getlvls[1];
				$maxlvl=$getlvls[2];		
										
				if (($user['level']>=$minlvl) and ($user['level']<=$maxlvl)) {
					//mysql_query2("UPDATE `oldbk`.`variables` SET `value`='".$minlvl." - ".$maxlvl." - ".$user['level']."' WHERE `var`='debug';");							
					echo "top.p('<span class=date ".$zhaloba.">".date("H:i",$math[1])."</span> <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',7);".$addjs;
				}
			} elseif ((strpos($math[3],"private [pal-" ) !== FALSE) and (($user['klan']=='pal' && $user['align']!=1.2) || $user['id']==326 || $user['id']==28453)) {
				$chans = mysql_fetch_array(mysql_query2("SELECT `name` FROM `oldbk`.`chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
				$chans = explode(",",$chans['name']) ;
				$pos = strpos($math[3],"[pal-" )+5;
				if(in_array(substr($math[3],$pos,1),$chans)) {
					$math[3] = preg_replace_callback("/private \[pal-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal-'.$m[1].'\",false)'.chr(92).'\' class=private>private [ pal-'.$m[1].' ]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
				}
			} elseif($user['room'] == 402 && (strpos($math[3],"private [kt-team-{$user_location['location_special_id']}-{$user_location['location_special_id2']}-{$user_location['location_special_id3']}]" ) !== false)) {
				//KT чат команды
				$_message = trim(str_replace('private [kt-team-'.$user_location['location_special_id'].'-'.$user_location['location_special_id2'].'-'.$user_location['location_special_id3'].']', '', $math[3]));
				$math[3] = '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"kt-team\",false)'.chr(92).'\' class=private3>private [kt-team]</a> '.$_message;
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
			} elseif ($user['ruines'] > 0 && (((strpos($math[3],"private [team-blue-{$user['ruines']}-1]" ) !== FALSE) AND $user['id_grup']==1) OR ((strpos($math[3],"private [team-red-{$user['ruines']}-2]" ) !== FALSE)  AND  $user['id_grup']==2))) {
				// вывод чата для руин
				// я пишу своей команде и все
				$math[3] = preg_replace_callback("/private \[team-blue-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-blue\",false)'.chr(92).'\' class=private3>private [team-blue]</a>'; }, $math[3]);
				$math[3] = preg_replace_callback("/private \[team-red-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-red\",false)'.chr(92).'\' class=private4>private [team-red]</a>'; }, $math[3]);
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
			} elseif ($user['ruines'] > 0 && (((strpos($math[3],"private [team-blue-{$user['ruines']}-2]" ) !== FALSE) AND $user['id_grup']==1) OR ((strpos($math[3],"private [team-red-{$user['ruines']}-1]" ) !== FALSE)  AND  $user['id_grup']==2))) {
				// я пишу вражеской команде - делаем подмену в обратном клике
				$math[3] = preg_replace_callback("/private \[team-blue-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-red\",false)'.chr(92).'\' class=private3>private [team-blue]</a>'; }, $math[3]);
				$math[3] = preg_replace_callback("/private \[team-red-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-blue\",false)'.chr(92).'\' class=private4>private [team-red]</a>'; }, $math[3]);
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
			} elseif ($user['ruines'] > 0 && (((strpos($math[3],"private [team-blue-{$user['ruines']}-" ) !== FALSE) AND  $math[2]==$user['login']) OR ((strpos($math[3],"private [team-red-{$user['ruines']}-" ) !== FALSE)  AND  $math[2]==$user['login']))) {
				// чтобы отправляющий видел если адресованно другой команде
				$math[3] = preg_replace_callback("/private \[team-blue-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-blue\",false)'.chr(92).'\' class=private3>private [team-blue]</a>'; }, $math[3]);
				$math[3] = preg_replace_callback("/private \[team-red-".$user['ruines']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-red\",false)'.chr(92).'\' class=private4>private [team-red]</a>'; }, $math[3]);
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
			} elseif (strpos($math[3],"private [zgroup-{$user['id_grup']}]") !== FALSE)  {
					// прием чата в загороде
					$math[3] = preg_replace_callback("/private \[zgroup-[\d]*\]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"zgroup\",false)'.chr(92).'\' class=private3>private [zgroup]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
			} elseif ((
					((strpos($math[3],"private [team-1-{$user['battle']}-1]" ) !== FALSE) AND  $user['battle_t']==1) OR 
					((strpos($math[3],"private [team-2-{$user['battle']}-2]" ) !== FALSE) AND  $user['battle_t']==2) OR 
					((strpos($math[3],"private [team-3-{$user['battle']}-3]" ) !== FALSE) AND  $user['battle_t']==3)
					) and (!isset($_SESSION['tfon']) || (isset($_SESSION['tfon']) && $_SESSION['tfon']==0))) {
				// я пишу своей команде и все
				if($user['battle'] > 0) {
					$math[3] = preg_replace_callback("/private \[team-1-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-1\",false)'.chr(92).'\' class=private3>private [team-1]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-2-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-2\",false)'.chr(92).'\' class=private3>private [team-2]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-3-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-3\",false)'.chr(92).'\' class=private3>private [team-3]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
				}
			} elseif ((
					((strpos($math[3],"private [team-1-{$user['battle']}-2]") !== FALSE) AND $user['battle_t']==1) OR 
					((strpos($math[3],"private [team-1-{$user['battle']}-3]") !== FALSE) AND $user['battle_t']==1) OR 

					((strpos($math[3],"private [team-2-{$user['battle']}-1]") !== FALSE) AND $user['battle_t']==2) OR 
					((strpos($math[3],"private [team-2-{$user['battle']}-3]") !== FALSE) AND $user['battle_t']==2) OR 

					((strpos($math[3],"private [team-3-{$user['battle']}-1]") !== FALSE) AND $user['battle_t']==3) OR 
					((strpos($math[3],"private [team-3-{$user['battle']}-2]") !== FALSE) AND $user['battle_t']==3)

					) and (!isset($_SESSION['tfon']) || (isset($_SESSION['tfon']) && $_SESSION['tfon']==0))) {
				// я пишу вражеской команде - делаем подмену в обратном клике
				if($user['battle'] > 0) {
					$math[3] = preg_replace_callback("/private \[team-1-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-2\",false)'.chr(92).'\' class=private3>private [team-1]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-2-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-1\",false)'.chr(92).'\' class=private3>private [team-2]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-3-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-1\",false)'.chr(92).'\' class=private3>private [team-3]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
				}
			} elseif ( 
					((strpos($math[3],"private [team-1-{$user['battle']}-" ) !== FALSE) AND (($math[2]==$user['login']) OR ($orig_math[2]=='Невидимка:'.$hidden_my['idiluz']))) OR
					((strpos($math[3],"private [team-2-{$user['battle']}-" ) !== FALSE) AND $math[2]==$user['login']) OR
					((strpos($math[3],"private [team-3-{$user['battle']}-" ) !== FALSE) AND $math[2]==$user['login'])
				) {
				// чтобы отправляющий (даже если он невидимка) видел если адресованно другой команде
				if($user['battle'] > 0) {
					$math[3] = preg_replace_callback("/private \[team-1-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-1\",false)'.chr(92).'\' class=private3>private [team-1]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-2-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-2\",false)'.chr(92).'\' class=private3>private [team-2]</a>'; }, $math[3]);
					$math[3] = preg_replace_callback("/private \[team-3-".$user['battle']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"team-2\",false)'.chr(92).'\' class=private3>private [team-3]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',4);".$addjs;
				}
			} elseif (strpos($math[3],"private [klan-pal-" ) !== FALSE && ($user['id']==28453 || $user['id']==326)) {
				// отражение паловских клановых каналов для админов
				$chans = mysql_query_cache("SELECT `name` , `filt_name` FROM `oldbk`.`chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';",false,5*60);
				if (count($chans)) {
					$chans = $chans[0];

					$filt_name = array();
					$filt_name = unserialize($chans['filt_name']);
	
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($math[3],"[klan-pal-" )+strlen('pal')+7;
					$out_ch=substr($math[3],$pos,1);
	
				   	//клан чат по каналам - идет проверка на фильтр по каналам - кланового чата
				    	if ((in_array($out_ch,$chans)) and (!isset($filt_name[$out_ch]) || (isset($filt_name[$out_ch]) && $filt_name[$out_ch] == 0))) {
						$math[3] = preg_replace_callback("/private \[klan-pal-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan-pal-'.$m[1].'\",false)'.chr(92).'\' class=private>private [ klan-pal-'.$m[1].' ]</a>'; }, $math[3]);
						echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
					}
				}
			} elseif (strpos($math[3],"private [klan-{$user['klan']}-" ) !== FALSE ) {
				// отражение клановых каналов для всех

				$chans = mysql_query_cache("SELECT `name` , `filt_name` FROM `oldbk`.`chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';",false,60);
				if (count($chans)) {
					$chans = $chans[0];

					$filt_name = array();
					$filt_name = unserialize($chans['filt_name']);
	
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($math[3],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
					$out_ch=substr($math[3],$pos,1);
	
				   	//клан чат по каналам - идет проверка на фильтр по каналам - кланового чата
				    	if ((in_array($out_ch,$chans)) and (!isset($filt_name[$out_ch]) || (isset($filt_name[$out_ch]) && $filt_name[$out_ch] == 0))) {
					    	$math[3] = preg_replace_callback("/private \[klan-".$user['klan']."-([1-9])]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan-'.$m[1].'\",false)'.chr(92).'\' class=private>private [ klan-'.$m[1].' ]</a>'; }, $math[3]);
					    	echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
					}
				}
			} elseif  (strpos($math[3],"private [mklan-" ) !== FALSE) {
				$mpos = strpos($math[3],"[mklan-")+6;
				$mwho = explode("-",substr($math[3],$mpos));

				if ($mwho[1]==$user['klan']) {
					$sqlchek = mysql_query_cache("select chc.* , ch.mname , ch.filt_mname from oldbk.chat_chanels as chc LEFT JOIN oldbk.chanels as ch ON ch.klan=chc.clan1 and ch.user='{$user['id']}' where chc.clan1='{$user['klan']}' and chc.clan2='".mysql_real_escape_string($mwho[2])."' and chc.chanel='".(int)($mwho[3])."' and chc.chanel2='".(int)($mwho[4])."' and chc.active =1 LIMIT 1;",false,60);
					if (count($sqlchek)) {
						$sqlchek = $sqlchek[0];
	
						$filt_mname = array();
						$filt_mname = unserialize($sqlchek['filt_mname']);
	
						if ($sqlchek['mname']!='') {
							$kanals = explode(",",$sqlchek['mname']);
							$out_ch=$mwho[3];
							if ((in_array($mwho[3],$kanals)) and (!isset($filt_mname[$out_ch]) || (isset($filt_mname[$out_ch]) && $filt_mname[$out_ch] == 0))) {
								if ($mwho[3]==0) {
									$math[3]=preg_replace_callback("/private \[mklan-".$user['klan']."-".mysql_real_escape_string($mwho[2])."-".(int)($mwho[3])."-".(int)($mwho[4])."-]/U", function ($m) { global $mwho; return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"mklan\",false)'.chr(92).'\' class=private2>private [ mklan ]</a><font color=black>('.mysql_real_escape_string($mwho[2]).')</font>'; },$math[3]); 
								} else { 
									$math[3]=preg_replace_callback("/private \[mklan-".$user['klan']."-".mysql_real_escape_string($mwho[2])."-".(int)($mwho[3])."-".(int)($mwho[4])."-]/U", function ($m) { global $mwho; return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"mklan-'.$mwho[3].'\",false)'.chr(92).'\' class=private2>private [ mklan-'.$mwho[3].' ]</a><font color=black>('.mysql_real_escape_string($mwho[2]).')</font>'; },$math[3]);
								}
								$math[3]=preg_replace("/private \[mklan-(.*)-]/U","",$math[3]);
								echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
							}
						}
					}
				} else	if (isset($mwho[2]) && $mwho[2]==$user['klan']) {
					$sqlchek = mysql_query_cache("select chc.* , ch.mname , ch.filt_mname from oldbk.chat_chanels as chc LEFT JOIN oldbk.chanels as ch ON ch.klan=chc.clan2 and ch.user='{$user['id']}' where chc.clan1='".mysql_real_escape_string($mwho[1])."' and chc.clan2='{$user['klan']}' and chc.chanel='".(int)($mwho[3])."' and chc.chanel2='".(int)($mwho[4])."' and chc.active =1 LIMIT 1;",false,60);
					if (count($sqlchek)) {
						$sqlchek = $sqlchek[0];	
	
						$filt_mname = array();
						$filt_mname = unserialize($sqlchek['filt_mname']);
		
						if ($sqlchek['mname']!='') {
							$kanals = explode(",",$sqlchek['mname']) ;
							$out_ch=$mwho[4];
							if((in_array($mwho[4],$kanals)) and (!isset($filt_mname[$out_ch]) || (isset($filt_mname[$out_ch]) && $filt_mname[$out_ch] == 0))) {
								if ($mwho[4]==0) {
									$math[3]=preg_replace_callback("/private \[mklan-".mysql_real_escape_string($mwho[1])."-".$user['klan']."-".(int)($mwho[3])."-".(int)($mwho[4])."-]/U", function ($m) { global $mwho; return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"mklan\",false)'.chr(92).'\' class=private2>private [ mklan ]</a><font color=black>('.mysql_real_escape_string($mwho[1]).')</font>'; },$math[3]);
								} else { 
									$math[3]=preg_replace_callback("/private \[mklan-".mysql_real_escape_string($mwho[1])."-".$user['klan']."-".(int)($mwho[3])."-".(int)($mwho[4])."-]/U", function ($m) { global $mwho; return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"mklan-'.$mwho[4].'\",false)'.chr(92).'\' class=private2>private [ mklan-'.$mwho[4].' ]</a><font color=black>('.mysql_real_escape_string($mwho[1]).')</font>'; },$math[3]);
								}
	
							 	$math[3]=preg_replace("/private \[mklan-(.*)-]/U","",$math[3]);
								echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
							}
						}
					}
				}
			} elseif (strpos($math[3],"private [pal]" ) !== FALSE) {
				// пал каналы
				if(($user['klan']=='pal' && $user['align'] != 1.2) OR $user['id'] == 326 OR $user['id'] == 14896 OR $user['klan'] == 'radminion' OR $user['klan'] == 'Adminion') {
					$math[3] = preg_replace_callback("/private \[pal]/U", function ($m) { return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal\",false)'.chr(92).'\' class=private>private [ pal ]</a>'; }, $math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
				}
			} elseif (strpos($math[3],"private [klan-{$user['klan']}]" ) !== FALSE)  {
				// клан приват
				if($user['klan']!='') {
					$math[3] = preg_replace_callback("/private \[klan\-{$user['klan']}\]/U", function ($m) { return '<a onclick='.chr(92).'\'top.AddToPrivate(\"klan\",false,event)'.chr(92).'\' class=private>private [ klan ]</a>'; }, $math[3]);

					if (!isset($_SESSION['offclanchat']) || $_SESSION['offclanchat'] == 0) {
						echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',3);".$addjs;
					}
				}
			} elseif (strpos($math[3],"private [helpers]" ) !== FALSE && ($user['deal'] == -1)) {
				// приват канал хелперов
				$math[3] = preg_replace_callback("/private \[(.*)\]/U", function ($m) { global $user; return '<a href='.chr(92).'\'javascript:top.AddToPrivate(\"'.(($m[1] != 'helpers')?$m[1]:'helpers').'\",false)'.chr(92).'\' class=private>private [ <span oncontextmenu=\"return OpenMenu(event,'.$user['level'].');\">'.$m[1].'</span> ]</a>'; }, $math[3]);
				echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',6);".$addjs;
			} elseif (((strpos($math[3],"private [{$user['login']}]" ) !== FALSE) OR ($math[2] == $user['login']) OR ($orig_math[2]=='Невидимка:'.$hidden_my['idiluz']) )) {
				// приват для юзеров
				if(( strpos($math[3]," privatehelpers ") !== FALSE )) {
					// помошники
					$math[3] = str_replace(" privatehelpers ","",$math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',6);".$addjs;
				} elseif (( strpos($math[3]," privatetorg ") !== FALSE )) {
					// торговый
					$math[3] = str_replace(" privatetorg ","",$math[3]);
					echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',8);".$addjs;
				} else {
					if (!isset($ignorelist[$chat_user_id])) {
						if (strpos($math[3],'private ['.$user['login'].']') !== FALSE) {
							echo "top.soundD();";
						}
						$math[3] = preg_replace_callback("/private \[(.*)\]/U", function ($m) { global $user,$math; return '<a onclick='.chr(92).'\'top.AddToPrivate(\"'.(($m[1] != $user['login']) ? $m[1] : $math[2]).'\",false,event)'.chr(92).'\' class=private>private [ <span oncontextmenu=\"return OpenMenu(event,'.$user['level'].');\">'.$m[1].'</span> ]</a>'; }, $math[3]);
						echo "top.p('<span class=date2 ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',2);".$addjs;

						if (count($auto) && $user['slp'] == 0) {
							if ($math[2]!=$user['login']) {
							
								if (strpos($math[3],'<b>Автоответчик:</b>') !== FALSE) {
								
								} else {
									addchp ('private ['.$math[2].'] <b>Автоответчик:</b> '.$auto['answer'],$user['login'].":|:".$user['id'],-1,$user['id_city']);
								}
							}
						}
					} else {
						addchp ('<font color=red>Внимание!</font> Персонаж <b>'.$user['login'].'</b> занес вас в свой игнор лист и не получит ваше сообщение!','{[]}'.$math[2].'{[]}','-1',0);
					}
				}
			} elseif(( strpos($math[3]," privatetorg ") !== FALSE )) {
				// помошники
				$math[3] = str_replace(" privatetorg ","",$math[3]);
				$times = ''; $soundON='';

				if ((strpos($math[3],"[".$user['login']."]") > 0) OR ($math[2] == $user['login']) OR ($orig_math[2]=='Невидимка:'.$hidden_my['idiluz']) ) {
					$times = 'date2';
					$math[3] = str_replace("to [".$user['login']."]","<B>to [".$user['login']."]</B>",$math[3] );
					$soundON='top.soundD();';
				} elseif($_GET['om'] != 1) {
					$times = 'date';
				}

				if($_GET['om'] != 1 OR $times == 'date2') {
					echo $soundON."top.p('<span class={$times} ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',8);".$addjs;
				}
			} elseif(( strpos($math[3]," privatehelpers ") !== FALSE )) {
				// помошники
				$math[3] = str_replace(" privatehelpers ","",$math[3]);
				$times = ''; $soundON='';
				if ((strpos($math[3],"[".$user['login']."]") > 0) OR ($math[2] == $user['login']) OR ($orig_math[2]=='Невидимка:'.$hidden_my['idiluz']) ) {
					$times = 'date2';
					$math[3] = str_replace("to [".$user['login']."]","<B>to [".$user['login']."]</B>",$math[3] );
					$soundON='top.soundD();';
				} elseif($_GET['om'] != 1) {
					$times = 'date';
				}

				if($_GET['om'] != 1 OR $times == 'date2') {
					echo $soundON."top.p('<span class={$times} ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',6);".$addjs;
				}
			} elseif(( strpos($math[3],"private" ) === FALSE ) && (isset($math[4]) && $user['room']==$math[4])) {
				// остальные мессаги в этом руме
				$times = ''; $soundON='';
				if ((strpos($math[3],"[".$user['login']."]") > 0) OR ($math[2] == $user['login']) OR ($orig_math[2]=='Невидимка:'.$hidden_my['idiluz']) ) {
					$times = 'date2';
					$math[3] = str_replace("to [".$user['login']."]","<B>to [".$user['login']."]</B>",$math[3] );
					$soundON='top.soundD();';
				} elseif($_GET['om'] != 1) {
					$times = 'date';
				}

				if($_GET['om'] != 1 OR $times == 'date2') {
					echo $soundON."top.p('<span class={$times} ".$zhaloba.">".date("H:i",$math[1])."</span> [<a onclick=\"top.AddTo(\'{$math[2]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] <span class=stext id=".$chatrow['id'].">".$math[3]."</span>',1);".$addjs;
				}
			}

			$chat_id = $chatrowrid;
	}

	if (!isset($_SESSION['newsup_id'])) $_SESSION['newsup_id'] = 0;

	//обработка new_updates
	if ((int)$_SESSION['newsup_id']>0) {
		$newsfilt=(int)$_SESSION['newsup_id'];
		$newsfilt=" id > {$newsfilt} and ";
	} else {
		$newsfilt='';
	}
	
	/*online
	$getdata=mysql_query2("select * from oldbk.new_updates where ".$newsfilt." hide=0 order by top desc , cdate desc limit 50; ");
	if (mysql_num_rows($getdata)>0) 
	{
		while($row=mysql_fetch_array($getdata)) 
		{
			$phpdate = strtotime($row['cdate']);
			echo "top.p('<span class=date >".date( 'd-m-Y H:i:s', $phpdate )."</span> <span class=stext id=news".$row['id'].">".$row['message']."</span>',9);";
			$nlast_id=$row['id'];
		}	
	$_SESSION['newsup_id']=$nlast_id;
	}
	*/
	
//	$getdata=mysql_query_cache("select * from oldbk.new_updates where ".$newsfilt." hide=0 order by top desc , cdate limit 100; ",false,120);
	$getdata=mysql_query_cache("select * from oldbk.new_updates where ".$newsfilt." hide=0 order by top asc , cdate desc limit 10; ",false,120);
	$first_run = 0;
	$nlast_id = 0;
	if (count($getdata) > 0) {
		sort($getdata);
		reset($getdata);
		while(list($k,$row) = each($getdata)) {
			if (isset($_SESSION['newsup_id'])) {
				$phpdate = strtotime($row['cdate']);
				echo "top.p('<span class=date >".date( 'd-m-Y H:i:s', $phpdate )."</span> <span class=stext id=news".$row['id'].">".$row['message']."</span>',9);";
			} else {
				$first_run=true;
			}
			$nlast_id=$row['id'];
		}		
		$_SESSION['newsup_id']=$nlast_id;	

	}
	if ($first_run) {
		echo "top.p(' ',9);";
	}

	$_SESSION['lastlook'] = time();

	if ($newmaxid > 0) $chat_id = $newmaxid;
	echo "</script><script>top.slid(".$chat_id."); top.srld();</script>";
/*
	if (isset($_GET['an']) && $_GET['an'] == 0) {
		include "genactions.php";
		$t = ReturnActions();
		$ids = array_keys($t);
		$anim = 0;

		if (!isset($_COOKIE['acc'])) $_COOKIE['acc'] = "";
		if (!isset($acc)) $acc = "";

		if ($_COOKIE['acc'] != $acc) {
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

			if ($anim) {
				// появилась акция новая - обновляем верхний фрейм
				echo '<script>top.frames["newplr"].location.reload(true);</script>';
			}
		}
	}
*/

	if ((isset($_SESSION['adm_view']) && $_SESSION['adm_view']==1) OR ($user['hidden']>0)) {
		// фикс телеграфа для админов и неведов/перевоплов, телеграфы получаем сразу если онлайн
		$rs = mysql_query2("SELECT * FROM oldbk.`telegraph` WHERE `owner` = '".$user['id']."';");
		if (mysql_num_rows($rs) > 0) {
			mysql_query2("DELETE FROM oldbk.`telegraph` WHERE `owner` = '".$user['id']."';");
		    	while($r = mysql_fetch_assoc($rs)) {
				addchp ($r['text'],'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
	   		}
	   	}
	} else {
		if ($user['hidden']==0) {
			if (!isset($_SESSION['chat_refr_time'])) $_SESSION['chat_refr_time'] = 0;
		
			if ($_SESSION['chat_refr_time']<time()-25) {
			 	if ($user['odate']<time()) {
					//если время меньше чем текущее то обновляем если больше , то не трогаем
			 		$_SESSION['chat_refr_time']=time();
					mysql_query2("UPDATE `users` SET `odate` = ".time()." WHERE `id` = {$user['id']};");
//2					save_otime_to_file($user['id']);
				}
			} else {
				//save_otime_to_file_s($user['id']);
			}
		}
	}

	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' Сompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
    	}
	die();
} elseif (isset($_GET['text'])) {                             
	$add_room = " , `room`='{$user['room']}' "; // рум для инсерта если просто чат - поумолчанию так
	if(isset($_GET['browser']) && ($_GET['browser'] == "gecko" || $_GET['browser'] == "presto")) $_GET['text'] = iconv('utf8', 'cp1251', $_GET['text']);


	// если 0вой уровень, то пишем только админам, палам и дилерам
	/*
	if (strpos($_GET['text'],"private" ) !== FALSE && $user['level'] == 0) {
		preg_match_all("/\[(.*)\]/U", $_GET['text'], $matches);

		for ($ii=0;$ii<count($matches[1]);$ii++){
			$dde = mysql_fetch_array(mysql_query2("SELECT `id` FROM `users` WHERE (`klan` = 'radminion' OR `klan` = 'Adminion' OR `deal` = 1 OR (`align`>1 AND `align`<2)) AND `login` = '".trim($matches[1][$ii])."' LIMIT 1 ;"));
			if (!$dde['id']) {
				exit;
			}
		}
	}*/

	$_GET['text'] = str_ireplace('dawin.info','',$_GET['text']);
	$_GET['text'] = str_ireplace('dawin','',$_GET['text']);

	if ((isset($_SESSION['offclanchat']) && $_SESSION['offclanchat'] == 1) and (strpos($_GET['text'],"private [klan]" ) !== FALSE)) {
		addchp ('<font color=red>Внимание!</font> У Вас отключен клановый чат!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
	}
	if (@trim($_GET['text']) != null) {

			if ($user['level'] == 0) 
			{
				/*
				if (!isset($_SESSION['chat0wait'])) {
					$_SESSION['chat0wait'] = time();
				} else {
					if ($_SESSION['chat0wait'] + 60 >= time()) 
					{
					*/
						$_GET['text']='private ['.$user['login'].'] Вы сможете писать сообщения в чат по достижение 1-го уровня.';
					
					/*} else {
						$_SESSION['chat0wait'] = time();
					}
				
				}
					*/
			}
	
		if ($user['slp'] == 0 || (($user['deal'] == -1 ) && isset($_GET['chtype']) && $_GET['chtype'] == 6 && strpos($_GET['text'],'private') === false)) {
			$_GET['text'] = substr($_GET['text'],0,400);
			$_GET['text'] = str_replace('<','&lt;',$_GET['text']);
			$_GET['text'] = str_replace(']:[','] : [',$_GET['text']);
			$_GET['text'] = str_replace('>','&gt;',$_GET['text']);

			$_GET['text'] = preg_replace('~private[\s]*\[klan-[a-z]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[team-red-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[team-blue-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[kt-team-[0-9-]*\]~iU','',$_GET['text']); //KT
			$_GET['text'] = preg_replace('~private[\s]*\[zgroup-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[team-1-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[team-2-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~private[\s]*\[team-3-[a-z0-9-]*\]~iU','',$_GET['text']);
			$_GET['text'] = preg_replace('~&#[\d]{1,};~iU','',$_GET['text']);


			$dooblechat = 0;
			$chans = array();
			$pos = false;

			// чат для помощи
			if (isset($_GET['chtype']) && $_GET['chtype'] == 6 && strpos($_GET['text'],'private') === FALSE) {
				$_GET['text'] .= ' privatehelpers ';
				$dooblechat = 1;
			}

			// торговый чат
			if (isset($_GET['chtype']) && $_GET['chtype'] == 8 && strpos($_GET['text'],'private') === FALSE) {
				$_GET['text'] .= ' privatetorg ';
				$dooblechat = 1;
			}

			// чат для хелперов
			if (strpos($_GET['text'],'private [helpers]') !== FALSE) {
				if (($user['deal'] != -1)) {
					$_GET['text'] = str_replace('private [helpers]','',$_GET['text']);
				} else {
					$dooblechat = 1;
				}
			}
			                                                                    
			//тим чат для руин
			if ((strpos($_GET['text'],"private [team-red" ) !== FALSE) OR (strpos($_GET['text'],"private [team-blue" ) !== FALSE)) {
				if ($user['ruines'] > 0) {
					$_GET['text'] = str_replace('team-red','team-red-'.$user['ruines'].'-'.$user['id_grup'],$_GET['text']);
					$_GET['text'] = str_replace('team-blue','team-blue-'.$user['ruines'].'-'.$user['id_grup'],$_GET['text']);
				} else {
   					$_GET['text'] = str_replace('private [team-red]','',$_GET['text']);
					$_GET['text'] = str_replace('private [team-blue]','',$_GET['text']);
				}
			}

			//тим чат для КТ
			if (strpos($_GET['text'],"private [kt-team]" ) !== false) {
				$user_location = mysql_fetch_array(mysql_query2("SELECT * from oldbk.user_location where user_id='{$user['id']}' ;"));
                $inTournament = ($user_location['in_clan_tournament'] == 1) ? true : false;
                $tournamentId = $user_location['location_special_id'];
                $tournamentGroupId = $user_location['location_special_id2'];
                $tournamentGroupTeamId = $user_location['location_special_id3'];

				if ($inTournament) {
					$_GET['text'] = str_replace('kt-team','kt-team-'.$tournamentId.'-'.$tournamentGroupId.'-'.$tournamentGroupTeamId, $_GET['text']);
				} else {
					$_GET['text'] = str_replace('private [kt-team]','', $_GET['text']);
				}
			}

			//тим чат загород - при отправке
			if ((strpos($_GET['text'],"private [zgroup" ) !== FALSE)) {
				if (($user['room']>=50000) and ($user['room']<=60000) and ($user['id_grup']>0)) {
					$_GET['text'] = str_replace('private [zgroup','private [zgroup-'.$user['id_grup'],$_GET['text']);
				} else {
					$_GET['text'] = str_replace('private [zgroup]','',$_GET['text']);
				}
			}
			
			//тим чат для боев
			if ((strpos($_GET['text'],"private [team-1" ) !== FALSE) OR (strpos($_GET['text'],"private [team-2" ) !== FALSE) OR (strpos($_GET['text'],"private [team-3" ) !== FALSE)) {
				if ($user['battle'] > 0) {
					$_GET['text'] = str_replace('team-1','team-1-'.$user['battle'].'-'.$user['battle_t'],$_GET['text']);
					$_GET['text'] = str_replace('team-2','team-2-'.$user['battle'].'-'.$user['battle_t'],$_GET['text']);
					$_GET['text'] = str_replace('team-3','team-3-'.$user['battle'].'-'.$user['battle_t'],$_GET['text']);
				} else {
					$_GET['text'] = str_replace('private [team-1]','',$_GET['text']);
					$_GET['text'] = str_replace('private [team-2]','',$_GET['text']);
					$_GET['text'] = str_replace('private [team-3]','',$_GET['text']);
				}
			}

			if ($user['klan'] == '') {
				$_GET['text'] = str_replace('private [klan]','',$_GET['text']);
				$_GET['text'] = str_replace('private [klan','private ['.$user['login'],$_GET['text']);

				// не вклане не могут писать в межклан - затираем
				$_GET['text'] = str_replace('private [mklan]','',$_GET['text']);
				$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','',$_GET['text']);
			} else {
				$_GET['text'] = str_replace('private [klan','private [klan-'.$user['klan'],$_GET['text']);

				$qchans = mysql_query_cache("SELECT `name`, `mname` FROM `oldbk`.`chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';",false,60);
				if (count($qchans) > 0) {
	                                $qchans = $qchans[0];

					$chans = explode(",",$qchans['name']) ;
					$mchans = explode(",",$qchans['mname']) ;
				} else {
					$chans = array();
					$mchans = array();
				}

				$pos = strpos($_GET['text'],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
				$mpos = strpos($_GET['text'],"private [mklan-" )+15;


				if (strpos($_GET['text'],"private [klan" ) !== FALSE) {
					$dooblechat=1;
				}
				if (strpos($_GET['text'],"private [pal" ) !== FALSE) {
					$dooblechat=1;
				}

				// mclans
				// надо добавить к исходящему ID канала в базе

				if (strpos($_GET['text'],"private [mklan" ) !== FALSE) {
					$outchanel=(int)substr($_GET['text'],$mpos,1);
					if(!in_array($outchanel,$mchans)) {
						$_GET['text'] = str_replace('private [mklan]','',$_GET['text']);
						$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','',$_GET['text']);
					} else {
						$idmchat = mysql_query_cache("SELECT *  FROM `oldbk`.`chat_chanels` WHERE ((`clan1`='".$user['klan']."' and  `chanel`='".$outchanel."') or (`clan2`='".$user['klan']."' and  `chanel2`='".$outchanel."') ) and active=1",false,60);
						if (count($idmchat) > 0) {
							$idmchat = $idmchat[0];
							if ($idmchat['id'] > 0) {
								if ($idmchat['clan1']==$user['klan']) {
									$_GET['text']   = str_replace('private [mklan]','private [mklan-'.$user['klan'].'-'.$idmchat['clan2'].'-'.'0'.'-'.$idmchat['chanel2'].'-]',$_GET['text']);
									$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','private [mklan-'.$user['klan'].'-'.$idmchat['clan2'].'-\\1-'.$idmchat['chanel2'].'-]',$_GET['text']);
									$dooblechat=1;
								} else if ($idmchat['clan2']==$user['klan']) {
									$_GET['text']   = str_replace('private [mklan]','private [mklan-'.$idmchat['clan1'].'-'.$user['klan'].'-'.$idmchat['chanel'].'-0-]',$_GET['text']);
									$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','private [mklan-'.$idmchat['clan1'].'-'.$user['klan'].'-'.$idmchat['chanel'].'-\\1-]',$_GET['text']);
									$dooblechat=1;
								} else {
									$_GET['text'] = str_replace('private [mklan]','',$_GET['text']);
									$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','',$_GET['text']);
									$dooblechat=1;
								}
							} else {
								$_GET['text'] = str_replace('private [mklan]','',$_GET['text']);
								$_GET['text'] = preg_replace('~private \[mklan-([0-9])\]~iU','',$_GET['text']);
								$dooblechat=1;					
							}
						}
					}
				}
			}


			$_GET['text'] = str_replace('&#8238','',$_GET['text']);

                	if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
				$_GET['text'] = preg_replace("~private \[klan-{$user['klan']}-[1-9]\]~iU",'',$_GET['text']);
			}


			if(($user['klan'] != 'pal' or ($user['klan'] == 'pal' AND $user['align']==1.2)) AND $user['id'] != 326 AND $user['id'] != 14896 AND $user['klan'] != 'radminion' AND $user['klan'] != 'Adminion') {
				$_GET['text'] = str_replace('private [pal]','',$_GET['text']);
				$_GET['text'] = preg_replace("~private \[pal-[1-9]\]~iU",'',$_GET['text']);
				// шоб палы неписали невидимкам с ид
				$_GET['text'] = preg_replace("~Невидимка\:([0-9]+)~i",'</a><b><i>Невидимка</i></b>',$_GET['text']);
			} else {
				$chans = mysql_query_cache("SELECT `name` FROM `oldbk`.`chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';",false,5*60);
				if (count($chans)) {
					$chans = $chans[0];
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($_GET['text'],"[pal-" );
					if ($pos !== false) {
						$pos += 5;
						if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
							$_GET['text'] = preg_replace("~private \[pal-[1-9]\]~iU",'',$_GET['text']);
						}
					}
				}
			}
	
	
			$_GET['text'] = str_replace('%27','',$_GET['text']);
			$_GET['text'] = str_replace('\"','%22',$_GET['text']);
			$_GET['text'] = str_replace('\`','',$_GET['text']);

			// загружаем все эффекты
			$eff = mysql_query_cache("SELECT * FROM `effects` WHERE `owner` = ".$user['id'],false,15);

			$alleff = array();

			while(list($k,$ea) = each($eff)) {
				$alleff[$ea['type']][] = $ea;
			}



			if (isset($alleff[22225]) && $_GET['chtype'] != 6) {
				$_GET['text'] = ChRandomColor($_GET['text']);
			}

			if (isset($alleff[22226]) && $_GET['chtype'] != 6) {
				$_GET['text'] = ChRandomCaps($_GET['text']);
			}

	
			// тут смайлы
			$lsml = array();
			$lsml2 = array();

			$klansm = "";
			if (strlen($user['klan'])) $klansm = ' or (owner = 0 and klan = "'.$user['klan'].'")';
			$q = mysql_query_cache('SELECT * FROM oldbk.smiles WHERE (klan = "" and (owner = 0 OR owner = '.$user['id'].')) '.$klansm.' ORDER BY id ASC',false,5*60);


			$sscount = 0;
			while(list($k,$ss) = each($q)) {
				$lsml = "/:".$ss['name'].":/i";
				if ($ss['owner'] > 0 || $ss['klan'] != "") {
					$lsml2 = "<img width=".$ss['w']." height=".$ss['h']." src=\"http://i.oldbk.com/i/smiles/".$ss['name'].".gif\">";
				} else {
					$lsml2 = "<img style=\"cursor:pointer;\" width=".$ss['w']." height=".$ss['h']." onclick=S(\"".$ss['name']."\") src=\"http://i.oldbk.com/i/smiles/".$ss['name'].".gif\">";
				}
				$tmpcount = 0;
				$_GET['text'] = preg_replace($lsml, $lsml2, $_GET['text'], 3,$tmpcount);
				$sscount += $tmpcount;
				if ($sscount >=3) break;
			}
	

			// смайлы для помощников хардкод в ch.php и в buttons.php
			if ($user['deal'] == -1 || $user['klan'] == "pal" || $user['id'] == 14897)  {
				$lsml = array();
				$lsml2 = array();
				while(list($k,$v) = each($hsmiles)) {
					$lsml[] = "/:".$k.":/";				
					$lsml2[] = "<img src=\"".$v."\">";
				}
				$_GET['text'] = preg_replace($lsml, $lsml2, $_GET['text'], 3);
			}
	

			if (($user['hidden']>0) and ($user['hiddenlog']!='')) {
				$fake=explode(",",$user['hiddenlog']); 
				//исходящее сообщение от перевопла
				$user['login'] = $fake[1];
			} else if($user['hidden']>0) {
			 	//исходящее от неведимы
				$user['login'] = 'Невидимка:'.$user['hidden'];
			}
	
			/// авто молчанка
			if (!isset($_SESSION['lastmes'])) $_SESSION['lastmes'] = 0;

			if ((!$_SESSION['lastmes']) OR ($_SESSION['lastmes']+10<time())) {
				$_SESSION['lastmes']=time();
				$_SESSION['mescount']=1;
			} else {
				$_SESSION['mescount']+=1;
			}


	            	if(($user['align']>2 && $user['align']<3) || $user['deal'] > 0 || $user['id']==190672 ) {
	            	 	// не применяем фильтр
	            	} elseif (($_SESSION['mescount'] >=3) and ($_SESSION['lastmes']+10>time())) {
				$_GET['text']='private ['.$user['login'].'] Вы не можете отправлять так часто сообщения... ';
			}

			if ($dooblechat==1) {
				$ci=0;	//для базы для доступа из другого города
			}
	
		   	if (strpos($_GET['text'],"private" ) !== FALSE) {
		   		$add_room=""; //рум не ставим если есть слово приват
		   	}

			// мысленная связь
			if (isset($alleff[9999])) {
				while(list($k,$misl_data) = each($alleff[9999])) {
					$test_str='private ['.$misl_data['add_info'].']'; 
					if (strpos($_GET['text'],$test_str) !== FALSE) {
						$ci=0;
					}
				}
			}

			// приваты для админов и диллеров - авто-масленная связь
			function mteststr($arr,$text) {
				foreach($arr as $what) {
					if (strpos($text,'private ['.$what.']') !== FALSE) {
						return true;
					}
				}
				return false;	
			}


			/*
			if ($ci!=0) {
				$mniks=array('Воин','-Ковальски-','Enchanter','Andres','Нахичеванец','Дилер','Торинос','DarliBank','Alibi','Walle','million','- Werter -','Bred','Архитектор','A-Tech','Десятый','Подмастерье','Тринити','Искушение','-Optimus Prime-','ICE QUEEN','Портной');
		
		 		if (((($user[deal]>0) or ($user['klan']=='radminion') or ($user['klan']=='Adminion') or ($user[id]==7937)) and (strpos($_GET['text'],'private [') !== FALSE)) or (mteststr($mniks,$_GET['text']))) {
		   			$ci=0;
		   		}
			}*/

			if ($user['hidden'] > 0) {
				$user['color'] = "Black";
			}
	

			if ($user['klan'] == "Adminion" || $user['klan'] == "radminion") {
				if (strpos($_GET['text'],'/rebootf') !== FALSE) {
					mysql_query2("UPDATE `oldbk`.`variables` SET `value`='1' WHERE `var`='fights_exit';");
					//mysql_query2("UPDATE `avalon`.`variables` SET `value`='1' WHERE `var`='fights_exit';");
					//mysql_query2("UPDATE `angels`.`variables` SET `value`='1' WHERE `var`='fights_exit';");					
				}
				if (strpos($_GET['text'],'/rebootarch') !== FALSE) {
					file_get_contents('http://capitalcity.oldbk.com/reboot.php?key=245by8ugesh4ruidkjf78w5yu&mode=arch');
				}
				if (strpos($_GET['text'],'/rebootmap') !== FALSE) {
					file_get_contents('http://capitalcity.oldbk.com/reboot.php?key=245by8ugesh4ruidkjf78w5yu&mode=map');
				}
			}

			$txt_to_file=":[".time ()."]:[{$user['login']}:|:{$user['id']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n";

		  	/// добавляем в базу чат
			mysql_query2("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."', `owner`='{$user['id']}'  , `city`='{$ci}' ".$add_room);
			$_SESSION['chatmsglast'] = mysql_insert_id();

			// 1 апреля
			if (isset($alleff[22223]) && $_GET['chtype'] != 6) {
				$vl = $alleff[22223][0]['add_info'];

				$_GET['text']  = TrimEPrivate($_GET['text']);
				$_GET['text'] .= str_replace('%NAME%',$vl,$l22223[mt_rand(0,count($l22223)-1)]);
				//$_GET['text'] = preg_replace($lsml, $lsml2, $_GET['text'], 3);

				$txt_to_file=":[".time ()."]:[{$user['login']}:|:{$user['id']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n";

				mysql_query2("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."', `owner`='{$user['id']}'  , `city`='{$ci}' ".$add_room);
				$_SESSION['chatmsglast'] = mysql_insert_id();
			}

			if (isset($alleff[22224]) && $_GET['chtype'] != 6) {
				$vl = $alleff[22224][0]['add_info'];

				$_GET['text']  = TrimEPrivate($_GET['text']);
				$_GET['text'] .= str_replace('%NAME%',$vl,$l22224[mt_rand(0,count($l22224)-1)]);
				$_GET['text'] = preg_replace($lsml, $lsml2, $_GET['text'], 3);

				$txt_to_file=":[".time ()."]:[{$user['login']}:|:{$user['id']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n";

				mysql_query2("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."', `owner`='{$user['id']}'  , `city`='{$ci}' ".$add_room);
				$_SESSION['chatmsglast'] = mysql_insert_id();
			}

			if (isset($alleff[22227]) && $_GET['chtype'] != 6) {
				$vl = $alleff[22227][0]['add_info'];

				$_GET['text']  = TrimEPrivate($_GET['text']);
				$_GET['text'] .= str_replace('%NAME%',$vl,$l22227[mt_rand(0,count($l22227)-1)]);
				$_GET['text'] = preg_replace($lsml, $lsml2, $_GET['text'], 3);

				$txt_to_file=":[".time ()."]:[{$user['login']}:|:{$user['id']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n";

				mysql_query2("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."', `owner`='{$user['id']}'  , `city`='{$ci}' ".$add_room);
				$_SESSION['chatmsglast'] = mysql_insert_id();
			}

	
			// комментатор	
			if (strpos($_GET['text'],"to [Комментатор]" ) !== FALSE && strpos($_GET['text'],"private") === FALSE) {
				if (strpos($_GET['text'],"to [Комментатор] анекдот" ) !== FALSE) {
					$commas = array(
						'Артника может обидеть каждый, но не каждый успеет извиниться. &copy;Мимоза',
						'ОлдБКшник сдает кровь. Медсестра, завязывая жгут: - Так, работаем кулачком! - По корпусу или в челюсть? &copy;Мимоза',
						'Артник приходит из центральной площади в клан с синяками на теле . Глава его спрашивает: — Что, напали? — Да, меч кромуса хотели отобрать. — Так ты их нам опознать-то сможешь? — А чё я-то? Пускай теперь их сокланновцы в морге опознают... &copy;Секс-Любовник',
						'Сидит команда в башне смерти. Делят оружие, вдруг в комнату входит член другой команды, весь уже разодетый. Глава команды кричит одному из своих: - МАРИНУЙ! - От маринуя слышу! &copy;Arkada',
						'"Сойдет за близы" - сказал Илья Муромец завязывая вокруг шеи змея Горыныча',
						'Часы показывали 16.08.03 12:00, когда бойцы клана MIB и Орден Паладинов бросили вызов друг другу. 12:01 Бой закончен. Победа за Merlin',
						'ХХХХ: Долой муфлонов из чата!!! Merlin: Пользователь ХХХХ был удалён по собственному желанию. &copy;XyliGUNka',
						'В конкурсе по женской логике победил генератор ударов &copy;Алексей',
						'Я вчера с такой девушкой познакомился… 90-60-90! - да ладно!! а выносливость сколько? &copy;Akrobat',
						'-Ах ты крыса!!! Ясно ж сказано, ТОЛЬКО ЯНТАРКИ! -Так я ж так и одет! -А эли, эли это что такое?! -Умные да?! А сами-то сможете на эль янтарку нацепить?!! &copy;Arkada',
						'-Думаете, ОлдБК - просто клон? Качайтесь, кризис скоро закончится.. &copy;Гефест',
						'Трин достала записку Комментатора. Комментатор орал и отбивался ногами. &copy;Посеша',
						'Хороший, плохой, главный тот, у кого сусел! &copy;Thomas Malton',
						'Наши комментаторы, самые <вырезано цензурой> комментаторские комментаторы в мире!'
					);
					addchp($commas[rand(0,count($commas)-1)],"Комментатор",$user['room'],$user['id_city']);
				} else {
					$commas = array(
						'Так слово за слово и получил Иванушка инвалидность...',
						'Что поговорить больше не с кем?',
						'Отдыхай!',
						'Вас много, комментатор - один!',
						'А станете наезжать, не буду комментировать ваши бои!',
						'Отвали!',
						'Тренируйся на кошечках!',
						'Анекдот: - Товарищ водитель, почему ваша пассажирка не пристегнута ремнями безопасности? - Так это же моя тёща!!',
						'Сам такой!',
						'Продам кредиты (в приват)',
						'мдя...',
						'Лучше в бою проявляй энтузиазм.',
						'Кто тут комментатор? Ты или я???',
						'Надо же...',
						'Сам дурак!',
						'Наши комментаторы, самые <вырезано цензурой> комментаторские комментаторы в мире!',
						'(судорожно оглядываясь) КТО ЗДЕСЬ???',
						'Не болтайте ерундой',
						'Все! Теперь ты мне должен!',
						'р-р-р...',
						'А в бою это повторить сможешь?',
						'Я долго думал, что такое 90х60х90. Оказалось, что это 486 000.',
						'Может тебе кредитов дать, чтоб отстал?',
						'Братву позову!',
						'Твой интеллект поражает <вырезано цензурой>',
						'Вот сижу тут и разбавляю свою мудрость вашей глупостью.',
						'Ты с кем посоревноваться решил?',
						'Ждите ответа. Ждите ответа. Ждите ответа. Ждите ответа. Ждите, короче...',
						'Я комментатор! А ты кто???',
						'Щас я все это запишу, а потом передам кляузу паладинам...',
						'я занят!!!'
					);
					addchp($commas[rand(0,count($commas)-1)],"Комментатор",$user['room'],$user['id_city']);
				}
			} elseif (strpos($_GET['text'],"to [Пятницо]" ) !== FALSE OR strpos($_GET['text'],"private [Пятницо]" ) !== FALSE) {
				if (date("w") == 5) {
					//Список случайных фраз, которые следует выдавать при обращении to/private Пятницо:				 
					$commas = array(
						'Я высокая зеленоглазая брюнетка. А ты как выглядишь?',
						'Что-то мне приключений захотелось... Почудим?',
						'Хватит скрывать свои чувства. Сознайся, я тебе нравлюсь.',
						'А давай устроим вечер откровений?',
						'У меня сегодня прекрасное настроение. Хочу общаться.',
						'Я Вас люблю. Ваш ровный почерк, и смайлы Ваши в конце строчек. Как Вам моя поэзия?',
						'Бывает, я сама себя не понимаю...',
						'Утомил ты меня. Пойду налью себе чего-нибудь покрепче. Никуда не уходи, я скоро вернусь.',
						'Гадаю по сетчатке глаза. Хочешь тебе сейчас погадаю? Придвинься ближе к монитору и широко раскрой глаза.',
						'В прошлый раз мы с тобой не договорили. Продолжим?',
						'Говорить не думая — все равно что стрелять не целясь.',
						'Тсс...я форум читаю!',
						'Хочу мороженого. Ты какое любишь?',
						'Можно я всем расскажу, какой комплимент ты мне в приват написал?',
						'Ты сладкоежка?',
						'Ну что ты такое говоришь? На самом деле все не так.',
						'Подари мне пару ласковых слов.',
						'Не спорь со мной. Я читала об этом в одной очень умной книжке.',
						'Давай я тебя тут со всеми познакомлю.',
						'Что-то я тебя не узнаю. Ты что ник сменил?',
						'Я так долго тебя ждала!',
						'Чем занимаешься?',
						'Давай дружить!',
						'я занята!!!'
					);
				
					if (strpos($_GET['text'],"to [Пятницо]" ) !== FALSE) {
						$pto=" to [".$user['login']."] ";
					} elseif (strpos($_GET['text'],"private [Пятницо]" ) !== FALSE) {
						$pto=" private [".$user['login']."] ";
					} else {
						$pto="";
					}
					addchp($pto.$commas[rand(0,count($commas)-1)],"Пятницо",$user['room'],$user['id_city']);
				}
			}
		}
	}
		
	echo "<script>document.domain = \"oldbk.com\"; top.CLR1();top.RefreshChat();</script>";

	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' Сompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
		die();
    	}       
} elseif (isset($_GET['showch'])) {


// для старого дизайна чата
if (isset($_GET['scan2']) == 1) {
	$_SESSION['toold'] = 1;

	// пишем лог
	/*
	$fp = fopen("./oldchat_log",'a+');
	flock ($fp,LOCK_EX);
	fputs($fp , time().":".$user['login'].":".$user['id']."\n");
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose ($fp);
	*/

}
if (isset($_SESSION['toold'])) $_GET['scan2'] = 1;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>

<SCRIPT LANGUAGE="JavaScript" SRC="http://i.oldbk.com/i/js/clipboard.min.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="http://chat.oldbk.com/i/ch5.js?ver=1" charset="windows-1251"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="http://i.oldbk.com/i/sl2.js"></SCRIPT>

<style type="text/css">

.hoversmile{
}

a.hoversmile:hover {
	/*border: solid black 1px;*/
	background-color:gray;
}

.ssm-smile-title {
  height:10px;
  font-size:120%;
  FONT-FAMILY:Tahoma;
  background:url(../i/smilestitle.gif);
  /*background-color:#6699FF; */
}
.ssm-smile-body {
  padding: 5px;
  overflow-y:scroll;
  height: 110px;
}

.menu {
  background-color: #d2d0d0;
  border-color: #ffffff #626060 #626060 #ffffff;
  border-style: solid;
  border-width: 1px;
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
}

.menuItem {
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none;
  cursor:pointer;
}

.menuItem:hover {
  background-color: #a2a2a2;
  color: #0066FF;
}

span {
  FONT-SIZE: 10pt;
  FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif;
  text-decoration: none;
  FONT-WEIGHT: bold;
  cursor: pointer;
}
.stext {
  cursor: default;
  FONT-WEIGHT: normal;
  FONT-SIZE: 10pt;
  FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif;
  text-decoration: none;
}

.my_clip_button {   
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none; }
.my_clip_button.hover { background-color: #a2a2a2; color: #0066FF; }

.chheadpas {
	background:url(http://i.oldbk.com/i/chat/chat_passive.jpg);
	background-repeat:no-repeat;
	text-align: center;
}

.chheadact {
	background:url(http://i.oldbk.com/i/chat/chat_aaactive.jpg);
	background-repeat:no-repeat;
	text-align: center;	
}

.newspas {
	background:url(http://i.oldbk.com/i/chat/news_pass.gif);
	background-repeat:no-repeat;
	text-align: center;
	cursor:pointer;
	white-space: nowrap;
}

.newspasr {
	background:url(http://i.oldbk.com/i/chat/news_passr.gif);
	background-repeat:no-repeat;
	text-align: center;
	cursor:pointer;	
	white-space: nowrap;	
}

.newsact {
	background:url(http://i.oldbk.com/i/chat/news_active.gif);
	background-repeat:no-repeat;
	text-align: center;	
	cursor:pointer;	
	white-space: nowrap;	
}

.cho {
		background:url(http://i.oldbk.com/i/chat/x_bg.jpg);
}

.chmtext {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #8b8b8b;
	font-size: 10px;
	text-align: center;
	text-decoration:none

}

.chheadpas {
	cursor:pointer;
}

.chheadpas.chmtext:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #1b1b1b;
	font-size: 10px;
	text-align: center;
	text-decoration:none;
}

.chmtext:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #1b1b1b;
	font-size: 10px;
	text-align: center;
	text-decoration:none
}

.chheadpas:hover a {color:#000000;}
.chheadact:hover a {color:#8b8b8b;}
.chheadact a {color:#000000;}
.chheadact:hover a {color:#000000;}
.chheadact:hover a {cursor:default;}

.ssm-smile {
   width:400px;
   height:140px;
   background-color:#f2f0f0;
   text-align: center;
   border: 2px groove black;
  opacity: 0.8; filter: alpha (opacity=80);
}
</style>

<SCRIPT>
document.domain = "oldbk.com";

function S(name){
	var sData = top.frames['bottom'].window.document;
	sData.F1.text.focus();
	sData.F1.text.value = sData.F1.text.value + ':'+name+': ';
}

function SSm(name){
	ssminput=top.frames['bottom'].document.getElementById('ssmtext');
	ssminput.focus();
	ssminput.value+=':'+name+': ';
}

var MsgArray = new Array();
var ImHelper = <?php if ($user['deal'] == -1) echo 'true'; else echo 'false'; ?>;

/*
function chktest() {
	alert(MsgArray.length);
}

setInterval(chktest,30*1000);
*/


function p(text,type) {
	if (type == 2 && text.indexOf("private") == -1) type = 1;
	MsgArray.push(new Array(text,type));

	var redraw = false;

	if (MsgArray.length >= 1000) {
		var removed = MsgArray.splice(0,200);
		redraw = true;
		for (key in removed) {
	 		delete removed[key];
		}
		delete removed;

	}


	if (text.indexOf("В прямом эфире для вас работает RDJ") != -1) {
		type = 5;
	}
	
	if (text.indexOf("<font color=red>Автозаявка на <b>турнир</b>") != -1) {
		type = 5;
	}
	
	if (type == currenttab || (currenttab == 1 && CheckMask(type) && type != 6 && type != 8) || (currenttab == 6 && CheckMask2(type) && type != 8) || (type == 7 && currenttab != 99) || (currenttab == 8 && CheckMask3(type) && type != 6)) {
		if  (type == 9) {
			document.getElementById("newsmes").innerHTML += text+"<BR>";
		} else {
			document.getElementById("mes").innerHTML += text+"<BR>";
		}
	} else {
		if ((viewmask[4] == 0 && !CheckMask(type) && type != 6) || (ImHelper && type == 6) || (viewmask[4] == 0 && ((currenttab >= 2 && currenttab <= 5) || (currenttab == 8)) && type != 6 && type != 8) || (viewmask[4] == 0 && currenttab == 6 && !CheckMask2(type) && type != 6)) {
			if (type != 1 && type != 7) {
				if (!top.OnlineOld) document.getElementById("wtab"+type).style.display = "";
				if (type==9) document.getElementById("ctab"+type).className = "newspasr";
			}
		}
	}
	if (redraw) {
		RedrawWindow();
	}

}

var currenttab = 1;
var viewmask = new Array(1,1,1,1,0,0,0,0,0,0,0,0,0,0);
var showhelpalert = true;

function clearfull() {
	if(confirm('Очистить весь чат?')) {
		clrchat();
	}
	document.getElementById("ClearMenu").style.display = "none";
}

function clearpanel() {
	if (currenttab == 99) {
		document.getElementById("ClearMenu").style.display = "none";
		return;
	}
	newmsgarray = new Array();
	for (key in MsgArray) {
 		t = MsgArray[key][1];
		if (!(t == currenttab || t == 7)) {
			newmsgarray.push(MsgArray[key]);
		}
	}

	MsgArray = newmsgarray;
	RedrawWindow();

	document.getElementById("ClearMenu").style.display = "none";
}

function clrchat() {
	MsgArray = new Array();	
	if ((currenttab != 99)&&(currenttab != 9)) document.getElementById("mes").innerHTML = "";
}

function toold() {
	top.OnlineOld = true;
	top.frames["online"].location.href = "http://chat.oldbk.com/ch.php?scan2=1&online=1"; 
	top.frames["bottom"].location.href = "buttons.php?scan2=1&a="+Math.random(); 
	top.frames["chat"].location.href = "http://chat.oldbk.com/ch.php?showch&scan2=1"; 
}


function ctab(n) {
	if (n == currenttab) return;

	/*
	if (n == 6 && ImHelper == false && showhelpalert == true) {
		alert("Здесь можно задать вопрос и получить разъяснения по игровому процессу. За использование этого чата не по назначению (общение на другие темы, флуд, найм, лечение, купля-продажа и тд.) последует наказание паладинской молчанкой.");
		showhelpalert = false;
	}*/

	if (n != 99 && n != 1) document.getElementById("wtab"+n).style.display = "none";

	if (currenttab == 99) {
		for (i = 2; i < 16; i++) {
			val = document.getElementById("mask"+i).checked;
			viewmask[i-2] = val;
		}
	}

	if (currenttab==9) {
		document.getElementById("ctab"+currenttab).className = "newspas";
		document.getElementById("newsmes").style.display = "none"; 
		document.getElementById("mes").style.display = ""; 
	} else {
		document.getElementById("ctab"+currenttab).className = "chheadpas";
		document.getElementById("mes").style.display = ""; 		
	}

	<?
		if (($user['klan']=='radminion') OR ($user['klan']=='Adminion')) {
			echo '
				if (currenttab!=10) {
					document.getElementById("newsadmin").style.display = "none"; 
					document.getElementById("mes").style.display = ""; 
				}
	
				if (n==10) {
					document.getElementById("newsadmin").style.display = "";
					document.getElementById("mes").style.display = "none"; 			
				} else {
					document.getElementById("newsadmin").style.display = "none"; 
				}
			';
		}
	?>		
		

		
	if (n==9) {
		document.getElementById("ctab"+n).className = "newsact";	
		document.getElementById("mes").style.display = "none"; 	
		document.getElementById("newsmes").style.display = ""; 				
	} else {
		document.getElementById("ctab"+n).className = "chheadact";
	}
		
	currenttab = n;
	if (n == 99) {
		var html = '<br><p style="margin-left:10px;">\
			<table cellpadding=4 cellspacing=4 border=0><tr><td><b>Отображать в:</b></td><td><b>Общем чате</b></td><td><b>Чате помощи</b></td><td><b>Торговом чате</b></td></tr>\
			<tr><td>Приватные сообщения</td>		<td align="center"><input type="checkbox" '+(viewmask[0] ? ' checked ' : "")+'id="mask2"></td><td align="center"><input type="checkbox" '+(viewmask[5] ? ' checked ' : "")+'id="mask7"> </td><td align="center"><input type="checkbox" '+(viewmask[10] ? ' checked ' : "")+'id="mask12"></td></tr>\
			<tr><td>Клановые каналы</td>		<td align="center"><input type="checkbox" '+(viewmask[1] ? ' checked ' : "")+'id="mask3"></td><td align="center"><input type="checkbox" '+(viewmask[6] ? ' checked ' : "")+'id="mask8"> </td><td align="center"><input type="checkbox" '+(viewmask[11] ? ' checked ' : "")+'id="mask13"></td></tr>\
			<tr><td>Групповой чат</td>		<td align="center"><input type="checkbox" '+(viewmask[2] ? ' checked ' : "")+'id="mask4"></td><td align="center"><input type="checkbox" '+(viewmask[7] ? ' checked ' : "")+'id="mask9"> </td><td align="center"><input type="checkbox" '+(viewmask[12] ? ' checked ' : "")+'id="mask14"></td></tr>\
			<tr><td>Системные сообщения</td> 	<td align="center"><input type="checkbox" '+(viewmask[3] ? ' checked ' : "")+'id="mask5"></td><td align="center"><input type="checkbox" '+(viewmask[8] ? ' checked ' : "")+'id="mask10"></td><td align="center"><input type="checkbox" '+(viewmask[13] ? ' checked ' : "")+'id="mask15"></td></tr>\
			</table><br>\
			<input type="checkbox" '+(viewmask[4] ? ' checked ' : "")+'id="mask6"> Отключить оповещения о новых сообщениях<br><br> \
			<input type="checkbox" '+(viewmask[9] ? ' checked ' : "")+'id="mask11"> Отключить автоскролл<br><br> \
			<input type="button" OnClick="toold();" style="font-weight:bold;" value="Переключиться на Старый Дизайн" name="Переключиться на Старый Дизайн"><br><br> \
		</p>';
		document.getElementById("mes").innerHTML = html;
	} else {
		RedrawWindow();
	}
}

function loadnews(sURL) {
	var request=null;
			 
	if(!request) try {
		request=new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e){}
			 
	if(!request) try {
		request=new ActiveXObject('Microsoft.XMLHTTP');
	} catch (e){}
			 
	if(!request) try {
		request=new XMLHttpRequest();
	} catch (e){}

	if(!request)
		return "";
	request.open('GET', sURL, false);
	request.send(null);
	return request.responseText;
}

function RedrawWindow() {
	var todraw = "";
	if (currenttab == 6) {
		todraw = "<center><font color=red>Здесь можно задать вопрос и получить разъяснения по игровому процессу.<br> За использование этого чата не по назначению (общение на другие темы, флуд, найм, лечение, купля-продажа и тд.) последует наказание паладинской молчанкой.</font></center><BR>";
	} else if (currenttab == 9) {
		todraw = loadnews('http://chat.oldbk.com/newsupdate.php');
		document.getElementById("newsmes").innerHTML =todraw+ '<br><div id="fulllink" style="float:right;"><small><a target="_blank" href="http://capitalcity.oldbk.com/events.php">Все сообщения</a></small>&nbsp;&nbsp;&nbsp;</div><br>';
		return;
	}
	
	for (key in MsgArray) {
 		t = MsgArray[key][1];

		if (MsgArray[key][0].indexOf("В прямом эфире для вас работает RDJ") != -1) {
			t = 5;
		}

		if (t == currenttab || (currenttab == 1 && CheckMask(t) && t != 6 && t != 8) || (currenttab == 6 && CheckMask2(t) && t != 8) || (t == 7 && currenttab != 6) || (currenttab == 8 && CheckMask3(t) && t != 6)) {
			todraw += MsgArray[key][0]+"<BR>";
		}
 	}
	document.getElementById("mes").innerHTML = todraw;
	if (currenttab != 6) {
		top.frames['chat'].window.scrollBy(0, 65000);
		top.frames['chat'].window.scrollBy(0, 65000);
	} else {
		if (ImHelper) {
			top.frames['chat'].window.scrollBy(0, 65000);
			top.frames['chat'].window.scrollBy(0, 65000);
		} else {
			top.frames['chat'].window.scrollBy(0, -65000);
		}
	}
}

function CheckMask(tab) {
	if (viewmask[tab-2]) return true;
	return false;
}

function CheckMask2(tab) {
	if (viewmask[tab+3]) return true;
	return false;
}

function CheckMask3(tab) {
	if (viewmask[tab+8]) return true;
	return false;
}

function changechatpos(size) {
	var obj = top.document.getElementById("mainchat");
	var tmp = obj.rows;
	var reg = /[\d]{1,}\%/g
	tmp = parseInt(reg.exec(tmp));

	if (!size) {
		// plus
		tmp += 10;
		if (tmp > 95) tmp = 95;
	} else {
		// minus
		tmp -= 10;
		if (tmp <= 0) tmp = 0;
	}
	obj.rows = tmp+"%,*,0";
}

</SCRIPT>
</head>

<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 bgcolor=#eeeeee onLoad="top.RefreshChat();">
<?php
if (!isset($_GET['scan2'])) {
?>
<div id="fixednew" style="position:fixed;margin:0px;padding:0px;z-index:999;width:100%;text-align:center;overflow:auto;">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
 	 <tr>
 	    <td background="http://i.oldbk.com/i/chat/x_bg.jpg" height="26">&nbsp;</td>
	    <td nowrap width=36 height="26" id="ctab0" class="chheadpas"><img OnClick="changechatpos(1);" style="margin-top:8px;cursor:pointer;" src="http://i.oldbk.com/i/up.gif" alt="Увеличить высоту чату" title="Увеличить высоту чату"> <img OnClick="changechatpos(0);" style="cursor:pointer;margin-top:8px;" src="http://i.oldbk.com/i/down.gif" alt="Уменьшить высоту чату" title="Уменьшить высоту чату"></td>
     	    <td background="http://i.oldbk.com/i/chat/news_pass.gif"  title="Обновления" alt="Обновления" width="42" height="26" id="ctab9"  class="newspas"  OnClick="ctab(9);return false;" nowrap style="position:fixed;"><a href="#" OnClick="ctab(9);return false;">&nbsp;<span style="display:none;" id="wtab9"></span></a></td>
	<?
		if (($user['klan']=='radminion') OR ($user['klan']=='Adminion'))
		{
		echo '<td nowrap width="115" height="26" id="ctab10" class="chheadpas" OnClick="ctab(10);return false;"><a href="#" OnClick="ctab(10);return false;" class="chmtext">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admin<span style="display:none;" id="wtab10"> (<font color=red>!</font>)</span></a></td>';
		}
	?>
	    <td nowrap width="26" height="26" background="http://i.oldbk.com/i/chat/chat_icon.jpg"></td>
	    <td nowrap width=115 height="26" id="ctab1" class="chheadact" OnClick="ctab(1);return false;"><a href="#" class="chmtext">Общий чат</a></td>
	    <td nowrap width=115 height="26" id="ctab2" class="chheadpas" OnClick="ctab(2);return false;"><a href="#" OnClick="ctab(2);return false;" class="chmtext">Приваты<span style="display:none;" id="wtab2"> (<font color=red>!</font>)</span></a></td>
	    <td nowrap width=115 height="26" id="ctab3" class="chheadpas" OnClick="ctab(3);return false;"><a href="#" OnClick="ctab(3);return false;" class="chmtext">Клановый чат<span style="display:none;" id="wtab3"> (<font color=red>!</font>)</span></a></td>
	    <td nowrap width=115 height="26" id="ctab4" class="chheadpas" OnClick="ctab(4);return false;"><a href="#" OnClick="ctab(4);return false;" class="chmtext">Групповой чат<span style="display:none;" id="wtab4"> (<font color=red>!</font>)</span></a></td>
	    <td nowrap width=115 height="26" id="ctab8" class="chheadpas" OnClick="ctab(8);return false;"><a href="#" OnClick="ctab(8);return false;" class="chmtext">Торговый<span style="display:none;" id="wtab8"></span></a></td>	    
	    <td nowrap width=115 height="26" id="ctab5" class="chheadpas" OnClick="ctab(5);return false;"><a href="#" OnClick="ctab(5);return false;" class="chmtext">Системные<span style="display:none;" id="wtab5"> (<font color=red>!</font>)</span></a></td>

	    <td nowrap width=115 height="26" title="Здесь можно задать вопрос и получить разъяснения по игровому процессу. За использование этого чата не по назначению (общение на другие темы, флуд, найм, лечение, купля-продажа и тд.) последует наказание паладинской молчанкой." alt="Здесь можно задать вопрос и получить разъяснения по игровому процессу. За использование этого чата не по назначению (общение на другие темы, флуд, найм, лечение, купля-продажа и тд.) последует наказание паладинской молчанкой." id="ctab6" class="chheadpas" OnClick="ctab(6);return false;"><a href="#" OnClick="ctab(6);return false;" class="chmtext">Помощь<span style="display:none;" id="wtab6"> (<font color=red>!</font>)</span></a></td>
	    <td nowrap width=115 height="26" id="ctab99" class="chheadpas" OnClick="ctab(99);return false;"><a href="#" OnClick="ctab(99);return false;" class="chmtext">Настройки</a></td>
	    <td background="http://i.oldbk.com/i/chat/x_bg.jpg" height="26">&nbsp;</a></td>
	  </tr>
	</table>
  </td></tr>

</div><br style="margin:0px;padding:0px;"><br>
<?php
}
?>

	<div style="margin-top:10px;margin-left:3px;margin-bottom:10px;" id="mes"></div>
	<div style="margin-top:10px;margin-left:3px;margin-bottom:10px;display:none;" id="newsmes"></div>
	<?
	if (($user['klan']=='radminion') OR ($user['klan']=='Adminion'))
	{
	echo '<div style="display:none; margin-top:10px;margin-left:3px;margin-bottom:10px; bottom: 0px; width: 95%; height:300px " id="newsadmin"> 
	 <iframe  src="http://chat.oldbk.com/api_add_admin.php" width="100%" height="100%" scrolling="yes" frameborder="0" style="padding: 0px; margin: 0px;" /></iframe></div>';
	}
	?>

<DIV ID="oMenu" style="width:auto;position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>
<DIV ID="ClearMenu" style="position:absolute; border:1px solid #666; background-color:#e2e0e0; display:none; "></DIV>
</body>
</html>

<?php
}
?>