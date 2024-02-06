<div id="content"><?php
function getline($fl) {
  $fp = @fgets($fl, 65536);
  $fp = substr($fp, 0, strlen($fp) - 1);
  return $fp;
}
?>
<h1>Miroslav Hajda - Personal Homepage</h1>
<img src="about/images/photos/fotka7.jpg" alt="[photo]" style="float: right;" />
<?php if (time() > filectime('author-alive.dat') + (60 * 60 * 24 * 90)) {
  echo '<p><h3 style="color: red; background-color: yellow;">This website is abandoned - author of this site is either dead or very long not updating</h3></p>';
} ?>
<p>Welcome stray wanderer!</p>

<h2>Latest news:</h2>

<?php include "pages/inc/news_inc.php";

$count_file = fopen('pages/news/count.txt', 'r');
$blog_count = getline($count_file);
fclose($count_file);

if ($blog_count > 0) {
  showNews($blog_count);
} else {
  echo '</p>There is no post yet.</p>';
} ?>

<p>Show <a href="?p=news<?php echo $langPostfix; ?>">all news</a>.</p>

<h2>Latest blog post:</h2>

<?php include "pages/inc/blog_inc.php";

$count_file = fopen('pages/blog/count.txt', 'r');
$blog_count = getline($count_file);
fclose($count_file);

if ($blog_count > 0) {
  showBlog($blog_count);
} else {
  echo '</p>There are no blog posts yet.</p>';
} ?>

<p>See <a href="?p=blog<?php echo $langPostfix; ?>">all blog posts</a>.</p>

<h2>Latest visitor's comment:</h2>

<?php include "pages/inc/comment_inc.php";

$count_file = fopen('pages/comments/count.txt', 'r');
$comment_count = getline($count_file);
fclose($count_file);

if ($comment_count > 0) {
  showComment($comment_count);
} else {
  echo '</p>There are user comments yet.</p>';
} ?>

<p>See <a href="?p=comments<?php echo $langPostfix; ?>">all comments</a> or add <a href="?p=add-comment<?php echo $langPostfix; ?>">new comment</a>.</p>

<p><small>&copy; Miroslav Hajda 2021 | Version 4.2 | Hosted on <a class="urlextern" href="https://www.zdechov.net">zdechov.net</a> | <a class="urlextern" href="https://github.com/hajdam/hajdam-web">Source</a></small></p>
</div>
</body>
</html>