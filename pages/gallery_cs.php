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
      $dirhandle = opendir($itempath);
      while (($subitem = readdir($dirhandle))!==false) {
        $subitempath = $itempath.'/'.$subitem;
        if (is_file($subitempath)) {
          echo '<a href="'.$subitempath.'"><img src="'.$itempath.'/.preview/'.$subitem.'" alt="['.$subitem.']" /></a>&nbsp;';
        } else if (is_dir($subitempath) && ($subitem[0] != '.')) {
          echo '<h2>'.$dirtitle.' - '.$subitem.'</h2>'."\n";
          $subdirhandle = opendir($itempath.'/'.$subitem);
          while (($subitem2 = readdir($subdirhandle))!==false) {
            $subitempath2 = $itempath.'/'.$subitem.'/'.$subitem2;
            if (is_file($subitempath2)) {
              echo '<a href="'.$subitempath2.'"><img src="'.$itempath.'/'.$subitem.'/.preview/'.$subitem2.'" alt="['.$subitem2.']" /></a>&nbsp;';
            }
          }
          closedir($subdirhandle);
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