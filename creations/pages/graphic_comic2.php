<div id="content">
<h1>Graphical Creations - Comic: Fighter</h1>

<?php
  $count = 5;
  $item = (int) $_GET['item'];
  if (!$item) $item = 1;
  if ($item < 10) $item = '0'.$item;
  echo '<p style="text-align: center">';
  if ($item > 1) echo '<a href="?graphic_comic2&amp;item='.($item-1).$langPostfix.'">&lt;&nbsp;Previous</a>&nbsp;';
  if ($item < $count) echo '<a href="?graphic_comic2&amp;item='.($item+1).$langPostfix.'">Next&nbsp;&gt;</a>';
  echo '</p>';
  echo '<p><img src="../images/comics/fighter/'.$item.'.jpg" alt="['.$item.']" class="center"/></p>';
?>

</div>
</body>
</html>