<?php

function showNews($i) {
  global $lang, $langPostfix;

  if ($lang == 'cs') {
    $filepath = 'pages/news/'.$i.'.txt';
  } else {
    $filepath = 'pages/news/'.$i.'_en.txt';
    if (!is_file($filepath)) $filepath = 'pages/news/'.$i.'.txt';
  }
  $file = fopen($filepath, 'r');
  $time = getline($file);
  $title = getline($file);
  $shorttext = getline($file);
  fclose($file);

  if ($lang == 'cs') {
    echo '<p><strong><a href="?news&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>Novinka vložena '.date('d. m. Y H:m:s', $time).'<br/>'.$shorttext.'</p>';
  } else {
    echo '<p><strong><a href="?news&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>News on '.date('l jS \of F Y h:i:s A', $time).'<br/>'.$shorttext.'</p>';
  }
}
?>