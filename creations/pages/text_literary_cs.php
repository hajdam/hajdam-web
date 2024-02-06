<div id="content">
<h1>Textové výtvory - Literární</h1>
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
$count_file = fopen('pages/literary/count.txt', 'r');
$count = getline($count_file);
fclose($count_file);

$pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;
if ($pos < 0) $pos = 0;
if ($pos * $perpage > $count) $pos = intdiv($count, $perpage); 	

if (isset($_GET['item'])) {
	$item = (int) $_GET['item'];

	$filepath = 'pages/literary/'.$item.'.txt';
	if (!is_file($filepath)) $filepath = 'pages/literary/'.$item.'_en.txt';
    $file = fopen($filepath, 'r');
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
    echo '<p>Vytvořeno '.date('d. m. Y H:m:s', $time).'<br/><br/>'.$shorttext.'</p>';
    echo '<p>'.$content."\n</p>";

	if ($item > 1) {
	  echo '<a href="?p=text/literary&item='.($item-1).$langPostfix.'">&lt;&lt;&nbsp;Předchozí položka</a>&nbsp;&nbsp;';
	}
	if ($item < $count) {
	  echo '<a href="?p=text/literary&item='.($item+1).$langPostfix.'">Následující položka&nbsp;&gt;&gt;</a>';
    }
} else if ($count == 0) {
	echo '<p>Ještě tu nejsou žádné položky.</p>';
} else {
	echo '<ul>';
	$pagepos = $pos * $perpage;
	
	$fst = $pagepos + $perpage;
	if ($fst > $count) $fst = $count;
	for ($i = $fst; $i > $pagepos; $i--) {
	  $notice = '';
      $filepath = 'pages/literary/'.$i.'.txt';
      if (!is_file($filepath)) {
      	$filepath = 'pages/literary/'.$i.'_en.txt';
        $notice = ' (pouze anglicky)';
      }
      $file = fopen($filepath, 'r');
      $time = getline($file);
      $title = getline($file);
      $shorttext = getline($file);
      fclose($file);

      echo '<li>';
      echo '<p><strong><a href="?p=text/literary&item='.$i.$langPostfix.'">'.$title.'</a></strong>'.$notice.'<br/>Vytvořeno '.date('d. m. Y H:m:s', $time).'<br/>'.$shorttext.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Showing ".($pagepos + 1)." to ".$fst." of ".$count." items</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="?p=text/literary&pos='.($pos-1).$langPostfix.'">&lt;&lt;&nbsp;Předchozí stránka</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?p=text/literary&pos='.($pos+1).$langPostfix.'">Následující stránka&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>

</div>
</body>
</html>