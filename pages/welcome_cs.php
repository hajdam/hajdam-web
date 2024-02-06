<div id="content"><?php
function getline($fl) {
  $fp = @fgets($fl, 65536);
  $fp = substr($fp, 0, strlen($fp) - 1);
  return $fp;
}
?>
<h1>Miroslav Hajda - Osobní stránky</h1>
<img src="about/images/photos/fotka7.jpg" alt="[fotka]" style="float: right" />
<?php if (time() > filectime('author-alive.dat') + (60 * 60 * 24 * 90)) {
  echo '<p><h3 style="color: red; background-color: yellow;">Tato stránka je opuštěna - autor této stránky je buď mrtev nebo velice dlouho neprovedl žádnou úpravu</h3></p>';
} ?>
<p>Vítej zbloudilý poutníče!</p>

<h2>Poslední novinka:</h2>

<?php include "pages/inc/news_inc.php";

$count_file = fopen('pages/news/count.txt', 'r');
$blog_count = getline($count_file);
fclose($count_file);

if ($blog_count > 0) {
  showNews($blog_count);
} else {
  echo '</p>Zatím nejsou žádné novinky.</p>';
} ?>

<p>Zobrazit <a href="?p=news<?php echo $langPostfix; ?>">všechny novinky</a>.</p>

<h2>Poslední článek na blogu:</h2>

<?php include "pages/inc/blog_inc.php";

$count_file = fopen('pages/blog/count.txt', 'r');
$blog_count = getline($count_file);
fclose($count_file);

if ($blog_count > 0) {
  showBlog($blog_count);
} else {
  echo '</p>Zatím nejsou na blogu žádné články.</p>';
} ?>

<p>Zobrazit <a href="?p=blog<?php echo $langPostfix; ?>">všechny články blogu</a>.</p>

<h2>Poslední komentář návštěvníka:</h2>

<?php include "pages/inc/comment_inc.php";

$count_file = fopen('pages/comments/count.txt', 'r');
$comment_count = getline($count_file);
fclose($count_file);

if ($comment_count > 0) {
  showComment($comment_count);
} else {
  echo '</p>Zatím nejsou žádné komentáře návštěvníků.</p>';
} ?>

<p>Můžete <a href="?p=comments<?php echo $langPostfix; ?>">zobrazit všechny komentáře</a> nebo <a href="?p=add-comment<?php echo $langPostfix; ?>">přidat nový</a>.</p>

<p><small>&copy; Miroslav Hajda 2021 | Verze 4.2 | Hostováno u <a class="urlextern" href="https://www.zdechov.net">zdechov.net</a> | <a class="urlextern" href="https://github.com/hajdam/hajdam-web">Zdroj stránky</a></small></p>
</div>
</body>
</html>