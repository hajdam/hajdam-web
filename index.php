<?php
$lang = (isset($_GET['lang']) && $_GET['lang'] == 'cs') ? 'cs' : '';
$langPostfix = ($lang == 'cs') ? '&amp;lang=cs' : '';

$query = getenv('QUERY_STRING');
if (empty($query)) {
  include('header.php');
  $include = 'pages/news'.$lang.'.php';
} else {
  $paramPos = strpos($query, '&');
  if ($paramPos !== false) $query = substr($query, 0, $paramPos);
  $target = 'pages/'.$query.$lang.'.php';

  include('header.php');
  if (!(preg_match("/[a-z\/\_\-]+/", $query) === false) && file_exists($target)) {
    $include = $target;
  } else {
    $include = 'pages/not-found'.$lang.'.php';
  }
}

include $include;

include 'refer.php'; ?>