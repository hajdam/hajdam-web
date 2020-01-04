<?php
// Store referer
$referer = $_SERVER['HTTP_REFERER'];

$remoteAddr = $_SERVER['REMOTE_ADDR'];
$myIPs = array();
if (!in_array($remoteAddr, $myIPs)) {
  file_put_contents("/var/www/html/bined/referer.html", date("Y-m-d H:i:s").": ".$remoteAddr." ".$referer."<br/>\n", FILE_APPEND);
}
?>