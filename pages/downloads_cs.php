<div id="content">
<div id="dirlisting">
<?php
$rootpath = 'download';
$path = @$_GET['path'];
if (!isset($path)) {
	$path = '';
} else {
  $path = str_replace('..','',urldecode($path));
  $i = 0;
  while (@$path[$i] == '/') $i++;
  if ($i > 0) $path = substr($path, $i);
  if ($path != '') {
  	  if ($path[strlen($path) -1] != '/') $path .= '/';
  }
}

if ($path != '') {
  $basename = basename($path);
  $parentpath = dirname($path);
  echo '<h1><img src="images/tree/folder-32x32.gif" alt="[dir]"/>&nbsp;Složka: '.($parentpath == '.' ? '' : $parentpath.'/').$basename.'</h1>'."\n";	
  echo '<img src="images/tree/up.gif" alt="[up]"/>&nbsp;<a href="?downloads'.$langPostfix.(($parentpath == '.') ? '' : '&path='.$parentpath).'">.. (o úroveň výše)</a><br/><br/>'."\n";
} else {
  echo '<h1>Ke stažení</h1>'."\n";	
}

$hasdirs = false;
$handle = opendir($rootpath.'/'.$path);
while (($item = readdir($handle))!==false) {
  if ($item[0] != '.') {
  	$itempath = $path.$item;
    if (is_dir($rootpath.'/'.$itempath)) {
      echo '<img src="images/tree/folder.gif" alt="[dir]"/>&nbsp;<a href="?downloads'.$langPostfix.'&path='.$itempath.'">'.$item.'</a><br/>'."\n";
      $hasdirs = true;
    }
  }
}
closedir($handle);

$hasfiles = false;
if ($path != '') {
  $handle = opendir($rootpath.'/'.$path);
  while (($item = readdir($handle))!==false) {
    if ($item[0] != '.') {
  	  $itempath = $path.$item;
      if (!is_dir($rootpath.'/'.$itempath)) {
      	if (!$hasfiles) {
      		$hasfiles = true;
      		if ($hasdirs) echo '<br/>'."\n";
      	}

        echo '<img src="images/filetypes/null.gif" alt="[dir]"/>&nbsp;<a href="download/?'.$itempath.'">'.$item.'</a><br/>'."\n";
      }
    }
  }
  closedir($handle);
}
?>

</div></div>
</body>
</html>