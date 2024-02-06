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

if ($lang != 'cs') {
  $submenu_about = '
<ul><li><a href="?p=resume'.$langPostfix.'">Resume</a></li>
<li><a href="?p=pets'.$langPostfix.'">Pets</a></li>
<li><a href="?p=computers'.$langPostfix.'">Computers</a></li>
</ul>';
} else {
  $submenu_about = '
<ul><li><a href="?p=resume'.$langPostfix.'">Životopis</a></li>
<li><a href="?p=pets'.$langPostfix.'">Mazlíčci</a></li>
<li><a href="?p=computers'.$langPostfix.'">Počítače</a></li></ul>';
}

$childIndex = 'about';
include('../header.php');

if (empty($query)) {
  header('Location: '.'?me'.$langPostfix);
  exit();
} else {
  $target = 'pages/'.$query.$filePostfix.'.php';
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