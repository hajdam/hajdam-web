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

if (($query == 'sites') || (strncmp($query, "site/", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_sites = '
<ul><li><a href="?site/homepage'.$langPostfix.'">Homepage</a></li>
<li><a href="?site/sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?site/iper'.$langPostfix.'">I.P.E.R Website</a></li></ul>';
  } else {
    $submenu_sites = '
<ul><li><a href="?site/homepage'.$langPostfix.'">Osobní stránka</a></li>
<li><a href="?site/sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?site/iper'.$langPostfix.'">I.P.E.R Web</a></li></ul>';
  }
} else if (($query == 'concepts') || (strncmp($query, "concept/", 8) === 0)) {
  if ($lang != 'cs') {
    $submenu_concepts = '
<ul><li><a href="?concept/sharpmz'.$langPostfix.'">Sharp MZ</a></li></ul>';
  } else {
    $submenu_concepts = '
<ul><li><a href="?concept/sharpmz'.$langPostfix.'">Sharp MZ</a></li></ul>';
  }
} else {
  if ($lang != 'cs') {
    $submenu_software = '
<ul><li><a href="?exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?comusika'.$langPostfix.'">Comusika</a></li>
<li><a href="?software/java'.$langPostfix.'">More (Java)</a></li>
<li><a href="?software/delphi'.$langPostfix.'">Old (Delphi)</a></li>
<li><a href="?software/pascal'.$langPostfix.'">Old (Pascal)</a></li>
<li><a href="?software/sharpmz'.$langPostfix.'">Old (Sharp MZ)</a></li></ul>';
  } else {
    $submenu_software = '
<ul><li><a href="?exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?comusika'.$langPostfix.'">Comusika</a></li>
<li><a href="?software/java'.$langPostfix.'">Další (Java)</a></li>
<li><a href="?software/delphi'.$langPostfix.'">Staré (Delphi)</a></li>
<li><a href="?software/pascal'.$langPostfix.'">Staré (Pascal)</a></li>
<li><a href="?software/sharpmz'.$langPostfix.'">Staré (Sharp MZ)</a></li></ul>';
  }
}

$childIndex = 'projects';
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