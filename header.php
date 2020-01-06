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

<div id="sidebar">
<h4>&nbsp;&nbsp;&nbsp;General</h4>
<ul>
  <li><a href="<?php echo $rootPrefix; ?>?news<?php echo $langPrefix; ?>">News</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?about<?php echo $langPrefix; ?>">About Me</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?blog<?php echo $langPrefix; ?>">Blog</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?gallery<?php echo $langPrefix; ?>">Gallery</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?downloads<?php echo $langPrefix; ?>">Downloads</a></li>
</ul>

<h4>&nbsp;&nbsp;&nbsp;Projects</h4>
<ul>
  <li><a href="<?php echo $parentPrefix; ?>editor">Editor - Java</a><?php echo $submenu_editor; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>android">Editor - Android</a><?php echo $submenu_android; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>library">Component Libraries</a><?php echo $submenu_library; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>basic-editor">Basic Editor</a><?php echo $submenu_basiceditor; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>netbeans-plugin">NetBeans Plugin</a><?php echo $submenu_netbeansplugin; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>intellij-plugin">IntelliJ Plugin</a><?php echo $submenu_intellijplugin; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>eclipse-plugin">Eclipse Plugin</a><?php echo $submenu_eclipseplugin; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>jdeveloper-extension">JDeveloper Extension</a><?php echo $submenu_jdeveloperextension; ?></li>
  <li><a href="<?php echo $parentPrefix; ?>bluej-extension">BlueJ Extension</a><?php echo $submenu_bluejextension; ?></li>
</ul>

<h4>&nbsp;&nbsp;&nbsp;Creations</h4>
<ul>
  <li><a href="<?php echo $rootPrefix; ?>?participate">Participate</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?features">Features</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?concepts">Concepts</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?source-codes">Source Codes</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?donate">Donate</a></li>
</ul>

<h4>&nbsp;&nbsp;&nbsp;Social</h4>
<ul>
  <li><a class="urlextern" href="https://sourceforge.net/projects/bined/">SourceForge</a></li>
  <li><a class="urlextern" href="https://www.openhub.net/p/bined/">OpenHub</a></li>
  <li><a href="<?php echo $rootPrefix; ?>?similar-projects">Similar Projects</a></li>
</ul>
</div>
