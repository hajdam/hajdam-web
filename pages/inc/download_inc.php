<?php

function getLine($fl) {
  $fp = fgets($fl, 1000);
  $fp = substr($fp, 0, strlen($fp) - 1);
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
  $today = getdate($uts);
  return ($today['seconds'] / 2) % 31 +
      $today['minutes'] * 32 +
      $today['hours'] * 2048 + 
      65536 * ($today['mday'] + $today['mon'] * 32 + ($today['year'] - 1980) * 512);
}

function crc32_file($filename)
{
    return hash_file('CRC32', $filename , FALSE);
}

function genFileHead($fname, $crc, $size) {
    $head = "PK".chr(3).chr(4).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr($crc);
    $head .= binStr($size).binStr($size).substr(binStr(strlen($fname)), 0, 2);
    $head .= chr(0).chr(0).$fname;
    return $head;
}

function genDirHead($dname) {
    $head = "PK".chr(3).chr(4).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr(0);
    $head .= binStr(0).binStr(0).substr(binStr(strlen($dname)), 0, 2);
    $head .= chr(0).chr(0).$dname;
    return $head;
}

function genCdFileHead($fname, $crc, $size) {
    $head = "PK".chr(2).chr(1).chr(0x1e).chr(3).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr($crc);
    $head .= binStr($size).binStr($size).substr(binStr(strlen($fname)), 0, 2);
    $head .= chr(0).chr(0).chr(0).chr(0);
    $head .= chr(0).chr(0).chr(0).chr(0).binStr(0).binStr(0).$fname;
    return $head;
}

function genCdDirHead($dname) {
    $head = "PK".chr(2).chr(1).chr(0x1e).chr(3).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr(0);
    $head .= binStr(0).binStr(0).substr(binStr(strlen($dname)), 0, 2);
    $head .= chr(0).chr(0).chr(0).chr(0);
    $head .= chr(0).chr(0).chr(0).chr(0).binStr(0).binStr(0).$dname;
    return $head;
}

function genCdEnd($cdOffset, $cdCount, $cdSize) {
    $head = "PK".chr(5).chr(6).chr(0).chr(0).chr(0).chr(0).substr(binStr($cdCount), 0, 2).substr(binStr($cdCount), 0, 2).binStr($cdSize).binStr($cdOffset);
    $head .= chr(0).chr(0);
    return $head;
}

function genDirFiles($path, $sub) {
    $size = 0;

    // Process files
    $fl = fopen($path."/.download/.files","r");
    do {
        $fname = getLine($fl);
        if ($fname != '') {
            $fsize = getLine($fl);
            $fcrc = hexdec(strtoupper(getLine($fl)));
            
            $head = genFileHead($sub.$fname, $fcrc, $fsize);
            $size += strlen($head);
            echo $head;
            $size += readfile($path.'/'.$fname);
        }
    } while ($fname != '');
    fclose($fl);

    // Process subdirectories
    $handle = opendir($path);
    while (($item = readdir($handle))!==false) {
      if ($item[0] != '.') {
          $itempath = $path.'/'.$item;
          if (is_dir($itempath) && is_dir($itempath.'/.download')) {
              $head = genDirHead($itempath);
              $size += strlen($head);
              echo $head;
              
              $size += genDirFiles($path.'/'.$item, $sub.'/'.$item);
          }
      }
    }
    closedir($handle);
    return $size;
}

function genDirCd($path, $sub, &$cdCount) {
    $size = 0;

    // Process files
    $fl = fopen($path."/.download/.files","r");
    do {
        $fname = getLine($fl);
        if ($fname != '') {
            $fsize = getLine($fl);
            $fcrc = hexdec(getLine($fl));
            
            $head = genCdFileHead($sub.$fname, $fcrc, $fsize);
            $size += strlen($head);
            echo $head;
        }
    } while ($fname != '');
    fclose($fl);

    // Process subdirectories
    $handle = opendir($path);
    while (($item = readdir($handle))!==false) {
      if ($item[0] != '.') {
          $itempath = $path.'/'.$item;
          if (is_dir($itempath) && is_dir($itempath.'/.download')) {
              $head = genCdDirHead($itempath);
              $size += strlen($head);
              echo $head;
              
              $size += genDirCd($path.'/'.$item, $sub.'/'.$item);
          }
      }
    }
    closedir($handle);
    return $size;
    
    return 0;
}

function generateZip($path, $files, $dirs) {
    header("Content-type: application/x-zip-compressed");
    header("Content-disposition: filename=download.zip");

    // Precompute size
    $path = '../download'.($path == '' ? '' : '/'.$path);
    // TODO
    
    $offset = 0;
    $offset += genDirFiles($path, '');

    $cdOffset = $offset;
    $cdCount = 0;
    $offset += genDirCd($path, '', $cdCount);
    $cdSize = $offset - $cdOffset;

    echo genCdEnd($cdOffset, $cdCount, $cdSize);
}

function precompute($dir) {
    precomputePath($dir, '');
}

function precomputePath($dir, $sub) {
    $path = $dir.($sub == '' ? '' : '/'.$sub);
    echo $path."<br/>";
    $cpath = $path."/.download";
    if (!is_dir($cpath)) {
        mkdir($cpath, 0777);
    }
    
    $subFSum = 0;
    $fNLength = 0;
    $fSize = 0;
    $handle = opendir($path);
    while (($item = readdir($handle))!==false) {
      if ($item[0] != '.') {
        $itempath = $path.'/'.$item;
        if (is_dir($itempath)) {
          precomputePath($dir, ($sub == '' ? $item : $sub.'/'.$item));

          $itemSubLength = strlen($item + 1);
          $fNLength += $itemSubLength;
          $fl = fopen($itempath."/.download/.dir","r");
          $subFCount = getLine($fl);
          $subFNLength = getLine($fl);
          $subFSize = getLine($fl);
          if ($subFCount > 0) {
              $subFSum += $subFCount;
              $fNLength += $subFNLength * $itemSubLength;
              $fSize += $subFSize;
          }
          fclose($fl);
        }
      }
    }
    closedir($handle);

    $fl = fopen($cpath."/.files","w+");

    $fCount = 0;
    if ($sub != '') {
        $handle = opendir($path);
        while (($item = readdir($handle))!==false) {
            if ($item[0] != '.') {
              $itempath = $path.'/'.$item;
              if (is_file($itempath)) {
                fwrite($fl, $item."\n");
                $filesize = filesize($itempath);
                fwrite($fl, $filesize."\n");
                fwrite($fl, crc32_file($itempath)."\n");
                $fCount++;
                $fNLength += strlen($item);
                $fSize += $filesize;
              }
            }
        }
        closedir($handle);
    }

    fclose($fl);

    $fl = fopen($cpath."/.dir","w+");
    fwrite($fl, ($fCount + $subFSum)."\n");
    fwrite($fl, $fNLength."\n");
    fwrite($fl, $fSize."\n");
    fclose($fl);
}
?>