<div id="content">
<p>Přidat <a href="?p=add-comment<?php $langPostfix; ?>">nový komentář</a>.</p>
<p>Komentáře návštěvníků této stránky:</p>
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
$count_file = fopen('pages/comments/count.txt', 'r');
$count = getline($count_file);
fclose($count_file);

$pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;
if ($pos < 0) $pos = 0;
if ($pos * $perpage > $count) $pos = intdiv($count, $perpage); 	

if (isset($_POST['comment']) && $_POST['comment'] != '') {
  $antispam = isset($_POST['antispam']) ? $_POST['antispam'] : '';
  $author = isset($_POST['author']) && $_POST['author'] != '' ? $_POST['author'] : '(anonymous)';
  $comment = $_POST['comment'];
  $pos = 0;
  if ($antispam == 'COMMENT') {
    $count++;
    $file = fopen('pages/comments/'.$count.'.txt', 'w');
    $author = htmlspecialchars(strip_tags(substr(preg_replace("/\r|\n/", '', $author), 0, 128)));
    $comment = htmlspecialchars(strip_tags(substr(preg_replace("/\r\n/", "\n", $comment), 0, 512)));
    putline($file, time());
    putline($file, $author);
    putline($file, $comment);
    fwrite($file, $message);
    fclose($file);
  
    $count_file = fopen('pages/comments/count.txt', 'w');
    putline($count_file, $count);
    fclose($count_file);
    echo '<p>Váš komentář byl přidán.</p>';
  }
}

if ($count == 0) {
	echo '<p>Zatím žádné komentáře.</p>';
} else {
	echo '<ul>';
	$pagepos = $pos * $perpage;
	
	$fst = $pagepos + $perpage;
	if ($fst > $count) $fst = $count;
	for ($i = $fst; $i > $pagepos; $i--) {
      $file = fopen('pages/comments/'.$i.'.txt', 'r');
      $time = getline($file);
      $author = getline($file);
      $comment = '';
      while ($file !== false && !feof($file)) {
      	  if ($comment != '') {
      	  	  $comment .= "<br/>";
      	  }
                        
      	  $comment .= getline($file);
      }
      fclose($file);
      
      echo '<li>';
      echo '<p>Komentář od: <strong>'.$author.'</strong> vložen '.date('d. m. Y H:m:s', $time).'</p>';
      echo '<p>'.$comment.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Zobrazuje se ".($pagepos + 1)." až ".$fst." z ".$count." komentářů</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="?p=comments&pos='.($pos-1).$langPostfix.'">&lt;&lt;&nbsp;Předchozí stránka</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?p=comments&pos='.($pos+1).$langPostfix.'">Následující stránka&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>
</div>
</body>
</html>