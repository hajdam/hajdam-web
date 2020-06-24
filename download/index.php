<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include '../pages/inc/download_inc.php';
  
  $path = $_POST['path'];
  $dirs = array();
  $files = array();

  foreach ($_POST as $key => $value) {
    if (strncmp($key, 'file_', 5) == 0) {
//      echo "$key=$value<br />";
      array_push($files, $value);
    }
  }

  foreach ($_POST as $key => $value) {
    if (strncmp($key, 'dir_', 4) == 0) {
//      echo "$key=$value<br />";
      array_push($dirs, $value);
    }
  }
  
  generateZip($path, $files, $dirs);
  exit();   
}

// Store referer
$referer = @$_SERVER['HTTP_REFERER'];

$component = "";

function startsWith($text, $match) {
    return substr($text, 0, strlen($match)) === $match;
}

$query = str_replace('..','',@$_SERVER['QUERY_STRING']);
$query = str_replace('%20',' ',$query);
$component = ':' . $query;

if (empty($query)) {
  $query = '../?downloads';
} else {
  file_put_contents("/var/www/html/hajdam/download/referer.html", date("Y-m-d H:i:s").' '.$_SERVER['REMOTE_ADDR']." ".$component." : ".$referer."<br/>\n", FILE_APPEND);
}
header('Location: ' . $query);
exit();
?>
