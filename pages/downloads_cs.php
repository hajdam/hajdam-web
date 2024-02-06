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
  echo '<img src="images/tree/up.gif" alt="[up]"/>&nbsp;<a href="?p=downloads'.$langPostfix.(($parentpath == '.') ? '' : '&amp;path='.$parentpath).'">.. (o úroveň výše)</a><br/><br/>'."\n";
} else {
  echo '<h1>Ke stažení</h1>'."\n";	
}

echo '<form method="post" name="download" action="download/">'."\n";
echo '<input type="hidden" name="path" value="'.$path.'"/>'."\n";

$hasdirs = false;
$dirIndex = 0;
$handle = opendir($rootpath.'/'.$path);
if ($handle !== false) {
  while (($item = readdir($handle))!==false) {
    if ($item[0] != '.') {
  	  $itempath = $path.'/'.$item;
      if (is_dir($rootpath.'/'.$itempath)) {
        echo '<input type="checkbox" name="dir_'.$dirIndex.'" value="'.htmlentities($item).'" />';
        echo '<img src="images/tree/folder.gif" alt="[dir]"/>&nbsp;<a href="?p=downloads'.$langPostfix.'&amp;path='.$itempath.'">'.$item.'</a><br/>'."\n";
        $dirIndex++;
        $hasdirs = true;
      }
    }
  }
  closedir($handle);
} else {
	echo '<p>Error: invalid path</p>';
}

$hasfiles = false;
$fileIndex = 0;
if ($path != '') {
  $handle = opendir($rootpath.'/'.$path);
  if ($handle !== false) {
    while (($item = readdir($handle))!==false) {
      if ($item[0] != '.') {
  	    $itempath = $path.'/'.$item;
        if (!is_dir($rootpath.'/'.$itempath)) {
          if (!$hasfiles) {
        	$hasfiles = true;
            if ($hasdirs) echo '<br/>'."\n";
      	  }

      	  $filetype = 'null.gif';
      	  $filetypealt = 'file';
      	
      	  $ext = substr($item, strlen($item)-4);
      	  switch ($ext) {
      	     case '.mzf':
      	     case '.zip':
      	     case '.ani':
      	     case '.ico':
      	     case '.rar':
      	     case '.txt':
      	     case '.mod':
               $filetype = substr($ext,1).'.gif';
      	       $filetypealt = substr($ext,1);
      	       break;
      	     case '.png':
      	     case '.gif':
      	     case '.jpg':
               $filetype = 'image.png';
      	       $filetypealt = 'image';
      	       break;
      	         
      	  }

          echo '<input type="checkbox" name="file_'.$fileIndex.'" value="'.htmlentities($item).'" />';
          echo '<img src="images/filetypes/'.$filetype.'" alt="['.$filetypealt.']"/>&nbsp;<a href="download/?f='.$itempath.'">'.$item.'</a><br/>'."\n";
          $fileIndex++;
        }
      }
    }
    closedir($handle);
  } else {
	echo '<p>Error: invalid path</p>';
  }   
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