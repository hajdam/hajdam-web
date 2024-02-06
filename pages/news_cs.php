<div id="content">
<h1>Novinky</h1>
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
$count_file = fopen('pages/news/count.txt', 'r');
$count = getline($count_file);
fclose($count_file);

$pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;
if ($pos < 0) $pos = 0;
if ($pos * $perpage > $count) $pos = intdiv($count, $perpage); 	

if (isset($_GET['post'])) {
	$post = (int) $_GET['post'];

    $file = fopen('pages/news/'.$post.'.txt', 'r');
    $time = getline($file);
    $title = getline($file);
    $shorttext = getline($file);
    $content = '';
    while ($file !== false && !feof($file)) {
  	  if ($content != '') {
        $content .= "\n";
      }
      $content .= getline($file);
    }
    echo '<h2>'.$title."</h2>\n";
    echo '<p>Článek vložen '.date('d. m. Y H:m:s', $time).'<br/><br/>'.$shorttext.'</p>';
    echo '<p>'.$content."\n</p>";

	if ($post > 1) {
	  echo '<a href="?p=news&post='.($post-1).$langPostfix.'">&lt;&lt;&nbsp;Předchozí článek</a>&nbsp;&nbsp;';
	}
	if ($post < $count) {
	  echo '<a href="?p=news&post='.($post+1).$langPostfix.'">Následující článek&nbsp;&gt;&gt;</a>';
    }
} else if ($count == 0) {
	echo '<p>Zatím žádné články.</p>';
} else {
	echo '<ul>';
	$pagepos = $pos * $perpage;
	
	$fst = $pagepos + $perpage;
	if ($fst > $count) $fst = $count;
	for ($i = $fst; $i > $pagepos; $i--) {
      $file = fopen('pages/news/'.$i.'.txt', 'r');
      $time = getline($file);
      $title = getline($file);
      $shorttext = getline($file);
      $post = '';
      while ($file !== false && !feof($file)) {
      	  if ($post != '') {
      	  	  $post .= "\n";
      	  }
                        
      	  $post .= getline($file);
      }
      fclose($file);
      
      echo '<li>';
      echo '<p><strong><a href="?p=news&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>Článek vložen '.date('d. m. Y H:m:s', $time).'<br/>'.$shorttext.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Zobrazuje se ".($pagepos + 1)." až ".$fst." z ".$count." článků</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="news&pos='.($pos-1).$langPostfix.'">&lt;&lt;&nbsp;Předchozí stránka</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?p=news&pos='.($pos+1).$langPostfix.'">Následující stránka&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>
</div>
</body>
</html>