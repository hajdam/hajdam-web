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

if (($query == 'sites') || (strncmp($query, "site_", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_sites = '
<ul><li><a href="?site_homepage'.$langPostfix.'">Homepage</a></li>
<li><a href="?site_sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?site_iper'.$langPostfix.'">I.P.E.R Website</a></li></ul>';
  } else {
    $submenu_sites = '
<ul><li><a href="?site_homepage'.$langPostfix.'">Osobní stránka</a></li>
<li><a href="?site_sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?site_iper'.$langPostfix.'">I.P.E.R Web</a></li></ul>';
  }
} else if (($query == 'concepts') || (strncmp($query, "concept_", 8) === 0)) {
  if ($lang != 'cs') {
    $submenu_concepts = '
<ul><li><del><a href="?concept_todo'.$langPostfix.'">TODO</a></del></li></ul>';
  } else {
    $submenu_concepts = '
<ul><li><del><a href="?concept_todo'.$langPostfix.'">TODO</a></del></li></ul>';
  }
} else {
  if ($lang != 'cs') {
    $submenu_software = '
<ul><li><a href="?exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?consonica'.$langPostfix.'">Consonica</a></li></ul>';
  } else {
    $submenu_software = '
<ul><li><a href="?exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?consonica'.$langPostfix.'">Consonica</a></li></ul>';
  }
}

$childIndex = 'projects';
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