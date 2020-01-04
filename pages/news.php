<div id="content">
<?php if (time() > filectime('author-alive.dat') + (60 * 60 * 24 * 90)) {
  echo '<p><h3 style="color: red; background-color: yellow;">This website is abandoned - author of this site is either dead or very long not updating</h3></p>';
} ?>
<p>TODO</p>
</div>
</body>
</html>