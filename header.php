<?php
if (!empty($prefix)) {
    $parentPrefix = $prefix.'/';
    $rootPrefix = $parentPrefix;
} else {
    $parentPrefix = '/';
    $rootPrefix = '';
} ?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="<?php echo $lang; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" href="<?php echo $rootPrefix; ?>hajdam.ico" />
<link href="<?php echo $parentPrefix; ?>css/site.css" rel="stylesheet">
<title><?php echo ($lang == 'cs') ? 'HajdaM - Osobní webová stránka' : 'HajdaM - Personal Homepage' ?></title>
</head>

<body>
<div id="name"><h1><a href="<?php echo $parentPrefix; ?>"><img src="<?php echo $parentPrefix; ?>images/hajdam-logo.png" alt="[HajdaM]" title="Icon" width="50" height="50" style="vertical-align: text-top; margin-top: -7px;"/>&nbsp;<?php echo ($lang == 'cs') ? 'HajdaM' : 'HajdaM' ?></a></h1></div>
<div id="divider"></div>
<ul id="navmenu"><?php if ($lang != 'cs') { ?>
  <li><div>General</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?welcome<?php echo $langPostfix; ?>">Welcome</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?news<?php echo $langPostfix; ?>">News</a></li>
      <li><a href="<?php echo $rootPrefix; ?>about?me<?php echo $langPostfix; ?>">About Me</a><?php echo @$submenu_about; ?></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?blog<?php echo $langPostfix; ?>">Blog</a></strike></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?gallery<?php echo $langPostfix; ?>">Gallery</a></strike></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?downloads<?php echo $langPostfix; ?>">Downloads</a></strike></li>
    </ul>
  </li>
  <li><div>Projects</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>projects?software<?php echo $langPostfix; ?>">Software</a><?php echo @$submenu_software; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?sites<?php echo $langPostfix; ?>">Sites</a><?php echo @$submenu_sites; ?></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>projects?concepts<?php echo $langPostfix; ?>">Concepts</a><?php echo @$submenu_concepts; ?></strike></li>
    </ul>
  </li>
  <li><div>Creations</div>
    <ul class="submenu">
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?music<?php echo $langPostfix; ?>">Music</a><?php echo @$submenu_music; ?></strike></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?media<?php echo $langPostfix; ?>">Media</a><?php echo @$submenu_media; ?></strike></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?games<?php echo $langPostfix; ?>">Games</a><?php echo @$submenu_games; ?></strike></li>
    </ul>
  </li>
  <li><div>Social</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?comments<?php echo $langPostfix; ?>">Visitor's comments</a></li>
<?php } else { ?>
  <li><div>Obecné</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?welcome<?php echo $langPostfix; ?>">Vítejte</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?news<?php echo $langPostfix; ?>">Novinky</a></li>
      <li><a href="<?php echo $rootPrefix; ?>about?me<?php echo $langPostfix; ?>">O mě</a><?php echo @$submenu_about; ?></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?blog<?php echo $langPostfix; ?>">Blog</a></strike></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?gallery<?php echo $langPostfix; ?>">Galerie</a></strike></li>
      <li><strike><a href="<?php echo $rootPrefix; ?>?downloads<?php echo $langPostfix; ?>">Ke stažení</a></strike></li>
    </ul>
  </li>
  <li><div>Projekty</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>projects?software<?php echo $langPostfix; ?>">Software</a><?php echo @$submenu_software; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?sites<?php echo $langPostfix; ?>">Webové stránky</a><?php echo @$submenu_sites; ?></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>projects?concepts<?php echo $langPostfix; ?>">Koncepty</a><?php echo @$submenu_concepts; ?></strike></li>
    </ul>
  </li>
  <li><div>Tvorba</div>
    <ul class="submenu">
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?music<?php echo $langPostfix; ?>">Hudba</a><?php echo @$submenu_music; ?></strike></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?media<?php echo $langPostfix; ?>">Media</a><?php echo @$submenu_media; ?></strike></li>
      <li><strike><a href="<?php echo $parentPrefix; ?>creations?games<?php echo $langPostfix; ?>">Hry</a><?php echo @$submenu_games; ?></strike></li>
    </ul>
  </li>
  <li><div>Sociální</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?comments<?php echo $langPostfix; ?>">Komentáře návštěvníků</a></li>
<?php } ?>
      <li><a class="urlextern" href="https://github.com/hajdam">GitHub</a></li>
      <li><a class="urlextern" href="https://linkedin.com/in/miroslav-hajda-44539024">LinkedIn</a></li>
      <li><a class="urlextern" href="https://youtube.com/user/hajdamcz">YouTube</a></li>
    </ul>
  </li>
</ul>
