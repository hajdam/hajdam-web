<div id="content">
<p>Add <a href="?add-comment">new comment</a>.</p>
<p>User comments for this project:</p>
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
    echo '<p>Your comment was added.</p>';
  }
}

if ($count == 0) {
	echo '<p>There are no comments yet.</p>';
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
      while (!feof($file)) {
      	  if ($comment != '') {
      	  	  $comment .= "<br/>";
      	  }
                        
      	  $comment .= getline($file);
      }
      fclose($file);
      
      echo '<li>';
      echo '<p>Comment from: <strong>'.$author.'</strong> on '.date('l jS \of F Y h:i:s A', $time).'</p>';
      echo '<p>'.$comment.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Showing ".($pagepos + 1)." to ".$fst." of ".$count." comments</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="?comments&pos='.($pos-1).'">&lt;&lt;&nbsp;Previous page</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?comments&pos='.($pos+1).'">Next page&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>
</div>
</body>
</html>