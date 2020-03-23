<?php global $prefix;
if (!empty($prefix)) {
    $parentPrefix = $prefix.'/';
    $rootPrefix = $parentPrefix;
} else {
    $parentPrefix = '/next/';
} ?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" href="hajdam.ico" />
<link href="<?php echo $parentPrefix; ?>css/site.css" rel="stylesheet">
<title>HajdaM - Personal Homepage</title>
</head>

<body>
<div id="name"><h1><a href="<?php echo $parentPrefix; ?>"><img src="<?php echo $parentPrefix; ?>images/hajdam-logo.png" alt="[HajdaM]" title="Icon" width="50" height="50" style="vertical-align: text-top; margin-top: -7px;"/>&nbsp;HajdaM - Personal Homepage</a></h1></div>
<div id="navbar">
  <a id="FeaturesIcon" href="<?php echo $rootPrefix; ?>?features">Features</a>
  <a id="ScreenshotsIcon" href="<?php echo $rootPrefix; ?>?screenshots">Screenshots</a>
  <a id="DownloadIcon" href="<?php echo $rootPrefix; ?>?downloads">Downloads</a>
  <a id="DocumentationIcon" href="<?php echo $rootPrefix; ?>editor/?manual">Manual</a>
</div>
<div id="divider"></div>

<ul id="navmenu">
  <li><div>General</div>
    <ul class="submenu">
    <li><a href="<?php echo $rootPrefix; ?>?news<?php echo $langPrefix; ?>">News</a></li>
    <li><a href="<?php echo $rootPrefix; ?>?about<?php echo $langPrefix; ?>">About Me</a></li>
    <li><a href="<?php echo $rootPrefix; ?>?blog<?php echo $langPrefix; ?>">Blog</a></li>
    <li><a href="<?php echo $rootPrefix; ?>?gallery<?php echo $langPrefix; ?>">Gallery</a></li>
    <li><a href="<?php echo $rootPrefix; ?>?downloads<?php echo $langPrefix; ?>">Downloads</a></li>
    </ul>
  </li>
  <li><div>Projects</div>
    <ul class="submenu">
      <li><a href="<?php echo $parentPrefix; ?>bined<?php echo $langPrefix; ?>">BinEd - Hexadecimal Editor</a><?php echo $submenu_editor; ?></li>
    </ul>
  </li>
  <li><div>Social</div>
    <ul class="submenu">
      <li><a class="urlextern" href="https://sourceforge.net/projects/bined/">SourceForge</a></li>
      <li><a class="urlextern" href="https://www.openhub.net/p/bined/">OpenHub</a></li>
      <li><a href="<?php echo $rootPrefix; ?>?similar-projects">Similar Projects</a></li>
    </ul>
  </li>
</ul>
