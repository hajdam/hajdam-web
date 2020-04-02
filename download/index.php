<?php
// Store referer
$referer = $_SERVER['HTTP_REFERER'];
$component = "";

function startsWith($text, $match) {
    return substr($text, 0, strlen($match)) === $match;
}

$query = str_replace('..','',$_SERVER['QUERY_STRING']);
$query = str_replace('%20',' ',$query);
$component = ':' . $query;

if (empty($query)) {
  $query = '../?downloads';
} else {
  file_put_contents("/var/www/html/hajdam/download/referer.html", date("Y-m-d H:i:s").$component.": ".$_SERVER['REMOTE_ADDR']." ".$referer."<br/>\n", FILE_APPEND);
}
header('Location: ' . $query);
exit();
?>
