<?php
$directory = " home/aindex/www/cubesat/teste_post";
$phpfiles = glob($directory . "*.html");

foreach($phpfiles as $phpfiles)
{
echo $phpfiles;
}
?>
