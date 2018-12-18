document.domain = "oldbk.com";
//-------------------------------------------------------------
// Функция для определения координат указателя мыши
function defPosition(event) {
	var isIE11 = navigator.userAgent.match(/Trident\/7.0.*rv.*11\.0/);

      var x = y = 0;
      if (document.attachEvent != null || isIE11) { // Internet Explorer & Opera
            x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
            y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
			if (window.event.clientY + 72 > document.body.clientHeight) { y-=68 } else { y-=2 }
      } else if (!document.attachEvent && document.addEventListener) { // Gecko
            x = event.clientX + window.scrollX;
            y = event.clientY + window.scrollY;
			if (event.clientY + 72 > document.body.clientHeight) { y-=68 } else { y-=2 }
      } else {
            // Do nothing
      }
      return {x:x, y:y};
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

var flagpop=0;

function OpenMenu2(evt,level){
    evt = evt || window.event;
    evt.cancelBubble = true;

	 var found = document.getElementById(level).innerHTML;
    var menu = document.getElementById("oMenu");
    var html = "";
	html  = '<a href="javascript:void(0)" class="menuItem" onclick="window.open(\'http://capitalcity.oldbk.com/topal.php?id='+level+'\',\'help\',\'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes\'); cMenu();">Сообщить о нарушении</a>';

 // Если есть что показать - показываем
    if (html){
        menu.innerHTML = html;
        menu.style.top = defPosition2(evt).y + "px";
        menu.style.left = defPosition2(evt).x + "px";
        menu.style.display = "";
    }
    // Блокируем всплывание стандартного браузерного меню
    return false;
}

var clip = null;

function OpenMenu(evt,level){
    evt = evt || window.event;
    evt.cancelBubble = true;
    // Показываем собственное контекстное меню
    var menu = document.getElementById("oMenu");
    var html = "";
	login=(evt.target || evt.srcElement).innerHTML;

	var i1, i2;
	if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);

	var login2 = login;
	login2 = login2.replace('%', '%25');
	while (login2.indexOf('+')>=0) login2 = login2.replace('+', '%2B');
	while (login2.indexOf('#')>=0) login2 = login2.replace('#', '%23');
	while (login2.indexOf('?')>=0) login2 = login2.replace('?', '%3F');


//	html  = '<table border=0 cellapadding=0 cellspacing=0><tr><td></td><td><a href="javascript:void(0)" class="menuItem" style="display:inline;" onclick="top.AddTo(\''+login+'\');cMenu()">Написать в общий чат</a></td></tr>'+
//	'<tr><td align="center"><img src="http://i.oldbk.com/i/lock.gif"></td><td><a href="javascript:void(0)" class="menuItem" style="display:inline;" onclick="top.AddToPrivate(\''+login+'\');cMenu()">Написать приватно</a></td></tr>'+
//	'<tr><td align="center"><img src="http://i.oldbk.com/i/inf.gif"></td><td><a href="javascript:void(0)" class="menuItem" style="display:inline;" onclick="window.open(\'http://capitalcity.oldbk.com/inf.php?login='+login+'\')"; cMenu();">Открыть инфо персонажа</a></td></tr>'+
//	'<tr><td></td><td><A href="javascript:void(0)" class="menuItem" style="display:inline;" onclick="AddToList(\''+login+'\',1);return false;">Добавить в список друзей</A></td></tr>'+
//	'<tr><td></td><td><A HREF="javascript:void(0)" class="menuItem" style="display:inline;" onclick="AddToList(\''+login+'\',2);return false;">Добавить в игнор-лист</A></td></tr>'+
//	'<tr><td></td><td><div class="d_clip_button" data-clipboard-text="'+login+'" id="d_clip_button"><A href="#" class="menuItem" style="display:inline;" onclick="return false;">Скопировать имя персонажа</a></div></td></tr></table>';

	html  = '<a href="javascript:void(0)" class="menuItem" onclick="top.AddTo(\''+login+'\');cMenu()">Написать в общий чат</a>'+
	'<a href="javascript:void(0)" class="menuItem" onclick="top.AddToPrivate(\''+login+'\');cMenu()">Написать приватно</a>'+
	'<a href="javascript:void(0)" class="menuItem" onclick="window.open(\'http://capitalcity.oldbk.com/inf.php?login='+login+'\')"; cMenu();">Открыть инфо персонажа</a>'+
	'<A href="javascript:void(0)" class="menuItem" onclick="AddToList(\''+login+'\',1);return false;">Добавить в список друзей</A>'+
	'<A HREF="javascript:void(0)" class="menuItem" onclick="AddToList(\''+login+'\',2);return false;">Добавить в игнор-лист</A>'+
	'<div class="d_clip_button" data-clipboard-text="'+login+'" id="d_clip_button"><A href="#" class="menuItem" onclick="return false;">Скопировать имя персонажа</a></div>';


 // Если есть что показать - показываем
    if (html){
        menu.innerHTML = html;
        posx = defPosition2(evt).y;

	if (posx > 100) {
		if (document.body.offsetHeight - posx < 80) posx = posx - 80;
	}

	menu.style.top = posx + "px";
 
        menu.style.left = defPosition2(evt).x + "px";
        menu.style.display = "";
    }
	if (flagpop==0){
		flagpop=1;
	} else {
	}
    // Блокируем всплывание стандартного браузерного меню
    clip = new Clipboard(document.getElementById('d_clip_button'));
    return false;
}


function AddToList(login, type) {
	mypath = "http://capitalcity.oldbk.com/friends.php?FindLogin="+login+"&pals=1";
	if (type == 2) {
		mypath += "1&addenemy";
	}

	top.frames['main'].location = mypath;
}



function addHandler(object, event, handler, useCapture){
    if (object.addEventListener){
        object.addEventListener(event, handler, useCapture ? useCapture : false);
    } else if (object.attachEvent){
        object.attachEvent('on' + event, handler);
    } else alert("Add handler is not supported");
}

addHandler(document, "contextmenu", function(){
  if (clip) { 
	delete clip;
	clip = null;
  }
  document.getElementById("oMenu").style.display = "none";
});

addHandler(document, "click", function(){
  if (clip) { 
	delete clip;
	clip = null;
  }
  document.getElementById("oMenu").style.display = "none";
});

function cMenu() {
  if (clip) { 
	delete clip;
	clip = null;
  }
  document.getElementById("oMenu").style.display = "none";
  top.frames['bottom'].window.document.F1.text.focus();
}
//-------------------------------------------------------------------------