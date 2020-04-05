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

if (($query == 'text') || (strncmp($query, "text_", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_text = '
<ul><li><a href="?text_literary'.$langPostfix.'">Literary</a></li>
<li><a href="?text_subtitles'.$langPostfix.'">Subtitles</a></li></ul>';
  } else {
    $submenu_text = '
<ul><li><a href="?text_literary'.$langPostfix.'">Literární</a></li>
<li><a href="?text_subtitles'.$langPostfix.'">Titulky</a></li></ul>';
  }
} else if (($query == 'music') || (strncmp($query, "music_", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_music = '
<ul><li><del><a href="?music_old'.$langPostfix.'">Old</a></del></li></ul>';
  } else {
    $submenu_music = '
<ul><li><del><a href="?music_old'.$langPostfix.'">Old</a></del></li></ul>';
  }
} else if (($query == 'media') || (strncmp($query, "media_", 6) === 0)) {
  if ($lang != 'cs') {
    $submenu_media = '
<ul><li><del><a href="?todo'.$langPostfix.'">TODO</a></del></li></ul>';
  } else {
    $submenu_media = '
<ul><li><del><a href="?todo'.$langPostfix.'">TODO</a></del></li></ul>';
  }
}

$childIndex = 'creations';
include('../header.php');

if (empty($query)) {
  $include = 'pages/main'.$filePostfix.'.php';
} else {
  $target = 'pages/'.$query.$filePostfix.'.php';
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
    $include = 'pages/not-found'.$filePostfix.'.php';
  }
}

include $include;

include '../refer.php';
?>