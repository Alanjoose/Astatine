<?php

require 'kernel.php';

$templatesDir = 'templates/iridium';
$object = 'model';
$file = $templatesDir.'/'.ucwords($object).'Template.php.dist';
// print_r(file_get_contents($file));

print_r(file_put_contents('app/Models/Test.php', file_get_contents($file)));