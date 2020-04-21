<?php

function getOne($fl) {
  $fp = fgets($fl, 1000);
  $fp = substr($fp,0, strlen($fp)-2);
  return $fp;
}

function binStr($src) {
  $fb1 = "";
  $fb2 = $src;
  for($fb=0; $fb<=3; $fb++) {
    $fn = $fb2 % 256;
    $fb1 .= chr($fn);
    $fb2 = $fb2 / 256;
  }
  return $fb1;
}

function strBin($src) {
  $fb1 = 0;
  $fb2 = 1;
  for($i=0; $i<=3; $i++) {
    $fb1 = $fb1 + ord(substr($src, $i, 1)) * $fb2;
    $fb2 = $fb2 * 256;
  }
  return $fb1;
}

function skipOne($src) {
  return substr($src,1,strlen($src));
}

function dosDate($uts) {
  $today=getdate($uts);
  return ($today[seconds]/2)%31+$today[minutes]*32+$today[hours]*2048+65536*
  ($today[mday]+$today[mon]*32+($today[year]-1980)*512);
}


?>