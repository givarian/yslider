<?php

require_once 'resizelib/ThumbLib.inc.php';

$fileName = (isset($_GET['file'])) ? urldecode($_GET['file']) : null;

if ($fileName == null || !file_exists($fileName))
{
     // handle missing images however you want... perhaps show a default image??  Up to you...
	 //echo "you don't have permissions to do this";
}

if (!strpos($fileName, $_SERVER['HTTP_HOST'])) return;


$urlFile = str_replace($_GET['siteurl'] . '/wp-content/','../../',$fileName);

try
{
     $thumb = PhpThumbFactory::create($urlFile);
}
catch (Exception $e)
{
     // handle error here however you'd like
     return;
}

$thumb->adaptiveResize($_GET['width'], $_GET['height']);

$thumb->show();

?>
