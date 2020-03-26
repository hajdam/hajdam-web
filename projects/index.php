<?php
$requestedLang = (isset($_GET['lang']) && ($_GET['lang'] == 'cs' || $_GET['lang'] == 'en')) ? $_GET['lang'] : '';

$lang = $requestedLang;
if ($requestedLang == '') {
    $supportedLangs = array('cs', 'en-GB', 'en');
    $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
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

if ($lang != 'cs') {
  if ($query == 'sites') {
    $submenu_sites = '
<ul><li><a href="'.$parentPrefix.'?site_exbin'.$langPrefix.'">ExBin Project</a></li>
<li><a href="'.$parentPrefix.'?site_sharpmz'.$langPrefix.'">Sharp MZ</a></li>
<li><a href="'.$parentPrefix.'?site_iper'.$langPrefix.'">I.P.E.R Website</a></li></ul>';
  } else {
    $submenu_software = '
<ul><li><a href="'.$parentPrefix.'?exbin'.$langPrefix.'">ExBin Project</a></li>
<li><a href="'.$parentPrefix.'?bined'.$langPrefix.'">BinEd Editor</a></li>
<li><a href="'.$parentPrefix.'?mzemu'.$langPrefix.'">Sharp MZ Emulator</a></li></ul>';
  }
} else {
  if ($query == 'sites') {
    $submenu_sites = '
<ul><li><a href="'.$parentPrefix.'?site_exbin'.$langPrefix.'">ExBin Project</a></li>
<li><a href="'.$parentPrefix.'?site_sharpmz'.$langPrefix.'">Sharp MZ</a></li>
<li><a href="'.$parentPrefix.'?site_iper'.$langPrefix.'">I.P.E.R Website</a></li></ul>';
  } else {
    $submenu_software = '
<ul><li><a href="'.$parentPrefix.'?exbin'.$langPrefix.'">ExBin Project</a></li>
<li><a href="'.$parentPrefix.'?bined'.$langPrefix.'">BinEd Editor</a></li>
<li><a href="'.$parentPrefix.'?mzemu'.$langPrefix.'">Sharp MZ Emulator</a></li></ul>';
  }
}

include('../header.php');

if (empty($query)) {
  $include = 'pages/main.php';
} else {
  $target = 'pages/'.$query.'.php';
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
    $include = 'pages/not-found.php';
  }
}

include $include;

include '../refer.php';
?>