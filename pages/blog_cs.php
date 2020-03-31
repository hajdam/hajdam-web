<div id="content">
<h1>Blog</h1>
<?php

function getline($fl) {
  $fp = @fgets($fl, 65536);
  $fp = substr($fp, 0, strlen($fp) - 1);
  return $fp;
}

function putline($fl, $data) {
  fwrite($fl, $data.chr(10), strlen($data) + 1);
}

$perpage = 10;
$count_file = fopen('pages/blog/count.txt', 'r');
$count = getline($count_file);
fclose($count_file);

$pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;
if ($pos < 0) $pos = 0;
if ($pos * $perpage > $count) $pos = intdiv($count, $perpage); 	

if ($count == 0) {
	echo '<p>Zatím žádné články.</p>';
} else {
	echo '<ul>';
	$pagepos = $pos * $perpage;
	
	$fst = $pagepos + $perpage;
	if ($fst > $count) $fst = $count;
	for ($i = $fst; $i > $pagepos; $i--) {
      $file = fopen('pages/blog/'.$i.'.txt', 'r');
      $time = getline($file);
      $title = getline($file);
      $shorttext = getline($file);
      $post = '';
      while (is_file($file) && !feof($file)) {
      	  if ($post != '') {
      	  	  $post .= "\n";
      	  }
                        
      	  $post .= getline($file);
      }
      fclose($file);
      
      echo '<li>';
      echo '<p>Článek: <strong>'.$title.'</strong> vložen '.date('d. m. Y H:m:s', $time).'</p>';
      echo '<p>'.$shorttext.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Zobrazuje se ".($pagepos + 1)." až ".$fst." z ".$count." článků</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="blog&pos='.($pos-1).'">&lt;&lt;&nbsp;Předchozí stránka</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?blog&pos='.($pos+1).'">Následující stránka&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>
</div>
</body>
</html>