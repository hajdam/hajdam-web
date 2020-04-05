<?php
// Store referer
$referer = @$_SERVER['HTTP_REFERER'];

$remoteAddr = @$_SERVER['REMOTE_ADDR'];
$myIPs = array();
if (!in_array($remoteAddr, $myIPs)) {
  $childPrefix = '';
  if (isset($childIndex)) $childPrefix = $childIndex.': ';

  file_put_contents("/var/www/html/hajdam/referer.html", date("Y-m-d H:i:s").": ".$remoteAddr." ".$childPrefix.@$query." ".$referer."<br/>\n", FILE_APPEND);
}
?>