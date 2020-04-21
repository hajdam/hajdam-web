<?php
global $lang, $requestedLang;
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
    if ($lang == '') {
    	$lang = 'en';
    }
}
$filePostfix = ($lang == 'cs') ? '_cs' : '';
$langPostfix = ($requestedLang != '') ? '&amp;lang='.$requestedLang : '';

global $prefix;
$prefix = '';
$query = getenv('QUERY_STRING');
if (empty($query)) {
  include('header.php');
  $include = 'pages/welcome'.$filePostfix.'.php';
} else {
  // Previous version redirections
  if (strncmp($query, "download/", 9) === 0) {
    header('Location: '.'download/?'.substr($query, 9));
    exit();
  }
  
  if ($query == 'lang=cs' || $query == 'lang=en') {
    header('Location: '.'?welcome&'.$query);
    exit();
  }
	
  $paramPos = strpos($query, '&');
  if ($paramPos !== false) $query = substr($query, 0, $paramPos);
  if (strpos($query, '=')) $query = '';
  $target = 'pages/'.$query.$filePostfix.'.php';

  include('header.php');
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
  	http_response_code(404);
    $include = 'pages/not-found'.$filePostfix.'.php';
  }
}

include $include;

include 'refer.php'; ?>