<?php

function showComment($i) {
  global $lang, $langPostfix;

  if ($lang == 'cs') {
    $filepath = 'pages/comments/'.$i.'.txt';
  } else {
    $filepath = 'pages/comments/'.$i.'_en.txt';
    if (!is_file($filepath)) $filepath = 'pages/comments/'.$i.'.txt';
  }
  $file = fopen($filepath, 'r');
  $time = getline($file);
  $author = getline($file);
  $comment = getline($file);
  fclose($file);

  if ($lang == 'cs') {
    echo '<p>Komentář od: <strong>'.$author.'</strong> vložen '.date('d. m. Y H:m:s', $time).'</p>';
    echo '<p>'.$comment.'</p>';
  } else {
    echo '<p>Comment from: <strong>'.$author.'</strong> on '.date('l jS \of F Y h:i:s A', $time).'</p>';
    echo '<p>'.$comment.'</p>';
  }
}
?>