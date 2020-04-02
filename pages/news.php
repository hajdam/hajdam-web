<div id="content">
<h1>News</h1>
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

	$filepath = 'pages/news/'.$post.'_en.txt';
	if (!is_file($filepath)) $filepath = 'pages/news/'.$post.'.txt';
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
    echo '<p>Posted on '.date('l jS \of F Y h:i:s A', $time).'<br/><br/>'.$shorttext.'</p>';
    echo '<p>'.$content."\n</p>";

	if ($post > 1) {
	  echo '<a href="?news&post='.($post-1).$langPostfix.'">&lt;&lt;&nbsp;Previous post</a>&nbsp;&nbsp;';
	}
	if ($post < $count) {
	  echo '<a href="?news&post='.($post+1).$langPostfix.'">Next post&nbsp;&gt;&gt;</a>';
    }
} else if ($count == 0) {
	echo '<p>There are no post yet.</p>';
} else {
	echo '<ul>';
	$pagepos = $pos * $perpage;
	
	$fst = $pagepos + $perpage;
	if ($fst > $count) $fst = $count;
	for ($i = $fst; $i > $pagepos; $i--) {
      $filepath = 'pages/news/'.$i.'_en.txt';
      if (!is_file($filepath)) $filepath = 'pages/news/'.$i.'.txt';
      $file = fopen($filepath, 'r');
      $time = getline($file);
      $title = getline($file);
      $shorttext = getline($file);
      fclose($file);
      
      echo '<li>';
      echo '<p><strong><a href="?news&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>Posted on '.date('l jS \of F Y h:i:s A', $time).'<br/>'.$shorttext.'</p>';
      echo "</li>\n";
	}
    echo '</ul>';
    echo "\n";
    echo "<p>Showing ".($pagepos + 1)." to ".$fst." of ".$count." posts</p>\n";
	if ($count > $perpage) {
	  echo '<p>';
	  if ($pos > 0) {
		echo '<a href="?news&pos='.($pos-1).$langPostfix.'">&lt;&lt;&nbsp;Previous page</a>&nbsp;&nbsp;';
	  }
	  $maxpos = intdiv($count + $perpage - 1, $perpage) - 1; 
	  if ($pos < $maxpos) {
		echo '<a href="?news&pos='.($pos+1).$langPostfix.'">Next page&nbsp;&gt;&gt;</a>';
	  }
	}
} ?>
</div>
</body>
</html>