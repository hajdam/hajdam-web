<?php
if (!empty($prefix)) {
    $parentPrefix = $prefix.'/';
    $rootPrefix = $parentPrefix;
} else {
    $parentPrefix = '/';
    $rootPrefix = '';
} ?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" href="<?php echo $rootPrefix; ?>hajdam.ico" />
<link href="<?php echo $parentPrefix; ?>css/site.css" rel="stylesheet">
<title><?php echo ($lang == 'cs') ? 'HajdaM - Osobní webová stránka' : 'HajdaM - Personal Homepage' ?></title>
</head>

<body>
<span id="leftbar">
<span id="logo"><h1><a href="<?php echo $parentPrefix; ?>"><img src="<?php echo $parentPrefix; ?>images/hajdam-logo.png" alt="[HajdaM]" title="Icon" width="50" height="50" style="vertical-align: text-top; margin-top: -7px;"/>&nbsp;<?php echo ($lang == 'cs') ? 'HajdaM' : 'HajdaM' ?></a></h1></span>
<ul id="navmenu"><?php if ($lang != 'cs') { ?>
  <li><div>General</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?p=welcome<?php echo $langPostfix; ?>">Welcome</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=news<?php echo $langPostfix; ?>">News</a></li>
      <li><a href="<?php echo $rootPrefix; ?>about?p=me<?php echo $langPostfix; ?>">About Me</a><?php echo @$submenu_about; ?></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=blog<?php echo $langPostfix; ?>">Blog</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=gallery<?php echo $langPostfix; ?>">Gallery</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=downloads<?php echo $langPostfix; ?>">Downloads</a></li>
    </ul>
  </li>
  <li><div>Projects</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>projects?p=software<?php echo $langPostfix; ?>">Software</a><?php echo @$submenu_software; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?p=sites<?php echo $langPostfix; ?>">Sites</a><?php echo @$submenu_sites; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?p=concepts<?php echo $langPostfix; ?>">Concepts</a><?php echo @$submenu_concepts; ?></li>
    </ul>
  </li>
  <li><div>Creations</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>creations?p=texts<?php echo $langPostfix; ?>">Texts</a><?php echo @$submenu_texts; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=graphics<?php echo $langPostfix; ?>">Graphics</a><?php echo @$submenu_graphics; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=music<?php echo $langPostfix; ?>">Music</a><?php echo @$submenu_music; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=video<?php echo $langPostfix; ?>">Video</a><?php echo @$submenu_video; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=games<?php echo $langPostfix; ?>">Games</a><?php echo @$submenu_game; ?></li>
    </ul>
  </li>
  <li><div>Social</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?p=comments<?php echo $langPostfix; ?>">Visitor's comments</a></li>
<?php } else { ?>
  <li><div>Obecné</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?p=welcome<?php echo $langPostfix; ?>">Vítejte</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=news<?php echo $langPostfix; ?>">Novinky</a></li>
      <li><a href="<?php echo $rootPrefix; ?>about?p=me<?php echo $langPostfix; ?>">O mě</a><?php echo @$submenu_about; ?></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=blog<?php echo $langPostfix; ?>">Blog</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=gallery<?php echo $langPostfix; ?>">Galerie</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?p=downloads<?php echo $langPostfix; ?>">Ke stažení</a></li>
    </ul>
  </li>
  <li><div>Projekty</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>projects?p=software<?php echo $langPostfix; ?>">Software</a><?php echo @$submenu_software; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?p=sites<?php echo $langPostfix; ?>">Webové stránky</a><?php echo @$submenu_sites; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?p=concepts<?php echo $langPostfix; ?>">Koncepty</a><?php echo @$submenu_concepts; ?></li>
    </ul>
  </li>
  <li><div>Tvorba</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>creations?p=texts<?php echo $langPostfix; ?>">Texty</a><?php echo @$submenu_text; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=graphics<?php echo $langPostfix; ?>">Grafika</a><?php echo @$submenu_graphic; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=music<?php echo $langPostfix; ?>">Hudba</a><?php echo @$submenu_music; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=video<?php echo $langPostfix; ?>">Videa</a><?php echo @$submenu_video; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>creations?p=games<?php echo $langPostfix; ?>">Hry</a><?php echo @$submenu_game; ?></li>
    </ul>
  </li>
  <li><div>Sociální</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?p=comments<?php echo $langPostfix; ?>">Komentáře návštěvníků</a></li>
<?php } ?>
      <li><a class="urlextern" href="https://github.com/hajdam">GitHub</a></li>
      <li><a class="urlextern" href="https://linkedin.com/in/miroslav-hajda-44539024">LinkedIn</a></li>
      <li><a class="urlextern" href="https://youtube.com/user/hajdamcz">YouTube</a></li>
    </ul>
  </li>
</ul>
<?php
if ($lang == 'cs') {
  echo '<p style="text-align: center"><a href="?p='.($query == '' ? '' : $query.'&amp;').'lang=en"><img src="'.$parentPrefix.'images/flags/en.gif" alt="[en]"/>&nbsp;English version</a></p>';
} else {
  echo '<p style="text-align: center"><a href="?p='.($query == '' ? '' : $query.'&amp;').'lang=cs"><img src="'.$parentPrefix.'images/flags/cz.gif" alt="[cs]"/>&nbsp;Česká verze</a></p>';
}
?>
</span>
