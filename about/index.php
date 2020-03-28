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

global $prefix, $submenu_about;

$prefix = '..';
$query = getenv('QUERY_STRING');
$paramPos = strpos($query, '&');
if ($paramPos !== false) $query = substr($query, 0, $paramPos);

if ($lang != 'cs') {
  $submenu_about = '
<ul><li><strike><a href="'.$parentPrefix.'?resume'.$langPostfix.'">Resume</a></strike></li>
<li><strike><a href="'.$parentPrefix.'?pets'.$langPostfix.'">Pets</a></strike></li>
<li><a href="'.$parentPrefix.'?computers'.$langPostfix.'">Computers</a></li>
</ul>';
} else {
  $submenu_about = '
<ul><li><strike><a href="'.$parentPrefix.'?resume'.$langPostfix.'">Životopis</a></strike></li>
<li><strike><a href="'.$parentPrefix.'?pets'.$langPostfix.'">Mazlíčci</a></strike></li>
<li><a href="'.$parentPrefix.'?computers'.$langPostfix.'">Počítače</a></li></ul>';
}

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