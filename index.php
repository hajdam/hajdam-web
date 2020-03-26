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

global $prefix;
$prefix = '';
$query = getenv('QUERY_STRING');
if (empty($query)) {
  include('header.php');
  $include = 'pages/news'.$filePostfix.'.php';
} else {
  $paramPos = strpos($query, '&');
  if ($paramPos !== false) $query = substr($query, 0, $paramPos);
  $target = 'pages/'.$query.$filePostfix.'.php';

  include('header.php');
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
    $include = 'pages/not-found'.$filePostfix.'.php';
  }
}

include $include;

include 'refer.php'; ?>