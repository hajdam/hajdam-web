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
<ul><li><a href="?resume'.$langPostfix.'">Resume</a></li>
<li><del><a href="?pets'.$langPostfix.'">Pets</a></del></li>
<li><a href="?computers'.$langPostfix.'">Computers</a></li>
</ul>';
} else {
  $submenu_about = '
<ul><li><a href="?resume'.$langPostfix.'">Životopis</a></li>
<li><del><a href="?pets'.$langPostfix.'">Mazlíčci</a></del></li>
<li><a href="?computers'.$langPostfix.'">Počítače</a></li></ul>';
}

$childIndex = 'about';
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