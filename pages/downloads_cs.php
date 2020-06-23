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
}

if ($path != '') {
  $basename = basename($path);
  $parentpath = dirname($path);
  echo '<h1><img src="images/tree/folder-32x32.gif" alt="[dir]"/>&nbsp;Složka: '.($parentpath == '.' ? '' : $parentpath.'/').$basename.'</h1>'."\n";	
  echo '<img src="images/tree/up.gif" alt="[up]"/>&nbsp;<a href="?downloads'.$langPostfix.(($parentpath == '.') ? '' : '&path='.$parentpath).'">.. (o úroveň výše)</a><br/><br/>'."\n";
} else {
  echo '<h1>Ke stažení</h1>'."\n";	
}

echo '<form method="post" name="download" action="download/">'."\n";
echo '<input type="hidden" name="path" value="'.$path.'"/>'."\n";

$hasdirs = false;
$handle = opendir($rootpath.'/'.$path);
while (($item = readdir($handle))!==false) {
  if ($item[0] != '.') {
  	$itempath = $path.'/'.$item;
    if (is_dir($rootpath.'/'.$itempath)) {
      echo '<input type="checkbox" name="dir_'.$item.'" />';
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
  	  $itempath = $path.'/'.$item;
      if (!is_dir($rootpath.'/'.$itempath)) {
      	if (!$hasfiles) {
      		$hasfiles = true;
      		if ($hasdirs) echo '<br/>'."\n";
      	}

        echo '<input type="checkbox" name="file_'.$item.'" />';
        echo '<img src="images/filetypes/null.gif" alt="[file]"/>&nbsp;<a href="download/?'.$itempath.'">'.$item.'</a><br/>'."\n";
      }
    }
  }
  closedir($handle);
}
?>
<script language="JavaScript"><!--

function CheckAllBoxes() 
{
  for (var i=0;i<document.download.elements.length;i++)
  { var e=document.download.elements[i];
    if (e.type=="checkbox") { e.checked=document.download.checkAll.checked }
  }
}

//--></script>

<p><input type="checkbox" name="checkAll" onClick="CheckAllBoxes()">Zaškrtnout všechny položky</p>
<img alt="Stáhnout ZIP" src="../images/filetypes/zip.gif" width="16" height="16" />&nbsp;<input type="submit" value="Stáhnout vybrané" name="downloadSelected" /><br/>
</form>

</div></div>
</body>
</html>