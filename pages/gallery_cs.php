<div id="content">
<h1>Galerie</h1>

<?php
$rootpath = 'download/gallery';
$handle = opendir($rootpath);
while (($item = readdir($handle))!==false) {
  if ($item[0] != '.') {
  	$itempath = $rootpath.'/'.$item; 
    if (is_dir($itempath)) {
      $dirtitle = $item;
      if (is_file($itempath.'/.preview/dir.txt')) {
      	  //echo '<p>Has dir</p>';
      }
      echo '<h2>'.$dirtitle.'</h2>'."\n";
      $dirhandle = opendir($rootpath.'/'.$item);
      while (($subitem = readdir($dirhandle))!==false) {
        $subitempath = $itempath.'/'.$subitem;
        if (is_file($subitempath)) {
          echo '<a href="'.$subitempath.'"><img src="'.$itempath.'/.preview/'.$subitem.'" alt="['.$subitem.']" /></a>&nbsp;';
        }
      }
      closedir($dirhandle);
    }
  }
}
closedir($handle);
?>

<p>TODO</p>

</div>
</body>
</html>