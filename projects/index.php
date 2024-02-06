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

if (($query == 'sites') || (strncmp($query, "site/", 5) === 0)) {
  if ($lang != 'cs') {
    $submenu_sites = '
<ul><li><a href="?p=site/homepage'.$langPostfix.'">Homepage</a></li>
<li><a href="?p=site/sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?p=site/iper'.$langPostfix.'">I.P.E.R Website</a></li></ul>';
  } else {
    $submenu_sites = '
<ul><li><a href="?p=site/homepage'.$langPostfix.'">Osobní stránka</a></li>
<li><a href="?p=site/sharpmz'.$langPostfix.'">Sharp MZ Wiki</a></li>
<li><a href="?p=site/iper'.$langPostfix.'">I.P.E.R Web</a></li></ul>';
  }
} else if (($query == 'concepts') || (strncmp($query, "concept/", 8) === 0)) {
  if ($lang != 'cs') {
    $submenu_concepts = '
<ul><li><a href="?p=concept/sharpmz'.$langPostfix.'">Sharp MZ</a></li></ul>';
  } else {
    $submenu_concepts = '
<ul><li><a href="?p=concept/sharpmz'.$langPostfix.'">Sharp MZ</a></li></ul>';
  }
} else {
  if ($lang != 'cs') {
    $submenu_software = '
<ul><li><a href="?p=exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?p=bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?p=mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?p=comusika'.$langPostfix.'">Comusika</a></li>
<li><a href="?p=software/java'.$langPostfix.'">More (Java)</a></li>
<li><a href="?p=software/delphi'.$langPostfix.'">Old (Delphi)</a></li>
<li><a href="?p=software/pascal'.$langPostfix.'">Old (Pascal)</a></li>
<li><a href="?p=software/sharpmz'.$langPostfix.'">Old (Sharp MZ)</a></li></ul>';
  } else {
    $submenu_software = '
<ul><li><a href="?p=exbin'.$langPostfix.'">ExBin Project</a></li>
<li><a href="?p=bined'.$langPostfix.'">BinEd Editor</a></li>
<li><a href="?p=mzemu'.$langPostfix.'">Sharp MZ Emulator</a></li>
<li><a href="?p=comusika'.$langPostfix.'">Comusika</a></li>
<li><a href="?p=software/java'.$langPostfix.'">Další (Java)</a></li>
<li><a href="?p=software/delphi'.$langPostfix.'">Staré (Delphi)</a></li>
<li><a href="?p=software/pascal'.$langPostfix.'">Staré (Pascal)</a></li>
<li><a href="?p=software/sharpmz'.$langPostfix.'">Staré (Sharp MZ)</a></li></ul>';
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