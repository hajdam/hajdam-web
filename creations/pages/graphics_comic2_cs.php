<div id="content">
<h1>Grafické výtvory - Komix: Fighter</h1>

<?php
  $count = 5;
  $item = (int) $_GET['item'];
  if (!$item) $item = 1;
  if ($item < 10) $item = '0'.$item;
  echo '<p style="text-align: center">';
  if ($item > 1) echo '<a href="?graphics_comic2&amp;item='.($item-1).$langPostfix.'">&lt;&nbsp;Předchozí</a>&nbsp;';
  if ($item < $count) echo '<a href="?graphics_comic2&amp;item='.($item+1).$langPostfix.'">Následující&nbsp;&gt;</a>';
  echo '</p>';
  echo '<p><img src="../images/comics/fighter/'.$item.'.jpg" alt="['.$item.']" class="center"/></p>';
?>

</div>
</body>
</html>