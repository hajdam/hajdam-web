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
$query = @$_GET['p'];
if (empty($query)) {
  $query = @getenv('QUERY_STRING');
  $paramEndPos = strpos($query, '&');
  $valuePos = strpos($query, '=');
  if (!empty($query) && ($paramEndPos == null || ($paramEndPos > 0 && ($valuePos == null || $valuePos > $paramEndPos)))) {
    header('Location: ?p='.$query);
    exit();
  }
  $query = "";
}

if (($query == 'texts') || (strncmp($query, "text/", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_text = '
<ul><li><a href="?p=text/literary'.$langPostfix.'">Literary</a></li>
<li><a href="?p=text/subtitles'.$langPostfix.'">Subtitles</a></li></ul>';
  } else {
    $submenu_text = '
<ul><li><a href="?p=text/literary'.$langPostfix.'">Literární</a></li>
<li><a href="?p=text/subtitles'.$langPostfix.'">Titulky</a></li></ul>';
  }
} else if (($query == 'graphics') || (strncmp($query, "graphic/", 8) === 0)) {
  if ($lang != 'cs') {
    $submenu_graphic = '
<ul><li><a href="?p=graphic/icons'.$langPostfix.'">Icons</a></li>
<li><a href="?p=graphic/paintings'.$langPostfix.'">Paintings</a></li></ul>';
  } else {
    $submenu_graphic = '
<ul><li><a href="?p=graphic/icons'.$langPostfix.'">Ikony</a></li>
<li><a href="?p=graphic/paintings'.$langPostfix.'">Malby</a></li></ul>';
  }
} else if (($query == 'music') || (strncmp($query, "music/", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_music = '
<ul><li><a href="?p=music/old'.$langPostfix.'">Old</a></li></ul>';
  } else {
    $submenu_music = '
<ul><li><a href="?p=music/old'.$langPostfix.'">Staré</a></li></ul>';
  }
} else if (($query == 'video') || (strncmp($query, "video/", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_video = '
<ul><li><a href="?p=video/old'.$langPostfix.'">Old</a></li></ul>';
  } else {
    $submenu_video = '
<ul><li><a href="?p=video/old'.$langPostfix.'">Staré</a></li></ul>';
  }
} else if (($query == 'games') || (strncmp($query, "game/", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_game = '
<ul><li><a href="?p=game/minecraft'.$langPostfix.'">Minecraft</a></li>
<li><a href="?p=game/shapezio'.$langPostfix.'">shapez.io</a></li></ul>';
  } else {
    $submenu_game = '
<ul><li><a href="?p=game/minecraft'.$langPostfix.'">Minecraft</a></li>
<li><a href="?p=game/shapezio'.$langPostfix.'">shapez.io</a></li></ul>';
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