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
  return ($today[seconds]/2)%31 +
      $today[minutes]*32 +
      $today[hours]*2048 + 
      65536 * ($today[mday] + $today[mon]*32 + ($today[year]-1980) * 512);
}

function checkzip($fname, $file) {
  $fl=fopen($file,"r");
  if ($fl) {
//    $t=fread($fl,7);
//    if ($t=="Rar!".chr(26).chr(7).chr(0)) {
//      $t=fread($fl,7);
//      $t.=fread($fl, binstrr(substr($t,5,2)));
// CRC control later
//      fclose($fl);
// Create Store Head
      $fl=fopen($file,"r");
      $buffer=fread($fl, filesize($file));
      $crc=crc32($buffer);
      $head="PK".chr(3).chr(4).chr(10).chr(0).binstr(0).binstr(dosdt(time())).binstr($crc);
      $head.=binstr(strlen($buffer)).binstr(strlen($buffer)).substr(binstr(strlen($fname)),0,2);
      $head.=chr(0).chr(0).$fname;
      return $head;
//    } else return false;
  fclose($fl);
  } else return false;
}

?>