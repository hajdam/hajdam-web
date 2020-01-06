<?php include('header.php');
$lang = (isset($_GET['link']) && $_GET['link'] == 'cs') ? 'cs' : '';
$langPostfix = ($lang == 'cs') ? '&amp;lang=cs' : '';
$query = getenv('QUERY_STRING');
if (empty($query)) {
  $include = 'pages/news'.$lang.'.php';
} else {
  $paramPos = strpos($query, '&');
  if ($paramPos !== false) $query = substr($query, 0, $paramPos);
  $target = 'pages/'.$query.$lang.'.php';
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
    $include = 'pages/not-found'.$lang.'.php';
  }
}

include $include;

include 'refer.php'; ?>