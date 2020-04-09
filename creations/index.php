<?php
$requestedLang = (isset($_GET['lang']) && ($_GET['lang'] == 'cs' || $_GET['lang'] == 'en')) ? $_GET['lang'] : '';

$lang = $requestedLang;
if ($requestedLang == '') {
    $supportedLangs = array('cs', 'en-GB', 'en');
    $languages = explode(',', @$_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $langMatch = '';
    foreach ($languages as $nextLang) {
      if (in_array($nextLang, $supportedLangs)) {
        $lang = $nextLang == 'cs' ? 'cs' : 'en';
        break;
      }
    }
}
$filePostfix = ($lang == 'cs') ? '_cs' : '';
$langPostfix = ($requestedLang != '') ? '&amp;lang='.$requestedLang : '';

global $prefix, $submenu_software, $submenu_sites;

$prefix = '..';
$query = getenv('QUERY_STRING');
$paramPos = strpos($query, '&');
if ($paramPos !== false) $query = substr($query, 0, $paramPos);

if (($query == 'text') || (strncmp($query, "text/", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_text = '
<ul><li><a href="?text/literary'.$langPostfix.'">Literary</a></li>
<li><a href="?text/subtitles'.$langPostfix.'">Subtitles</a></li></ul>';
  } else {
    $submenu_text = '
<ul><li><a href="?text/literary'.$langPostfix.'">Literární</a></li>
<li><a href="?text/subtitles'.$langPostfix.'">Titulky</a></li></ul>';
  }
} else if (($query == 'graphic') || (strncmp($query, "graphic/", 8) === 0)) {
  if ($lang != 'cs') {
    $submenu_graphic = '
<ul><li><a href="?graphic/icons'.$langPostfix.'">Icons</a></li>
<li><a href="?graphic/paintings'.$langPostfix.'">Paintings</a></li></ul>';
  } else {
    $submenu_graphic = '
<ul><li><a href="?graphic/icons'.$langPostfix.'">Ikony</a></li>
<li><a href="?graphic/paintings'.$langPostfix.'">Malby</a></li></ul>';
  }
} else if (($query == 'music') || (strncmp($query, "music/", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_music = '
<ul><li><a href="?music/old'.$langPostfix.'">Old</a></li></ul>';
  } else {
    $submenu_music = '
<ul><li><a href="?music/old'.$langPostfix.'">Staré</a></li></ul>';
  }
} else if (($query == 'video') || (strncmp($query, "video/", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_video = '
<ul><li><del><a href="?todo'.$langPostfix.'">TODO</a></del></li></ul>';
  } else {
    $submenu_video = '
<ul><li><del><a href="?todo'.$langPostfix.'">TODO</a></del></li></ul>';
  }
}

$childIndex = 'creations';
include('../header.php');

if (empty($query)) {
  $include = 'pages/main'.$filePostfix.'.php';
} else {
  $target = 'pages/'.str_replace('/','_',$query).$filePostfix.'.php';
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
  	http_response_code(404);
    $include = 'pages/not-found'.$filePostfix.'.php';
  }
}

include $include;

include '../refer.php';
?>