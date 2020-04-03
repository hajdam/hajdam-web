<?php

function showComment($i) {
  global $lang, $langPostfix;

  if ($lang == 'cs') {
    $filepath = 'pages/blog/'.$i.'.txt';
  } else {
    $filepath = 'pages/blog/'.$i.'_en.txt';
    if (!is_file($filepath)) $filepath = 'pages/blog/'.$i.'.txt';
  }
  $file = fopen($filepath, 'r');
  $time = getline($file);
  $title = getline($file);
  $shorttext = getline($file);
  fclose($file);

  if ($lang == 'cs') {
    echo '<p><strong><a href="?blog&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>Článek vložen '.date('d. m. Y H:m:s', $time).'<br/>'.$shorttext.'</p>';
  } else {
    echo '<p><strong><a href="?blog&post='.$i.$langPostfix.'">'.$title.'</a></strong><br/>Posted on '.date('l jS \of F Y h:i:s A', $time).'<br/>'.$shorttext.'</p>';
  }
}
?>