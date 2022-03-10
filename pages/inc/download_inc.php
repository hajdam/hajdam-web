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
    return hash_file('CRC32B', $filename , FALSE);
}

function genFileHead($fname, $crc, $size) {
    return genCFileHead($fname, $crc, $size, $size, 0);
}

function genCFileHead($fname, $crc, $size, $extSize, $compression) {
    $head = "PK".chr(3).chr(4).chr(10).chr(0).chr(0).chr(0).substr(binStr($compression), 0, 2).binStr(dosDate(time())).binStr($crc);
    $head .= binStr($size).binStr($extSize).substr(binStr(strlen($fname)), 0, 2);
    $head .= chr(0).chr(0).$fname;
    return $head; // 30
}

function genDirHead($dname) {
    $head = "PK".chr(3).chr(4).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr(0);
    $head .= binStr(0).binStr(0).substr(binStr(strlen($dname)), 0, 2);
    $head .= chr(0).chr(0).$dname;
    return $head; // 30
}

function genCdFileHead($fname, $crc, $size, $offset) {
    return genCdCFileHead($fname, $crc, $size, $offset, $size, 0);
}

function genCdCFileHead($fname, $crc, $size, $offset, $extSize, $compression) {
    $head = "PK".chr(1).chr(2).chr(0x14).chr(3).chr(10).chr(0).chr(0).chr(0).substr(binStr($compression), 0, 2).binStr(dosDate(time())).binStr($crc);
    $head .= binStr($size).binStr($extSize).substr(binStr(strlen($fname)), 0, 2);
    $head .= chr(0).chr(0).chr(0).chr(0);
    $head .= chr(0).chr(0).chr(0).chr(0).binStr(0x81b60000).binStr($offset).$fname;
    return $head; // 46
}

function genCdDirHead($dname, $offset) {
    $head = "PK".chr(1).chr(2).chr(0x14).chr(3).chr(10).chr(0).binStr(0).binStr(dosDate(time())).binStr(0);
    $head .= binStr(0).binStr(0).substr(binStr(strlen($dname)), 0, 2);
    $head .= chr(0).chr(0).chr(0).chr(0);
    $head .= chr(0).chr(0).chr(0).chr(0).binStr(0x41ff0010).binStr($offset).$dname;
    return $head; // 46
}

function genCdEnd($cdOffset, $cdCount, $cdSize) {
    $head = "PK".chr(5).chr(6).chr(0).chr(0).chr(0).chr(0).substr(binStr($cdCount), 0, 2).substr(binStr($cdCount), 0, 2).binStr($cdSize).binStr($cdOffset);
    $head .= chr(0).chr(0);
    return $head; // 22
}

function genDirFiles($path, $sub, $files, $dirs, $offset, &$cdOffsets) {
    $size = 0;

    // Process files
    $fl = fopen($path."/.download/.files","r");
    do {
        $fname = getLine($fl);
        if ($fname != '' && (!isset($files) || in_array($fname, $files))) {
            $fsize = getLine($fl);
            $fcrc = hexdec(strtoupper(getLine($fl)));
            
            $cdOffsets[$sub.$fname] = $offset + $size;

            $zipFile = $path.'/.download/'.$fname.'.zip';
            if (is_file($zipFile)) {
              $ff = fopen($zipFile, 'r');
              fseek($ff, 8);
              $compression = strBin(fread($ff, 2));
              fseek($ff, 22);
              $extSize = strBin(fread($ff, 4));
              $fnameLength = strBin(fread($ff, 2));
              $extraLength = strBin(fread($ff, 2));
              fread($ff, $fnameLength);
              fread($ff, $extraLength);
              
              $head = genCFileHead($sub.$fname, $fcrc, $fsize, $extSize, $compression);
              $size += strlen($head);
              echo $head;
              flush();
              ob_flush();

              while ($fsize > 0) {
                  $buffer = fread($ff, $fsize > 1024 ? 1024 : $fsize);
                  $bufferSize = strlen($buffer);
                  $size += $bufferSize;
                  $fsize -= $bufferSize;
                  echo $buffer;
              }
              
              fclose($ff);
            } else {
              $head = genFileHead($sub.$fname, $fcrc, $fsize);
              $size += strlen($head);
              echo $head;
              flush();
              ob_flush();

              $size += readfile($path.'/'.$fname);
            }
            flush();
            ob_flush();
        }
    } while ($fname != '');
    fclose($fl);

    // Process subdirectories
    $handle = opendir($path);
    if ($handle != null) {
		while (($item = readdir($handle))!==false) {
		  if ($item[0] != '.' && (!isset($dirs) || in_array($item, $dirs))) {
			  $itempath = $path.'/'.$item;
			  if (is_dir($itempath) && is_dir($itempath.'/.download')) {
				  $cdOffsets[$sub.$item.'/'] = $offset + $size;
				  $head = genDirHead($sub.$item.'/');
				  $size += strlen($head);
				  echo $head;
				  
				  $size += genDirFiles($path.'/'.$item, $sub.$item.'/', null, null, $offset + $size, $cdOffsets);
			  }
		  }
		}
		closedir($handle);
	}
    return $size;
}

function genDirCd($path, $sub, $files, $dirs, &$cdCount, &$cdOffsets) {
    $size = 0;

    // Process files
    $fl = fopen($path."/.download/.files","r");
    do {
        $fname = getLine($fl);
        if ($fname != '' && (!isset($files) || in_array($fname, $files))) {
            $fsize = getLine($fl);
            $fcrc = hexdec(getLine($fl));
            
            $zipFile = $path.'/.download/'.$fname.'.zip';
            if (is_file($zipFile)) {
              $ff = fopen($zipFile, 'r');
              fseek($ff, 8);
              $compression = strBin(fread($ff, 2));
              fseek($ff, 22);
              $extSize = strBin(fread($ff, 4));
              fclose($ff);

              $head = genCdCFileHead($sub.$fname, $fcrc, $fsize, $cdOffsets[$sub.$fname], $extSize, $compression);
              $size += strlen($head);
              echo $head;
            } else {
              $head = genCdFileHead($sub.$fname, $fcrc, $fsize, $cdOffsets[$sub.$fname]);
              $size += strlen($head);
              echo $head;
            }
            $cdCount++;
        }
    } while ($fname != '');
    fclose($fl);

    // Process subdirectories
    $handle = opendir($path);
    while (($item = readdir($handle))!==false) {
      if ($item[0] != '.' && (!isset($dirs) || in_array($item, $dirs))) {
          $itempath = $path.'/'.$item;
          if (is_dir($itempath) && is_dir($itempath.'/.download')) {
              $head = genCdDirHead($sub.$item.'/', $cdOffsets[$sub.$item.'/']);
              $size += strlen($head);
              echo $head;
              $cdCount++;
              
              $size += genDirCd($path.'/'.$item, $sub.$item.'/', null, null, $cdCount, $cdOffsets);
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

    // Compute size before sending data
    $path = '../download'.($path == '' ? '' : '/'.$path);
    // TODO
    
    $cdOffsets = array();
    $offset = 0;
    $offset += genDirFiles($path, '', $files, $dirs, $offset, $cdOffsets);

    $cdOffset = $offset;
    $cdCount = 0;
    $offset += genDirCd($path, '', $files, $dirs, $cdCount, $cdOffsets);
    $cdSize = $offset - $cdOffset;

    echo genCdEnd($cdOffset, $cdCount, $cdSize);
  echo $files[0];
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

          $itemSubLength = strlen($item) + 1;
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

                $zipFile = $path.'/.download/'.$item.'.zip';
                if (is_file($zipFile)) {
                  $ff = fopen($zipFile, 'r');
                  fseek($ff, 14);
                  $crc = strBin(fread($ff, 4));
                  $filesize = strBin(fread($ff, 4));
                  fwrite($fl, $filesize."\n");
                  fwrite($fl, dechex($crc)."\n");
                  fclose($ff);
                } else {
                  $filesize = filesize($itempath);
                  fwrite($fl, $filesize."\n");
                  fwrite($fl, crc32_file($itempath)."\n");
                }
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