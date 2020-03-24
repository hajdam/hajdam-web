<?php
if (!empty($prefix)) {
    $parentPrefix = $prefix.'/';
    $rootPrefix = $parentPrefix;
} else {
    $parentPrefix = '/';
}

if ($query == 'about') {
  $submenu_about = '
  <ul><li><a href="?todo">TODO</a></li>
  <li><a href="?todo2"><strike>TODO2</strike></a></li></ul>';
} ?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" href="hajdam.ico" />
<link href="<?php echo $parentPrefix; ?>css/site.css" rel="stylesheet">
<title><?php echo ($lang == 'cs') ? 'HajdaM - Osobní webová stránka' : 'HajdaM - Personal Homepage' ?></title>
</head>

<body>
<div id="name"><h1><a href="<?php echo $parentPrefix; ?>"><img src="<?php echo $parentPrefix; ?>images/hajdam-logo.png" alt="[HajdaM]" title="Icon" width="50" height="50" style="vertical-align: text-top; margin-top: -7px;"/>&nbsp;<?php echo ($lang == 'cs') ? 'HajdaM - Osobní webová stránka' : 'HajdaM - Personal Homepage' ?></a></h1></div>
<div id="divider"></div>

<ul id="navmenu">
  <li><div>General</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?news<?php echo $langPrefix; ?>">News</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?about<?php echo $langPrefix; ?>">About Me</a><?php echo $submenu_about; ?></li>
      <li><a href="<?php echo $rootPrefix; ?>?blog<?php echo $langPrefix; ?>">Blog</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?gallery<?php echo $langPrefix; ?>">Gallery</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?downloads<?php echo $langPrefix; ?>">Downloads</a></li>
    </ul>
  </li>
  <li><div>Projects</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>projects?software<?php echo $langPrefix; ?>">Software</a><?php echo $submenu_software; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?sites<?php echo $langPrefix; ?>">Sites</a><?php echo $submenu_sites; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?media<?php echo $langPrefix; ?>">Media</a><?php echo $submenu_media; ?></li>
      <li><a href="<?php echo $parentPrefix; ?>projects?concepts<?php echo $langPrefix; ?>">Concepts</a><?php echo $submenu_concepts; ?></li>
    </ul>
  </li>
  <li><div>Social</div>
    <ul class="submenu">
      <li><a href="<?php echo $rootPrefix; ?>?comments<?php echo $langPrefix; ?>">Comments</a></li>
      <li><a class="urlextern" href="https://linkedin.com/in/miroslav-hajda-44539024">Linked-in</a></li>
    </ul>
  </li>
</ul>
