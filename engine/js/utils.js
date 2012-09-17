function delete_confirm(){
  return confirm("Уверены, что хотите удалить?");
}

function $$(element) {
  return document.getElementById(element);
}

function addBookmark(url, title)
{
  if (!url) url = location.href;
  if (!title) title = document.title;
  
  //Gecko
  if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function")) window.sidebar.addPanel (title, url, "");
  //IE4+
  else if (typeof window.external == "object") window.external.AddFavorite(url, title);
  //Opera7+
  else if (window.opera && document.createElement)
  {
    var a = document.createElement('A');
    if (!a) return false; //IF Opera 6
    a.setAttribute('rel','sidebar');
    a.setAttribute('href',url);
    a.setAttribute('title',title);
    a.click();
  }
  else return false;
  
  return true;
}

//<!--
//<![CDATA[
  function menuhide(menunum)
  {
    var currentmenu = document.getElementById("navbody" + menunum);
    currentmenu.style.visibility = 'hidden';
  }

  function menushow(menunum)
  {
    var currentmenu = document.getElementById("navbody" + menunum);
    currentmenu.style.visibility = 'visible';
  }
//]]>
//-->

/**
 *	Показать / Спрятать статистику 
 *	autor divBYzero 
 */
function st_show_hide(elem) {
	var stat = document.getElementById(elem);
	if (stat.style.display == "") {
		stat.style.display = "none";
	} else {
		stat.style.display = "";
	}
}

/**
 *	Предупреждение (warning_and_submit)
 *	autor divBYzero 
 */
function w_a_s(text,form_name, _new) {
  if (confirm("Внимание! "+text)) {
	if (_new != "") {
		start = document.forms[form_name].elements[_new];
		start.value="new";
	}
    document.forms[form_name].submit();
  } else {
    return false;
  }
}